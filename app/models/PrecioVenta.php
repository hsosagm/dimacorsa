<?php
use \NEkman\ModelLogger\Contract\Logable;

class PrecioVenta extends \BaseModel implements Logable{

	protected $table = 'precio_venta';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }
}
