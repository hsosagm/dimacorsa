@if (count(@$pv) > 0)

    <table width="100%">

        <thead >
            <tr>
                <th>Monto</th>
                <th>Metodo</th>
            </tr>
        </thead>

        <tbody >
            @foreach($pv as $q)
                <?php
                    $monto = number_format($q->monto,2,'.',',');
                ?>
                <tr>
                    <td width="10%"> {{ $monto }} </td>
                    <td field="cantidad" cod="{{ $q->id }}" class="edit" width="10%"> {{ $q->metodo_pago->descripcion }} </td>        
                    <td width="5%"><i style="color:#FF5960" onclick="RemoveSalePayment({{$q->id}}, {{Input::get('venta_id')}})" class="pointer">&#10007</i></td>
                </tr>
            @endforeach  
        </tbody>

    </table>

@endif

<script>

    if ( {{ $resta_abonar }} <= 0 ) {
        $(".modal-body :input").prop("disabled", true);
        $(".modal-footer").empty().slideUp('slow').slideDown('slow').append("<button type='button' onclick='EndSale(this, {{Input::get('venta_id')}})' class='btn btn-success'>Finalizar venta</button>");
        $('.modal-title').text('Pagos completados puede finalizar la venta');
    };

    function EndSale(element, $id) {

        $(element).prop("disabled", true);

        $.ajax({
            type: 'POST',
            url: "user/ventas/EndSale",
            data: { id: $id},
            success: function (data) {
                if (data.success == true)
                {
                    $('.bs-modal').modal('hide');
                    msg.success('Venta finalizada', 'Listo!');
                    $(".form-panel").hide();
                }
                else
                {
                    msg.warning(data, 'Advertencia!');
                    $(element).prop("disabled", false);
                }
            }
        });
    }

</script>