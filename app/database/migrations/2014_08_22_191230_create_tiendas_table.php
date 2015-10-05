<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiendasTable extends Migration {

	public function up()
	{
		Schema::create('tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50)->unique();
			$table->string('direccion');
			$table->string('telefono', 50);
			$table->tinyInteger('status');
			$table->integer('limite_cajas')->default(1);
			$table->integer('limite_usuarios')->default(2);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tiendas');
	}
}
