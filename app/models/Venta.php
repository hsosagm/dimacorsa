<?php

class Venta extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'ventas';

    public function detalle_venta()
    {
        return $this->hasMany('DetalleVenta');
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
