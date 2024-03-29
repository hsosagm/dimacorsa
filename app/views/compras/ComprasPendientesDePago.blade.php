
@include('proveedor_partials.head_content')

<?php
    $total_saldo = 0;
    $saldo_vencido = 0;
?>

<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr id="hhh">
            <th>Fecha compra</th>
            <th>Fecha ingreso</th>
            <th>Usuario</th>
            <th>Proveedor</th>
            <th>Factura</th>
            <th>Total</th>
            <th>Saldo</th>
            <th>     </th>
        </tr>
    </thead>
    <tbody>
        @foreach($compras as $q)
            <?php
                $total_saldo = $total_saldo + $q->saldo;
                $fecha_entrada = date('Ymd', strtotime($q->fecha));
                $fecha_vencida = date('Ymd', strtotime("-30 days"));
            ?>

            @if( $fecha_entrada < $fecha_vencida )
                <?php $saldo_vencido = $saldo_vencido + $q->saldo; ?>
                <tr class="red" id="{{ $q->id }}">
                    <td class="center" width="16%"> {{ $q->fecha }} </td>
                    <td class="center" width="16%"> {{ $q->fecha_ingreso }} </td>
                    <td width="15%"> {{ $q->usuario }} </td>
                    <td width="20%"> {{ $q->proveedor }} </td>
                    <td width="10%"> {{ $q->numero_documento }} </td>
                    <td class="right"  width="9%"> {{ f_num::get5($q->total) }} </td>
                    <td class="right"  width="9%"> {{ f_num::get5($q->saldo) }} </td>
                    <td class="center" width="5%">
                        <i id="{{ $q->id }}" class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)" ></i>
                    </td>
                </tr>
            @else
                <tr id="{{ $q->id }}">
                    <td class="center" width="16%"> {{ $q->fecha  }} </td>
                    <td class="center" width="16%"> {{ $q->fecha_ingreso }} </td>
                    <td width="15%"> {{ $q->usuario }} </td>
                    <td width="20%"> {{ $q->proveedor }} </td>
                    <td width="10%"> {{ $q->numero_documento }} </td>
                    <td class="right"  width="9%"> {{ f_num::get5($q->total) }} </td>
                    <td class="right"  width="9%"> {{ f_num::get5($q->saldo) }} </td>
                     <td class="center" width="5%">
                        <i id="{{ $q->id }}" class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)" ></i>
                    </td>
                </tr>
            @endif

        @endforeach

    </tbody>

</table>
{{ Form::hidden('total_saldo', f_num::get5($total_saldo)) }}
{{ Form::hidden('saldo_vencido', f_num::get5($saldo_vencido)) }}
