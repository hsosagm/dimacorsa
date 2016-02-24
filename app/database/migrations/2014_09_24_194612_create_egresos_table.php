<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEgresosTable extends Migration {

	public function up()
	{
		Schema::create('egresos', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('tienda_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('caja_id')->default(0);
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_egresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->decimal('monto', 11, 5);
			$table->integer('egreso_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();
			$table->foreign('egreso_id')->references('id')->on('egresos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('detalle_egresos');
		Schema::drop('egresos');
	}
}
