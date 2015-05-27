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
}
 