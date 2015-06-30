<?php

class EgresoController extends \BaseController {

    public function __construct(Table $table)
    {
        $this->table = $table;
    } 

     public function create()
    {
        if (Input::has('_token'))
        {
            $query = new DetalleEgreso;
            
            if ($query->_create())
            {
                $href = 'user/egresos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'egreso_id', $href )));
            }

            return $query->errors();
        }

        $egreso = new Egreso;

        if (!$egreso->create_master())
        {
            return $egreso->errors();
        }

        $id = $egreso->get_id();

        $message = 'Egreso ingresado';

        $name = 'egreso_id';

        return View::make('egresos.create', compact('id', 'message', 'name'));

    }

    public function delete_detail()
    {
        $delete = DetalleEgreso::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return  'Huvo un error al tratar de eliminar' ;
    }

    public function OpenTableExpendituresDay()
    {
        return View::make('egresos.ExpendituresDay');
    }

    function ExpendituresDay_dt(){

        $table = 'egresos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "egresos.created_at as fecha",
            "detalle_egresos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN detalle_egresos ON (egresos.id = detalle_egresos.egreso_id) 
        JOIN users ON (users.id = egresos.user_id)
        JOIN tiendas ON (tiendas.id = egresos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }
}
 