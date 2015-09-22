<?php

class NotaCreditoController extends \BaseController {

	public function create()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));

            $notaCredito = new NotaCredito;
            
            $data = Input::all();
            $data['caja_id'] = Auth::user()->caja_id;

            if (!$notaCredito->create_master($data))
            {
                return $notaCredito->errors(); 
            }

            return 'success';
        }

        return View::make('notas_creditos.create');
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