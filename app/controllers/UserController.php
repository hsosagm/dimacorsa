<?php

use App\Validators\UserValidator;
use Zizaco\Entrust\EntrustRole;

class UserController extends Controller {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function index()
	{
		return View::make('user.index');
	}

	public function users()
	{
		$table = 'users';

		$columns = array("username","nombre","apellido","email","tienda_id","status");

		$Searchable = array("username","nombre","apellido","email","tienda_id","status");
		
		echo TableSearch::get($table, $columns, $Searchable);
	}
	
	public function create()
	{
		if (Input::has('_token'))
		{
			if ($this->user->_create())
			{
				$tema = new Tema;
				$tema->user_id = $this->user->get_id();
				$tema->save();

				$role = EntrustRole::find(3);
				$user = $this->user->find($this->user->get_id());
				$user->attachRole( $role );

				return 'success';
			}
			else
			{
				return $this->user->errors();
			}
		}

		return View::make('user.create');
	}

	public function edit_profile()
	{

		if (Input::has('_token'))
		{
			$user = $this->user->find(Input::get('id'));

			if ( $user->_update() )
			{
				return 'success';
			}
			else
			{
				return $user->errors();
			}
		}

		return View::make('user.profile');
	}


	public function edit()
	{
		$user_id = Input::get('id');

		$assigned = $this->assigned($user_id);

		$no_assigned = $this->no_assigned($user_id);

		$user = $this->user->find($user_id);

		return View::make('user.edit', compact('assigned' , 'no_assigned', 'user'));
	}


	public function remove_role()
	{
		$user_id = Input::get('user_id');

		$user = $this->user->find($user_id);
		$user->detachRole(Input::get('role_id'));

		$assigned = $this->assigned($user_id);

		$no_assigned = $this->no_assigned($user_id);

		$user = $this->user->find($user_id);

		return View::make('user.edit', compact('user' , 'no_assigned', 'assigned'));

	}

	public function add_role()
	{
		$user_id = Input::get('user_id');

		$role = EntrustRole::find(Input::get('role_id'));
		$user = $this->user->find($user_id);
		$user->attachRole( $role );

		$assigned = $this->assigned($user_id);

		$no_assigned = $this->no_assigned($user_id);

		$user = $this->user->find($user_id);

		return View::make('user.edit', compact('user' , 'no_assigned', 'assigned'));

	}


	public function delete()
	{
		$user = $this->user->destroy(Input::get('id'));

		if ($user)
		{
			return 'success';
		}

		return 'error';
	}


	public function assigned($user_id)
	{
		$assigned = Assigned_roles::where('user_id', $user_id)
		->join('roles', 'assigned_roles.role_id', '=', 'roles.id')->get();

		return $assigned;
	}


	public function no_assigned($user_id)
	{
		$user_role = Assigned_roles::where('user_id','=',Auth::user()->id)->where('role_id','=',1)->first();
		if ($user_role) 
		{
			$no_assigned = EntrustRole::whereNotIn('id', function($query) use ($user_id)
			{
				$query->select(DB::raw('role_id'))->from('assigned_roles')->whereRaw("user_id = ?", array($user_id));
			})->lists('name', 'id');

			return $no_assigned; 
		}

		$no_assigned = EntrustRole::whereNotIn('id', function($query) use ($user_id)
		{
			$query->select(DB::raw('role_id'))->from('assigned_roles')->whereRaw("user_id = ?", array($user_id));
		})->where('id','!=',1)->lists('name', 'id');

		return $no_assigned; 
	}


	//area de consultas para el usuario

	public function VerTablaVentasDelDiaUsuario()
	{
		$factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'garantia')->first();

		return View::make('user_consulta.VentasDelDia',compact('factura','garantia'));
	}

	public function VerTablaSoporteDelDiaUsuario()
	{
		return View::make('user_consulta.SoporteDelDia');
	}

	public function VerTablaIngresosDelDiaUsuario()
	{
		return View::make('user_consulta.IngresosDelDia');
	}

	public function VerTablaEgresosDelDiaUsuario()
	{
		return View::make('user_consulta.EgresosDelDia');
	}

	public function VerTablaGastosDelDiaUsuario()
	{
		return View::make('user_consulta.GastosDelDia');
	}

	public function VerTablaAdelantosDelDiaUsuario()
	{
		return View::make('user_consulta.AdelantosDelDia');
	}

	public function VerTablaClientesUsuario()
	{
		return View::make('user_consulta.Clientes');
	}


//**********************************************************************************************************************
//Consultas del Usuario
//**********************************************************************************************************************
	public function VentasDelDiaUsuario_dt()
	{
		
		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha", 
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"total",
			"saldo",
			"completed"
			);
 
		$Search_columns = array("users.nombre","users.apellido","clientes.nombre");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND ventas.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function SoporteDelDiaUsuario()
	{
		$table = 'detalle_soporte';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"soporte.created_at as fecha",
			"detalle_soporte.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN soporte ON (soporte.id = detalle_soporte.soporte_id) 
		JOIN users ON (users.id = soporte.user_id)
		JOIN tiendas ON (tiendas.id = soporte.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_soporte.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND soporte.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );
	}

	public function IngresosDelDiaUsuario()
	{
		$table = 'detalle_ingresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"ingresos.created_at as fecha",
			"detalle_ingresos.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN ingresos ON (ingresos.id = detalle_ingresos.ingreso_id) 
		JOIN users ON (users.id = ingresos.user_id)
		JOIN tiendas ON (tiendas.id = ingresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_ingresos.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND ingresos.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
		
	}

	public function EgresosDelDiaUsuario()
	{
		$table = 'detalle_egresos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"egresos.created_at as fecha",
			"detalle_egresos.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN egresos ON (egresos.id = detalle_egresos.egreso_id) 
		JOIN users ON (users.id = egresos.user_id)
		JOIN tiendas ON (tiendas.id = egresos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_egresos.metodo_pago_id)";

		$where = " 
		DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND egresos.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	public function GastosDelDiaUsuario()
	{
		$table = 'detalle_gastos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"gastos.created_at as fecha",
			"detalle_gastos.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN gastos ON (gastos.id = detalle_gastos.gasto_id) 
		JOIN users ON (users.id = gastos.user_id)
		JOIN tiendas ON (tiendas.id = gastos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_gastos.metodo_pago_id)";

		$where = "
		DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND gastos.tienda_id =".Auth::user()->tienda_id;
		
		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );		
	}

	public function AdelantosDelDiaUsuario()
	{
		$table = 'detalle_adelantos';

		$columns = array(
			"tiendas.nombre as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"adelantos.created_at as fecha",
			"detalle_adelantos.descripcion as detalle_descripcion",
			'monto',
			"metodo_pago.descripcion as metodo_descripcion"
			);

		$Searchable = array("users.nombre","users.apellido");

		$Join = "JOIN adelantos ON (adelantos.id = detalle_adelantos.adelanto_id) 
		JOIN users ON (users.id = adelantos.user_id)
		JOIN tiendas ON (tiendas.id = adelantos.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = detalle_adelantos.metodo_pago_id)";

		$where = "
		DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;
		$where .= " AND adelantos.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}
	
	public function clientes()
	{
		$table = 'clientes';

		$columns = array(
			"CONCAT_WS(' ',nombre,apellido) as cliente",
			"direccion","telefono","nit");

		$Searchable = array("nombre","direccion","telefono");

		echo TableSearch::get($table, $columns, $Searchable);
	}

	public function VentasAlCreditoUsuario()
	{
		$ventas = DB::table('ventas')
        ->select(DB::raw("ventas.id,
        	ventas.total,
        	ventas.created_at as fecha, 
            CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
            cliente.nombre as cliente,
            saldo"))
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where('saldo', '>', 0)
        ->where('ventas.user_id', '=', Auth::user()->id)
        ->orderBy('fecha', 'ASC')
        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('ventas.creditSales', compact('ventas'))->render()
        ));
	}
}

