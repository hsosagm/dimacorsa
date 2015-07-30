<?php

class ConfiguracionController extends \BaseController {

	public function impresora()
	{
		return View::make('configuracion.impresora')->render();
	}
}