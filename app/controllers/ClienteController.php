<?php

class ClienteController extends \BaseController {

    public function index()
    { 
        return Response::json(array(
            'success' => true,
            'table' => View::make('cliente.index')->render()
        ));
    }

    public function search()
    {
        return Autocomplete::get('clientes', array('id', 'nombre', 'apellido', 'nit'));
    }

    public function getInfo($id = null)
    {
        if(!$id) {
            $id = Input::get('id');
        }
        
        $cliente = Cliente::with('tipocliente')->find($id);

        $query = Venta::where('cliente_id','=', $id)
        ->where('saldo', '>', 0)
        ->get();

        if (!count($query) ) 
        {
            $cliente['saldo_total']   = 0;
            $cliente['saldo_vencido'] = 0;
        }

        $saldo_total = 0;
        $saldo_vencido = 0;

        foreach ($query as  $q)
        {
            $fecha_entrada = $q->created_at;
            $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
            $fecha_vencida = date('Ymd',strtotime("-30 days"));

            if ($fecha_entrada < $fecha_vencida)
            {
                $saldo_vencido = $saldo_vencido + $q->saldo;
            }
            $saldo_total = $saldo_total + $q->saldo;
        }

        $cliente['saldo_total']   = $saldo_total;
        $cliente['saldo_vencido'] = $saldo_vencido;

        return $cliente;
    }

    public function create()
    {
        if (Session::token() == Input::get('_token'))
        {
            $cliente = new Cliente;

            $data = Input::all();

            if (Input::get('nit') == "") 
                $data['nit'] = 'C/F';
            else
                $data['nit'] = $this->limpiaNit(Input::get('nit'));

            if (!$cliente->_create($data))
            {
                return $cliente->errors();
            }

            return Response::json(array(
                'success' => true,
                'info'    =>  $this->getInfo( $cliente->get_id() ),
            ));
        }

        return View::make('cliente.create');
    }

    public function info()
    {
        $cliente =  Cliente::find(Input::get('id'));

        $contactos = ClienteContacto::where('cliente_id','=',Input::get('id'))->get();

        return View::make('cliente.info',compact('cliente' , 'contactos'));
    }

    public function contacto_delete()
    {
        $contacto = ClienteContacto::find(Input::get('cliente_contacto_id'));
        $cliente_id = $contacto->cliente_id;

        ClienteContacto::destroy(Input::get('cliente_contacto_id'));

        $lista = View::make('cliente.contactos_list',compact('cliente_id'))->render();
        
        return Response::json(array(
            'success' => true, 
            'lista' => $lista
            ));

    }

    public function contacto_create()
    {
        
        $cliente_id = Input::get('cliente_id');

        $contacto = new ClienteContacto;

        $data = Input::all();
        $data['cliente_id'] = $cliente_id;

        if (!$contacto->_create($data))
        {
            return $contacto->errors();
        }

        $lista = View::make('cliente.contactos_list',compact('cliente_id'))->render();
        
        return Response::json(array(
            'success' => true, 
            'lista' => $lista
            ));

    }

    public function contacto_update()
    {
        if (Session::token() == Input::get('_token'))
        {
            $contacto = ClienteContacto::find(Input::get('id'));

            if (!$contacto->_update())
            {
                return $contacto->errors();
            }

            $cliente_id = $contacto->cliente_id;
            $lista = View::make('cliente.contactos_list',compact('cliente_id'))->render();

            return Response::json(array(
                'success' => true,
                 'lista' => $lista
                 )); 
        }

        $contacto = ClienteContacto::find(Input::get('id'));

       return View::make('cliente.contacto_edit',compact('contacto'));

    }

    public function contacto_nuevo()
    {
        return View::make('cliente.contacto_nuevo');
    }

    public function edit()
    {
        if (Input::has('_token')) {

            $cliente = Cliente::find(Input::get('id'));
              $data = Input::all();

            if (Input::get('nit') == "") 
                $data['nit'] = 'C/F';
            else
                $data['nit'] = $this->limpiaNit(Input::get('nit'));

            if (!$cliente->_update($data))
            {
                return $cliente->errors();
            }

            return Response::json(array(
                'success' => true,
                'info'    => $this->getInfo(),
            ));
        }

        $cliente = Cliente::find(Input::get('id'));

        $contactos = ClienteContacto::where('cliente_id','=',Input::get('id'))->get();

        return View::make('cliente.edit',compact('cliente' , 'contactos'));
    }

    public function contacto_info()
    {
        $contacto = ClienteContacto::find(Input::get('id'));

        return View::make('cliente.contacto_info',compact('contacto'));
    }

    public function salesByCustomer()
    {
        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.cliente.salesByCustomer')->render()
        ));
    }

    function DT_salesByCustomer() {

        $table = 'ventas';

        $columns = array(
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "ventas.created_at as fecha", 
            "ventas.id as idventa",
            "total",
            "saldo"
            );

        $Search_columns = array("users.nombre","users.apellido","ventas.id");

        $Join = "JOIN users ON (users.id = ventas.user_id)";

        $where = "ventas.cliente_id = ". Input::get('cliente_id');

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );   
    }

    public function getInfoCliente()
    {
        $query = Venta::where('cliente_id','=', Input::get('cliente_id'))
        ->where('saldo', '>', 0)
        ->get();

        $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        if (!count($query) ) 
        {
            $cliente = Cliente::find(Input::get('cliente_id'));

            $cliente = $cliente->nombre . "&nbsp;" . $cliente->apellido;

            $info = $cliente . $tab . " Saldo total &nbsp; 0.00" . $tab ." Saldo vencido &nbsp; 0.00";

            return Response::json(array(
                'success'       => true,
                'info'          => $info,
                'saldo_total'   => 0,
                'saldo_vencido' => 0
            ));
        }

        $saldo_total = 0;
        $saldo_vencido = 0;

        foreach ($query as  $q)
        {
            $fecha_entrada = $q->created_at;
            $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
            $fecha_vencida = date('Ymd',strtotime("-30 days"));

            if ($fecha_entrada < $fecha_vencida)
            {
                $saldo_vencido = $saldo_vencido + $q->saldo;
            }
            $saldo_total = $saldo_total + $q->saldo;
        }

        $cliente = $query[0]->cliente->nombre . "&nbsp;" . $query[0]->cliente->apellido;

        $info = $cliente . $tab . " Saldo total &nbsp;". f_num::get($saldo_total) . $tab ." Saldo vencido &nbsp;" .f_num::get($saldo_vencido);

        return Response::json(array(
            'success'       => true, 
            'info'          => $info,
            'saldo_total'   => $saldo_total,
            'saldo_vencido' => $saldo_vencido
        ));
    }


    public function creditSalesByCustomer()
    {
        $ventas = DB::table('ventas')
        ->select(DB::raw("ventas.id,
            ventas.total,
            ventas.created_at as fecha, 
            CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
            CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente,
            saldo"))
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('saldo', '>', 0)
        ->where('cliente_id', Input::get('cliente_id'))
        ->orderBy('fecha', 'ASC')
        ->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.cliente.CreditSalesByCustomer', compact('ventas'))->render()
        ));
    }

    public function clientes()
    {
        $table = 'clientes';

        $columns = array(
            "CONCAT_WS(' ',nombre,apellido) as cliente",
            "direccion","telefono","nit");

        $Searchable = array("nombre","direccion","telefono");

        echo TableSearch::get($table, $columns, $Searchable);
    }

    function limpiaNit($nit) 
    {
        return  preg_replace('/[^A-Za-z0-9]/', '', strtoupper($nit));
    }

    public function getHistorialAbonos()
    {
        $abonosVentas = DB::table('abonos_ventas')
            ->select(DB::raw("abonos_ventas.id,
                abonos_ventas.created_at as fecha, 
                CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
                metodo_pago.descripcion as metodoPago,
                abonos_ventas.monto,
                observaciones"))
            ->join('users', 'abonos_ventas.user_id', '=', 'users.id')
            ->join('metodo_pago', 'abonos_ventas.metodo_pago_id', '=', 'metodo_pago.id')
            ->where('cliente_id', Input::get('cliente_id'))
            ->orderBy('fecha', 'ASC')
            ->get();

        return Response::json(array(
            'success' => true,
            'data'    => $abonosVentas,
            'table'   => View::make('ventas.historialAbonos')->render()
        ));
    }

    public function getHistorialPagos()
    {
        $pagosVentas = DB::table('pagos_ventas')
            ->select(DB::raw("monto,
                CONCAT_WS(' ',users.nombre,users.apellido) as usuario,
                CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda,
                pagos_ventas.created_at as fecha,
                ventas.id as factura,
                metodo_pago.descripcion as metodoPago"))
            ->join('metodo_pago', 'pagos_ventas.metodo_pago_id', '=', 'metodo_pago.id')
            ->join('ventas', 'pagos_ventas.venta_id', '=', 'ventas.id')
            ->join('users', 'ventas.user_id', '=', 'users.id')
            ->join('tiendas', 'ventas.tienda_id', '=', 'tiendas.id')
            ->where('cliente_id', Input::get('cliente_id'))
            ->orderBy('fecha', 'ASC')
            ->get();

        return Response::json(array(
            'success' => true,
            'data'    => $pagosVentas,
            'table'   => View::make('ventas.historialPagos')->render()
        ));
    }

}
