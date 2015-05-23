@if(count(@$det_pagos) > 0)
    <table width="100%"> 
        <thead>
            <tr>
                <th width="65%">Metodo</th>
                <th width="35%" style="text-align: center;">Monto</th>
                <th width="15%"> </th>
            </tr>
        </thead>
        <tbody> 
            @foreach (@$det_pagos as $key => $det) 
            <tr> 
                <td width="65%"> {{$det->metodo_pago->descripcion}} </td>
                <td width="30%" align="right"> {{@$det->monto}} </td>
                <td width="15%">
                    <i class="fa fa-times pointer btn-link theme-c" onClick="DeletePurchasePaymentItem({{$det->id}},{{Input::get('compra_id')}})"></i>
                </td>
            </tr>  
            @endforeach   
        </tbody>
    </table>

    @if (($total_compra - $total_pagos) <= 0) 
        <script>
            $(function() {
                $(".modal-body .form-footer").slideUp('slow', function() { 
                    $(".modal-body :input").prop('disabled', true);
                    $(".modal-body .form-footer").html('<input  class="btn theme-button" type="button" onClick="FinishInitialPurchase({{Input::get('compra_id')}});" value="Finalizar Compra" >');
                    $(".modal-body .form-footer").slideDown('slow', function() { });
                });
                
            });
        </script>
    @endif

@endif