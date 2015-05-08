<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDetalleDescargasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detalle_descargas', function(Blueprint $table)
		{
			$table->integer('descarga_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->primary(array('descarga_id','producto_id'));
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->timestamps();

			$table->foreign('descarga_id')->references('id')->on('descargas')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('detalle_descargas');
	}

}
