<?php
 
class ProveedorController extends BaseController {

    public function search()
    {
        return Autocomplete::get('proveedores', array('id', 'nombre','direccion','direccion'),'direccion');
    }
 
    public function create()
    {
        if (Input::has('_token'))
        {
            $proveedor = new Proveedor;

            if (!$proveedor->_create())
            { 
                return $proveedor->errors();
            }

            $proveedor_id = $proveedor->get_id();

            $proveedor = Proveedor::find($proveedor_id);

            $contactos = ProveedorContacto::where('proveedor_id','=',$proveedor_id)->get();

            return Response::json(array(
                'success' => true, 
                'form' => View::make('proveedor.edit',compact('proveedor' , 'contactos'))->render()
                ));
        }

        return View::make('proveedor.create');
    }

    public function help()
    {
    	$proveedor =  Proveedor::find(Input::get('id'));

        $contactos = ProveedorContacto::where('proveedor_id','=',Input::get('id'))->get();

        return View::make('proveedor.help',compact('proveedor' , 'contactos'));
    }
    
    public function index()
    {
        return View::make('proveedor.index');
    }

    public function contacto_create()
    {
        
        $proveedor_id = Input::get('proveedor_id');
        $contacto = new ProveedorContacto;

        if (!$contacto->_create())
        {
            return $contacto->errors();
        }

        $lista = View::make('proveedor.contactos_list',compact('proveedor_id'))->render();
        
        return Response::json(array(
            'success' => true, 
            'lista' => $lista
            ));

    }

    public function contacto_update()
    {
        if (Input::has('_token'))
        {
            $contacto = ProveedorContacto::find(Input::get('id'));

            if (!$contacto->_update())
            {
                return $contacto->errors();
            }

            $proveedor_id = $contacto->proveedor_id;
            $lista = View::make('proveedor.contactos_list',compact('proveedor_id'))->render();

            return Response::json(array(
                'success' => true,
                 'lista' => $lista
                 )); 
        }

        $contacto = ProveedorContacto::find(Input::get('id'));

       return View::make('proveedor.contactos_edit',compact('contacto'));

    }

    public function contacto_nuevo()
    {
        return View::make('proveedor.contactos_nuevo');
    }

    public function edit()
    {
         if (Input::has('_token'))
        {
            $proveedor = Proveedor::find(Input::get('id'));

            if (!$proveedor->_update())
            {
                return $proveedor->errors();
            }

            return 'success'; 
        }

        $proveedor = Proveedor::find(Input::get('id'));

        $contactos = ProveedorContacto::where('proveedor_id','=',Input::get('id'))->get();

        return View::make('proveedor.edit',compact('proveedor' , 'contactos'));

    }

    public function contacto_info()
    {
        $contacto = ProveedorContacto::find(Input::get('id'));

        return View::make('proveedor.contacto_info',compact('contacto'));
    }

    public function TotalCredito()
    {
        $total = Compra::select(DB::Raw('sum(saldo) as total'))
        ->where('proveedor_id','=', Input::get('proveedor_id'))
        ->where('saldo','>', 0 )->first();

        return $total->total;
    }

    public function AbonarCompra()
    {
        $compra = Compra::find(Input::get('compra_id'));
        $abono = AbonosCompra::find(Input::get('abonos_compra_id'));

        if (Input::has('_token'))
        {
            if ($this->BuscarMetodoDePago() != null ) 
                return 'no puede ingresar dos Abonos con el mismo metodo..!';

            if($compra->saldo < Input::get("monto") || Input::get("monto") == 0)
                return 'El moto ingresado no puede ser mayor al monto Restante..!';

            $detalle_abono = new DetalleAbonosCompra;

            if (!$detalle_abono->_create()) 
            {
                return $detalle_abono->errors();
            }
           
            $abono->total = $abono->total + Input::get('monto');
            $total_abonos = $abono->total;
            $abono->save();

            $compra->saldo = $compra->saldo - Input::get('monto');
            $total_compra = $compra->saldo;
            $compra->save();

            $abono_id = Input::get('abonos_compra_id');
            $det_abonos = $this->BuscaDetalleAbonosCompra($abono_id);

            return Response::json(array(
                'success' => true,
                 'detalle' =>  View::make('compras.abonar',compact('abono_id','total_compra','total_abonos','det_abonos'))->render()
            )); 

        }

        $abono_id = $this->CrearAbonoCompra();
        $total_compra = $compra->saldo;

        return Response::json(array(
                'success' => true,
                 'detalle' =>  View::make('compras.abonar',compact('abono_id','total_compra'))->render()
        )); 
        
    }

    public function EliminarDetalleAbono()
    {
        $detalle = DetalleAbonosCompra::find(Input::get('id'));
        $abono   = AbonosCompra::find($detalle->abonos_compra_id);
        $compra  = Compra::find(Input::get('compra_id'));

        $total_compra = $compra->saldo + $detalle->monto;
        $compra->saldo = $total_compra;
        $compra->save();
        
        $total_abonos = $abono->total - $detalle->monto;
        $abono->total = $total_abonos;
        $abono->save() ;

        $detalle->delete();
        $abono_id = $abono->id;
        $det_abonos = $this->BuscaDetalleAbonosCompra($abono_id);

         return Response::json(array(
            'success' => true,
            'detalle' =>  View::make('compras.abonar',compact('abono_id','total_compra','total_abonos','det_abonos'))->render()
        )); 
    }

    public function EliminarAbonoCompra()
    {   

        $detalle = DetalleAbonosCompra::where('abonos_compra_id','=',Input::get('id'))->get();

        foreach ($detalle as $key => $val) 
        {
            $compra = Compra::find($val->compra_id);
            $compra->saldo = $compra->saldo + $val->monto;
            $compra->save();
        }

        AbonosCompra::destroy(Input::get('id'));

        return 'success';
    }

    public function CrearAbonoCompra()
    {
        $abono = new AbonosCompra;
        $abono->user_id = Auth::user()->id;
        $abono->proveedor_id = Input::get('proveedor_id');
        $abono->save();

        return $abono->id;
    }

    public function ShowModalPaySupplier()
    {
        $saldo_vencido = $this->OverdueBalance();
        $saldo_total   = $this->FullBalance();

        return View::make('proveedor.ingreso_abono',compact('saldo_total','saldo_vencido'));
    }

    //funcion para pagar el saldo vencido
    public function OverdueBalancePay()
    {   
        $total_vencido = number_format($this->OverdueBalance(), 2, '.', '');
        $monto = number_format(Input::get('monto'), 2, '.', '');

        if ($total_vencido != $monto || $monto == 0)
        {
            return 'el monto enviado es incorrecto intente de nuevo...!';
        }

        $compras = DB::table('compras')
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->get();
        
        $abono_id = $this->CreateAbonosCompra();

        foreach ($compras as $key => $dt) 
        {
            $this->CreateDetalleAbonosCompra($dt->id,$abono_id, $dt->saldo);
        }

        DB::table('compras')
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('proveedor_id','=',Input::get('proveedor_id'))
        ->update(array('saldo'=>0));

        $detalle = $this->BalanceDetails($abono_id);

        return Response::json(array(
            'success' => true ,
            'detalle' => View::make('proveedor.ingreso_abono_body',compact("detalle",'abono_id'))->render()
            ));
    }

    //funcion para crear el abono
    public function CreateAbonosCompra()
    {
        $abono = new AbonosCompra;
        $abono->proveedor_id = Input::get('proveedor_id');
        $abono->user_id = Auth::user()->id;
        $abono->observaciones = Input::get('observaciones');
        $abono->total = Input::get('monto');
        $abono->save();
        
        return $abono->id;   
    }

    //funcion para crear el detalle del abono
    public function CreateDetalleAbonosCompra($compra_id,$abono_id,$monto)
    {
        $detalle = new DetalleAbonosCompra;
        $detalle->compra_id = $compra_id;
        $detalle->abonos_compra_id = $abono_id;
        $detalle->monto = $monto;
        $detalle->metodo_pago_id = Input::get('metodo_pago_id');
        $detalle->save();
    }

    //funcion para pagar todo el saldo
    public function FullBalancePay()
    {
        $total_saldo = number_format($this->FullBalance(), 2, '.', '');
        $monto = number_format(Input::get('monto'), 2, '.', '');

        if ($total_saldo != $monto || $monto == 0)
        {
            return 'el monto enviado es incorrecto intente de nuevo...!';
        }

        $abono_id = $this->CreateAbonosCompra();
        
         $compras = DB::table('compras')
        ->where('saldo','>',0)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->get();

        foreach ($compras as $key => $dt) 
        {
            $this->CreateDetalleAbonosCompra($dt->id,$abono_id, $dt->saldo);
        }

        DB::table('compras')
        ->where('saldo','>',0)
        ->where('proveedor_id','=',Input::get('proveedor_id'))
        ->update(array('saldo'=>0));

        $detalle = $this->BalanceDetails($abono_id);

        return Response::json(array(
            'success' => true ,
            'detalle' => View::make('proveedor.ingreso_abono_body',compact("detalle",'abono_id'))->render()
            ));

    }

    function PartialBalancePay()
    {
         $total_saldo = number_format($this->FullBalance(), 2, '.', '');
         $monto = number_format(Input::get('monto'), 2, '.', '');
         if ($total_saldo < $monto || $monto == 0)
        {
            return 'el monto enviado no puede ser mayor ala deuda...!';
        }

          $abono_id = $this->CreateAbonosCompra();
        
         $compras = DB::table('compras')
        ->where('saldo','>',0)
        ->where('proveedor_id','=',Input::get('proveedor_id'))
        ->orderBy('fecha_documento')->get();

         foreach ($compras as $key => $dt) 
        {
            if($dt->saldo <= $monto && $monto != 0 )
            {
                $update = Compra::find($dt->id);
                $update->saldo = 0.00 ;
                $update->save();
                $monto = $monto - $dt->saldo;

                $this->CreateDetalleAbonosCompra($dt->id,$abono_id, $dt->saldo);
            }

            else if($dt->saldo > $monto && $monto != 0)
            {   
                $update = Compra::find($dt->id);
                $update->saldo = $dt->saldo - $monto;
                $update->save();
                
                $this->CreateDetalleAbonosCompra($dt->id,$abono_id, $monto);
            }
        }

        $detalle = $this->BalanceDetails($abono_id);

        return Response::json(array(
            'success' => true ,
            'detalle' => View::make('proveedor.ingreso_abono_body',compact("detalle",'abono_id'))->render()
            ));
    }

    //funcion para eliminar el abono 
    public function DeleteBalancePay()
    {
        $detalle = DetalleAbonosCompra::where('abonos_compra_id','=',Input::get('id'))->get();

        foreach ($detalle as $key => $dt) 
        {
            $this->ReturnBalancePurchase($dt->compra_id , $dt->monto);
        }

        AbonosCompra::destroy(Input::get('id'));

        return 'success';
    }

    //funcion para retornar el saldo ala compra
    public function ReturnBalancePurchase($compra_id , $saldo)
    {
        $compra = Compra::find($compra_id);

        $compra->saldo = $saldo;

        $compra->save();
    }

    //funcion para  obtener el total del del saldo vencido
    public function OverdueBalance()
    {
        $query = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->first();

        return $query->total;
    }

    //funcion para obtener el saldo total
    public function FullBalance()
    {
        $query = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->first();

        return $query->total;
    }

    //funcion para obtener el detalle de los pagos
    public function BalanceDetails($id_pago)
    {
        $query = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto','saldo',DB::raw('(saldo+monto) as saldo_anterior'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=',$id_pago)->get();

        return $query;
    }

    //funcion para verificar si ya se ingreso un abono con ese metodo
    public function BuscarMetodoDePago()
    {
        $query = DetalleAbonosCompra::where('abonos_compra_id','=', Input::get('abonos_compra_id'))
        ->where('metodo_pago_id','=', Input::get('metodo_pago_id'))
        ->first();

        return $query;
    }

    public  function BuscaDetalleAbonosCompra($abono_id)
    {
        $pagos = DetalleAbonosCompra::where('abonos_compra_id','=',$abono_id)->get();
        return $pagos;
    }
}

