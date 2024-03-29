<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriaGastosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categoriasGastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50);
			$table->timestamps();
		});

		Schema::create('subcategoriasGastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcategoriasGastos');
		Schema::drop('categoriasGastos');
	}

}
