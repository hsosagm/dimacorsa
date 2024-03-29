<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipoCliente extends Migration {

	public function up()
	{
		Schema::create('tipo_cliente', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->timestamps();
		});

		DB::table('tipo_cliente')->insert(array(
            array('id' => 1, 'nombre' => 'Cliente individual'),
        ));
	}

	public function down()
	{
		Schema::drop('tipo_cliente');
	}
}
