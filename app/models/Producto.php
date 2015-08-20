<?php

class Producto extends \BaseModel {

	protected $table = 'productos';

	protected $guarded = array('id');

    public function marca()
    {
        return $this->belongsTo('Marca', 'marca_id');
    }

    public function categoria()
    {
        return $this->belongsTo('Categoria', 'categoria_id');
    }
}
