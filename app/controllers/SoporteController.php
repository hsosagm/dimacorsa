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
}
