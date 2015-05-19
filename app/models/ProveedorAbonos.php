<?php

use \NEkman\ModelLogger\Contract\Logable;

class ProveedorAbonos extends Eloquent  implements Logable{
	
	protected $table = 'prov_abonos';

	protected $guarded = array('id');
	
	public function getLogName()
    {
        return $this->id; 
    }
}