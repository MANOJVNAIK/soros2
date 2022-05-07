<section class="main-section grid_8">
    <nav class="collapsed">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;

        //$this->renderPartial('rawmixLeftMenu');

        $baseUrl = Yii::app()->basePath;

	$this->renderPartial('rawmixLeftMenu');
        ?>
    </nav>
    <div class="main-content" >
        <section class="container_6 clearfix" style="margin-top:0px !important;margin-bottom:0px !important;padding-top:2px !important;">
            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading" style="margin-top:0px !important;padding-top:2px !important;">
                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="min-height:340px;background:transparent !important;border:0px !important;">
                    <div id="showStats" title="Accept Proposed Values" style="margin:0px 10px;min-height:280px;">
                        <div style="width:100%;height:auto;">
                            <div style="width:35%;float:left;">
                                <section id="sidebarpaneDialog-2" style="height:105px">
                                    <form name="proposedformsubmit2" id="proposedformsubmit2" >
                                        <table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;height:100px !important;;">
                                            <thead>
                                                <tr style="height:50px !important;">
                                                    <th class="ui-state-default" style="width:20%;">Set-Point</th>
                                                    <th class="ui-state-default">Target</th>
                                                    <th class="ui-state-default">120 (Avg)</th>
                                                    <th class="ui-state-default">90 (Avg)</th>
                                                    <th class="ui-state-default">60 (Avg)</th>
                                                    <th class="ui-state-default">30 (Avg)</th>
                                                    <th class="ui-state-default">15 (Avg)</th>
                                                    <th class="ui-state-default">5 (Avg)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rArr = array(5, 15, 30, 60, 90, 120);
                                                $rArrAssoc = array();

                                                $settingsQ = "select * from rm_settings where varName='AUTOMODE' OR varName='AUTO_TEST' ";
                                                $commandQ = Yii::app()->db->createCommand($settingsQ);

                                                $settModeAr = $commandQ->query()->readAll();

                                                foreach ($settModeAr as $sr) {
                                                    if ($sr["varName"] == "AUTOMODE")
                                                        $settAMode = $sr["varValue"];
                                                    if ($sr["varName"] == "AUTO_TEST")
                                                        $settATMode = $sr["varValue"];
                                                }

                                                $sql = "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 " .
                                                        "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
                                                $command = Yii::app()->db->createCommand($sql);

                                                $spList = $command->query()->readAll();
                                                $colstr = "";
                                                $def_setPointsString = "";
                                                foreach ($spList as $spAr) {
                                                    $elem = $spAr["sp_name"];
                                                    //AS03222015
                                                    if ($elem == "KH")
                                                        $elem = "IF( (CaO <= 0), 0 , ROUND(((CaO - 1.65 * Al2O3 - 0.35 * Fe2O3) / (2.80 * sio2)),3) ) as KH";
                                                    else if ($elem == "LSF")
                                                        $elem = "IF( (CaO <= 0), 0 , (CaO/(2.8*SiO2+1.18*Al2O3+0.65*Fe2O3) * 100) ) as LSF";
                                                    else if ($elem == "C3S")
                                                        $elem = "IF( (CaO <= 0), 0 , ROUND((4.07*CaO - 7.6*SiO2 - 6.72*Al2O3 - 1.43*Fe2O3 - 2.852*SO3 ),3) ) as C3S";
                                                    else if ($elem == "NAEQ")
                                                        $elem = "IF( (K2O <= 0), 0 , ROUND((K2O * 6.58 + Na2O ),3) ) as NAEQ";
                                                    else if ($elem == "SM")
                                                        $elem = "IF( (SiO2 <= 0), 0 , (SiO2/(Al2O3+Fe2O3)) ) as SM";
                                                    else if ($elem == "IM")
                                                        $elem = "IF( (Al2O3 <= 0), 0 , (Al2O3/Fe2O3) ) as IM";
                                                    else
                                                        $elem = "`$elem`";
                                                    $colstr .= "$elem ,";
                                                    $def_setPointsString .= $spAr["sp_name"] . "_Avg:(" . $spAr["sp_value_num"] . ");";
                                                } $colstr = substr($colstr, 0, -1);
                                                $def_setPointsString = substr($def_setPointsString, 0, -1);

                                                $colstr .= ",`CaO`,`Al2O3`,`Fe2O3`,`SiO2`";

                                                $sptsSql = "SELECT $colstr, TPH FROM `analysis_A1_A2_Blend` WHERE 1 ORDER BY LocalendTime DESC LIMIT 125";
                                                $sptCommand = Yii::app()->db->createCommand($sptsSql);

                                                $spValsList = $sptCommand->query()->readAll();
                                                
                                         

                                                $i = 0;
                                                $k = 0;
                                                $setPointsString = "";
                                                //Array ( [sp_name] => LSF [sp_value_num] => 95.00000 [sp_measured] => 0.00000 );

                                                array_push($spList, Array("sp_name" => "SiO2", "sp_value_num" => 0));
                                                array_push($spList, Array("sp_name" => "Al2O3", "sp_value_num" => 0));
                                                array_push($spList, Array("sp_name" => "CaO", "sp_value_num" => 0));
                                                    foreach($spList as $spAr){
                                                    
                                                     $rArrAssoc[$spAr["sp_name"]]["total"] = 0;
                                                }

                                                foreach ($spValsList as $id => $anArr) {
                                                    foreach ($spList as $spAr) {
                                                        $spname = $spAr["sp_name"];

                                                        if (in_array($i, $rArr) && $k > 0) {
                                                            //if($spname == "C3S")
                                                            //echo $spname ." : " . $i . " : total :=".$rArrAssoc[$spname]["total"] . " : = " .round(($rArrAssoc[$spname]["total"]/$k),2) . " : " . $k . "<br/>";

                                                            $avgVal = round(($rArrAssoc[$spname]["total"] / $k), 2);
                                                            $rArrAssoc[$spname][$i] = $avgVal;
                                                            if (($i == 15) && isset($spname) && isset($avgVal)) {
                                                                $setPointsString .= "$spname:" . round($avgVal, 2) . ";";
                                                            }
                                                        }

                                                        $cVal = 
                                                        $rArrAssoc[$spname]["total"] += $anArr[$spname];
                                                    }

                                                    if ($anArr["TPH"] > 0) {
                                                        $k++;
                                                    }
                                                    $i++;
                                                }
                                                $setPointsString = substr($setPointsString, 0, -1);
                                                if ($setPointsString == "")
                                                    $setPointsString = $def_setPointsString;

                                                //foreach($rArrAssoc as $id=>$val) {
                                                //echo $id; print_r($val);echo "<br/>";echo "<br/>";
                                                //}
                                                $i = 0;


                                                foreach ($spList as $spAr) {
                                                    if ($i % 2 == 0) {
                                                        echo '<tr class="gradeA odd" style="height:30px !important;">';
                                                    } else {
                                                        echo '<tr class="gradeB even" style="height:30px !important;">';
                                                    }
                                                    $spname = $spAr["sp_name"];
                                                    echo '<td style="width:20%;height:20px;font-weight:bold">' . $spname . '</td>';
                                                    echo '<td >' . sprintf("%4.2f", $spAr["sp_value_num"]) . '</td>';
                                                    $avgAr = "";
                                                    if (isset($rArrAssoc[$spname])) {
                                                        foreach ($rArrAssoc[$spname] as $id => $val) {
                                                            if ($id != "total") {
                                                                $avgAr = '<td>' . sprintf("%4.2f", $val) . '</td>' . $avgAr;
                                                            }
                                                        }
                                                        echo $avgAr;
                                                    } else {
                                                        echo "<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
                                                    }

                                                    echo '</tr>';
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </section>
                            </div>
                            <div style="width:60%;float:right;">
                                <section id="sidebarpaneDialog-1" style="height:225px">
                                    <form name="proposedformsubmit" id="proposedformsubmit" >
                                        <input type="hidden" name="setPoints" id="setPoints" value="<?php echo $setPointsString; ?>" />
                                        <table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
                                            <thead>
                                                <tr>
                                                    <th class="ui-state-default">SI</th>
                                                    <th class="ui-state-default">Feeder</th>
                                                    <th class="ui-state-default">Min Rate</th>
                                                    <th class="ui-state-default">Max Rate</th>
                                                    <th class="ui-state-default">Measured</th>
                                                    <th class="ui-state-default">Proposed</th>
                                                    <th class="ui-state-default">New-Proposed <br/>(Sum = 100 +- 0.1 %) </th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php
$sql = "SELECT src_id,src_name,src_measured_feedrate,src_min_feedrate,src_max_feedrate,src_proposed_feedrate ,src_actual_feedrate,src_status_mode FROM `rm_source` WHERE 1 " .
        "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
$command = Yii::app()->db->createCommand($sql);

$spList = $command->query()->readAll();
$i = 0;
$totalFeedR = 0;
foreach ($spList as $spAr) {
    if ($i % 2 == 0) {
        echo '<tr class="gradeA odd">';
    } else {
        echo '<tr class="gradeB even">';
    }

    if ($spAr["src_status_mode"] == 0) {
        $spAr["src_proposed_feedrate"] = 0;
        $src_newPr = 0;
        $rOString = 'readonly  ';
    } else {
        $rOString = ' class="inputChanger" ';

        //if ($settAMode == 0 ) {
        //	$src_newPr = $spAr["src_measured_feedrate"] ;
        //}
        $src_newPr = $spAr["src_proposed_feedrate"];
    }

    echo '<td>' . ($i + 1) . '</td>';
    echo '<td style="height:20px;font-weight:bold">' . Yii::t('dash', str_replace("%", "", $spAr['src_name'])) . '</td>';
    echo '<td><input style="width:80px;" class="forcedLabel"  type="text" value="' . sprintf("%4.2f", $spAr["src_min_feedrate"] * 100) . '" name="' . $spAr["src_id"] . '_min" id="' . $spAr["src_id"] . '_min" /></td>';
    echo '<td><input style="width:80px;" class="forcedLabel"  type="text" value="' . sprintf("%4.2f", $spAr["src_max_feedrate"] * 100) . '" name="' . $spAr["src_id"] . '_max" id="' . $spAr["src_id"] . '_max" /></td>';
    echo '<td>' . sprintf("%4.2f", $spAr["src_measured_feedrate"]) . '</td>';
    echo '<td><input style="width:80px;" class="forcedLabel" readonly type="text" value="' . sprintf("%4.2f", $spAr["src_proposed_feedrate"]) . '" name="' . $spAr["src_id"] . '_pr" id="' . $spAr["src_id"] . '_pr" /></td>';
    echo '<td><input style="width:80px;" ' . $rOString . ' type="text" value="' . sprintf("%4.2f", $src_newPr) . '" name="' . $spAr["src_id"] . '_nw" id="' . $spAr["src_id"] . '_nw" title="' . $spAr["src_name"] . '"/></td>';
    echo '</tr>';

    $totalFeedR += $spAr["src_proposed_feedrate"];
    $i++;
}
?>

                                                <tr class="gradeB even" >
                                                    <td colspan="6" style="height:20px;font-wieght:bold;border-right:0px !important;">
                                                        <button style="margin-top:0px !important;" id="acceptFProposed" class="ui-button ui-button ui-widget ui-state-highlight ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                                                            <span class="ui-button-text" style="color:red;"><?php echo Yii::t('rm_settings', "Submit New Feed Rates"); ?></span>
                                                        </button>
                                                    </td>
                                                    <td style="height:20px;border-left:0px !important;">
                                                        <input style="width:80px;float:right;margin-right:50px;background:gray !important;color:white;" readonly type="text" value="<?php echo sprintf("%4.2f", $totalFeedR); ?>" name="totalFeed" id="totalFeed" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </section>
                            </div><!--  float right -->
                        </div><!--  auto -->
                    </div><!--  showstats -->
                </section>
            </div><!--  grid_6 -->
        </section><!-- section -->
        <section class="container_6 clearfix" style="margin-top:0px !important;padding-top:5px !important;">
<?php
if (1) {
	
		echo '
	 <script type="text/javascript">
	  $("header").addClass( function(index, currentClass){
		   var addedClass;
		   if( currentClass === "" )
		   {
		addedClass = "ui-widget-header ui-corner-top";
		   }
		   return addedClass;
		  });
	 </script>
	 <script src="' . Yii::app()->baseUrl . '/themes/tutorialzine1/js/highCharts/highstock.js" type="text/javascript"></script>
	 <script src="' . Yii::app()->baseUrl . '/themes/tutorialzine1/js/highCharts/modules/exporting.js" type="text/javascript"></script>
	';	
	
    DashHelper::getMeIndvChart("C3S", 1);
    DashHelper::getMeIndvChart("Fe2O3", 2);
    DashHelper::getMeIndvChart("SM", 3);
    DashHelper::getMeIndvChart("IM", 4);
}
?>
        </section>
    </div><!-- main -->
</section><!-- section main -->

<form id="goback" action="<?php echo Yii::app()->baseUrl; ?>/rawmix"/>
<script type="text/javascript">

    $("#acceptFProposed").click(function (e) {
        e.preventDefault();
        var formElements = new Array();
        $("#proposedformsubmit :input[name*='_nw']").each(function () {
            //alert($(this).attr("class"));
            formElements.push($(this));
        });
        var t_sum = 0;
        var error = 0;
        $.each(formElements, function (i, val) {
            if (val.attr("class") == "inputChanger") {
                var sn = val.attr("name");
                var sn_rep = sn.replace("_nw", "");
                var sn_t = val.attr("title");
                var sn_val = parseFloat(val.attr("value"));

                var sn_min = parseFloat($("#" + sn_rep + "_min").val());
                var sn_max = parseFloat($("#" + sn_rep + "_max").val());

                if (sn_val < sn_min) {
                    //alert("l sn = " + sn + " sn_t = " + sn_t + " sn_val = " + sn_val + " sn_min = " + sn_min+ " sn_max = " + sn_max);
                    alert("Value for Feeder " + sn_t + " is Less than Source Min");
                    error = 1;
                } else if (sn_val > sn_max) {
                    //alert("m sn = " + sn + " sn_t = " + sn_t + " sn_val = " + sn_val + " sn_min = " + sn_min+ " sn_max = " + sn_max);
                    alert("Value for Feeder " + sn_t + " is More than Source Max");
                    error = 1;
                } else
                    t_sum += sn_val;
            }//if inputchanger
        });

        if (error)
            return;

        if (!error && (t_sum < 0 || t_sum > 101 || t_sum < 99)) {
            alert("ERROR: Total Feed Rates SUM is not between 99 & 101 :" + t_sum);
            error = 1;
        }

        if (error)
            return;

        var answer = confirm('Are you sure you want to submit the values?');
        if (answer)
        {
            var setPointsArray = $("#setPoints").val();
            //alert(setPointsArray);
            var formArray = $("#proposedformsubmit").serializeObject();
            //console.log(setPointsArray);
            //alert('<?php echo Yii::app()->baseUrl; ?>/rawmix/submitProposed');
            //e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->baseUrl; ?>/rawmix/submitProposed',
                data: {'feedRates': formArray, 'setPoints': setPointsArray},
                success: function (response) {
                    //alert(stringified);
                    //return;
                    if (response) {
                        alert("Proposed Feed Rates Submitted Successfully");
                        $("#goback").submit();
                    } else {
                        alert("Error:Proposing new Feed Rates.Please contact Sabia!");
                    }
                }
            });  //end ajax
        }

    });


    function getSetPointTotal() {

        var setpointObj = {};
        $("#proposedformsubmit2 table tbody tr").each(function () {
            $(this).find('td:nth-child(1)');

            var eleName = $(this).find('td:nth-child(1)').html();
            var eleValue = $(this).find('td:nth-child(2)').html();

            setpointObj[eleName] = eleValue;

            //console.log(eleName);
            // console.log(setpointObj);

        });
        console.log(setpointObj);
        return setpointObj;

    }
    $.fn.serializeObject = function ()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $("#cancelProposed").click(function () {
        $("#goback").submit();
    });

    $(".inputChanger").change(function () {
        var sn = $(this).attr("name");
        var sn_rep = sn.replace("_nw", "");
        var sn_t = $(this).attr("title");
        var sn_val = parseFloat($(this).attr("value"));
        var t_sum = $("#totalFeed").val();
        var m_val = $("#" + sn_rep + "_pr").val();

        var sn_min = parseFloat($("#" + sn_rep + "_min").val());
        var sn_max = parseFloat($("#" + sn_rep + "_max").val());
        //alert("m sn = " + sn + " sn_t = " + sn_t + " sn_val = " + sn_val + " sn_min = " + sn_min+ " sn_max = " + sn_max);

        if (sn_val < sn_min) {
            //alert("l sn = " + sn + " sn_t = " + sn_t + " sn_val = " + sn_val + " sn_min = " + sn_min+ " sn_max = " + sn_max);
            alert("Value for Feeder " + sn_t + " is Less than Source Min");
            error = 1;
        } else if (sn_val > sn_max) {
            //alert("m sn = " + sn + " sn_t = " + sn_t + " sn_val = " + sn_val + " sn_min = " + sn_min+ " sn_max = " + sn_max);
            alert("Value for Feeder " + sn_t + " is More than Source Max");
            error = 1;
        } else {
            //var tnew = parseFloat(sn_val - m_val);
            //t_sum = parseFloat(t_sum) + parseFloat(tnew);
            //t_sum = parseFloat(t_sum).toFixed(2);
            //$("#totalFeed").val(t_sum);
            var ntsum = 0;
            $('.inputChanger').each(function () {
                ntsum += parseFloat($(this).val());
            });
            //alert(ntsum);
            ntsum = parseFloat(ntsum).toFixed(2);
            $("#totalFeed").val(ntsum);
        }

        if (error)
            return;

        if (!error && (t_sum < 0 || t_sum > 101 || t_sum < 99)) {
            alert("ERROR: Total Feed Rates SUM should be between 100 +- 1");
            error = 1;
        }

        if (error)
            return;
    });

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
</style>
