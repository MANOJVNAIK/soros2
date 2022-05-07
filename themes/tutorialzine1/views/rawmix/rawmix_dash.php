   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
  
        <style type="text/css">
         a.longSize {width:810px !important; margin-left:5px;}
        </style>
        
        <script type="text/javascript">

         var dashObj = {
                       grabDashboardLayout : function(lay_id){
                        $.ajax({
                         type: 'POST',
                         url: '<?php echo Yii::app()->baseUrl; ?>/dash/GrabdashboardLayout',
                         data: { 'lay_id' : lay_id },
                         success: function(msg){
                          document.location.reload(true);
                         }
                        }); //end ajax..
                       } //grabDashboardLayout..
         };
         
         
        </script>
        
        <section class="main-section grid_8">
            <nav class="">
             <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        		 <?php
                         $layoutY = $this->layout;
                         $them = Yii::app()->theme->name;
                         
                          $this->renderPartial('rawLefthnadmMenu');
                          ?>
            </nav>
            <div class="main-content">
            
           
           		  <div class="clear"><br/></div>
                    <?php                      //Abhinandan. Here we will parse each active record and return a list of layout names.. (to be placed in the top menu of the dash)..
                     if( isset($layouts) )
                     {
                      $layout_names = array();
                      foreach ($layouts as $record) {
                       $layout_names[] = $record->getAttributes( array('subname', 'lay_id') );
                      }
                      for($i=0; $i<count($layout_names); ++$i){
                      ?>
                      <script type="text/javascript">
                       var li_layout    = document.createElement("li");  
                           li_layout.setAttribute("name", '<?php echo $layout_names[$i]["lay_id"]; ?>');
                           li_layout.setAttribute("onclick", "dashObj.grabDashboardLayout( this.getAttribute('name') ); ");
                        var li_layout_a = document.createElement("a");
                           li_layout_a.setAttribute("href", "#");
                           //li_layout_a.setAttribute("href", "<?php echo Yii::app()->baseUrl; ?>/dash");
                           li_layout_a.innerHTML = '<?php echo $layout_names[$i]["subname"]; ?>';
                           li_layout.appendChild(li_layout_a);
                          
                          document.getElementById('menuItemLayouts_ul').appendChild(li_layout);
                      </script> 
                      <?php
                      }
                     }
                      
                     if( count($portlets) > 0 )
                     {
                     	$dl = $def_layout[0]->getAttributes( array('subname', 'lay_id') );
                     	
                     	
                     	$pagetType  = $_REQUEST['pageType'];
                     	$sTime 		= $_REQUEST['sTime'];
                     	$eTime 		= $_REQUEST['eTime'];
                     	
                     	$tGrpInfo 		= $_REQUEST['tGrp'];
                     	$tagInfo 		= $_REQUEST['tag'];
                     	
                     	if(isset($_REQUEST['tag']))
                     	{
						    $tableNameQuery = "SELECT tagName,LocalstartTime as sTime,LocalendTime as eTime from rta_tag_index_queued tag WHERE tagID=$tagInfo";
						    $tcommand 	    = Yii::app()->db->createCommand($tableNameQuery)->queryRow();
						   
				   		    $analysisTableName = "analysis_" . $tcommand['DB_ID_string'];
				   		    $tagName		  = $tcommand['tagName'];
				   		    $sTime		  = $tcommand['sTime'];
				   		    $eTime		  = $tcommand['eTime'];
 						}                    	
                     	
                     	if(empty($pagetType))
                     	{
                  		$notifyMsg = Yii::t('app', "Showing")." <span style='font-weight:bold;'>".Yii::t('app', "Real-Time")."</span> ".Yii::t('app', "Analyzer Information");
                                
                     	}
                     	else if($pagetType == "timeRange")
                     	{
                                $notifyMsg = Yii::t('app', "Showing Analysis Data between")."<span style='font-weight:bold;'>$sTime</span> ".Yii::t('app', "And"). "<span style='font-weight:bold;'>$eTime</span>";
                     	}
                     	else if($pagetType == "tagIndex")
                     	{
                                $notifyMsg = Yii::t('app', "Showing Analysis Data for Tag").":<span style='font-weight:bold;'>$tagName</span> ".Yii::t('app', "with Start-Time").": <span style='font-weight:bold;'>$sTime</span> ".Yii::t('app', "And End-Time").":<span style='font-weight:bold;'>$eTime</span>";
                     	}
                     	
                     	
                     ?>
                    <div class="ui-state-highlight" style="text-align:center;"><?php echo $notifyMsg ; ?> <br/></div>
                    <div class="clearfix"><br/></div>
                     
                        <!-- Tabs inside Portlet -->
                        <div class="grid_6 grid_6Head portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all">
                            <div class="portlet ui-sortable clearfix collapsible ">
                                <header>
				                        <?php 
				                        	echo "<h2>". $dl[subname] ;
				                        	echo '<label id="realTimeLink" style="float:right;margin-right:50px;margin-bottom:5px;" for="button-toggle2-3" aria-pressed="false" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right" role="button" aria-disabled="false"><span class="ui-button-text">Real-Time</span></label>';
				                        	echo "</h2>"; 
				                        ?>
								<a role="button" class="portlet-collapse ui-corner-all collapsed" href="#"><span class="ui-icon ui-icon-circle-plus">Expand/Collapse</span></a>				                        
                                </header>
                                <section id="tabsSectionMain" style="display:none;">
                                    <div class="tabs">
                                        <ul>
                                            <li><a href="#tportlet-pane-2">Time-Range</a></li>
                                            <li><a href="#tportlet-pane-3">Tons-Range</a></li>
                                            <li><a href="#tportlet-pane-4">Tags</a></li>
                                        </ul>
                                        <!-- Time Range -->
                                        <section id="tportlet-pane-2" >
											<div class="clearfix flLeft">
                                                <label class="form-label" for="form-name">Start Time <em>*</em></label>
                                                <div class="form-input"><input type="text" required="required" name="timeRangeStart" id="timeRangeStart">
                                                <span><input type="text" name="timeRangeStart_time" id="timeRangeStart_time" class="timepick" size="5" maxlength="5" /></span></div>
                                            </div>                                            
											<div class="clearfix flLeft">
                                                <label class="form-label" for="form-name">End Time <em>*</em></label>
                                                <div class="form-input"><input type="text" required="required" name="timeRangeEnd" id="timeRangeEnd">
                                                <span><input type="text" name="timeRangeEnd_time" id="timeRangeEnd_time" class="timepick" size="5" maxlength="5" /></span></div>                                                
                                            </div>                                            
											<div class="form-action clearfix flLeft">
                                                <button style="margin-top:10px;" id="timeRangeSubmit" data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">SUBMIT</span></button>
                                            </div>
                                        </section>
                                        <!-- Time Range -->
                                        <!-- Tons Range -->                                                                                
                                        <section id="tportlet-pane-3">
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
                                                <button style="margin-top:10px;" id="tonsRangeSubmit" data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">SUBMIT</span></button>
                                            </div>
                                        </section>
                                        <!-- Tons Range -->
                                        <!-- Tagging -->                                                                                
                                        <section id="tportlet-pane-4">
											<div class="clearfix flLeftSm">
                                                <label class="form-label" for="form-name">Tag Group <em>*</em></label>
                                                <div class="form-input">
                                                	<select id="tagGroupSelector">
							                		<option value="nodata">--Select--</option>
							                		<?php
							                			
							                			{
								                			foreach($tagGrpDataLst as $vals)
															{
															    echo '<option value="'.$vals["tagGroupID"].'">'.$vals["tagGroupName"].'</option>';
															}     
								                		}   
							                		?>
                                                	</select>
												</div>                                                                                                
                                            </div>                                            
											<div class="clearfix flLeftSm">
                                                <label class="form-label" for="form-name">Tag <em>*</em></label>
                                                <div class="form-input">
                                                	<select id="tagSelector">
							                		<option value="nodata" label="hidden" >--Select--</option>
							                		<?php
							                			
							                			{
								                			foreach($tagDataLst as $vals)
															{
															    echo '<option value="'.$vals["tagID"].'"  label="'.$vals["tagGroupID"].'" lang="'.$vals["status"].'">'.$vals["tagName"].'</option>';
															}     
								                		}   
							                		?>
                                                	</select>
												</div>                                                                                                
                                            </div>         
                                          						<div class="form-action clearfix flLeftSm">
                                                <button style="margin-top:10px;" id="tagsDataSubmit" data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">SUBMIT</span></button>
                                            </div>
                                        </section>
                                        <!-- Tagging -->
                                    </div>
                                </section>
                            </div>
                        </div>
                        <!-- End Tabs inside Portlet -->
                     
                     <?php
                     } //if portltes > 0
                    if ( count($portlets) < 1 )
	               {
	                Yii::app()->user->setFlash('testA','Please go back to settings and add some gadgets.');
	              ?>
	                <ul id="top_ul" class="isotope-widgets isotope-container iStatus"> 
	                 <li id="first_element" class="dash-order">
	                  <a id="first_element_a" class="button-grey ui-corner-all animJq longSize" href="#" style="color:red; font-size:14px">
	                   <?php echo Yii::app()->user->getFlash('testA'); ?>
	                   <span><?php //echo Yii::t('app','Aluminum_Percentage'); ?></span>
	                  </a>
	                 </li>
	                </ul>
	              <?php
	               }
	              ?> 

<!--	              
	        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui-timepicker-addon.js"></script>
-->
            <script type="text/javascript">
		                 $('#timeRangeStart').datepicker();
		                 $('#timeRangeEnd').datepicker();
		                 
		                 $('#tonsRangeStart').datepicker();
		                 $('#tonsRangeEnd').datepicker();
		                 
		                 $('#timeTagStart').datepicker();
		                 $('#timeTagEnd').datepicker();
		                 
		                 $("#tagGroupSelector").change(function(){
	 					    var cnt   = 0;
			                var selGrp = $(this).val();
			                $('#tagSelector').val(0).change();
			                if(selGrp == "nodata")
			                	return;
			                
							$('#tagSelector > option').each(function() {
							    var lblID = $(this).attr("label");
							    if(lblID != selGrp)
							    {
							    	$(this).hide();
							    }
							    else if(lblID == selGrp)
							    {
							    	$(this).show();
							    	cnt++;
							    }							    
							});		
							    
						    if(cnt == 0)
						    {
						    	alert("No Tags defined for this Tag-Group");
						    }
							                 
						});
		                 
		                 $("#tagSelector").change(function(){
			                var selGrp = $('#tagSelector > option:selected').attr("label");

			                if(selGrp == "nodata")
			                	return;
			                
							$('#tagGroupSelector > option').each(function() {
							    var lblID = $(this).val();
								var cnt   = 0;
							    if(lblID == selGrp)
							    {
							    	$(this).attr("selected","selected");							    	
									//$('#tagGroupSelector').val(cnt).change();                 
							    }
							    cnt++;							    
							});		
						});
						
            </script>   
            <script type="text/javascript">
	                 $(".animJq").animate(
	                     {
	                      opacity : 1
	                     },
	                     2000,
	                     "linear",
	                     function(){
	                               $('#first_element_a').effect("highlight", {}, 1000);    //Abhinandan. Better appearance is when used with the <a> element..
	                     }
	                 );

					   var currentTime = new Date();
					   var chours = currentTime.getHours();
					   var cminutes = currentTime.getMinutes();
					   var cTime	= chours + ":" + cminutes;

						$('.timepick').timeslider({ showValue: true, clickable: true});
		                 
		                 $('#timeRangeStart_time').val(cTime);
		                 $('#timeRangeEnd_time').val(cTime);
		                 $('#tonsRangeStart_time').val(cTime);
		                 $('#tonsRangeEnd_time').val(cTime);
		                 $('#timeTagStart_time').val(cTime);
		                 $('#timeTagEnd_time').val(cTime);		                 
						
		                 
		                 $("#realTimeLink").click(function() {
		                 	window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash");
		                 });
		                 
		                 $("#timeRangeSubmit").click(function() {
		                 	var curSTime = $('#timeRangeStart').val() + " " + $('#timeRangeStart_time').val();
		                 	var curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
		                 	window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash?pageType=timeRange&sTime="+curSTime +"&eTime="+curETime );
		                 });
		                 
		                 $("#tonsRangeSubmit").click(function() {
		                 	var curSTime = $('#timeRangeStart').val() + " " + $('#timeRangeStart_time').val();
		                 	var curETime = $('#timeRangeEnd').val() + " " + $('#timeRangeEnd_time').val();
		                 	window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash?pageType=timeRange&sTime="+curSTime +"&eTime="+curETime );
		                 });
		                 
		                 $("#tagsDataSubmit").click(function() {
		                 
		                 	var tagGrp   = $('#tagGroupSelector').val();
		                 	var tagSel   = $('#tagSelector').val();
			                var tagStat  = $('#tagSelector > option:selected').attr("lang");
		                 	//var curSTime = $('#timeTagStart').val() + " " + $('#timeTagStart_time').val();
		                 	//var curETime = $('#timeTagEnd').val() + " " + $('#timeTagEnd_time').val();
		                 	window.location.replace("<?php echo Yii::app()->baseUrl; ?>/dash?pageType=tagIndex&tGrp="+tagGrp+"&tag="+tagSel +"&tagStatus="+tagStat ); //+"&sTime="+curSTime +"&eTime="+curETime
		                 });
		                 
	                </script>   
                <section class="container_6 clearfix">
					<?php if ( 0 ) { ?>
	                <!-- <div class="grid_6"> -->
	                    <div class="ui-widget message info">
	                        <div class="ui-state-highlight ui-corner-all"> 
	                            <p>
						        <span id="smsgSave" >
						            <?php echo Yii::t('Dashboard', 'You can customize this view using Themes. Move the widgets around to create your favorite view and save it.')?>
						        </span>
						    	</p>
	                        </div>
	                    </div>
	               <!-- </div> -->
                    <div class="clear"></div>
					<?php 
					} 
                                        
						//echo "<div class='grid_6'>";
						
						if( count($portlets) > 0 )
				        {
				        	DashHelper::createDisplay($columns,$portlets,$widString);
				        }                                                
						//DashHelper::createDisplay($columns,$portlets,$widString);   //Abhinandan. Jan13th..   The gadgets show up here @ '..protected/components/ ' 
						//echo "</div>";
					?>
					
				</div>
			</section>
		</div>
	</section>