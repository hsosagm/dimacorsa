<?php

class ConfiguracionController extends \BaseController {

	public function impresora()
	{
		return View::make('configuracion.impresora')->render();
	}

	public function getImpresoras($im)
	{
		$impresoras = explode(",",substr($im, 0, -1));
		$val = array();

		for ($i=0; $i < count($impresoras); $i++) { 
			$val[$impresoras[$i]] = $impresoras[$i];
		}

		$factura 	 = Form::select('factura', $val ,'',array('class' => 'form-control')) ;
		$garantia 	 = Form::select('garantia', $val ,'',array('class' => 'form-control')) ;
		$comprobante = Form::select('comprobante', $val ,'',array('class' => 'form-control')) ;
		$codigoBarra = Form::select('codigoBarra', $val ,'',array('class' => 'form-control')) ;

		return Response::json(array(
			'factura'     => $factura ,
			'garantia' 	  => $garantia ,
			'comprobante' => $comprobante ,
			'codigoBarra' => $codigoBarra 
			));
	}

	public function saveImpresora()
	{
		if (Session::token() == Input::get('_token'))
		{	
			$factura 	 = Input::get('factura') ;
			$garantia 	 = Input::get('garantia') ;
			$comprobante = Input::get('comprobante') ;
			$codigoBarra = Input::get('codigoBarra') ;

			DB::table('printer')->where('tienda_id', '=', Auth::user()->tienda_id)->delete();

			DB::table('printer')->insert(array(
				array('impresora' => $factura     , 'nombre' => 'factura'     , 'tienda_id' => Auth::user()->tienda_id),
				array('impresora' => $garantia    , 'nombre' => 'garantia'    , 'tienda_id' => Auth::user()->tienda_id),
				array('impresora' => $comprobante , 'nombre' => 'comprobante' , 'tienda_id' => Auth::user()->tienda_id),
				array('impresora' => $codigoBarra , 'nombre' => 'codigoBarra' , 'tienda_id' => Auth::user()->tienda_id),
				));

			return 'success';
		}
	}
}