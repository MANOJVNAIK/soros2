<section class="main-section grid_8">

    <nav class="collapsed">
	<!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
	<?php
	$layoutY = $this->layout;
	$them = Yii::app()->theme->name;

	$this->renderPartial('rawmixLeftMenu');
	?>
    </nav>
    <div class="main-content" >
	<section class="container_6 clearfix" style="margin-top:0px !important;margin-bottom:0px !important;padding-top:2px !important;">
	    <!-- Tabs inside Portlet -->
	    <div class="grid_6 leading" style="margin-top:0px !important;padding-top:2px !important;">
			<section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="min-height:340px;background:transparent !important;border:0px !important;">
				
				
				<div id="showStats" title="Accept Proposed Values" style="margin:20px 20px;min-height:280px;">
				<div style="width:100%;height:auto;">
					<div style="width:100%;float:left;">
						    <section id="sidebarpaneDialog-2" style="height:105px">
							<header class="ui-widget-header ui-corner-top">
				<h2>
						Analysis Results
				</h2>
			</header>
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
												    $rArr 	   = array(5,15,30,60,90,120);
												    $rArrAssoc = array();

													$settingsQ = "select * from rm_settings where varName='AUTOMODE' OR varName='AUTO_TEST' ";
												    	$commandQ = Yii::app()->db->createCommand($settingsQ);
													
													$settModeAr = $commandQ->query()->readAll();
													
													foreach($settModeAr as $sr){
														if($sr["varName"] == "AUTOMODE")
															$settAMode = $sr["varValue"]; 
														if($sr["varName"] == "AUTO_TEST")
															$settATMode = $sr["varValue"]; 
													}

												    $sql =  "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 ".
														"AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
												    $command = Yii::app()->db->createCommand($sql);

												    $spList = $command->query()->readAll();
												    $colstr ="";
												    $def_setPointsString = "";
												    foreach($spList as $spAr) {
														$elem = $spAr["sp_name"];
														//AS03222015
														if($elem == "KH")
															$elem = "IF( (CaO <= 0), 0 , ROUND(((CaO - 1.65 * Al2O3 - 0.35 * Fe2O3) / (2.80 * sio2)),3) ) as KH";				
														else if($elem == "LSF")
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
														$def_setPointsString .= $spAr["sp_name"] . "_Avg:(".$spAr["sp_value_num"].");";
												    }												    $colstr = substr($colstr,0,-1);
												    $def_setPointsString = substr($def_setPointsString, 0 ,-1);

												    $colstr .= ",`CaO`,`Al2O3`,`Fe2O3`,`SiO2`";

												    $sptsSql =  "SELECT $colstr, TPH FROM `analysis_A1_A2_Blend` WHERE 1 ORDER BY LocalendTime DESC LIMIT 125";
												    $sptCommand = Yii::app()->db->createCommand($sptsSql);

												    $spValsList = $sptCommand->query()->readAll();

												    $i =0;
												    $k =0;
												    $setPointsString = "";
												    //Array ( [sp_name] => LSF [sp_value_num] => 95.00000 [sp_measured] => 0.00000 );
												    
												    array_push($spList, Array( "sp_name" => "CaO","sp_value_num" => 0));
												    array_push($spList, Array( "sp_name" => "Al2O3","sp_value_num" => 0));
												    array_push($spList, Array( "sp_name" => "Fe2O3","sp_value_num" => 0));
												    array_push($spList, Array( "sp_name" => "SiO2","sp_value_num" => 0));
													//array_push($spList, Array( "sp_name" => "MgO","sp_value_num" => 0));
												    //array_push($spList, Array( "sp_name" => "K2O","sp_value_num" => 0));


												    foreach($spValsList as $id=>$anArr) {
														    foreach($spList as $spAr) {
															$spname = $spAr["sp_name"];

															if(in_array($i,$rArr) && $k > 0){
																//if($spname == "C3S")
																//echo $spname ." : " . $i . " : total :=".$rArrAssoc[$spname]["total"] . " : = " .round(($rArrAssoc[$spname]["total"]/$k),2) . " : " . $k . "<br/>";

																$avgVal =  round(($rArrAssoc[$spname]["total"]/$k),2);
																$rArrAssoc[$spname][$i] = $avgVal;
																if (($i == 15) && isset($spname) && isset($avgVal)) {
																	$setPointsString .= "$spname:" . round($avgVal,2) . ";";
																}
															}

																$rArrAssoc[$spname]["total"] += $anArr[$spname];
														    }

														    if($anArr["TPH"] >0) {
															$k++;
														    }
															$i++;
												    }
												    $setPointsString = substr($setPointsString, 0 ,-1);
												    if($setPointsString == "")
													$setPointsString = $def_setPointsString;

												    //foreach($rArrAssoc as $id=>$val) {
													//echo $id; print_r($val);echo "<br/>";echo "<br/>";
												    //}
												    $i =0;											    


												    foreach($spList as $spAr) {
													if($i % 2 ==0) {
														echo '<tr class="gradeA odd" style="height:30px !important;">';
													}
													else {
														echo '<tr class="gradeB even" style="height:30px !important;">';
													}
													$spname = $spAr["sp_name"];
													echo '<td style="width:20%;height:20px;font-weight:bold">'. $spname .'</td>';
													echo '<td >'. sprintf("%4.2f",$spAr["sp_value_num"]) .'</td>';
													$avgAr = "";
													if(isset($rArrAssoc[$spname])){
														foreach($rArrAssoc[$spname] as $id=>$val) {
															if($id != "total"){
																$avgAr =  '<td>'. sprintf("%4.2f",$val) .'</td>' . $avgAr;
															}
														}
														echo $avgAr;
													}else {
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
				</div><!--  auto -->
				</div><!--  showstats -->
				
				<div title="Accept Proposed Values" style="margin:100px 20px;min-height:280px;">
				<div style="width:100%;height:auto;">
					<div style="width:100%;float:left;">
					<header class="ui-widget-header ui-corner-top">
						<h2>
								Rm History
						</h2>
					</header>
					
					<form  name="proposedformsubmit" id="proposedformsubmit" method="get" action="#">
                                 <table id="dbtable1" class="customStyle" style="width:100%;font-size:medium;border:1px solid #F0F0F0;">
                                  
								  <thead>

                                    <?php
                                        $sql =  "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 ".
                                                    "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
                                        $command = Yii::app()->db->createCommand($sql);

                                        $spList = $command->query()->readAll();

                                        $curTime = time();
                                        $days = $_REQUEST["days"];

                                        if(isset($days)){
                                            $days = $days;
                                        }else {
                                            $days = 5;
                                        }

                                        $prev3daysData = $curTime - ($days * 24 * 60 * 60) ;
                                        $displayTime = date("Y-m-d H:i:00",$prev3daysData);

                                        $status		 = "";

                                        if(isset($_REQUEST["status"])) {
                                            $statusMsg = "";
                                        }else{
                                            $statusMsg = "SUCCESS";
                                        }
										$query 	= 'SELECT *                 FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id  ORDER BY rm_run_id DESC';
										//$csql 	=  ;//'SELECT count(*) as count FROM rm_inputoutputdump rio INNER JOIN rm_runlog rl ON rm_sid=rm_sim_id  ORDER BY rm_run_id DESC LIMIT 5';
				               
										
										//echo "Debug ".$query	;					
										$command = Yii::app()->db->createCommand($query);

										$ccommand = Yii::app()->db->createCommand($csql);

										$countRow = 5;

										$dataProvider = new CSqlDataProvider($query, array(
											'keyField' => 'rm_sid',
											'totalItemCount' => $countRow['count'],
											'pagination' => array(
											'pageSize' => 5,
											),
										));
                                        $anyList = $command->query()->readAll();

                                        $sql =  "SELECT src_id,src_name,src_measured_feedrate,src_min_feedrate,src_max_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `rm_source` WHERE 1 ".
                                                    "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
                                        $command = Yii::app()->db->createCommand($sql);

                                        $srcList = $command->query()->readAll();
                                        $i =0;
                                        $totalFeedR = 0;
                                        $colLen = count($srcList);
                                        $spLen  = count($spList);

                                        echo '<tr>';
                                                    echo '<th class="ui-state-default"></th>';
                                                    echo '<th class="ui-state-default" ></th>';
                                                    echo '<th class="ui-state-default" colspan="'.$colLen.'"><span style="font-weight:bold;">Input Feed-Rates</span></th>';
                                            echo '<th class="ui-state-default" colspan="'.$spLen.'"><span style="font-weight:bold;">Input Analysis</span></th>';
                                            echo '<th class="ui-state-default" colspan="'.$colLen.'"><span style="font-weight:bold;">Output Feed-Rates</span></th>';
                                        echo '</tr>';

                                       echo '<tr style="font-size:14px !important;">';
										echo '<th class="ui-state-default" >Time</th>';
										echo '<th class="ui-state-default" >Run</th>';

                                        foreach($srcList as $spAr) {
												$spAr['src_name'] = str_replace("New_LimeStone","Lime(N)",$spAr['src_name']);
												$spAr['src_name'] = str_replace("Old_LimeStone","Lime(O)",$spAr['src_name']);

												$spAr['src_name'] = str_replace("Old_","(O)",$spAr['src_name']);
												$spAr['src_name'] = str_replace("New_","(N)",$spAr['src_name']);
												$spAr['src_name'] = str_replace("Bottom_","",$spAr['src_name']);

												if(isset($spAr["src_name"]))
														echo '<th class="ui-state-default" >'. Yii::t("dash",str_replace("% ","",$spAr["src_name"])).'</th>';
												else
														echo '<th></th>';
                                        }

                                        foreach($spList as $spAr) {
											if(isset($spAr["sp_name"]))
													echo '<th class="ui-state-success">'. $spAr["sp_name"].'</th>';
											else
													echo '<th></th>';
                                        }

                                        foreach($srcList as $spAr) {
											$spAr['src_name'] = str_replace("New_LimeStone","Lime(N)",$spAr['src_name']);
											$spAr['src_name'] = str_replace("Old_LimeStone","Lime(O)",$spAr['src_name']);

											$spAr['src_name'] = str_replace("Old_","(O)",$spAr['src_name']);
											$spAr['src_name'] = str_replace("New_","(N)",$spAr['src_name']);
											$spAr['src_name'] = str_replace("Bottom_","",$spAr['src_name']);

                                            if(isset($spAr["src_name"]))
                                                    echo '<th class="ui-state-highlight">'. Yii::t("dash",str_replace("% ","",$spAr["src_name"])).'</th>';
                                            else
                                                    echo '<th></th>';
                                            }
                                            echo '<tr>';

                                            ?>
											
										 </thead>
                                        <tbody>

										<?php
										$this->widget('zii.widgets.CListView', array(
											'dataProvider' => $dataProvider,
											'itemView' => '_iohistory_row_view',
											'template' => ' {items} ',
											'viewData'=>array('spList'=>$spList,'srcList'=>$srcList),
																'emptyText' => 'No Results Found'
										));
										?>

									</tbody>
								</table>

				<?php
				$this->widget('CLinkPager', array(
				    'pages' => $dataProvider->getPagination(),
				    'firstPageLabel' => 'First',
                     'lastPageLabel' => 'Last',
				    'prevPageLabel' => '<<  ',
				    'nextPageLabel' => ' >>',
				    'htmlOptions' => array('class' => ' pagination pull-right'),
				    'hiddenPageCssClass' => 'hide',
				    'internalPageCssClass' => 'pagenum',
				    'header' => '',

				));
				?>
			    </form>
                           
					</div>
					</div>
				</div>
				
			<div title="Accept Proposed Values" style="margin:100px 20px;min-height:280px;">
				<div style="width:100%;height:auto;">
					<div style="width:100%;float:left;">
					<header class="ui-widget-header ui-corner-top">
						<h2>
								Average Interval
						</h2>
					</header>
			
				<div>
			
			<?php 
			
					//$currentDate = date('Y:m:d H:i:s',strtotime('2018-08-23 02:03:24'));
					
					$currentDate = date('Y:m:d H:i:s',time());
					$date = date('Y-m-d',strtotime($currentDate));
					$houre = date('H',strtotime($currentDate));
					$elements = array('LocalendTime','Al2O3','SiO2','Fe2O3','MgO','CaO','KH','AM','SM','TPH');
					$displayElements = array('Endtime','Al2O3','SiO2','Fe2O3','MgO','CaO','KH','AM','SM','TPH');
					$Hdate = $date." $houre".":00:00" ;//date('Y-m-d H:i:s',$date." $houre".":00:00");
					
					//echo date('Y-m-d H:i:s',time());
					
					$pHoureTic = strtotime($Hdate);//date('Y-m-d H:i:s',);
					$counter = $pHoureTic;
			
			?>

						<table id="avg-table" class="customStyle dataTable no-footer ">
			
							<thead>
							
									<?php 
											foreach($displayElements as $dele){
												
												echo "<th class='ui-state-default '>  ".$dele." </th>";
											}
									?>
							</thead>
				<tbody>
				
				
				<?php 
				
					//	echo $Hdate;
						//echo  date('Y-m-d H:i:s',strtotime($Hdate));
							$avgArray = getaIntervalAvg($Hdate,$currentDate);
							
							echo "<tr>";
									foreach($elements as $ele){
											
											echo "<td> ".$avgArray[$ele]." </td>";
										}
							
							echo "</tr>";
						
						for($i = 0;$i< 24 ; $i++){
							
						
							echo "<tr>";
							$counter -= 3600;
							
							$endDate 	 =  date('Y-m-d H:i:s',$counter);
							$startDate   =  date('Y-m-d H:i:s',$counter - 3600);
							
							$avgArray = getaIntervalAvg($startDate,$endDate);
							
							//	var_dump($var);
					
							foreach($elements as $ele){
											
											echo "<td> ".$avgArray[$ele]." </td>";
										}
							
							
						
							echo "</tr>";
									
							}
						
					
					
		
				?>
				
		
		
				</tbody>
				</table>
			
			</div>
			
			</div>
			
			</div>
			</div>
			
			
			</section>
			</div><!--  grid_6 -->
			
	</section>
</div><!-- main -->

</section>




<?php 


function getaIntervalAvg($startDate,$endTime){
	
	$sql = "select * from analysis_A1_A2_Blend  where LocalendTime > '".$startDate."'  AND LocalendTime < '".$endTime."'";
	
	$elements = array('LocalendTime','Al2O3','SiO2','Fe2O3','MgO','CaO','KH','AM','SM','TPH');
	
	$average = array();
	
	
	$result = Yii::app()->db->createCommand($sql)->queryAll();
	
	foreach($result as $row){
		
		foreach($elements as $ele){
			
			
              $tAl2O3  = $row['Al2O3'];

              $tSiO2  =$row['SiO2'];

              $tFe2O3  =$row['Fe2O3'];

              $tCaO    = $row['CaO'];


              //Calculate formulas
              if($ele == 'KH'){
                $formulaVal = (($tCaO - 1.65 * $tAl2O3 - 0.35 * $tFe2O3) / (2.80 * $tSiO2));
				$row[$ele] = $formulaVal;

              } else if ($ele == "SM") {
                   
				   $formulaVal = round((( $tSiO2) /
                            ($tAl2O3 +
                            $tFe2O3)), 3);
					$row[$ele] = $formulaVal;		
                    
                    
            } else if ($ele == "AM"){
                    $formulaVal = round(( $tAl2O3 /
                   $tFe2O3), 3);
				   $row[$ele] = $formulaVal;
              }
			  
			$average[$ele][] =  $row[$ele];
			
		}
		
	}
	
	$eleAvg = array();
	foreach($average as $key => $tmpArray){
		
		
	if($key == 'totalTons'){
			
			$sum   =  array_sum($tmpArray);
			$eleAvg[$key] = round($sum,3) ;
			
			continue;
		}
		
		
		
		if($key == 'LocalendTime'){
			
			$eleAvg[$key] = array_pop($tmpArray) ; 
			continue;
		} /*else{
			
				$count = count($tmpArray);
		
				$sum   =  array_sum($tmpArray);
		
				$avg = $sum  / $count;
		
		
				$eleAvg[$key] = round($avg,3) ;
		}*/
		
				$count = count($tmpArray);
				$sum   =  array_sum($tmpArray);
				$avg = $sum  / $count;
				$eleAvg[$key] = round($avg,3) ;
		
	}
	
	//var_dump($eleAvg);
	return $eleAvg;
	
}



?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.dataTables.min.js" ></script>
			<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/dataTables.tableTools.min.js" ></script>
<script type="text/javascript">



    
	
	
	$("#avg-table").dataTable( {
						"sPaginationType": "full_numbers",
					    "bLengthChange": true,
					    "bFilter": false,
					    "bSort": true,
					    "bInfo": true,
					    "bAutoWidth": true,
					    "bDestroy": true,
						"iDisplayLength": 25,
					    dom: "T<'clear'>lfrtip","tableTools": {
													"sSwfPath": "/Helios/themes/tutorialzine1/js/swf/copy_csv_xls_pdf.swf",
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
					} );
					</script>

