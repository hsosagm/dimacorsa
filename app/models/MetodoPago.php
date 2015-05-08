<?php
use \NEkman\ModelLogger\Contract\Logable;

class MetodoPago extends \Eloquent implements Logable {

	protected $table = 'metodo_pago';

	protected $guarded = array('id');

    public function getLogName()
    {
        return $this->id;
    }
}
