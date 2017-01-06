<?php namespace App\gastos;

use Input, View, Gasto, Response, Success, DetalleGasto, Auth, MetodoPago, Caja, CierreCaja, CajaController, Kardex, Carbon;

class GastoController extends \BaseController {

    protected $tienda_id;

    public function __construct()
    {
        $this->tienda_id = Auth::user()->tienda_id;
    }

	public function create()
	{
		return View::make('gastos::create');
	}

    public function save()
    {
        $gasto = new Gasto;
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data = [];

        if (Auth::user()->tienda->cajas)
            $data['caja_id'] = $caja->id;

        if (!$gasto->create_master($data))
            return $gasto->errors();

        $total = 0;

        foreach (Input::get('detalle') as $key => $value)
        {
            if ($value['metodo_pago_id'] == 1) {
                $total += str_replace(',', '', $value['monto']);
            }
        }

        if ($total > $this->efectivoCaja())
        {
            Gasto::destroy($gasto->get_id());

            return Response::json(array(
                'success' => false,
                'msg' => "No se puede ingresar un gasto en efectivo mayor al efectivo que tiene en caja..!"
            ));
        }

        foreach (Input::get('detalle') as $key => $value) {
            $dg = new DetalleGasto;
            $dg->gasto_id = $gasto->get_id();
            $dg->categoria_id = $value['categoria_id'];
            $dg->subcategoria_id = $value['subcategoria_id'];
            $dg->metodo_pago_id = $value['metodo_pago_id'];
            $dg->descripcion = $value['descripcion'];
            $dg->monto = str_replace(',', '', $value['monto']);
            $dg->save();
        }

        return Response::json(array(
            'success' => true,
            'msg' => "Gasto ingresado"
        ));
    }


    public function delete()
    {
        $delete = DetalleGasto::destroy(Input::get('id'));

        if ($delete)
            return 'success';

        return 'Huvo un error al tratar de eliminar';
    }


    public function efectivoCaja()
    {
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $datos['fecha_inicial'] = CierreCaja::whereCajaId($caja->id)->max('created_at');
        $datos['fecha_final'] = Carbon::now();
        $datos['caja_id'] = $caja->id;

        $cajaController = new CajaController;
        $data = $cajaController->resumen_movimientos($datos);
        $efectivo = 0; // se inicializa en cero para que no de error si todos los datos estan vacios
        $efectivo += $data['soporte']['efectivo'];
        $efectivo += $data['pagos_ventas']['efectivo'];
        $efectivo += $data['abonos_ventas']['efectivo'];
        $efectivo += $data['ingresos']['efectivo'];
        $efectivo += $data['adelanto']['efectivo'];
        $efectivo -= $data['gastos']['efectivo'];
        $efectivo -= $data['egresos']['efectivo'];
        $efectivo -= $data['devolucion']['efectivo'];

        return $efectivo;
    }
}
