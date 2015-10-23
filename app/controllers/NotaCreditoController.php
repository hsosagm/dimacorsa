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

            if (!$notaCredito->create_master($data))
            {
                return $notaCredito->errors();
            }

            $nota_credito_id = $notaCredito->get_id();
            return Response::json(array(
                'success' => true
            ));
        }

        return View::make('notas_creditos.create');
    }

    public function detalle()
    {
        if (Input::has('_token'))
        {
            $verificar = AdelantoNotaCredito::where('metodo_pago_id', '=', Input::get('metodo_pago_id'))
            ->where('nota_credito_id', '=', Input::get('nota_credito_id'))->get();

            if (count($verificar))
                return 'ya a ingresado ese metodo de pago en este adelanto...!';

            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));

            $notaCreditoAdelanto = new AdelantoNotaCredito;

            if (!$notaCreditoAdelanto->_create())
            {
                return $notaCreditoAdelanto->errors();
            }

            $detalle = AdelantoNotaCredito::where('nota_credito_id', '=', Input::get('nota_credito_id'))->get();

            return Response::json(array(
                'success' => true,
                'table' => View::make('notas_creditos.detalle_body', compact('detalle'))->render()
            ));
        }

        return View::make('notas_creditos.create');
    }

	public function deleteAdelanto()
	{
		$notaCredito = NotaCredito::find(Input::get('nota_credito_id'));

		if ($notaCredito->delete()) {
			return Response::json(array(
                'success' => true,
            ));
		}

		return 'error al tratar de eliminar...!';
	}

	public function eliminarNotaCredito()
	{
		$notaCredito = NotaCredito::find(Input::get('nota_credito_id'));

		if ($notaCredito->delete()) {
			return Response::json(array(
                'success' => true,
            ));
		}

		return 'error al tratar de eliminar...!';
	}

    public function eliminarDetalle()
    {
        $adelanto = AdelantoNotaCredito::find(Input::get('adelanto_nota_credito_id'));
        $nota_credito_id = $adelanto->nota_credito_id;
        $adelanto->delete();

        $detalle = AdelantoNotaCredito::where('nota_credito_id', '=', $nota_credito_id )->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('notas_creditos.detalle_body', compact('detalle'))->render()
        ));
    }

    public function getConsultarNotasDeCreditoCliente()
    {
        $dataAdelanto = DB::table('notas_creditos')->select(
			DB::raw("notas_creditos.id as id"),
			DB::raw("adelanto_nota_credito.id as id_foraneo"),
            DB::raw("notas_creditos.created_at as fecha"),
            DB::raw("CONCAT_WS(' ',users.nombre,users.apellido) as usuario"),
			DB::raw("clientes.nombre as cliente"),
			DB::raw("notas_creditos.tipo as tipo"),
			DB::raw("notas_creditos.nota as nota"),
            DB::raw("adelanto_nota_credito.monto as monto"))
        ->join("users", "users.id", "=", "user_id")
		->join("clientes", "clientes.id", "=", "cliente_id")
        ->join("adelanto_nota_credito", "nota_credito_id", "=", "notas_creditos.id")
		->where("estado", "=", 0)
        ->where("cliente_id", "=", Input::get('cliente_id'))
        ->get();

		$dataDevolucion = DB::table('notas_creditos')->select(
			DB::raw("notas_creditos.id as id"),
			DB::raw("devolucion_nota_credito.id as id_foraneo"),
            DB::raw("notas_creditos.created_at as fecha"),
            DB::raw("CONCAT_WS(' ',users.nombre,users.apellido) as usuario"),
			DB::raw("clientes.nombre as cliente"),
			DB::raw("notas_creditos.tipo as tipo"),
			DB::raw("notas_creditos.nota as nota"),
            DB::raw("devolucion_nota_credito.monto as monto"))
        ->join("users", "users.id", "=", "user_id")
		->join("clientes", "clientes.id", "=", "cliente_id")
        ->join("devolucion_nota_credito", "nota_credito_id", "=", "notas_creditos.id")
        ->where("estado", "=", 0)
		->where("cliente_id", "=", Input::get('cliente_id'))
        ->get();

		$cliente_id    = Input::get('cliente_id');
 		$venta_id      = 10;
		$restanteVenta = 150;

        return Response::json(array(
            'success' => true,
			'dataDevolucion' => $dataDevolucion,
			'dataAdelanto'   => $dataAdelanto,
			'restanteVenta'  => $restanteVenta,
			'venta_id'       => $venta_id,
			'cliente_id'     => $cliente_id,
            'view' => View::make('notas_creditos.consultarNotasDeCreditoCliente',
			compact('dataAdelanto', 'dataDevolucion', 'venta_id', 'restanteVenta', 'cliente_id'))->render(),
        ));
    }

	public function updateClienteId()
	{
		$notaCredito = NotaCredito::find(Input::get('nota_credito_id'));
		$notaCredito->cliente_id = Input::get('cliente_id');
		$notaCredito->save();

		return Response::json(array(
			'success' => true
		));
	}

    public function getFormSeleccionarTipoDeNotaDeCredito()
    {
        return  View::make('notas_creditos.formSeleccionarTipoDeNotaDeCredito');
    }

	public function imprimirNotaDeCretidoAdelanto()
	{
		$notaCreditoAdelanto = AdelantoNotaCredito::whereNotaCreditoId(Input::get('nota_credito_id'))->get();

		if (count($notaCreditoAdelanto) <= 0 )
			return 'no has ingresado pagos ala Nota de Credito....!';

		$notaCredito = NotaCredito::with('adelanto', 'cliente', 'user')->find(Input::get('nota_credito_id'));

		$pdf = PDF::loadView('notas_creditos.comprobanteAdelanto',  array('notaCredito' => $notaCredito));

		return $pdf->stream('Adelanto_Nota_De_Credito_'.$notaCredito->id);
	}
}
