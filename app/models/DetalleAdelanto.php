<?php

class DetalleAdelanto extends \BaseModel {

	protected $table = 'detalle_adelantos';

	protected $guarded = array('id');

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }

}
