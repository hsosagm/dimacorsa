<?php

class DetalleSoporte extends \BaseModel {

	protected $table = 'detalle_soporte';

	protected $guarded = array('id');

    public function soporte()
    {
        return $this->belongsTo('Soporte', 'soporte_id');    
    }

    public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
