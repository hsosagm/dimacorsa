<?php

class Devolucion extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'devoluciones';

    public function devolucion_detalle()
    {
        return $this->hasMany('DevolucionDetalle');
    }

	public function devolucion_pagos()
    {
        return $this->hasMany('DevolucionPago');
    }

    public function cliente()
    {
        return $this->belongsTo('Cliente');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
