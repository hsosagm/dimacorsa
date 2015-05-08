<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClienteDetalleAbonosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_detalle_abonos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_abono_id')->unsigned();
			$table->integer('venta_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('cliente_abono_id')->references('id')->on('cliente_abonos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('restrict')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cliente_detalle_abonos');
	}

}
