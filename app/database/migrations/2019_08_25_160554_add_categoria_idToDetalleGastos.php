<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriaIdToDetalleGastos extends Migration {

	public function up()
	{
		Schema::table('detalle_gastos', function($table) {
			$table->integer('categoria_id');
			$table->integer('subcategoria_id');
		});
	}


	public function down()
	{
		Schema::table('detalle_gastos', function($table) {
			$table->dropColumn('categoria_id');
			$table->dropColumn('subcategoria_id');
		});
	}

}
