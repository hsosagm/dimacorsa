<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiasCreditoProClien extends Migration {

	public function up()
	{
		Schema::table('proveedores', function($table)
		{
		    $table->integer('dias_credito')->default(0);
		});

		Schema::table('clientes', function($table)
		{
		    $table->integer('dias_credito')->default(0);
		});
	}

	public function down()
	{
	}

}
 