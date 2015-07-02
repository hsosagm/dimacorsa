<?php

class IngresoController extends \BaseController {

    public function __construct(Table $table)
    {
        $this->table = $table;
    } 

     public function create()
    {
        if (Input::has('_token'))
        {
            $query = new DetalleIngreso;
           
            if ($query->_create())
            {
                $href = 'user/ingresos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'ingreso_id', $href )));
            }

            return $query->errors();
        }

        $ingreso = new Ingreso;

        if (!$ingreso->create_master())
        {
            return $ingreso->errors();
        }

        $id = $ingreso->get_id();

        $message = 'Ingreso ingresado';

        $name = 'ingreso_id';

        return View::make('ingresos.create', compact('id', 'message', 'name'));

    }

    public function delete_detail()
    {
        $delete = DetalleIngreso::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    }

    public function OpenTableIncomeDay()
    {
        return View::make('ingresos.IncomeDay');
    }

    function IncomeDay_dt(){

        $table = 'ingresos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "ingresos.created_at as fecha",
            "detalle_ingresos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN detalle_ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
        JOIN users ON (users.id = ingresos.user_id)
        JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }

    public function IngresosPorFecha()
    {
        return View::make('ingresos.IngresosPorFecha');
    }

    function IngresosPorFecha_dt(){
        
         $fecha    = Input::get('fecha');
        $consulta = Input::get('consulta');

        $where = null;

        if ($consulta == 'dia') 
            $where = "DATE_FORMAT(ingresos.created_at, '%Y-%m-%d') = DATE_FORMAT('{$fecha}', '%Y-%m-%d')";

        if ($consulta == 'semana') 
            $where = " WEEK(ingresos.created_at) = WEEK('{$fecha}')  AND YEAR(ingresos.created_at) = YEAR('{$fecha}')  ";

        if ($consulta == 'mes') 
            $where = "DATE_FORMAT(ingresos.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";

        if ($where == null)
            $where = "DATE_FORMAT(ingresos.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date+1, '%Y-%m-%d')";
        

        $table = 'ingresos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "ingresos.created_at as fecha",
            "detalle_ingresos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN detalle_ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
        JOIN users ON (users.id = ingresos.user_id)
        JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }
}
 