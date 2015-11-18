<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InformeGeneral extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('informe_general', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
			$table->decimal('diferencia_inversion', 10, 2);
			$table->decimal('diferencia_cobrar', 10, 2);
			$table->decimal('diferencia_pagar', 10, 2);
			$table->timestamps();

			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('informe_inversion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('informe_general_id')->unsigned();
			$table->decimal('ventas', 10, 2);
			$table->decimal('compras', 10, 2);
			$table->decimal('descargas', 10, 2);
			$table->decimal('traslados', 10, 2);
			$table->decimal('esperado', 10, 2);
			$table->decimal('real', 10, 2);
			$table->timestamps();

			$table->foreign('informe_general_id')->references('id')->on('informe_general')->onDelete('cascade')->onUpdate('cascade');
		});

		Schema::create('informe_cuentas_por_cobrar', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('informe_general_id')->unsigned();
			$table->decimal('creditos', 10, 2);
			$table->decimal('abonos', 10, 2);
			$table->decimal('esperado', 10, 2);
			$table->decimal('real', 10, 2);
			$table->timestamps();

			$table->foreign('informe_general_id')->references('id')->on('informe_general')->onDelete('cascade')->onUpdate('cascade');
		});

		Schema::create('informe_cuentas_por_pagar', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('informe_general_id')->unsigned();
			$table->decimal('creditos', 10, 2);
			$table->decimal('abonos', 10, 2);
			$table->decimal('esperado', 10, 2);
			$table->decimal('real', 10, 2);
			$table->timestamps();

			$table->foreign('informe_general_id')->references('id')->on('informe_general')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('informe_inversion');
		Schema::drop('informe_cuentas_por_cobrar');
		Schema::drop('informe_cuentas_por_pagar');
		Schema::drop('informe_general');
	}

}
