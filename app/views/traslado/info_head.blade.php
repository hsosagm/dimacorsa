    <div class="col-md-8 master-detail-info">
        <div class="row">
            <div class="col-md-4">
                Tienda Origen: 
            </div>
            <div class="col-md-8">
                {{ $traslado->tienda->nombre .'  '. $traslado->tienda->direccion}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                Tienda Destino: 
            </div>
            <div class="col-md-8">
                {{ $destino->nombre .'  '. $destino->direccion}}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                Nota: {{ $traslado->nota }}
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 search-tienda-info"> </div>
        </div>
    </div>
