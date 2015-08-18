<?php

class DetalleCompra extends \BaseModel {

	protected $table = 'detalle_compras';

	protected $guarded = array('id');

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }

    public function compra()
    {
        return $this->belongsTo('Compra');    
    }
}
