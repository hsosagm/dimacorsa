<?php

class GastoController extends \BaseController {

    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function create()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));

            if (Input::get('metodo_pago_id') == 1)
                if (Input::get('monto') > $this->efectivoCaja())
                    return "No se puede ingresar un gasto en efectivo mayor al efectivo que tiene en caja..!";

            $detalleGasto = new DetalleGasto;

            if ($detalleGasto->_create())
                return Response::json(array('success' => true, 'detalle' => $this->table->detail($detalleGasto, 'gasto_id', 'user/gastos/delete_detail')));

            return $detalleGasto->errors();
        }

        $gasto = new Gasto;
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data = Input::all();

        if (Auth::user()->tienda->cajas)
            $data['caja_id'] = $caja->id;

        if (!$gasto->create_master($data))
            return $gasto->errors();

        $id = $gasto->get_id();

        $message = 'Gasto ingresado';

        $name = 'gasto_id';

        return View::make('gastos.create', compact('id', 'message', 'name'));
    }

    public function delete()
    {
        return $this->delete_detail();
    }

    public function delete_detail()
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
