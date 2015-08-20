<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Disparadores extends Migration {

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

		DB::unprepared('
	        CREATE TRIGGER calculated_total_exist_update  AFTER UPDATE  ON `existencias` FOR EACH ROW
	        BEGIN
	         UPDATE productos SET 
	         	existencia = (SELECT sum(existencia) from existencias where producto_id = NEW.producto_id )
	         	WHERE id = NEW.producto_id;
	        END
        ');

        DB::unprepared("
    		CREATE TRIGGER create_existencias_tienda AFTER INSERT ON `tiendas`
    		FOR EACH ROW BEGIN
    			DECLARE v_finished INTEGER DEFAULT 0;
    			DECLARE _producto_id INTEGER;
    		    
    		    DECLARE loop_productos CURSOR FOR SELECT id  from productos;
    		    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
    
    		OPEN loop_productos;
    		    loop_new: LOOP
    		        FETCH  FROM loop_productos INTO _producto_id;
    		        IF v_finished = 1 THEN
    		            LEAVE loop_new;
    		        END IF;
    		            INSERT INTO existencias (tienda_id , producto_id) VALUES (NEW.id , _producto_id);
    		    END LOOP loop_new;
    		CLOSE loop_productos;

     		END
     	");
	}

	public function down()
	{
		DB::unprepared('DROP TRIGGER `calculated_total_exist`');
		DB::unprepared('DROP TRIGGER `calculated_total_exist_update`');
		DB::unprepared('DROP TRIGGER `create_existencias_tienda`');
	}
}
