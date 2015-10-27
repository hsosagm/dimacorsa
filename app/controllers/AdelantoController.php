<?php

class AdelantoController extends \BaseController {

   public function create()
    {
        if (Input::has('_token'))
        {
            $adelanto = new Adelanto;
            $caja = Caja::whereUserId(Auth::user()->id)->first();

            $data = Input::all();
            $data['caja_id'] = $caja->id;

            if (!$adelanto->create_master($data))
            {
                return $adelanto->errors();
            }

            $adelanto_id = $adelanto->get_id();

            return Response::json(array(
                'success' => true,
                'detalle' => View::make('adelantos.detalle', compact('adelanto_id'))->render()
            ));
        }

        return View::make('adelantos.create');
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
