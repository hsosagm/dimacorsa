<?php

class DetalleIngreso extends \BaseModel {

	protected $table = 'detalle_ingresos';

	protected $guarded = array('id');

    public function ingreso()
    {
        return $this->belongsTo('Ingreso', 'ingreso_id');    
    }

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
