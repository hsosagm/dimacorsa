{{ Form::open(array('data-remote-PurchasePayment')) }} 

<input type="hidden" name="compra_id" value="{{Input::get('compra_id')}}">
<div class="row totales-pagos" >
    <div class="col-md-4" align="center"><p>Restante: {{ @$total_compra - @$total_pagos }}</p> </div>
    <div class="col-md-4" align="center"><p>Total   : {{ @$total_compra }} </p></div>
    <div class="col-md-4" align="center"><p>Pagos   : {{ @$total_pagos  }}</p></div>
</div>
<div class="form-group">
    <div class="col-md-5">
        <input class="form-control input_numeric input" type="text" name="monto" placeholder="Monto" value="{{ @$total_compra - @$total_pagos }}" >
    </div>
    <div class="col-md-5">
        {{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
    </div>
    <div class="col-md-2">
        <button class="form-control">nota</button>
    </div>
</div><br>
<div class="pagos-detalle">
    @include('compras.payment_detail')
</div>

<div class="form-footer" align="right">
    <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
    <input  class="btn theme-button" type="submit" value="Enviar" >
</div>

{{Form::close()}}

<style type="text/css"> 
   .modal-body { padding: 0px 0px 0px; }
   .bs-modal .Lightbox{ width: 450px !important; }
</style>