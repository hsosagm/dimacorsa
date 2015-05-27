<?php
use \NEkman\ModelLogger\Contract\Logable;

class Adelanto extends \BaseModel implements Logable{

    protected $table = 'adelantos';
    
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

    public function detalle_adelantos()
    {
        return $this->hasMany('DetalleAdelanto');
    }

    public function getLogName()
    {
        return $this->id;
    }
}