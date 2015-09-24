<?php

class DevolucionNotaCredito extends \BaseModel {

	protected $table = 'devolucion_nota_credito';

	protected $guarded = array('id');

	public function notaCredito()
	{
		return $this->belongsTo('NotaCredito');
	}

	public function ventas()
	{
		return $this->belongsTo('Venta');
	}

	public function detalle_devolucion()
    {
        return $this->hasMany('DetalleDevolucionNotaCredito');
    }

    public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}