<?php

class KardexAccion extends \BaseModel {

	protected $guarded = array('id');

    protected $table = 'kardex_accion';

    public function kardex()
    {
        return $this->hasMany('Kardex','kardex_accion_id');
    }
}
