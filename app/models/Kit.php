<?php

class Kit extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'kits';

    public function kit_detalle()
    {
        return $this->hasMany('KitDetalle');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}
