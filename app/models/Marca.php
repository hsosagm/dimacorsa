<?php

class Marca extends \BaseModel {

	protected $table = 'marcas';

	protected $guarded = array('id');

    public function producto()
    {
        return $this->hasMany('Producto', 'marca_id');
    }

}
