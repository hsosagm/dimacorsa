<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_ingresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->decimal('monto', 8, 2);
			$table->integer('ingreso_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->timestamps();

			$table->foreign('ingreso_id')->references('id')->on('ingresos')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_ingresos');
	}

}
 