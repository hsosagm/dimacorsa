
<?php
use \NEkman\ModelLogger\Contract\Logable;

class Descarga extends \BaseModel implements Logable{

	protected $guarded = array('id');

	protected $table = 'descargas';

    public function detalle_descarga()
    {
        return $this->hasMany('DetalleDescarga');
    }

	public function getLogName()
    {
        return $this->id;
    }
}
