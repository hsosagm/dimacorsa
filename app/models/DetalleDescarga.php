<?php

class DetalleDescarga extends \BaseModel {

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
}
