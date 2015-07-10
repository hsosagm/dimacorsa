<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DisparadorExistenciaTotal extends Migration {

	public function up()
 	{

        DB::unprepared('
        CREATE TRIGGER calculated_total_exist AFTER INSERT ON `existencias` FOR EACH ROW
        BEGIN
         UPDATE productos SET 
         	existencia = (SELECT sum(existencia) from existencias where producto_id = NEW.producto_id )
         	WHERE id = NEW.producto_id;
   
        END
        ');
 	}


 	public function down()
 	{
  			DB::unprepared('DROP TRIGGER `calculated_total_exist`');
 	}

}
