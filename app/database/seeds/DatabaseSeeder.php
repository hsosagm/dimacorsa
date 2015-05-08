<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

      //  $this->call('StatusTableSeeder');
       // $this->command->info('Status table seeded!');

        $this->call('TiendasTableSeeder');
        $this->command->info('Tiendas table seeded!');

		$this->call('UsersTableSeeder');
        $this->command->info('User table seeded!');

        $this->call('RolesTableSeeder');
        $this->command->info('Roles table seeded!');
	}

}
