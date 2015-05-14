<?php

class BaseModel extends Eloquent   {

    protected $rules = array();
    protected $errors;
    protected $model_id;

    public function _create()
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
        $class::create($values);
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


    public function create_master()
    {
        $data = Input::all();
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

        $this->id = $model->id;

        return 'success';
    }


    public function errors()
    {
        return $this->errors->first();
    }

    public function get_id()
    {
        return $this->id;
    }
}
