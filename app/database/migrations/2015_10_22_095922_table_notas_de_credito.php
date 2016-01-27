<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableNotasDeCredito extends Migration {

	public function up()
	{
		Schema::create('notas_creditos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('estado')->default(0);
			$table->integer('venta_id')->nullable();
			$table->string('tipo');
			$table->string('tipo_id');
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('notas_creditos');
	}

}
