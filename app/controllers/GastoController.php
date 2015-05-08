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

    public function delete_detail()
    {
        $delete = DetalleGasto::destroy(Input::get('id'));

        if ($delete)
        {
            return 'success';
        }

        return 'Huvo un error al tratar de eliminar';
    }

}
 