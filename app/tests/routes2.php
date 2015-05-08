<?php

tooltip: {
    shared: false,
    formatter: function() {
        var text = '';
        if(this.series.name == 'Soporte') {
            text = this.point.name+' '+'de'+' '+this.point.year+'<br/>'+'<b>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</b>';
        } else {
            text = this.point.dia;
        }
        return text;
    }
},

Route::get('/', function()
{
	return View::make('main');
});

Route::get('login', function()
{

return View::make('login');

});

Route::get('logout', function()
{
    Auth::logout();
    return Redirect::to('login');
});

Route::get('admin', array('before' => 'auth', function()
{
	if(Auth::check()){
    return View::make('admin');
    }
	return View::make('login');

}));

// Route::post('user/create', function()
// {
// 	if (Request::ajax())
// 	{
// 	    return 'ajax Request';
// 	}
// 	else {
// 		return 'no ajax Request';
// 	}
// });


Route::post('admin', function(){

    // if(Request::ajax()){

	   $credentials = array(
	   'email' => Input::get('username'),
	   'password' => Input::get('password') 
	    );

	   if(Auth::attempt($credentials, Input::get('remember', 0)))
	    {

	   	    return View::make('admin');

	    }
	    else
	    {
	      $msg = array("El nombre de usuario o password no son correctos");
	      return Response::json(array(
	      'success' => false,
	      'errors' => $msg,
	      'message'         =>     'Error de logeo'
	      ));

	    } 
    // }
});


Route::get('nombre', function()
{
	$producto = Producto::all();

	return $producto;

});

Route::get('Gilder_y_kelly', function()
{
	return 'Juntos por siempre';

});


Route::get('usertable', function()
{
	Schema::create('users', function($table)
	{
		$table->engine = 'InnoDB';
	    $table->increments('id');
	    $table->string('nombre');
	    $table->string('password');
	    $table->string('email')->unique();
	    $table->string('remember_token');
	    $table->string('updated_at');
	    $table->string('created_at');

	});
	return 'Tabla creada';
});


Route::get('create_user', function()
{
	$user = new User;
	$user->nombre = 'Kelly';
	$user->password = Hash::make('11111');
	$user->email = 'kelly@hotmail.com';
	$user->save();

	if ($user){
		return 'usuario creado';
	}
	else {
		return 'uvo un error';
	}

});


Route::get('start', function()
{

$admin = Role::where('name','=','Admin')->first();

$user = User::where('username','=','kellross')->first();

$user->attachRole( $admin );
return 'ok';

});


	public function search(){

		$term = trim(Input::get('term'));
		$term = preg_replace('/\s+/', ' ', $term);
		$a_json = array();
		$parts = explode(' ', $term);
		$p = count($parts);
		 
		$sql = 'SELECT id, nombre, data  FROM clienteview WHERE id is not null';
		for($i = 0; $i < $p; $i++) {
		    $sql .= ' AND nombre LIKE ' . "'%" . $parts[$i] . "%'";
		}

		$search = DB::select($sql);

		foreach ($search as $user) {
			  $json["id"] = $user->id;
			  $json["value"] = $user->nombre;
			  $json["label"] = $user->nombre;
			  $json["cust_data"] = $user->data;
			  array_push($a_json, $json);
		}

	    $a_json = apply_highlight($a_json, $parts);
		$json = json_encode($a_json);
		print $json;
	}