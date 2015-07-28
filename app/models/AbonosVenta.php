<?php

class AbonosVenta extends \BaseModel {
	
	protected $table = 'abonos_ventas';

	protected $guarded = array('id');
	
	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }

    public function cliente()
    {
        return $this->belongsTo('Cliente');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function detalle_abonos_ventas()
    {
        return $this->hasMany('DetalleAbonosVenta');
    }
    
}
