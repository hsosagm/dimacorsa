<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdelantosTable extends Migration {

	public function up()
	{
		Schema::create('adelantos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_adelantos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('adelanto_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->string('descripcion', 100);
			$table->decimal('monto', 7, 2);
			$table->timestamps();
			$table->foreign('adelanto_id')->references('id')->on('adelantos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('detalle_adelantos');
		Schema::drop('adelantos');
	}
}
