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

              @foreach ($det_pagos as $key => $det) 

              <?php $click = "DeletePurchasePaymentItem(".$det->id.",'".$det->metodo."',this)" ?>

              <tr> 

                <td width="65%"> {{$det->metodo}} </td>

                <td width="30%" align="right"> {{$det->monto}} </td>

                <td width="10%">
                    <i class="fa fa-times pointer btn-link theme-c" onClick="{{$click}}"></i>
                </td>

            </tr>  

            @endforeach  
            
            @if($flete != '')
            <tr> 

                <td width="65%"> Flete </td>

                <td width="30%" align="right"> {{@$flete->monto}} </td>

                <td width="10%">
                    <i class="fa fa-times pointer btn-link theme-c" href="admin/compras/DeletePurchaseShipping" id="{{@$flete->id}}" onClick="DeleteDetalle(this);"></i>
                </td>

            </tr> 
            @endif 

        </tbody>

    </table>

</div>

<strong>

    <div class="row totales-pagos" >

        <div class="col-md-4">Restante: {{ $total_compra - $total_abono }} </div>

        <div class="col-md-4" align="center">Total   : {{ $total_compra }} </div>

        <div class="col-md-4" align="right">Abonos  : {{ $total_abono  }}</div>

    </div>

</strong>

</div>

<fieldset {{$desabilitar}}>

    <div id="body-tipos">

        <div class="form-group">

            <div class="col-sm-6 select_metodo_pago">

                {{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}

            </div>

            <div class="col-sm-6">

                <input class="form-control" type="text" name="monto" placeholder="Monto" value="{{$total_compra - $total_abono}}" >

            </div>

        </div>

        <div class="form-group">

            <div class="col-sm-12 select_metodo_pago">
                <textarea name="nota" rows="2" cols="40" placeholder="Nota"></textarea>
            </div>

        </div>

        <br>

    </div>

</fieldset>

<input type="{{$tipo}}" class="btn btn-info btn-lg btn-block theme-button" style="height:40px;" value="{{$value_submit}}" onclick="{{$funcion_submit}}" >

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