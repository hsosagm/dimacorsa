<?php
use \NEkman\ModelLogger\Contract\Logable;

use Carbon\Carbon;

class Marca extends \BaseModel implements Logable{

	protected $table = 'marcas';

	protected $guarded = array('id');

    public function producto()
    {
        return $this->hasMany('Producto', 'marca_id');
    }

    public function getLogName()
    {
        return $this->id;
    }
}
