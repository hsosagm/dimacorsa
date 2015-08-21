<body onblur="">
    <div align="center">
        <div style="" id="garantia" height="100%"> 
            <table width="100%">
                <tr>
                    <td>
                        <img src="http://hsystemas.com/images/click.jpg" width="127" height="83">
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <div id="encabezado_factura" style="display:inline-block;">
                            <div style="display:inline-block;">
                                <label style="">3ra calle 13-71 zona 1, Chiquimula   Telefono: 7942-1383</label>
                            </div>
                            <br/>
                            <div style="display:inline-block;">
                                <label>Fecha: {{ @$venta->created_at }} </label>
                            </div>
                            <div style="display:inline-block;">
                                <label style="margin-left:12px;"> Garantia No. : {{ @$venta->id }} </label>
                            </div>
                            <br/>
                            <div style="display:inline-block;">
                                <label> {{ @$venta->cliente->nombre.' '.@$venta->cliente->apellido }} </label>
                            </div>
                            <div style="display:inline-block;">
                                <label style="margin-left:12px;" id="garantia_direccion">{{ @$venta->cliente->direccion }} </label>
                            </div>
                            <div style="display:inline-block;">
                                <label style="margin-left:12px;" id="garantia_nit"> {{ @$venta->cliente->nit }} </label>
                            </div>

                        </div>
                    </td>
                </tr>

            </table>


            <div id="garantia_detalle">
                <table width="100%" class="table">
                    <tr>
                        <th width="15%">Cantidad</th>
                        <th width="55%">Descripcion</th>
                        <th width="15%">Precio</th>
                        <th width="15%">Total</th>
                    </tr>
                    <?php $total = 0;  $serials = "";?>
                    @foreach($venta->detalle_venta as $key => $dt)
                    <tr height="1"  style="font-size:12px; ">
                        <td width="15%"> 
                            {{ $dt->cantidad }}
                        </td>   
                        <td width="55%"> 
                            {{ $dt->producto->descripcion }} , {{ $dt->producto->marca->nombre }}
                        </td>
                        <td width="15%" style="text-align:right; padding-right:15px">
                            {{ f_num::get($dt->precio) }}
                        </td>
                        <td width="15%" style="text-align:right; padding-right:15px">
                            {{ f_num::get($dt->cantidad * $dt->precio)}}
                        </td>   
                    </tr>
                    <?php 
                        $total = $total +($dt->cantidad * $dt->precio); 
                         if ($dt->serials != null ) {
                             $serials .= $dt->serials." , ";
                         }
                    ?>
                    @endforeach

                    <tfoot height="15">
                    <tr>
                        <td style="font-size:12px; " colspan="3">
                           Total:
                        </td>
                        <td style="text-align:right; padding-right:15px"> Q {{f_num::get($total)}}</td>
                    </tr>
                    <tr>
                        <td colspan="4"> Series </td>
                    </tr>
                    <tr>
                        <td colspan="4"> {{$serials}} </td>
                    </tr>
                </tfoot>
                </table>
            </div>

            <div id="garantia_terminos">
                <p class="texto_garantia" align="justify" style="font-size:10px">
                    IMPORTANTE:  Click, garantiza este producto en todos sus componentes funcionales  y mano de obra contra cualquier defecto de fabricación a partir de  la fecha de entrega, de acuerdo con las siguientes condiciones.
                    VIGENCIAS:  Computadoras portátiles y de mesa, monitores, ups y respaldos de energía (excluye cargador y batería en portátiles y fuente de poder en desktops): 1 año.    Cargador, batería y fuente de poder 3 meses.   Sistemas de audio, Bocinas, Cámaras Digitales.
                    6 meses.    Accesorios, impresoras, ratones, teclados, audífonos, unidades de almacenamiento internas y externas, unidades ópticas, lectores de medios y cables de todo tipo 3 meses.
                    CONDICIONES:
                    1.Para hacer efectiva esta garantía, deberán presentar el producto al lugar donde fue adquirido junto con una copia de su garantía proporcionada por la empresa.
                    2.El tiempo de reparación en ningún caso será mayor de 15 días habiles contados a partir de la fecha de recepción del producto por parte  de Click. 
                    3.Favor de Leer Cuidadosamente las Instrucciones de Uso é Instalación del fabricante, antes de encender el equipo, así como los Términos de la Presente Póliza.
                    Su garantia perdera validez en los siguientes casos:
                    1.Cuando el producto ha sido utilizado en condiciones distintas a las indicadas en sus especificaciones ambientales. 
                    2.Cuando el producto no ha sido operado de acuerdo con el manual de uso proporcionado.  
                    3.Cuando el producto haya sufrido daños por sobrecarga eléctrica, daños físicos, daños accidentales, derrame de líquidos o cualquier otro tipo de mal uso por parte del consumidor.
                    4.Cuando el producto ha sido alterado ó reparado por personas  no autorizadas por la empresa.
                    5.Si el sello de garantía ha sido removido o alterado por personal ajeno a la empresa. 
                    6.La Garantía NO cubre desgaste normal de la unidad o mantenimientos Preventivos. 
                    7.Esta garantía no cubre el software instalado en computadoras, por lo que el Cliente acepta completa responsabilidad por su software y datos, incluyendo la responsabilidad de tener sus respaldos (copia de seguridad). 
                    8.La reparación o reemplazo de un producto durante la garantía, no extenderá el término original  de la  garantía.

                </p><br/><br/><br/>
                <p>
                    <table border="0" width="100%">
                        <tr>
                            <td align="center">________________________</td>
                            <td align="center">________________________</td>
                        </tr>
                        <tr>
                            <td align="center">Firma del vendedor</td>
                            <td align="center">Sello</td>
                        </tr>
                    </table>  
                </p>
            </div>
        </div> 
    </div>
</body>
<style>
    #garantia {
        width:750px;
    }

    #garantia_detalle {
        height:490px;  
    }
    
    .table {
        border-spacing: 0;
        margin-top:25px;
    }

    .table {
      color:#666;
      font-size:12px;
      background:#eaebec;
      border:#ccc 1px solid;
  }

  .table tr th {
      padding:5px 5px 5px 5px !important;
      background: #fafafa;
      text-align: center !important;
      border-bottom:1px solid #e0e0e0 !important;
  }

  .table tr td {
      padding:2px !important;
      border-bottom:1px solid #e0e0e0 !important;
      border-left: 1px solid #e0e0e0 !important;
      background: #fafafa;
  }
  
  .table tr:last-child td{
      border-bottom:0;
  }


</style>