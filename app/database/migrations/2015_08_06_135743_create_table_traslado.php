<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTraslado extends Migration {

	public function up()
	{
		Schema::create('traslados', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('tienda_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('tienda_id_destino')->unsigned();
            $table->integer('user_id_recibido')->nullable();
            $table->decimal('total', 8, 5)->default(0.00);
            $table->boolean('recibido')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('kardex')->default(0);
            $table->text('nota');
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id_destino')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_traslados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('traslado_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad');
			$table->decimal('precio', 8, 5);
			$table->text('serials');
			$table->timestamps();
			$table->foreign('traslado_id')->references('id')->on('traslados')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		chema::drop('detalle_traslados');
		Schema::drop('traslados');
	}

}
