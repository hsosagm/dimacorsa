<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProveedorContactos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	 	Schema::create('proveedor_contacto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('proveedor_id')->unsigned();
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

			
			$table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
		}); 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
