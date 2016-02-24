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
			$table->integer('limite_usuarios')->default(3);
			$table->timestamps();
		});

		$tienda = new Tienda;
		$tienda->id = 1;
		$tienda->nombre = "Tienda 1";
		$tienda->direccion = "Ciudad";
		$tienda->telefono = "123456";
		$tienda->status = 1;
		$tienda->save();
	}

	public function down()
	{
		Schema::drop('tiendas');
	}
}
