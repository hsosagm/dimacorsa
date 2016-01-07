<script type="text/javascript">
    var d = new Date();
    var mes = d.getMonth() +1; 
    var datos  =  {{$data}};
    var ganancias  =  {{$ganancias}};

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

                                    $("g").eq(1).hide();
                                    $("g").eq(2).hide();

                                    $('.highcharts-legend-item rect').remove();

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
                        if (chart.title.textStr == "Comparativa Por Mes") {
                            $("g").eq(1).show();
                            $("g").eq(2).show();
                        };
                        chart.tooltip.options.formatter = function()
                        {
                            if (this.series.name == 'ventas' || this.series.name == 'ganancias') {
                                return '<div class="toltip">Total ventas de'+' '+this.point.name+'</div><i>'+'Q'+' '+Highcharts.numberFormat(this.y, 2)+'</i>';
                            } else {
                                return this.point.tooltip;
                            }
                        }
                        setTimeout(function() {
                            $('.highcharts-legend-item rect').remove();
                        }, 0);
                    },

                    load: function(event) {
                        $('.highcharts-legend-item rect').remove();
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
                }, {
                name: 'ganancias',
                colorByPoint: true,
                data: ganancias
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
                                url: 'owner/chart/getComparativaMensualPorMes',
                                data: { mes: mes, method: "next" },
                            }).done(function(data) {
                                if (data.success == true)
                                {
                                    if (mes == 12) {
                                        mes = 1;
                                    } else {
                                        mes++;
                                    }
                                    var chart = $('#container').highcharts();
                                    chart.series[1].setData(data.ganancias);
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
                                url: 'owner/chart/getComparativaMensualPorMes',
                                data: { mes: mes, method: "prev" },
                            }).done(function(data) {
                                if (data.success == true)
                                {
                                    if (mes == 1) {
                                        mes = 12;
                                    } else {
                                        mes--;
                                    }
                                    var chart = $('#container').highcharts();
                                    chart.series[1].setData(data.ganancias);
                                    chart.series[0].setData(data.ventas);
                                    return;
                                }
                                msg.warning(data, 'Advertencia!');
                            }); 
                        }
                    }
                }
            },

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
                graph_container_compile();
            }
        });
    }

    function cierreDelDia(dia){
        $.ajax({
            type: "GET",
            url: 'admin/cierre/getCierreDelDia',
            data: { fecha:dia , grafica: true},
            success: function (data) {
                graph_container.x = 2;
                $('#cierres').html(data);
                graph_container_compile();
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
            },

            getAsignarInfoEnviar: function($v_model ,$v_metodo){
                cierre_model= $v_model;
                cierre_metodo_pago_id = $v_metodo;
                graph_container.getCierreConsultasPorMetodoDePago(1 , null); 
            },

            getCierreConsultasPorMetodoDePago: function(page , sSearch) {
                $.ajax({
                    type: 'GET',
                    url: "admin/cierre/consultas/ConsultasPorMetodoDePago/"+cierre_model+"?page=" + page,
                    data: {sSearch: sSearch , metodo_pago_id : cierre_metodo_pago_id , fecha: cierre_fecha_enviar, grafica:"_graficas" },
                    success: function (data) {
                        if (data.success == true) {
                            graph_container.x = 3;
                            $('#cierres_dt').html(data.table);
                        }
                        else {
                            msg.warning(data, 'Advertencia!');
                        }
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

    $(document).on('click', '.pagination_cierre_graficas a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        graph_container.getCierreConsultasPorMetodoDePago(page , null); 
    });

</script>

<div class="panel_heading">
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div v-show="x == 2" id="cierres"></div>
<div v-show="x == 3" id="cierres_dt"></div>
-