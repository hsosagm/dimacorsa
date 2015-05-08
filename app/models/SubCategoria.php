<?php
use \NEkman\ModelLogger\Contract\Logable;

class SubCategoria extends \BaseModel  implements Logable{

	protected $table = 'sub_categorias';

	protected $guarded = array('id');

	public function getLogName()
    {
        return $this->id;
    }

}
