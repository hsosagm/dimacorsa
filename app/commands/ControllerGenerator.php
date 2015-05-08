<?php

use Illuminate\Filesystem\Filesystem;

class ControllerGenerator {

	protected $file;

	public function __construct(Filesystem $file)
	{
		$this->file = $file;
	}


	public function make($resource)
	{
		$controllerName = $this->getControllerName($resource);

		$path = app_path()."/controllers/{$controllerName}.php";

		$template = $this->getTemplate($resource);

		$this->file->put($path, $template);
	}


	public function getTemplate($resource)
	{

        $controllerName = $this->getControllerName($resource);
        $varName        = $this->getTableName($resource);
        $modelName      = $this->getModelName($resource);

		$template = $this->file->get(__DIR__.'/templates/controller.txt');

		$template = str_replace('{{controllerName}}', $controllerName, $template);

		$template = str_replace('{{modelName}}', $modelName, $template);

		return str_replace('{{varName}}', $varName, $template);

	}


    protected function getModelName($resource)
    {
        return ucwords(str_singular(camel_case($resource)));
    }


    protected function getTableName($resource)
    {
        return str_plural($resource);
    }


    protected function getControllerName($resource)
    {
        return ucwords(camel_case($resource)) . 'Controller';
    }

}
