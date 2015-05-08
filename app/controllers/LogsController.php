<?php

class LogsController extends Controller {

	public function productos()
	{
		return View::make('logs.productos');
	}


	public function usuarios()
	{
		return View::make('logs.usuarios');
	}


	public function productos_serverside()
	{
        $this->procces_serverside('Producto');
	}


	public function usuarios_serverside()
	{
		$this->procces_serverside('User');
	}


	public function procces_serverside($model)
	{
		$table = 'model_log_update';

		$columns = array("username","model_id","key", "old", "new", "timestamp");

		$searchable = array("username", "model_id", "old", "new");

		$join = 'JOIN model_log ON model_log_update.model_log_id = model_log.id JOIN users ON model_log.user_id = users.id';

		$where = "model_log.model = '$model' ";

		echo TableSearch::get($table, $columns, $searchable, $join, $where);
	}
}