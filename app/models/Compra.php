<?php

class Compra extends \BaseModel {

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
    
    public function proveedor()
    {
        return $this->belongsTo('Proveedor');    
    }
}
