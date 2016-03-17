<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
    <body>
        <table width="100%" cellspacing="0">
            <thead>
                <tr style="background-color: #D5D5D5;">
                    <th width="1%">No.</th>
                    <th width="40%">Cliente</th>
                    <th width="45%">Direccion</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @php($num = 1)
                @foreach($data['clientes'] as $cl)
                    <tr style="{{($num%2)?'background-color: #FFFFFF;':'background-color: #ECECEC;'}}">
                        <td width="1%"> {{ $num }} </td>
                        <td width="40%"> {{ $cl->cliente }} </td>
                        <td width="45%"> {{ $cl->direccion }} </td>
                        <td align="right" width="15%"> {{ f_num::get($cl->total) }} </td>
                    </tr>
                    @php($num++)
                @endforeach
            </tbody>
        </table>
    </body>
</html>