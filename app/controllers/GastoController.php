<?php

class GastoController extends \BaseController {

    public function __construct(Table $table)
    {
        $this->table = $table;
    } 

     public function create()
    {
        if (Input::has('_token'))
        {
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));
            
            $query = new DetalleGasto;
           
            if ($query->_create())
            {
                $href = 'user/gastos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'gasto_id', $href )));
            }

            return $query->errors();
        }

        $gasto = new Gasto;

        if (!$gasto->create_master())
        {
            return $gasto->errors();
        }

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
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    }

    public function OpenTableExpensesDay()
    {
        return View::make('gastos.ExpensesDay');
    }

    function ExpensesDay_dt(){

        $table = 'detalle_gastos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "gastos.created_at as fecha",
            "detalle_gastos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
        JOIN users ON (users.id = gastos.user_id)
        JOIN tiendas ON (tiendas.id = gastos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";
       
        $where .= ' AND gastos.tienda_id = '.Auth::user()->tienda_id;

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }

    public function GastosPorFecha()
    {
        return View::make('gastos.GastosPorFecha');
    }

    function GastosPorFecha_dt(){
        $fecha    = Input::get('fecha');
        $consulta = Input::get('consulta');

        $where = null;

        if ($consulta == 'dia') 
            $where = "DATE_FORMAT(gastos.created_at, '%Y-%m-%d') = DATE_FORMAT('{$fecha}', '%Y-%m-%d')";

        if ($consulta == 'semana') 
            $where = " WEEK(gastos.created_at) = WEEK('{$fecha}')  AND YEAR(gastos.created_at) = YEAR('{$fecha}')  ";

        if ($consulta == 'mes') 
            $where = "DATE_FORMAT(gastos.created_at, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')";

        if ($where == null)
            $where = "DATE_FORMAT(gastos.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date+1, '%Y-%m-%d')";
        
        $table = 'detalle_gastos';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "gastos.created_at as fecha",
            "detalle_gastos.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $where .= ' AND gastos.tienda_id = '.Auth::user()->tienda_id;
        
        $Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
        JOIN users ON (users.id = gastos.user_id)
        JOIN tiendas ON (tiendas.id = gastos.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );   
    }

}
 