<script src="<?php echo Yii::app()->baseUrl; ?>/themes/tutorialzine1/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
   
    $(document).ready(function() {
   
    var fetchDashboardElements = 'fetchDashboardElements';
    var gadgetType             = 'Charts';
    
    $.ajax({
     type:'POST',
     url: '<?php echo Yii::app()->baseUrl; ?>/dash/Dash',
     data: {'ajaxForwardRequest' : fetchDashboardElements, 'gadgetType' : gadgetType},
     success: function(stringified){
    
      var data = $.parseJSON(stringified);

      //Abhinandan.  Parse string elements to int type..
      for(var i = 0; i < data.length; ++i){
       for(var j=0; j <data[i].length; ++j){
        if(j == 0)
        {
         data[i][j] = (parseInt( data[i][j], 10 ) * 1000) ;  //Abhinandan.  Convert timestamp x1000; Because Highcharts reads in milliseconds..
        }
        else if(j == 1)
        {
         data[i][j] = parseFloat( data[i][j] );
        }
       }
      }
      
      //console.log('data is ' + data);
       
      
      var masterChart,
        detailChart;   
    
        // create the master chart
        function createMaster() {
            masterChart = new Highcharts.Chart({
                chart: {
                    renderTo: 'master-container',
                    reflow: false,
                    borderWidth: 0,
                    backgroundColor: null,
                    marginLeft: 50,
                    marginRight: 20,
                    zoomType: 'x',
                    events: {
    
                        // listen to the selection event on the master chart to update the
                        // extremes of the detail chart
                        selection: function(event) {
                            var extremesObject = event.xAxis[0],
                                min = extremesObject.min,
                                max = extremesObject.max,
                                detailData = [],
                                xAxis = this.xAxis[0];
    
                            // reverse engineer the last part of the data
                            jQuery.each(this.series[0].data, function(i, point) {
                                if (point.x > min && point.x < max) {
                                    detailData.push({
                                        x: point.x,
                                        y: point.y
                                    });
                                }
                            });
    
                            // move the plot bands to reflect the new detail span
                            xAxis.removePlotBand('mask-before');
                            xAxis.addPlotBand({
                                id: 'mask-before',
                                from: Date.UTC(2006, 0, 1),
                                to: min,
                                color: 'rgba(0, 0, 0, 0.2)'
                            });
    
                            xAxis.removePlotBand('mask-after');
                            xAxis.addPlotBand({
                                id: 'mask-after',
                                from: max,
                                to: Date.UTC(2008, 11, 31),
                                color: 'rgba(0, 0, 0, 0.2)'
                            });
    
    
                            detailChart.series[0].setData(detailData);    						
                            return false;
                        }
                    }
                },
                title: {
                    text: null
                },
                xAxis: {
                    type: 'datetime',
                    showLastTickLabel: true,
                    maxZoom: 14 * 24 * 3600000, // fourteen days
                    plotBands: [{
                        id: 'mask-before',
                        from: Date.UTC(2006, 0, 1),
                        to: Date.UTC(2008, 7, 1),
                        color: 'rgba(0, 0, 0, 0.2)'
                    }],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    gridLineWidth: 0,
                    labels: {
                        enabled: false
                    },
                    title: {
                        text: null
                    },
                    min: 0.6,
                    showFirstLabel: false
                },
                tooltip: {
                    formatter: function() {
                        return false;
                    }
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        fillColor: {
                            linearGradient: [0, 0, 0, 70],
                            stops: [
                                [0, '#4572A7'],
                                [1, 'rgba(0,0,0,0)']
                            ]
                        },
                        lineWidth: 1,
                        marker: {
                            enabled: false
                        },
                        shadow: false,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        enableMouseTracking: false
                    }
                },
    
                series: [{
                    type: 'area',
                    name: 'Calcium',
                    pointInterval: 24 * 3600 * 1000,
                    pointStart: Date.UTC(2006, 0, 01),
                    data: data
                }],
    
                exporting: {
                    enabled: false
                }
    
            }, function(masterChart) {
                createDetail(masterChart)
            });
        }
    
        // create the detail chart
        function createDetail(masterChart) {
           
            //console.log(masterChart);  //Abhinandan. Feb25th..
    
            // prepare the detail chart
            var detailData = [],
                detailStart = Date.UTC(2008, 7, 1);
    
            jQuery.each(masterChart.series[0].data, function(i, point) {
                if (point.x >= detailStart) {
                    detailData.push(point.y);
                }
            });
            
            
            
            // create a detail chart referenced by a global variable
            detailChart = new Highcharts.Chart({
                chart: {
                    marginBottom: 120,
                    renderTo: 'detail-container',
                    reflow: false,
                    marginLeft: 50,
                    marginRight: 20,
                    style: {
                        position: 'absolute',
                    }
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Elemental Analysis - Calcium'
                },
                subtitle: {
                    text: 'Select an area by dragging across the lower chart'
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    maxZoom: 0.1
                },
                tooltip: {
                           
                    formatter: function() {             //%A %B %e %Y
                        var point = this.points[0];
                        return '<b>'+ point.series.name +'</b><br/>'+
                            Highcharts.dateFormat('%a %d %b %H:%M:%S ', this.x) + ':<br/>'+
                            Highcharts.numberFormat(point.y, 2) + ' units';
                    },
                    
                    shared: true
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: false,
                            states: {
                                hover: {
                                    enabled: true,
                                    radius: 3
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Calcium',
                    pointStart: detailStart,
                    pointInterval: 24 * 3600 * 1000,
                    data: detailData
                }],
    
                exporting: {
                    enabled: false
                }
    
            });
        }
    
        // make the container smaller and add a second container for the master chart
        var $container = $('#containerHC')
            .css('position', 'relative');
    
        var $detailContainer = $('<div id="detail-container">')
            .appendTo($container);
    
        var $masterContainer = $('<div id="master-container">')
            .css({ position: 'absolute', top: 300, height: 80, width: '80%' })
            .appendTo($container);
    
        // create master and in its callback, create the detail chart
        createMaster();
      
       
       /*  
    var data = [
                [(1361901685 * 1000),69.10],   
                [(1361901688 * 1000),69.61],
                [(1361901680 * 1000),67.72],
                [(1361901683 * 1000),65.48],
                [(1361901735 * 1000),66.31],
                [(1361901737 * 1000),65.66],
                [(1361901751 * 1000),63.93],
                [(1361901753 * 1000),63.19],
                [(1361901767 * 1000),65.68]
    ];
    */
      
       
     }  //end ajax success.. 
      
    }); //end ajax..
    
  
    
    
    
    }); //end document.ready..

</script>

<script src="<?php echo Yii::app()->baseUrl; ?>/assets/AGHCharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/assets/AGHCharts/modules/exporting.js"></script>

<!-- <div id="containerHC" style="min-width: 400px; height: 400px; margin: 0 auto;"></div>  -->
