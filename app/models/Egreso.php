<?php
use \NEkman\ModelLogger\Contract\Logable;

class Egreso extends \BaseModel implements Logable{

    protected $table = 'egresos';
    
	protected $guarded = array('id');

	protected $rules = array(
		'tienda_id'  => 'required|integer',
		'user_id'    => 'required|integer',
	);

	public function tienda()
    {
        return $this->belongsTo('Tienda');    
    }

    public function user()
    {
        return $this->belongsTo('User');    
    }

    public function detalle_egresos()
    {
        return $this->hasMany('DetalleEgreso');
    }

    public function getLogName()
    {
        return $this->id;
    }
}