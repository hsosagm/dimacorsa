<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleAbonosCompras extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_abonos_compra', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('abonos_compra_id')->unsigned();
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('abonos_compra_id')->references('id')->on('abonos_compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
			
		
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_abonos_compra');
	}

}
