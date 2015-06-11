<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBarcode extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('barcode', function($table)
		{
			$table->increments('id')->unique();
			$table->string('tipo');
			$table->integer('ancho');
			$table->integer('alto');
			$table->integer('letra');
			$table->string('codigo');
			$table->timestamps();
		});

		$barcode = new BarCode;
        $barcode->id = 1 ;
        $barcode->tipo = 'code128';
        $barcode->ancho = 2;
        $barcode->alto = 40;
        $barcode->letra = 15;
        $barcode->codigo = '12345678910';
        $barcode->save();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('barcode');
	}

}

