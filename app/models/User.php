<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;
use \NEkman\ModelLogger\Contract\Logable;

class User extends \BaseModel implements UserInterface, RemindableInterface, Logable {

	use UserTrait, RemindableTrait, HasRole;
    protected $table = 'users';
	protected $guarded = array('id');
    protected $hidden = array('password', 'remember_token');

    public function setPasswordAttribute($pass) 
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function getLogName()
    {
        return $this->id;
    }

    public function tienda()
    {
        return $this->belongsTo('Tienda');    
    }

    public function gastos()
    {
        return $this->hasMany('Gasto');
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }
 
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
