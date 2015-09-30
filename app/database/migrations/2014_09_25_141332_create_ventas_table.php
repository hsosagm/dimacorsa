<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVentasTable extends Migration {

	public function up()
	{
		Schema::create('ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
            $table->integer('tienda_id')->unsigned()->default(1);
            $table->integer('user_id')->unsigned();
            $table->integer('caja_id');
            $table->decimal('saldo', 8, 2)->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->boolean('completed')->default(0);
            $table->boolean('canceled')->default(0);
            $table->boolean('kardex')->default(0);
			$table->timestamps();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		}); 

		Schema::create('detalle_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('venta_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 8, 2);
			$table->decimal('ganancias', 8, 2)->default(0.00);
			$table->text('serials')->nullable();
			$table->timestamps();
			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('pagos_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('venta_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->timestamps();
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('pagos_ventas');
		Schema::drop('detalle_ventas');
		Schema::drop('ventas');
	}

}
