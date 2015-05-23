<?php

class PagosVenta extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'pagos_ventas';

    public function venta()
    {
        return $this->belongsTo('Venta', 'venta_id');    
    }

    public function metodo_pago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');    
    }
    
}
