<style type="text/css">
    #container {
        min-width: 310px;
        margin: 0 auto;
        height: 400px; 
    }
</style>

<script type="text/javascript">

    var data  =  {{$data}};

    var graphTitle = [];
    var graphPosition = 0;
    graphTitle[graphPosition] = "Totales De Ventas Por Año";

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
                marginLeft: 75,
                marginRight: 25,
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
                            chart.showLoading('Loading data ...');

                            $.ajax({
                                type: 'GET',
                                url: e.point.url,
                                data: e.point.variables,
                                success: function (data)
                                {
                                    var data = JSON.parse(data);
                                    var toltip = data.tooltip;
                                    graphPosition++;
                                    chart.hideLoading();

                                    var title = data['title']+' '+e.point.name;
                                    chart.setTitle({ text: graphTitle[graphPosition] = title });


                                    chart.addSeriesAsDrilldown(e.point, data = {name: data['name'], colorByPoint: true, data: data['data']});
                                    chart.tooltip.options.formatter = function()
                                    {
                                        console.log(this.point.tooltip);
                                        return this.point.tooltip;
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
                        return Highcharts.numberFormat(this.value, 2);
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
                            if(this.series.name == 'Gastos') {
                                var num = this.y / 1000;
                                return Highcharts.numberFormat(num, 1);
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
                formatter: function() {
                    return 'Total ventas de'+' '+this.point.year+'<br/>'+'<b>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</b>';
                }
            },

            series: [{
                name: 'ventas por año',
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

function cierreDelMes(year, month){
    fecha = year + '-' + month +'-01';

    $.ajax({
        type: "GET",
        url: 'admin/cierre/CierreDelMesPorFecha',
        data: { fecha:fecha , grafica:'show' },
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            $('.dt-container-cierre').html(data);
            $('.dt-container').hide();
            $('.dt-container-cierre').show();
        }
    });
}

function test2(){
    alert('si2');
}

</script>

<div id="container"></div>