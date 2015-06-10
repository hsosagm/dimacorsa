<?php
use \NEkman\ModelLogger\Contract\Logable;

class BarCode extends \BaseModel implements Logable{
	
	protected $table = 'barcode';

	protected $guarded = array('id');

	protected $fillable = [];

/**
 * [getLogName description]
 * @return 
 */
	public function getLogName() 
	{
		return $this->id;
	}
}