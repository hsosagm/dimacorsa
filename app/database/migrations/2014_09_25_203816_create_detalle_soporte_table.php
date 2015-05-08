<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleSoporteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_soporte', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->decimal('monto', 8, 2);
			$table->integer('soporte_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->timestamps();

			$table->foreign('soporte_id')->references('id')->on('soporte')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_soporte');
	}

}
