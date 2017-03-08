<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProveedoresProductos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('productos', function($table)
		{
			 $table->integer('proveedor1')->nullable()->default(0);
			 $table->integer('proveedor2')->nullable()->default(0);
			 $table->integer('proveedor3')->nullable()->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
