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

	public function create()
	{
		if (Input::has('_token'))
		{
			if ($this->user->_create())
			{
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
		$no_assigned = EntrustRole::whereNotIn('id', function($query) use ($user_id)
		{
			$query->select(DB::raw('role_id'))->from('assigned_roles')->whereRaw("user_id = ?", array($user_id));
		})->lists('name', 'id');

		return $no_assigned;
	}


	//area de consultas para el usuario

	public function VerTablaVentasDelDiaUsuario()
	{
		return View::make('user_consulta.VentasDelDia');
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

}