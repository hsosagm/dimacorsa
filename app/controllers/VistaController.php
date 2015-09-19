<?php

class VistaController extends \BaseController {

	public function cambiarVistaPuntoDeVenta() {
		$user = User::find(Auth::user()->id);
		$user->vista = "User";
		$user->save();
	}

	public function cambiarVistaAdministardor() {
		$user = User::find(Auth::user()->id);
		$user->vista = "Admin";
		$user->save();
	}

	public function cambiarVistaPropietario() {
		$user = User::find(Auth::user()->id);
		$user->vista = "Owner";
		$user->save();
	}

}
