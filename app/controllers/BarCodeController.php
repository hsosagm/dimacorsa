<?php

class BarCodeController extends \BaseController {

	public function create()
    {
        if (Session::token() == Input::get('_token'))
        {

            $estilo = BarCode::find(1);

            if ( $estilo->_update() )
            {
                return 'success';
            }
            
            return $estilo->errors();
        }
        $estilo = BarCode::find(1);

        return View::make('barcode.create',compact('estilo'));
    }

    public function print_code()
    {
        $producto = Producto::find(Input::get('id'));
        $estilo = BarCode::find(1);
        $ancho = 2;

        if ($estilo->tipo == 'code39') 
        {
           $ancho = $estilo->ancho/=2;
        }
        
        $data  = array(
            'success' => true,
            'codigo'  => $producto->codigo,
            'tipo'    => $estilo->tipo,
            'ancho'   => $ancho,
            'alto'    => $estilo->alto,
            'letra'   => $estilo->letra
            );

        return Response::json($data);
    }
}
