<?php

namespace NEkman\ModelLogger\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Data related to model updates
 * 
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class UpdateData extends Eloquent {

	protected $table = 'model_log_update';
	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function message() {
		return $this->belongsTo(__NAMESPACE__ . '\Message', 'model_log_id', 'id');
	}

}
