<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableNotasCreditos extends Migration {
	public function up()
	{
		Schema::create('notas_creditos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('caja_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned();
			$table->decimal('monto', 8, 2)->default(0.00);
			$table->decimal('descuento_sobre_saldo', 8, 2)->default(0.00);
			$table->boolean('estado')->default(0);
			$table->integer('venta_id')->nullable();
			$table->string('tipo');
			$table->text('nota')->nullable();

			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		}); 

		Schema::create('detalle_nota_credito', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('nota_credito_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->text('serials')->nullable();
			$table->timestamps();
			$table->foreign('nota_credito_id')->references('id')->on('notas_creditos')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('detalle_nota_credito');
		Schema::drop('notas_creditos');
	}

}
