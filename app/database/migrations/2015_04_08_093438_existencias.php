<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Existencias extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('existencias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->decimal('existencia', 8, 2)->default(0.00);
			$table->timestamps();

			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('existencias');
	}

}
