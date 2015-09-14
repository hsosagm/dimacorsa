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

        $(".modal-footer").empty().slideUp('slow').slideDown('slow')
        .append(
            "<button style='width:270px; margin-right:5px; margin-top:10px' type='button' onclick='' class='btn btn-success'><i class='fa fa-print'></i> Finalizar e imprimir garantia</button>",
            "<button style='width:270px; margin-right:5px; margin-top:10px' type='button' onclick='FinalizeSale(this, {{Input::get('venta_id')}})' class='btn btn-success'><i class='fa fa-check'></i> Finalizar</button>",
            "<button style='width:270px; margin-right:5px; margin-top:10px' type='button' onclick='' class='btn btn-success'><i class='fa fa-print'></i> Finalizar e imprimir fact. y garant.</button>",
            "<button style='width:270px; margin-right:5px; margin-top:10px' type='button' onclick='' class='btn btn-success'><i class='fa fa-print'></i> Finalizar e imprimir factura</button>"
        );

        $('.modal-title').text('Pagos completados puede finalizar la venta');
    };

</script>