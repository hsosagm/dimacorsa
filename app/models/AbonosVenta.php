<?php

class AbonosVenta extends \BaseModel {
	
	protected $table = 'abonos_ventas';

	protected $guarded = array('id');
	
	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
    
}
