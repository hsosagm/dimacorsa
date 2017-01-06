<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGastosTable extends Migration {

	public function up()
	{
		Schema::create('gastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->integer('caja_id')->default(0);
			$table->integer('categoria_id')->unsigned();
            $table->integer('subcategoria_id')->unsigned();
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('categoria_id')->references('id')->on('gastosCategorias')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('subcategoria_id')->references('id')->on('gastosSubcategorias')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_gastos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('gasto_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->string('descripcion', 100);
			$table->decimal('monto', 8, 2);
			$table->timestamps();
			$table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('detalle_gastos');
		Schema::drop('gastos');
	}
}
