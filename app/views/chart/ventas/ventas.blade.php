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
                marginLeft: 100,
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

                                    chart.addSeriesAsDrilldown(e.point, data = {name: data['name'], colorByPoint: true, data: data['data']});

                                    chart.tooltip.options.formatter = function()
                                    {
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
                            if (this.series.name == 'ventas por año') {
                                return 'Total ventas de'+' '+this.point.year+'<br/>'+'<b>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</b>';
                            } else {
                                return this.point.tooltip;
                            }
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
        var fecha = year + '-' + month +'-01';
        $.ajax({
            type: "GET",
            url: 'admin/cierre/CierreDelMesPorFecha',
            data: { fecha: fecha , grafica: true },
            success: function (data) {
                graph_container.x = 2;
                $('#cierres').html(data);
            }
        });
    }

    function cierreDelDia(dia){
        $.ajax({
            type: "GET",
            url: 'admin/cierre/CierreDelDiaPorFecha',
            data: { fecha:dia , grafica: true},
            success: function (data) {
                graph_container.x = 2;
                $('#cierres').html(data);
            }
        });
    }


    function getVentasPorHoraPorUsuario(fecha){
        $.ajax({
        type: 'GET',
        data: { fecha:fecha , grafica: true},
        url: "user/ventas/getVentasPorHoraPorUsuario",
        success: function (data) {
            if (data.success == true) {
                graph_container.x = 2;
                $('#cierres').html(data.table);
                return 0;
            }
            msg.warning('Hubo un error intentelo de nuevo', 'Advertencia!');
            }
        }); 
    }

    var graph_container = new Vue({

        el: '#graph_container',

        data: {
            x: 1,
        },

        methods: {

            reset: function() {
                graph_container.x = graph_container.x - 1;
            },

            close: function() {
                $('#graph_container').hide();
            },

            getVentasDelMes: function (e,fecha) {
                $.ajax({
                    type: "GET",
                    url: 'admin/cierre/VentasDelMes',
                    data: { fecha: fecha , grafica: true},
                    success: function (data) {
                        $('#cierres_dt').html(data);
                    }
                });
            },

            getSoporteDelMes: function (e,fecha) {
                $.ajax({
                    type: "GET",
                    url: 'admin/cierre/SoportePorFecha',
                    data: { fecha:fecha, grafica: true  },
                    success: function (data, text) {
                        $('#cierres_dt').html(data);
                    }
                });
            },

            getGastosDelMes: function (e,fecha) {
                 $.ajax({
                    type: "GET",
                    url: 'admin/cierre/GastosPorFecha',
                    data: { fecha:fecha, grafica: true },
                    success: function (data, text) {
                        $('#cierres_dt').html(data);
                    }
                });
            }
        }
    });

    function graph_container_compile() {
        graph_container.$nextTick(function() {
            graph_container.$compile(graph_container.$el);
        });
    }

</script>

<div class="panel_heading">
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container"></div>
<div v-show="x == 2" id="cierres"> </div>
<div v-show="x == 3" id="cierres_dt"></div>