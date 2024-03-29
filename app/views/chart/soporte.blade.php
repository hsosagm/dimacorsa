<style type="text/css">

    #container {
        min-width: 310px;
        margin: 0 auto;
        height: 400px; 
    }

</style>

<script type="text/javascript">
    
$(function () {

    $("#container").html("Cargando datos del servidor...");

    $.ajax({
        type: 'POST',
        url: 'owner/soporte/graph_by_date',
        data: { start: <?php echo Input::get('start') ?>, end: <?php echo Input::get('end') ?> },
        success: function (data) {

            var graphTitle = [];
            var graphPosition = 0;
            graphTitle[graphPosition] = "Soporte de los ultimos 12 meses";

            var data = JSON.parse(data);

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

            $('#container').highcharts({

                chart: {
                    type: 'column',
                    marginLeft: 75,
                    marginRight: 25,
                    options3d: {
                        enabled: true,
                        alpha: 5,
                        beta: 0,
                        depth: 50                    },

                    events: {

                        drilldown: function (e) {
                            
                            if (!e.seriesOptions) {

                                var chart = this;
                                chart.showLoading('Loading data ...');

                                $.ajax({
                                    type: 'POST',
                                    url: 'owner/soporte/graph_by_day',
                                    data: { year: e.point.year, month: e.point.month },
                                    success: function (data)
                                    {
                                        var data = JSON.parse(data);
                                        graphPosition++;
                                        chart.hideLoading();
                                        var title = data['title']+' '+e.point.name+' '+'de'+' '+e.point.year;
                                        chart.setTitle({ text: graphTitle[graphPosition] = title });
                                        chart.addSeriesAsDrilldown(e.point, data = { data: data['data'] });
                                        chart.tooltip.options.formatter = function()
                                        {
                                            return this.point.dia;
                                        };
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
                            chart.tooltip.options.formatter = function()
                            {
                                return this.point.name+' '+'de'+' '+this.point.year+'<br/>'+'<b>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</b>';
                            }
                        }
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
                           var num = this.value;
                           var num = accounting.formatMoney(num, "", 0, ",", ".");
                           return num;
                     
                        }
                    }
                },
                plotOptions: {
                    column: {
                        depth: 25
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            formatter: function() {
                                if(this.series.name == 'Soporte') {
                                    var num = this.y / 1000;
                                    return Highcharts.numberFormat(num, 1);
                                } else {
                                    var num = this.y;
                                    return Highcharts.numberFormat(num, 0);
                                }
                            },
                        }
                    }
                },
                credits: {
                    text: ""
                },
                tooltip: {
                    formatter: function() {
                        return this.point.name+' '+'de'+' '+this.point.year+'<br/>'+'<b>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</b>';
                    }
                },
                series: [{
                    name: 'Soporte',
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
                            fill: 'white',
                            'stroke-width': 1,
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
        },
        error: function(errors)
        {
            msg.error('Hubo un error, intentelo de nuevo', 'Advertencia!');
        }
    });

});

</script>

<div id="container"></div>