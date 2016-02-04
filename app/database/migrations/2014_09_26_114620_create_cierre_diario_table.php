<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCierreDiarioTable extends Migration {

	public function up()
	{
		Schema::create('cierre_diario', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->decimal('efectivo_esp', 8, 2);
			$table->decimal('cheque_esp', 8, 2);
			$table->decimal('tarjeta_esp', 8, 2);
			$table->decimal('deposito_esp', 8, 2);
			$table->decimal('efectivo', 8, 2);
			$table->decimal('cheque', 8, 2);
			$table->decimal('tarjeta', 8, 2);
			$table->decimal('deposito', 8, 2);
			$table->text('nota');
			$table->timestamps('fecha_inicial');
			$table->timestamps('fecha_final');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('cierre_diario');
	}
}
