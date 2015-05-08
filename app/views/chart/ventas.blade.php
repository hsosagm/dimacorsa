<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>
    $(function () {
        Highcharts.wrap(Highcharts.Chart.prototype, 'getContainer', function (proceed) {
           proceed.call(this);
           this.container.style.background = 'url(images/graph.png)';
        });

        Highcharts.theme = {
           colors: ["#56aaff", "#8cea8c", "#8d4654", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
              "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
           chart: {
              backgroundColor: null,
              style: {
                 fontFamily: "Signika, serif"
              }
           },
           title: {
              style: {
                 color: 'black',
                 fontSize: '16px',
                 fontWeight: 'bold'
              }
           },
           subtitle: {
              style: {
                 color: 'black'
              }
           },
           tooltip: {
              borderWidth: 0
           },
           legend: {
              itemStyle: {
                 fontWeight: 'bold',
                 fontSize: '13px'
              }
           },
           xAxis: {
              labels: {
                 style: {
                    color: '#6e6e70'
                 }
              }
           },
           yAxis: {
              labels: {
                 style: {
                    color: '#6e6e70'
                 }
              }
           },
           plotOptions: {
              series: {
                 shadow: true
              },
              candlestick: {
                 lineColor: '#404048'
              },
              map: {
                 shadow: false
              }
           },
           navigator: {
              xAxis: {
                 gridLineColor: '#D0D0D8'
              }
           },
           rangeSelector: {
              buttonTheme: {
                 fill: 'white',
                 stroke: '#C0C0C8',
                 'stroke-width': 1,
                 states: {
                    select: {
                       fill: '#D0D0D8'
                    }
                 }
              }
           },
           scrollbar: {
              trackBorderColor: '#C0C0C8'
           },
           background2: '#E0E0E8' 
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

            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ventas de los ultimos 12 meses'
                },
                xAxis: {
                    categories: [
                        '<?php echo $dt->month(12) ?>',
                        '<?php echo $dt->month(11) ?>',
                        '<?php echo $dt->month(10) ?>',
                        '<?php echo $dt->month(9) ?>',
                        '<?php echo $dt->month(8) ?>',
                        '<?php echo $dt->month(7) ?>',
                        '<?php echo $dt->month(6) ?>',
                        '<?php echo $dt->month(5) ?>',
                        '<?php echo $dt->month(4) ?>',
                        '<?php echo $dt->month(3) ?>',
                        '<?php echo $dt->month(2) ?>',
                        '<?php echo $dt->month(1) ?>',
                        '<?php echo $dt->month(0) ?>'
                    ]
                },
                credits: {
                    enabled: false
                },
                series: [{
          type: 'column',
          name: 'Ventas',
          data: [<?php echo $v[12] ?>,  <?php echo $v[11] ?>, <?php echo $v[10] ?>, <?php echo $v[9] ?>, 
                 <?php echo $v[8] ?>, <?php echo $v[7] ?>, <?php echo $v[6] ?>, <?php echo $v[5] ?>,
                 <?php echo $v[4] ?>, <?php echo $v[3] ?>, <?php echo $v[2] ?>, <?php echo $v[1] ?>,
                 <?php echo $v[0] ?>]
       }, {
          type: 'column',
          name: 'Ganancias',
          data: [<?php echo $g[12] ?>,  <?php echo $g[11] ?>, <?php echo $g[10] ?>, <?php echo $g[9] ?>, 
                 <?php echo $g[8] ?>, <?php echo $g[7] ?>, <?php echo $g[6] ?>, <?php echo $g[5] ?>,
                 <?php echo $g[4] ?>, <?php echo $g[3] ?>, <?php echo $g[2] ?>, <?php echo $g[1] ?>,
                 <?php echo $g[0] ?>]
          }],
          yAxis: {
            title: {
                text: 'Valores'
            },
            labels: {
                formatter: function(){
                    var num = this.value;
                    var num = accounting.formatMoney(num, "Q   ", 2, ",", ".");
                    return num;
                }
            }
          },
        });
    });
</script>