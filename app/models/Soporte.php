<?php
use \NEkman\ModelLogger\Contract\Logable;

class Soporte extends \BaseModel implements Logable{

	protected $table = 'soporte';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
