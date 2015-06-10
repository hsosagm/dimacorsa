<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleEgresosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_egresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->decimal('monto', 8, 2);
			$table->integer('egreso_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();

			$table->foreign('egreso_id')->references('id')->on('egresos')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_egresos');
	}

}
