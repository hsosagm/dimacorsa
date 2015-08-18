<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriasTable extends Migration {

	public function up()
	{
		Schema::create('categorias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50);
			$table->timestamps();
		});

		Schema::create('sub_categorias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('categoria_id')->unsigned();
			$table->string('nombre');
			$table->timestamps();
			$table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('sub_categorias');
		Schema::drop('categorias');
	}
}
