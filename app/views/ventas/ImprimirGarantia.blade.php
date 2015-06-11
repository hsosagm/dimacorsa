<div style="" id="garantia"> 
  <table>
    <tr>
      <td>
        <img src="http://hsystemas.com/images/click.jpg" width="127" height="83">
      </td>
    </tr>
    <tr>
      <td>
        <div id="encabezado_factura" style="display:inline-block;">
          <div style="display:inline-block;">
            <label style="margin-right: 100px;">3ra calle 13-71 zona 1, Chiquimula   Telefono: 7942-1383</label>
          </div><br>
          <div style="display:inline-block;">
            <label > {{ @$venta->created_at }} </label>
          </div>
          <div style="display:inline-block;">
            <label style="margin-left:12px;">{{ @$venta->id }}</label>
          </div><br>
          <div style="display:inline-block;">
            <label> {{ @$venta->cliente->nombre.' '.@$venta->cliente->apellido }}</label>
          </div>
          <div style="display:inline-block;">
            <label style="margin-left:12px;" id="garantia_direccion">{{ @$venta->cliente->direccion }}</label>
          </div>
          <div style="display:inline-block;">
            <label style="margin-left:12px;" id="garantia_nit">{{ @$venta->cliente->nit }}</label>
          </div>
          <div style="display:inline-block;">
            <label style="margin-left:12px;" id="garantia_telefono">{{ @$venta->cliente->telefono }}</label>
          </div>
        </div>
      </td>
    </tr>
  </table>
  
  <div id="garantia_detalle"></div>
  <div id="garantia_terminos">
    <p class="texto_garantia" align="justify" style="font-size:14px">IMPORTANTE:  Click, garantiza este producto en todos sus componentes funcionales  y mano de obra contra cualquier defecto de fabricación a partir de  la fecha de entrega, de acuerdo con las siguientes condiciones.
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
    </p><br><br><br>
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

