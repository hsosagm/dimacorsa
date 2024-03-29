<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarcasTable extends Migration {

	public function up()
	{
		Schema::create('marcas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre', 50);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('marcas');
	}
}
