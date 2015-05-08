<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tipo_cliente_id')->default(1)->unsigned();
			$table->string('nombre', 100);
			$table->string('apellido', 100);
			$table->string('direccion');
			$table->string('telefono', 100);
			$table->string('nit', 100);
			$table->string('email', 100);
			$table->timestamps();

			$table->foreign('tipo_cliente_id')->references('id')->on('tipo_cliente')->onDelete('restrict')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}
