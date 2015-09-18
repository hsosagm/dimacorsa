<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColumVistaUser extends Migration {

	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->string('vista');
		});
	}

	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn('vista');
		});
	}
}
