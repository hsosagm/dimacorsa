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
			$table->decimal('diferencia_inversion', 10, 2);
			$table->decimal('diferencia_cobrar', 10, 2);
			$table->decimal('diferencia_pagar', 10, 2);
			$table->timestamps();
		});

		DB::table('informe_general')->insert(array(
            array(
            	'id' => 1,
             	'diferencia_inversion' => 0, 
             	'diferencia_pagar' => 0,
             	'diferencia_cobrar' => 0,
            ),
        ));

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

		DB::table('informe_inversion')->insert(array(
            array(
            	'id' => 1,
            	'informe_general_id' => 1,
             	'ventas' => 0, 
             	'compras' => 0,
             	'descargas' => 0,
             	'traslados' => 0,
             	'esperado' => 0,
             	'real' => 0,
            ),
        ));

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

		DB::table('informe_cuentas_por_cobrar')->insert(array(
            array(
            	'id' => 1,
            	'informe_general_id' => 1,
             	'creditos' => 0, 
             	'abonos' => 0,
             	'esperado' => 0,
             	'real' => 0,
            ),
        ));

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

		DB::table('informe_cuentas_por_pagar')->insert(array(
            array(
            	'id' => 1,
            	'informe_general_id' => 1,
             	'creditos' => 0, 
             	'abonos' => 0,
             	'esperado' => 0,
             	'real' => 0,
            ),
        ));
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
