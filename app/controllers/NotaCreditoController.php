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

    public function imprimirNotaDeCretido()
    {
        $notaCredito = NotaCredito::with('cliente', 'user')->find(Input::get('nota_credito_id'));
        $pdf = PDF::loadView('notas_creditos.comprobanteAdelanto',  array('notaCredito' => $notaCredito));
        return $pdf->stream('Adelanto_Nota_De_Credito_'.$notaCredito->id);
    }
}
