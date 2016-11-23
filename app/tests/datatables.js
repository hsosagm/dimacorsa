oTable.fnFilter( this.value );


var oTable =  $('#example'). dataTable();
$('#example').on('click', 'tr', function(){
    var oData = oTable.fnGetData(this);
    console.log(oData);
})

get id of row
https://datatables.net/forums/discussion/20921/get-the-dt-rowid-when-i-click-on-a-cell
this.parentNode.id

para agregar row
<script type="text/javascript">
 var counter=1;
     function fnClickAddRow() {
       $('#example').dataTable().fnAddData( [
         "20",
         "Alice",
         "Paul",
         "40,000",
         "A"] );
       counter++;
     }
  </script>

para agregar class
    "aoColumnDefs": [
      { "sClass": "my_class", "aTargets": [ 0 ],
      { "bVisible": false, "aTargets": [ 0 ]}
    ]


para agregar una columna
     "aoColumnDefs": [
           {
               "aTargets":[7],
               "fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
               {
                   $(nTd).css('text-align', 'center');
               },
               "mData": null,
               "mRender": function( data, type, full) {    // You can use <img> as well if you want
                   return '<td><a href="edit.php?id='+'$Row'+'" class="reject">edit</a></td>';
               }
           }

]

$("#example tbody tr").on('click',function(event) {
   var value=$(this).closest('tr').children('td:first').text();
   alert(value);
  })


tr.row_selected td{background-color:red !important;}

http://datatables.net/release-datatables/extras/ColReorder/col_filter.html

http://tableclothjs.com/

https://datatables.net/usage/server-side

        $('#example').dataTable({

          aoColumns: [
                     { "sTitle": "Nombre" },
                     { "sTitle": "Direccion" },
                     { "sTitle": "Telefono" },
                     { "sTitle": "Contacto" },

                     {
                       "sTitle": "Contacto",
                           "mRender": function ( data, type, full ) {
                             return '<a href="#" id="'+data+'" onclick="del_prov('+data+')">Eliminar</a>';
                           }
                      },
                   ],


$('#Accumulate').click(function(){
    oTable.fnFilter("Accumulate");
});

.dataTables_filter {
     display: none;
}


$("tr td:nth-child(2));

var table = $('#example').DataTable();

table.ajax.reload( function ( json ) {
    $('#myInput').val( json.lastInput );
} );


$row['DT_RowClass'] = "mi clase";

https://datatables.net/reference/option/displayStart

https://datatables.net/reference/api/page.info%28%29

// para filtrar por pagina

jQuery.fn.dataTableExt.oApi.fnDisplayStart = function ( oSettings, iStart, bRedraw )
{
    if ( typeof bRedraw == 'undefined' ) {
        bRedraw = true;
    }

    oSettings._iDisplayStart = iStart;
    if ( oSettings.oApi._fnCalculateEnd ) {
        oSettings.oApi._fnCalculateEnd( oSettings );
    }

    if ( bRedraw ) {
        oSettings.oApi._fnDraw( oSettings );
    }
};

var table = $('#example').dataTable({});

table.fnDisplayStart(32);