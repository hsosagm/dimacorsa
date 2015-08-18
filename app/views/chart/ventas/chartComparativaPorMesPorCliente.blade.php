<script type="text/javascript">
    var d = new Date();
    var mes = d.getMonth() +1; 
    var datos  =  {{$data}};
    var cliente_id = {{ Input::get('cliente_id') }};

    var graphTitle = [];
    var graphPosition = 0;
    graphTitle[graphPosition] = "Comparativa Por Mes";

    Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
       proceed.call(this);
       this.container.style.background = 'url(images/graph.png)';
    });

    Highcharts.theme = {
       chart: {
          backgroundColor: null
       },
    };

    Highcharts.setOptions(Highcharts.theme);

    Highcharts.setOptions({
        lang: {
            printChart: 'Imprimir grafica',
            contextButtonTitle: 'Menú contextual.',
            downloadPNG: 'Descarcar en PNG',
            downloadJPEG: 'Descarcar en JPEG',
            downloadPDF: 'Descarcar en PDF',
            downloadSVG: 'Descarcar en SVG',
            exportButtonTitle: 'Exportar Grafica',
            loading: 'Cargando...',
            printButtonTitle: 'Imprimir la pagina',
            resetZoom: 'Reset zoom',
            resetZoomTitle: 'Reset zoom title',
            thousandsSep: ',',
            decimalPoint: '.'
        }
    });

    Highcharts.setOptions({
        lang: {
            drillUpText: '◁ Regresar a {series.name}'
        }
    });

    $(function () {

        $('#container').highcharts({
            chart: {
                type: 'column',
                marginLeft: 85,
                marginRight: 35,
                options3d: {
                    enabled: true,
                    alpha: 1,
                    beta: 5,
                    depth: 0
                }
            },

            title: {
                text: graphTitle[graphPosition]
            },

            xAxis: {
                type: 'category'
            },

            legend: {
                enabled: true,
                itemStyle: { "color": "#23516F" }
            },

            yAxis: {
                title: {
                    enabled: false,
                    text: ''
                },
                labels: {
                    formatter: function() {
                        return Highcharts.numberFormat(this.value, 2);
                    }
                }
            },

            plotOptions: {
                column: {
                    depth: 100
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        style: {
                            "fontWeight": 'normal'
                        },
                        formatter: function() {
                            if(this.series.name == 'Ventas por dia') {
                                var num = this.y / 1000;
                                return Highcharts.numberFormat(num, 0);
                            } else {
                                return Highcharts.numberFormat(this.y, 2);
                            }
                        },
                    }
                }
            },

            credits: {
                text: ""
            },

            tooltip: {
                useHTML: true,

                style: {
                    padding: 16,
                    fontWeight: '100',
                    color: '#5B7574'
                },

                formatter: function() {
                    return '<div class="toltip">Total ventas de'+' '+this.point.name+'</div><i>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</i>';
                }
            },

            series: [{
                name: 'ventas',
                colorByPoint: true,
                data: datos
            }],

            exporting: {
                buttons: {

                    'next': {
                        symbol: 'url(img/next.png)',
                        radius : 12,
                        symbolX:1,
                        symbolY:10,
                        x: -62,
                        y: 350,
                        height: 20,
                        width: 1,
                        onclick: function() {
                            $.ajax({
                                type: "GET",
                                url: 'user/chart/comparativaPorMesPorClientePrevOrNext',
                                data: { mes: mes, cliente_id: cliente_id, method: "next" },
                            }).done(function(data) {
                                if (data.success == true)
                                {
                                    if (mes == 12) {
                                        mes = 1;
                                    } else {
                                        mes++;
                                    }
                                    var chart = $('#container').highcharts();
                                    chart.series[0].setData(data.ventas);
                                    return;
                                }
                                msg.warning(data, 'Advertencia!');
                            }); 
                        }
                    },

                    'prev': {
                        symbol: 'url(img/prev.png)',
                        symbolX:1,
                        symbolY:10,
                        x: -100,
                        y: 350,
                        height: 20,
                        width: 1,
                        onclick: function() {
                            $.ajax({
                                type: "GET",
                                url: 'user/chart/comparativaPorMesPorClientePrevOrNext',
                                data: { mes: mes, cliente_id: cliente_id, method: "prev" },
                            }).done(function(data) {
                                if (data.success == true)
                                {
                                    if (mes == 1) {
                                        mes = 12;
                                    } else {
                                        mes--;
                                    }
                                    var chart = $('#container').highcharts();
                                    chart.series[0].setData(data.ventas);
                                    return;
                                }
                                msg.warning(data, 'Advertencia!');
                            }); 
                        }
                    }
                }
            }
        })
   });

</script>

<div class="panel_heading">
    <div class="pull-right">
        <button v-on="click: closeMainContainer" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>