<?php

Form::macro('_text', function($column_name, $value = null, $lable_name = null)
{
    if ($lable_name == null) {
        $lable_name = ucwords($column_name);
    }
    $lable   = Form::label('body', $lable_name, array('class'=>'col-sm-2 control-label'));
    $element = Form::text($column_name, $value, array('class'=>'form-control','autocomplete'=>'off'));
    return textWrapper($element, $lable);
});


Form::macro('_password', function($column_name, $value = null)
{
    $lable   = Form::label('body', ucwords($column_name), array('class'=>'col-sm-2 control-label'));
    $element = Form::password($column_name, array('class'=>'form-control', 'placeholder' => 'Password'));
    return textWrapper($element, $lable);
});


function textWrapper($element, $lable)
{
    $out  = '<div class="form-group">';
    $out .= $lable;
    $out .= '<div class="col-sm-9">';
    $out .= $element;
    $out .= '</div>';
    $out .= '</div>';
    return $out;
}

Form::macro('_select',function($column_name,$value,$id = null,$plus = null ,$lable_name = null)
{
    if( $lable_name == null)
    {
        $lable_name = ucwords($column_name);
        $lable_name = substr($lable_name, 0, -3);
    }

    $lable   = Form::label('body', $lable_name, array('class'=>'col-sm-2 control-label'));
    $element = Form::select($column_name, $value, $id, array('class'=>'form-control'));
    
    return selectWrapper($element, $lable ,$plus);
});


function selectWrapper($element, $lable , $plus = null)
{
    $out = '<div class="form-group">';
    $out .= $lable;
    $out .= $plus;
    $out .= '<div class="col-sm-9">';
    $out .= $element;
    $out .= '</div>';
    $out .= '</div>';
    return $out;
}


Form::macro('_submit', function()
{
    $enviar = Form::submit('Enviar!', ['class'=>'btn theme-button']);
    $cerrar = Form::button('Cerrar!', ['class'=>'btn btn-default', 'data-dismiss'=>'modal']);
    return submitWrapper($enviar, $cerrar);
});


function submitWrapper($enviar, $cerrar)
{
    $out  = '<div class="modal-footer">';
    $out .= $cerrar;
    $out .= $enviar;
    $out .= '</div>';
    return $out;
}


Form::macro('_open', function($message)
{
    return Form::open(array('data-remote', 'data-success' => $message, 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all'));
});


Form::macro('ddt_open', function($message)
{
    return Form::open(array('ddt-remote', 'data-success' => $message, 'method' =>'post', 'role'=>'form'));
});


Form::macro('md8_open', function()
{
    return Form::open(array('data-remote', 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal regular col-md-8 all'));
});


Form::macro('button_edit', function($id)
{
    return Form::button('<i class="icon-pencil" style="font-size:18px;"></i>', array('class'=>'btn-link', 'id'=>$id));
});


Form::macro('button_new', function($id)
{
    return Form::button('<i class="icon-plus-sign" style="font-size:18px;"></i>', array('class'=>'btn-link', 'id'=>$id));
});


Form::macro('_label', function($name)
{
    return Form::label('body', $name, array('class'=>'control-label col-lg-3'));
});


Form::macro('_hidden', function($id)
{
    return Form::hidden('id', $id);
});
