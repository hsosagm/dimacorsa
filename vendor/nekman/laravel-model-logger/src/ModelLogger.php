<?php

namespace NEkman\ModelLogger;

use NEkman\ModelLogger\Contract\Logable;
use NEkman\ModelLogger\Exception\NoOldModelException;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Package logic. Only used within the package
 * 
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class ModelLogger {

	const ACTION_DELETE = 'delete';
	const ACTION_UPDATE = 'update';
	const ACTION_INSERT = 'insert';

	/**
	 * For updating, get the old model
	 * @param \Eloquent $model
	 * @return type
	 * @throws \InvalidArgumentException
	 */
	public static function getOldModel(Eloquent $model) {
		$class = get_class($model);

		$oldModel = $class::find($model->id);
		if (empty($oldModel)) :
			throw new NoOldModelException("Could not find model with class {$class} and id {$model->id}");
		endif;

		return $oldModel;
	}

	/**
	 * Get the data needed to save an update post
	 * @param \Log\Logable $model
	 * @param \Log\Logable $oldModel
	 * @return array Array of datas
	 */
	public static function getDatas(Logable $model, Logable $oldModel) {
		$diff = self::getLogDifference($model, $oldModel);
		
		$datas = array();
		foreach ($diff as $key) :
			$datas[] = array(
			    'key' => $key,
			    'new' => $model->{$key},
			    'old' => $oldModel->{$key},
			);
		endforeach;

		return $datas;
	}

	/**
	 * Determine the difference between this model and another
	 * @param self $model
	 * @return array Keys that are different
	 */
	public static function getLogDifference(Eloquent $model, Eloquent $oldModel) {
		$attributes = $model->attributesToArray();
		$modelAttributes = $oldModel->attributesToArray();

		$diff = array();

		// Determine what values are not the same
		foreach ($attributes as $key => $value) :
			$other = $modelAttributes[$key];

			if ($value !== $other) :
				$diff[] = $key;
			endif;
		endforeach;

		return $diff;
	}

}
