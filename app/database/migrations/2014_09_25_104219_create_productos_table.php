<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('categoria_id')->unsigned();
			$table->integer('marca_id')->unsigned();
			$table->integer('sub_categoria_id');
			$table->string('codigo', 50);
			$table->string('descripcion');
			$table->decimal('existencia',8,2)->default(0.00);
			$table->decimal('p_costo', 8, 2);
			$table->decimal('p_publico', 8, 2);
			$table->integer('inactivo');
			
			$table->timestamps();

			$table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('marca_id')->references('id')->on('marcas')->onDelete('restrict')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('productos');
	}

}
