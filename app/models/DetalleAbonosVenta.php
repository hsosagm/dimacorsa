<?php

use \NEkman\ModelLogger\Contract\Logable;

class DetalleAbonosVenta extends \BaseModel  implements Logable{
	
	protected $table = 'detalle_abonos_ventas';

	protected $guarded = array('id');
    
	public function getLogName()
    {
        return $this->id;
    }
}