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

    public function getAdelantos() {
        return Response::json(array(
            'success' => true,
            'table'   => View::make('adelantos.adelantos')->render()
        ));
    }

    public function DTadelantos() 
    {
        $table = 'adelantos';

        $columns = array(
            "adelantos.created_at as fecha",
            "CONCAT_WS(' ', users.nombre, users.apellido) as usuario",
            "clientes.nombre as cliente",
            "adelantos.descripcion as descripcion",
            "adelantos.total as total"
        );

        $Search_columns = array("users.nombre", "users.apellido", "clientes.nombre", "adelantos.descripcion");
        $Join = "JOIN users ON (users.id = adelantos.user_id) JOIN clientes ON (clientes.id = adelantos.cliente_id)";
        $where = ' adelantos.tienda_id = '. Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }

    public function getDetalleAdelantos()
    {
        $adelanto = Adelanto::with('pagos')->find(Input::get('adelanto_id'));
            
        return Response::json(array(
            'success' => true,
            'table'   => View::make('notas_creditos.detalleAdelanto',compact('adelanto'))->render())
        );
    }
}
