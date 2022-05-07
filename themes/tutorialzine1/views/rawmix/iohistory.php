<section class="main-section grid_8">
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        $cur_date = date("m/d/y");
        // SELECT * FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id AND  rl.rm_updated > '' AND  rm_status = "SUCCESS" ORDER BY rm_run_id DESC LIMIT 10

        $histTimeRangeStrt = @$_REQUEST["start_date"];
        $histTimeRangeEndt = @$_REQUEST["end_date"];

        if (isset($histTimeRangeStrt) && isset($histTimeRangeEndt)) {
            $timeStrg = "&start_date={$histTimeRangeStrt}&end_date={$histTimeRangeEndt}";
        } else {
            $timeStrg = "";
        }

        $baseUrl = Yii::app()->baseUrl;
        $RHEAURL = Yii::app()->params["rheaUrl"];
        $pageNumb = @$_REQUEST["page"];

        if (!isset($pageNumb))
            $pageNumb = 1;

        $nextPageNumb = $pageNumb + 1;
        $prevPageNumb = $pageNumb - 1;


        $testing = @$_REQUEST["testing"];
        if (isset($testing)) {
            $showPage = 1;
        } else
            $showPage = 1;

        $currentTime = date("Y-m-d H:i") . ":00";

        $simuLateYes = @$_REQUEST["simulate"];
        $dtime = @$_REQUEST["stime"]; //Simulation Time
        $simulateButton = 0;

        if (isset($simuLateYes) && $simuLateYes == "yes") {
            $simulateButton = 1;
            if (isset($dtime)) {
                $dtime = strtotime($dtime) + 5;   //Go 5 minutes forward
                $dtime = date("Y-m-d H:i:00", $dtime);
            } else {
                $dtime = date("Y-m-d H:i") . ":00";
            }
        }

        if (!isset($dtime)) {
            $dtime = date("Y-m-d H:i") . ":00";
        }

        $cs = Yii::app()->clientScript;
        $cs->registerScript("sabiaConf", "" . "var baseUrl = '{$baseUrl}';", CClientScript::POS_BEGIN);
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;

        $this->renderPartial('rawmixLeftMenu');
        ?>
    </nav>
    <div class="main-content" >


        <?php
        $this->renderPartial("idiotLightsGadget");
        ?>

        <?php
        if (!$showPage) {
            echo '<div class="form-action clearfix ui-state-highlight" style="padding:20px;text-align:center;">';
            echo 'System Under Maintenance. Will be live in a few minutes !';
            echo '</div>';
        } else {
            ?>
            <section class="container_6 ">
                <div class="">

                    <div class="grid_6">
                        <header class="ui-widget-header ui-corner-top">
                            <h2><?php echo Yii::t('app', 'RawMix Output History Log'); ?></h2>
                        </header>
    <?php
    $starTime = "";
    $endTime = "";
    if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {


        $starTime = date("Y-m-d H:i:00", strtotime($_REQUEST['start_date']));
        $endTime = date("Y-m-d H:i:00", strtotime($_REQUEST['end_date']));
    } else {
        $starTime = date("Y-m-d H:i:00", time() - (8 * 3600));
        $endTime = date("Y-m-d H:i:00", time());
    }
    ?>
                        <section id="sidebarpaneDialog-1" >
                            <div class="clearfix padding" style="padding:5px;border:1px solid lightgray;">
                                <form  name="historyformsubmit" id="historyformsubmit" method="get" action="#">
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name"><?php echo Yii::t('app', 'Start Time'); ?> <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="histTimeRangeStart" id="histTimeRangeStart" autocomplete="off" value="<?php echo date("Y-m-d",strtotime( $starTime)); ?>" >
                                            <span>
                                                <input type="text" name="histTimeRangeStart_time" id="histTimeRangeStart_time" class="timepick" size="5" maxlength="5"  <?php echo date("H:i", strtotime($starTime)); ?>/>
                                                <input type="hidden" name="start_date" id="start_dateString" class="" size="5" maxlength="5" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix flLeft">
                                        <label class="form-label" for="form-name"><?php echo Yii::t('app', 'End Time'); ?> <em>*</em></label>
                                        <div class="form-input"><input type="text" required="required" name="histTimeRangeEnd" id="histTimeRangeEnd" value='<?php echo date("Y-m-d", strtotime($endTime)); ?>' >
                                            <span>
                                                <input type="text" name="histTimeRangeEnd_time" id="histTimeRangeEnd_time" class="timepick" size="5" maxlength="5" value='<?php echo date("H:i", strtotime($endTime)); ?>'/>
                                                <input type="hidden" name="end_date" id="end_dateString" class="" size="5" maxlength="5" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-action clearfix flLeft" style="width:150px;">
                                        <label class="form-label" for="form-name"><?php echo Yii::t('app', 'History'); ?></label>
                                        <div class="form-input">
                                            <button id="historyformsubmitBut" data-icon-primary="ui-icon-circle-check" type="button" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">
    <?php echo Yii::t('dash', "SUBMIT"); ?>
                                                </span></button>
                                        </div>        
                                    </div>
                                </form>
                            </div>						
                            <form  name="proposedformsubmit" id="proposedformsubmit" method="get" action="#">
                                </div> 
                                <table id="dbtable1" class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
                                    <thead>

    <?php
    $sql = "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 " .
            "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
    $command = Yii::app()->db->createCommand($sql);

    $spList = $command->query()->readAll();

    $curTime = time();
    $days = @$_REQUEST["days"];

    if (isset($days) && $days > 0) {
        $days = $days;
    } else {
        $days = 5;
    }

    $prev3daysData = $curTime - ($days * 24 * 60 * 60);
    $displayTime = date("Y-m-d H:i:00", $prev3daysData);

    $status = "";

    if (isset($_REQUEST["status"])) {
        $statusMsg = "";
    } else {
        $statusMsg = "SUCCESS";
    }
    if (isset($starTime) && isset($endTime)) {

        $query = 'SELECT * FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id AND rl.rm_updated > \'' . $starTime . '\' AND rl.rm_updated < \'' . $endTime . '\' ORDER BY rm_run_id DESC';       //AND rm_status = "' . $statusMsg . '"
        $csql = 'SELECT count(*) as count FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id AND rl.rm_updated > \'' . $starTime . '\' AND rl.rm_updated < \'' . $endTime . '\' ORDER BY rm_run_id DESC';
    } else {
        $query = 'SELECT * FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id AND rl.rm_updated > \'' . $displayTime . '\' ORDER BY rm_run_id DESC';
        $csql = 'SELECT count(*) as count FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id AND rl.rm_updated > \'' . $displayTime . '\' ORDER BY rm_run_id DESC LIMIT 100';
    }

    $command = Yii::app()->db->createCommand($query);

    $ccommand = Yii::app()->db->createCommand($csql);

    $countRow = $ccommand->queryRow();

    $dataProvider = new CSqlDataProvider($query, array(
        'keyField' => 'rm_sid',
        'totalItemCount' => $countRow['count'],
        'pagination' => array(
            'pageSize' => 25,
        ),
    ));
    $anyList = $command->query()->readAll();

    $sql = "SELECT src_id,src_name,src_measured_feedrate,src_min_feedrate,src_max_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `rm_source` WHERE 1 " .
            "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
    $command = Yii::app()->db->createCommand($sql);

    $srcList = $command->query()->readAll();
    $i = 0;
    $totalFeedR = 0;
    $colLen = count($srcList);
    $spLen = count($spList);

    echo '<tr>';
    echo '<th class="ui-state-default" style="width:100px"> </th>';
    echo '<th class="ui-state-default" ></th>';
    echo '<th class="ui-state-default" colspan="' . $colLen . '"><span style="font-weight:bold;">' . Yii::t('app', 'Input Feed-Rates') . '</span></th>';
    echo '<th class="ui-state-default" colspan="' . $spLen . '"><span style="font-weight:bold;">' . Yii::t('app', 'Input Analysis') . '</span></th>';
    echo '<th class="ui-state-default" colspan="' . $colLen . '"><span style="font-weight:bold;">' . Yii::t('app', 'Output Feed-Rates') . '</span>
												 <a href="#paginationB" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" ><span class="ui-button-text"> <img width="14" height="10" src="' . Yii::app()->theme->baseurl . '/images/nav-arrow-down.png" > </span></a>
											</th>';
    echo '</tr>';
    echo '<tr style="font-size:14px !important;">';
    echo '<th class="ui-state-default" >' . Yii::t('app', 'Time') . '</th>';
    echo '<th class="ui-state-default" >' . Yii::t('app', 'Run') . '</th>';
    $colCounter = 2;
    foreach ($srcList as $spAr) {
        $spAr['src_name'] = str_replace("New_LimeStone", "Lime(N)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("Old_LimeStone", "Lime(O)", $spAr['src_name']);

        $spAr['src_name'] = str_replace("Old_", "(O)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("New_", "(N)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("Bottom_", "", $spAr['src_name']);

        $sName = str_replace("% ", "", $spAr["src_name"]);
        if (isset($spAr["src_name"])) {
            echo '<th class="ui-state-default" >' . Yii::t('dash',$sName) . '</th>';
//														echo '<th class="ui-state-default" >'. Yii::t("dash",str_replace("% ","",$spAr["src_name"])).'</th>';
            $colCounter++;
        } else {
            echo '<th></th>';
            $colCounter++;
        }//else
    }

    foreach ($spList as $spAr) {
        if (isset($spAr["sp_name"])) {
            echo '<th class="ui-state-success">' . $spAr["sp_name"] . '</th>';
            $colCounter++;
        } else {
            echo '<th></th>';
            $colCounter++;
        }//else
    }//foreach

    foreach ($srcList as $spAr) {
        $spAr['src_name'] = str_replace("New_LimeStone", "Lime(N)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("Old_LimeStone", "Lime(O)", $spAr['src_name']);

        $spAr['src_name'] = str_replace("Old_", "(O)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("New_", "(N)", $spAr['src_name']);
        $spAr['src_name'] = str_replace("Bottom_", "", $spAr['src_name']);
        
        $sName = str_replace("% ", "", $spAr["src_name"]);
        if (isset($spAr["src_name"])) {
            echo '<th class="ui-state-highlight">' . Yii::t('dash',$sName)  . '</th>';
//                                                  echo '<th class="ui-state-highlight">'. Yii::t("dash",str_replace("% ","",$spAr["src_name"])).'</th>';
            $colCounter++;
        } else {
            echo '<th></th>';
            $colCounter++;
        }//else
    }//foreach
    echo '<tr>';
    ?>

                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($dataProvider->totalItemCount > 0) {
                                            $this->widget('zii.widgets.CListView', array(
                                                'dataProvider' => $dataProvider,
                                                'itemView' => '_iohistory_row_view',
                                                'template' => ' {items} ',
                                                'viewData' => array('spList' => $spList, 'srcList' => $srcList),
                                                'emptyText' => ''
                                            ));
                                        }
                                        ?>

                                    </tbody>
                                </table>
                                        <?php
                                        if ($dataProvider->totalItemCount <= 0)
                                            echo '<section><div class="ui-widget ui-widget-content clearfix" style="width:100%;text-align:center;color:red;">' . Yii::t('app', 'No Results Found') . '</div></section>';

                                        $this->widget('CLinkPager', array(
                                            'pages' => $dataProvider->getPagination(),
                                            'firstPageLabel' => 'First',
//                     '               lastPageLabel' => 'Last',
//				    'prevPageLabel' => '<<  ',
                                            'nextPageLabel' => ' >>',
                                            'htmlOptions' => array('class' => ' pagination pull-right', 'id' => 'paginationB'),
                                            'hiddenPageCssClass' => 'hide',
                                            'internalPageCssClass' => 'pagenum',
                                            'header' => '',
                                        ));
                                        ?>
                            </form>
                        </section>
                    </div>
                </div><!-- main -->
            </section><!-- section main -->
                                <?php
                            }

                            $features = Yii::app()->params["features"];
                            if (@($features["import_export"]) && (1 == $features["import_export"])) {
                                $importExportFeature = 'dom: "T<\'clear\'>lfrtip",' .
                                        '"tableTools": {
											"sSwfPath": "' . Yii::app()->theme->baseUrl . '/js/swf/copy_csv_xls_pdf.swf",
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
							}';
                            } else {
                                $importExportFeature = '';
                            }

                            echo '
		<script type="text/javascript" src="' . Yii::app()->theme->baseUrl . '/js/jquery.dataTables.min.js' . '" ></script>
		<script type="text/javascript" src="' . Yii::app()->theme->baseUrl . '/js/dataTables.tableTools.min.js' . '" ></script>
 ';
                            ?>
    </div>
</section>

<div style="display:none">
    <div id="error-message" title="Log History Messages">
    </div>
</div>

<script type="text/javascript">


    var oTable0 = $("#dbtable1").dataTable({
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        "bFilter": false,
        "bPaginate": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": true,
        "bDestroy": true,
        "iDisplayLength": 25,
<?php echo $importExportFeature; ?>
    });
    oTable0.fnSort([[0, "DESC"]]);

    function fetchErrorMsg(log_id) {

        $.ajax({

            url: baseUrl + "/rawmix/geterrormessages",
            type: "GET",
            data: {logid: log_id},
            success: function (response) {

                $("#error-message").dialog({
                    autoOpen: false,
                    height: 600,
                    width: 900,
                    modal: true,
                    open: function (event, ui) {


                    },
                    buttons: {

                        "Close": function () {
                            $(this).dialog("close");
                        }
                    },
                    close: function () {

                    }
                });

                $("#error-message").html(response);

                $("#error-message").dialog('open');

            }
        })
    }


</script>

<script type="text/javascript">

    $("#widget-orders").click(function () {
        $("#spGraphsSection").toggle();
    });

    $("#widget-orders2").click(function () {
        $("#tabsSectionMain").toggle();
    });

    //$("#simulatebutToggler").click(function() {
    //$("#tabsSectionMain").toggle();
    //});

    $("#spGraphsSection").hide();
    $("#tabsSectionMain").hide();

</script>
<style type="text/css">

    #acceptFProposed {
        float:right;
        margin-right:46%;
        margin-top:15px;
    }

    #cancelProposed {
        float:left;
        margin-left:10px;
        margin-top:15px;
    }

    .forcedLabel {
        width:50px !important;
        background:transparent !important;
        border:0 !important;
    }

    li.selected {
        background:orange !important;
        font-color:red !important;
        border:red 2px solid !important;
    }
</style>


<script type="text/javascript">

    $("#submitProposed").click(function () {
        window.location.replace("<?php echo Yii::app()->baseUrl; ?>/rawmix/submitPr");
    });

    $("#errorRuns").click(function () {
        window.location.replace("<?php echo Yii::app()->baseUrl; ?>/rawmix/iohistory?status=1");
    });

    $('#timeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});
    $('#histTimeRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
    $('#histTimeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});

    var currentTime = new Date();
    var chours = currentTime.getHours();
    var cminutes = currentTime.getMinutes();
    var cTime = chours + ":" + cminutes;

    $('.timepick').timeslider({ showValue: true, clickable: true});

    $('#timeRangeEnd_time').val();
    $('#histTimeRangeStart_time').val();
    $('#histTimeRangeEnd_time').val();

    $("#historyformsubmitBut").click(function () {
        var histcurSTime = $('#histTimeRangeStart').val() + " " + $('#histTimeRangeStart_time').val();
        var histcurETime = $('#histTimeRangeEnd').val() + " " + $('#histTimeRangeEnd_time').val();

        $("#start_dateString").val(histcurSTime);
        $("#end_dateString").val(histcurETime);
        $("#historyformsubmit").submit();
    });


    $(".simulatePreRun").click(function () {
        var restCheck = $("#resetSim").attr("checked");

        var type = $(this).attr("alt");
        var curETime = "";
        if (type == "con") {
            curETime = "<?php echo $dtime; ?>";
        }
        else if (type == "real") {
            curETime = "<?php echo $currentTime; ?>";
        } else {
            curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
        }
        if (curETime.length == 1) {
            alert("Please select a DATE for simulation");
            return;
        }

        if (restCheck) {
            restCheck = "&reset=1";
        } else {
            restCheck = "";
        }
        var simRunCnt = parseInt($("#simRunCnt").val());
        $("#dialogRun").dialog({
            resizable: false,
            title: 'Running RHEA Simulator',
            width: 900,
            height: 500,
            modal: true,
            buttons: {
                "SIMULATE": function () {
                    simRunCnt = parseInt($("#simRunCnt").val());
                    $("#dialogRun").html("Running Simulation...<br/><img src='<?php echo $baseUrl; ?>/images/ajax-loader.gif' alt='Loading'/>");
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo $RHEAURL; ?>?stime=" + curETime + "&ajaxsimulate=1&type=" + type + "&runCntr=" + simRunCnt,
                        success: function (msg) {
                            $("#dialogRun").html(msg);
                        },
                        cancel: function () {
                            document.location.reload(true);
                            $(this).dialog("close");
                        }
                    }); //end ajax..
                },
                "CONTINUE": function () {
                    $("#dialogRun").html("Running Simulation...<br/><img src='<?php echo $baseUrl; ?>/images/ajax-loader.gif' alt='Loading'/>");
                    simRunCnt = parseInt($("#simRunCnt").val());
                    simRunCnt = simRunCnt + 1;
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo $RHEAURL; ?>?stime=" + curETime + "&ajaxsimulate=1&type=" + type + "&runCntr=" + simRunCnt,
                        success: function (msg) {
                            $("#dialogRun").html(msg);
                            $("#simRunCnt").val(simRunCnt);
                        },
                        cancel: function () {
                            document.location.reload(true);
                            $(this).dialog("close");
                        }
                    }); //end ajax..
                },
                "VERIFY-NEXT": function () {
                    simRunCnt = parseInt($("#simRunCnt").val());
                    simRunCnt = simRunCnt + 1;
                    $("#dialogRun").html("Fetching Data to Verify Next Simulation...<br/><img src='<?php echo $baseUrl; ?>/images/ajax-loader.gif' alt='Loading'/>");
                    var buttonsHtml = $("#subbuttons").html();
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo $RHEAURL; ?>?stime=" + curETime + "&ajaxsimulate=1&showInfoOnly=1&type=" + type + "&runCntr=" + simRunCnt,
                        success: function (msg) {
                            $("#dialogRun").html(msg + buttonsHtml);
                        },
                        cancel: function () {
                            document.location.reload(true);
                            $(this).dialog("close");
                        }
                    }); //end ajax..
                },
                "Close": function () {
                    curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
                    $(this).dialog("close");
                    window.location.replace("<?php echo Yii::app()->baseUrl; ?>/rawmix/iohistory?simulate=yes&dtime=" + curETime);
                },
            },
        });//	 dialogRun

        $("#dialogRun").html("Fetching Data to Verify Next Simulation...<br/><img src='<?php echo $baseUrl; ?>/images/ajax-loader.gif' alt='Loading'/>");
        var buttonsHtml = $("#subbuttons").html();
        $.ajax({
            type: 'POST',
            url: "<?php echo $RHEAURL; ?>?stime=" + curETime + "&ajaxsimulate=1&showInfoOnly=1&type=" + type + restCheck,
            success: function (msg) {
                $("#dialogRun").html(msg + buttonsHtml);
            },
            cancel: function () {
                document.location.reload(true);
                $(this).dialog("close");
            }
        }); //end ajax..
    });//simulatePreRun

    $(".simulateRun").click(function () {
        var restCheck = $("#resetSim").attr("checked");

        if (restCheck) {
            restCheck = "&reset=1";
        } else {
            restCheck = "";
        }

        var type = $(this).attr("alt");
        var curETime = "";
        if (type == "con") {
            curETime = "<?php echo $dtime; ?>";
        } else if (type == "real") {
            curETime = "<?php echo $currentTime; ?>";
        } else {
            curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
        }
        if (curETime.length == 1) {
            alert("Please select a DATE for simulation");
            return;
        }

        $("#dialogRun").dialog({
            resizable: false,
            title: 'Running RHEA Simulator',
            width: 1200,
            height: 700,
            modal: true,
            buttons: {
                "Close": function () {
                    $(this).dialog("close");
                    window.location.replace("<?php echo Yii::app()->baseUrl; ?>/rawmix/iohistory?simulate=yes&stime=" + curETime);
                }},
        });//	 dialogRun

        $("#dialogRun").html("Running Simulation...<br/><img src='<?php echo $baseUrl; ?>/images/ajax-loader.gif' alt='Loading'/>");

        $.ajax({
            type: 'POST',
            url: "<?php echo $RHEAURL; ?>?stime=" + curETime + "&ajaxsimulate=1&type=" + type + restCheck,
            success: function (msg) {
                $("#dialogRun").html(msg);
            },
            cancel: function () {
                document.location.reload(true);
                $(this).dialog("close");
            }
        }); //end ajax..
    });//simulateRun
    //$("#collSPGbutton").addClass("collapsed");
    //$("#collSPGbutton2").addClass("collapsed");

</script>
<div id="dialogRun" title="Running RHEA Simulator" style="display:none;">
    <p>Simulation run Results.</p>
</div>

<div id="subbuttons" style="display:none;">
    <div style="margin:10px;padding:10px;">
    </div>
</div>