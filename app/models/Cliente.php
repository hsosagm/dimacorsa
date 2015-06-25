<?php
use \NEkman\ModelLogger\Contract\Logable;

class Cliente extends \BaseModel implements Logable{

	protected $table = 'clientes';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }

    public function venta()
    {
        return $this->hasMany('Venta');
    }

    public function tipo_cliente()
    {
        return $this->belongsTo('TipoCliente', 'tipo_cliente_id');    
    }
}
