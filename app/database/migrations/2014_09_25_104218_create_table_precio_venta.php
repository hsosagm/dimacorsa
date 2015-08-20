<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrecioVenta extends Migration {

	public function up()
	{
		Schema::create('precio_venta', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('precio_venta');
	}
}
