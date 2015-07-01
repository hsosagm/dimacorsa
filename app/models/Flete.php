<?php

use \NEkman\ModelLogger\Contract\Logable;

class Flete extends Eloquent  implements Logable{
	
	protected $table = 'fletes';

	protected $guarded = array('id');
	
	public function getLogName()
    {
        return $this->id; 
    }
}