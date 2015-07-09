<?php

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});

Route::filter('csrf', function()
{
	if (Input::has('_token')) {
		if (Session::token() != Input::get('_token'))
		{
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
});

/** Roles de Administrador , Propietario  y Usuario para verificar el login **/
Entrust::routeNeedsRole( '/'   ,  array('Owner','Admin','User') , Redirect::to('/logIn'), false );

/** Roles de Administrador , Propietario  y Usuario **/
Entrust::routeNeedsRole( 'user/*'   ,  array('Owner','Admin','User') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'cliente'  ,  array('Owner','Admin','User') , Redirect::to('/'), false );

/** Roles de Administrador y Propietario **/
Entrust::routeNeedsRole( 'admin/*'     , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'proveedor'   , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/users' , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/user/*', array('Owner','Admin') , Redirect::to('/'), false );

/** Roles del Propietario **/
Entrust::routeNeedsRole( 'owner/chart/*'  , array('Owner') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/soporte/*', array('Owner') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/gastos/*' , array('Owner') , Redirect::to('/'), false );

