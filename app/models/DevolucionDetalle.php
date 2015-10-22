<?php

class DevolucionDetalle extends \BaseModel {

	protected $table = 'devoluciones_detalle';

	protected $guarded = array('id');

	public function devolucion()
	{
		return $this->belongsTo('Devolucion');
	}

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }
}
