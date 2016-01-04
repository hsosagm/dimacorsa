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

		$columns = array(
			"username",
			"CONCAT_WS(' ', users.nombre, users.apellido) as usuario",
			"tiendas.nombre as tienda",
			"email",
			"users.status as estado");

		$Searchable = array("username","users.nombre","users.apellido","users.email","tiendas.nombre");

		$join =  " LEFT JOIN assigned_roles ON (assigned_roles.user_id = users.id)";
		$join .= " JOIN tiendas ON (users.tienda_id = tiendas.id)";

		if (Auth::user()->hasRole("Admin"))
			$where = " role_id != 1";

		if (Auth::user()->hasRole("Owner"))
			$where = null;

			$GroupBy = " Group By username ";



		echo TableSearch::get($table, $columns, $Searchable, $join, $where, $GroupBy);
	}

	public function buscar()
	{
		return autocompleteFilterTienda::get('users', array('id', 'nombre', 'apellido', 'username'));
	}


	public function create()
	{
		if (Input::has('_token'))
		{
			$data = input::all();
			$data['status'] = 2;

			if ($this->user->_create($data))
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
			$cantidad_usuarios = User::where('status','=',1)->count();
			$tienda = Tienda::find(Auth::user()->tienda_id);

			if (Input::get('status') == 1) {
				if ($cantidad_usuarios >= $tienda->limite_usuarios)
					return "No puede activar mas usuarios porque exede la cantidad de usuarios pagados...!";
			}

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

	public function getConsultarSerie()
	{
		return Response::json(array(
			'success' => true,
			'view' => View::make('user_consulta.consultarSerie')->render(),
			));
	}

	public function setConsultarSerie()
	{
		$detalleCompra = DetalleCompra::select('compra_id', 'producto_id')
		->where('serials', 'LIKE','%'.trim(str_replace("'", '', Input::get('serials'))).'%')
		->join('compras', 'compras.id', '=', 'compra_id')
		->where('tienda_id','=' , Auth::user()->tienda_id)->first();

		$detalleVenta  = DetalleVenta::select('venta_id', 'producto_id')
		->where('serials', 'LIKE','%'.trim(str_replace("'", '', Input::get('serials'))).'%')
		->join('ventas', 'ventas.id', '=', 'venta_id')
		->where('tienda_id','=', Auth::user()->tienda_id)->first();

		return Response::json(array(
			'success' => true,
			'view' => View::make('user_consulta.consultarSerieBody',compact('detalleVenta', 'detalleCompra'))->render(),
			));
	}

	//area de consultas para el usuario

	public function VerTablaVentasDelDiaUsuario()
	{
		$factura = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'factura')->first();

		$garantia = DB::table('printer')->select('impresora')
		->where('tienda_id', Auth::user()->tienda_id)->where('nombre', 'garantia')->first();

		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.VentasDelDia',compact('factura','garantia'))->render()
		));
	}

	public function VerTablaSoporteDelDiaUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.SoporteDelDia')->render()
		));
	}

	public function VerTablaIngresosDelDiaUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.IngresosDelDia')->render()
		));
	}

	public function VerTablaEgresosDelDiaUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.EgresosDelDia')->render()
		));
	}

	public function VerTablaGastosDelDiaUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.GastosDelDia')->render()
		));
	}

	public function VerTablaAdelantosDelDiaUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.AdelantosDelDia')->render()
		));
	}

	public function VerTablaClientesUsuario()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.Clientes')->render()
		));
	}

	public function getConsultarNotasDeCredito()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.consultarNotasDeCredito')->render()
		));
	}

	public function VentasSinFinalizar()
	{
		return Response::json(array(
			'success' => true,
			'table'   => View::make('user_consulta.ventasSinFinalizar')->render()
		));
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
			"completed",
			"canceled"
			);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = " DATE_FORMAT(ventas.created_at, '%Y-%m-%d') > DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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

		$where = " DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  =  DATE_FORMAT(current_date, '%Y-%m-%d')";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = " DATE_FORMAT(detalle_soporte.created_at, '%Y-%m-%d')  > DATE_FORMAT({$fecha}, '%Y-%m-%d')";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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

		$where = " DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  =  DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = " DATE_FORMAT(detalle_ingresos.created_at, '%Y-%m-%d')  > DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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

		$where = " DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  =  DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = " DATE_FORMAT(detalle_egresos.created_at, '%Y-%m-%d')  > DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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

		$where = " DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d') = DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = " DATE_FORMAT(detalle_gastos.created_at, '%Y-%m-%d') > DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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

		$where = "DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  =  DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = "DATE_FORMAT(detalle_adelantos.created_at, '%Y-%m-%d')  >  DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

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
			clientes.nombre as cliente,
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

	public function DtConsultarNotasDeCredito()
	{
		$table = 'notas_creditos';

		$columns = array(
			"notas_creditos.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"tipo",
			"nota",
			"monto",
			"estado"
			);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre", 'tipo', 'monto');

		$Join  = "JOIN users ON (users.id = notas_creditos.user_id) ";
		$Join .= "JOIN clientes ON (clientes.id = notas_creditos.cliente_id) ";
		$Join .= "JOIN adelanto_nota_credito ON (notas_creditos.id = nota_credito_id) ";

		$where = "DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d')  =  DATE_FORMAT(current_date, '%Y-%m-%d') ";
		$where .= " AND users.id =".Auth::user()->id;

		if (trim(Input::get('tipo')) == 'caja')
		{
			$fecha = "'".CierreCaja::where('caja_id','=',Auth::user()->caja_id)->max('created_at')."'";
			$where = "DATE_FORMAT(notas_creditos.created_at, '%Y-%m-%d')  >  DATE_FORMAT({$fecha}, '%Y-%m-%d') ";
			$where .= " AND users.caja_id =".Auth::user()->caja_id;
		}

		$where .= " AND notas_creditos.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function DtVentasSinFinalizar()
	{
		$caja = Caja::whereUserId(Auth::user()->id)->first();

		$table = 'ventas';

		$columns = array(
			"ventas.created_at as fecha",
			"CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
			"clientes.nombre as cliente",
			"total",
			"saldo",
			"completed",
			"canceled"
			);

		$Search_columns = array("users.nombre","users.apellido","clientes.nombre");

		$Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

		$fecha = "'".CierreCaja::where('caja_id','=',$caja->id )->max('created_at')."'";

		$where = " DATE_FORMAT(ventas.updated_at, '%Y-%m-%d') >= DATE_FORMAT({$fecha}, '%Y-%m-%d') ";

		$where .= " AND ventas.completed = 2 ";

		$where .= " AND ventas.tienda_id =".Auth::user()->tienda_id;

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}
}
