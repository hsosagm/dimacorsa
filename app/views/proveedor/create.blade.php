{{ Form::open(array('data-remote-proveedor')) }}

<div class="row form-proveedor">

    <div class="col-md-8 info-proveedor" >

        <table class="">

            <tr>
                <td> Nombre:</td>
                <td> {{ Form::text("nombre", "" , array())}} </td>
            </tr>

            <tr>
                <td> Direccion: </td>
                <td> {{ Form::text("direccion", "" , array())}} </td>
            </tr>

            <tr>
                <td> Nit: </td>
                <td> {{ Form::text("nit", "" , array())}} </td>
            </tr>

            <tr>
                <td> Telefono: </td>
                <td> {{ Form::text("telefono", "" , array())}} </td>
            </tr>

        </table> 

    </div>

    <div class="col-md-4">

    </div>

</div>
<div class="form-footer" align="right">

    {{ Form::submit('Crear!', array('class'=>'theme-button')) }}

</div>
{{ Form::close() }}

<div class="proveedor-body">

</div>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 850px !important;
    }

</style>
