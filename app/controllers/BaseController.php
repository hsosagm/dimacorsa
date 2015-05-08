<?php

class BaseController extends Controller {


    public function getModel()
    {
		$class = get_class($this);
	    $model = str_replace('Controller', "", $class);
	    return new $model;
    }


    public function getView()
    {
		$class = get_class($this);
	    $model = str_replace('Controller', "", $class);
        return strtolower($model);
    }


	public function create()
    {
    	if (Input::has('_token'))
        {
            $model = $this->getModel();

            if ($model->_create())
            {
                return 'success';
            }
            
            return $model->errors();
    	}

        return View::make($this->getView().'.create');
    }


    public function edit()
    {
    	if (Input::has('_token'))
        {
	    	$model = $this->getModel()->find(Input::get('id'));

			if ( $model->_update() )
			{
		        return 'success';
			}

			return $model->errors();
    	}

    	$model = $this->getModel()->find(Input::get('id'));

    	return View::make($this->getView().'.edit', compact('model'));
    }
    

    public function delete()
    {
    	$delete = $this->getModel()->destroy(Input::get('id'));

    	if ($delete)
    	{
    		return 'success';
    	}

    	return 'error';
    }
}
