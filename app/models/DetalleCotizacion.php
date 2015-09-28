<?php

class DetalleCotizacion extends \BaseModel {

	protected $table = 'detalle_cotizaciones';

	protected $guarded = array('id');

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }

    public function cotizacion()
    {
        return $this->belongsTo('Cotizacion', 'cotizacion_id');    
    }
}
