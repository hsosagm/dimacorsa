<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVentasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cliente_id')->unsigned();
            $table->integer('tienda_id')->unsigned()->default(1);
            $table->integer('user_id')->unsigned();
            $table->string('numero_documento', 100);
            $table->decimal('saldo', 8, 2)->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->boolean('completed')->default(0);
            $table->boolean('canceled')->default(0);
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
		}); 
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ventas');
	}

}
