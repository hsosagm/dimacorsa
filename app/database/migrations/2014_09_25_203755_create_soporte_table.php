<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoporteTable extends Migration {

	public function up()
	{ 
		Schema::create('soporte_estados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('estado');
			$table->timestamps();
		});

		Schema::create('soporte', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('soporte_estado_id')->unsigned()->default(1);
			$table->integer('caja_id')->default(0);
			$table->date('fecha_entrega')->nullable();
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('soporte_estado_id')->references('id')->on('soporte_estados')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('soporte_espera', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('soporte_id')->unsigned();
			$table->string('descripcion');
			$table->timestamps();
			$table->foreign('soporte_id')->references('id')->on('soporte')->onDelete('cascade')->onUpdate('cascade');
		});

		Schema::create('detalle_soporte', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->decimal('monto', 8, 5);
			$table->integer('soporte_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();
			$table->foreign('soporte_id')->references('id')->on('soporte')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});

		DB::table('soporte_estados')->insert(array(
            array('id' => 1, 'estado' => 'Espera'),
            array('id' => 2, 'estado' => 'Proceso'),
            array('id' => 3, 'estado' => 'Finalizado'),
            array('id' => 4, 'estado' => 'Entregado'),
            array('id' => 5, 'estado' => 'Pendiente'),
        ));
	}

	public function down()
	{
		Schema::drop('detalle_soporte');
		Schema::drop('soporte_espera');
		Schema::drop('soporte');
		Schema::drop('soporte_estados');
	}

}
