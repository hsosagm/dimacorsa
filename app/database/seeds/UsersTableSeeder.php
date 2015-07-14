<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$users = [
		            [
		                'username' => 'admin',
		                'nombre' => 'Administrador',
		                'apellido' => 'Sistema',
		                'email' => 'admin@Sistema.com',
		                'password' => 'admin',
		                'status' => 1
		            ]
		        ];

        foreach($users as $user){
            User::create($user);
        }
	}

}
