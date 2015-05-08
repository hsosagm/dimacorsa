<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str as Str;
use Illuminate\Filesystem\Filesystem as Filesystem;

class ModelGeneratorCommand extends Command {


	protected $name = 'make';
	protected $description = 'Resource generator.';
	protected $model;
	protected $controller;
    protected $file;


	public function __construct(ModelGenerator $model, ControllerGenerator $controller, ViewGenerator $view, Filesystem $file)
	{
		parent::__construct();

		$this->model = $model;
        $this->controller = $controller;
		$this->view = $view;
        $this->file = $file;
	}


	public function fire()
	{
		$resource = $this->argument('resource');

		$this->callModel($resource);
        $this->callController($resource);
		$this->callView($resource);
        $this->updateRoutesFile($resource);

        $this->info( "Todo generado con exito" );
	}

    
    protected function callModel($resource)
    {
        $modelName = $this->getModelName($resource);
        $tableName = $this->getTableName($resource);

        if ($this->confirm("Quieres que haga el $modelName modelo? [yes|no]"))
        {
		    $this->model->make($modelName, $tableName);
        }
    }


    protected function callController($resource)
    {
        $controllerName = $this->getControllerName($resource);
        $tableName      = $this->getTableName($resource);
        $modelName      = $this->getModelName($resource);

        if ($this->confirm("Quieres que haga el $controllerName controller? [yes|no]"))
        {
        	$this->controller->make($resource);
        }
    }


    protected function callView($resource)
    {
        $elements = [];
        $tableName = $this->getTableName($resource);
        $elements = $this->makeFormElements($tableName);
        $modelName = $this->getModelName($resource);

        if ($this->confirm("Do you want me to create views for this $modelName resource? [yes|no]"))
        {
            foreach(['index', 'show', 'create', 'edit'] as $viewName)
            {
                $this->view->make($elements, $modelName, $viewName, $tableName);
            }
        }
    }


    public function makeFormElements($tableName)
    {
        $columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns('tiendas');

        $attributes = $this->getModelAttributes($columns);

        foreach($attributes as $column)
        {
          $elements[] = $this->makeFormField($column);
        }

        return $elements;
    }


    protected function makeFormField($column)
    {
        return $element = "{{ Form::_text('$column') }}";
    }


    protected function getModelAttributes($columns)
    {
        $names = array_keys($columns);

        return array_diff($names, array('id', 'created_at', 'updated_at', 'deleted_at', 'password'));
    }


    protected function getTableInfo($model)
    {
        $table = Pluralizer::plural($model);

        return \DB::getDoctrineSchemaManager()->listTableDetails($table)->getColumns();
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


	protected function getArguments()
	{
        return [
            ['resource', InputArgument::REQUIRED, 'Singular resource name']
        ];
	}


	protected function getOptions()
	{
		return array(
			array('path', null, InputOption::VALUE_OPTIONAL, 'path to directory.', app_path().'/models'),
		);
	}


    public function updateRoutesFile($resource)
    {
        $name      = $this->getTableName($resource);
        $modelName = $this->getModelName($resource);
        $path      = app_path() . '/routes.php';
        $file      = new Filesystem();

        $append="Route::group(array('prefix' => '$name'), function()
{
    Route::get('create', '" . ucwords($modelName) . "Controller@create');
    Route::post('create', '" . ucwords($modelName) . "Controller@create');
    Route::post('edit', '" . ucwords($modelName) . "Controller@edit');
});
";

        $buffer=$file->get($path);

        if ( !Str::contains( $buffer, $append) ) {       
            $this->file->append($path, "\n\n".$append);
        }
    }
}
