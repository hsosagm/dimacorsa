<?php

class KardexTransaccion extends \BaseModel {

	protected $guarded = array('id');

    protected $table = 'kardex_transaccion';

    public function kardex()
    {
        return $this->hasMany('Kardex','kardex_transaccion_id');
    }
}
