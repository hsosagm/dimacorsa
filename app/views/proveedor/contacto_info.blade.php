<div class="informacion-contacto" >
   {{ @$contacto->direccion }} <br>
   {{ @$contacto->telefono1.'   '. @$contacto->telefono2.'   '. @$contacto->celular }} <br>
   {{ @$contacto->correo }}
</div>

<style>
    .informacion-contacto {
        font-size: 10px;
        margin-left: 5px;
        line-height: 130%;
    }
</style>