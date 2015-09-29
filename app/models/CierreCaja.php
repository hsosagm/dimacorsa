<?php

class CierreCaja extends \BaseModel {

	protected $table = 'cierre_caja';

	protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('User');
    }
}
