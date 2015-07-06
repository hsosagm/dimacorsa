<?php

use \NEkman\ModelLogger\Contract\Logable;

class AbonosCompra extends \BaseModel  implements Logable{
	
	protected $table = 'abonos_compras';

	protected $guarded = array('id');
	
	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }

    public function proveedor()
    {
        return $this->belongsTo('Proveedor');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function detalle_abonos_compra()
    {
        return $this->hasMany('DetalleAbonosCompra');
    }
	public function getLogName()
    {
        return $this->id;
    }
}
