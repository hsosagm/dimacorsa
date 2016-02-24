<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePromociones extends Migration {

	public function up()
	{
		Schema::create('promociones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->unsigned();
			$table->integer('precio_venta_id')->unsigned();
			$table->decimal('p_promocion', 8, 5
				);
			$table->date('fecha_inicio');
			$table->date('fecha_fin');
			$table->timestamps();
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('precio_venta_id')->references('id')->on('precio_venta')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('promocion_cliente', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('precio_venta_id')->unsigned();
			$table->integer('tipo_cliente_id')->unsigned();
			$table->decimal('porcentaje', 8, 5);
			$table->timestamps();
			$table->foreign('precio_venta_id')->references('id')->on('precio_venta')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('tipo_cliente_id')->references('id')->on('tipo_cliente')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('promocion_cliente');
		Schema::drop('promociones');
	}
}
