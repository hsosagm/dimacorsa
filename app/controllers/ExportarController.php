<?php

class ExportarController extends \BaseController {

    public function exportarInventarioActual($tipo)
    {
        $tienda_id = Auth::user()->tienda_id;

        $productos = DB::table('productos')
            ->select(DB::raw("
                productos.codigo as codigo,
                CONCAT_WS(' ', descripcion, marcas.nombre) as descripcion,
                ROUND(p_costo,3) as p_costo,
                p_publico,
                existencias.existencia as existencia,
                productos.existencia as existencia_total"))
            ->join('marcas', 'marca_id', '=', 'marcas.id')
            ->join('existencias', 'productos.id', '=', 'existencias.producto_id')
            ->where('tienda_id', '=', $tienda_id)
            ->where('productos.existencia', '>', 0)
            ->get();

        $data['productos'] = $productos;
        $data['orientacion'] = "portrait";
        $data['tipo'] = $tipo;
        $data['titulo'] = "inventarioActual-".Carbon::now();

        if ($tipo == 'pdf')
            $data['orientacion'] = "landscape";

        $vista = "exportarInventarioActual";

        return $this->exportarExel($data, $vista);
    }

    public function exportarEstadoDeCuentaDeClientes($tipo)
    {
        $tienda_id = Auth::user()->tienda_id;

        $ventas = DB::table('clientes')
            ->select(DB::raw("
                MIN(ventas.created_at) as fecha,
                clientes.id as cliente_id,
                clientes.nombre as cliente,
                clientes.telefono as telefono,
                clientes.direccion as direccion,
                sum(ventas.total) as total,
                sum(ventas.saldo) as saldo_total,
                (select sum(saldo) from ventas where
                    tienda_id = {$tienda_id} AND completed = 1 AND
                    DATEDIFF(current_date, created_at) >= clientes.dias_credito
                    AND cliente_id = clientes.id) as saldo_vencido
                "))
            ->join('ventas', 'ventas.cliente_id', '=', 'clientes.id')
            ->where('ventas.saldo', '>', 0)
            ->where('ventas.completed', '=', 1)
            ->where('ventas.tienda_id', '=', $tienda_id)
            ->orderBy('ventas.created_at','asc')
            ->groupBy('cliente_id')
            ->get();

        $data['ventas'] = $ventas;
        $data['orientacion'] = "portrait";
        $data['tipo'] = $tipo;
        $data['titulo'] = "Ventas_Pendientes_de_Pago_Clientes_".Carbon::now();

        if ($tipo == 'pdf')
            $data['orientacion'] = "landscape";

        $vista = "exportarEstadoDeCuentaDeClientes";

        return $this->exportarExel($data, $vista);
    }

    public function exportarEstadoDeCuentaPorCliente($tipo)
    {
        $ventas = DB::table('ventas')
            ->select(
                DB::raw("ventas.created_at as fecha_ingreso"),
                DB::raw("CONCAT_WS(' ',users.nombre,users.apellido) as usuario"),
                DB::raw("ventas.total as total"),
                DB::raw("ventas.saldo as saldo"),
                DB::raw("DATEDIFF(current_date,ventas.created_at) as dias"))
            ->join('users','users.id','=','ventas.user_id')
            ->where('ventas.tienda_id','=',Auth::user()->tienda_id)
            ->where('ventas.saldo', '>', 0)
            ->where('ventas.cliente_id', '=', Input::get('cliente_id'))->get();

        $data['ventas'] = $ventas;

        $cliente = Cliente::find(Input::get('cliente_id'));

        $data['titulo'] = "Ventas_pendietes_de_pago_del_cliente".$cliente->nombre;
        $data['orientacion'] = "landscape";
        $data['tipo'] = $tipo;
        $data['cliente']['nombre'] = $cliente->nombre;
        $data['cliente']['telefono'] = $cliente->telefono;
        $data['cliente']['direccion'] = $cliente->direccion;

        if ($tipo == 'pdf')
            $data['orientacion'] = "portrait";

        $vista = "exportarEstadoDeCuentaPorCliente";

        return $this->exportarExel($data, $vista);
    }

    public function exportarVentasPendientesDeUsuarios($tipo)
    {
        $tienda_id = Auth::user()->tienda_id;

        $ventas = DB::table('users')
            ->select(DB::raw("
                MIN(ventas.created_at) as fecha,
                users.id as id,
                CONCAT_WS(' ',users.nombre,users.apellido) as usuario,
                tiendas.direccion as tienda,
                sum(ventas.total) as total,
                sum(ventas.saldo) as saldo_total,
                (select sum(saldo) from ventas
                inner join clientes on (clientes.id = ventas.cliente_id)
                where
                    tienda_id = {$tienda_id} AND completed = 1 AND
                    DATEDIFF(current_date, ventas.created_at) >= clientes.dias_credito
                    AND user_id = users.id) as saldo_vencido
                "))
            ->join('ventas', 'ventas.user_id', '=', 'users.id')
            ->join('tiendas', 'tiendas.id', '=', 'users.tienda_id')
            ->where('ventas.saldo', '>', 0)
            ->where('ventas.completed', '=', 1)
            ->orderBy('ventas.created_at','asc')
            ->groupBy('user_id')
            ->get();

        $data['ventas'] = $ventas;
        $data['orientacion'] = "landscape";
        $data['tipo'] = $tipo;
        $data['titulo'] = "Venta_ Pendientes_de_Pago_De_Usuarios".Carbon::now();

        $vista = "exportarVentasPendientesDeUsuarios";

        return $this->exportarExel($data, $vista);
    }

    public function exportarVentasPendientesPorUsuario($tipo)
    {
        $ventas = DB::table('ventas')
        ->select(
                DB::raw("ventas.id as venta_id"),
                DB::raw("ventas.created_at as fecha_ingreso"),
                DB::raw("clientes.nombre as cliente"),
                DB::raw("clientes.telefono as telefono"),
                DB::raw("ventas.total as total"),
                DB::raw("ventas.saldo as saldo"),
                DB::raw("DATEDIFF(current_date,ventas.created_at) as dias")
            )
        ->join('clientes','clientes.id','=','ventas.cliente_id')
        ->where('ventas.tienda_id','=',Auth::user()->tienda_id)
        ->where('ventas.saldo', '>', 0)
        ->where('ventas.user_id', '=', Input::get('user_id'))->get();

        $data['ventas'] = $ventas;

        $user = User::find(Input::get('user_id'));

        $data['titulo'] = "Ventas_pendietes_de_pago_del_Usuario_".$user->nombre.' '.$user->apellido;
        $data['orientacion'] = "landscape";
        $data['tipo'] = $tipo;
        $data['usuario'] = $user->nombre.' '.$user->apellido;

        $vista = "exportarVentasPendientesPorUsuario";

        if ($tipo == 'pdf')
            $data['orientacion'] = "portrait";

        return $this->exportarExel($data, $vista);
    }

    public function ExportarCierreDelMes($tipo,$fecha)
    { 
        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->join("detalle_ventas", "detalle_ventas.venta_id", "=", "ventas.id")
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(detalle_ventas.precio * detalle_ventas.cantidad) as total')));

        $ganancias =  DB::table('users')
        ->select(DB::raw('sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as total'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')->first();

        $soporte = Soporte::join('detalle_soporte','detalle_soporte.soporte_id','=','soporte.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $gastos = Gasto::join('detalle_gastos','detalle_gastos.gasto_id','=','gastos.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $compras = Compra::where('tienda_id','=',Auth::user()->tienda_id)
        ->first(array(DB::raw('sum(saldo) as total')));

        $ventas_c = Venta::where('tienda_id','=',Auth::user()->tienda_id)
        ->first(array(DB::raw('sum(saldo) as total')));

        $inversion = Existencia::join('productos','productos.id','=','existencias.producto_id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('existencias.existencia','>', 0)
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo)) as total')));

        $ventas_usuarios =  DB::table('users')
        ->select(DB::raw('users.id, users.nombre, users.apellido,
            sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
            sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

        $date = Carbon::createFromFormat('Y-m-d', "{$fecha}");

        $fecha_env = Venta::first();

        if (@$fecha_env->created_at == null)
            $fecha_env = Carbon::now();
        else
            $fecha_env = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_env->created_at);

        $data['dia_inicio'] =  $fecha_env;
        $data['total_ventas'] = f_num::get($ventas->total   );
        $data['total_ganancias'] = f_num::get($ganancias->total);
        $data['total_soporte'] = f_num::get($soporte->total  );
        $data['total_gastos'] = f_num::get($gastos->total   );
        $data['compras_credito'] = f_num::get($compras->total  );
        $data['ventas_credito'] = f_num::get($ventas_c->total );
        $data['inversion_actual'] = f_num::get($inversion->total);
        $data['ganancias_netas'] = f_num::get(($ganancias->total+$soporte->total)-$gastos->total);
        $data['mes'] = Traductor::getMes($date->formatLocalized('%B')).' '.$date->formatLocalized('%Y');
        $data['fecha'] = $date;
        $data['fecha_input'] = $date->formatLocalized('%Y-%m-%d');

        $datos['data'] = $data;
        $datos['tipo'] = $tipo;
        $datos['orientacion'] = "landscape";
        $datos['titulo'] = "Cierre de mes";
        $datos['ventas_usuarios'] = $ventas_usuarios;
        $vista = "ExportarCierreDelMes";

        return $this->exportarExel($datos, $vista);
    }

    public function exportarExel($data, $vista)
    {
        if ($data['tipo'] == 'pdf') 
        {
            $pdf = PDF::loadView('exportar.'.$vista, array('data' => $data))
            ->setPaper('letter')->setOrientation('landscape')->setPaper('letter');

            return $pdf->stream($data['titulo'].'.pdf');
        }

        Excel::create($data['titulo'], function($excel) use($data, $vista)
        {
            $excel->setTitle($data['titulo']);
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($data, $vista)
            {
                $hoja->setOrientation($data['orientacion']);
                $hoja->loadView('exportar.'.$vista, array('data' => $data));
            });

        })->export('xls');
    }


}
