<?php

class HomeController extends \BaseController {

    public function login()
    {
        return View::make('logins.login');
    }


    public function validate_phone()
    {

        $credentials = array(
            'username'  => strtolower(Input::get('username')),
            'password'  => Input::get('password'),
            'status' => 1
        );

        $rememberMe = Input::get('rememberme');
        
        if(Auth::attempt($credentials, $rememberMe))
        {
            $user = User::find(Auth::user()->id);
       
            if (Auth::user()->hasRole("Owner"))
                $user->vista = 'Owner';

            else if (Auth::user()->hasRole("Admin")) 
                $user->vista = 'Admin';

            else if (Auth::user()->hasRole("User")) 
                $user->vista = 'User';

            else
                $user->vista = 'Default';

            $user->caja_id = 0;
            
            $user->save();

            return Redirect::to('/');
        }

        $user = User::where('username','=', Input::get('username'))->first();

        if ($user)
        {
            if ($user->status == 2)
            {
               return 'usuario inactivo..'; // inactive user
            }

            return 'password incorrecto...'; // incorrect password
        }

        return 'username incorrecto..'; // incorrect username


    }

    public function validate()
    {
        $credentials = array(
            'username'  => strtolower(Input::get('username')),
            'password'  => Input::get('password'),
            'status' => 1
        );

        $rememberMe = Input::get('rememberme');
        
        if(Auth::attempt($credentials, $rememberMe))
        {
            $user = User::find(Auth::user()->id);
       
            if (Auth::user()->hasRole("Owner"))
                $user->vista = 'Owner';

            else if (Auth::user()->hasRole("Admin")) 
                $user->vista = 'Admin';

            else if (Auth::user()->hasRole("User")) 
                $user->vista = 'User';

            else
                $user->vista = 'Default';

            $user->caja_id = 0;
            
            $user->save();

            return 'success';
        }

        $user = User::where('username','=', Input::get('username'))->first();

        if ($user)
        {
            if ($user->status == 2)
            {
               return 0; // inactive user
            }

            return 2; // incorrect password
        }

        return 1; // incorrect username
    }


    public function index()
    {
        if (!Auth::check()) return Redirect::to('logIn');

        $clientes = DB::table('clientes')->count();

        return View::make('layouts.master', compact('clientes'));
    }


    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->caja_id = 0;
        $user->save();
        
        Auth::logout();

        return Redirect::to('logIn')->with('message', 'Su session ha sido cerrada.');
    }
}
