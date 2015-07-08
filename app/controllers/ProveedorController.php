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

        $total = f_num::get($saldo_total->total);
        $vencido = f_num::get($saldo_vencido->total);
        $tab = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        return "Saldo Total: {$total} {$tab} Saldo Vencido: {$vencido}";
    }
   
    public function AbonosDelDia()
    {
         return View::make('proveedor.AbonosDelDia');
    }

    public function AbonosDelDia_dt()
    {
        $table = 'abonos_compras';

        $columns = array(
            "CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
            "proveedores.nombre as proveedor_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')",
            "metodo_pago.descripcion as metodo_descripcion",
            'abonos_compras.monto as total','observaciones');

        $Searchable = array("users.nombre","users.apellido",);

        $Join = "
        JOIN users ON (users.id = abonos_compras.user_id)
        JOIN tiendas ON (tiendas.id = abonos_compras.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = abonos_compras.metodo_pago_id)
        JOIN proveedores ON (proveedores.id = abonos_compras.proveedor_id)";

        $where = " DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";
        $where .= ' AND abonos_compras.tienda_id = '.Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function AbonosPorFecha()
    {
         return View::make('proveedor.AbonosPorFecha');
    }

    public function AbonosPorFecha_dt()
    {
        $fecha    = Input::get('fecha');
        $consulta = Input::get('consulta');

        $where = null;

        if ($consulta == 'dia') 
            $where = "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d') = DATE_FORMAT('{$fecha}', '%Y-%m-%d')";

        if ($consulta == 'semana') 
            $where = " WEEK(abonos_compras.created_at) = WEEK('{$fecha}')  AND YEAR(abonos_compras.created_at) = YEAR('{$fecha}')  ";

        if ($consulta == 'mes') 
            $where = "DATE_FORMAT(abonos_compras.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";

        if ($where == null)
            $where = "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date+1, '%Y-%m-%d')";

        $table = 'abonos_compras';

        $columns = array(
            "CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
            "proveedores.nombre as proveedor_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')",
            "metodo_pago.descripcion as metodo_descripcion",
            'abonos_compras.monto as total','observaciones');

        $Searchable = array("users.nombre","users.apellido",);

        $where .= ' AND abonos_compras.tienda_id = '.Auth::user()->tienda_id;

        $Join = "
        JOIN users ON (users.id = abonos_compras.user_id)
        JOIN tiendas ON (tiendas.id = abonos_compras.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = abonos_compras.metodo_pago_id)
        JOIN proveedores ON (proveedores.id = abonos_compras.proveedor_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function ImprimirAbono_dt($code,$id)
    {
        $detalle = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto',DB::raw('detalle_abonos_compra.created_at as fecha'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=', $id)->get();

        $abono = AbonosCompra::with('proveedor','user','metodoPago')->find($id);

        $saldo = Compra::where('proveedor_id', '=' , $abono->proveedor_id)->first(array(DB::raw('sum(saldo) as total')));

        return View::make('proveedor.ImprimirAbono',compact('abono', 'detalle' , 'saldo'))->render();
    }

     public function ImprimirAbono($id)
    {
        $abono_id = Crypt::decrypt($id);

        $detalle = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto',DB::raw('detalle_abonos_compra.created_at as fecha'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=', $abono_id)->get();

        $abono = AbonosCompra::with('proveedor','user','metodoPago')->find($abono_id);

        $saldo = Compra::where('proveedor_id', '=' , $abono->proveedor_id)->first(array(DB::raw('sum(saldo) as total')));

        return View::make('proveedor.ImprimirAbono',compact('abono', 'detalle' , 'saldo'))->render();
    }
}
