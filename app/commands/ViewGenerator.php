<?php

use Illuminate\Filesystem\Filesystem;

class ViewGenerator {

	protected $file;

	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}


	public function make($elements, $modelName, $viewName, $tableName)
	{
		$path = app_path()."/views/{$tableName}/{$viewName}.blade.php";
		$template = $this->getTemplate($elements, $modelName);
		$this->makeDir($tableName);

		$this->file->put($path, $template);
	}


	public function getTemplate($elements, $modelName)
	{
		$template = $this->file->get(__DIR__.'/templates/view.txt');


		$template = str_replace('{{formElements}}', implode(PHP_EOL."\t", $elements), $template);
		$template = str_replace('{{msg}}', $modelName, $template);

		return $template;
	}

	public function makeDir($tableName)
	{
		$path = app_path()."/views/{$tableName}";

		if (!file_exists($path))
		{
	       mkdir($path, 0777, true);
	    }
	}

}
