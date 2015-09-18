<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumCajaUser extends Migration {

	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->integer('caja_id')->default(0);
		});
	}

	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn('caja_id');
		});
	}

}
