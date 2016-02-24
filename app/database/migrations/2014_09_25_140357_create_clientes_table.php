<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesTable extends Migration {

	public function up()
	{
		Schema::create('clientes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tipo_cliente_id')->default(1)->unsigned();
			$table->string('nombre', 200);
			$table->string('direccion');
			$table->string('telefono', 100);
			$table->string('nit', 100);
			$table->string('email', 100);
			$table->decimal('limite_credito', 8, 2)->default(0.00);
			$table->integer('dias_credito')->default(30);
			$table->timestamps();
			$table->foreign('tipo_cliente_id')->references('id')->on('tipo_cliente')->onDelete('restrict')->onUpdate('cascade');
		});

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

		DB::table('clientes')->insert(array(
            array(
            	'id' => 1, 
            	'nombre' => 'Consumidor Final', 
            	'direccion' => 'Ciudad',
            	'nit' => 'C/F'
            ),
        ));
	}

	public function down()
	{
		Schema::drop('cliente_contacto');
		Schema::drop('clientes');
	}
}
