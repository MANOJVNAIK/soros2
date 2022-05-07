
<script src="<?php echo Yii::app()->baseUrl ?>/themes/tutorialzine1/js/highCharts/highstock.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl ?>/themes/tutorialzine1/js/highCharts/modules/exporting.js" type="text/javascript"></script>

<section class="main-section grid_8">
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;
        $currentTimeTick = time();

        $language = Yii::app()->language;

        if (isset($_REQUEST['plotTimeRangeStart']) && isset($_REQUEST['plotTimeRangeEnd'])) {


            $strtStr = $_REQUEST['plotTimeRangeStart'] . ' ' . $_REQUEST['plotTimeRangeStart_Time'];
            $endStr = $_REQUEST['plotTimeRangeEnd'] . ' ' . $_REQUEST['plotTimeRangeEnd_Time'];

            $startDate = $_REQUEST['plotTimeRangeStart'];
            $startTime = $_REQUEST['plotTimeRangeStart_Time'];


            $endDate = $_REQUEST['plotTimeRangeEnd'];
            $endTime = $_REQUEST['plotTimeRangeEnd_Time'];
        } else {

            $currentTimeTick = time();
            $startDate = date('Y-m-d', $currentTimeTick - (3600 * 8));
            $startTime = date('H:i', $currentTimeTick - (3600 * 8));


            $endDate = date('Y-m-d', $currentTimeTick);
            $endTime = date('H:i', $currentTimeTick);


            $strtStr = $startDate . " " . $startTime;
            $endStr = $endDate . " " . $endTime;
        }
        ?>

        <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
    </nav>
    <div class="main-content" >

        <section class="container_6 clearfix" style="padding-top:0px !important;">

            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading">
                <header class="ui-widget-header ui-corner-top">
                    <h2><?php echo Yii::t('leftmenu', 'Graphs'); ?></h2>

                </header>
                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" >

                    <div class="clearfix padding" style="padding:5px;border:1px solid lightgray;">
                        <form  name="plotoryformsubmit" id="plotoryformsubmit" method="post" action="#">
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'Start Time') ?> <em>*</em></label>
                                <div class="form-input">
                                    <input type="text" required="required" name="plotTimeRangeStart" id="timeRangeStart" autocomplete="off" value="<?php echo $startDate; ?>" >
                                    <span>
                                        <input type="text" name="plotTimeRangeStart_Time" id="plotTimeRangeStart_Time" autocomplete="off" class="timepick" value="<?php echo $startTime; ?>" size="5" maxlength="5" />
                                        <input type="hidden" name="start_date" id="start_dateString"  size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'End Time') ?> <em>*</em></label>
                                <div class="form-input"><input type="text" required="required" name="plotTimeRangeEnd" id="timeRangeEnd" autocomplete="off" value="<?php echo $endDate; ?>" >
                                    <span>
                                        <input type="text" name="plotTimeRangeEnd_Time" id="plotTimeRangeEnd_Time" class="timepick" size="5" maxlength="5" value="<?php echo $endTime; ?>"/>
                                        <input type="hidden" name="end_date" id="end_dateString"  size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="form-action clearfix flLeft" style="width:150px;">
                                <label class="form-label" for="form-name"><?php echo Yii::t('leftmenu', 'History') ?> </label>
                                <div class="form-input">
                                    <button id="plotoryformsubmitBut" data-icon-primary="ui-icon-circle-check" type="button" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">
<?php echo Yii::t('dash', 'SUBMIT') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <div class="grid_6 leading"                    
                 <section class="ui-widget-content ui-corner-bottom">

                    <div id="kumar"></div>
<?php


$gr_elements =LabUtility::spElements();


$rowCnt = 0;
foreach ($gr_elements as $grEle) {
    if ($grEle != "" && $grEle != " " && $grEle != "LocalendTime") {

        $aObject = new AnalysisDataObject($strtStr, $endStr);
        $records = $aObject->getRecords();

        $series[$grEle]['analysis'] = LabUtility::getChartColumn($records, $grEle);

        if (LabUtility::isSpEle($grEle)) {
            $spArray = LabUtility::getChartSpColumn($records, $grEle);

            $series[$grEle]['setpoint'] = $spArray;

            $series[$grEle]['tolerence_u_limit'] = LabUtility::getChartSpUtoleranceColumn($records, $grEle);
            ;
            $series[$grEle]['tolerence_l_limit'] = LabUtility::getChartSpLtoleranceColumn($records, $grEle);
        }
    }


    echo ' <div class="grid_3 portlet ui-sortable clearfix padMargin collapsible" draggable="true" id="GraphCont_3333">
                                                <header class="ui-widget-header ui-corner-top">
                                                        <h2>' . Yii::t('app', $grEle . '-Plot') . '</h2>
                                                </header>
                                                <section id="section_3333"> 
                                                 <div class="ui-widget portlet-content">
                                                        <div id="graph_' . $grEle . '"> </div>
                                                 </div>
                                                </section>
                                                </div>';
//                                        echo "<div id='graph_$grEle'></div>";
//					DashHelper::getMeIndvChart($grEle,$rowCnt++, 1);
}//foreach
?>
                </section>
            </div><!--  grid_6 -->
        </section><!-- section -->
    </div><!-- main -->
</section><!-- section main -->

<script type="text/javascript">


    var series = <?php echo CJSON::encode($series) ?>;
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    //altFormat: "yy-mm-dd"
    $('#timeRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
    $('#timeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});


    $('.timepick1').timeslider();

    $("#plotoryformsubmitBut").click(function () {

//        debugger;
        var plotcurSTime = $('#timeRangeStart').val() + " " + $('#plotTimeRangeStart_Time').val();
        var plotcurETime = $('#timeRangeEnd').val() + " " + $('#plotTimeRangeEnd_Time').val();

        $("#start_dateString").val(plotcurSTime);
        $("#end_dateString").val(plotcurETime);
        $("#plotoryformsubmit").submit();
    });

    window.onload = function () {


        for (x in series) {


            var chartData = series[x];

            //tolerence_u_limit
            var eleData = chartData['analysis'];
            var spData = chartData['setpoint'];
            var uTollerenceData = chartData['tolerence_u_limit'];
            var lTollerenceData = chartData['tolerence_l_limit'];

            console.log(spData)


            var id = "graph_" + x;

//            console.log(id);

            Highcharts.StockChart({
                chart: {
                    renderTo: id
                },

                rangeSelector: {
                    inputEnabled: false,
                    selected: 0,
                    inputPosition: {
                        align: 'left',
                        x: 0,
                        y: 20
                    },
                    buttonPosition: {

                        align: 'left',
                        x: 0,
                        y: 20,
                    },
                    buttons: [

                        {
                            type: 'hour',
                            count: 1,
                            text: '1H',
                        }, {
                            type: 'hour',
                            count: 2,
                            text: '2H'
                        },
                        {
                            type: 'hour',
                            count: 4,
                            text: '4H'
                        },
                        {
                            type: 'all',
                            text: 'All'
                        }
                    ]
                },
                title: {
                    text: x
                },

                tooltip: {
                    valueDecimals: 2,
                },
                series: [{
                        name: x,
                        data: eleData,
                        tooltip: {
                            valueDecimals: 1,
                            valueSuffix: "%"
                        }},
                    {
                        name: "Set Point",
                        data: spData,
                    },
                    {
                        name: "Upper Tolerance",
                        data: uTollerenceData,
                    },
                    {
                        name: "Lower Tolerance",
                        data: lTollerenceData,
                    }
                ] /*uTollerenceData*/,
                lang: {
                    noData: "No data available"
                },
                noData: {
                    style: {
                        fontWeight: 'bold',
                        fontSize: '15px',
                        color: '#303030'
                    }
                },
                credits: false,
                exporting: {
                }


            });//Highcarts end
        }
    }

</script>
