<div class="tipo_compra_body">

</div>

{{ Form::open(array('data-remote-pago')) }} 

<div class="pagos-body">
    <div class="pagos-detalle">
        <table class="table table-hover" width="100%">

            <thead> 
                <tr class="danger"> 
                    <th> Metodo </th> 
                    <th> Monto  </th> 
                    <th></th>  
                </tr> 
            </thead>

            <tbody>
              @foreach ($det_pagos as $key => $det) 

                <?php $click = "DeleteDetalleAbono(".$det->id.",'".$det->metodo."',this)" ?>
                 <tr class="warning" > 
                    <td width="50%"> {{$det->metodo}} </td>
                    <td width="50%"> {{$det->monto}} </td>
                    <td>
                        <i class="fa fa-times pointer btn-link theme-c" onClick="{{$click}}"></i>
                    </td>
                 </tr>  

              @endforeach  
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-4">Restante: {{ $total_compra - $total_abono }} </div>
        <div class="col-md-4">Total   : {{ $total_compra }} </div>
        <div class="col-md-4">Abonos  : {{ $total_abono  }}</div>
    </div>
    
</div>
<fieldset {{$desabilitar}}>
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

                <input class="form-control" type="text" name="monto" value="{{$total_compra - $total_abono}}" {{$desabilitar}}>

            </div>

        </div>

        <br>
    </div>
</fieldset>
<input type="{{$tipo}}" class="btn btn-info btn-lg btn-block theme-button" style="height:40px;" value="{{$value_submit}}" onclick="{{$funcion_submit}}" >
{{Form::close()}}

<style type="text/css">

.pagos-body .pagos-detalle {
    max-height: 150px !important;
    /*height: 150px !important;*/
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;
    padding: 0px 0px 0px 0px !important;
    margin: 0px 0px 0px 0px !important;
    background: white;
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

   .pagos-body table tr
   {
    border-bottom: 1px solid black;

}

.pagos-body table
{
    margin-bottom: 25px;
}

</style>