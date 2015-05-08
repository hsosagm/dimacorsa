<?php

namespace NEkman\ModelLogger\Observer;

use NEkman\ModelLogger\ModelLogger;
use NEkman\ModelLogger\Contract\Logable;
use NEkman\ModelLogger\Model as Model;

/**
 * Log every model database event
 * 
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class Logger {

	/**
	 * Log a message to the database
	 * @param String $action ACTION_* constant
	 * @param \Log\Logable $model
	 * @return \Log\Message Logged message
	 */
	private static function log($action, Logable $model) {
		$modelId = $model->getLogName();
		if (empty($modelId)) :
			throw new \InvalidArgumentException("model_id must be set, it is currently {$model->getLogName()}");
		endif;

		$obj = Model\Action::where('name', '=', $action)->limit(1)->get();
		if ($obj->isEmpty()) :
			throw new \InvalidArgumentException("{$action} is not a valid action");
		endif;

		$message = new Model\Message;
		$message->action()->associate($obj[0]);
		$message->model = get_class($model);
		$message->model_id = $modelId;
		$message->save();

		return $message;
	}

	public function deleted(Logable $model) {
		try {
			self::log(ModelLogger::ACTION_DELETE, $model);
		} catch (\Exception $ex) {
			$msg = $ex->getMessage() . PHP_EOL . $ex->getTraceAsString();
			\Log::error($msg);
		}
	}

	public function created(Logable $model) {
		try {
			self::log(ModelLogger::ACTION_INSERT, $model);
		} catch (\Exception $ex) {
			$msg = $ex->getMessage() . PHP_EOL . $ex->getTraceAsString();
			\Log::error($msg);
		}
	}

	public function updating(Logable $model) {
		try {
			$oldModel = ModelLogger::getOldModel($model);
			$datas = ModelLogger::getDatas($model, $oldModel);

			\DB::transaction(function() use($model, $datas) {
				$message = self::log(ModelLogger::ACTION_UPDATE, $model);

				foreach ($datas as $data) :
					$obj = new Model\UpdateData;
					$obj->key = $data['key'];
					$obj->old = empty($data['old']) ? 'null' : $data['old'];
					$obj->new = empty($data['new']) ? 'null' : $data['new'];
					$obj->message()->associate($message);
					$obj->save();
				endforeach;
			});
		} catch (\Exception $ex) {
			$msg = $ex->getMessage() . PHP_EOL . $ex->getTraceAsString();
			\Log::error($msg);
		}
	}

}
