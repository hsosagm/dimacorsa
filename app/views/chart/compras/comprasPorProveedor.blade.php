<script type="text/javascript">

    var data  =  {{$data}};

    var graphTitle = [];
    var graphPosition = 0;
    graphTitle[graphPosition] = "Totales De Compras Por Año";

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
                marginLeft: 100,
                marginRight: 30,
                options3d: {
                    enabled: true,
                    alpha: 5,
                    beta: 0,
                    depth: 50
                },

                events: {
                    drilldown: function (e) {
                        if (!e.seriesOptions) {
                            var chart = this;
                            chart.showLoading('Cargando datos...');

                            $.ajax({
                                type: 'GET',
                                url: e.point.url,
                                data: e.point.variables,
                                success: function (data)
                                {
                                    var data = JSON.parse(data);
                                    graphPosition++;
                                    chart.hideLoading();

                                    var title = data['title']+' '+e.point.name;
                                    chart.setTitle({ text: graphTitle[graphPosition] = title });

                                    chart.addSeriesAsDrilldown( e.point, { name: data['name'], colorByPoint: true, data: data['data'] });
                                },
                                error: function(errors)
                                {
                                    msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
                                }
                            });
                        }
                    },

                    drillup: function(e) {
                        graphPosition--;
                        var chart = this;
                        chart.setTitle({ text: graphTitle[graphPosition] });
                        setTimeout(function() {
                            
                        }, 0);
                    },
                }
            },

            title: {
                text: graphTitle[graphPosition]
            },

            xAxis: {
                type: 'category'
            },

            legend: {
                enabled: false
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
                    depth: 60
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        style: {
                            "fontWeight": 'normal'
                        },
                        formatter: function() {
                            return Highcharts.numberFormat(this.y, 2);
                        },
                    }
                }
            },

            credits: {
                enabled: false
            },

            tooltip: {
                enabled: false
            },

            series: [{
                name: 'compras',
                colorByPoint: true,
                data: data
            }],

            drilldown: {
                drillUpButton: {
                    position: {
                        y: -37,
                        x: -33
                    },
                    theme: {
                        fill: 'white', 'stroke-width': 1,
                        stroke: 'silver',
                        r: 0,
                        states: {
                            hover: {
                                fill: '#E9FDCF'
                            },
                            select: {
                                stroke: '#039',
                                fill: '#E9FDCF'
                            }
                        }
                    }
                },
                series: []
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