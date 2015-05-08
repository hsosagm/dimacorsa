<?php

namespace NEkman\ModelLogger\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Core model of the package, the log messages
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class Message extends Eloquent {

	protected $table = 'model_log';
	public $timestamps = false;

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		
		try {
			$this->attachUser();
		} catch (\InvalidArgumentException $ex) {
			// No logged in user
		}
	}

	public function getDates() {
		return array('timestamp');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function update_data() {
		return $this->hasMany(__NAMESPACE__ . '\UpdateData', 'model_log_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo(\Config::get('auth.model'), 'user_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function action() {
		return $this->belongsTo(__NAMESPACE__ . '\Action', 'action_id', 'id');
	}

	/**
	 * Attach the logged in user to this message
	 * @throws InvalidArgumentException
	 */
	private function attachUser() {
		if (!\Auth::check()) :
			throw new \InvalidArgumentException('Cant find a logged in user');
		endif;

		$this->user()->associate(\Auth::user());
	}

}
