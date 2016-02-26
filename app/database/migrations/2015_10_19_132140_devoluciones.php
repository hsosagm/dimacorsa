<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Devoluciones extends Migration {

	public function up()
	{
		Schema::create('devoluciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('cliente_id')->unsigned();
			$table->integer('venta_id')->unsigned();
			$table->decimal('total', 8, 2)->default(0.00);
			$table->integer('caja_id')->default(0);
			$table->string('observaciones')->nullable();
			$table->boolean('completed')->default(0);
			$table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('devoluciones_detalle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('devolucion_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->decimal('ganancias', 11, 5)->default(0.00);
			$table->text('serials')->nullable();
			$table->timestamps();

			$table->foreign('devolucion_id')->references('id')->on('devoluciones')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('devoluciones_pagos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('devolucion_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('devolucion_id')->references('id')->on('devoluciones')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('devoluciones_pagos');
		Schema::drop('devoluciones_detalle');
		Schema::drop('devoluciones');
	}
}
