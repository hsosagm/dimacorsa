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
        return Autocomplete::get('clientes', array('id', 'nombre', 'direccion', 'nit'));
    }

    public static function getInfo($id = null)
    {
        if(!$id)
            $id = Input::get('id');

        $cliente = Cliente::with('tipocliente')->find($id);

        $query = Venta::whereClienteId($id)
        ->whereTiendaId(Auth::user()->tienda_id)
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
                $saldo_vencido = $saldo_vencido + $q->saldo;

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
                return $cliente->errors();

            return Response::json(array(
                'success' => true,
                'info'    =>  $this->getInfo( $cliente->get_id() ),
            ));
        }

        return View::make('cliente.create');
    }

    public function crearCliente()
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
                return $cliente->errors();

            return 'success';
        }

        return Response::json(array(
            'success' => true,
            'view' =>  View::make('cliente.create')->render()
        ));
    }

    public function actualizarCliente()
    {
        $cliente = Cliente::find(Input::get('cliente_id'));

        $contactos = ClienteContacto::where('cliente_id','=',Input::get('cliente_id'))->get();

        return Response::json(array(
            'success' => true,
            'view' =>  View::make('cliente.actualizarCliente',compact('cliente' , 'contactos'))->render()
        ));
    }

    public function eliminarCliente()
    {
        $delete = Cliente::destroy(Input::get('cliente_id'));

        if ($delete)
            return Response::json(array( 'success' => true ));

        return 'Error al eliminar el cliente...';
    }

    public function _edit()
    {
        $cliente = Cliente::find(Input::get('cliente_id'));

        return Response::json(array(
            'success' => true,
            'view' =>  View::make('cliente._edit', compact('cliente'))->render()
        ));
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
            return $contacto->errors();

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
                return $contacto->errors();

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
                return $cliente->errors();

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

    function DT_salesByCustomer()
    {
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

        $where  = "ventas.cliente_id = ". Input::get('cliente_id');
        $where .= " AND ventas.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

    public function devolutionsByCustomer()
    {
        return Response::json(array(
            'success' => true,
            'table' => View::make('ventas.cliente.devolutionsByCustomer')->render()
        ));
    }

    function DT_devolutionsByCustomer()
    {
        $table = 'devoluciones';

        $columns = array(
            "CONCAT_WS(' ', users.nombre, users.apellido) as usuario",
            "devoluciones.created_at as fecha",
            "clientes.nombre as cliente",
            "total"
        );

        $Search_columns = array("users.nombre", "users.apellido", "clientes.nombre");
        $Join = "JOIN users ON (users.id = devoluciones.user_id) JOIN clientes ON (clientes.id = devoluciones.cliente_id)";
        $where  = "devoluciones.cliente_id = ".Input::get('cliente_id');
        $where .= " AND devoluciones.tienda_id = ".Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

    public function getInfoCliente()
    {
        $query = Venta::whereClienteId(Input::get('cliente_id'))
        ->whereTiendaId(Auth::user()->tienda_id)
        ->where('saldo', '>', 0)
        ->get();

        $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

        $cliente = Cliente::find(Input::get('cliente_id'));

        if (!count($query) )
        {
            $cliente = $cliente->nombre;

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
                $saldo_vencido = $saldo_vencido + $q->saldo;

            $saldo_total = $saldo_total + $q->saldo;
        }

        $cliente = $query[0]->cliente->nombre;

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
            clientes.nombre as cliente,
            saldo"))
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('saldo', '>', 0)
        ->where('ventas.tienda_id', '=', Auth::user()->tienda_id)
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
            "clientes.nombre as cliente",
            "direccion","telefono","nit", "email", "updated_at");

        $Searchable = array("nombre","direccion","telefono");

        echo TableSearch::get($table, $columns, $Searchable);
    }

    public function limpiaNit($nit)
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
            ->where('abonos_ventas.tienda_id', Auth::user()->tienda_id)
            ->orderBy('fecha', 'DESC')
            ->get();

        $comprobante = DB::table('printer')->select('impresora')
        ->where('tienda_id',Auth::user()->tienda_id)->where('nombre','comprobante')->first();

        return Response::json(array(
            'success' => true,
            'data'    => $abonosVentas,
            'table'   => View::make('ventas.historialAbonos', compact('comprobante'))->render()
        ));
    }

    public function estadoDeCuenta()
    {
        $ventas = Venta::whereClienteId(Input::get('cliente_id'))->whereTiendaId(Auth::user()->tienda_id)
        ->with('user')->where("saldo", ">", "0")->get();

        $cliente = Cliente::find(Input::get('cliente_id'));

        if (Input::has("pdf"))
        {
            $pdf = PDF::loadView('cliente.export.estadoDeCuenta', array('ventas' => $ventas, 'cliente' => $cliente))
            ->setPaper('letter')->setOrientation('landscape')->setPaper('letter');

            return $pdf->stream('Kardex.pdf');
        }

        Excel::create('ESTADO_DE_CUENTA_CLIENTE', function($excel) use($ventas, $cliente)
        {
            $excel->setTitle('ESTADO DE CUENTA CLIENTE');
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($ventas, $cliente)
            {
                $hoja->setOrientation('landscape');
                $hoja->loadView('cliente.export.estadoDeCuenta', array('ventas' => $ventas, 'cliente' => $cliente));
            });

        })->export("xls");
    }

    public function enviarEstadoDeCuenta()
    {
        $cliente_id = Input::get('cliente_id');

        $$ventas = Venta::whereClienteId(Input::get('cliente_id'))->whereTiendaId(Auth::user()->tienda_id)
        ->with('user')->where("saldo", ">", "0")->get();

        $cliente = Cliente::find($cliente_id);
        $emails [] = "leonel.madrid@hotmail.com";
        $_ENV["MAIL_NAME"] = "ESTADO_DE_CUENTA";
        Mail::queue('emails.mensaje', array('asunto' => 'ESTADO DE CUENTA A LA FECHA '.Carbon::now()), function($message)
        use($emails, $ventas, $cliente, $cliente_id)
        {
            $pdf = PDF::loadView('cliente.export.estadoDeCuenta', array('ventas' => $ventas, 'cliente' => $cliente))
            ->setPaper('letter')->setOrientation('landscape')->setPaper('letter');

            $excel = Excel::create("ESTADO_DE_CUENTA_CLIENTE_{$cliente_id}", function($excel) use($ventas, $cliente)
            {
                $excel->setTitle('ESTADO DE CUENTA CLIENTE');
                $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
                ->setCompany('Click Chiquimula');
                $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
                $excel->setSubject('Click');

                $excel->sheet('datos', function($hoja) use($ventas, $cliente)
                {
                    $hoja->setOrientation('landscape');
                    $hoja->loadView('cliente.export.estadoDeCuenta', array('ventas' => $ventas, 'cliente' => $cliente));
                })->store('xls');

            });

            $message->to($emails)->subject('ESTADO DE CUENTA A LA FECHA '.Carbon::now());
            $message->attachData($pdf->output(), "ESTADO_DE_CUENTA_CLIENTE.pdf");
            $message->attach(storage_path()."/exports/ESTADO_DE_CUENTA_CLIENTE_{$cliente_id}.xls");

        });


        $file = storage_path()."/exports/ESTADO_DE_CUENTA_CLIENTE_{$cliente_id}.xls";
        if (is_file($file)) {
            chmod($file,0777);
            if(!unlink($file)){ }
        }

        return Response::json([
            "success" => true
        ]);
    }

}
