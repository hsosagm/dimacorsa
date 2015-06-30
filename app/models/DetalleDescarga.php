<?php
use \NEkman\ModelLogger\Contract\Logable;

class DetalleDescarga extends \BaseModel implements Logable {

	protected $table = 'detalle_descargas';

	protected $guarded = array('id');

	public function producto()
    {
        return $this->belongsTo('Producto');    
    }

    public function descarga()
    {
        return $this->belongsTo('Descarga', 'descarga_id');    
    }

    public function getLogName()
    {
        return $this->id;
    }

}
