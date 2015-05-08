<?php
use \NEkman\ModelLogger\Contract\Logable;

class DetalleSoporte extends \BaseModel implements Logable{

	protected $table = 'detalle_soporte';

	protected $guarded = array('id');

    public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }

    public function getLogName()
    {
        return $this->id;
    }
}
