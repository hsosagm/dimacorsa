<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50)->unique();
			$table->string('direccion');
			$table->string('telefono', 50);
			$table->tinyInteger('status');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		Schema::drop('tiendas');
	}

}
