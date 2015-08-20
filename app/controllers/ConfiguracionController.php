<?php

class ConfiguracionController extends \BaseController {

	public function impresora()
	{
		return View::make('configuracion.impresora')->render();
	}

	public function notificacion()
	{
		if (Input::has('_token'))
		{
			$notificacion = Notificacion::where('tienda_id', '=', Auth::user()->tienda_id)
			->where('notificacion', '=',Input::get('notificacion'))
			->where('correo', '=', Input::get('correo'))->first();

			if($notificacion != null)
				return 'El correo ya esta ingresado para esa Notificacion..';

			$nuevaNotificacion = new Notificacion;
			$nuevaNotificacion->correo = Input::get('correo');
			$nuevaNotificacion->notificacion = Input::get('notificacion');
			$nuevaNotificacion->tienda_id = Auth::user()->tienda_id;
			$nuevaNotificacion->save();

			$correos = Notificacion::where('tienda_id', '=', Auth::user()->tienda_id)->get();

			return Response::json(array(
				'success' => true, 
				'table' => View::make('configuracion.listCorreos',compact('correos'))->render() 
				));
		}

		$correos = Notificacion::where('tienda_id', '=', Auth::user()->tienda_id)->get();
		return View::make('configuracion.notificacion', compact('correos'))->render();
	}

	public function eliminarNotificacion()
	{
		$notificacion = Notificacion::find(Input::get('id'));
		
		if ($notificacion->delete())
            return 'success';
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