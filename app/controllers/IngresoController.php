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

}
 