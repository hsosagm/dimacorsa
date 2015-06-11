<?php

class BaseModel extends Eloquent   {

    protected $rules = array();
    protected $errors;
    protected $model_id;

    public function _create($data = null)
    {
        if ($data == null) 
        {
            $data = Input::all();
        }

        $class = get_class($this);
        $path = "App\\Validators\\{$class}Validator";
        $v = $path::make($data);

        if ($v->fails())
        {
            $this->errors = $v->messages();
            return false;
        }

        $values = array_map('trim', $data);
        $values = preg_replace('/\s{2,}/', ' ', $values);
        $values = array_map('ucfirst', $values);
        $model = $class::create($values);
        $this->model_id = $model->id;

        return 'success';
    }


    public function _update()
    {
        $class = get_class($this);
        $path = "App\\Validators\\{$class}Validator";

        if (class_exists($path))
        {
            $v = $path::make();
            if ($v->fails())
            {
                $this->errors = $v->messages();
                return false;
            }

            if (Input::has('password'))
            {
                $values = ( array_map('trim', Input::all()) );
            }
            else
            {
                $values = ( array_map('trim', Input::except('password')) );
            }

            $class::find(Input::get('id'))->update($values);
            return 'success';
        }
    }

     public function update_master()
    {
        $data = Input::all();
        $data['user_id'] = Auth::user()->id;
        $data['tienda_id'] = Auth::user()->tienda_id;

        $class = get_class($this);
        $path = "App\\Validators\\{$class}Validator";

        if (class_exists($path))
        {
            $v = $path::make($data);
            if ($v->fails())
            {
                $this->errors = $v->messages();
                return false;
            }

            if (Input::has('password'))
            {
                $values = ( array_map('trim', Input::all()) );
            }
            else
            {
                $values = ( array_map('trim', Input::except('password')) );
            }

            $class::find(Input::get('id'))->update($values);
            return 'success';
        }
    }


    public function create_master($data = null)
    {
        if ($data == null) 
        {
            $data = Input::all();
        }

        $data['user_id'] = Auth::user()->id;
        $data['tienda_id'] = Auth::user()->tienda_id;
        $class = get_class($this);
        $path = "App\\Validators\\{$class}Validator";
        $v = $path::make($data);

        if ($v->fails())
        {
            $this->errors = $v->messages();
            return false;
        }

        $model = $class::create($data);

        $this->model_id = $model->id;

        return 'success';
    }


    public function errors()
    {
        return $this->errors->first();
    }


    public function get_id()
    {
        return $this->model_id;
    }


    public function SaleItem()
    {
        $class = get_class($this);
        $path = "App\\Validators\\{$class}Validator";
        $v = $path::make();

        if ($v->fails())
        {
            $this->errors = $v->messages();
            return false;
        }

        $values = array_map('trim', Input::all());
        $values = preg_replace('/\s{2,}/', ' ', $values);
        $values = array_map('ucfirst', $values);

        $query = Producto::find(Input::get('producto_id'));
        
        $values['ganancias'] = $values['precio'] - ( $query->p_costo / 100);
        $class::create($values);
        return 'success';
    }
}
