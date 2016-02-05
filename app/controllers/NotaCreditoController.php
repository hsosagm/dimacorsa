<?php
class NotaCreditoController extends \BaseController {

    public function create()
    {
        if (Input::has('_token'))
        {
            $notaCredito = new NotaCredito;
            $caja = Caja::whereUserId(Auth::user()->id)->first();
            $data = Input::all();
            $data['tipo'] = 'Adelanto';
            $data['estado'] = 0;
            if (!$notaCredito->create_master($data))
            {
                return $notaCredito->errors();
            }
            return 'success';
        }
        return View::make('notas_creditos.create');
    }

    public function getFormSeleccionarTipoDeNotaDeCredito()
    {
        return  View::make('notas_creditos.formSeleccionarTipoDeNotaDeCredito');
    }

    public function imprimirNotaDeCretido()
    {
        $notaCredito = NotaCredito::with('cliente', 'user')->find(Input::get('nota_credito_id'));
        $pdf = PDF::loadView('notas_creditos.comprobanteAdelanto',  array('notaCredito' => $notaCredito))->setPaper('letter');
        return $pdf->stream('Adelanto_Nota_De_Credito_'.$notaCredito->id);
    }

    public function elminiarNotaDecredito()
    {
        $notaDeCredito = NotaCredito::find(intval(Input::get('nota_credito_id')));

        if ($notaDeCredito->estado == 1) {
            return 'No se puede eliminar por que ya fue utilizada en una venta...';
        }

        if (trim($notaDeCredito->tipo) == "adelanto") {
            Adelanto::destroy($notaDeCredito->tipo_id);
            NotaCredito::destroy(Input::get('nota_credito_id'));
            return Response::json(array('success' => true));
        }        

        return "Solo se pueden eliminar adelantos..";
    }

    public function getConsultarNotasDeCreditoCliente()
    {
        $pagos = PagosVenta::whereMetodoPagoId(6)
        ->whereVentaId(Input::get('venta_id'))->first();

        if ($pagos != "")
            return 'Ya has ingresado notas de credito en la venta..!';

        $notasCreditos = NotaCredito::select(
            DB::raw('notas_creditos.id as id'),
            DB::raw("notas_creditos.created_at as fecha"),
            'monto')
        ->whereClienteId(Input::get('cliente_id'))
        ->whereEstado(0)->get();

        if (!count($notasCreditos))
            return 'No tienes notas de credito para asignar..!';

        NotaCredito::whereClienteId(Input::get('cliente_id'))
        ->whereEstado(0)->whereVentaId(Input::get('venta_id'))
        ->update(array('venta_id' => null));

        $totalVenta = DetalleVenta::select(DB::raw('sum(precio * cantidad) as total'))
        ->whereVentaId(Input::get('venta_id'))->first();

        $totalPago = PagosVenta::select(DB::raw('sum(monto) as total'))
        ->whereVentaId(Input::get('venta_id'))->first();

        $data['notas'] = $notasCreditos;
        $data['total_venta'] = $totalVenta->total;
        $data['total_pago'] = $totalPago->total;
        $data['saldo_restante'] = ($totalVenta->total - $totalPago->total);
        $data['enviar']['cliente_id'] = Input::get('cliente_id');
        $data['enviar']['venta_id'] = Input::get('venta_id');

        return Response::json(array(
            'success' => true,
            'table' => View::make('notas_creditos.consultarNotasDeCreditoCliente', compact('data'))->render()
        ));
    }

     public function getDetalleNotaDeCredito() {

        $notaCredito = NotaCredito::find(Input::get("nota_credito_id"));

        if (trim($notaCredito->tipo) == "adelanto") {
            $adelanto = Adelanto::with('pagos')->find($notaCredito->tipo_id);
            
            return Response::json(array(
                'success' => true,
                'table'   => View::make('notas_creditos.detalleAdelanto',compact('adelanto'))->render())
            );
        }

        if (trim($notaCredito->tipo) == "devolucion") {
            $detalle = $this->getDevolucionesDetalle($notaCredito->tipo_id);
 
            return Response::json(array(
                'success' => true,
                'table'   => View::make('ventas.devoluciones.DT_detalleDevolucion',compact('detalle'))->render())
            );
        }
    }

    public function getDevolucionesDetalle($id)
    {
        $detalle = DB::table('devoluciones_detalle')
        ->select(array(
            'devoluciones_detalle.id',
            'devolucion_id',
            'producto_id',
            'cantidad',
            'precio',
            'ganancias',
            'serials',
            DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->whereDevolucionId($id)
        ->join('productos', 'devoluciones_detalle.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        foreach ($detalle as $dt) {
            if ($dt->serials) {
                $dt->serials = explode(',', $dt->serials);
            }
        }
 
        return $detalle;
    }
}
