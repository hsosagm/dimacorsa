<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleAbonosVentasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_abonos_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('abonos_ventas_id')->unsigned();
			$table->integer('venta_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();

			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('abonos_ventas_id')->references('id')->on('abonos_ventas')->onDelete('cascade')->onUpdate('cascade');
			
		});
	} 


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_abonos_ventas');
	}

}
