<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvDetalleAbonosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prov_abonos_detalle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('prov_abono_id')->unsigned();
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->string('nota')->nullable();
			$table->timestamps();

			$table->foreign('prov_abono_id')->references('id')->on('prov_abonos')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('prov_abonos_detalle');
	}

}
