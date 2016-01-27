<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdelantosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('adelantos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tienda_id')->unsigned()->default(1);
			$table->integer('user_id')->unsigned();
			$table->integer('caja_id')->default(0);
			$table->text('descripcion');
			$table->decimal('saldo', 8, 2)->default(0.00);
			$table->decimal('total')->default(0.00);
			$table->boolean('completed')->default(0);
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('adelantos_detalle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('adelanto_id')->unsigned();
			$table->integer('producto_id')->default(0);
			$table->text('descripcion');
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->timestamps();

			$table->foreign('adelanto_id')->references('id')->on('adelantos')->onDelete('cascade')->onUpdate('cascade');
		});

		Schema::create('adelantos_pagos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('adelanto_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('adelanto_id')->references('id')->on('adelantos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('adelantos_pagos');
		Schema::drop('adelantos_detalle');
		Schema::drop('adelantos');
	}

}
