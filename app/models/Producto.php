<?php

use \NEkman\ModelLogger\Contract\Logable;

class Producto extends \BaseModel implements Logable {

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

    public function getLogName()
    {
        return $this->id;
    }
}
