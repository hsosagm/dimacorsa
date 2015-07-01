<?php
use \NEkman\ModelLogger\Contract\Logable;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements Logable
{

public function getLogName()
    {
        return $this->id;
    }
}