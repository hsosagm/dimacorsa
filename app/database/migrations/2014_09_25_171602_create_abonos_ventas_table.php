<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbonosVentasTable extends Migration {

	public function up()
	{
		Schema::create('abonos_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->integer('cliente_id')->unsigned();
			$table->integer('caja_id')->unsigned();
			$table->decimal('monto', 8, 2)->default(0.00);
			$table->string('observaciones')->nullable();
			$table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('caja_id')->references('id')->on('cajas')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_abonos_ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('abonos_ventas_id')->unsigned();
			$table->integer('venta_id')->unsigned();
			$table->decimal('monto', 8, 2);
			$table->timestamps();
			$table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('abonos_ventas_id')->references('id')->on('abonos_ventas')->onDelete('cascade')->onUpdate('cascade');
			
		});
	}

	public function down()
	{
		Schema::drop('detalle_abonos_ventas');
		Schema::drop('abonos_ventas');
	}
}
