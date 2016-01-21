<?php

class AdelantoPago extends \BaseModel {

	protected $table = 'adelantos_pagos';

	protected $guarded = array('id');

    public function adelanto()
    {
        return $this->belongsTo('Adelanto', 'adelanto_id');    
    }

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
