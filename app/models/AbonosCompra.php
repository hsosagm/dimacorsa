<?php

class AbonosCompra extends \BaseModel  {
	
	protected $table = 'abonos_compras';

	protected $guarded = array('id');
	
	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
    
}
