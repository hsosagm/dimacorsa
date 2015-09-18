<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCajasPorTienda extends Migration {

	public function up()
	{
		Schema::create('cajas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
			$table->string('nombre');
	
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		}); 

		Schema::create('cierre_caja', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('caja_id')->unsigned();
			$table->decimal('efectivo_esp', 8, 2);
			$table->decimal('cheque_esp', 8, 2);
			$table->decimal('tarjeta_esp', 8, 2);
			$table->decimal('deposito_esp', 8, 2);
			$table->decimal('efectivo', 8, 2);
			$table->decimal('cheque', 8, 2);
			$table->decimal('tarjeta', 8, 2);
			$table->decimal('deposito', 8, 2);
			$table->text('nota');
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('caja_id')->references('id')->on('cajas')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('cierre_caja');
		Schema::drop('cajas');
	}

}
