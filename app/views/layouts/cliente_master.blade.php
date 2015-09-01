<!DOCTYPE html>

<?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
<?php  $tema = Tema::where('user_id', Auth::user()->id)->first(); ?>
<!-- START @HEAD -->
@include('cliente_partials.head')
<!-- END @HEAD -->

<body style="display: block;" class="page-header-fixed page-sidebar-fixed page-footer-fixed">

    <section id="wrapper">

     <!--/ START HEADER -->
     @include('cliente_partials.header')
     <!--/ END HEADER -->

     <!-- /#sidebar-left -->
     @include('cliente_partials.slidebar-left')
     <!--/ END SIDEBAR LEFT -->

     <!-- START @PAGE CONTENT -->
     <section id="page-content">

        <div id="loader"><div class="spinner flat"></div></div>

        <div class="header-content">
            <h2><a href="/" class="fa fa-home" style="font-size:22px;" onclick="limpiar_home();"></a> <span v-html="infoCliente" id="infoSaldosTotales"></span></h2>
        </div>


        @include('cliente_partials.body-content')

        @include('cliente_partials.footer')

    </section><!-- /#page-content -->
    <!--/ END PAGE CONTENT -->

    <!-- START @SIDEBAR RIGHT -->
    @include('cliente_partials.slidebar-right')
    <!-- END   @SIDEBAR RIGHT -->
    
</section>


<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div>

<div class="graficas_auxiliar" style="display:none"></div>

<script src="js/vue.min.js"></script>
<script src="js/main.js"></script>
<script src="js/cliente.js"></script>
<script src="calendar/picker.js"></script>
<script src="calendar/picker.date.js"></script>
<script src="calendar/translations/es_ES.js"></script>
<script type="text/javascript" src="js/qz/deployJava.js"></script>
<script type="text/javascript" src="js/qz/PluginDetect.js"></script>
<script type="text/javascript" src="js/qz/qz.js"></script>
<script type="text/javascript" src="js/qz/html2canvas.js"></script>
<script type="text/javascript" src="js/qz/jquery.plugin.html2canvas.js"></script>

<script>
    $(document).ready(function(){
        /*configuracion del thema capturado de la base de datos*/ 
        $('link#theme').attr('href', 'css/themes/{{@$tema->colorSchemes}}.theme.css');
        $('.navbar-toolbar').attr('class', 'navbar navbar-toolbar navbar-{{@$tema->navbarColor}}');
        $('#sidebar-left').addClass('{{@$tema->sidebarTypeSetting}}');

        if($('#sidebar-left').hasClass('sidebar-box')){
            $('#sidebar-left').attr('class','sidebar-box sidebar-{{@$tema->sidebarColor}}');
        }
        else if($('#sidebar-left').hasClass('sidebar-rounded')){
            $('#sidebar-left').attr('class','sidebar-rounded sidebar-{{@$tema->sidebarColor}}');
        }
        else if($('#sidebar-left').hasClass('sidebar-circle')){
            $('#sidebar-left').attr('class','sidebar-circle sidebar-{{@$tema->sidebarColor}}');
        }
        else if($('#sidebar-left').attr('class') == ''){
            $('#sidebar-left').attr('class','sidebar-{{@$tema->sidebarColor}}');
        } 

        if($('#sidebar-left').hasClass('sidebar-default')){
            $('#sidebar-type-default').attr('checked','checked');
        }
        if($('#sidebar-left').hasClass('sidebar-box')){
            $('#sidebar-type-box').attr('checked','checked');
        }
        if($('#sidebar-left').hasClass('sidebar-rounded')){
            $('#sidebar-type-rounded').attr('checked','checked');
        }
        if($('#sidebar-left').hasClass('sidebar-circle')) {
            $('#sidebar-type-circle').attr('checked','checked');
        }

    }); 
</script>
<script>

    $('#customer_search').autocomplete({
        serviceUrl: '/user/cliente/search',
        onSelect: function (q) {
            vm.cliente_id = q.id;
            vm.infoCliente = q.value;
            vm.getInfoCliente(q.id);
            $('#customer_search').val('');
            $('.montoAbono').val(0);
            vm.monto = 0;
            vm.tableDetail = '';
            if ( vm.formPayments == false ) {
                vm.closeMainContainer();
            };
        }
    });
    
    $(document.body).delegate(":input", "keyup", function(e) {

        if (e.keyCode == 13 && e.shiftKey) {
            $(this).trigger("shift_enter");
            e.preventDefault();
        }
    });

    $(document).on("keydown",".input",function(event) {
        if (event.which === 13 || event.keyCode === 13) {
            event.stopPropagation();
            var position = $(this).index('input');
            $("input, select").eq(position+1).select();
        }
    });

    $('#date-input').datepicker();

</script> 
<canvas id="hidden_screenshot" style="display:none;"></canvas>
<canvas id="barcode" style="display:none;"></canvas>
</body>

</html>