var app = new Vue({

    el: '#forms',

    data: {

        cliente: [],
        venta_id: 0,
        showNewCustomerForm: false,
        showEditCustomerForm: false,
        detalle: false,
        detalleTable: [],
        totalVenta: 0,
        editedTodo: null,
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
            app.showNewCustomerForm = false;
            app.showEditCustomerForm = false;
            app.detalle = false;
        },

        editItem: function (e) {
            this.beforeEditCache = e.dt.cantidad;
            this.editedTodo = e;
        },

        cancelEdit: function (e) {
            this.editedTodo = null;
            e.dt.cantidad = this.beforeEditCache;
        },

        doneEdit: function (e) {
            e.dt.cantidad = e.dt.cantidad.trim();
            if (!e.dt.cantidad) {
                this.editedTodo = null;
                e.dt.cantidad = this.beforeEditCache;
                return;
            }
            var that = this;
            e.dt.cantidad = parseInt(e.dt.cantidad);
            $.ajax({
                type: 'POST',
                url: 'user/ventas/UpdateDetalle',
                data: { values: e.dt, oldvalue: this.beforeEditCache },
                success: function (data) {
                    console.log(data);
                    if (data.success == true)
                    {
                        that.editedTodo = null;
                        return msg.success('Producto actualizado', 'Listo!');
                    }
                    msg.warning(data, 'Advertencia!');
                }
            });
        },

        removeItem: function (index, id) {
            $.confirm({
                confirm: function() {
                    $.ajax({
                        type: 'POST',
                        url: 'user/ventas/RemoveSaleItem',
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

        showEditCustomer: function() {
            this.showNewCustomerForm = false;
            this.showEditCustomerForm = !this.showEditCustomerForm;
        },

        showNewCustomer: function() {
            this.showEditCustomerForm = false;
            this.showNewCustomerForm = !this.showNewCustomerForm;
        },

        getInfoCliente: function(id) {
            $.get( "/user/cliente/getInfo",  { id: id }, function( data ) {
                app.cliente = data;
                app.updateClienteId(data.id);
            });
        },

        generarVenta: function(e) {

            var form = $(e.target).closest("form");
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

                        return msg.success('Venta generada', 'Listo!');
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


        createNewCustomer: function(e) {

            var form = $(e.target).closest("form");
            $('input[type=submit]', form).prop('disabled', true);

            $.ajax({  
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {

                    if (data.success == true) {
                        app.cliente = data.info;
                        app.showNewCustomerForm = false;
                        app.updateClienteId(data.info.id);
                        return msg.success('Cliente creado', 'Listo!');
                    }

                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                },
                error: function(errors) {
                    $('input[type=submit]', form).prop('disabled', false);
                }
            });

            e.preventDefault();
        },


        editCustomer: function(e) {

            var form = $(e.target).closest("form");
            $('input[type=submit]', form).prop('disabled', true);

            $.ajax({  
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {

                    if (data.success == true) {
                        app.cliente = data.info;
                        app.showEditCustomerForm = false;
                        return msg.success('Cliente actualizado', 'Listo!');
                    }

                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                },
                error: function(errors) {
                    $('input[type=submit]', form).prop('disabled', false);
                }
            });

            e.preventDefault();
        },


        updateClienteId: function(id) {

            if (app.venta_id > 0) {
                $.ajax({
                    type: 'POST',
                    url: '/user/ventas/updateClienteId',
                    data: { venta_id: app.venta_id, cliente_id: id },
                    success: function (data) {

                        if (data.success == true)
                            return msg.success('Dato actualizado', 'Listo!');

                        msg.warning(data, 'Advertencia!');
                    }
                });
            };
        }
   }

});


function ventas_compile() {
    app.$nextTick(function() {
        app.$compile(app.$el);
    });
}