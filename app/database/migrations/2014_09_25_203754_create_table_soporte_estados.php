<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSoporteEstados extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('soporte_estados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('estado');
			$table->timestamps();
		});
	} 

	public function down()
	{
		Schema::drop('soporte_estados');
	}

}
