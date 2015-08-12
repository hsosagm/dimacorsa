<?php

class Kardex extends \BaseModel {

	protected $guarded = array('id');

    protected $table = 'kardex';

    public function kardex_accion()
    {
        return $this->belongsTo('KardexAccion');
    }

    public function kardex_transaccion()
    {
        return $this->belongsTo('KardexTransaccion');    
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function producto()
    {
        return $this->belongsTo('Producto');    
    }
}
