<?php

class AdelantoNotaCredito extends \BaseModel {

	protected $table = 'adelanto_nota_credito';

	protected $guarded = array('id');

    public function notaCredito()
    {
        return $this->belongsTo('NotaCredito');
    }

    public function metodoPago()
    {
        return $this->belongsTo('MetodoPago', 'metodo_pago_id');
    }
}