<?php

class Traslado extends \BaseModel {

	protected $table = 'traslados';
	
	protected $guarded = array('id');

	public function detalle_traslado()
    {
        return $this->hasMany('DetalleTraslado');    
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function tienda()
    {
        return  $this->belongsTo('Tienda');
    }
}
