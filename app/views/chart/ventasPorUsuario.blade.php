<style type="text/css">
    #container {
        min-width: 310px;
        margin: 0 auto;
        height: 400px; 
    }
</style>


<script type="text/javascript">

    var data =  {{$data}};

    $(function () {

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
                }
            },
            xAxis: {
                categories: Highcharts.getOptions().lang.shortMonths
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                name: 'Ventas por usuario',
                data: data
            }]
        });
    });

</script>

<div id="container"></div>