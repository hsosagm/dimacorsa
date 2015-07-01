<?php
use \NEkman\ModelLogger\Contract\Logable;

class DetalleEgreso extends \BaseModel {

	protected $table = 'detalle_egresos';

	protected $guarded = array('id');

	public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }

}
