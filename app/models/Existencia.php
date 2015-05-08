<?php
use \NEkman\ModelLogger\Contract\Logable;

class Existencia extends Eloquent implements Logable{

	protected $table = 'existencias';

	protected $guarded = array('id');

	public $timestamps = false;

	public function getLogName()
    {
        return $this->id;
    }
}
