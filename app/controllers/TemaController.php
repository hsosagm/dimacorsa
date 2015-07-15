<?php

class TemaController extends \BaseController {

	public function colorSchemes($color) 
	{
		 $tema = Tema::where("user_id","=",Auth::user()->id)->first();
		 $tema->colorSchemes = $color;
		 $tema->save();

		return 'Color del tema guardado';
	}

	public function navbarColor($color) 
	{
		$tema = Tema::where("user_id",Auth::user()->id)->first();
		$tema->navbarColor = $color;
		$tema->save();

		return 'Color del la barra superior guardado';
	}

	public function sidebarColor($color) 
	{
		$tema = Tema::where("user_id",Auth::user()->id)->first();
		$tema->sidebarColor = $color;
		$tema->save();

		return 'Color del la barra lateral guardado';
	}

	public function sidebarTypeSetting($tipo)
	{
		$tema = Tema::where("user_id",Auth::user()->id)->first();
		$tema->sidebarTypeSetting = $tipo;
		$tema->save();

		return 'success';
	}
}
