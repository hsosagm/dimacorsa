<?php

use \NEkman\ModelLogger\Contract\Logable;

class DetalleAbonosCompra extends \BaseModel  implements Logable{
	
	protected $table = 'detalle_abonos_compra';

	protected $guarded = array('id');
	
	public function getLogName()
    {
        return $this->id;
    }
}
