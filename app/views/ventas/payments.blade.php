<div id="pagosventa">
    
    {{ Form::open(array('url' => '/user/ventas/ModalSalesPayments', 'data-remote-sales-payment')) }}
        
        {{ Form::hidden('venta_id', Input::get('venta_id')) }}

        <div class="row" style="margin-left:10px">
            <div class="col-md-6"><p>Total a cancelar: @{{ TotalVenta | currency ' '}}</p></div>
            <div v-show="!vuelto" class="col-md-6"><p>Resta abonar: @{{ resta_abonar | currency ' '}}</p></div>
            <div v-show="vuelto" class="col-md-4"><p class="btn-success" style="padding-left:10px">Su vuelto es: @{{ vuelto | currency ' ' }}</p></div>
        </div>
        <div class="row" style="margin-left:20px; width:90%">
            <div class="col-md-4"><p>Monto</p></div> 
            <div class="col-md-4"><p>Metodo</p></div> 
            <div class="col-md-4"><p></p></div> 
        </div>
        <div class="row" style="margin-top:10px; margin-left:20px; width:90%">
            <div class="col-md-4"><input class="form-control numeric" type="text" value="{{ $resta_abonar }}" name="monto"></div>
            <div class="col-md-4">{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',6)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}</div>
            <div class="col-md-4">
               <!-- <button type="button" onclick="getConsultarNotasDeCreditoCliente(this,{{$cliente_id}})" class="btn-theme form-control ">Notas de Credito</button>-->
            </div>
        </div>

        <div style="height:150px">
            @include('ventas.payments_detail')
        </div>

        <div class="modal-footer" style="margin-top:20px">
            <button class="btn theme-button" type="submit">Enviar</button>
        </div>
    {{Form::close()}}

</div>


<script type="text/javascript">

    var pagosventa = new Vue({

        el: '#pagosventa',

        data: {
            resta_abonar: {{ $resta_abonar }},
            vuelto: {{ $vuelto }},
            TotalVenta: {{ $TotalVenta }},
        }
});


$('.numeric').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});

</script>