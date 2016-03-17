<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('tienda_id')->unsigned();
			$table->decimal('total', 8, 2)->default(0.00);
			$table->string('observaciones')->nullable();
			$table->boolean('completed')->default(0);
			$table->boolean('kardex')->default(0);
			$table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('tienda_id')->references('id')->on('tiendas')->onDelete('restrict')->onUpdate('cascade');
		});

		Schema::create('kits_detalle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('kits_id')->unsigned();
			$table->integer('producto_id')->unsigned();
			$table->integer('cantidad')->unsigned();
			$table->decimal('precio', 11, 5);
			$table->timestamps();

			$table->foreign('kits_id')->references('id')->on('kits')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kits_detalle');
		Schema::drop('kits');
	}

}
