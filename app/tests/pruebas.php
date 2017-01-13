<?php

ALTER TABLE `gastos` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(), CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
ALTER TABLE gastos ADD COLUMN `categoria_id` INT(10) UNSIGNED NOT NULL AFTER `caja_id`;
ALTER TABLE gastos ADD COLUMN `subcategoria_id` INT(10) UNSIGNED NOT NULL AFTER `categoria_id`;
UPDATE detalle_gastos SET categoria_id = 1 WHERE 1;
UPDATE detalle_gastos SET subcategoria_id = 1 WHERE 1;

quitar relaciones
ALTER TABLE gastos
DROP COLUMN `categoria_id`;

ALTER TABLE gastos
DROP COLUMN `subcategoria_id`;

alter table `subcategoriasGastos` add column categoriasGasto_id int(10) after nombre

UPDATE `subcategoriasGastos` SET `categoriasGasto_id` = 1 WHERE 1

// TRIGGERS

BEGIN
  UPDATE clickgt.users
     SET name= "jose"
   WHERE ID = NEW.id;
END

    @if(Auth::user()->hasRole("Owner"))

    @endif

// $('#example').dataTable().fnStandingRedraw();
//$ex->ex -= $dv['cant'];

echo get_class( Auth::getFacadeRoot() ); // echos Illuminate\Auth\AuthManager

Input::merge(array('precio' => str_replace(',', '', Input::get('precio'))));

$min = Carbon::createFromFormat('Y-m-d h:i:s', Soporte::first()->created_at);

$query = DB::table('detalle_venta')
    ->select(DB::raw('idventa, sum(cantidad * precio) as total, ganancias'))
    ->where(DB::raw('YEAR(fecha)'), '=', date('Y'))
    ->where(DB::raw('MONTH(fecha)'), '=', 4)
    ->where('ganancias', '>', 0)
    ->groupBy('idventa')
    ->get();

var_dump( $query );

{{ Form::open(array('data-remote-md', 'data-success' => 'Venta Generada')) }}

    {{ Form::hidden('cliente_id') }}

    <div class="row">
        <div class="col-md-6">
            <table>
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <input type="text" id="cliente_id">
                        <i class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                        <i class="fa fa-pencil btn-link theme-c" id="cliente_edit"></i>
                        <i class="fa fa-plus-square btn-link theme-c" id="cliente_create"></i>
                    </td>
                </tr>
                <tr>
                    <td>Factura No.: </td>
                    <td> <input type="text" name="numero"> </td>
                </tr>
                <tr>
                    <td> Fecha de Doc.:</td>
                    <td><input class="date" data-value="2015/03/08" type="text" name="fecha"></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 search-cliente-info"></div>
    </div>

    <div class="form-footer" align="right">
          {{ Form::submit('Ok!', array('class'=>'theme-button')) }}
    </div>

{{ Form::close() }}


<div class="compra-body"></div>


<script>

$(function() {

    $("#cliente_id").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "user/cliente/buscar",
                dataType: "json",
                data: request,
                success: function (data) {
                    response(data);
                },
                error: function () {
                    response([]);
                }
            });
        },
        minLength: 3,
        select:function( data, ui ) {
            $("input[name='cliente_id']").val(ui.item.id);
            $(".search-cliente-info").html('<strong>Direccion:  '+ui.item.descripcion+'</strong><br><strong>Contacto:   '+ui.item.value+'</strong>');

        },
        autoFocus: true,
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 100000);
        }
    });
});

$('.date').pickadate({
  // min: -15,
  max: true,
});

</script>


SELECT * FROM foo WHERE a = 'a'
AND (
    WHERE b = 'b'
    OR WHERE c = 'c'
)
AND WHERE d = 'd'


Foo::where( 'a', '=', 'a' )
    ->where( function ( $query )
    {
        $query->where( 'b', '=', 'b' )
            ->or_where( 'c', '=', 'c' );
    })
    ->where( 'd', '=', 'd' )
    ->get();


Route::get('search', function()
{
    $q = 'Her nandez Hernandez el';

    $searchTerms = explode(' ', $q);

    $query = Cliente::select('id', DB::raw('CONCAT(nombre, " ", apellido) AS full_name'));

    foreach($searchTerms as $term)
    {
        $query = $query->Where(DB::raw('CONCAT(nombre, " ", apellido)'), 'LIKE', '%'. $term .'%');
    }

    $search = $query->take(5)->get();

    $a_json = array();

    foreach ($search as $results => $data) {
        $a_json[] = array(
            'id'    => $data->id,
            'value' => $data->full_name
            );
    }

    echo json_encode($a_json);
});

    public function search()
    {
        $object = new stdClass();

        $object->table   = "productos";
        $object->columns = array("codigo", "descripcion");
        $object->join    = array('marcas', 'productos.marca_id', 'marcas.id');

        return Search::get($object);
    }

Route::get('tables', function() {

    // $tables = DB::select('SHOW TABLES');

    // foreach ($tables as $key => $table) {
    //     echo $table->Tables_in_laravel . '<br>';
    // }

$test = array(
    'username'   => 'Admin',
    'first_name' => 'Admin',
    'last_name'  => 'Admin',
    'email'      => 'admin@gmail.com',
    'password' => Hash::make('admin')
);

return $test['email'];

});

class Foo {

    const TAX = .09; // Global that can not be changed then name chud be uppgercase

    public $completed = false;

    public static function test($name) { //static make it global good when the data dosn it change

        return $name;
    }
}


Route::get('constant', function(){

    echo Foo::TAX;
});


Route::get('clases', function(){

echo Foo::test('gil');

});

// abstract class no se puede instanciar sirve para que nadie la use directamente pero se puede extender de otra clase
// y usar sus funciones y cuando se declara una funcion abstract en la clase base debe crearse esa funcion en la subclase
//throw new Exception();


$columns = DB::connection()
  ->getDoctrineSchemaManager()
  ->listTableColumns('table');

foreach($columns as $column) {
  print $column->getName();
  print $column->getType()->getName();
  print $column->getDefault();
  print $column->getLength();
}


return Response::json(array('success' => true, 'last_insert_id' => $data->id), 200);

// Eloquent collection
    $family = [
        ['name' => 'kelly'],
        ['lastname' => 'Ross']
    ];

    $family = new Illuminate\Database\Eloquent\Collection($family);

    return $family->first();

//make alphaunermic
$database_table_name = preg_replace("/[^a-z0-9_\s-]/", "", $database_table_name);
//Clean multiple dashes or whitespaces
$database_table_name = preg_replace("/[\s-]+/", " ", $database_table_name);


Upon searching and trial and error I accomplished my goal the following way.

I created an Event listener that I for organizational purposes placed in /app/events/database.php

With the following


Event::listen('illuminate.query', function($query, $bindings, $time, $name)
{
  // Code to log query goes here
});

I then placed in my /app/start/global.php the following line

include(app_path().'/events/database.php');

This now captures all requests to query the database using either DB, or Eloquent.



Route::get('test', function() {

    $productos = Producto::with('marca')->find('1003971');

    return json_encode($productos->marca);
});

Route::get('/test', function() {

    $DetalleSoporte = DetalleSoporte::find(114);

    echo $DetalleSoporte->metodoPago->descripcion;

    $producto = Producto::find(1003975);

    echo $producto->marcaa->nombre;

});


$data = Input::all();
$data['confirmation_code'] = md5( uniqid(mt_rand(), true) );
$this->user->create($data);


Route::filter('serviceCSRF',function(){
    if (Session::token() != Request::header('csrf_token')) {
        return Response::json([
            'message' => 'I’m a teapot !!! you stupid hacker :D'
        ], 418);
    }
});

public function __construct()
    {
        $this->beforeFilter('serviceAuth');
        $this->beforeFilter('serviceCSRF');
    }


public function __construct() {
    $this->beforeFilter('csrf', array('on'=>'post'));
    $this->beforeFilter('auth', array('only'=>array('getDashboard')));
}

Route::get('/assing_perm_to_role', function()
{
    $ingresarVentas = Permission::where('name','=','ingresar_ventas')->first();


   $role = Role::where('name','=','User')->first();


    $role->perms()->sync(array($ingresarVentas->id));

    return 'Success!';

});

Route::get('test/pusher/{title}', function($title)
{
    App::make('Pusher')->trigger('demoChannel', 'userPost', ['title' => $title] );

    return $title;
});


$query = DB::table('category_issue')
    ->select(array('issues.*', DB::raw('COUNT(issue_subscriptions.issue_id) as followers')))
    ->where('category_id', '=', 1)
    ->join('issues', 'category_issue.issue_id', '=', 'issues.id')
    ->left_join('issue_subscriptions', 'issues.id', '=', 'issue_subscriptions.issue_id')
    ->group_by('issues.id')
    ->order_by('followers', 'desc')
    ->get();


@if (count($books))
    @foreach($books as $book)
        @include('books.single', $book)
    @endforeach
@else
    <p>No Books exist.</p>
@endif



public static function tableName()
{
    return with(new static)->getTable();
}


@foreach ($users as $user)
  // access user properties here
  @foreach ($user->item as $item)
    // access item properties here.
  @endforeach
@endforeach


$csvFile = 'http://localhost/laravel/public/tablas/producto.csv';
$csvFile = public_path().'/tablas/producto.csv';

@if (count($records))
    @foreach ($records as $record)
        @include('record.item', $record)
    @endforeach
@else
    @include('record.no-items')
@endif



class Meses {

    public function mes() {

        for ($i=0; $i<=12; $i++)
        {
            $dt = Carbon::now()->addMonths($i);

            $months[] = $dt->format('F');

            $meses = $months[$i];

            $mesArray = array(
                'January' => "Enero",
                'February' => "Febrero",
                'March' => "Marzo",
                'April' => "Abril",
                'May' => "Mayo",
                'June' => "Junio",
                'July' => "Julio",
                'August' => "Agosto",
                'September' => "Septiembre",
                'October' => "Octubre",
                'November' => "Noviembre",
                'December' => "Diciembre"
            );

            $mesReturn = $mesArray[$meses];
            $mes[] = $mesReturn;

            }

            echo $mes[0];
    }

}

        $m = App::make('Meses');

        echo $m->mes(0);

$time = Carbon::instance(Auth::user()->created_at)->diffForHumans();
echo "<br>";

$date = str_replace('/', '-', Auth::user()->created_at);
echo CarbonLocale::createFromTimeStamp(strtotime($date))->diffForHumans();

Event::listen('illuminate.query', function($sql){

    var_dump($sql);
});


Route::get('query', function(){

    $date = new DateTime('-1 days');

    echo $date->format('Y-m-d');
});

Route::get('search', function(){

    if ($search = Request::get('q'))
    {
        $user = User::where(function($query) use ($search)
        {
            $query->where('username', 'LIKE', "%$search%")
            ->orWhere('nombre', 'LIKE', "%$search%");
        })->get();
    }
    else
    {
        $user = User::all();
    }
});


public function showWelcome()
{
	 return View::make('hello');
}

		        if(Entrust::hasRole('Owner'))
		        {
		            return View::make('main');
		        }

		        else if(Entrust::hasRole('Admin'))
		        {
		            return View::make('hello');
		        }

		        else {
		            Auth::logout();
		            return Redirect::to('/') ->with('flash_notice', 'You don\'t have access!');
		        }

Route::get('create_user', function()
{
    $user = new User;
    $user->nivel = 1;
    $user->nombre = 'Gilder';
    $user->apellido = 'Hernandez';
    $user->email = 'intelpcventas@hotmail.com';
    $user->password = Hash::make('003210');
    $user->save();

    if ($user){
        return 'usuario creado';
    }
    else {
        return 'uvo un error';
    }

});

Route::get('home', array('before' => 'auth', function()
{
        if(Entrust::hasRole('Owner')) {
            return View::make('home');
        }

        else if(Entrust::hasRole('Admin')) {
            return View::make('hello');
        }

        else {
            Auth::logout();
            return Redirect::to('/') ->with('flash_notice', 'You don\'t have access!');
        }

    return App::abort(403);
}));


Route::post('admin', function(){

    if(Request::ajax()){

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
    }
});

    public function search()
    {
        $object = new stdClass();

        $object->table   = "productos";
        $object->columns = array("codigo", "descripcion");
        $object->join    = array('marcas', 'productos.marca_id', 'marcas.id');

        return Search::get($object);
    }

Route::get('/create', function()
{
        User::create(array(
            'username'   => 'Admin',
            'first_name' => 'Admin',
            'last_name'  => 'Admin',
            'email'      => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ));
        return 'Usuario creado';
});


Route::get('home', array('before' => 'auth', function()
{
    return View::make('home');
}));


Route::get('/start', function()
{
    $owner = new Role;
    $owner->name = 'Owner';
    $owner->save();

    $admin = new Role;
    $admin->name = 'Admin';
    $admin->save();

    $usuario = new Role();
    $usuario->name = 'User';
    $usuario->save();


    $user = User::where('username','=','hsosan1')->first();

    $user->attachRole( $owner );


    $user = User::where('username','=','Admin')->first();

    $user->attachRole( $admin );


    $user = User::where('username','=','Usuario')->first();

    $user->attachRole( $usuario );


    $manageProductos = new Permission;
    $manageProductos->name = 'manage_productos';
    $manageProductos->display_name = 'Manage productos';
    $manageProductos->save();

    $manageUsers = new Permission;
    $manageUsers->name = 'manage_users';
    $manageUsers->display_name = 'Manage Users';
    $manageUsers->save();

    $owner->perms()->sync(array($manageProductos->id,$manageUsers->id));
    $admin->perms()->sync(array($manageProductos->id));

    return 'Success!';

});


    return View::make('blog')->with('posts', $posts);


	$model = User::findOrFail(1);

	$model = User::where('votes', '>', 100)->firstOrFail();


	use Illuminate\Database\Eloquent\ModelNotFoundException;

	App::error(function(ModelNotFoundException $e)
	{
	    return Response::make('Not Found', 404);
	});


	$user = User::find(1);

	$user->delete();

    User::destroy(1, 2, 3);


    public function validate()
    {


    	if(Request::ajax()){

		    $credentials = array(
	            'username'  => strtolower(Input::get('username')),
	            'password'  => Input::get('password')
		    );

		    if(Auth::attempt($credentials))
		    {
			    return 'success';

			} else {
		        echo 'error';
		    }
		}

js
$(document).ready(function() {

    var form = $('#ajaxform');
        form.bind('submit',function (e) {
            e.preventDefault();

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                beforeSend: function(){
                    $(".load").show();
                },
                complete: function(data){
                    $('.load').hide();
                },
                success: function (data) {
                    $(form)[0].reset();
                    window.location='index';
                },
                error: function(errors){
                    $('.load').hide();
                    alert('errors');
                    alert(errors.message);
                }
            });
       return false;
    });

});


## SEED DATABASE


php artisan db:seed --class=UserTableSeeder

class UserTableSeeder extends Seeder {

   public function run()
   {
        $user = User::create(array(
          'username' => 'philipbrown',
          'first_name' => 'Philip',
          'last_name' => 'Brown',
          'email' => 'phil@ipbrown.com',
          'password' => 'qwerty'
        ));
   }

}


Route::get('seed', function()
{
        DB::table('levels')->truncate();

        $levels = [
                    [
                        'name' => 'Propietario'
                    ],
                    [
                        'name' => 'Administrador'
                    ],
                    [
                        'name' => 'Usuario'
                    ],
                ];

        foreach($levels as $level){
            Level::create($level);
        }
});


$resultado = DB::table('carros')->get();

$resultado = DB::table('carros')->count();

$resultado = DB::table('carros')->where('color', '=', 'Verde')->get();

$resultado = DB::table('carros')->where('color', '=', 'Verde')->get(array('id', 'modelo', 'color'));

$resultado = DB::table('carros')->where('color', '=', 'Verde')->first();

$resultado = DB::table('carros')->where('color', '=', 'Verde')->first(array('id', 'modelo', 'color'));

$resultado = DB::table('carros')->where('color', '=', 'Verde')->count();

$resultado = DB::table('carros')->where('color', '=', 'Verde')->max('id');

$resultado = DB::table('carros')->where('color', '=', 'Blanco')->where('modelo','=','Corrolla')->get();

$resultado = DB::table('carros')->where('color', '=', 'Blanco')->orWhere('placa','=','JUH 111')->get();

$resultado = DB::table('carros')->whereBetween('id', array('1', '4'))->get();

$resultado = DB::table('carros')->whereNull('color')->get();

$resultado = DB::table('carros')->orderBy('modelo', 'Desc')->get();

$resultado = DB::table('carros')->groupBy('color')->get(array('color'));

$resultado = DB::table('carros')->take(4)->skip(3)->get();

$resultado = DB::select( DB::raw('SELECT * FROM roles WHERE id = ?'), array(1));

$resultado = DB::select( DB::raw("SELECT * FROM roles WHERE id = :id"), array(
   'id' => 1,
));

$resultado = dd(DB::getQueryLog());


function view($view)
{
    $ms = Person::where('name', '=', 'Foo Bar')->first();

    $persons = Person::order_by('list_order', 'ASC')->get();
    return View::make('users', compact('ms','persons'));
}

return URL::current();

return URL::full();

return URL::previous();

return URL::secureAsset('img/logo.png');

<a href="{{ url('mi/ruta', array('foo', 'bar'), true) }}">Mi ruta</a>
<a href="https://miaplicacion.dev/my/route/foo/bar">Mi ruta</a>

<a href="{{ route('miruta') }}">Mi ruta</a>

<a href="{{ action('MiControlador@miAccion') }}">Mi enlace</a>

<img src="{{ asset('img/logo.png') }}" />

<img src="{{ secure_asset('img/logo.png') }}" />


$resultado = Input::except(array('foo', 'baz'));
var_dump($resultado);

$resultado = Input::except('foo', 'baz');
var_dump($resultado);


Route::get('/', function()
{
    Input::flash();
    return Redirect::to('nueva/peticion');
});

Route::get('nueva/peticion', function()
{
    var_dump(Input::old('bar'));
});

Input::old('primero', 'segundo', 'tercero');
Input::flashOnly('primero', 'segundo', 'tercero');
Input::flashExcept('primero', 'segundo', 'tercero');
Input::old(array('primero', 'segundo', 'tercero'));
Input::flashOnly(array('primero', 'segundo', 'tercero'));
Input::flashExcept(array('primero', 'segundo', 'tercero'));

return Redirect::to('nueva/peticion')->withInput(Input::only('foo'));
return Redirect::to('nueva/peticion')->withInput(Input::except('foo'));


$cookie = Cookie::make('bajas-en-hidratos', 'galleta de almendras', 30);

$cookie = Cookie::get('bajas-en-hidratos');
var_dump($cookie);

'campo' => 'alpha_dash'
'campo' => 'date_format:d/m/y'
'campo' => 'exists:users,usuario'
'campo' => 'different:another_campo'
'campo' => 'regex:[a-z]'
'campo' => 'required_if:usuario,zoidberg'
'campo' => 'same:edad'


$tabla->string('apodo', 128); //varchar(128)
$tabla->text('cuerpo');
$tabla->integer('tamano_zapatos'); //int(11)
$tabla->decimal('tamano'); //decimal(8,2)
$tabla->dateTime('cuando');
$tabla->softDeletes();
$tabla->string('usuario')->unique()->primary();
$tabla->string('nombre')->nullable(false);
$tabla->string('nombre')->default('John Doe');
$tabla->integer('edad')->unsigned();
$tabla->dropColumn('nombre');
$tabla->dropColumn(array('nombre', 'edad'));
$tabla->dropColumn('nombre', 'edad');
$tabla->renombreColumn('nombre', 'apodo');

Schema::dropIfExists('ejemplo');

if (Schema::hasTable('autor')) {

    Schema::create('libros', function($tabla)
    {
        $tabla->increments('id');
    });
}

$tabla->engine = 'InnoDB';


public $timestamps = true;

Album::truncate();

return Album::pluck('artista');

return Album::lists('artista');

Route::get('year', function()
{
return Album::whereNested(function($query)
{
$query->where('year', '>', 2000);
$query->where('year', '<', 2005);
})
->get();
});

return Album::whereIn('artista', $values)->get();
return Album::whereNotIn('artista', $values)->get();
return Album::whereNull('artista')->get();
return Album::whereArtist('Something Corporate')->get();

Route::get('p2', function()
{
$coleccion = Album::all();
var_dump(count($coleccion));
var_dump($coleccion->shift());
var_dump(count($coleccion));
});

$result = $a->merge($b);

var_dump($b->isEmpty());
var_dump( $coleccion->toArray() );
var_dump( $coleccion->toJson() );
$coleccion = Album::all();
var_dump( $coleccion->count() );

$album->artista()->attach(2);


Route::get('/', function()
{
    $artista = new Artista;
    $artista->nombre = 'Eve 6';
    $artista->save();

    $album = new Album;
    $album->nombre = 'Horrorscope';
    $album->artista()->associate($artista);
    $album->save();

    $oyente = new Oyente;
    $oyente->nombre = 'Naruto Uzumaki';
    $oyente->save();
    $oyente->albums()->save($album);

    return View::make('hello');
});

public function store()
{
  $user = User::create();
  $response = Event::fire('user.create', array($user));
}

Event::listen('user.create', function($user)
{
  // Send welcome email

  return false;
});

Event::listen('user.*', function($user)
{
  if (Event::firing() == 'user.update')
  {
    // Send email
  }
});

class MiGestor
{
public function procesar()
{
// Gestionar el evento aquí.
}
}

Event::listen('mi.evento', 'MiGestor@procesar');


class MisGestores
{

    public function primero()
    {
        // First event listener.
    }

    public function segundo()
    {
        // Second event listener.
    }

    public function tercero()
    {
        // Third event listener.
    }

    public function subscribe($eventos)
    {
        $eventos->listen('primer.evento', 'MisGestores@primero');
        $eventos->listen('segundo.evento', 'MisGestores@segundo');
        $eventos->listen('tercer.evento', 'MisGestores@tercero');
    }

}

Event::subscribe(new MisGestores);

Route::get('Cookie', function()
{
    $cookie = Cookie::make('bajas-en-hidratos', 'galleta de almendras', 30);
    return Response::make('Nom nom.')->withCookie($cookie);
});

Route::get('nom-nom', function()
{
$cookie = Cookie::get('bajas-en-hidratos');
$cookie = Cookie::get('bajas-en-hidratos', 'pollo');
var_dump($cookie);
var_dump(Cookie::has('bajas-en-hidratos'));
$cookie = Cookie::forever('bajas-en-hidratos', 'galleta de almendras');
$cookie = Cookie::forget('bajas-en-hidratos');
var_dump(Cookie::has('bajas-en-hidratos'));


});


Route::get('app2', function(){

    $app = app();

    $app['tres'] = 3;

    echo $app['tres'];
});


Route::get('app', function(){

    App::bind('tres', function () {

        return 3;

    });

    echo App::make('tres');
});


Route::get('app3', function(){

    App::singleton('aleatorio', function () {
        return rand();
    });

    var_dump(App::make('aleatorio'));
    var_dump(App::make('aleatorio'));
    var_dump(App::make('aleatorio'));

});


class Algo
{
    public function greet()
    {

    }
}


class Ejemplo
{
    protected $algo;

    public function __construct(Algo $algo)
    {
        $this->algo = $algo;
    }

    public function greet()
    {
        return 'Hello, World!';
    }

}


Route::get('app4', function(){

    $ejemplo = App::make('Ejemplo');

    dd($ejemplo->greet());

});



class Drinkevent extends Eloquent {

    public function participants()
    {
        return $this->belongsToMany('Participant');
    }
}


class Participant extends Eloquent {

    public function drinkevents()
    {
        return $this->belongsToMany('Drinkevent');
    }

    public function drink()
    {
        return $this->belongsToMany('Drink');
    }
}

class Drink extends Eloquent {

    public function participants()
    {
        return $this->belongsToMany('Participant');
    }

}

$drinkevent = Drinkevent::with('participants.drink')->findOrFail($id);

Post::all(['id','name']);

Marca::lists('nombre', 'id');


class LoadDataController extends \Controller {

    public function index()
    {
        DB::table('marcas')->delete();

        function csv_to_array($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;

            $header = NULL;
            $data = array();

            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    if(!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }

            return $data;
        }

        $csvFile = public_path().'/tablas/marca.csv';

        $areas = csv_to_array($csvFile);

        DB::table('marcas')->insert($areas);

        return "success";
    }
}
