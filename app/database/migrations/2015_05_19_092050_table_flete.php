<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableFlete extends Migration {

	public function up()
	{
		Schema::create('fletes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compra_id')->unsigned();
			$table->decimal('monto', 11, 5);
			$table->string('nota')->nullable();
			$table->timestamps();
			$table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade')->onUpdate('cascade');
		});
	} 

	public function down()
	{
		Schema::drop('fletes');
	}
}
