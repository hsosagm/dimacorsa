<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDescargasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descargas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->string('descripcion')->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_descargas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('descarga_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->decimal('cantidad', 8, 2);
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
		Schema::drop('descargas');
	}

}
