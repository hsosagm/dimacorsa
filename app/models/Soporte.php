<?php

class Soporte extends \BaseModel {

	protected $table = 'soporte';

	protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('User');    
    }
}
