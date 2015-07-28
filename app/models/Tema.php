<?php

class Tema extends \BaseModel {

	protected $table = 'tema';

	protected $guarded = array('id');

	public function user()
    {
        return $this->belongsTo('User');    
    }
}
