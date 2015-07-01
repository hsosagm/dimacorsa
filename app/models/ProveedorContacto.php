<?php
use \NEkman\ModelLogger\Contract\Logable;

class ProveedorContacto extends \BaseModel implements Logable{

	protected $table = 'proveedor_contacto';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
