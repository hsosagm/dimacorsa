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

		return Form::select('impresora', $val ,'',array('class' => 'form-control')) ;
	}
}