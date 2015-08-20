
<?php

class Descarga extends \BaseModel {

	protected $guarded = array('id');

	protected $table = 'descargas';

    public function detalle_descarga()
    {
        return $this->hasMany('DetalleDescarga');
    }
}
