<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTheme extends Migration {

	public function up()
	{
		Schema::create('tema', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('colorSchemes')->default('default');
			$table->string('sidebarColor')->default('dark');
			$table->string('navbarColor')->default('dark');
			$table->string('sidebarTypeSetting')->default('sidebar-circle');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		}); 

		DB::table('tema')->insert(array(
            array('id' => 1, 'user_id' => 1),
        ));
	}

	public function down()
	{
		Schema::drop('tema');
	}

}
