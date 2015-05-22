<div class="tipo_compra_body">

</div>

{{ Form::open(array('data-remote-pago')) }} 

<div class="pagos-body">

    <div class="pagos-detalle">

        <table width="100%"> 

            <thead>

                <tr>

                    <th width="70%">Metodo</th>

                    <th width="30%" style="text-align: right;">Monto</th>

                    <th width="5%"> </th>

                </tr>

            </thead>

            <tbody> 

        </tbody>

    </table>

</div>

<strong>

    <div class="row totales-pagos" >

        <div class="col-md-4">Restante: ?? </div>

        <div class="col-md-4" align="center">Total   : ?? </div>

        <div class="col-md-4" align="right">Abonos  : ?? </div>

    </div>

</strong>

</div>

<fieldset >

    <div id="body-tipos">

        <div class="form-group">

            {{ Form::label('body', 'Metodo', array('class'=>'col-sm-2 control-label')) }} 

            <div class="col-sm-9 select_metodo_pago">

                {{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}

            </div>

        </div>

        <div class="form-group">

            {{ Form::label('body', 'Monto', array('class'=>'col-sm-2 control-label')) }} 

            <div class="col-sm-9">

                <input class="form-control" type="text" name="monto" value="">

            </div>

        </div>

        <br>

    </div>

</fieldset>

<input type="" class="btn btn-info btn-lg btn-block theme-button" style="height:40px;" value="" onclick="" >

{{Form::close()}}

<style type="text/css">
    
    .modal-body {
        padding: 0px 0px 0px;
    }

    .totales-pagos {
        color: black;
        font-size: 10px;
    }

    .pagos-detalle{
        font-size: 11px;
        line-height: 100%;
        width: 100% !important;
        margin-top: 10px;
        padding-top: 5px;
        border: 1px solid #C5C5C5;
    }

    .pagos-detalle table  thead, .pagos-detalle table  tbody { display: block; }

    .pagos-detalle table tbody {
        width: 100% !important;
        height:65px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .pagos-detalle table tbody tr td{
        background: white;
    }

    .pagos-detalle table thead tr th {
        font-size: 10px;
        line-height: 100%;
        border-bottom: 1px solid #AAAAAA;
        padding-left: 5px !important;
        padding-top: 5px !important;
        padding-bottom: 5px !important;
        background: white;
        color: black;
    }

    .bs-modal .Lightbox{
        width: 410px !important;
    }

    #body-tipos
    {
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 15px;
    }

    #body-tipos div div 
    {
        margin-bottom: 15px;
    }

</style>