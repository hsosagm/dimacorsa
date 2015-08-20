<?php

class DetalleGasto extends \BaseModel {

	protected $table = 'detalle_gastos';

	protected $guarded = array('id');

    public function gasto()
    {
        return $this->belongsTo('Gasto', 'gasto_id');    
    }

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}
