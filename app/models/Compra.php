<?php
use \NEkman\ModelLogger\Contract\Logable;

class Compra extends \BaseModel implements Logable{

	protected $table = 'compras';
	
	protected $guarded = array('id');

	public function detalle_compra()
    {
        return $this->hasMany('DetalleCompra');    
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function getLogName()
    {
        return $this->id;
    }

    public function proveedor()
    {
        return $this->belongsTo('Proveedor');    
    }
}
