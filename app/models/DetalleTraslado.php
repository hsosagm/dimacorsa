<?php

class DetalleCompra extends \BaseModel{

	protected $table = 'detalle_traslados';

	protected $guarded = array('id');

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }

    public function traslados()
    {
        return $this->belongsTo('Traslado');    
    }
}
