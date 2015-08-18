<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotificacion extends Migration {

	public function up()
	{
		Schema::create('notificaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tienda_id')->unsigned();
			$table->string('correo');
			$table->string('notificacion');
			$table->timestamps();
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		}); 
	}

	public function down()
	{
		Schema::drop('notificaciones');
	}
}
