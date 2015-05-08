<?php
use \NEkman\ModelLogger\Contract\Logable;

class Venta extends \BaseModel implements Logable{

	protected $guarded = array('id');

	protected $table = 'ventas';

	public function getLogName()
    {
        return $this->id;
    }
}
