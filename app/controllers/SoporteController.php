<?php

class SoporteController extends BaseController {

    public function __construct(Table $table)
    {
        $this->table = $table;
    }  

    public function create()
    {
        if (Input::has('_token'))
        {
            $query = new DetalleSoporte;

            if ($query->_create())
            {
                $href = 'user/soporte/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'soporte_id', $href )));
            }

            return $query->errors();
        }

        $soporte = new Soporte;

        if (!$soporte->create_master())
        {
            return $soporte->errors();
        }

        $id = $soporte->get_id();

        $message = 'Soporte ingresado';

        $name = 'soporte_id';

        return View::make('soporte.create', compact('id', 'message', 'name'));

    }

    public function delete_detail()
    {
        $delete = DetalleSoporte::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    }
    
    public function OpenTableSupportDay()
    {
        return View::make('soporte.SupportDay');
    }

    function SupportDay_dt(){

        $table = 'soporte';

        $columns = array(
            "tiendas.nombre as tienda_nombre",
            "CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
            "soporte.created_at as fecha",
            "detalle_soporte.descripcion as detalle_descripcion",
            'monto',
            "metodo_pago.descripcion as metodo_descripcion"
            );

        $Searchable = array("users.nombre","users.apellido");

        $Join = "JOIN detalle_soporte ON (soporte.id = detalle_soporte.soporte_id) 
        JOIN users ON (users.id = soporte.user_id)
        JOIN tiendas ON (tiendas.id = soporte.tienda_id)
        JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

        $where = " DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

        echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
    }
}
