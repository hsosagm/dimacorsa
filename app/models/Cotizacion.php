<?php

class Cotizacion extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'cotizaciones';

    public function detalle_cotizacion()
    {
        return $this->hasMany('DetalleCotizacion');
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
