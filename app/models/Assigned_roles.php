<?php

use \NEkman\ModelLogger\Contract\Logable;

class Assigned_roles extends Eloquent  implements Logable{
	
	public function getLogName()
    {
        return $this->id;
    }
}
