<?php
use \NEkman\ModelLogger\Contract\Logable;

class Gasto extends \BaseModel implements Logable{

    protected $table = 'gastos';
    
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

    public function detallegastos()
    {
        return $this->hasMany('DetalleGasto');
    }

    public function getLogName()
    {
        return $this->id;
    }
}
