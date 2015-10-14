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

    public function _create()
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
            $data = $this->TotalCreditoCompras($proveedor_id);

            return Response::json(array(
                'success' => true,
                'proveedor_id' => $proveedor_id,
                'nombre' => $proveedor->nombre,
                'direccion' => $proveedor->direccion,
                'saldo_total' => f_num::get($data['saldo_total']),
                'saldo_vencido' => f_num::get($data['saldo_vencido'])
            ));
        }

        return View::make('proveedor.compras.create');
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

    public function proveedores()
    {
        $table = 'proveedores';
        $columns = array("nombre","direccion","telefono","nit");
        $Searchable = array("nombre","direccion","telefono");

        echo TableSearch::get($table, $columns, $Searchable);
    }

    public function contacto_delete()
    {
        $contacto = ProveedorContacto::find(Input::get('proveedor_contacto_id'));
        $proveedor_id = $contacto->proveedor_id;

        ProveedorContacto::destroy(Input::get('proveedor_contacto_id'));

        $lista = View::make('proveedor.contactos_list',compact('proveedor_id'))->render();

        return Response::json(array(
            'success' => true,
            'lista' => $lista
        ));
    }

    public function contacto_create()
    {
        $proveedor_id = Input::get('proveedor_id');
        $contacto = new ProveedorContacto;
        $data = Input::all();
        $data['proveedor_id'] = $proveedor_id;

        if (!$contacto->_create($data))
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

    public function _edit()
    {
         if (Input::has('_token'))
        {
            $proveedor = Proveedor::find(Input::get('id'));

            if (!$proveedor->_update())
            {
                return $proveedor->errors();
            }

            $proveedor = Proveedor::find(Input::get('id'));
            $data = $this->TotalCreditoCompras(Input::get('id'));

            return Response::json(array(
                'success' => true,
                'proveedor_id' => Input::get('id'),
                'nombre' => $proveedor->nombre,
                'direccion' => $proveedor->direccion,
                'saldo_total' => f_num::get($data['saldo_total']),
                'saldo_vencido' => f_num::get($data['saldo_vencido'])
            ));
        }

        $proveedor = Proveedor::find(Input::get('id'));

        return View::make('proveedor.compras.edit',compact('proveedor'));
    }

    public function contacto_info()
    {
        $contacto = ProveedorContacto::find(Input::get('id'));
        return View::make('proveedor.contacto_info',compact('contacto'));
    }

    public function TotalCredito()
    {
        $saldo_total = Compra::where('proveedor_id','=', Input::get('proveedor_id'))
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->first();

        return array(
            'saldo_total' => f_num::get($saldo_total->total) ,
            'saldo_vencido' => f_num::get($saldo_vencido->total)
        );
    }

    public function _TotalCredito()
    {
        $saldo_total = Compra::where('proveedor_id','=', Input::get('proveedor_id'))
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('proveedor_id','=',Input::get('proveedor_id'))->first();

        return array(
            'saldo_total' => $saldo_total->total,
            'saldo_vencido' => $saldo_vencido->total
        );
    }

    public function TotalCreditoCompras($proveedor_id)
    {
        $saldo_total = Compra::where('proveedor_id','=', $proveedor_id)
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('saldo','>', 0 )->first(array(DB::Raw('sum(saldo) as total')));

        $saldo_vencido = DB::table('compras')
        ->select(DB::raw('sum(saldo) as total'))
        ->where('saldo','>',0)
        ->where(DB::raw('DATEDIFF(current_date,fecha_documento)'),'>=',30)
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('proveedor_id','=',$proveedor_id)->first();

        return array(
            'saldo_total' => $saldo_total->total,
            'saldo_vencido' => $saldo_vencido->total
        );
    }

    public function ImprimirAbono()
    {
        $detalle = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto',DB::raw('detalle_abonos_compra.created_at as fecha'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=', Input::get('id'))->get();

        $abono = AbonosCompra::with('proveedor','user','metodoPago')->find(Input::get('id'));

        $saldo = Compra::where('proveedor_id', '=' , $abono->proveedor_id)->first(array(DB::raw('sum(saldo) as total')));

        $pdf = PDF::loadView('proveedor.ImprimirAbono',  array(
            'detalle' => $detalle, 'abono' => $abono, 'saldo' => $saldo))
        ->save("pdf/".Input::get('id').Auth::user()->id.'ap.pdf');

        return Response::json(array(
            'success' => true,
            'pdf'   => Input::get('id').Auth::user()->id.'ap'
        ));
    }

    public function ImprimirAbonoPdf()
    {
        $detalle = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto',DB::raw('detalle_abonos_compra.created_at as fecha'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=', Input::get('id'))->get();

        $abono = AbonosCompra::with('proveedor','user','metodoPago')->find(Input::get('id'));
        $saldo = Compra::where('proveedor_id', '=' , $abono->proveedor_id)->first(array(DB::raw('sum(saldo) as total')));
        $pdf = PDF::loadView('proveedor.ImprimirAbono', array('detalle' => $detalle, 'abono' => $abono, 'saldo' => $saldo));

        return $pdf->stream();
    }

    public function getInfoProveedor()
    {
        $data =  $this->_TotalCredito();
        $saldo_vencido = f_num::get($data['saldo_vencido']);
        $saldo_total = f_num::get($data['saldo_total']);
        $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        $proveedor = Proveedor::find(Input::get('proveedor_id'));

        $info = "Proveedor: &nbsp;{$proveedor->nombre}{$tab}Saldo total &nbsp;{$saldo_total}{$tab}Saldo vencido &nbsp;{$saldo_vencido}";

        return Response::json(array(
            'success'       => true,
            'info'          => $info,
            'saldo_total'   => $data['saldo_total'],
            'saldo_vencido' => $data['saldo_vencido']
        ));
    }
}
