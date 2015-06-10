<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClienteContacto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	 	Schema::create('cliente_contacto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->string('nombre');
			$table->string('apellido');
			$table->string('direccion');
			$table->string('telefono1');
			$table->string('telefono2');
			$table->string('celular');
			$table->string('correo');
			$table->string('numero');
			$table->integer('preferido');
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
		}); 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente_contacto');
	}

}
