<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagosVentasTable extends Migration {

	public function up()
	{
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
	}
}
