<?php

class AdelantoController extends \BaseController {

    public function __construct(Table $table)
    {
        $this->table = $table;
    } 

     public function create()
    {
        if (Session::token() == Input::get('_token'))
        {
            $query = new DetalleAdelanto;
           
            if ($query->_create())
            {
                $href = 'user/adelantos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'adelanto_id', $href )));
            }

            return $query->errors();
        }

        $adelanto = new Adelanto;

        if (!$adelanto->create_master())
        {
            return $adelanto->errors();
        }

        $id = $adelanto->get_id();

        $message = 'Adelanto ingresado';

        $name = 'adelanto_id';

        return View::make('adelantos.create', compact('id', 'message', 'name'));

    }

    public function delete_detail()
    {
        $delete = DetalleAdelanto::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    }

    public function OpenTableAdvancesDay()
    {
        return View::make('adelantos.AdvancesDay');
    }

    function AdvancesDay_dt(){

        $table = 'detalle_adelantos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "adelantos.created_at as fecha",
            "detalle_adelantos.descripcion as detalle_descripcion",
            "metodo_pago.descripcion as metodo_descripcion",
            'monto');

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
        JOIN users ON (users.id = adelantos.user_id)
        JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";


        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }
}
 