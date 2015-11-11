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

    public function getConsultarNotasDeCreditoCliente()
    {
        $pagos = PagosVenta::whereMetodoPagoId(6)->first();

        if ($pagos != "")
            return 'Ya has ingresado notas de credito en la venta..!';

        $notasCreditos = NotaCredito::select(
            DB::raw('notas_creditos.id as id'),
            DB::raw("CONCAT_WS(' ', nombre, apellido) as usuario"),
            'monto')
        ->join('users', 'user_id', '=', 'users.id')
        ->whereClienteId(Input::get('cliente_id'))->get();

        if (!count($notasCreditos))
            return 'No tienes notas de credito para asignar..!';

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
}
