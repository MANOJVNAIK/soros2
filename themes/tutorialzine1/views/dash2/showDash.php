<style type="text/css">
    a.longSize {width:810px !important; margin-left:5px;}

    li.selected {
        background:orange !important;
        font-color:red !important;
        border:red 2px solid !important;
    }
</style>

<script type="text/javascript">

    var dashObj = {
        grabDashboardLayout: function (lay_id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->baseUrl; ?>/dash/GrabdashboardLayout',
                data: {'lay_id': lay_id},
                success: function (msg) {
                    document.location.reload(true);
                }
            });
        }
    };


</script>

<section class="main-section grid_8">
    <nav class="collapsed">
        <?php include_once( LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
    </nav>
    <div class="main-content">

        <div class="clear"><br/></div>
        <?php
        //Abhinandan. Here we will parse each active record and return a list of layout names.. (to be placed in the top menu of the dash)..
        if (isset($layouts)) {
            $layout_names = array();
            foreach ($layouts as $record) {
                $layout_names[] = $record->getAttributes(array('subname', 'lay_id'));
            }
            for ($i = 0; $i < count($layout_names); ++$i) {
                ?>
                <script type="text/javascript">
                    var li_layout = document.createElement("li");
                    li_layout.setAttribute("name", '<?php echo $layout_names[$i]["lay_id"]; ?>');
                    li_layout.setAttribute("onclick", "dashObj.grabDashboardLayout( this.getAttribute('name') ); ");
                    var li_layout_a = document.createElement("a");
                    li_layout_a.setAttribute("href", "#");
                    //li_layout_a.setAttribute("href", "<?php echo Yii::app()->baseUrl; ?>/dash");
                    li_layout_a.innerHTML = '<?php echo $layout_names[$i]["subname"]; ?>';
                    li_layout.appendChild(li_layout_a);
                    if (document.getElementById('menuItemLayouts_ul'))
                        document.getElementById('menuItemLayouts_ul').appendChild(li_layout);
                </script> 
                <?php
            }
        }

        if (count($portlets) > 0) {
            $dl = $def_layout[0]->getAttributes(array('subname', 'lay_id'));



            $pagetType = @$_REQUEST['pageType'];
            $sTime = @$_REQUEST['sTime'];
            $eTime = @$_REQUEST['eTime'];

            $tGrpInfo = @$_REQUEST['tGrp'];
            $tagInfo = @$_REQUEST['tag'];

            if ((isset($_REQUEST['pageType'])) && ($_REQUEST['pageType'] == "timeRange") && (isset($_REQUEST['sTime'])) && (isset($_REQUEST['eTime']))) {


                $curTime = strtotime($_REQUEST['eTime']);

                $sysTime = time();
                if ($sysTime <= $curTime)
                    $curTime = $sysTime;

                $curTime = date("Y-m-d H:i:s", $curTime);

                $prevTime = date("Y-m-d H:i:s", strtotime($_REQUEST['sTime']));
            }
            else {

                $curTime = date("Y-m-d H:i:s", time());
                $prevTime = date("Y-m-d H:i:s", time() - (60 * 60 * 8));
            }

            if (empty($pagetType)) {
                $notifyMsg = Yii::t('app', "Showing") . " <span style='font-weight:bold;'>" . Yii::t('app', "Real-Time") . "</span> " . Yii::t('app', "Analyzer Information");
            } else if ($pagetType == "timeRange") {
                $notifyMsg = Yii::t('app', "Showing Analysis Data between") . "<span style='font-weight:bold;'>$sTime</span> " . Yii::t('app', "And") . "<span style='font-weight:bold;'>$eTime</span>";
            } else if ($pagetType == "tagIndex") {
                $notifyMsg = Yii::t('app', "Showing Analysis Data for Tag") . ":<span style='font-weight:bold;'>$tagName</span> " . Yii::t('app', "with Start-Time") . ": <span style='font-weight:bold;'>$sTime</span> " . Yii::t('app', "And End-Time") . ":<span style='font-weight:bold;'>$eTime</span>";
            }
            ?>
            <div class="ui-state-highlight" style="text-align:center;"><?php echo $notifyMsg; ?> <br/></div>

            <section class="container_6 clearfix" style="padding:2px !important;margin-bottom:0px !important;">

                <!-- Tabs inside Portlet -->
                <div class="grid_6 grid_6Head portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all">
                    <div class="portlet ui-sortable clearfix collapsible ">
                        <header>
    <?php
    echo "<h2>" . Yii::t('dash', $dl["subname"]);
    echo '<label id="realTimeLink" style="float:right;margin-right:50px;margin-bottom:5px;" for="button-toggle2-3" aria-pressed="false" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button-text">' . Yii::t('dash', 'Real-Time') . '</span></label>';
    echo "</h2>";
    ?>
                            <a role="button" id="colButt" class="portlet-collapse ui-corner-all collapsed" href="#"><span class="ui-icon ui-icon-circle-plus">
                            <?php echo Yii::t('dash', 'Expand/Collapse'); ?></span></a>				                        
                        </header>
                        <section id="tabsSectionMain" style="display:none;">
                            <div class="tabs">
                                <ul>
                                    <li><a href="#tportlet-pane-2">
    <?php echo Yii::t('dash', 'Time-Range'); ?>
                                        </a></li>
                                </ul>
                                <!-- Time Range -->
                                <section id="tportlet-pane-2" >
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name">
    <?php echo Yii::t('dash', 'Start Time'); ?> <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="timeRangeStart" id="timeRangeStart" autocomplete="off" value="<?php echo date('Y-m-d', strtotime($prevTime)) ?>">
                                            <span><input type="text" name="timeRangeStart_time" id="timeRangeStart_time" class="timepick" size="5" maxlength="5" autocomplete="off" value="<?php echo date('H:i', strtotime($prevTime)) ?>"/></span></div>
                                    </div>                                            
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name">
    <?php echo Yii::t('dash', 'End Time'); ?>
                                            <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="timeRangeEnd" id="timeRangeEnd" autocomplete="off" value="<?php echo date('Y-m-d', strtotime($curTime)) ?>">
                                            <span><input type="text" name="timeRangeEnd_time" id="timeRangeEnd_time" class="timepick" size="5" maxlength="5" autocomplete="off" value="<?php echo date('H:i', strtotime($curTime)) ?>" /></span></div>                                                
                                    </div>                                            
                                    <div class="form-action clearfix flLeft">
                                        <button style="margin-top:10px;" id="timeRangeSubmit" data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text"><?php echo Yii::t('dash', 'SUBMIT'); ?></span></button>
                                    </div>
                                </section>
                                <!-- Time Range -->
                                <!-- Tons Range -->                                                                                
                                <section id="tportlet-pane-3" style="display:none;">
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name">Start Time <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="tonsRangeStart" id="tonsRangeStart">
                                            <span><input type="text" name="tonsRangeStart_time" id="tonsRangeStart_time" class="timepick" size="5" maxlength="5" /></span></div>                                                                                                
                                    </div>                                            
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name">End Time <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="tonsRangeEnd" id="tonsRangeEnd">
                                            <span><input type="text" name="tonsRangeEnd_time" id="tonsRangeEnd_time" class="timepick" size="5" maxlength="5" /></span></div>                                                                                                
                                    </div>                                            
                                    <div class="form-action clearfix flLeft">
                                        <button style="margin-top:10px;" id="tonsRangeSubmit" data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text"><?php echo Yii::t('dash', 'SUBMIT'); ?></span></button>
                                    </div>
                                </section>
                                <!-- Tons Range -->

                            </div>
                        </section>
                    </div>
                </div>
                <!-- End Tabs inside Portlet -->
            </section>

    <?php
} //if portltes > 0<?php echo Yii::t('dash','Select'); 
if (count($portlets) < 1) {
    Yii::app()->user->setFlash('testA', Yii::t('dash', 'Please go back to settings and add some gadgets.'));
    ?>
            <ul id="top_ul" class="isotope-widgets isotope-container iStatus"> 
                <li id="first_element" class="dash-order">
                    <a id="first_element_a" class="button-grey ui-corner-all animJq longSize" href="#" style="color:red; font-size:14px">
            <?php echo Yii::app()->user->getFlash('testA'); ?>
                        <span><?php //echo Yii::t('app','Aluminum_Percentage');  ?></span>
                    </a>
                </li>
            </ul>
    <?php
}
?> 

        <script type="text/javascript">
            $('#timeRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
            $('#timeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});

            $('#tonsRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
            $('#tonsRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});

            $('#timeTagStart').datepicker({dateFormat: 'yy-mm-dd'});
            $('#timeTagEnd').datepicker({dateFormat: 'yy-mm-dd'});

            $("#tagGroupSelector").change(function () {
                var cnt = 0;
                var selGrp = $(this).val();
                $('#tagSelector').val(0).change();
                if (selGrp == "nodata")
                    return;

                $('#tagSelector > option').each(function () {
                    var lblID = $(this).attr("label");
                    if (lblID != selGrp)
                    {
                        $(this).hide();
                    } else if (lblID == selGrp)
                    {
                        $(this).show();
                        cnt++;
                    }
                });

                if (cnt == 0)
                {
                    alert("No Tags defined for this Tag-Group");
                }

            });

            $("#tagSelector").change(function () {
                var selGrp = $('#tagSelector > option:selected').attr("label");

                if (selGrp == "nodata")
                    return;

                $('#tagGroupSelector > option').each(function () {
                    var lblID = $(this).val();
                    var cnt = 0;
                    if (lblID == selGrp)
                    {
                        $(this).attr("selected", "selected");
                        //$('#tagGroupSelector').val(cnt).change();                 
                    }
                    cnt++;
                });
            });

        </script>   
        <script type="text/javascript">
            $(".animJq").animate(
                    {
                        opacity: 1
                    },
                    2000,
                    "linear",
                    function () {
                        $('#first_element_a').effect("highlight", {}, 1000);    //Abhinandan. Better appearance is when used with the <a> element..
                    }
            );


            $('.timepick').timeslider({showValue: true, clickable: true});



            $("#realTimeLink").click(function () {
                window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash");
            });

            $("#timeRangeSubmit").click(function () {
                var curSTime = $('#timeRangeStart').val() + " " + $('#timeRangeStart_time').val();
                var curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
                window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash2/dash?pageType=timeRange&sTime=" + curSTime + "&eTime=" + curETime);
            });



        </script>   
        <section class="container_6 clearfix" style="margin-top:0px !important;padding-top:0px !important;">

<?php
if (count($portlets) > 0) {
    DashHelper::createDisplay($columns, $portlets, $widString);
}
?>


            <div  id="average-table" style="height:auto !important;" class="grid_6 portlet ui-sortable clearfix padMargin collapsible" draggable="true">
                <header class="ui-widget-header ui-corner-top">
                    <h2>
            <?php
            $msg = Yii::t('app', "Hourly Average(s) Table");
            echo $msg;
            ?>
                    </h2>
                </header>
                <section id="section_0" class="no-padding clearfix">
                        <?php
                        echo DashHelper::feedRateAverageTable($sTime, $eTime);
                        //$this->renderPartial('average-table', array('defaultHour' => $defaultHour, 'sTime' => $sTime, 'eTime' => $eTime));
                        ?>

                </section>
            </div>
        </section>
    </div>
</section>

<script type="text/javascript">

    function reload() {


        setTimeout(function () {
            window.location = '';
        }, 60000);
    }
    window.onload = function () {

        reload();
        $("#SetPoints_sp_priority").change(function () {
            $.ajax({
                url: '<?php echo Yii::app()->createAbsoluteUrl('dash/SetDefaultAvgRange') ?>',
                type: 'post',
                data: {default_avg_range: $("#SetPoints_sp_priority").val()},
                success: function () {

                    location.reload();
//                            console.log()
                }
            })
        })
    }

    $("#colButt").click(function () {
        $("#tabsSectionMain").toggle();
    });



    $("#avg-table").dataTable({
        "sPaginationType": "full_numbers",
        "bLengthChange": true,
        "bFilter": false,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 25,
        dom: "T<'clear'>lfrtip", "tableTools": {
            "sSwfPath": "<?php echo Yii::app()->baseUrl; ?>/themes/tutorialzine1/js/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
                "copy",
                "xls",
                "print",
                {
                    "sExtends": "collection",
                    "sButtonText": "Save",
                    "aButtons": ["csv", "xls"]
                }
            ]
        }
    });

</script>			
<?php

function createDetInfoUls() {
    $detInfoArray = array("Daemon_Running" => array("green" => "yes", "orange" => "", "red" => "no"),
        "Detector_Temp" => array("green" => "39:42", "orange" => "35:39", "red" => "35:42"),
        "Count_Rate_(aligned)" => array("green" => "2000000:3000000", "orange" => "175000000:2000000",
            "red" => "175000000:3000000"),
        "Good_Data_Secs" => array("green" => "60", "orange" => "55:60", "red" => "0:55"),
        "H_Peak_Raw_Channel" => array("green" => "99:100", "orange" => "96:99", "red" => "96:100"),
        "PMT_Voltage_Readback" => array("green" => "700:800", "orange" => "700:820", "red" => "650:820")
    );

    $detInfoArray_keys = array("Daemon_Running" => "System",
        "Detector_Temp" => "Temperature",
        "Count_Rate_(aligned)" => "Count Rate",
        "Good_Data_Secs" => "Data Quality",
        "H_Peak_Raw_Channel" => "H Peak",
        "PMT_Voltage_Readback" => "HV"
    );
    echo '<ul class="isotope-widgets isotope-container">';
    for ($i = 1; $i < 3; $i++) {

        $colstr = '';
        foreach ($detInfoArray as $id => $vl)
            $colstr .= "`$id`,";

        $colstr = substr($colstr, 0, -1);

        $sql = "SELECT $colstr FROM `analysis_status_info` WHERE Detector_ID = 'datad$i' ORDER BY LocalEndTime DESC LIMIT 1";
        $command = Yii::app()->db->createCommand($sql);
        //echo $sql;

        $settList = array();

        $dInfoList = $command->query()->readAll();
        if (count($dInfoList) > 0) {

            foreach ($dInfoList[0] as $sid => $val) {
                $aval = $val;
                $val = str_replace(",", "", $val);
                $val = str_replace("C", "", $val);
                $val = str_replace("V", "", $val);
                $val = str_replace(" ", "", $val);

                if (isset($detInfoArray[$sid])) {

                    $colorArray = $detInfoArray[$sid];
                    foreach ($colorArray as $cid => $cval) {
                        if ((strpos($cval, ":")) === false) {
                            if (strtolower($cval) == strtolower($val)) {
                                $colorSel = $cid;
                                break;
                            }
                        }//if
                        else {
                            list($lbound, $rbound) = explode(":", $cval);
                            if ($cid == "green") {
                                if (($val >= $lbound) || ($val <= $rbound)) {
                                    $colorSel = $cid;
                                    break;
                                }
                            }

                            if (($val <= $lbound) || ($val >= $rbound)) {
                                $colorSel = $cid;
                                break;
                            }
                        }
                    }//foreach
                    echo '<li class="dash-det' . $i . '" style="width:175px;">';
                    echo '<a class="button-' . $colorSel . ' ui-corner-all" href="#">';
                    //echo '<strong>'.$aval.'</strong>';
                    echo '<span style="border:none;font-color:black;font-weight:bold;">[Test]' . $detInfoArray_keys[$sid] . '</span>';
                    echo '</a>';
                    echo '</li>';
                }//if
                else
                    continue;
            }//foreach
        }//if count
    }//foreach 4 runs
    echo '</ul>';
}

//function	
?>