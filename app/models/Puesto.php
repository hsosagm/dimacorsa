<?php

class Puesto extends \BaseModel {

    protected $table = 'puestos';
    
	protected $guarded = array('id');

    public function user()
    {
        return $this->hasMany('User');
    }
}
