<?php
use \NEkman\ModelLogger\Contract\Logable;

class DetalleGasto extends \BaseModel implements Logable{

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

    public function getLogName()
    {
        return $this->id;
    }
}
