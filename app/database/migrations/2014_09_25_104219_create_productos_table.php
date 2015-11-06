<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductosTable extends Migration {

	public function up()
	{
		Schema::create('productos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('categoria_id')->unsigned();
			$table->integer('sub_categoria_id');
			$table->integer('marca_id')->unsigned();
			$table->integer('precio_venta_id')->default(1)->unsigned();
			$table->string('codigo', 50);
			$table->string('descripcion',100);
			$table->integer('existencia')->default(0);
			$table->integer('p_costo');
			$table->decimal('p_publico', 8, 2);
			$table->integer('stock_minimo')->default(0);
			$table->integer('inactivo'); 

			$table->timestamps();

			$table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('marca_id')->references('id')->on('marcas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('precio_venta_id')->references('id')->on('precio_venta')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('productos');
	}
}
