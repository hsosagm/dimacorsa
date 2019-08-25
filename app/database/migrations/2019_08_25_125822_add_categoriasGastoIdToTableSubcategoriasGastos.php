<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriasGastoIdToTableSubcategoriasGastos extends Migration {

	 public function up()
	 {
	     Schema::table('subcategoriasGastos', function($table) {
	         $table->integer('categoriasGasto_id');
	     });
	 }


	 public function down()
	 {
	     Schema::table('subcategoriasGastos', function($table) {
	         $table->dropColumn('categoriasGasto_id');
	     });
	 }

}
