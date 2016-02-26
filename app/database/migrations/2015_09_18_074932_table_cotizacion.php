<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCotizacion extends Migration {

	public function up()
	{
		Schema::create('cotizaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
            $table->integer('tienda_id')->unsigned()->default(1);
            $table->integer('user_id')->unsigned();
            $table->decimal('saldo', 8, 2)->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->boolean('completed')->default(0);
			$table->timestamps();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_cotizaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cotizacion_id')->unsigned();
			$table->integer('producto_id')->default(0);
			$table->text('descripcion');
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->timestamps();
			$table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('detalle_cotizaciones');
		Schema::drop('cotizaciones');
	}

}
