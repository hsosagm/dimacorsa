<?php
use \NEkman\ModelLogger\Contract\Logable;

class Proveedor extends \BaseModel implements Logable{

	protected $table = 'proveedores';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
