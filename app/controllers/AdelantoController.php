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
}
 