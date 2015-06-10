<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('tienda_id')->unsigned()->default(1);
	        $table->string('username', 15)->unique();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->tinyInteger('status')->default(1);
            $table->string('remember_token')->nullable();
			$table->timestamps();

			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
