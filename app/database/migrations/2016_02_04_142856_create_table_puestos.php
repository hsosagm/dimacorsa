<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePuestos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puestos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('descripcion');
			$table->timestamps();
		});

		DB::table('puestos')->insert(array(
            array('id' => 1, 'descripcion' => 'Propietario'),
            array('id' => 2, 'descripcion' => 'Gerente general'),
            array('id' => 3, 'descripcion' => 'Ejecutivo de ventas'),
            array('id' => 4, 'descripcion' => 'Soporte tecnico'),
        ));


		Schema::table('users', function($table)
		{
			$table->integer('puesto_id')->unsigned()->default(3);
			$table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puestos');
	}

}
 