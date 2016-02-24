<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosCompras extends Migration {

	public function up()
	{
		Schema::create('abonos_compras', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->integer('metodo_pago_id')->unsigned()->default(1);
			$table->integer('proveedor_id')->unsigned();
			$table->decimal('monto', 11, 5);
			$table->string('observaciones')->nullable();
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('metodo_pago_id')->references('id')->on('metodo_pago')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('detalle_abonos_compra', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('abonos_compra_id')->unsigned();
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 11, 5);
			$table->timestamps();
			$table->foreign('abonos_compra_id')->references('id')->on('abonos_compras')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::drop('abonos_compras');
		Schema::drop('detalle_abonos_compra');
	}
}
