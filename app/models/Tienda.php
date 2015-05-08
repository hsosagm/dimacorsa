<?php
use \NEkman\ModelLogger\Contract\Logable;

class Tienda extends \BaseModel implements Logable{

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
