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
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));
            
            $query = new DetalleSoporte;

            if ($query->_create())
            {
                $href = 'user/soporte/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'soporte_id', $href )));
            }

            return $query->errors();
        }

        $soporte = new Soporte;
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data = Input::all();
        $data['caja_id'] = $caja->id;

        if (!$soporte->create_master($data))
        {
            return $soporte->errors();
        }

        $id = $soporte->get_id();

        $message = 'Soporte ingresado';

        $name = 'soporte_id';

        return View::make('soporte.create', compact('id', 'message', 'name'));

    }

    public function delete()
    {
        return $this->delete_detail();
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
}
