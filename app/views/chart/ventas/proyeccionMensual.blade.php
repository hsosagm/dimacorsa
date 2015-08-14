<script type="text/javascript">
    $(function () {
        var chart;
        $(document).ready(function() {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container'
                },
                title: {
                    text: 'Ventas Mensuales',
                    x: -20 //center
                },
                subtitle: {
                    text: 'Proyeccion de ventas para los proximos tres meses',
                    x: -20
                },
                xAxis: {
                    allowDecimals: false,
                    labels: {
                        formatter: function() {
                           return this.value;
                        }
                    }
                },

                plotOptions: {
                    series: {
                        pointStart: 2012
                    }
                },
                series: [{
                    name: 'Actual',
                    type: 'areaspline',
                    color: '#4572A7',
                    data: [ 100, 200, 150 ]
                }, {
                    name: 'Futuro',
                    dashStyle: 'dot',
                    color: '#4572A7',
                    data: [ [ 2014, 150 ], [ 2015, 125 ], [ 2016, 250 ], [ 2017, 137.5 ] ]
                }]
            });
        });
        
    });
</script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>