<section class="main-section grid_8">
 <nav class="">
   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
  <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
 </nav>
 
 <?php 
 	$features = Yii::app()->params["features"];
 	if(@($features["auto_tagging"]) && (1 == $features["auto_tagging"])){
 		$autoTaggingFlag = 1;
 	}else {
 		$autoTaggingFlag = 0;
 	}
 ?>
<div class="main-content">
    <header>
        <h2>Tags Management System
        </h2>
    </header>
    <section class="container_6 clearfix">
    
                                <div class="tabs">
                                    <ul>
                                        <li><a href="#pane-2">Tag(s)</a></li>
                                        <li><a href="#pane-1">Tag-Group</a></li>
                                        <?php if($autoTaggingFlag){ ?>
                                        <li><a href="#pane-3">Auto-Tagging</a></li>
                                        <?php }//auto Tagging ?>
                                    </ul>
                                    <!-- tab "panes" -->
                                    <section id="pane-1">
                                        <div class="sliders clearfix">
											<div id="successMessageTG" style="display:none;background:#CCFF99;color:black;border:1;"></div>
									         <div style="float:left;width:50%;">
										         <span style="width:150px;">Create New Tag-Group :</span>
												  <button class="button" id="addNewTagGroup" name="addNewTagGroup"> + Tag-Group</button>
											 </div>
											 <div class="grid_6 leading" style="width:1100px;">
												<div class="search-form" style="display:none">
													<?php $this->renderPartial('_tagsearch',array(
														'model'=>$model,
													)); 
													
													
													Yii::app()->clientScript->registerScript('search', "
														$('.search-button').click(function(){
															$('.search-form').toggle();
															return false;
														});
														$('.search-form form').submit(function(){
															$.fn.yiiGridView.update('taggroups-grid', {
																data: $(this).serialize()
															});
															return false;
														});
													");
													
													?>
												</div><!-- search-form -->
										<?php 
												$this->widget('zii.widgets.grid.CGridView', array(
													'id'=>'taggroups-grid',
													'dataProvider'=>$dataProvider,
													'itemsCssClass' =>'displaytab',
													'summaryText'=>'',
													'filter'=>$model,
													'columns'=>array(
														/*'lay_id',*/
														/*'a_href',*/
														'tagGroupID',
														/*'gadPlacement',*/
														'tagGroupName',
														array(
															'class'=>'CButtonColumn',
															'template'=>'{update}{delete}',
															'buttons'=>array
													        (
													            'update' => array
													            (
													            	'url' =>'"#$data->tagGroupID"',
													                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/update/$data->tagID"',
													                'visible'=>'1',
													                'options'=>array('class'=>'TagGroupUpdate','alt'=>"{$data->tagGroupID}"),
													            ),
													            'delete' => array
													            (
													            	'url' =>'"#$data->tagGroupID"',
													                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/delete/$data->tagID"',
													                'visible'=>'1',
													                'options'=>array('class'=>'TagGroupDelete','alt'=>"{$data->tagGroupID}"),
													                //'options'=>array('onclick'=>$data->id),
													            ),
													        ),
														),//array
													),//columns
												)); 
										?>                            
											 </div>
                                         </div>
    								</section>
                                    <!-- tab "panes" -->
                                    <section id="pane-2">
                                        <div class="sliders clearfix">
										    <div class="sidebar-tabs">
										        <ul>
										            <li><a href="#ltagblock" style="background:#99FF99;">Live Tag(s)</a></li>
										            <li><a href="#ctagblock">Completed Tag(s)</a></li>
										        </ul>
										            <section style="display:block" id="ltagblock" >
                                        
											            <div style="float:left;width:50%;">
												          <span style="width:150px;">Create New Tag :</span>
														  <button class="button" id="addNewTag" name="addNewTag"> + Tag</button>
														</div>
														<div id="successMessageT1" style="display:none;background:#CCFF99;color:black;border:1;"></div>
														<div class="grid_6 leading" style="width:98%;">
															<div class="search-form" style="display:none">
																<?php $this->renderPartial('_tagsearch',array(
																	'model'=>$model,
																)); 
																
																
																Yii::app()->clientScript->registerScript('search', "
																$('.search-button').click(function(){
																	$('.search-form').toggle();
																	return false;
																});
																$('.search-form form').submit(function(){
																	$.fn.yiiGridView.update('tags-grid', {
																		data: $(this).serialize()
																	});
																	return false;
																});
																");
																
																?>
															</div><!-- search-form -->
															<?php 
																	$this->widget('zii.widgets.grid.CGridView', array(
																		'id'=>'tags-grid',
																		'dataProvider'=>$tagsData,
																		'filter'=>$tmodel,
																		'summaryText'=>'',
																		'itemsCssClass' =>'displaytab',
																		'columns'=>array(
																			/*'lay_id',*/
																			/*'a_href',*/
																			'tagID',
																			/*'gadPlacement',*/
																			'status',
																			'tagName',
																			'LocalstartTime',
																			'LocalendTime',
																			array(
																				'class'=>'CButtonColumn',
																				'template'=>'{update}{delete}',
																				'buttons'=>array
																		        (
																		            'update' => array
																		            (
																		            	'url' =>'"#"',
																		                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/update/$data->tagID"',
																		                'visible'=>'1',
																		                'options'=>array('class'=>'QueuedUpdate','alt'=>"{$data->tagID}"),
																		            ),
																		            'delete' => array
																		            (
																		            	'url' =>'"#$data->tagID"',
																		                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/delete/$data->tagID"',
																		                'visible'=>'1',
																		                'options'=>array('class'=>'QueuedDelete','alt'=>"{$data->tagID}"),
																		                //'options'=>array('onclick'=>$data->id),
																		            ),
   																		        ),
																			),//array
																		),//columns
																	)); 
															?>                            
													 </div> <!-- grid_6 -->
												</section><!-- ltagblock -->
									            <section style="display:block" id="ctagblock" >
														<div id="successMessageT2" style="display:none;background:#CCFF99;color:black;border:1;"></div>
														<div class="grid_6 leading" style="width:98%;">
															<div class="search-form" style="display:none">
																<?php $this->renderPartial('_tagsearch_comp',array(
																	'model'=>$ctagmodel,
																)); 
																
																
																Yii::app()->clientScript->registerScript('search', "
																$('.search-button').click(function(){
																	$('.search-form').toggle();
																	return false;
																});
																$('.search-form form').submit(function(){
																	$.fn.yiiGridView.update('tags-grid', {
																		data: $(this).serialize()
																	});
																	return false;
																});
																");
																
																?>
															</div><!-- search-form -->
															<?php 
																	$this->widget('zii.widgets.grid.CGridView', array(
																		'id'=>'tags-grid2',
																		'dataProvider'=>$ctagmodel->search(),
																		'filter'=>$ctagmodel,
																		'itemsCssClass' =>'displaytab',
																		'columns'=>array(
																			/*'lay_id',*/
																			/*'a_href',*/
																			'tagID',
																			/*'gadPlacement',*/
																			'status',
																			'tagName',
																			'LocalstartTime',
																			'LocalendTime',
																			array(
																				'class'=>'CButtonColumn',
																				'template'=>'{update}{delete}',
																				'buttons'=>array
																		        (
																		            'update' => array
																		            (
																		            	'url' =>'"#"',
																		                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/update/$data->tagID"',
																		                'visible'=>'1',
																		                'options'=>array('class'=>'CompletedUpdate','alt'=>"{$data->tagID}"),
																		            ),
																		            'delete' => array
																		            (
																		            	'url' =>'"#$data->tagID"',
																		                //'url'=>'"' . Yii::app()->baseUrl . '/rtaTagIndexCompleted/delete/$data->tagID"',
																		                'visible'=>'1',
																		                'options'=>array('class'=>'CompletedDelete','alt'=>"{$data->tagID}"),
																		                //'options'=>array('onclick'=>$data->id),
																		            ),
   																		        ),
																			),//array
																		),//columns
																		'emptyText' => 'No Results Found!',
																	)); 
															?>                            
													 </div> <!-- grid_6 -->
												</section><!-- ctagblock-->
											 </div><!-- sidebar-tabs -->
                                         </div>
    								</section>
<!-- tab "panes" -->
									<!--  pane-3 -->
									<?php if($autoTaggingFlag){ ?>
<section id="pane-3">
    <div class="sliders clearfix">
         <div>

		<form action="realTimeDisplay.php" method="post" id="userAutoTagViewForm">
			<input type="hidden" name="pageType" value="tagManage"/>			
		</form>

    <div class="sidebar-tabs">
        <ul>
            <li><a href="#userForm1">By Minute(s)</a></li>
            <li><a href="#userForm2">By Ton(s)</a></li>
        </ul>
        <form action="realTimeDisplay.php" method="post" id="userAutoTagForm">	   	
            <section style="display:block" id="userForm1" >
			<table style="width: 600px;">
			<tbody>
				<tr class="minClass<?php echo $hidState; ?>">
					<td align="left" colspan="1" style="padding-left:10px; padding-top:7px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> T-ag every</td>
					<td colspan="5">
						<input type="hidden" name="inputTextOptionAHid" id="inputTextOptionAHid" value="<?php echo $minutesTagArray['at_units']; ?>" />
						<input <?php echo $inputState; ?> name="inputTextOptionA" id="inputTextOptionA" style="font-size:13px; margin: 0px" type="text" value="<?php echo $minutesTagArray['at_units']; ?>" /> Minutes. <font color="#ff0000">( > 10 Minutes )</font></td>
				</tr>
				<tr class="minClass<?php echo $hidState; ?>">
					<td align="left" colspan="1" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> Tag Name</td>
					<td colspan="5">
						<input type="hidden" name="input_A_nameHid" id="input_A_nameHid" value="<?php echo $minutesTagArray['at_tagname']; ?>" />
						<input <?php echo $inputState; ?> name="input_A_name" id="input_A_name" style="font-size:13px" type="text" value="<?php echo $minutesTagArray['at_tagname']; ?>" /></td>
				</tr>
				<tr class="minClass<?php echo $hidState; ?>">
					<td align="left" colspan="1" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> Tag Group</td>
					<td colspan="5" style="padding-top: 10px">
						<input type="hidden" name="tagGroups_optionAHid" id="tagGroups_optionAHid" value="<?php echo $minutesTagArray['at_taggroup']; ?>" />
						<select <?php echo $inputState; ?> name="tagGroups_optionA" id="tagGroups_optionA" style="font-size:13px; margin:0px"> 
                		<option value="nodata">--Select--</option>
                		<?php
                			
                			{
	                			foreach($tagGroupsList as $vals)
								{
								    echo '<option value="'.$vals["tagGroupID"].'">'.$vals["tagGroupName"].'</option>';
								}     
	                		}   
                		?>
						</select></td>
				</tr>
				<tr class="delClass<?php echo $hidState; ?>"><td></td>
					 <td align="left" colspan="6" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:auto;text-align:center;">
					  	<button style="float:left;background:#FF3300;color:white;" class="button" id="delMins" name="delMins">STOP</button>
					</td>
				</tr>
			</tbody>
			</table>
            </section>

            <section id="userForm2" >
			<table style="width: 600px;">
			<tbody>
				<tr class="tonClass<?php echo $hidState; ?>">
					<td align="left" style="padding-left:10px; padding-top:7px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> Tag every</td>
					<td colspan="5">
						<input type="hidden" name="inputTextOptionBHid" id="inputTextOptionBHid" value="<?php echo $tonsTagArray['at_units']; ?>" />					
						<input <?php echo $inputState; ?> name="inputTextOptionB" id="inputTextOptionB" style="font-size:13px" type="text" value="<?php echo $tonsTagArray['at_units']; ?>" /> Tons. <font color="#ff0000">( > 500 Tons )</font>
					</td>
				</tr>
				<tr class="tonClass<?php echo $hidState; ?>">
					<td align="left" colspan="1" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> Tag Name</td>
					<td colspan="5">
						<input type="hidden" name="input_B_nameHid" id="input_B_nameHid" value="<?php echo $tonsTagArray['at_tagname']; ?>" />					
						<input <?php echo $inputState; ?> name="input_B_name" id="input_B_name" style="font-size:13px" type="text" value="<?php echo $tonsTagArray['at_tagname']; ?>" />
					</td>
				</tr>
				<tr class="tonClass<?php echo $hidState; ?>">
					<td align="left" colspan="1" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:120px">
						<font color="#ff0000">*</font> Tag Group</td>
					<td colspan="5" style="padding-top: 10px">
						<input type="hidden" name="tagGroups_optionBHid" id="tagGroups_optionBHid" value="<?php echo $tonsTagArray['at_taggroup']; ?>" />					
						<select <?php echo $inputState; ?> name="tagGroups_optionB" id="tagGroups_optionB" style="font-size:13px; margin:0px"> 
                		<option value="nodata">--Select--</option>
                		<?php
                			
                			{
	                			foreach($tagGroupsList as $vals)
								{
								    echo '<option value="'.$vals["tagGroupID"].'">'.$vals["tagGroupName"].'</option>';
								}     
	                		}   
                		?>
						</select>
					</td>
				</tr>
				<tr class="delClass<?php echo $hidState; ?>"><td></td>
					<td align="left" colspan="6" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:auto;text-align:center;">
					    <button style="float:left;background:#FF3300;color:white;" class="button" id="delTons" name="delTons">STOP</button>
					</td>
				</tr>		
				<!--			
				<tr>
					<td></td>
					<td align="left" colspan="6" style="padding-left:10px; padding-top:13px; padding-bottom:10px; width:auto;text-align:center;">
					    <button style="float:left;background:#FF3300;color:white;" class="button" id="autoTagSubmit" name="autoTagSubmit">SAVE</button>
<?php 
					if($submitTagValue == "Save")
					{
?>					
					    <button style="float:left;background:#FF3300;color:white;" class="button" id="autoTagCancel" name="autoTagCancel">Cancel</button>
<?php
					}
?>
					</td>
				</tr>
				-->
			</tbody>
		</table>	
            </section>
        
		<input type="hidden" name="pageType" value="tagManage"/>
		<input type="hidden" name="minsChanged" id="minsChanged" value="changed"/>
		<input type="hidden" name="tonsChanged" id="tonsChanged" value="changed"/>
		
		<input type="hidden" name="screenFormAction" id="screenFormAction" value="<?php echo $formAction; ?>"/>	
		</form> 
        </div>
			
		</div>
	</div>
    </section>
								    <!--  pane-3 -->
								    <?php }//autoTagging ?>
</div>
<script type="text/javascript">
	$(".tabs").tabs();
	$( ".sidebar-tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	$( ".sidebar-tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );	
</script>
<div id="tagGroupBlock">
    <section class="ui-widget-content ui-corner-bottom">
        <form class="form has-validation" novalidate="novalidate">            
        <div class="clearfix">
            <label for="form-name" class="form-label">Tag Group<em>*</em><small>Enter Tag-Group name</small></label>
            <div class="form-input"><input type="text" id="tagGroupName" name="tagGroupName" required="required" /></div>
        </div>

        <div class="clearfix">
            <label for="form-email" class="form-label">Data Source<em>*</em><small>Choose where data comes from</small></label>
            <div class="form-input">
            	<select name="dataSourceTg" id="dataSourceTg" required="required" >
            		<option value="nodata"> -- Select --</option>
                		<?php
	            			foreach($analysisList as $vals)
							{
							    echo '<option value="'.$vals["rtaMasterID"].'">'.
							    	$vals["data_src"].
							    	'</option>';
							}     
                		?>
            	</select>
            </div>
        </div>
        <?php
        	$dateTime = date("y-m-d h:i:s");
        ?>
        <div class="clearfix">
            <label for="form-name" class="form-label">Current Time<em>*</em></label>
            <div class="form-input">
            <input type="text" id="cDateTime" value="<?php echo $dateTime; ?>" name="cDateTime" required="required" /></div>
        </div>
<!--
        <div class="clearfix">
            <label for="form-email" class="form-label"></label>
            <div class="form-input">
				<button data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
					<span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span>
					<span class="ui-button-text">SUBMIT</span>
				</button>            
            </div>
        </div>
-->
        
	</form>
	</section>
</div>

<div id="tagBlock">
        <section class="ui-widget-content ui-corner-bottom">
            <form class="form has-validation" novalidate="novalidate">            
            <div class="clearfix">
                <label for="form-name" class="form-label">Tag<em>*</em><small>Enter Tag Name</small></label>
                <div class="form-input"><input type="text" id="tagName" name="tagName" required="required" /></div>
            </div>

            <div class="clearfix">
                <label for="form-email" class="form-label">Tag Group<em>*</em><small>Choose Tag Group</small></label>
                <div class="form-input">
                	<select name="seldataSourceTglist" id="seldataSourceTglist" required="required" >
                		<option value="nodata">--Select--</option>
                		<?php
                			
                			{
	                			foreach($tagGroupsList as $vals)
								{
								    echo '<option value="'.$vals["tagGroupID"].'">'.$vals["tagGroupName"].'</option>';
								}     
	                		}   
                		?>
                	</select>
                </div>
            </div>

            <div class="clearfix">
                <label for="form-email" class="form-label">Start Time<em>*</em><small>Choose a Date Time</small></label>
                <div class="form-input"><input name="sTimer" id="sTimer" required="required" />
                <span><input type="text" name="timeRangeStart_timer" style="width:150px;"  id="timeRangeStart_timer" class="timepick" size="5" maxlength="5" /></span><br/></div>
            </div>

            <div class="clearfix">
                <label for="form-email" class="form-label">End Time<em>*</em><small>Choose a Date Time</small></label>
                <div class="form-input"><input name="eTimer" id="eTimer" required="required" />
                <span><input type="text" name="timeRangeEnd_timer" style="width:150px;" id="timeRangeEnd_timer" class="timepick" size="5" maxlength="5" /></span><br/></div>
            </div>
<!--
	        <div class="clearfix">
	            <label for="form-email" class="form-label"></label>
	            <div class="form-input">
					<button data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
						<span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span>
						<span class="ui-button-text">SUBMIT</span>
					</button>            
	            </div>
	        </div>
-->
		</form>
		</section>
</div>

<script type="text/javascript">
	
   //Select Gadget (close button)
   $("#tagBlock").dialog(
    {
     autoOpen: false,
     title:"Tag(s)",  
     height: 450,
     width: 600,
     modal: true,
     scrolling:false,
     buttons: {
       "Submit":function(){
		   var tagNa = $("#tagName").val();
		   var sDsrc = $("#seldataSourceTglist").val();
		   var tstartD = $("#sTimer").val();
		   var tstartT = $("#timeRangeStart_timer").val();
		   var tendD   = $("#eTimer").val();
		   var tendT    = $("#timeRangeEnd_timer").val();
		   
		   if(tstartD)
		   {
		   	var tstimear = tstartD.split("\/");
		   	tstartD		 = tstimear[2]+"-"+tstimear[1]+"-"+tstimear[0];
		    tstartD 	 = tstartD.replace(/\//g,"-");
		   }
		   
		   if(tendD)
		   {
		   	var tetimear = tendD.split("\/");
		   	tendD		 = tetimear[2]+"-"+tetimear[1]+"-"+tetimear[0];
		    tendD   	 = tendD.replace(/\//g,"-");
		   }
		   
		   if(tstartT)
		   	tstartD += " " + tstartT + ":00";
		   
		   if(tendT)
		   	tendD   += " " + tendT + ":00";

       	   if(checkStr($("#tagName").val()))
       	   {
       	   		alert("Tag Name cann't be empty");
       	   		return;
       	   }
       	   
       	   if($("#seldataSourceTglist").val()=="nodata")
       	   {
       	   		alert("Please select a Source Tag");
       	   		return;
       	   }
       	   
       	   if(checkStr($("#sTimer").val()))
       	   {
       	   		alert("Please select start time");
       	   		return;
       	   }
       	   
       	   if(checkStr($("#eTimer").val()))
       	   {
       	   		alert("Please select end time");
       	   		return;
       	   }
			//alert(tstartD+":"+tendD);
			
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl; ?>/TagGroup/ajaxUp",
			data: {"hidTagOnly":1, "tagName" : tagNa,"sDsrc" : sDsrc ,"tstartD":tstartD,"tendD":tendD,},
			success: function(str){
				if(str == "SUCCESS")
				{
					$("#successMessageT1").html("Tag successfully inserted!");
					$("#successMessageT1").show();
					$("#successMessageT1").toggle( "blind", 4000 );
				}
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
       	   
           $(this).dialog('close');
       },
       "Cancel":function(){
           $(this).dialog('close');
       }
     }
    }
   );
       
  $("#addNewTag").click(function(){
    $("#tagBlock").dialog("open");
  });

   //Select Gadget (close button)
   $("#tagGroupBlock").dialog(
    {
     title:"Tag Group(s)",  
     autoOpen: false,  
     height: 350,
     width: 700,
     modal: true,
     scrolling:false,
     buttons: {
       "Submit":function(){
       	   var tgName = $("#tagGroupName").val();
       	   var dsTag  = $("#dataSourceTg").val();
       	   var cTime  = $("#cDateTime").val();
       	   
       	   if(checkStr($("#tagGroupName").val()))
       	   {
       	   		alert("Tag Group cann't be empty");
       	   		return;
       	   }
       	   
       	   if($("#dataSourceTg").val()=="nodata")
       	   {
       	   		alert("Please select a Source Tag");
       	   		return;
       	   }
       	   
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl; ?>/TagGroup/ajaxUp",
			data: {"hidTagGroup":1, "tagGrName" : tgName,"DSTag" : dsTag,"cTime":cTime,},
			success: function(str){
				if(str == "SUCCESS")
				{
					$("#successMessageTG").html("Tag-Group successfully inserted!");
					$("#successMessageTG").show();
					$("#successMessageTG").toggle( "blind", 3000 );
				}
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
				       	   
       	   
           $(this).dialog('close');
       },
       "Cancel":function(){
           $(this).dialog('close');
       }
     }
    }
   );
       
  $("#addNewTagGroup").click(function(){
    $("#tagGroupBlock").dialog("open");
  });
  
  $('#sTimer').datepicker();
  $('#eTimer').datepicker();

  $('.timepick').timeslider({ showValue: true, clickable: true});

	function checkStr(str) {
		return isEmpty(str) || isBlank(str);
	}
	
	function isEmpty(str) {
	    return (!str || 0 === str.length);
	}

	function isBlank(str) {
	    return (!str || /^\s*$/.test(str));
	}
	$(".CompletedUpdate").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	   return;
       	   //alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexCompleted/update/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/rtaTagIndexCompleted/update/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				alert(str);
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});

	
	$(".CompletedDelete").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	  // alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexCompleted/delete/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/rtaTagIndexCompleted/delete/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				if(str == "SUCCESS")
				{
					$("#successMessageT2").html("Tag-Group successfully delted!");
					$("#successMessageT2").show();
					$("#successMessageT2").toggle( "blind", 3000 );
				}
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});
	
	$(".QueuedDelete").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	   //alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/delete/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/delete/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				if(str == "SUCCESS")
				{
					$("#successMessageT1").html("Tag successfully delted!");
					$("#successMessageT1").show();
					$("#successMessageT1").toggle( "blind", 3000 );
				}
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});

	
	$(".QueuedUpdate").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	   return;
       	   //alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/update/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/update/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				alert(str);
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});

	
	$(".TagGroupDelete").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	   //alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/update/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/TagGroup/delete/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				if(str == "SUCCESS")
				{
					$("#successMessageTG").html("Tag-Group successfully delted!");
					$("#successMessageTG").show();
					$("#successMessageTG").toggle( "blind", 3000 );
					
					//alert($(this).parent().closest("tr").html);
				}
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});

	
	$(".TagGroupUpdate").click(function(){
       	   var idd = $(this).attr("href");
       	   idd     = idd.replace("#","");
       	   return;
       	   //alert("<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/update/'; ?>" + idd);
			$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->baseUrl . '/rtaTagIndexQueued/update/'; ?>" + idd,
			data: {"ajax":1},
			success: function(str){
				alert(str);
			},
			failure:function(err){
				alert("There is something wrong");
			}
			});
	
	});
	
	
</script>