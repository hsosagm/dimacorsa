<?php

class NotaCreditoController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            $notaCredito = new NotaCredito;
            $caja = Caja::whereUserId(Auth::user()->id)->first();
            $data = Input::all();

            $data['caja_id'] = $caja->id;
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

    public function getFormMetodoPagoNotaDeCredito()
    {
        $venta = Venta::find(Input::get('venta_id'));
        //iniciar las variables que se van a enviar en cero para no hacerlo en el blade
        $descuento_sobre_saldo = 0;
        $monto = 0;
        return  View::make('notas_creditos.formMetodoPagoNotaDeCredito', compact('venta', 'descuento_sobre_saldo', 'monto'));
    }

	public function imprimirNotaDeCretido()
	{
		$notaCredito = NotaCredito::with('cliente', 'user')->find(Input::get('nota_credito_id'));

		$pdf = PDF::loadView('notas_creditos.comprobanteAdelanto',  array('notaCredito' => $notaCredito));

		return $pdf->stream('Adelanto_Nota_De_Credito_'.$notaCredito->id);
	}
}
