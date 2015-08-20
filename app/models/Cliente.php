<?php

class Cliente extends \BaseModel {

	protected $table = 'clientes';

	protected $guarded = array('id');

    public function venta()
    {
        return $this->hasMany('Venta');
    }

    public function tipocliente()
    {
        return $this->belongsTo('TipoCliente', 'tipo_cliente_id');    
    }
}
