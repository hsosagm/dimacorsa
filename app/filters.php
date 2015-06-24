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


Entrust::routeNeedsRole( 'owner*', array('Owner'), Redirect::to('/') );