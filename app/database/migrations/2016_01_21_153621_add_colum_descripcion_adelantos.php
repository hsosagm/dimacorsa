<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumDescripcionAdelantos extends Migration {

	public function up()
	{
		Schema::table('adelantos', function($table)
		{
		    $table->string('descripcion');
		});
	}
	public function down()
	{
	}

}
