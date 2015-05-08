<?php
use \NEkman\ModelLogger\Contract\Logable;

class Cliente extends \BaseModel implements Logable{

	protected $table = 'clientes';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
