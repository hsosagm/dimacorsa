var app = new Vue({

    el: '#formsContainerVue',

    data: {
        cliente: [],
        venta_id: 0,
        showNewCustomerForm: false,
        showEditCustomerForm: false,
        detalle: false,
        detalleTable: [],
        totalVenta: 0,
        totalCotizacion: 0,
        totalAdelanto: 0,
        editedTodo: null,
        cotizacion_id: 0,
    },

    computed: {

        FullName: function () {
            return this.cliente.nombre + ' ' + this.cliente.apellido
        }
    },

    watch: {
        'detalleTable': function () {
            app.$compile(app.$el);
            var sum = 0;
            for (var i = this.detalleTable.length - 1; i >= 0; i--) {
                sum += parseFloat(this.detalleTable[i]["total"]);
            }
            this.totalVenta = sum;
            this.totalCotizacion = sum;
            this.totalAdelanto = sum;
        }
    },

    directives: {
        'item-focus': function () {
            this.el.focus();
        }
    },

    methods: {

        reset: function() {
            app.cliente = [];
            app.venta_id = 0;
            app.cotizacion_id = 0;
            app.showNewCustomerForm = false;
            app.showEditCustomerForm = false;
            app.detalle = false;
        },

        doneEditCotizacion: function (e, t) {
            e.dt.cantidad = parseInt(e.dt.cantidad);
            $.ajax({
                type: 'POST',
                url: 'user/cotizaciones/UpdateDetalle',
                data: { values: e.dt, cotizacion_id: e.dt.cotizacion_id, oldvalue: this.beforeEditCache, field: t.target.getAttribute('field') },
                success: function (data) {
                    if (data.success == true)
                    {
                        $('.body-detail').html(data.table);
                        app.$compile(app.$el);
                        return msg.success('Producto actualizado', 'Listo!');
                    }
                    msg.warning(data, 'Advertencia!');
                }
            });
        },

        removeItemCotizacion: function (index, id) {
            $.confirm({
                confirm: function() {
                    $.ajax({
                        type: 'POST',
                        url: 'user/cotizaciones/removeItemCotizacion',
                        data: { id: id },
                        success: function (data) {
                            if (data.success == true)
                            {
                                app.detalleTable.$remove(index);
                                return msg.success('Producto eliminado', 'Listo!');
                            }
                            msg.warning(data, 'Advertencia!');
                        }
                    });
                }
            });
        },

        generarCotizacion: function(e) {
            var form = $(".form-generarCotizacion");
            $('button[type=submit]', form).prop('disabled', true);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {
                    if (data.success == true)
                    {
                        $('form .footer').hide();
                        $('.master-detail-body').slideUp('slow',function() {
                            $('.master-detail-body').html(data.detalle);
                            $('.master-detail-body').slideDown('slow', function() {
                                $('#search_producto').focus();
                            });
                        });
                        return msg.success('Cotizacion generada', 'Listo!');
                    }
                    msg.warning(data, 'Advertencia!');
                    $('button[type=submit]', form).prop('disabled', false);
                },
                error: function(errors) {
                    $('button[type=submit]', form).prop('disabled', false);
                }
            });
            e.preventDefault();
        },

        generarAdelanto: function(e) {
            var form = $(".form-generarAdelanto");
            $('button[type=submit]', form).prop('disabled', true);
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {
                    if (data.success == true) {
                        $('form .footer').hide();
                        $('.master-detail-body').slideUp('slow',function() {
                            $('.master-detail-body').html(data.detalle);
                            $('.master-detail-body').slideDown('slow', function() {
                                $('#search_producto').focus();
                            });
                        });
                        return msg.success('Cotizacion generada', 'Listo!');
                    }
                    msg.warning(data, 'Advertencia!');
                    $('button[type=submit]', form).prop('disabled', false);
                },
                error: function(errors) {
                    $('button[type=submit]', form).prop('disabled', false);
                }
            });
            e.preventDefault();
        }
   }

});

function ventas_compile() {
    app.$nextTick(function() {
        app.$compile(app.$el);
    });
}