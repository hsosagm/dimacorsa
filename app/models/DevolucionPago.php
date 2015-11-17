<?php

class DevolucionPago extends \BaseModel {

	protected $table = 'devoluciones_pagos';

	protected $guarded = array('id');

	public function devolucion()
	{
		return $this->belongsTo('Devolucion');
	}

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
