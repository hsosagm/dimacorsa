<!DOCTYPE html>

    <?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
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
                <!-- Start page header -->
                <div class="header-content">

                    <h2><i class="fa fa-home"></i> <span v-html="infoCliente"></span></h2>
                </div><!-- /.header-content -->
                <!--/ End page header -->


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

        <script src="js/vue.min.js"></script>
        <script src="js/main.js"></script>
        <script src="js/cliente.js"></script>
        <script src="calendar/picker.js"></script>
        <script src="calendar/picker.date.js"></script>
        <script src="calendar/translations/es_ES.js"></script>

        <script>

            $('#customer_search').autocomplete({
                serviceUrl: '/user/cliente/buscar',
                onSelect: function (q) {
                    vm.cliente_id = q.id;
                    vm.infoCliente = q.value;
                    vm.getInfoCliente(q.id);
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

    </body>

</html>