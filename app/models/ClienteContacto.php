<?php
use \NEkman\ModelLogger\Contract\Logable;

class ClienteContacto extends \BaseModel implements Logable{

	protected $table = 'cliente_contacto';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
