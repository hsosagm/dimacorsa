<?php

class NotaCreditoController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            $notaCredito = new NotaCredito;
            $caja = Caja::whereUserId(Auth::user()->id)->first();

            $data = [];
            $data['cliente_id'] = Input::get('cliente_id');
            $data['caja_id'] = $caja->id;
            $data['tipo'] = 'Adelanto';
            $data['nota'] = Input::get('nota');

            if (!$notaCredito->create_master($data))
            {
                return $notaCredito->errors();
            }

            $nota_credito_id = $notaCredito->get_id();
            $cliente = Cliente::find(Input::get('cliente_id'));

            return Response::json(array(
                'success' => true,
                'detalle' => View::make('notas_creditos.detalle', compact('nota_credito_id', 'cliente'))->render()
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
        $data = DB::table('notas_creditos')->select(
            DB::raw("notas_creditos.created_at as fecha"),
            DB::raw("CONCAT_WS(' ',users.nombre,users.apellido) as usuario"),
            DB::raw("clientes.nombre as cliente"),
            "tipo","Monto","nota")
        ->join("users", "users.id", "=", "user_id")
        ->join("clientes", "clientes.id", "=", "cliente_id")
        ->whereRaw("date_format(notas_creditos.updated_at, '%Y-%m-%d') != date_format(current_date,'%Y-%m-%d')")
        ->where("venta_id",">",0)
        ->where("estado","=",0)
        ->get();

        return Response::json(array(
            'success' => true,
            'table' => View::make('notas_creditos.consultarNotasDeCreditoCliente', compact('data'))
        ));
    }

	public function updateClienteId() {

		$notaCredito = NotaCredito::find(Input::get('nota_credito_id'));

		$notaCredito->cliente_id = Input::get('');

	}

    public function getFormSeleccionarTipoDeNotaDeCredito()
    {
        return  View::make('notas_creditos.formSeleccionarTipoDeNotaDeCredito');
    }

    public function getFormMetodoPagoNotaDeCredito()
    {
        $venta = Venta::find(Input::get('venta_id'));
        return  View::make('notas_creditos.formMetodoPagoNotaDeCredito', compact('venta'));
    }
}
