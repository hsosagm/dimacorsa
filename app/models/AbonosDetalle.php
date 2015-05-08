<?php

use \NEkman\ModelLogger\Contract\Logable;

class AbonosDetalle extends Eloquent  implements Logable{
	
	protected $table = 'prov_abonos_detalle';

	protected $guarded = array('id');
	
	public function getLogName()
    {
        return $this->id;
    }
}
