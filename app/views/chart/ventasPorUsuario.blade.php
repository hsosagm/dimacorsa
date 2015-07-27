<style type="text/css">
    #container {
        min-width: 310px;
        margin: 0 auto;
        height: 400px; 
    }
</style>


<script type="text/javascript">

    var totales  =  {{$totales}};
    var usuarios =  {{$usuarios}};

    $(function () {

        Highcharts.setOptions({
            lang: {
                decimalPoint: '.',
                thousandsSep: ','
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
                    beta: 25,
                    depth: 90
                }
            },
            title: {
                text: 'Ventas de usuarios mes actual'
            },
            plotOptions: {
                column: {
                    depth: 100
                },
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
                            return Highcharts.numberFormat(this.y, 2);
                        },
                    }
                }
            },
            tooltip: {
                enabled: false
            },
            xAxis: {
                categories: usuarios
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
            series: [{
                name: 'Ventas por usuario',
                colorByPoint: true,
                data: totales
            }]
        });
    });

</script>

<div id="container"></div>