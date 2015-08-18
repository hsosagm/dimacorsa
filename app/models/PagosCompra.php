<?php

class PagosCompra extends \BaseModel {
	
	protected $table = 'pagos_compras';

	protected $guarded = array('id');

	public function compra()
    {
        return $this->belongsTo('Compra', 'compra_id');    
    }

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
