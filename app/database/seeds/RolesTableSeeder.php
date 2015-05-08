<?php

class RolesTableSeeder extends Seeder {

	public function run()
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


	    $user = User::where('username','=','propietario')->first();

	    $user->attachRole( $owner );


	    $user = User::where('username','=','administrador')->first();

	    $user->attachRole( $admin );


	    $user = User::where('username','=','usuario')->first();

	    $user->attachRole( $usuario );


	    $manageProductos = new Permission;
	    $manageProductos->name = 'manage_productos';
	    $manageProductos->display_name = 'Manage productos';
	    $manageProductos->save();

	    $manageUsers = new Permission;
	    $manageUsers->name = 'manage_users';
	    $manageUsers->display_name = 'Manage Users';
	    $manageUsers->save();

	    $ingresarVentas = new Permission;
	    $ingresarVentas->name = 'ingresar_ventas';
	    $ingresarVentas->display_name = 'Ingresar Ventas';
	    $ingresarVentas->save();

	    $owner->perms()->sync(array($manageProductos->id,$manageUsers->id, $ingresarVentas->id));
	    $admin->perms()->sync(array($manageProductos->id, $ingresarVentas->id));
	    $usuario->perms()->sync(array($ingresarVentas->id));
	}
	
}
