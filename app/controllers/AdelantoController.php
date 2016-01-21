<?php

class AdelantoController extends \BaseController {

    public function create()
    {
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $adelanto = new Adelanto;
        $adelanto->cliente_id = Input::get('cliente_id');
        $adelanto->total = Input::get('totalAdelanto');
        $adelanto->descripcion = Input::get('descripcion');
        $adelanto->completed = 1;
        $adelanto->user_id = Auth::user()->id;
        $adelanto->tienda_id = Auth::user()->tienda_id;
        $adelanto->caja_id = $caja->id;
        $adelanto->save();

        $adelanto_id = $adelanto->id;
        
        $nc = new NotaCredito;
        $nc->cliente_id =Input::get('cliente_id');
        $nc->tienda_id = Auth::user()->tienda_id;
        $nc->user_id = Auth::user()->id;
        $nc->tipo = 'adelanto';
        $nc->tipo_id = $adelanto_id;
        $nc->monto = Input::get('totalAdelanto');
        $nc->save();        

        foreach (Input::get("detallePagos") as $dp) {
            $adelantoPago = new AdelantoPago;
            $adelantoPago->adelanto_id = $adelanto_id;
            $adelantoPago->monto = $dp["monto"];
            $adelantoPago->metodo_pago_id = $dp["metodo_pago_id"];
            $adelantoPago->save();
        }

        return Response::json(["success" => true ]);
    }

    public function detalle()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

            $query = new AdelantoDetalle;

            $data = Input::all();

            if (Input::get('producto_id') > 0)
            {
                $producto = Producto::find(Input::get('producto_id'));
                $data['descripcion'] = $producto->descripcion;
            }

            else
                $data['producto_id'] = 0;

            if ( !$query->_create($data))
                return $query->errors();

            $detalle = $this->getAdelantoDetalle();

            $detalle = json_encode($detalle);

            $totalAdelanto = AdelantoDetalle::select(DB::raw('sum(precio * cantidad) as total'))->first();

            $adelanto = Adelanto::find(Input::get('adelanto_id'));
            $adelanto->total = $totalAdelanto->total;
            $adelanto->save();

            return Response::json(array(
                'success' => true,
                'table'   => View::make('adelantos.detalle_body', compact('detalle'))->render()
            ));
        }

        return 'Token invalido';
    }

    public function getAdelantoDetalle()
    {
        $detalle = DB::table('adelantos_detalle')
        ->select(array(
            'adelantos_detalle.id',
            'adelanto_id', 
            'producto_id',
            'cantidad',
            'precio',
            'adelantos_detalle.descripcion AS descripcion',
            DB::raw('cantidad * precio AS total')))
        ->where('adelanto_id', Input::get('adelanto_id'))
        ->get();

        return $detalle;
    }

    /*public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function create()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));

            $query = new DetalleAdelanto;

            if ($query->_create())
            {
                $href = 'user/adelantos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'adelanto_id', $href )));
            }

            return $query->errors();
        }

        $adelanto = new Adelanto;

        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data = Input::all();
        $data['caja_id'] = $caja->id;

        if (!$adelanto->create_master($data))
        {
            return $adelanto->errors();
        }

        $id = $adelanto->get_id();

        $message = 'Adelanto ingresado';

        $name = 'adelanto_id';

        return View::make('adelantos.create', compact('id', 'message', 'name'));
    }

    public function delete()
    {
        return $this->delete_detail();
    }

    public function delete_detail()
    {
        $delete = DetalleAdelanto::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    } */
}
