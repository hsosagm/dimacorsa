<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumPlanCajasTableTiendas extends Migration {

	public function up()
	{
		Schema::table('tiendas', function($table)
		{
			$table->tinyInteger('plan')->default(3);
			$table->tinyInteger('cajas')->default(1);
		});
	}

	public function down()
	{

	}

}