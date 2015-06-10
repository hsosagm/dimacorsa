<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleAdelantosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_adelantos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('adelanto_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->string('descripcion', 100);
			$table->decimal('monto', 7, 2);
			$table->timestamps();

			$table->foreign('adelanto_id')->references('id')->on('adelantos')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_adelantos');
	}

}
