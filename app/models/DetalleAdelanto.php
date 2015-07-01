<?php
use \NEkman\ModelLogger\Contract\Logable;

class DetalleAdelanto extends \BaseModel implements Logable{

	protected $table = 'detalle_adelantos';

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
