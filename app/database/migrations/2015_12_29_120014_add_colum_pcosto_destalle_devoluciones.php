<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumPcostoDestalleDevoluciones extends Migration {

	public function up()
	{
		Schema::table('devoluciones_detalle', function($table)
		{
		    $table->decimal('ganancias', 8, 2)->default(0.00);
		});
	}

	public function down() { }

}
