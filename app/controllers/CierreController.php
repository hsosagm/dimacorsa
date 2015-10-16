<?php

class CierreController extends \BaseController {

    public function getCierreDelDia()
    {
        $fecha = Input::get('fecha');
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
        {
            $fecha_enviar = 'current_date';
            $dt = Carbon::now();
        }

        else
            $dt = Carbon::createFromFormat('Y-m-d',$fecha);

        $fecha_titulo  = 'CIERRE DIARIO '.Traductor::getDia($dt->formatLocalized('%A')).' '.$dt->formatLocalized('%d');
        $fecha_titulo .= ' DE '.Traductor::getMes($dt->formatLocalized('%B')).' DE '.$dt->formatLocalized('%Y');

        $titulo ['fecha']  = $fecha_titulo;

        $data = $this->resumen_movimientos($fecha);
        $dataDetalle = $this->resumenMovimientosDetallado($fecha);

        $corte_realizado = Cierre::with('user')->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(cierre_diario.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->first();
        return View::make('cierre.getCierreDia',compact('data','fecha','dataDetalle','corte_realizado', 'titulo'));
    }

    public function CierreDelDia()
    {
        $dt = Carbon::now();
        $fecha_titulo  = 'CIERRE DIARIO '.Traductor::getDia($dt->formatLocalized('%A')).' '.$dt->formatLocalized('%d');
        $fecha_titulo .= ' DE '.Traductor::getMes($dt->formatLocalized('%B')).' DE '.$dt->formatLocalized('%Y');

        $titulo ['fecha']  = $fecha_titulo;

        $fecha = 'current_date';
        $data = $this->resumen_movimientos($fecha);
        $dataDetalle = $this->resumenMovimientosDetallado($fecha);
        $corte_realizado = Cierre::with('user')->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(cierre_diario.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->first();

        return View::make('cierre.CierreDia',compact('data','fecha','dataDetalle','corte_realizado','titulo'));
    }

    public function enviarCorreoPDF($cierre_id)
    {
        $dt = Carbon::now();
        $fecha_titulo  = 'CIERRE DIARIO '.Traductor::getDia($dt->formatLocalized('%A')).' '.$dt->formatLocalized('%d');
        $fecha_titulo .= ' DE '.Traductor::getMes($dt->formatLocalized('%B')).' DE '.$dt->formatLocalized('%Y');

        $tienda = Tienda::find(Auth::user()->tienda_id);
        $tienda_titulo = "{$tienda->nombre}, {$tienda->direccion}";

        $titulo ['tienda'] = $tienda_titulo;
        $titulo ['fecha']  = $fecha_titulo;

        $fecha = 'current_date';
        $data = $this->resumen_movimientos($fecha);
        $dataDetalle = $this->resumenMovimientosDetallado($fecha);
        $corte_realizado = Cierre::with('user')->find($cierre_id);
        $emails = array();

        $correos = DB::table('notificaciones')->select('correo')->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('notificacion','CierreDia')->get();

        foreach ($correos as $val) {
            $emails [] = $val->correo;
        }

        Mail::queue('emails.mensaje', array('asunto' => 'Cierre del Dia'), function($message)
        use($fecha, $data, $dataDetalle, $corte_realizado, $emails, $titulo, $tienda_titulo)
        {
            $pdf = PDF::loadView('cierre.ExportarCierreDelDia',  array(
                'data' => $data,
                'fecha' => $fecha,
                'dataDetalle' => $dataDetalle ,
                'corte_realizado' => $corte_realizado,
                'titulo' => $titulo
            ));

            $message->to($emails)->subject('Notificacion de Cierre del Dia '.$tienda_titulo);
            $message->attachData($pdf->output(), Carbon::now().".pdf");
        });
    }

    public function ExportarCierreDelDia($tipo,$fecha)
    {
        $  $fecha = Input::get('fecha');
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
        {
            $fecha_enviar = 'current_date';
            $dt = Carbon::now();
        }
        else
        {
            $dt = Carbon::createFromFormat('Y-m-d',$fecha);
        }

        $fecha_titulo  = 'CIERRE DIARIO '.Traductor::getDia($dt->formatLocalized('%A')).' '.$dt->formatLocalized('%d');
        $fecha_titulo .= ' DE '.Traductor::getMes($dt->formatLocalized('%B')).' DE '.$dt->formatLocalized('%Y');

        $titulo ['fecha']  = $fecha_titulo;

        $data = $this->resumen_movimientos($fecha);
        $dataDetalle = $this->resumenMovimientosDetallado($fecha);

        $corte_realizado = Cierre::with('user')->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(cierre_diario.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->first();


        if (trim($tipo) =='pdf')
        {
            $pdf = PDF::loadView('cierre.ExportarCierreDelDia', array(
                'data' => $data,
                'fecha' => $fecha,
                'dataDetalle' => $dataDetalle,
                'corte_realizado' => $corte_realizado,
                'titulo' => $titulo))
            ->setPaper('letter');

            return $pdf->stream();
        }


        Excel::create('CierreDia', function($excel) use($data, $fecha, $dataDetalle, $corte_realizado, $titulo)
        {
            $excel->setTitle('CierreDia');
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($data, $fecha, $dataDetalle, $corte_realizado, $titulo)
            {
                $hoja->setOrientation('landscape');
                $hoja->loadView('cierre.ExportarCierreDelDia', array(
                    'data' => $data,
                    'fecha' => $fecha,
                    'dataDetalle' => $dataDetalle,
                    'corte_realizado' => $corte_realizado,
                    'titulo' => $titulo));
                });

        })->export('xls');
    }

    public function CierreDelDiaPorFecha()
    {
        $fecha = Input::get('fecha');
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
        {
            $fecha_enviar = 'current_date';
            $dt = Carbon::now();
        }
        else
        {
            $dt = Carbon::createFromFormat('Y-m-d',$fecha);
        }

        $fecha_titulo  = 'CIERRE DIARIO '.Traductor::getDia($dt->formatLocalized('%A')).' '.$dt->formatLocalized('%d');
        $fecha_titulo .= ' DE '.Traductor::getMes($dt->formatLocalized('%B')).' DE '.$dt->formatLocalized('%Y');

        $titulo ['fecha']  = $fecha_titulo;

        $data = $this->resumen_movimientos($fecha);
        $dataDetalle = $this->resumenMovimientosDetallado($fecha);

        $corte_realizado = Cierre::with('user')->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(cierre_diario.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->first();
        return View::make('cierre.CierreDia',compact('data','fecha','dataDetalle','corte_realizado', 'titulo'));
    }

    public function resumenMovimientosDetallado($fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
            $fecha_enviar = 'current_date';

        /*inicio consulta para ventas al credito*/
        $pagosVentas = Venta::with('cliente','user')
        ->join('pagos_ventas','ventas.id','=','venta_id')
        ->where('metodo_pago_id',2)->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->get();
        /*fin consulta para ventas al credito*/

        /*inicio consulta para detalle de gastos */
        $detalleGastos = DetalleGasto::with('gasto','metodoPago')
        ->join('gastos','gastos.id','=','gasto_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->get();
        /*fin consulta para detalle de gastos */

        /*inicio consulta para detalle de egresos */
        $detalleEgresos = DetalleEgreso::with('egreso','metodoPago')
        ->join('egresos','egresos.id','=','egreso_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(egresos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->get();
        /*fin consulta para detalle de egresos */

        /*inicio consulta para detalle compras */
        $detalleCompras = Compra::with('proveedor','user')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(compras.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")->get();
        /*fin consulta para detalle compras */

        $depositosDetalle = $this->consultaDetalleOperaciones($fecha_enviar , 5);
        $chequesDetalle = $this->consultaDetalleOperaciones($fecha_enviar , 3);

        $dataDetalle['credito']['pagosVentas'] = $pagosVentas;
        $dataDetalle['deposito'] = $depositosDetalle;
        $dataDetalle['cheque'] = $chequesDetalle;
        $dataDetalle['todos']['detalleGastos'] = $detalleGastos;
        $dataDetalle['todos']['detalleEgresos'] = $detalleEgresos;
        $dataDetalle['todos']['detalleCompras'] = $detalleCompras;

        return $dataDetalle;
    }

    /*inicio consulta para todo lo que se hiso con deposito o cheque en el dia*/
    public function consultaDetalleOperaciones($fecha , $metodo_pago_id)
    {
        $depositosPagosVentas = PagosVenta::with('venta')->where('metodo_pago_id',$metodo_pago_id)
        ->join('ventas','ventas.id','=','venta_id')->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosAbonosVentas = AbonosVenta::with('user')->where('metodo_pago_id',$metodo_pago_id)
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(abonos_ventas.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosSoporte = DetalleSoporte::with('soporte')->where('metodo_pago_id',$metodo_pago_id)
        ->join('soporte','soporte.id','=','soporte_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosAdelanto = DetalleAdelanto::with('adelanto')->where('metodo_pago_id',$metodo_pago_id)
        ->join('adelantos','adelantos.id','=','adelanto_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(adelantos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosIngreso = DetalleIngreso::with('ingreso')->where('metodo_pago_id',$metodo_pago_id)
        ->join('ingresos','ingresos.id','=','ingreso_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ingresos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosGasto = DetalleGasto::with('gasto')->where('metodo_pago_id',$metodo_pago_id)
        ->join('gastos','gastos.id','=','gasto_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosEgreso = DetalleEgreso::with('egreso')->where('metodo_pago_id',$metodo_pago_id)
        ->join('egresos','egresos.id','=','egreso_id')
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(egresos.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosPagosCompras = PagosCompra::with('compra')->where('metodo_pago_id',$metodo_pago_id)
        ->join('compras','compras.id','=','compra_id')->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(compras.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositoAbonosCompras = AbonosCompra::with('user')->where('metodo_pago_id',$metodo_pago_id)
        ->where('tienda_id',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(abonos_compras.created_at, '%Y-%m-%d')= DATE_FORMAT({$fecha}, '%Y-%m-%d')")->get();

        $depositosDetalle['pagosVentas'] = $depositosPagosVentas;
        $depositosDetalle['abonosVentas'] = $depositosAbonosVentas;
        $depositosDetalle['soporte'] = $depositosSoporte;
        $depositosDetalle['adelantos'] = $depositosAdelanto;
        $depositosDetalle['ingresos'] = $depositosIngreso;
        $depositosDetalle['gastos'] = $depositosGasto;
        $depositosDetalle['egresos'] = $depositosEgreso;
        $depositosDetalle['pagosCompras'] = $depositosPagosCompras;
        $depositosDetalle['abonosCompras'] = $depositoAbonosCompras;

        return $depositosDetalle;
    }
    /*fin consulta para todo lo que se hiso con deposito o cheque en el dia*/

    /*
        funcion para ordenar el arreglo de los metodos de pago
        retorna un arreglo de una dimencion
        forma de uso $arreglo['efectivo']
    */
    public function llenar_arreglo($Query)
    {
        $arreglo_ordenado = array(
            'titulo'  => '',
            'efectivo'=>"0.00",
            'credito' =>"0.00",
            'cheque'  =>"0.00",
            'tarjeta' =>"0.00",
            'deposito'=>"0.00",
            'total'   =>"0.00"
        );

        foreach ($Query as $key => $val)
        {
            if($val->descripcion == 'Efectivo')
                $arreglo_ordenado['efectivo'] = $val->total;

            if($val->descripcion == 'Credito')
                $arreglo_ordenado['credito'] = $val->total;

            if($val->descripcion == 'Cheque')
                $arreglo_ordenado['cheque'] = $val->total;

            if($val->descripcion == 'Tarjeta')
                $arreglo_ordenado['tarjeta'] = $val->total;

            if($val->descripcion == 'Deposito'){
                $arreglo_ordenado['deposito'] = $val->total;
            }

            $arreglo_ordenado['total'] = $arreglo_ordenado['total'] + $val->total;
        }

        return $arreglo_ordenado;
    }

    public function ExportarCierreDelMes($tipo,$fecha)
    {
        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

        $ganancias =  DB::table('users')
        ->select(DB::raw('sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as total'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)->where('users.status','=',1)
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
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo/100)) as total')));

        $ventas_usuarios =  DB::table('users')
        ->select(DB::raw('users.id, users.nombre, users.apellido,
            sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
            sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)
        ->where('users.status','=',1)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

        $date = Carbon::createFromFormat('Y-m-d', "{$fecha}");

        $fecha_env = Venta::first();

        if (@$fecha_env->created_at == null)
        {
            $fecha_env = Carbon::now();
        }
        else
        {
            $fecha_env = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_env->created_at);
        }

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

        if (trim($tipo) == "pdf") {
            $pdf = PDF::loadView('cierre.ExportarCierreDelMes', array(
                'data' => $data,
                'ventas_usuarios' => $ventas_usuarios))
            ->setPaper('letter');

            return $pdf->stream();
        }


        Excel::create('CierreMes', function($excel) use($data, $ventas_usuarios)
        {
            $excel->setTitle('CierreMes');
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($data, $ventas_usuarios)
            {
                $hoja->setOrientation('landscape');
                $hoja->loadView('cierre.ExportarCierreDelMes', array(
                    'data' => $data,
                    'ventas_usuarios' => $ventas_usuarios));
                });

        })->export('xls');

    }


    public function CierreDelMes()
    {
        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

        $ganancias =  DB::table('detalle_ventas')
        ->select(DB::raw('sum(cantidad * ganancias) as total'))
        ->join('ventas','ventas.id','=','venta_id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")->first();

        $soporte = Soporte::join('detalle_soporte','detalle_soporte.soporte_id','=','soporte.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(soporte.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $gastos = Gasto::join('detalle_gastos','detalle_gastos.gasto_id','=','gastos.id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(gastos.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->first(array(DB::raw('sum(monto) as total')));

        $compras = Compra::where('tienda_id','=',Auth::user()->tienda_id)
        ->first(array(DB::raw('sum(saldo) as total')));

        $ventas_c = Venta::where('tienda_id','=',Auth::user()->tienda_id)
        ->first(array(DB::raw('sum(saldo) as total')));

        $inversion = Existencia::join('productos','productos.id','=','existencias.producto_id')
        ->where('tienda_id','=',Auth::user()->tienda_id)
        ->where('existencias.existencia','>', 0)
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo/100)) as total')));

        $ventas_usuarios =  DB::table('users')
        ->select(DB::raw('users.id, users.nombre, users.apellido,
            sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
            sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)
        ->where('users.status','=',1)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT(current_date, '%Y-%m')")
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

        $date = Carbon::now();

        $fecha_env = Venta::first();

        if (@$fecha_env->created_at == null)
        {
            $fecha_env = Carbon::now();
        }
        else
        {
            $fecha_env = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_env->created_at);
        }

        $data['dia_inicio'] = $fecha_env;
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

        return View::make('cierre.balanceGeneral',compact('ventas_usuarios','data'));

    }


    public function cierre()
    {
        if ( Input::has('_token') )
        {
            $cierre = new Cierre;

            if (!$cierre->create_master())
            {
                return $cierre->errors();
            }
            $this->enviarCorreoPDF($cierre->get_id());
            return Response::json(array(
                'success' => true ,
                'id' => $cierre->get_id()
                ));
        }

        $query = Cierre::where(DB::raw('DATE(created_at)'), '=', DATE('Y-m-d'))
        ->where('tienda_id', Auth::user()->tienda_id)
        ->first();

        if (count($query))
            return Response::json(array(
                'success' => false,
                'user' => $query->user->nombre. " " . $query->user->apellido
                ));

        $data = $this->resumen_movimientos('current_date');

        $efectivo = $data['adelantos']['efectivo'] + $data['soporte']['efectivo'] + $data['pagos_ventas']['efectivo'] + $data['abonos_ventas']['efectivo'] + $data['ingresos']['efectivo']
        - $data['gastos']['efectivo'] - $data['egresos']['efectivo'] - $data['pagos_compras']['efectivo'] - $data['abonos_compras']['efectivo'];

        $cheque = $data['pagos_ventas']['cheque'] + $data['abonos_ventas']['cheque'] + $data['soporte']['cheque'] + $data['adelantos']['cheque'] + $data['ingresos']['cheque'];
        $tarjeta = $data['pagos_ventas']['tarjeta'] + $data['abonos_ventas']['tarjeta'] + $data['soporte']['tarjeta'] + $data['adelantos']['tarjeta'] + $data['ingresos']['tarjeta'];

        $deposito = $data['pagos_ventas']['deposito'] + $data['abonos_ventas']['deposito'] + $data['soporte']['deposito'] + $data['adelantos']['deposito'] + $data['ingresos']['deposito'];

        $movimientos = array(
            'efectivo' => $efectivo,
            'cheque'   => $cheque,
            'tarjeta'  => $tarjeta,
            'deposito' => $deposito
            );

        $movimientos = json_encode($movimientos);

        return Response::json(array(
            'success' => true,
            'form' => View::make('cierre.cierre', compact('movimientos'))->render()
        ));
    }

    /*
        Funcion que nos retorna una matriz de dos dimencionespero voy a esperar que este solo
        su forma de uso es  $data['pagos_ventas']['efectivo'];
    */
    public function resumen_movimientos($fecha)
    {
        $data = [];
        $data['pagos_ventas']             =   $this->_query('pagos_ventas', 'venta', 'monto', $fecha);
        $data['abonos_ventas']            =   $this->query('abonos_ventas', 'monto', $fecha);
        $data['soporte']                  =   $this->__query('detalle_soporte', 'soporte', 'monto', $fecha);
        $data['adelantos']                =   $this->_query('detalle_adelantos', 'adelanto', 'monto', $fecha);
        $data['ingresos']                 =   $this->_query('detalle_ingresos', 'ingreso', 'monto', $fecha);
        $data['egresos']                  =   $this->_query('detalle_egresos', 'egreso', 'monto', $fecha);
        $data['gastos']                   =   $this->_query('detalle_gastos', 'gasto', 'monto', $fecha);
        $data['abonos_compras']           =   $this->query('abonos_compras', 'monto', $fecha);
        $data['pagos_compras']            =   $this->_query('pagos_compras', 'compra', 'monto', $fecha);
        $data['adelanto_notas_creditos']  =   $this->___query('adelanto_nota_credito', 'notas_creditos', 'nota_credito', 'monto', $fecha);
        $data['devolucion_notas_creditos']=   $this->___query('devolucion_nota_credito', 'notas_creditos', 'nota_credito', 'monto', $fecha);
        $data['resultados']               =   array();

        return $data;
    }

    /*********************************************************************************************************************************
        Inicio de Funciones para generar la consulta agrupandolos por el metodo de pago
    **********************************************************************************************************************************/

    // funcion cuando la tabla si tiene el campo tienda id
    public function query( $tabla , $campo , $fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
            $fecha_enviar = 'current_date';

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=", "metodo_pago.id")
        ->whereRaw("DATE_FORMAT({$tabla}.updated_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
        ->where("{$tabla}.tienda_id", '=' , Auth::user()->tienda_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    // funcion cuando la tabla no tiene el campo tienda id y  el nombre de la tabla que tiene el campo esta en plural
    public function _query( $tabla ,$tabla_master, $campo , $fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
            $fecha_enviar = 'current_date';

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=", "metodo_pago.id")
        ->join("{$tabla_master}s","{$tabla_master}s.id" , "=", "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}s.updated_at, '%Y-%m-%d')= DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
        ->where("{$tabla_master}s.tienda_id", '=', Auth::user()->tienda_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }
    //nombre de la tabla que tiene el campo esta en singular
    public function __query( $tabla ,$tabla_master, $campo , $fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
            $fecha_enviar = 'current_date';

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=", "metodo_pago.id")
        ->join("{$tabla_master}","{$tabla_master}.id", "=", "{$tabla}.{$tabla_master}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}.updated_at, '%Y-%m-%d') = DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
        ->where("{$tabla_master}.tienda_id", '=', Auth::user()->tienda_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }

    //funcion cuando la tabla master tiene nombre separados y tambien su foranea
    public function ___query( $tabla ,$tabla_master, $foranea ,$campo , $fecha )
    {
        $fecha_enviar = "'{$fecha}'";

        if ($fecha == 'current_date')
            $fecha_enviar = 'current_date';

        $Query = DB::table('metodo_pago')
        ->select(DB::raw("metodo_pago.descripcion as descripcion, sum({$campo}) as total"))
        ->join($tabla,"{$tabla}.metodo_pago_id" , "=", "metodo_pago.id")
        ->join("{$tabla_master}","{$tabla_master}.id", "=", "{$tabla}.{$foranea}_id")
        ->whereRaw("DATE_FORMAT({$tabla_master}.updated_at, '%Y-%m-%d') =  DATE_FORMAT({$fecha_enviar}, '%Y-%m-%d')")
        ->where("{$tabla_master}.tienda_id", '=', Auth::user()->tienda_id)
        ->groupBy('metodo_pago.id')->get();

        return $this->llenar_arreglo($Query);
    }
    /*********************************************************************************************************************************
        Fin de Funciones para generar la consulta agrupandolos por el metodo de pago
    **********************************************************************************************************************************/

    public function CierreDelMesPorFecha()
    {
        $fecha = Input::get('fecha');

        $ventas = Venta::where('ventas.tienda_id' , '=' , Auth::user()->tienda_id)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->first(array(DB::raw('sum(total) as total')));

        $ganancias =  DB::table('users')
        ->select(DB::raw('sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as total'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)->where('users.status','=',1)
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
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo/100)) as total')));

        $ventas_usuarios =  DB::table('users')
        ->select(DB::raw('users.id, users.nombre, users.apellido,
            sum(detalle_ventas.cantidad * detalle_ventas.precio) as total,
            sum(detalle_ventas.cantidad * detalle_ventas.ganancias) as utilidad'))
        ->join('ventas','ventas.user_id','=','users.id')
        ->join('detalle_ventas','detalle_ventas.venta_id','=','ventas.id')
        ->where('users.tienda_id','=',Auth::user()->tienda_id)
        ->where('users.status','=',1)
        ->whereRaw("DATE_FORMAT(ventas.created_at, '%Y-%m')= DATE_FORMAT('{$fecha}', '%Y-%m')")
        ->orderBy('total', 'DESC')
        ->groupBy('users.id','users.nombre','users.apellido')
        ->get();

        $date = Carbon::createFromFormat('Y-m-d', "{$fecha}");

        $fecha_env = Venta::first();

        if (@$fecha_env->created_at == null) {
            $fecha_env = Carbon::now();
        }else{
            $fecha_env = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_env->created_at);
        }

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

        if (Input::get('grafica') == true ) {
             return View::make('cierre.CierreMes',compact('ventas_usuarios','data'));
        }

        return View::make('cierre.balanceGeneral',compact('ventas_usuarios','data'));
    }

    public function CierresDelMes()
    {
        return View::make('cierre.CierresDelMes');
    }

    public function CierresDelMes_dt()
    {
        $fecha_enviar = "'".Input::get('fecha')."'";

        if (Input::get('fecha') == 'current_date')
            $fecha_enviar = 'current_date';

        $table = 'cierre_diario';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "nota",
            "cierre_diario.created_at as fecha"
            );

        $Searchable = array("users.nombre","users.apellido","cierre_diario.created_at","nota");

        $Join = "
        JOIN users ON (users.id = cierre_diario.user_id)
        JOIN tiendas ON (tiendas.id = cierre_diario.tienda_id)";

        $where = " DATE_FORMAT(cierre_diario.created_at, '%Y-%m')  = DATE_FORMAT({$fecha_enviar}, '%Y-%m')";
        $where .= ' AND cierre_diario.tienda_id = '.Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function VerDetalleDelCierreDelDia()
    {
        $cierre = Cierre::find(Input::get('cierre_id'));

        return Response::json(array(
            'success' => true,
            'table'   => View::make('cierre.DT_detalle_cierre', compact('cierre'))->render()
        ));
    }

    public function ImprimirCierreDelDia_dt($cod , $id)
    {
        $cierre = Cierre::with('user')->find($id);
        return View::make('cierre.ImprimirCierreDelDia_dt', compact('cierre'));
    }

    /*********************************************************************************************************************************
       Inicio Consultas de ventas del mes en el Balance General
    **********************************************************************************************************************************/
    public function VentasDelMes()
    {
        return View::make('cierre.VentasDelMes');
    }

    public function VentasDelMes_dt()
    {
        $fecha = Input::get('fecha');

        $table = 'productos';

        $columns = array(
            "sum(detalle_ventas.cantidad) as cantidad_total",
            "productos.descripcion as descripcion",
            "(productos.p_costo/100) as precio_costo",
            "productos.p_publico as precio_publico",
            "(sum(detalle_ventas.precio * detalle_ventas.cantidad )/sum(detalle_ventas.cantidad)) as precio_promedio",
            "(((sum(detalle_ventas.ganancias * detalle_ventas.cantidad)/sum(detalle_ventas.cantidad))*100)/(sum(detalle_ventas.precio * detalle_ventas.cantidad )/sum(detalle_ventas.cantidad))) as porcentaje",
            "sum(detalle_ventas.ganancias * detalle_ventas.cantidad) as ganancia_total",
            "sum(detalle_ventas.precio * detalle_ventas.cantidad ) as monto_total"
            );

        $Searchable = array("productos.descripcion");

        $Join  = " JOIN detalle_ventas ON (producto_id = productos.id) ";
        $Join .= " JOIN ventas ON (ventas.id = venta_id) ";

        $where = " DATE_FORMAT(detalle_ventas.created_at, '%Y-%m')  = DATE_FORMAT('{$fecha}', '%Y-%m') ";
        $where .= ' AND ventas.tienda_id = '.Auth::user()->tienda_id.' GROUP BY detalle_ventas.producto_id';

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function GastosPorFecha()
    {
        return View::make('cierre.GastosPorFecha');
    }

    public function GastosPorFecha_dt()
    {
        $fecha    = Input::get('fecha');
        $table = 'gastos';

        $columns = array(
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "gastos.created_at as fecha",
            "detalle_gastos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $where = "DATE_FORMAT(gastos.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";
        $where .= ' AND gastos.tienda_id = '.Auth::user()->tienda_id;

        $Join = " JOIN detalle_gastos ON (gastos.id = detalle_gastos.gasto_id)
        JOIN users ON (users.id = gastos.user_id)
        JOIN tiendas ON (tiendas.id = gastos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function SoportePorFecha()
    {
        return View::make('cierre.SoportePorFecha');
    }

    public function SoportePorFecha_dt()
    {
        $fecha    = Input::get('fecha');
        $table = 'soporte';

        $columns = array(
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "soporte.created_at as fecha",
            "detalle_soporte.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $where = "DATE_FORMAT(soporte.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";
        $where .= ' AND soporte.tienda_id = '.Auth::user()->tienda_id;

        $Join = "JOIN detalle_soporte ON (soporte.id = detalle_soporte.soporte_id)
        JOIN users ON (users.id = soporte.user_id)
        JOIN tiendas ON (tiendas.id = soporte.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }

    public function DetalleDeVentasPorProducto()
    {
        $table = 'detalle_ventas';

        $columns = array(
            "ventas.id as id_venta",
            "ventas.created_at fecha",
            "detalle_ventas.cantidad  as cantidad",
            "productos.descripcion  as descripcion",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
            "detalle_ventas.ganancias as ganancias",
            "detalle_ventas.precio as precio"
            );

        $Search_columns = array("users.nombre","users.apellido","venta.created_at","productos.descripcion");

        $Join  = "JOIN ventas ON (detalle_ventas.venta_id = ventas.id) ";
        $Join .= "JOIN productos ON (productos.id = detalle_ventas.producto_id) ";
        $Join .= "JOIN users ON (users.id = ventas.user_id) ";
        $Join .= "JOIN clientes ON (clientes.id = ventas.cliente_id)";

        $where  = " ventas.tienda_id = ".Auth::user()->tienda_id;
        $where .= " AND DATE_FORMAT(detalle_ventas.created_at, '%Y-%m') = DATE_FORMAT('".Input::get('fecha')."', '%Y-%m') ";
        $where .= " AND detalle_ventas.producto_id = ".Input::get('producto_id');

        $detalle = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'table'   => View::make('cierre.DetalleDeVentasPorProducto', compact('detalle'))->render()
        ));
    }

    public function DetalleVentaCierre()
    {
        $venta = Venta::with('cliente', 'detalle_venta')->find(Input::get('venta_id'));

        return Response::json(array(
            'success' => true,
            'table' => View::make('cierre.DetalleVentaCierre', compact('venta'))->render()
        ));
    }
    /*********************************************************************************************************************************
        Fin Consultas de ventas del mes en el Balance General
    **********************************************************************************************************************************/

}
