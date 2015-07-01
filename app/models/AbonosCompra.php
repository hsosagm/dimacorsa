<?php

use \NEkman\ModelLogger\Contract\Logable;

class AbonosCompra extends \BaseModel  implements Logable{
	
	protected $table = 'abonos_compras';

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
