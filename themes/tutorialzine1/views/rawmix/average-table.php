
			<?php 
			
			
					if(isset($_REQUEST['sTime'])){
						
						$startTime = date('Y-m-d H:i:s',strtotime($_REQUEST['sTime']));
						$endTime   = date('Y-m-d H:i:s',strtotime($_REQUEST['eTime']));
						
					}else{
						
						
                     //  $currentTimeTick = strtotime('2018-08-23 02:50:24');
						
						$currentTimeTick = time();
						
						$tmpDatw = date('Y-m-d H',time());
						$HourTime = strtotime($tmpDatw.":00:00");
						
						
						if($currentTimeTick > $HourTime){
							
							$currentTimeTick = $HourTime + ( 3660);
						}
						
						$endTime   = date('Y-m-d H:i:s',$currentTimeTick);
						$startTime = date('Y-m-d H:i:s',$currentTimeTick - (3 * 3600));
						
						
					}
					
					$elements = array('LocalendTime','SiO2','Al2O3','Fe2O3','CaO','KH','SM','AM','TPH');
					$displayElements = array('Endtime','SiO2','Al2O3','Fe2O3','CaO','KH','SM','AM','TPH');
					
					
			
			?>
			
						<table id="avg-table" class="customStyle dataTable no-footer" >
			
							<thead>
							
									<?php 
											foreach($displayElements as $dele){
												if($dele == 'AM') $dele = "IM";
												echo "<th class='ui-state-default '>  ".$dele." </th>";
											}
									?>
							</thead>
				<tbody>
				
				
				<?php 
							$i = (int)strtotime($endTime);
                         
                           $stopTime = (int)strtotime($startTime); 
                                               
                         // var_dump($tmpDatw.":00:00"); 
						 // var_dump($endTime,$startTime); 
						  
						  
						  
						
						$ri = 0;
						$dispAr = array();
						while($i > $stopTime){
							$rowTr = "";
							$sTime = date('Y-m-d H:i:s',$i - 3600);
							$eTime   =   date('Y-m-d H:i:s',$i);
							
								
							//echo $sTime . " , " . $eTime . "<br/>";
							$avgArray = getaIntervalAvg($sTime,$eTime);
						
							if(array_sum($avgArray) > 0):
							
								if($ri % 2 ==0) {
									$rowTr .=  '<tr class="gradeA odd">';
								}
								else {
									$rowTr .=  '<tr class="gradeB even">';
								}
								foreach($elements as $ele){
									
									$rowTr .=  "<td> ".$avgArray[$ele]." </td>";
								}
								
								$rowTr .=  "</tr>";
								$ri++;								
							endif;
						
							$i -= 3600;
							
							array_push($dispAr,$rowTr);
						}
						//$dispAr = array_reverse($dispAr);
						foreach($dispAr as $erow) echo $erow;
		
				?>
				
		
		
				</tbody>
				</table>
			
		

<?php 


function getaIntervalAvg($startDate,$endTime){
	
	$sql = "select * from analysis_A1_A2_Blend  where LocalendTime > '".$startDate."'  AND LocalendTime <= '".$endTime."' ORDER BY LocalendTime DESC";
	//echo $sql . "<br/>";
	$elements = array('LocalendTime','Al2O3','SiO2','Fe2O3','MgO','CaO','KH','AM','SM','TPH');
	
	$average = array();
	
	
	$result = Yii::app()->db->createCommand($sql)->queryAll();
	
	foreach($result as $row){
		
		foreach($elements as $ele){
			
			
              $tAl2O3  = (float)$row['Al2O3'];

              $tSiO2  =(float)$row['SiO2'];

              $tFe2O3  =(float)$row['Fe2O3'];

              $tCaO    = (float)$row['CaO'];


              //Calculate formulas
              if($ele == 'KH'){
                  if($tSiO2)
                     $formulaVal = (($tCaO - 1.65 * $tAl2O3 - 0.35 * $tFe2O3) / (2.80 * $tSiO2));
                  else
                      $formulaVal = 0.0;
				$row[$ele] = $formulaVal;

              } else if ($ele == "SM") {
                  if(($tAl2O3 + $tFe2O3))
				   $formulaVal = round((( $tSiO2) /
                            ($tAl2O3 +
                            $tFe2O3)), 3);
                   else
                      $formulaVal = 0.0;
					$row[$ele] = $formulaVal;		
                    
                    
            } else if ($ele == "AM"){
                  if($tFe2O3)                
                    $formulaVal = round(( $tAl2O3 /
                   $tFe2O3), 3);
                    else
                      $formulaVal = 0.0;
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
			
			$eleAvg[$key] = ($tmpArray[0]) ; 
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
