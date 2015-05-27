<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

    <!-- START @HEAD -->
    @include('proveedor_partials.head')
    <!-- END @HEAD -->
    

    <body class="page-header-fixed page-sidebar-fixed">

        <div id="loading">
            <div class="loading-inner">
                <img src="img/loader/flat/3.gif" alt="..."/>
            </div>
        </div>

        <section id="wrapper">

             <!--/ START HEADER -->
            @include('proveedor_partials.header')
            <!--/ END HEADER -->

            <!-- /#sidebar-left -->
             @include('proveedor_partials.slidebar-left')
            <!--/ END SIDEBAR LEFT -->

            <!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2><i class="fa fa-home"></i> <span id="InformationProviderSearches"></span></h2>

                </div><!-- /.header-content -->
                <!--/ End page header -->

            @include('proveedor_partials.body-content')

            @include('proveedor_partials.footer')

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->

            <!-- START @SIDEBAR RIGHT -->
            @include('proveedor_partials.slidebar-right')
            <!-- END   @SIDEBAR RIGHT -->
            
        </section>


        <div id="back-top" class="animated pulse circle">
            <i class="fa fa-angle-up"></i>
        </div>

<script src="js/proveedor.js"></script>
<script src="calendar/picker.js"></script>
<script src="calendar/picker.date.js"></script>
<script src="calendar/translations/es_ES.js"></script>


<script>

    $(document.body).delegate(":input", "keyup", function(e) {

        if(e.which == 13) {
            $(this).trigger("enter");
        }

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

    $.ui.autocomplete.prototype._renderItem = function (ul, item) {
        var term = this.term.split(' ').join('|');
        var re = new RegExp("(" + term + ")", "gi");
        var t = item.label.replace(re, "<b class='hiligth'>$1</b>");
        return $("<li></li>")
        .data("item.autocomplete", item)
        .append("<a>" + t + "</a>")
        .appendTo(ul);
    };

    $('#date-input').datepicker();

</script> 

 <script>

 $(function() {
        $("#ProviderFinder").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "user/buscar_proveedor",
                    dataType: "json",
                    data: request,
                    success: function (data) {
                        response(data);
                    },
                    error: function () {
                        response([]);
                    }
                });
            },
            minLength: 3,
            select:function( data, ui ){
                $("input[name='proveedor_id']").val(ui.item.id);

                $proveedor_id = ui.item.id;

                $.ajax({
                    type: 'POST',
                    url: 'admin/proveedor/total_credito',
                    data: {proveedor_id:$proveedor_id},
                    success: function (data) 
                    {
                        $("#InformationProviderSearches").html(ui.item.value+'  Saldo   Q: '+data);
                    },
                    error: function(errors)
                    {
                        msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
                    }
                });
            },
            autoFocus: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 100000);
            }
        });
    });

</script>

    </body>

</html>