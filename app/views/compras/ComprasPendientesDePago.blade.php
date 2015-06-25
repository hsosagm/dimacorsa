<?php 
$total_saldo = 0;
$saldo_vencido = 0;
?>

<table id="example" class="display" width="100%" cellspacing="0">

    <thead>
        <tr id="hhh">
            <th>Fecha</th>
            <th>Fecha Doc.</th>
            <th>Usuario</th>
            <th>Proveedor</th>
            <th>Numero</th>
            <th>Saldo</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>

        @foreach($compras as $q)
        <?php
        $total_saldo = $total_saldo + $q->saldo;
        $saldo = number_format($q->saldo,2,'.',',');
        $total  = number_format($q->total,2,'.',',');
        $fecha_entrada = $q->fecha;
        $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
        $fecha_vencida = date('Ymd', strtotime("-30 days"));
        ?>

        @if( $fecha_entrada < $fecha_vencida )
        <?php
        $saldo_vencido = $saldo_vencido + $q->saldo;
        ?>
        <tr class="red" id="{{ $q->id }}">
            <td class="center" width="15%"> {{ $q->fecha_ingreso }} </td>
            <td class="center" width="15%"> {{ $q->fecha }} </td>
            <td                width="21%"> {{ $q->usuario }} </td>
            <td                width="40%"> {{ $q->proveedor }} </td>
            <td                width="12%"> {{ $q->numero_documento }} </td>
            <td class="right"  width="12%"> {{ $saldo }} </td>
            <td class="right"  width="12%"> {{ $total }} </td>
            <td>
                <i id="{{ $q->id }}" class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)" ></i>
            </td>
        </tr>
        @else
        <tr id="{{ $q->id }}">
            <td class="center" width="15%"> {{ $q->fecha_ingreso }} </td>
            <td class="center" width="15%"> {{ $q->fecha  }} </td>
            <td                width="21%"> {{ $q->usuario }} </td>
            <td                width="40%"> {{ $q->proveedor }} </td>
            <td                width="12%"> {{ $q->numero_documento }} </td>
            <td class="right"  width="12%"> {{ $saldo }} </td>
            <td class="right"  width="12%"> {{ $total }} </td>

            <td>
                <i id="{{ $q->id }}" class="fa fa-plus-square btn-link theme-c" onClick="showPurchasesDetail(this)" ></i>
            </td>
        </tr>
        @endif

        @endforeach

    </tbody>

</table>
<?php $total_saldo = number_format($total_saldo,2,'.',','); ?>
<?php $saldo_vencido = number_format($saldo_vencido,2,'.',','); ?>

{{ Form::hidden('total_saldo', $total_saldo) }}
{{ Form::hidden('saldo_vencido', $saldo_vencido) }}
