<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePrinterConfiguration extends Migration {

	public function up()
	{
		Schema::create('printer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
			$table->string('impresora');
			$table->string('nombre');
			$table->string('margenes');
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		}); 
	}

	public function down()
	{
		Schema::drop('printer');
	}
}
