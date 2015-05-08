<?php
use \NEkman\ModelLogger\Contract\Logable;

class Categoria extends \BaseModel implements Logable{

	protected $table = 'categorias';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }

}
