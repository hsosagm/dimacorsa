{{ Form::open(array('url' => '/user/ventas/ModalSalesPayments', 'data-remote-sales-payment')) }}
    
    {{ Form::hidden('venta_id', Input::get('venta_id')) }}

    <div class="row" style="margin-left:10px">
        <div class="col-md-6"><p>Total a cancelar: {{$TotalVenta}}</p></div>
        <div class="col-md-6"><p>Resta abonar: {{$resta_abonar}}</p></div>
    </div>

    <div class="row" style="margin-top:10px; margin-left:20px; width:90%">
        <div class="col-md-2"><p>Monto</p></div> 
        <div class="col-md-4"><input class="form-control" type="text" name="monto" value="{{$resta_abonar}}"></div>
        <div class="col-md-2"><p>Metodo</p></div> 
        <div class="col-md-4">{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}</div>
    </div>

    <div style="height:150px">
        @include('ventas.payments_detail')
    </div>

    <div class="modal-footer" style="margin-top:20px">
        <button class="btn btn-default" type="button" data-dismiss="modal">Cancelar</button>
        <button class="btn theme-button" type="submit">Enviar</button>
    </div>

{{Form::close()}}