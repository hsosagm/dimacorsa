<?php

class Devolucion extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'devoluciones';

    public function detalle_devolucion()
    {
        return $this->hasMany('DetalleDevolucion');
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
