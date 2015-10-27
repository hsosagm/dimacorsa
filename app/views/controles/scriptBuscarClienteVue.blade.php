
<script type="text/javascript">
    $('#cliente').autocomplete({
        serviceUrl: '/user/cliente/search',
        onSelect: function (data) {
            app.getInfoCliente(data.id);
            $('#cliente').val("");
            app.verCliente = true;
            $(".inputGuardarVenta").focus();
        }
    });

    app.$nextTick(function() {
        app.$compile(app.$el);
        app.reset();
    });
</script>
