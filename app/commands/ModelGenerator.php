<?php

use Illuminate\Filesystem\Filesystem;

class ModelGenerator {

	protected $file;

	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}


	public function make($modelName, $tableName)
	{
		$path = app_path()."/models/{$modelName}.php";

		$template = $this->getTemplate($modelName, $tableName);

		$this->file->put($path, $template);
	}


	public function getTemplate($modelName, $tableName)
	{
		$template = $this->file->get(__DIR__.'/templates/model.txt');

		$template = str_replace('{{MODEL}}', $modelName, $template);

		return str_replace('{{TABLE}}', $tableName, $template);
	}

}
