<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleGastosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_gastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('gasto_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->string('descripcion', 100);
			$table->decimal('monto', 7, 2);
			$table->timestamps();

			$table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_gastos');
	}

}
