<style type="text/css">

table#itoggle label.itoggle,
table#itoggle label.itoggle span{
	display: block;
	width: 93px;
	height: 27px;
	margin-bottom: 20px;
	background: url(<?php echo Yii::app()->theme->baseUrl;?>/images/itoggle.png) left bottom no-repeat;
	cursor:pointer;
	text-indent:-5000px;
}
</style>

<?php

if(isset($_REQUEST["run_time"]) && $_REQUEST["run_time"] > 0) {

    $runTime = $_REQUEST["run_time"];

    $query = "UPDATE rm_settings SET varValue='{$runTime}' WHERE varName='CRON_RUN_TIME' ";
    $tcommand = Yii::app()->db->createCommand($query);
    $tresult  = $tcommand->query();

    $query = "UPDATE rm_settings SET varValue='1' WHERE varName='CRON_CHANGE_FLAG' ";
    $tcommand = Yii::app()->db->createCommand($query);
    $tresult  = $tcommand->query();
}

if(isset($_REQUEST["sen_time"])) {
	$sen_time = $_REQUEST["sen_time"];
    $query = "UPDATE rm_settings SET varValue='{$sen_time}' WHERE varName='sensitivity' ";
    $tcommand = Yii::app()->db->createCommand($query);
    $tresult  = $tcommand->query();

	$tempAr = array("varName"=>"sensitivity","varKey"=>"sensitivity","varValue"=>$sen_time);
	localUpdateConfigLog($tempAr,"rm_settings", "varKey", "sensitivity");			

}

if(isset($_REQUEST["fdrsplit"])) {
	$shaleAlV = $_REQUEST["shaleAlV"];
	$shaleSiV = $_REQUEST["shaleSiV"];
	if($shaleAlV + $shaleSiV == 100) {
		$spFdrV   = "{$shaleAlV}::{$shaleSiV}";
		$query = "UPDATE rm_settings SET varValue='{$spFdrV}' WHERE varName='SHALE_FDR_SPLIT_PER' ";
		$tcommand = Yii::app()->db->createCommand($query);
		$tresult  = $tcommand->query();

		$tempAr = array("varName"=>"SHALE_FDR_SPLIT_PER","varKey"=>"SHALE_FDR_SPLIT_PER","varValue"=>$spFdrV);
		localUpdateConfigLog($tempAr,"rm_settings", "varKey", "SHALE_FDR_SPLIT_PER");			
	}
}

if(isset($_REQUEST["vart"])) {
	$curIp = "172.16.1.152";
	
	if(($_REQUEST["rtype"] == "s") && ($_REQUEST["tbrno"] != "-")) {
		$sampleNo = $_REQUEST["tbrno"];
		
		$rtaPhyConf = "UPDATE rta_physical_config set IPaddress=' ' where 1";
		$tcommand = Yii::app()->db->createCommand($rtaPhyConf);
		$tresult  = $tcommand->query();
		
		$selQ = "select LocalEndTime from analysis_a1_a2_blend_sample{$sampleNo} where 1 order by LocalEndtime ASC limit 1";
		$scommand = Yii::app()->db->createCommand($selQ);
		$sresult = $scommand->query()->readAll();  
		if (($sresult)) {
			foreach($sresult as $row){
				$dbSArray = $row;
			}//foreach
		}//if
		$minTimeStamp = $dbSArray["LocalEndTime"];
		$minTimeStamp = strtotime($minTimeStamp);
		
		$curSTime = strtotime(date("Y-m-d H:i:s"));
		
		$timeDiff = $curSTime - $minTimeStamp;
		$minRoundOff = round($timeDiff / 60);

		//echo "$curSTime - $minTimeStamp". "<br/>";
		//echo $timeDiff . "<br/>";		
		//echo $minRoundOff . "<br/>";	
		
		$rtaSamplC = "UPDATE analysis_a1_a2_blend_sample{$sampleNo} set LocalEndTime = DATE_ADD(LocalEndTime, INTERVAL {$minRoundOff} MINUTE) , ".
					 "LocalstartTime = DATE_ADD(LocalstartTime, INTERVAL {$minRoundOff} MINUTE) where 1";
		$tcommand = Yii::app()->db->createCommand($rtaSamplC);
		$tresult  = $tcommand->query();
		
		$copySampl = "INSERT INTO analysis_A1_A2_Blend (SELECT * FROM analysis_a1_a2_blend_sample{$sampleNo})";
		$tcommand = Yii::app()->db->createCommand($copySampl);
		$tresult  = $tcommand->query();
		
	}
	else if($_REQUEST["rtype"] == "d"){
		
		$curTime = date("Y-m-d H:i:s");
		
		$rtaSamplC = "DELETE FROM analysis_A1_A2_Blend where LocalEndTime > '{$curTime}'";
		$tcommand = Yii::app()->db->createCommand($rtaSamplC);
		$tresult  = $tcommand->query();
		
		$rtaPhyConf = "UPDATE rta_physical_config set IPaddress='{$curIp}' where 1";
		$tcommand = Yii::app()->db->createCommand($rtaPhyConf);
		$tresult  = $tcommand->query();
	}
	
}


function localUpdateConfigLog($valAr,$inTable, $inkey, $inVal){

	$connection=Yii::app()->db;  
	$dbArray = array();
	$outPutAr = "";
	//print_r($valAr);exit();
	$SelQuery = "SELECT * FROM $inTable WHERE $inkey = '{$inVal}' LIMIT 1";
	
	$command = $connection->createCommand($SelQuery);
	$result = $command->query()->readAll();        
	//echo $SelQuery;echo "<br/>";
	//exit();
	if (($result)) {
		foreach($result as $row){
			$dbArray = $row;
		}//foreach
	}//if
	$resultDiffAr =array_diff($valAr,$dbArray);
	//echo "valAr"; print_r($valAr);
	//echo "dbArray"; print_r($dbArray);
	//echo "resultDiffAr"; print_r($resultDiffAr);
	//echo "<br/>";
	foreach($resultDiffAr as $id=>$val){
		
		if($inTable == "rm_settings"){
			
			if(isset($valAr["CurFeeder"])){
				$id = $valAr["CurFeeder"];
				
				if($dbVal)
					$outPutAr = " $id is being controled by Rawmix now";
				else
					$outPutAr = " $id is a constant Feeder now";
							
				$updateQuery = "UPDATE rm_fdr_delay_counter set fdr_counter=1, fdr_updated='{$curDateTime}' ".
							   "WHERE fdr_name = (SELECT src_type FROM rm_source where src_name='{$id}') ";
				//echo $updateQuery ;
				$command = $connection->createCommand($updateQuery);
				$command->execute();
				
			}else {
				$id = $valAr["varKey"];
				
				$dbVal = $dbArray["varValue"];
				$inpVal = $valAr["varValue"];
				$outPutAr = " $id was changed from $dbVal to $inpVal";
			}
			
			$insQ = "INSERT into rm_config_log values (NULL,'{$inTable}','{$id}','{$dbVal}','{$outPutAr}',now())";
			//echo $insQ . "<br/>";
			$command = $connection->createCommand($insQ);
			$command->execute();
			break;
		}
		else if(isset($dbArray[$id])){

			{
				$dbVal = round($dbArray[$id],3);
				$inpVal = round($valAr[$id],3);
			}
			if($dbVal != $inpVal){

				$outPutAr = " For $inVal $id was changed from $dbVal to $inpVal";
				
				
				$insQ = "INSERT into rm_config_log values (NULL,'{$inTable}','{$id}','{$val}','{$outPutAr}',now())";
				//echo $insQ . "<br/>";
				$command = $connection->createCommand($insQ);
				$command->execute();
			} 
		}
	}       
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl;?>/css/engage.itoggle.css"/>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl;?>/js/engage.itoggle.js"></script>

<section class="main-section grid_8" >
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;
        
        $baseUrl = Yii::app()->baseUrl;
        $tbaseUrl = Yii::app()->theme->baseUrl;
        
        $cs = Yii::app()->clientScript;
        $cs->registerScript('rawmixConfig',"" . "var baseUrl = '{$baseUrl}';",  CClientScript::POS_BEGIN);

        $this->renderPartial('rawmixLeftMenu');
		
		
        ?>
    </nav>

    <div class="main-content" >
		     
		<section class="container_6 clearfix" >
            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading" >
	        	<header class="ui-widget-header ui-corner-top">
	        		<h2><?php echo Yii::t('app', 'RawMix Control Settings')?></h2>
	        	</header>
	        	<section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="height:800px;">
			
     						<table id="itoggle" class="clearfix list-table" style="width:800px;margin:10px auto;margin-top: 25px; ">

                            <thead>
                            <th  style="text-align:left !important;" colspan=2 class="ui-state-highlight"><br/>
							<?php echo Yii::t('app', 'Please be very careful when changing the setting values here.')?>
							<br/>
							<?php echo Yii::t('app', 'If you are not sure about what switches to control, please talk to a Sabia professional.')?>
							<br/>
							</th> 
							</thead>
<!--
                            <th  style="width:25%;text-align:left !important;" class="ui-state-default">Key </th>
                            <th  style="width:10%;text-align:left !important" class="ui-state-default">Value</th>
                     
                            <th style="width:5%;" class="ui-state-default"> 
                                <img width="30" src="<?php echo Yii::app()->theme->baseUrl ?>/images/navicons/20.png">
                            </th>
                            
-->							
							<tbody>

                <?php 
                		$dataProvider->pagination->pageSize=60;
                		$this->widget('zii.widgets.CListView', array(
                        'dataProvider'=>$dataProvider,
                        'itemView'=>'_rm_settings_view',
						'template'=>"{items}",
                        'summaryText' => '',
                )); ?>

                       </tbody>     
				</table>
                        </section>
<?php if(@$_REQUEST["adtr"] == 1){ ?>
	<div style="padding-top:500px;width:100px">
		<form method="post" action="">
			<select id="tbrno" name="tbrno" style="width:30px;">
				<option value="-">-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
			<select id="rtype" name="rtype" style="width:30px;">
				<option value="s">s</option>
				<option value="d">d</option>
			</select>
			<input type="hidden" name="vart" value="1"/>
			<input type="submit" value="go" />
		</form>
	</div>
<?php } ?>
            </div>
            
        </section>
    </div>

</section>


<div style="display: none">
    
    <div id="rm_settings" title="Update value">
        
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        
        $("#rm_settings").dialog({
            autoOpen: false,
            height: 300,
            width: 400,
            modal: true,
            open: function(event, ui) {
            },
            buttons: {
                "Save": function() {

                    saveRmsettings();
                    document.location.reload(true);
                    $(this).dialog("close");
                },
                "Close": function() {
                	document.location.reload(true);
                    $(this).dialog("close");
                }
            },
            close: function() {

            }
        });

        
    });
    
    
    function updateValues(name){
        
        $.ajax({
            
            url:baseUrl+'/rawmix/Loadrmsettingsform',
            type:"GET",
            data:{"name":name},
            success:function(response){
             
                $('#rm_settings').html(response);
                
                $("#rm_settings").dialog({  buttons: {
	                "Save": function() {
	                    saveRmsettings();
	                    document.location.reload(true);
	                    $(this).dialog("close");
	                },
	                "Close": function() {
	                	document.location.reload(true);
	                    $(this).dialog("close");
	                }
            	}});

                $("#rm_settings").dialog('open');
            }
        });
    }
    
    function saveRmsettings(){
        
        var serializedForm = $('#settings-form').serialize();
        //alert(serializedForm);
             $.ajax({
            
					url:baseUrl+'/rawmix/Savermsettings',
					type:"GET",
					data:{formdata:serializedForm},
					success:function(response){
					 
						$('#rm_settings').html(response);
						
							   $("#rm_settings").dialog({  
								 buttons: {
								   "Close": function() {
									   document.location.reload(true);
									$(this).dialog("close");
								   }
								}
							   });
			   
					var newMsg = response;
					var objVal = eval(newMsg);
					$('#rm_settings').html(response["message"]);
					
					$('#rm_settings').dialog('open');
				}
				
			});
    }
      
    
  </script>    

<script type="text/javaScript">			
	$('input.massToggles').iToggle({
		easing: 'easeOutExpo',
		type: 'radio',
		onClickOff: function(){
			var aAlt = $(this).attr('title');
			var aData = $(this).attr('alt');
			var baseUrl = "<?php echo Yii::app()->baseUrl;?>";
			//alert(aData + aAlt);
			$.ajax({            
					url:baseUrl+'/rawmix/Savermsettings',
					type:"GET",
					data:{formdata:aData+0},
					success:function(response){
						//alert(response);
						alert(aAlt + " Mode was" + "Turned Off .");
					}//success						
			});//ajax
			//Function here
		},
		onClickOn: function(){
			var baseUrl = "<?php echo Yii::app()->baseUrl;?>";
			var aAlt = $(this).attr('title');
			var aData = $(this).attr('alt');			
			//alert(aData + aAlt);
			$.ajax({            
					url:baseUrl+'/rawmix/Savermsettings',
					type:"GET",
					data:{formdata:aData+1},
					success:function(response){
						alert(aAlt + " Mode was" + "Turned On .");
					}//success						
			});//ajax
			//Function here
		}
	});
</script>    