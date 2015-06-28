<?php

class Cierre extends \BaseModel {

	protected $table = 'cierre_diario';

	protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('User');
    }
}
