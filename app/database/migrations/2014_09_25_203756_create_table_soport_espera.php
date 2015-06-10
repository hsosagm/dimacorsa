<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSoportEspera extends Migration {

	public function up()
	{
		Schema::create('soporte_espera', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('soporte_id')->unsigned();
			$table->string('descripcion');
			$table->timestamps();

			$table->foreign('soporte_id')->references('id')->on('soporte')->onDelete('cascade')->onUpdate('cascade');
		});
	} 

	public function down()
	{
		Schema::drop('soporte_espera');
	}

}
