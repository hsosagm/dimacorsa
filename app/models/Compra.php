<?php
use \NEkman\ModelLogger\Contract\Logable;

class Compra extends \BaseModel implements Logable{

	protected $table = 'compras';
	
	protected $guarded = array('id');

	public function detalle_compra()
    {
        return $this->hasMany('DetalleCompra');    
    }

    public function getLogName()
    {
        return $this->id;
    }
}
