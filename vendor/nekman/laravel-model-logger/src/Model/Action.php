<?php

namespace NEkman\ModelLogger\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Log actions such as "inserted" or "deleted"
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class Action extends Eloquent {

	protected $table = 'model_log_action';
	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function message() {
		return $this->hasMany(__NAMESPACE__ . '\Message', 'id', 'action_id');
	}

}
