<?php

Route::filter('auth', function()
{
    if (!Auth::check())
    {
        if (Request::ajax())
        {
            return Response::json('Su sesion a expirado favor logearse de nuevo', 401);
        }
        else
        {
            return Redirect::to('logIn');
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
