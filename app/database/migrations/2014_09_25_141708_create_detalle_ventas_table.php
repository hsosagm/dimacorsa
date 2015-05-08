<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleVentasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('venta_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->decimal('ganancias', 8, 2)->default(0.00);
			$table->text('serials')->nullable();
			$table->timestamps();

			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('detalle_ventas');
	}

}
