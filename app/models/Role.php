<?php
use Zizaco\Entrust\EntrustRole;
use \NEkman\ModelLogger\Contract\Logable;

class Role extends EntrustRole implements Logable
{

    public static $rules = array(
        'name' => 'required|between:4,25'
    );

    public function getLogName()
    {
        return $this->id;
    }

}
