<div class="panel-body" style="padding:0px;">
    <table width="100%" class="table table-default">
        <thead>
            <tr>
                <th align="center">Fecha</th>
                <th align="center">Usuario</th>
                <th align="center">Cliente</th>
                <th align="center">Tipo</th>
                <th align="center">Nota</th>
                <th align="center">Monto</th>
                <th align="center"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>  </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td class="right">  </td>
                <td>
                    <div class="ckbox ckbox-teal" style="margin-left:30px;">
					</div>
                </td>
            </tr>
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td> </td>
                <td> </td>
                <td class="right">  </td>
                <td>
                    <div class="ckbox ckbox-teal"  >
					</div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"></th>
                <th colspan="2">  </th>
                <th colspan="2"> </th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <table width="100%" class="table table-default">
        <thead>
            <tr>
                <th align="center">Fecha</th>
                <th align="center">Usuario</th>
                <th align="center">Cliente</th>
                <th align="center">Tipo</th>
                <th align="center">Nota</th>
                <th align="center">Monto</th>
                <th align="center"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>  </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td class="right">  </td>
                <td>
                    <div class="ckbox ckbox-teal" style="margin-left:30px;">
					</div>
                </td>
            </tr>
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td> </td>
                <td> </td>
                <td class="right">  </td>
                <td>
                    <div class="ckbox ckbox-teal"  >
					</div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"></th>
                <th colspan="2">  </th>
                <th colspan="2"> </th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <?php
        $producto = Existencia::whereProductoId(1005579)->whereTiendaId(1)->first();
        $existencia = Existencia::find($producto->id);
        $existencia->existencia = $existencia->existencia - 1;
        if ($existencia->save()) {
            echo "<h1>success</h1>";
        }
    ?>
</div>
