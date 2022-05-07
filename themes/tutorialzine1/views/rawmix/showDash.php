<?php

	$baseUrl = Yii::app()->baseUrl;
	$RHEAURL = Yii::app()->params["rheaUrl"];
	$debugFlag = 0;
	$cur_ul    = Yii::app()->user->id;
	
	$currentRTime = date("Y-m-d H:i").":00";

	if(strpos($baseUrl,"eclipse_wrk")){
		$analysisAvgTableName = "analysis_a1_a2_blend";
	}else {
		$analysisAvgTableName = "analysis_A1_A2_Blend";
	}

	if(isset($_REQUEST["dtime"])) {
		$testing = 1;
		$g_currenTime = $_REQUEST["dtime"];
	}else {
		$testing = 0;
		$g_currenTime = date("Y-m-d H:i:s");
	}

	if(isset($_REQUEST["simulate"])) {
		$sourceTable = "rm_source_sim";
	}else
		$sourceTable = "rm_source";

	if($debugFlag)
		echo $g_currenTime;

	$srcArray = array();
	$elemArray = array();
	$elemvArray = array();

	if($testing) {
		$query =  "SELECT src_id,src_name FROM $sourceTable WHERE product_id=1";
	}else {
		$query =  "SELECT src_id,src_name FROM $sourceTable WHERE product_id=1";
	}
    $tcommand = Yii::app()->db->createCommand($query);
    $tresult  = $tcommand->query()->readAll();

    if(count($tresult)> 0){
		foreach($tresult as $roAr) {
			$tempVArray = array();
			$elemArray = array();

			$srcArray[$roAr["src_id"]]=$roAr["src_name"];
			$tsrcId = $roAr["src_id"];

			$query = "SELECT element_name,element_value,estimated_min,estimated_max FROM `rm_element_composition` where source_id = {$tsrcId} AND element_type=1; ";

		    $tcommand = Yii::app()->db->createCommand($query);
		    $tresult  = $tcommand->query()->readAll();

		    if(($tresult)) {
			    foreach($tresult as $trow) {
				$tVarName = $trow["element_name"];
				$tVarvAL = $trow["element_value"];
				array_push($elemArray ,$tVarName);
				array_push($tempVArray ,$tVarvAL);

				}//foreach
			}//if treslt
			$elemvArray[$tsrcId] = $tempVArray;
		}//foreach source
    }//if count

	
	$dbSrcArray = array();
	$dbSrcIdArray = array();
	$query =  "SELECT src_id,src_name,src_type FROM rm_source WHERE product_id=1";
	$tcommand = Yii::app()->db->createCommand($query);
	
	$tresult  = $tcommand->query()->readAll();

	if(count($tresult)> 0){
		foreach($tresult as $roAr) {
			$dbSrcArray[$roAr["src_id"]]=$roAr["src_type"];
			$dbSrcIdArray[$roAr["src_id"]]=$roAr["src_name"];
		}//foreach source
	}//if count
	
	$sql = "SELECT * FROM `rm_source_feeder_inputs` where 1 ORDER BY LocalendTime DESC LIMIT 1";
	$command = Yii::app()->db->createCommand($sql);
	
	$result = $command->query()->readAll();
	$cnt = count($result);
	$tSumMval = 0;

	if (($result) && ($cnt > 0)) {
		$i = 0;
		foreach ($result as $row) {
			foreach ($dbSrcArray as $dbsrcid => $srcVal) {

				$tname = "src_" . $dbsrcid . "_sp";				
				$mval = round(($row[$tname]), 3);
				$srcName = $dbSrcIdArray[$dbsrcid];

				if (!is_array($feedRatesSPArray[$srcName]))
					$feedRatesSPArray[$srcName] = array();

				$feedRatesSPArray[$srcName] = array("srcid"=>$dbsrcid,"src_type"=>$srcVal,"src_sp"=>$mval,"src_name"=>$srcName);
				$tSumMval += $mval;
			}//foreach				
		}//while
	}//if result
	$autoModeVar = 0;
	$masValHid = "";
	$starVingFlag = 0;
	$autoButtonClass = "ui-state-default";
	
	$ssql = "SELECT * FROM `rm_settings` where varName IN ('constFeeders' , 'AUTOMODE', 'MASTER_CONTROL_MODE' ,'STARVATION','shutdown_msg')";
	$scommand = Yii::app()->db->createCommand($ssql);
	
	$sresult = $scommand->query()->readAll();
	$scnt = count($sresult);
	
	foreach ($sresult as $rowRes) {

		if($rowRes["varName"] == "constFeeders"){
			$constFeedersStr = $rowRes["varValue"];
			$constFeedersStr = substr($constFeedersStr,0,-1);
			$constFeedersAr = explode(";",$constFeedersStr);
		}else if($rowRes["varName"] == "AUTOMODE" && $rowRes["varValue"]) {
			$autoModeVar = $rowRes["varValue"];
			$autoButtonClass = "button-green";
		}else if($rowRes["varName"] == "MASTER_CONTROL_MODE" && $rowRes["varValue"]) {
			$masValHid = 1;
		}else if($rowRes["varName"] == "STARVATION" && $rowRes["varValue"]) {
			$starVingFlag = 1;
		}else if($rowRes["varName"] == 'shutdown_msg') {
			$errorString = $rowRes["varValue"];
		}
	}
	
	foreach ($constFeedersAr as $sName){
            if (isset($feedRatesSPArray)) {
		$dbSrcId = $feedRatesSPArray[$sName]["srcid"];
		$feederConstArSpts[$dbSrcId] = $feedRatesSPArray[$sName]["src_sp"];
	}
	}
	
?>
<link rel="stylesheet" href="<?php echo $baseUrl ; ?>/css/style.css"/>


<section class="main-section grid_8">
    <nav class="">
	<!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
	<?php
	$layoutY = $this->layout;
	$them = Yii::app()->theme->name;

	$this->renderPartial('rawmixLeftMenu');

	//  include_once( LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php"));
	?>
    </nav>
    <div class="main-content">

	<div class="clear"><br/></div>
	<?php

	$productProfile= ProductProfile::model()->find('default_profile = 1');

	$productId = $productProfile['product_id'];

	$sourcList = Source::model()->findAll('product_id = :pid',array(':pid'=>$productId));

	$spList    = SetPoints::model()->findAll('sp_status=1 AND product_id = :pid',array(':pid'=>$productId));

	$sql = "SELECT * FROM  product_category right join colour_tbl on product_category.product_categoryid = colour_tbl.colour_id ORDER BY `colour_tbl`.`position` ASC";
	$command = Yii::app()->db->createCommand($sql);

	$funeList = $command->query()->readAll();



	$g_currenTime_l = strtotime($g_currenTime) - (20 * 60);
	$g_currenTime_l   = date("Y-m-d H:i:s", $g_currenTime_l);

	$g_currenTime_l2 = strtotime($g_currenTime) - (2 * 60);
	$g_currenTime_l2   = date("Y-m-d H:i:s", $g_currenTime_l2);

	$lastUpdatedCtrlFeedRates = 'SELECT * FROM `rm_ctrl_output_feedrates` WHERE updated BETWEEN "'. $g_currenTime_l.
									'" and "'. $g_currenTime .'" ORDER BY `rm_ctrl_output_feedrates`.`id` DESC LIMIT 1 ';
	$commandl = Yii::app()->db->createCommand($lastUpdatedCtrlFeedRates);
	//echo $lastUpdatedCtrlFeedRates;
	$lastUpdtTimeStamps = $commandl->query()->readAll();
	$liveValsAr = array();
	$liveVals = 0;

	if( count($lastUpdtTimeStamps) <= 0) {
			foreach($sourcList as $source) {
			       $source['src_proposed_feedrate'] = 0;

			}
	}else {
		$liveVals = 1;
		//if($_REQUEST["test"])print_r($lastUpdtTimeStamps[0]);
		foreach($lastUpdtTimeStamps[0] as $varid=>$varval){
			if($varid =="id" || $varid == "updated") continue;

			if(substr($varid, -2, 2) == "_m"){
				$varid = str_replace("Feeder","",$varid);
				$varid = str_replace("_cmd_m","",$varid);
				$liveValsAr[$varid] = $varval;
			}
		}
	}
	//if($_REQUEST["test"])print_r($liveValsAr);

	$lastUpdatedCtrlFeedRates = 'SELECT * FROM `rm_source_feeder_inputs` WHERE LocalendTime BETWEEN "'. $g_currenTime_l2.
									'" and "'. $g_currenTime .'" ORDER BY `rm_source_feeder_inputs`.`src_fid` DESC LIMIT 1 ';
	$commandl = Yii::app()->db->createCommand($lastUpdatedCtrlFeedRates);
	//echo $lastUpdatedCtrlFeedRates;
	$lastUpdtTimeStamps = $commandl->query()->readAll();

	if( count($lastUpdtTimeStamps) <= 0) {
			foreach($sourcList as $source) {
			       $source['src_measured_feedrate'] = 0;
				$source['src_status_mode']=0;
			}
		}

?>

<?php

		$this->renderPartial("idiotLightsGadget");

?>

<section class="container_6 clearfix" style="margin:0px auto;padding:10px;">
<div class="grid_6">
	<fieldset class="fieldset-buttons ui-corner-all">
		<legend class="buttonset-legend">
			<span id="dashboardview-filter2" class="buttonset">
			    <input type="radio" name="dashboardview2" id="dashboardview-det1" value=".dash-det1" checked /><label for="dashboardview-det1"><?php echo Yii::t('dash','Detector-1')?></label>
			    <input type="radio" name="dashboardview2" id="dashboardview-det2" value=".dash-det2" /><label for="dashboardview-det2"><?php echo Yii::t('dash','Detector-2')?></label>
			</span>
		</legend>
<?php
			DashHelper::createDetInfoUls();
?>
	</fieldset>
</div>
</section>

<?php	
	
	$newCTime = date('Y-m-d H:i:s',strtotime($currentRTime) - (60* 30));

	$scQuery = "SELECT * FROM rm_config_log where c_table_name ='rm_error_dialog' and c_updated >= '{$newCTime}' ORDER BY cid DESC";

	$ccommand = Yii::app()->db->createCommand($scQuery);
	$countsRow = $ccommand->queryRow();
	
	if($countsRow > 0){
		$ctupdated = $countsRow['c_updated'];	
		$msgDialogEr = $countsRow['c_var_desc'] . " updated on " . $updated;	
	}else {
		$ctupdated = 0;
	}
?>

<?php if($ctupdated ){ ?>
<section class="container_6 ">
		<div class="grid_6">
			<div class="ui-state-highlight" style="color:red;padding:5px;">
				<?php echo Yii::t('dash',$msgDialogEr); ?>
			</div>
		</div>
</section>
<?php } ?>


<section class="container_6 clearfix">
	<div class="grid_6">
	    <div class="grid_4 feedDisplay" >
		<header class="ui-widget-header ui-corner-top">
		<?php
			if($errorString) {
				echo "<h2 style='text-align:center;'>" . '<span class="ui-state-error redBlinkerbutton" style="text-align:center;padding-left:5px;padding-right:5px;"> ERROR:'.$errorString.'</span>' . "</h2>";
			}
			else { 
				echo "<h2>" . Yii::t('dash','Feed Rates Trend') . "</h2>";
			} 
		?>
		</header>
		<section id="section_rawMix" class="ui-widget-content ui-corner-bottom">
			    <div class="funelDiv">
				<input type="hidden" name="masValHid" id="masValHid" value="<?php echo $masValHid; ?>" />
	<?php
			    $colorId = 0;

			    foreach($sourcList as $source) {
				    $colorId++;
				    if($source['src_id'] == 1) 
						$leftMargin = "margin-left:40px !important;";
				    else 
						$leftMargin = "";

				    $source['src_name'] = str_replace("New_LimeStone","Lime(N)",$source['src_name']);
				    $source['src_name'] = str_replace("Old_LimeStone","Lime(O)",$source['src_name']);
					
					$fdrType = $source['src_type'];
					
					$fdrDelStr = '';
					$fdrDelayCounter = 0;
					
					$fdrDelaySql = 'SELECT * FROM `rm_fdr_delay_counter` WHERE fdr_type="'.$fdrType.'"';
					$commandldl = Yii::app()->db->createCommand($fdrDelaySql);

					$fdrCntrsResults = $commandldl->query()->readAll();

					if( count($fdrCntrsResults) > 0) {
						$fdrDelayCounter =  round($fdrCntrsResults[0]["fdr_counter"],0);
						if($fdrDelayCounter != 1)
							$fdrDelStr = '<div class="textItem8 numberCircle" style="border:1px red dotted;">'. ($fdrDelayCounter + 1) .'</div>';
						else
							$fdrDelStr = '';
					}

				    if($testing){

						$height = (int)$source['src_proposed_feedrate'];
		?>
						<div class="funelItemDiv" style="<?php echo $leftMargin?>background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/funel<?= $colorId?>.png) no-repeat scroll 0% 0% transparent;">
						    <div class="funelName">F<span style="color:red;font-size:16px;"><?php echo $colorId . "</span><span style='font-size:10px !important;'> " . CHtml::encode(Yii::t('dash',str_replace("%","",$source['src_name'])));?></span></div>
						    <div class="funelItem" data-height="116" style="background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/<?= $colorId?>.jpg) repeat scroll 0% 0% transparent;"></div>
							<?php echo $fdrDelStr; ?>
						    <div class="textItem2 ui-state-highlight" style="border:1px red dotted;"><?php echo sprintf("%4.2f",$source['src_proposed_feedrate'])?></div>
						    <div class="textItem ui-state-default" style="color:#A3B0B0;"><?php echo sprintf("%4.2f",$source['src_measured_feedrate'])?> </div>
						    <div class="imgone glow1"  id=""><img alt="" src="<?php echo $baseUrl ; ?>/images/rawmix/images/glow1.png"></div>
						    <div class="lineItem"><img alt="" src="<?php echo $baseUrl ; ?>/images/rawmix/images/line<?php echo $colorId?>.gif"></div>
						</div><!-- funnelItemDev -->
	<?php
				    }else if($source["src_status_mode"] == 1) {
					    if(!$liveVals){
						    $height = (int)$source['src_proposed_feedrate'];
					    }else {
						   $srcpr_fdr_rate = $liveValsAr[$source['src_id']];
						   $source['src_proposed_feedrate'] = $srcpr_fdr_rate;
					    }
					    

					    
						if($source['src_proposed_feedrate'] <= 0)
							$source['src_proposed_feedrate'] = $source['src_measured_feedrate'];


						$height = (int)$source['src_proposed_feedrate'];
		?>
						<div class="funelItemDiv" style="<?php echo $leftMargin?>background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/funel<?= $colorId?>.png) no-repeat scroll 0% 0% transparent;">
						    <div class="funelName">F<span style="color:red;font-size:16px;"><?php echo $colorId . "</span><span style='font-size:10px !important;'> " . CHtml::encode(Yii::t('dash',str_replace("%","",$source['src_name'])));?></span></div>
						    <div class="funelItem" data-height="116" style="background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/<?= $colorId?>.jpg) repeat scroll 0% 0% transparent;"></div>
							<?php echo $fdrDelStr; ?>
							<div class="textItem2 ui-state-highlight" style="border:1px red dotted;"><?php echo sprintf("%4.2f",$source['src_proposed_feedrate'])?></div>
						    <div class="textItem ui-state-default" style="color:#A3B0B0;"><?php echo sprintf("%4.2f",$source['src_measured_feedrate'])?> </div>
						    <?php if(isset($feederConstArSpts[$source["src_id"]])){ ?>
								 <div class="textItem3 ui-state-highlight" style="color:red;text-align:center;"><?php echo sprintf("%4.2f",$feederConstArSpts[$source["src_id"]])?> <span style="color:black;font-size:10px;">(C) </span> </div>
							<?php } ?>
							<div class="imgone glow1"  id=""><img alt="" src="<?php echo $baseUrl ; ?>/images/rawmix/images/glow1.png"></div>
						    <div class="lineItem"><img alt="" src="<?php echo $baseUrl ; ?>/images/rawmix/images/line<?php echo $colorId?>.gif"></div>
						</div><!-- funnelItemDev -->
	<?php
					}else {
	?>
						<div class="funelItemDiv" style="<?php echo $leftMargin?>background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/funelg.png) no-repeat scroll 0% 0% transparent;">
						    <div class="funelName">F<span style="color:red;font-size:16px;"><?php echo $colorId . "</span><span style='font-size:10px !important;'> " . CHtml::encode(Yii::t('dash',str_replace("%","",$source['src_name'])));?></span></div>
						    <div class="funelItemStale" data-height="116" style="background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/gray.jpg) repeat scroll 0% 0% transparent;"></div>
						    <div class="textItem ui-state-default">0</div>
						    <div class="textItem2 ui-state-default">0</div>
							<?php if(isset($feederConstArSpts[$source["src_id"]])){ ?>
								 <div class="textItem3 ui-state-highlight" style="color:red;text-align:center;"><?php echo sprintf("%4.2f",$feederConstArSpts[$source["src_id"]])?> <span style="color:black;font-size:10px;">(C) </span> </div>
							<?php } ?>
						</div><!-- funnelItemDev -->
	<?php
					}
			    }//foreach
	?>

			<div class="clearfix"></div>
			<div class="chikmik">
			       <img alt="" src="<?php echo $baseUrl?>/images/rawmix/images/chikmik_a.gif" width="580px">

			       <div class="showFlowRate">
	<?php
			    $colorId = 0;
			    foreach($sourcList as $source):
							$colorId++;
				if($source["src_status_mode"] == 1) {
					$height = (int)$source['src_proposed_feedrate'];

	?>
					<div class="flowRate"  style="height:<?php echo $height?>%;background: url(<?php echo $baseUrl ; ?>/images/rawmix/images/<?= $colorId?>.jpg) repeat scroll 0% 0% transparent;"></div>
	<?php
				}
						endforeach;
	?>
						</div>

			       <div class="showAcceptButton" style="background:transparent !important;">
<?php if($cur_ul < 3) { ?>
							<a href="<?php echo $baseUrl?>/rawmix/submitPr" class="ui-button ui-button ui-widget ui-state-highlight ui-corner-all ui-button-text-only" role="link" aria-disabled="false">
								<span class="ui-button-text" style="color:red;">
				                                   <?php echo Yii::t('dash','Manual');?>
								</span>
							</a>
<?php }//NOT EQUAL 3 ?>
							</button>
<?php
       $altValue = "Settings[varName]=AUTOMODE&Settings[varKey]=Automatic&Settings[varValue]=";
       if($cur_ul == 1) {
?>							
							<button id="automaticControlModeBut" title="<?php echo $autoModeVar; ?>" alt="<?php echo $altValue; ?>" style="margin-left:5px !important;" class="ui-button ui-button ui-widget <?php echo $autoButtonClass;?> ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
								<span class="ui-button-text" ><?php echo Yii::t('dash','Automatic');?></span>
							</button>
<?php }//NOT EQUAL 1 ?>
<?php if($starVingFlag){ ?>
						
						<span id="jquery_jplayer" style="maring:0px;padding:0px;width:0px;"></span>
						<span id="jp_container" style="maring:0px;padding:0px;">
							
								<button id="starvingModeBut" style="margin-left:95px !important;" title="Starvation Mode Active" class="ui-button  ui-corner-all ui-button-text-only redBlinkerbutton" role="button" aria-disabled="false">
									<span class="ui-button-text" ><?php echo Yii::t('dash','Starvation');?></span>
								</button>
								<a class="jp-mute" href="#">
								<img src="<?php echo  Yii::app()->theme->baseUrl ?>/images/navicons/127.png" width="48" height="48" /></a>
								<a class="jp-unmute" href="#">
								<img src="<?php echo  Yii::app()->theme->baseUrl ?>/images/navicons/125.png" width="48" height="48" /></a>
							
						</span>

<?php } ?>
					</div>
			</div>
		    </div><!--funelDiv-->
		</section>
	    </div><!--grid rawmix-->

		<div class="grid_2 portlet tabDisplay" >

		<div class="tabs">
		    <ul>
			<li><a href="#pane-1"><?php echo Yii::t('dash','Set-Points');?></a></li>
			<li><a href="#pane-2"><?php echo Yii::t('dash','Feed-Rates');?></a></li>
		    <li><a href="#pane-3"><?php echo Yii::t('dash','Elements');?></a></li>
		    </ul>

		    <!-- tab "panes" -->
		    <section id="pane-1" style="height:275px">
					<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
					    <thead>
						<tr>
						    <th class="ui-state-default" style="width:20%;font-weight:bold;"><?php echo Yii::t('dash',' SP ');?></th>
						    <th class="ui-state-default" style="font-weight:bold;"><?php echo Yii::t('dash','Target');?></th>
						    <th class="ui-state-default" style="font-weight:bold;"><?php echo Yii::t('dash','60');?></th>
						    <th class="ui-state-default" style="font-weight:bold;"><?php echo Yii::t('dash','30');?></th>
						    <th class="ui-state-default" style="font-weight:bold;"><?php echo Yii::t('dash','20');?></th>
						    <th class="ui-state-default" style="font-weight:bold;"><?php echo Yii::t('dash','10');?></th>
						</tr>
					    </thead>
					    <tbody>
								<?php
								    $rArr = array(60,30,20,10);
								    $rArrAssoc = array();
									$def_spList = array();
									$extraElemsAr = array("Al2O3","SiO2","CaO","Fe2O3","SM","IM");
									
								    $sql =  "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 ".
										"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
								    $command = Yii::app()->db->createCommand($sql);

								    $spList = $command->query()->readAll();
									
									foreach($spList as $spAr){array_push($def_spList, $spAr["sp_name"]);}
									
									foreach($extraElemsAr as $extElem){
										
										if(!in_array($extElem,$def_spList)){
											//$colstr .= ", $extElem ";
											array_push($spList, array("sp_name"=>$extElem,"sp_value_num"=>"-","sp_measured"=>"-"));
										}
									}
								
								    $colstr ="";
								    if(count($spList) > 0){
								    foreach($spList as $spAr) {
										$elem = $spAr["sp_name"];
										if($elem == "KH")
											$elem = "IF( (CaO <= 0), 0 , ROUND(((CaO - 1.65 * Al2O3 - 0.35 * Fe2O3) / (2.80 * sio2)),3) ) as KH";				
										else if($elem == "LSF")
											$elem = "IF( (CaO <= 0), 0 , (CaO/(2.8*SiO2+1.18*Al2O3+0.65*Fe2O3) * 100) ) as LSF";
										else if ($elem == "C3S")
											$elem = "IF( (CaO <= 0), 0 , ROUND((4.07*CaO - 7.6*SiO2 - 6.72*Al2O3 - 1.43*Fe2O3 - 2.852*SO3 ),3) ) as C3S";
										else if ($elem == "NAEQ")
											$elem = "IF( (K2O <= 0), 0 , ROUND((K2O * 0.658 + Na2O ),3) ) as NAEQ"; //NAEQ Equation Correction JW160412
										else if ($elem == "SM")
											$elem = "IF( (SiO2 <= 0), 0 , (SiO2/(Al2O3+Fe2O3)) ) as SM";
										else if ($elem == "IM")
											$elem = "IF( (Al2O3 <= 0), 0 , (Al2O3/Fe2O3) ) as IM";
										else
											$elem = "`$elem`";

										$colstr .= "$elem ,";
								    }

								    $colstr = substr($colstr,0,-1);

								    //AB42819 BEGIN:Analyzer values current Data vs anydata bug fix.
								    $sptsSql =  "SELECT $colstr, TPH FROM `$analysisAvgTableName` WHERE ".
										" LocalendTime >= DATE_SUB('{$g_currenTime}',INTERVAL 120 MINUTE) AND ".
										" LocalendTime <= '{$g_currenTime}' ".
										" ORDER BY LocalendTime DESC LIMIT 125";
								    $sptCommand = Yii::app()->db->createCommand($sptsSql);

								    $spValsList = $sptCommand->query()->readAll();
								    //echo $sptsSql;

								    $i =0;
								    $k =0;$k20=0;$k30=0;

								    foreach($spValsList as $id=>$anArr) {
									foreach($spList as $spAr) {
										$spname = $spAr["sp_name"];
										if(in_array($i,$rArr)  && ($k > 0) ) {
											$rArrAssoc[$spname][$i] = round(($rArrAssoc[$spname]["total"]/$k),2);
										}
										$rArrAssoc[$spname]["total"] += $anArr["$spname"];					
								    	}
									if($anArr["TPH"] >0) {
										$k++;											
									}
									$i++;
								    }
								    //AB42819 END:Analyzer values current Data vs anydata bug fix.

								    $i =0;
								    foreach($spList as $spAr) {
									if($i % 2 ==0) {
										echo '<tr class="gradeA odd">';
									}
									else {
										echo '<tr class="gradeB even">';
									}
									$spname = $spAr["sp_name"];
									
									foreach($rArrAssoc as $id=>$val) {
										if(isset($rArrAssoc[$spname])){
											foreach($rArr as $id){
												if(!isset($rArrAssoc[$spname][$id])){
													$rArrAssoc[$spname][$id] = "-";
												}
											}
										}
								        }

									echo '<td style="width:20%;height:30px;font-weight:bold">'. $spname .'</td>';
									
									if($spAr["sp_value_num"] > 0)
										echo '<td >'. sprintf("%4.2f",$spAr["sp_value_num"]) .'</td>';
									else
										echo '<td >'.'-</td>';

									$avgAr = "";
									if(isset($rArrAssoc[$spname])){
										foreach($rArrAssoc[$spname] as $id=>$val) {
											if(($id != "total")){
												$avgAr .=  '<td >'. sprintf("%4.2f",$val) .'</td>';
											}
										}//foreach
									}else {
										$avgAr =  "<td>-</td><td>-</td><td>-</td><td>-</td>";
									}
									
									echo $avgAr;
									echo '</tr>';
									$i++;
								    }
								    }
								?>
						</tbody>
					</table>
				</section>
		    <section id="pane-2" style="height:295px">
					<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
					    <thead>
						<tr>
						    <th class="ui-state-default"><?php echo Yii::t('dash','Feeder');?></th>
						    <th class="ui-state-default"><?php echo Yii::t('dash','Measured');?></th>
						    <th class="ui-state-default"><?php echo Yii::t('dash','Proposed');?></th>
						    <!-- <th class="ui-state-default">Set-Point</th> -->
						</tr>
					    </thead>
					    <tbody>
								<?php

								    $sql =  "SELECT src_name,src_measured_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `$sourceTable` WHERE 1 ".
										"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
								    $command = Yii::app()->db->createCommand($sql);

								    $spList = $command->query()->readAll();
								    $i =0;
								    foreach($spList as $spAr) {
									if($i % 2 ==0) {
										echo '<tr class="gradeA odd">';
									}
									else {
										echo '<tr class="gradeB even">';
									}
									echo '<td>'. Yii::t('dash',str_replace("%","",$spAr["src_name"]))  .'</td>';
									echo '<td>'. sprintf("%4.2f",$spAr["src_measured_feedrate"]) .'</td>';
									echo '<td>'. sprintf("%4.2f",$spAr["src_proposed_feedrate"]) .'</td>';
									//echo '<td>'. sprintf("%4.2f",$spAr["src_actual_feedrate"]) .'</td>';
									echo '</tr>';
									$i++;
								    }
								?>
						</tbody>
					</table>
				</section>
		    <section id="pane-3" style="height:295px">
					<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
						    <thead>
							<tr>
							    <th class="ui-state-default"><?php echo Yii::t('dash','Feeder');?></th>
								<?php
//                                                                array_pop($elemArray);
									foreach($elemArray as $va)  {
										echo '<th class="ui-state-default">'.Yii::t('dash',str_replace("%","",$va)).'</th>';
									}
								?>
							</tr>
						    </thead>
						    <tbody>
						    <?php
							//$srcIPFRValsArray
							$i =0;
							    if(is_array($elemvArray )) {
								foreach($elemvArray as $id=>$valAr) {
									if($i %2 == 0)
									{
										echo '<tr class="gradeA odd">';
									}else {
										echo '<tr class="gradeB even">';
									}
									echo '<td>'. Yii::t('dash',str_replace("%","",$srcArray[$id])) .'</td>';
									for($index = 0; $index < count($elemArray);$index++) {
                                                                            
                                                                            if(isset($valAr[$index])){
                                                                                
                                                                                echo '<td>'.sprintf("%4.0f",$valAr[$index]*100).' %</td>';
                                                                            }else{
                                                                                
                                                                                echo '<td>-</td>';
                                                                            }
										
									}
									echo '</tr>';
									$i++;
								}
							}
						    ?>
						    </tbody>
						</table>
				</section>
			</div>
		</div><!--grid 2-->
	</div>
</section><!-- section container-6 -->
    <section class="container_6 clearfix">

	<div class="leading clearfix">
		<div class="grid_6 portlet collapsible " style="height:auto !important;" >
			<header class="ui-widget-header ui-corner-top">
				<h2>
						<?php 						
						$msg = Yii::t('app',"Hourly Average(s) Table");
						echo $msg;	
						?>						
				</h2>
			</header>
		    <section class="no-padding clearfix">
				<?php 
				
					//$this->renderPartial("average-table");
					echo DashHelper::getAverageTable(3,"AN",1);

				?>

			</section>
        </div>
	</div>
</section>
	<script type="text/javascript">

	    $(".animJq").animate(

		    {
			opacity: 1
		    },
		    2000,
		    "linear",
		    function() {
			$('#first_element_a').effect("highlight", {}, 1000);    //Abhinandan. Better appearance is when used with the <a> element..
		    }
	    );
		window.onload = function(){
		   doAnimation();

		    (function nextImage() {
			   // $(images[imgIx++] || images[imgIx = 0, imgIx++]).delay(30000).hide().delay(30000).fadeIn(600).delay(0).fadeOut(600, nextImage);
			})();
		}

		function doAnimation(){
		       $('.funelItem').each(function(){
			var height = $(this).attr('data-height')
			$(this).animate({height:height+"px"},3000,'swing',function(){    (function nextImage() {

			var images = ['.imgone'],
			imgIx = 0;
			$(images[imgIx++] || images[imgIx = 0, imgIx++]).delay(30000).hide().delay(30000).fadeIn(6000).delay(0).fadeOut(6000, nextImage);
			})();});
		    });
	   }


	</script>
<?php
	$debugFlagTemp = 01;

	$srcIPFRValsArray = array();
	$srcOPFRValsArray = array();

	$prev60MinsTimeStamp = strtotime($g_currenTime) - 60;
	$prev60MinsTime 	 = date("m-d-y h:i:00", $prev60MinsTimeStamp);

	if($testing) {
		$query =  "SELECT * FROM rm_inputoutputdump WHERE rm_sim_id =".
				  "(SELECT rm_sid FROM rm_runlog WHERE rm_updated='{$g_currenTime}' ORDER BY rm_rid DESC LIMIT 1) ORDER BY rm_run_id DESC LIMIT 10";
	}else {
		$query =  "SELECT * FROM rm_inputoutputdump WHERE rm_sim_id =".
				  "(SELECT rm_sid FROM rm_runlog WHERE 1 ORDER BY rm_rid DESC LIMIT 1) ORDER BY rm_run_id DESC LIMIT 10";
	}


	$query = "SELECT * FROM rm_inputoutputdump rio INNER JOIN rm_runlog rr ON rm_sim_id= rm_sid AND rr.rm_updated >'{$prev60MinsTime}' WHERE rm_status='SUCCESS' ORDER BY rm_run_id DESC LIMIT 10";
    $command = Yii::app()->db->createCommand($query);
    if($debugFlag) echo $query;

    $result  = $command->query()->readAll();

    $countRuns = count($result);

    //print_r($result[0]["rm_output_feed"]);
?>	

    <section class="container_6 clearfix">

	<div class="leading clearfix">
		<div class="grid_6 portlet collapsible " id="widget-orders" >
			<header>
				<h2><?php echo Yii::t('dash','Set Point Graphs')?></h2>
				<a href="#" class="portlet-collapse ui-corner-all" role="button">
					<span class="ui-icon ui-icon-circle-minus"><?php echo Yii::t('dash','Expand/Collapse')?></span>
				</a>
			</header>
			<section class="no-padding" id="chartsBlockSection">
<?php

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


	$sql =  "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 ".
		"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
	$command = Yii::app()->db->createCommand($sql);

	$spList = $command->query()->readAll();
	$colstr ="";
	if(count($spList) > 0){
		$rowCnt = 0;
		foreach($spList as $spAr) {
			DashHelper::getMeIndvChart($spAr["sp_name"],$rowCnt++);
		}//foreach
	}//if count

?>
			</section>
		</div>
		</div>
	</section>

    <section class="container_6 clearfix">
		<div class="grid_6">
		<div class="tabs">
		    <ul>
		    <?php
		    $showRuns = 0;
		    if($showRuns){
			for($i=1;$i <=$countRuns;$i++) {
				echo '<li><a href="#pane-'.$i.'">Run '.$i.'</a></li>';
			}
		    }
		    ?>
		    </ul>


<?php


	if($result && $showRuns) {
		$cntrRun =0;
		foreach($result as $resAr) {
			$cntrRun++;
			$tempArray = $resAr;

			$rmipfeed = unserialize($tempArray["rm_input_feed"]);
			$globalTimeUpd = $tempArray["rm_updated"];

			if($debugFlag) DashHelper::showDump($rmipfeed);

			$timUpd = $globalTimeUpd ;
		    $timUpd = strtotime($timUpd);
			if(is_array($rmipfeed)) {
				foreach($rmipfeed as $id=>$vals) {
						$Timecntr = 0;
					foreach($vals as $i=>$v) {
						if($srcIPFRValsArray[$i]) {
							$srcIPFRValsArray[$i][$id]=$v;
						}
						else {
							$srcIPFRValsArray[$i] = array($id=>$v);
						}
						//echo "b: $timUpd" . "<br/>";
						//$timUpd = ($timUpd) + 60;
						//echo "a: $timUpd" . "<br/>";
						$srcIPFRValsArray[$i]["timestamp"] = $timUpd;
							$Timecntr++;
						}//vals
				}//foreach rminfeed
			}
			if($debugFlag) print_r($srcIPFRValsArray);

			$timUpd = $globalTimeUpd ;
			$timUpd = strtotime($timUpd);
			$timDefUpd = $timUpd;

			$rmopfeed = unserialize(trim($tempArray["rm_output_feed"]));
			if($debugFlag) DashHelper::showDump($tempArray["rm_output_feed"]);

			$ctr = count($srcArray);
			$k =0;
			if(is_array($rmopfeed)) {
				$i = 0;
			foreach($rmopfeed as $id=>$vals) {
				$i++;
					if(is_array($vals)) {
						foreach($vals as $il=>$v) {
						if(is_array($srcOPFRValsArray[$k])) {
							$srcOPFRValsArray[$k][$i]=$vals[$il] * 100;
						}
						else {
							$srcOPFRValsArray[$k] = array($i=>$vals[$il] * 100);
						}
						}
					}//if array
				if($i == $ctr) {
						$timUpd = $globalTimeUpd ;
						$timUpd = strtotime($timUpd);
					$timUpd = ($timUpd) + $k * 60;
						$srcOPFRValsArray[$k]["timestamp"] = $timUpd;
					$i =0;
					$k++;
				}else {
					$outputSrcUpdatedTimeStamp = $timDefUpd;
				}
			}//foreach rmopfeed
		}//is_array

		//DashHelper::showDump(" src op" , $srcOPFRValsArray);

			$rmipelem = unserialize(trim($tempArray["rm_input_elements"]));
			$rmopelem = unserialize(trim($tempArray["rm_output_elements"]));

			$rmipanres = unserialize(trim($tempArray["rm_input_analysis"]));
			//TODO see how to use these results
			$rmopanres = unserialize(trim($tempArray["rm_output_analysis"]));

			if($debugFlag) DashHelper::showDump("OE", $rmopelem );

?>
		    <!-- tab "panes" -->
		    <section id="pane-<?php echo $cntrRun; ?>">
			    <div class="sidebar-tabs">
				<ul>
				    <li><a href="#sidebarpane-1<?php echo $cntrRun; ?>"><?php echo Yii::t('dash','Feed Rates')?></a></li>
<?php if($_REQUEST["elem"]==1){ ?>
				    <li><a href="#sidebarpane-2<?php echo $cntrRun; ?>"><?php echo Yii::t('dash','Elements')?></a></li>
<?php } ?>
				    <li><a href="#sidebarpane-3<?php echo $cntrRun; ?>"><?php echo Yii::t('dash','Analysis Results')?></a></li>
				    <!-- <li><a href="#sidebarpane-41">Set Points</a></li> -->
				</ul>
				<!--  Feed Rates -->
				<section id="sidebarpane-1<?php echo $cntrRun; ?>" style="height:400px;" >
					<div class="grid_5">

								<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
								    <thead>
									<tr>
										<th class="ui-state-default" colspan="<?php echo count($srcArray)+1; ?>"><?php echo Yii::t('helios_rawmix_dash_text','Feed Rates (Proposed)')?></th>
									</tr>
									<tr>
									    <th class="ui-state-default"><?php echo Yii::t('app', 'Time-Stamp')?></th>
										<?php
											$srcCnt = 0;
											foreach($srcArray as $va)  {
												echo '<th class="ui-state-default">'.$va.'</th>';
												$srcCnt++;
											}
										?>
									</tr>
								    </thead>
								    <tbody>
								    <?php
									//$srcIPFRValsArray
									$i =0;
									//DashHelper::showDump("OP",$srcOPFRValsArray);

								//Feed Rates
									if(is_array($srcOPFRValsArray ) && (count($srcOPFRValsArray)== $srcCnt)) {
										foreach($srcOPFRValsArray as $id=>$valAr) {
											$i++;

											if($i %2 == 0)
											{
												echo '<tr class="gradeA odd">';
											}else {
												echo '<tr class="gradeB even">';
											}
											echo '<td>'.date("m/d/y H-i",$valAr["timestamp"]).'</td>';

											foreach($valAr as $il=>$v) {
												if($il != "timestamp")
													echo '<td>'.sprintf("%4.2f",$v).'</td>';
											}
											echo '</tr>';
										}
									}else {

										$sql =  "SELECT src_name,src_measured_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `$sourceTable` WHERE src_status_mode=1 ".
												"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
										    $command = Yii::app()->db->createCommand($sql);

										    $spList = $command->query()->readAll();
										    $i =0;
										    if(is_array($spList)) {

											if($i % 2 ==0) {
												echo '<tr class="gradeB odd">';
											}
											else {
												echo '<tr class="gradeA even">';
											}
											echo '<td>'. date("m/d/y H:i",$outputSrcUpdatedTimeStamp) .'</td>';
											foreach($spList as $spAr){
												echo '<td>'. sprintf("%4.2f",$spAr["src_proposed_feedrate"]) .'</td>';
											}
											echo '</tr>';
											$i++;
										    }//if isset


									}

								    ?>
								    </tbody>
								</table>
								<div class="padding clearfix"></hr><br/><br/></div>
								<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
								    <thead>
									<tr>
										<th class="ui-state-default" colspan="<?php echo count($srcArray)+1; ?>"><?php echo Yii::t('helios_rawmix_dash_text','Feed Rates (Measured)')?></th>
									</tr>
									<tr>
									    <th class="ui-state-default"><?php echo Yii::t('app', 'Time-Stamp')?></th>
										<?php
											foreach($srcArray as $va)  {
												echo '<th class="ui-state-default">'.$va.'</th>';
											}
										?>
									</tr>
								    </thead>
								    <tbody>
								    <?php
									//$srcIPFRValsArray
									$i =0;
									    if(is_array($srcIPFRValsArray )) {
										foreach($srcIPFRValsArray as $id=>$valAr) {
											if($i %2 == 0)
											{
												echo '<tr class="gradeA odd">';
											}else {
												echo '<tr class="gradeB even">';
											}
											$valAr["timestamp"] = $valAr["timestamp"] - $i * 60;
											echo '<td>'.date("m/d/y H:i",$valAr["timestamp"]).'</td>';
											foreach($valAr as $il=>$v) {
												if($il != "timestamp")
													echo '<td>'.sprintf("%4.2f",$v).'</td>';
											}
											echo '</tr>';
											$i++;
										}
									}

								    ?>
								    </tbody>
								</table>
							</div>
				</section>

<?php
	if($_REQUEST["elem"]==1){
		echo '<section id="sidebarpane-2'.$cntrRun.'" style="height:400px;">';
	}
	else
	  echo '<section id="sidebarpane-2'.$cntrRun.'" style="display:none;">';
?>
					<div class="grid_3">
								<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
								    <thead>
									<tr>
										<th class="ui-state-default" colspan="5">Elements (Lab)</th>
									</tr>
									<tr>
									    <th class="ui-state-default">Feeder</th>
										<?php
											foreach($elemArray as $va)  {
												echo '<th class="ui-state-default">'.$va.'</th>';
											}
										?>
									</tr>
								    </thead>
								    <tbody>
								    <?php
									//$srcIPFRValsArray

									$i =0;
									    if(is_array($rmipelem )) {
										foreach($rmipelem as $id=>$valAr) {
											$i++;
											if(!isset($srcArray[$i]))	{
												$i++;
											}
											{
												if($i %2 == 0)
												{
													echo '<tr class="gradeA odd">';
												}else {
													echo '<tr class="gradeB even">';
												}
												echo '<td>'. $srcArray[$i] .'</td>';
												foreach($valAr as $il=>$v) {
													echo '<td>'.sprintf("%4.2f",$v["value"]).'</td>';
												}
												echo '</tr>';
											}
										}
										}
								    ?>
								    </tbody>
								</table>
							</div>
					<div class="grid_3">
								<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
								    <thead>
									<tr>
										<th class="ui-state-default" colspan="6">Elements (Proposed)</th>
									</tr>
									<tr>
									    <!--
										<th class="ui-state-default">Run</th>
									    -->
									    <th class="ui-state-default">Feeder</th>
										<?php
											foreach($elemArray as $va)  {
												echo '<th class="ui-state-default">'.$va.'</th>';
											}
										?>
									</tr>
								    </thead>
								    <tbody>
								    <?php
									//$rmopelem
									$i =1;
									$srcid = 1;
									$run = 1;
									    if(is_array($rmopelem )) {
										foreach($rmopelem as $id=>$valAr) {
											$k =1;
											if($i %2 == 0)
											{
												echo '<tr class="gradeA odd">';
											}else {
												echo '<tr class="gradeB even">';
											}
											if(!isset($srcArray[$srcid])) $srcid++;
											echo '<td>'. $srcArray[$srcid] .'</td>';

											foreach($valAr as $il=>$v) {

												echo '<td>'.sprintf("%4.2f",$v[$elemArray[$k-1]]) . '</td>';
												$k++;
											}
											echo '</tr>';
											if($i % 4 ==0){
												$run++;
												$srcid =0;
											}
											$i++;
											$srcid++;
										}
									}

								    ?>
								    </tbody>
								</table>
							</div>
				</section>
				<section id="sidebarpane-3<?php echo $cntrRun; ?>">
					<div class="grid_5">
								<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
								    <thead>
									<tr>
										<th class="ui-state-default" colspan="5">Analysis Results</th>
									</tr>
									<tr>
									    <th class="ui-state-default">Timestamp</th>
										<?php
											foreach($elemArray as $va)  {
												echo '<th class="ui-state-default">'.$va.'</th>';
											}
										?>
									</tr>
								    </thead>
								    <tbody>
								    <?php
								    if(is_array($rmipanres)) {
								    foreach($rmipanres as $id=>$rmipanresAr) {
										for($i=0;$i<count($rmipanresAr);$i++) {
										if($i %2 == 0)
										{
											echo '<tr class="gradeA odd">';
										}else {
											echo '<tr class="gradeB even">';
										}
										$tempTime = strtotime($globalTimeUpd) - $i * 60;
										echo '<td>'.date("m/d/y H:i",$tempTime).'</td>';
										echo '<td>'.sprintf("%4.2f",$rmipanres[$elemArray[0]][$i]).'</td>';
										echo '<td>'.sprintf("%4.2f",$rmipanres[$elemArray[1]][$i]).'</td>';
										echo '<td>'.sprintf("%4.2f",$rmipanres[$elemArray[2]][$i]).'</td>';
										echo '<td>'.sprintf("%4.2f",$rmipanres[$elemArray[3]][$i]).'</td>';
										echo '</tr>';
									}//for
									break;
								}//foreach
								}
									?>
									</tbody>
								</table>
							</div>
				</section>
				<!--
				<section id="sidebarpane-41">
				    <h3>Sidebar 4</h3>
				    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dignissim eleifend luctus. Fusce vel nunc neque. Fusce pulvinar placerat vestibulum. Praesent scelerisque massa non tellus molestie eu mattis mauris tristique. In urna magna, suscipit ac vestibulum a, lobortis vel enim. Nunc egestas nisi magna. Cras aliquam gravida orci ut semper. Vivamus auctor, nibh id lobortis consequat, augue elit ornare mi, ac aliquet justo odio eu nulla. Nulla ipsum nulla, iaculis nec fringilla blandit, aliquet a sem. Morbi dapibus dolor vitae libero semper sagittis. Ut hendrerit, mi a eleifend consequat, nisi neque blandit quam, nec malesuada turpis velit ac metus. Nullam a pulvinar mi. Sed lobortis sem non metus condimentum fringilla. Fusce vestibulum ultrices sapien, id molestie risus sollicitudin ultricies. Sed scelerisque posuere bibendum. Maecenas luctus, diam eget ultrices rhoncus, est elit scelerisque lectus, quis interdum mi magna in urna. Mauris vitae euismod ligula.</p>
				</section>
				-->
			    </div><!-- slider-tabs -->

			</section><!-- pane1 -->
		<?php
			}//foreach result
		} //if result
		?>
		  </div>
	    </div>
	</section>


    <section class="container_6 clearfix">
		<div class="grid_6">
	<?php

	    if (count($portlets) > 0) {
		//DashHelper::createDisplay($columns, $portlets, $widString);
	    }
	?>

	    </div>
	</section>
</div>
</section>

<div id="showStats" style="display:none;" title="Accept Proposed Values">
<div style="width:100%;height:auto;">
	<div style="width:30%;float:left;">
		    <section id="sidebarpaneDialog-2" style="height:145px">
				<form name="proposedformsubmit" id="proposedformsubmit2" method="post" action="#">
					<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
					    <thead>
						<tr>
						    <th class="ui-state-default">Set-Point</th>
						    <th class="ui-state-default">Target</th>
						    <th class="ui-state-default">Current</th>
						</tr>
					    </thead>
					    <tbody>
								<?php

								    $sql =  "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 ".
										"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
								    $command = Yii::app()->db->createCommand($sql);

								    $spList = $command->query()->readAll();
								    $colstr ="";
								    if(count($spList) > 0){
										foreach($spList as $spAr) {
											$elem = $spAr["sp_name"];
											if($elem == "KH")
												$elem = "IF( (CaO <= 0), 0 , ROUND(((CaO - 1.65 * Al2O3 - 0.35 * Fe2O3) / (2.80 * sio2)),3) ) as KH";				
											else if($elem == "LSF")
												$elem = "IF( (CaO <= 0), 0 , (CaO/(2.8*SiO2+1.18*Al2O3+0.65*Fe2O3) * 100) ) as LSF";
											else if ($elem == "C3S")
												$elem = "IF( (CaO <= 0), 0 , ROUND((4.07*CaO - 7.6*SiO2 - 6.72*Al2O3 - 1.43*Fe2O3 - 2.852*SO3 ),3) ) as C3S";
											//else if ($elem == "NAEQ")
											//	$elem = "IF( (K2O <= 0), 0 , ROUND((K2O * 6.58 + Na2O ),3) ) as NAEQ";
											else if ($elem == "NAEQ")
												$elem = "IF( (K2O <= 0), 0 , ROUND((K2O * 0.658 + Na2O ),3) ) as NAEQ"; //NAEQ Equation Correction JW160412
											else if ($elem == "SM")
												$elem = "IF( (SiO2 <= 0), 0 , (SiO2/(Al2O3+Fe2O3)) ) as SM";
											else if ($elem == "IM")
												$elem = "IF( (Al2O3 <= 0), 0 , (Al2O3/Fe2O3) ) as IM";
											else
												$elem = "`$elem`";

											$colstr .= "$elem ,";
										}
									}
								    $colstr = substr($colstr,0,-1);
								    if($colstr =="" || $colstr == " ")$colstr = "dataID";							
									
									
								    $sptsSql =  "SELECT $colstr FROM `$analysisAvgTableName` WHERE 1 ORDER BY LocalendTime DESC LIMIT 1";
								    $sptCommand = Yii::app()->db->createCommand($sptsSql);

								    $spValsList = $sptCommand->query()->readAll();

								     $i =0;
								    foreach($spList as $spAr) {
									if($i % 2 ==0) {
										echo '<tr class="gradeA odd">';
									}
									else {
										echo '<tr class="gradeB even">';
									}
									$spname = $spAr["sp_name"];
									echo '<td>'. $spname .'</td>';
									echo '<td>'. sprintf("%4.2f",$spAr["sp_value_num"]) .'</td>';
									echo '<td>'. sprintf("%4.2f",$spValsList[0][$spname]) .'</td>';
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
	<section id="sidebarpaneDialog-1" style="height:295px">
				<form name="proposedformsubmit" id="proposedformsubmit" method="post" action="#">
					<table class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
					    <thead>
						<tr>
						    <th class="ui-state-default">Feeder</th>
						    <th class="ui-state-default">Measured</th>
						    <th class="ui-state-default">Proposed</th>
						</tr>
					    </thead>
					    <tbody>
								<?php

								    $sql =  "SELECT src_id,src_name,src_measured_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `$sourceTable` WHERE src_status_mode=1 ".
										"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
								    $command = Yii::app()->db->createCommand($sql);

								    $spList = $command->query()->readAll();
								    $i =0;
								    foreach($spList as $spAr) {
									if($i % 2 ==0) {
										echo '<tr class="gradeA odd">';
									}
									else {
										echo '<tr class="gradeB even">';
									}
									echo '<td>'. $spAr["src_name"] .'</td>';
									echo '<td>'. sprintf("%4.2f",$spAr["src_measured_feedrate"]) .'</td>';
									echo '<td><input type="text" value="'. sprintf("%4.2f",$spAr["src_proposed_feedrate"]) .'" name="'.$spAr["src_id"].'" /></td>';
									echo '</tr>';
									$i++;
								    }
								?>
						</tbody>
					</table>
					</form>
				</section>
		</div><!--  float right -->
</div><!--  auto -->
</div><!--  showstats -->
<script type="text/javascript">

	$("#widget-orders").click(function() {
		$("#chartsBlockSection").toggle();
	   });

	$("#chartsBlockSection").hide();


	$(".simulateRun").click(function() {
		var yn=confirm("Are you sure, you want to calculate new feed rates ?");
		var restCheck = "";
		var RHEAURL = "<?php echo $RHEAURL; ?>";
		if(yn){
			var type = $(this).attr("alt");
			var curETime = "";
			
			if(type == "real"){
				curETime = "<?php echo $currentRTime; ?>";
			}

			if(curETime.length == 1){
				alert( "Please select a DATE for simulation");return;
			}else {
				$.ajax({
					type: 'POST',
					url: RHEAURL + "?stime=" + curETime + "&ajaxsimulate=1&type="+type+restCheck,
					success: function(msg) {					
						alert("Feed Rates Submitted");
						document.location.reload(true);
					}
				}); //end ajax..
			}
		}//if yn
	});//simulateRun	

	$("#automaticControlModeBut").click(function() {
		var aData = $(this).attr('title');
		var aAlt = $(this).attr('alt');
		var keyval = "";
		var MasVal = $("#masValHid").val();

		if(aData == 1){
			keyval = "OFF";
			aData = 0;
		}
		else {
			keyval = "ON";
			aData = 1;
		}
		
		if ((MasVal == "") ) {
			alert("DCS IS IN CONTROL");
			document.location.reload(true);
			return;
		}
		
		var yn=confirm("Turn "+keyval+" `AUTOMATIC` mode?");
		var restCheck = "";
		if(yn){			
			
			var baseUrl = "<?php echo Yii::app()->baseUrl;?>";
			baseUrl = baseUrl+'/rawmix/Savermsettings';

			$.ajax({            
					url:baseUrl,
					type:"GET",
					data:{formdata:aAlt+aData},
					success:function(response){
						//alert(1 + response);
						alert("`AUTOMATIC` mode was " + "turned " + keyval);
						document.location.reload(true);
					}//success						
			});//ajax
		}
	});
</script>
<script type="text/javascript">
				function ReloadPage2() {
				   location.reload();
				};

				setTimeout("ReloadPage2()", 60000);
</script>

<!-- Div for Jplayer -->
<script type="text/javascript" src="<?php echo  Yii::app()->theme->baseUrl ?>/js/jquery.jplayer/jquery.jplayer.min.js" ></script>
<script type="text/javascript">
//<![CDATA[


	// Local copy of jQuery selectors, for performance.
	var	my_jPlayer = $("#jquery_jplayer");

	// Instance jPlayer
	my_jPlayer.jPlayer({
		swfPath: "<?php echo  Yii::app()->theme->baseUrl ?>/js/jquery.jplayer",
		cssSelectorAncestor: "#jp_container",
		supplied: "mp3",
		wmode: "window"
	});
	my_jPlayer.jPlayer("setMedia", {
		mp3: "<?php echo  Yii::app()->theme->baseUrl ?>/files/audio/alert.mp3"
	});
	
	var timedLoop = setInterval(playRepeat, 5000);
	function playRepeat() {
	  my_jPlayer.jPlayer("play");
	}

//]]>
</script>
