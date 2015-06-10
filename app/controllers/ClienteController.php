<?php

class ClienteController extends \BaseController {

    public function search()
    {
        return Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));
    }

    public function index()
    {
        return View::make('cliente.index');
    }

     public function create()
    {
        if (Session::token() == Input::get('_token'))
        {
            $cliente = new Cliente;

            if (!$cliente->_create())
            {
                return $cliente->errors();
            }

            $cliente_id = $cliente->get_id();

            $cliente = Cliente::find($cliente_id);

            $contactos = ClienteContacto::where('cliente_id','=',$cliente_id)->get();

            return Response::json(array(
                'success' => true, 
                'form' => View::make('cliente.edit',compact('cliente' , 'contactos'))->render()
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

    public function contacto_create()
    {
        
        $cliente_id = Input::get('cliente_id');
        $contacto = new ClienteContacto;

        if (!$contacto->_create())
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
         if (Session::token() == Input::get('_token'))
        {
            $cliente = Cliente::find(Input::get('id'));

            if (!$cliente->_update())
            {
                return $cliente->errors();
            }

            return 'success'; 
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
            "numero_documento",
            "total",
            "saldo"
            );

        $Search_columns = array("users.nombre","users.apellido","numero_documento");

        $Join = "JOIN users ON (users.id = ventas.user_id)";

        $where = "ventas.cliente_id = ". Input::get('cliente_id');

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );   
    }

    public function info_cliente()
    {
        $query = Venta::where('cliente_id','=', Input::get('cliente_id'))
        ->where('saldo', '>', 0)
        ->get();

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

        $saldo_total   = f_num::get($saldo_total);
        $saldo_vencido = f_num::get($saldo_vencido);

        $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        $info = $cliente . $tab . " Saldo total &nbsp;". $saldo_total . $tab ." Saldo vencido &nbsp;" .$saldo_vencido;

        return Response::json(array(
            'success'       => true,
            'info' => $info
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
            numero_documento,
            saldo"))
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('saldo', '>', 0)
        ->where('cliente_id', Input::get('cliente_id'))
        ->orderBy('fecha', 'ASC')
        ->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.creditSales', compact('ventas'))->render()
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

}
