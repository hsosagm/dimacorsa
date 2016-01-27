<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetodoPagoTable extends Migration {

	public function up()
	{
		Schema::create('metodo_pago', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->timestamps();
		});

		DB::table('metodo_pago')->insert(array(
            array('id' => 1, 'descripcion' => 'Efectivo'),
            array('id' => 2, 'descripcion' => 'Credito'),
            array('id' => 3, 'descripcion' => 'Cheque'),
            array('id' => 4, 'descripcion' => 'Tarjeta'),
            array('id' => 5, 'descripcion' => 'Deposito'),
            array('id' => 6, 'descripcion' => 'Nota de credito'),
            array('id' => 7, 'descripcion' => 'Descuento sobre saldo'),
        ));
	}

	public function down()
	{
		Schema::drop('metodo_pago');
	}
}
