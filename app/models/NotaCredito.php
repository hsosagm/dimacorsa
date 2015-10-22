<?php

class NotaCredito extends \BaseModel {

	protected $table = 'notas_creditos';

	protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('User');
    }

	public function cliente()
    {
        return $this->belongsTo('Cliente');
    }
}
