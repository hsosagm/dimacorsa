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
            Input::merge(array('monto' => str_replace(',', '', Input::get('monto'))));
            
            $query = new DetalleIngreso;
           
            if ($query->_create())
            {
                $href = 'user/ingresos/delete_detail';

                return Response::json(array('success' => true, 'detalle' => $this->table->detail($query, 'ingreso_id', $href )));
            }

            return $query->errors();
        }

        $ingreso = new Ingreso;
        $caja = Caja::whereUserId(Auth::user()->id)->first();

        $data = Input::all();
        $data['caja_id'] = $caja->id;

        if (!$ingreso->create_master($data))
        {
            return $ingreso->errors();
        }

        $id = $ingreso->get_id();

        $message = 'Ingreso ingresado';

        $name = 'ingreso_id';

        return View::make('ingresos.create', compact('id', 'message', 'name'));

    }

    public function delete()
    {
        return $this->delete_detail();
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
 