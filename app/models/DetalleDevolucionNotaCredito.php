<?php

class DetalleDevolucionNotaCredito extends \BaseModel {

	protected $table = 'detalle_devolucion_nota_credito';

	protected $guarded = array('id');

	public function devolucionNotaCredito()
	{
		return $this->belongsTo('DevolucionNotaCredito');
	}

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }
}
