<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumAbonoTableVentas extends Migration {

	public function up()
	{
		Schema::table('ventas', function($table)
		{
		    $table->integer('abono')->default(0);
		});
	}

	public function down()
	{

	}
}
