<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetodoPagoTable extends Migration {

	public function up()
	{
		Schema::create('metodo_pago', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('metodo_pago');
	}
}
