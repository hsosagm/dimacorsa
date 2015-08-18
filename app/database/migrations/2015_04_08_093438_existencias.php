<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Existencias extends Migration {

	public function up()
	{
		Schema::create('existencias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('producto_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('existencia')->default(0);
            $table->integer('existencia_real')->nullable();
            $table->integer('ajuste')->nullable();
			$table->tinyInteger('status')->default(0);
            $table->integer('user_id')->nullable();
			$table->timestamps();
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('existencias');
	}
}
