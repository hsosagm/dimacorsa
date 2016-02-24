<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardex extends Migration {

	public function up()
	{
		Schema::create('kardex_accion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->timestamps();
		});

		DB::table('kardex_accion')->insert(array(
            array('id' => 1, 'nombre' => 'insert'),
            array('id' => 2, 'nombre' => 'update'),
            array('id' => 3, 'nombre' => 'delete'),
        ));

		Schema::create('kardex_transaccion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->timestamps();
		}); 

		DB::table('kardex_transaccion')->insert(array(
            array('id' => 1, 'nombre' => 'compras'),
            array('id' => 2, 'nombre' => 'ventas'),
            array('id' => 3, 'nombre' => 'descargas'),
            array('id' => 4, 'nombre' => 'traslados'),
            array('id' => 5, 'nombre' => 'devolucion'),
            array('id' => 6, 'nombre' => 'ajuste'),
        ));

		Schema::create('kardex', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('kardex_accion_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('kardex_transaccion_id')->unsigned();
			$table->integer('transaccion_id');
			$table->string('evento');
			$table->integer('cantidad');
			$table->integer('existencia');
			$table->integer('existencia_tienda')->nullable();
			$table->decimal('costo', 8, 5);
			$table->decimal('costo_promedio', 8, 5);
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('kardex_accion_id')->references('id')->on('kardex_accion')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('kardex_transaccion_id')->references('id')->on('kardex_transaccion')->onDelete('restrict')->onUpdate('cascade');
		}); 

		
	}

	public function down()
	{
		Schema::drop('kardex_accion');
		Schema::drop('kardex_transaccion');
		Schema::drop('kardex');
	}
}
