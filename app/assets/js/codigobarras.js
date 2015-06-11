$(function() {
    $(document).on("click", "#settings_barcode",    function(){ settings_barcode(this);});
    $(document).on("change", "#barcode_live", function(e){ viewCode_barcode();});
});

function settings_barcode()
{
    $.get( "admin/barcode/create", function( data )
    {
        $('.modal-body').html(data);
        $('.modal-title').text('Barcode settings');
        $('.bs-modal').modal('show');
        viewCode_barcode();
    });  
}

function viewCode_barcode()
{
    var tipo=$('#tipo_barcode').val();
    var ancho=$('#ancho_barcode').val();
    var alto=$('#alto_barcode').val();
    var letra=$('#letra_barcode').val();
    var codigo=$('#codigo_barcode').val();

    if( tipo == 'code39' )
    {
        ancho/=2;
    }

    $("#live-code").barcode(codigo, tipo,
    {
        barWidth:ancho, 
        barHeight:alto, 
        fontSize:letra,
        showHRI:true,
        moduleSize:5
    });   
}

