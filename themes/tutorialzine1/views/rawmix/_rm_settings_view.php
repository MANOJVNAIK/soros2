<?php
$usrLvl = Yii::app()->user->level ;
$varNameval = $data->varName;
//$varArray = array("Manual", "AUTOMODE","STARVATION","MAX_RUNS","numOfIterations","SIMULATE","MULTIPLE_VARIABLES");
if($usrLvl == 1) {
	$varArray = array("STARVATION");
}
else {
	$varArray = array("Manual", "AUTOMODE","STARVATION","constFeeders", "CRON_RUN_TIME","sensitivity","SHALE_FDR_SPLIT_PER");
}

$federsplQuery = 'select varValue from rm_settings where varName ="FDR_SPLIT_ENABLED"';
$fdrSplEnd = Yii::app()->db->createCommand($federsplQuery)->queryScalar();

$federQuery = 'select varValue from rm_settings where varName ="allFeeders"';
$fdrString = Yii::app()->db->createCommand($federQuery)->queryScalar();
$allFeeders = explode(";",$fdrString);

$newVarArray = array(	"Manual"=>     "MANUAL",
						"AUTOMODE"=>"AUTOMATIC",
						"STARVATION"=>"STARVATION",
						//"MAX_RUNS"=>"MAX-RUNS",
						"numOfIterations"=>"NUM-OF-ITERATIONS",
						//"SIMULATE"=>"SIMULATE",
						//"MULTIPLE_VARIABLES"=>"MULTIPLE-VARIABLES",
						//"timeStampsPerInterval"=>"TIME BETWEEN RUNS",
						"AUTO_TEST"=>"AUTO-TEST",
						"CRON_RUN_TIME"=>"CRON_RUN_TIME",
						"constFeeders" => "FEEDER SETTINGS",
						"sensitivity" => "CONTROL SENSITIVITY",
						"SHALE_FDR_SPLIT_PER" =>"SHALE FEEDER SPLIT PERCENTAGE RATIO X:Y"
						//"MASTER_CONTROL_MODE"=>"Sabia Master Control Mode"
    );
			
$newVarDescArray = array(	"Manual"=>Yii::t('rm_settings',"Controls Manual Rawmix Operation Mode; To be left On at all times."),
							"AUTOMODE"=>Yii::t('rm_settings',"Controls Automatic Rawmix Operation Mode; On=Automatic; Off=Manual."),
							"STARVATION"=>Yii::t('rm_settings',"Controls Starvation Flag, indicating if the system is in Starvation Mode."),
							//"MAX_RUNS"=>"MAX-RUNS",
							//"numOfIterations"=>"NUM-OF-ITERATIONS",
							//"SIMULATE"=>Yii::t('rm_settings',"Controls Simulation Operation Mode; To be left Off at all times."),
							//"MULTIPLE_VARIABLES"=>"MULTIPLE-VARIABLES",
							//"timeStampsPerInterval"=>"TIME BETWEEN RUNS",
							"AUTO_TEST"=>Yii::t('rm_settings',"Controls Rawmix in Semi-Automatic Mode; To be left On at all times."),
							"constFeeders"=>Yii::t('rm_settings',"Change Feeder Settings to Constant/Auto Mode"),
							"CRON_RUN_TIME"=>Yii::t('rm_settings',"Run time for Rawmix Control"),
							"sensitivity" => Yii::t('rm_settings','CONTROL SENSITIVITY'),
							"SHALE_FDR_SPLIT_PER" => Yii::t('rm_settings','Please input the ratio in % only decimal values.'),
							//"MASTER_CONTROL_MODE"=>Yii::t('rm_settings',"Master Sabia Control switch for Rawmix Control"),
							);			
if(in_array($varNameval,$varArray)){
$ovarName   = $varNameval;	
$varNameval = $newVarArray[$varNameval];

$altValue = "Settings[varName]={$data->varName}&Settings[varKey]={$data->varKey}&Settings[varValue]=";
?>
<tr><td colspan=2></td></tr>
<tr><td colspan=2></td></tr>

<tr>
	<?php 
	
		if($varNameval == "FEEDER SETTINGS") $colspanText = "colspan=2 "; 
		if($ovarName == "SHALE_FDR_SPLIT_PER" && !$fdrSplEnd) return;

	
	?>
	<td style="text-align:left !important;" <?php echo $colspanText; ?>>
		<?php echo CHtml::encode(Yii::t('rm_settings',$varNameval)); ?><br/><br/>
		<span style="color:gray;font-size:12px;"><?php echo $newVarDescArray[$ovarName]; ?></small>
    </td>
<?php
	if($ovarName == "constFeeders"){
?>
	</tr>
	<tr>
	<td style="text-align:left !important;" >
	<table>
	
<?php		
		$constFeedersAr = explode(";",$data->varValue);
		foreach($allFeeders as $fdid=>$fdval){
		
		if($fdval == "")continue;
?>
		<td style="text-align:left !important;" >
		<?php
		
				foreach($constFeedersAr as $coid=>$cval){
					if($cval == $fdval){ 
						$varVal =0;
						break;
					}
					else
						$varVal =1;
				} 				
				if($varVal == 0)
					$switchVal = '';
				else	
					$switchVal = "checked='checked'";	
				
				$altValue = "Settings[CurFeeder]={$fdval}&Settings[ConstFeeder]={$data->varValue}&Settings[varName]={$data->varName}&Settings[varKey]={$data->varKey}&Settings[varValue]=";

		  ?>
		  <label ><?php echo CHtml::encode(Yii::t('dash',$fdval)) . "<br/>"; ?></label>
		  <input type="checkbox" <?php echo $switchVal; ?> class="massToggles" alt="<?php echo $altValue; ?>" title="<?php echo $fdval; ?>"/>

		  
		</td>
<?php
		}//foreach
?>
	</table>
	</td>
	<td></td>
<?php		
	}//if constFeeders
	else if($ovarName == "sensitivity") {
	$srunTimeArray = array("0","1","2");
	$srunTimeTextArray = array("NORM","FAST","AGGR");
	$varVal =  CHtml::encode(round($data->varValue,0)); 
?>
	<td style="text-align:left !important;">
		<form action="" method="post">
			<select name="sen_time" alt="<?php echo $altValue; ?>" title="<?php echo $varNameval; ?>" style="width:57px;" >
			<?php 
				foreach($srunTimeArray as $val){ 
					$sel = "";
					if($val == $varVal) $sel = "selected=selected"; 
					echo '<option value="'.$val.'" '.$sel.'> '.$srunTimeTextArray[$val].' </option>'; 
				
				} 
			?>
		  </select>  <input type="submit" value="<?php echo Yii::t('rm_settings','GO')?>" />
		</form>
	 	</td>
<?php		
	}
	else if($ovarName == "SHALE_FDR_SPLIT_PER" ) {
		
	$varVal =  $data->varValue; 
	list($varVal1,$varVal2) = explode("::",$varVal);
?>
	<td style="text-align:left !important;">
		<form action="" method="post">
			<span style="font-weight:bold;">Al</span> <input name="shaleAlV" style="padding-left:5px;width:30px;" type="text" value="<?php echo $varVal1; ?>" /> <span  style="font-weight:bold;">Si </span><input  style="padding-left:5px;width:30px;" name="shaleSiV" type="text" value="<?php echo $varVal2; ?>" />
			<input name="fdrsplit" type="submit" value="<?php echo Yii::t('rm_settings','GO')?>" />
		</form>
	 	</td>
<?php		
	}
	else if($ovarName == "CRON_RUN_TIME") {
	$runTimeArray = array("5","10","15");
	$varVal =  CHtml::encode(round($data->varValue,0)); 
?>
	<td style="text-align:left !important;">
		<form action="" method="post">
			<select name="run_time" title="<?php echo $altValue; ?>" alt="<?php echo $varNameval; ?>" style="width:57px;" >
			<?php 
				foreach($runTimeArray as $val){ 
					$sel = "";
					if($val == $varVal) $sel = "selected=selected"; 
					echo '<option value="'.$val.'" '.$sel.'> '.$val.' </option>'; 
				
				} 
			?>
		  </select>  <input type="submit" value="<?php echo Yii::t('rm_settings','GO')?>" />
		</form>
	 	</td>
<?php		
	}else {
		
?>
	<td style="text-align:left !important;">
		
	      <?php 
				$varVal =  CHtml::encode(round($data->varValue,0)); 
				if($varVal == 0)
					$switchVal = "";
				else	
					$switchVal = "checked='checked'";	
				
				if($ovarName == "MASTER_CONTROL_MODE" || $ovarName == "AUTOMODE" || $ovarName == "AUTO_TEST")
					$ideVal = " id='".$ovarName."' ";
				else
					$ideVal = "";
		  ?>	
		<input type="checkbox" <?php echo $switchVal; ?> <?php echo $ideVal; ?> class="massToggles" alt="<?php echo $altValue; ?>" title="<?php echo $varNameval; ?>"/>

	  	</td>
	
<?php
	}//else	
?>		

</tr>
<?php
}
?>