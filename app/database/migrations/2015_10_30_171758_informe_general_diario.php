<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InformeGeneralDiario extends Migration {

	public function up()
	{
		Schema::create('informe_general_diario', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('inversion', 8, 2);
			$table->decimal('cuentas_cobrar', 8, 2);
			$table->decimal('cuentas_pagar', 8, 2);
			$table->timestamps();
		});

	}

	public function down()
	{
		Schema::drop('informe_general_diario');
	}
}
