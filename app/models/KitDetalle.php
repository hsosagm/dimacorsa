<?php

class KitDetalle extends \BaseModel {

	protected $table = 'kit_detalle';

	protected $guarded = array('id');

	public function producto()
    {
        return $this->belongsTo('Producto');
    }

    public function kit()
    {
        return $this->belongsTo('Kits', 'kit_id');
    }
}
