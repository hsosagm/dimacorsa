<?php

/*
 * Migrations file for the package
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use NEkman\ModelLogger\Model;

class ModelLogger extends Migration {

	const TABLE = 'model_log';
	const TABLE_DATA = 'model_log_update';
	const TABLE_ACTION = 'model_log_action';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$user = Config::get('auth.table');

		// Action
		Schema::create(self::TABLE_ACTION, function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
		});

		DB::transaction(function() {
			$actions = array('insert', 'update', 'delete');
			foreach ($actions as $action) :
				$obj = new Model\Action;
				$obj->name = $action;
				$obj->save();
			endforeach;
		});
		// -- Action
		// Log
		Schema::create(self::TABLE, function(Blueprint $table) use($user) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('action_id')->unsigned();
			$table->string('model');
			$table->string('model_id');
			$table->timestamp('timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));

			$table->foreign('user_id')
				->references('id')->on($user)
				->onUpdate('cascade')->onDelete('cascade');

			$table->foreign('action_id')
				->references('id')->on(self::TABLE_ACTION)
				->onUpdate('cascade')->onDelete('cascade');
		});
		// -- Log
		// Data
		Schema::create(self::TABLE_DATA, function(Blueprint $table) {
			$table->increments('id');
			$table->integer('model_log_id')->unsigned();
			$table->string('key');
			$table->string('old');
			$table->string('new');
			$table->unique(array('model_log_id', 'key'));

			$table->foreign('model_log_id')
				->references('id')->on(self::TABLE)
				->onUpdate('cascade')->onDelete('cascade');
		});
		// -- Data
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop(self::TABLE_DATA);
		Schema::drop(self::TABLE);
		Schema::drop(self::TABLE_ACTION);
	}

}
