<?php

class RolesController extends \Controller {


	public function index()
	{
        return View::make('roles.index');
	}


	public function search()
	{
	    $roles = Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at'));

	    return Datatables::of($roles)

	    ->edit_column('users', '{{{ DB::table(\'assigned_roles\')->where(\'role_id\', \'=\', $id)->count()  }}}')
	    ->add_column('actions', '<a href="javascript:void(0)" id="role_edit" role_id="{{{ $id }}}" class="btn_table btn btn-info"><i class="fa fa-share-square-o"></i> Edit</a>
	                             <a href="javascript:void(0)" id="role_delete" role_id="{{{ $id }}}" class="btn_table btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
	                ')
	    ->remove_column('id')
	    ->make();
	}


	public function edit()
	{
		$role = Role::findOrFail(Input::get('role_id'));

		$permissions = $role->perms()->get();

		return View::make('roles.edit', compact('role', 'permissions'));
	}

}
