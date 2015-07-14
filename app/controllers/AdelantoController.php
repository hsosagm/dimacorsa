<?php

class AdelantoController extends \BaseController {

    public function __construct(Table $table)
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

        if (!$adelanto->create_master())
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
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
        JOIN users ON (users.id = adelantos.user_id)
        JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";
        $where .= ' AND adelantos.tienda_id = '.Auth::user()->tienda_id;


        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }

    public function AdelantosPorFecha()
    {
         return View::make('adelantos.AdelantosPorFecha');
    }

    public function AdelantosPorFecha_dt()
    {
        $fecha    = Input::get('fecha');
        $consulta = Input::get('consulta');

        $where = null;

        if ($consulta == 'dia') 
            $where = "DATE_FORMAT(adelantos.created_at, '%Y-%m-%d') = DATE_FORMAT('{$fecha}', '%Y-%m-%d')";

        if ($consulta == 'semana') 
            $where = " WEEK(adelantos.created_at) = WEEK('{$fecha}')  AND YEAR(adelantos.created_at) = YEAR('{$fecha}')  ";

        if ($consulta == 'mes') 
            $where = "DATE_FORMAT(adelantos.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";

        if ($where == null)
            $where = "DATE_FORMAT(adelantos.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date+1, '%Y-%m-%d')";
        
        $table = 'detalle_adelantos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "adelantos.created_at as fecha",
            "detalle_adelantos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $where .= ' AND adelantos.tienda_id = '.Auth::user()->tienda_id;
        
        $Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
        JOIN users ON (users.id = adelantos.user_id)
        JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }

}
 