<?php
        $informe_general_anterior = DB::table('informe_general')
        ->whereRaw("id = (select max(id) from informe_general)")->first();
    //consultas de lo real del sistema
        $informe_cuentas_por_pagar = Compra::first(array(DB::raw('sum(saldo) as total')));

        $informe_cuentas_por_cobrar = Venta::first(array(DB::raw('sum(saldo) as total')));

        $informe_inversion = Existencia::join('productos', 'productos.id', '=', 'existencias.producto_id')
        ->first(array(DB::raw('sum(existencias.existencia * (productos.p_costo/100)) as total')));

        //inversion
        $ventas = DB::table('ventas')
        ->join('detalle_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum((precio - ganancias) * cantidad) as total')));

        $compras = DB::table('compras')
        ->join('detalle_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $descargas = DB::table('descargas')
        ->join('detalle_descargas', 'descarga_id', '=', 'descargas.id')
        ->whereRaw("DATE(descargas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $traslados = DB::table('traslados')
        ->join('detalle_traslados', 'traslado_id', '=', 'traslados.id')
        ->whereRaw("DATE(traslados.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(precio * cantidad) as total')));

        $real_informe_inversion = DB::table('informe_inversion')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        $informe_inversion_esperado =  floatval((($real_informe_inversion->real + $compras->total) - ($ventas->total + $descargas->total)));
        $informe_inversion_real = floatval($informe_inversion->total);
        $diferencia_inversion =  $informe_inversion_real - $informe_inversion_esperado;

        //cuentas por cobrar
        $creditosVentas = DB::table('ventas')
        ->join('pagos_ventas', 'venta_id', '=', 'ventas.id')
        ->whereRaw("DATE(ventas.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        $abonosVentas = DB::table('abonos_ventas')
        ->join('detalle_abonos_ventas', 'abonos_ventas_id', '=', 'abonos_ventas.id')
        ->whereRaw("DATE(abonos_ventas.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_ventas.monto) as total')));
 
        $real_informe_cuentas_por_cobrar = DB::table('informe_cuentas_por_cobrar')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        DB::table('informe_cuentas_por_cobrar')->whereInformeGeneralId($informe_general_anterior->id)->update(array('real' => 401157.72));

        $informe_cuentas_por_cobrar_esperado = floatval(($real_informe_cuentas_por_cobrar->real + $creditosVentas->total) - $abonosVentas->total);
        $informe_cuentas_por_cobrar_real = floatval($informe_cuentas_por_cobrar->total);
        $diferencia_cobrar = $informe_cuentas_por_cobrar_real - $informe_cuentas_por_cobrar_esperado;

        //cuentas por pagar
        $abonosCompras = DB::table('abonos_compras')
        ->join('detalle_abonos_compra', 'abonos_compra_id', '=', 'abonos_compras.id')
        ->whereRaw("DATE(abonos_compras.created_at) = CURDATE()")
        ->first(array(DB::raw('sum(detalle_abonos_compra.monto) as total')));

        $creditosCompras = DB::table('compras')
        ->join('pagos_compras', 'compra_id', '=', 'compras.id')
        ->whereRaw("DATE(compras.created_at) = CURDATE()")
        ->whereMetodoPagoId(2)
        ->first(array(DB::raw('sum(monto) as total')));

        $real_informe_cuentas_por_pagar = DB::table('informe_cuentas_por_pagar')
        ->whereInformeGeneralId($informe_general_anterior->id)->first();

        $informe_cuentas_por_pagar_esperado = floatval(($real_informe_cuentas_por_pagar->real + $creditosCompras->total) - $abonosCompras->total);
        $informe_cuentas_por_pagar_real = floatval($informe_cuentas_por_pagar->total);
        $diferencia_pagar = $informe_cuentas_por_pagar_real - $informe_cuentas_por_pagar_esperado;


?>
<table width="100%" class="DT_table_div">
    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Ventas</td>
        <td align="right">Compras</td>
        <td align="right">Descargas</td>
        <td align="right">Traslados</td>
        <td align="right">Esperado</td>
        <td align="right">Real</td>
        <td align="right">Diferancia</td>
    </tr>
    <tr>
        <td>Inversion</td>
        <td align="right"> {{f_num::get($real_informe_inversion->real)}} </td>
        <td align="right"> {{f_num::get($ventas->total)}} </td>
        <td align="right"> {{f_num::get($compras->total)}} </td>
        <td align="right"> {{f_num::get($descargas->total)}} </td>
        <td align="right"> {{f_num::get($traslados->total)}} </td>
        <td align="right"> {{f_num::get($informe_inversion_esperado)}} </td>
        <td align="right"> {{f_num::get($informe_inversion->total )}}</td>
        <td align="right">{{f_num::get($diferencia_inversion)}}</td>
    </tr>
    <tr> <td colspan="8" height="50"></td> </tr>
    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Creditos</td>
        <td align="right">Abonos</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr>
        <td>Cuentas por cobrar</td>
        <td align="right"> {{f_num::get($real_informe_cuentas_por_cobrar->real)}} </td>
        <td align="right"> {{f_num::get($creditosVentas->total)}} </td>
        <td align="right"> {{f_num::get($abonosVentas->total)}} </td>
        <td align="right" colspan="2"></td>
        <td align="right"> {{f_num::get($informe_cuentas_por_cobrar_esperado)}} </td>
        <td align="right"> {{f_num::get($informe_cuentas_por_cobrar->total)}} </td>
        <td align="right"> {{f_num::get($diferencia_cobrar)}} </td>
    </tr>
    <tr> <td colspan="8" height="50"> </td> </tr>
    <tr>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">Creditos</td>
        <td align="right">Abonos</td>
        <td align="right" colspan="2"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr>
        <td>Cuentas por pagar</td>
        <td align="right"> {{f_num::get($real_informe_cuentas_por_pagar->real)}} </td>
        <td align="right"> {{f_num::get($creditosCompras->total)}} </td>
        <td align="right"> {{f_num::get($abonosCompras->total)}} </td>
        <td align="right" colspan="2"></td>
        <td align="right"> {{f_num::get($informe_cuentas_por_pagar_esperado) }} </td>
        <td align="right">{{f_num::get($informe_cuentas_por_pagar->total)}}</td>
        <td align="right">{{f_num::get($diferencia_pagar)}}</td>
    </tr>
</table>
