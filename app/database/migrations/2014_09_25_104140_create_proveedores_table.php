<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProveedoresTable extends Migration {

	public function up()
	{
		Schema::create('proveedores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 100);
			$table->string('direccion');
			$table->string('nit',50);
			$table->string('telefono', 100);
			$table->integer('dias_credito')->default(30);
			$table->timestamps(); 

		});

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

	public function down()
	{
		Schema::drop('proveedor_contacto');
		Schema::drop('proveedores');
	}
}
