<?php
use \NEkman\ModelLogger\Contract\Logable;

class Venta extends \BaseModel implements Logable{

	protected $guarded = array('id');

	protected $table = 'ventas';

    public function detalle_venta()
    {
        return $this->hasMany('DetalleVenta');
    }

	public function getLogName()
    {
        return $this->id;
    }

    public function cliente()
    {
        return $this->belongsTo('Cliente');    
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
