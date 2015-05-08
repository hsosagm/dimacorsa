<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$users = [
		            [
		                'username' => 'propietario',
		                'nombre' => 'Propietario',
		                'apellido' => 'Propietario',
		                'email' => 'propietario@gmail.com',
		                'password' => Hash::make('owner'),
		                'tienda_id' => 1,
		                'status' => 1
		            ],
		            [
		                'username' => 'leonel',
		                'nombre' => 'Leonel',
		                'apellido' => 'Madrid',
		                'email' => 'leonel.madridio@hotmail.com',
		                'password' => Hash::make('12345'),
		                'tienda_id' => 1,
		                'status' => 1
		            ],
		            [
		                'username' => 'administrador',
		                'nombre' => 'Administrador',
		                'apellido' => 'Administrador',
		                'email' => 'administrador@gmail.com',
		                'password' => Hash::make('admin'),
		                'tienda_id' => 1,
		                'status' => 1
		            ],
		            [
		                'username' => 'usuario',
		                'nombre' => 'Usuario',
		                'apellido' => 'Usuario',
		                'email' => 'usuario@gmail.com',
		                'password' => Hash::make('usuario'),
		                'tienda_id' => 1,
		                'status' => 1
		            ],
		        ];

        foreach($users as $user){
            User::create($user);
        }
	}

}
