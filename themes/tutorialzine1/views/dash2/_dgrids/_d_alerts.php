
<script type="text/javascript">
                         //var header = document.getElementById('Live_Status');
                         /*
                         $('header').addClass( function(index, currentClass){
                          var addedClass;
                          if( currentClass === "" )
                          {
                           addedClass = "ui-widget-header ui-corner-top";
                          }
                          return addedClass;
                         });
                        */ 
                        
                        </script>


<p style="display: none;">H Peak Levels</p>

 
 <!-- <div id="alerts" style="padding-left:20px;height:200px;">  -->
 
  <!-- 
<span class="vertical large" style="height: 200px; margin-right: 15px;width:15px;float:left;">

	
	<span class="left-mark" style="bottom: 1px"><span class="mark-label align-bottom">0%</span></span>
	<span class="left-mark" style="bottom: 25%"><span class="mark-label">25%</span></span>
	<span class="left-mark" style="bottom: 50%"><span class="mark-label">50%</span></span>
	<span class="left-mark" style="bottom: 75%"><span class="mark-label">75%</span></span>
  
	<span class="right-mark" style="bottom: 1px"><span class="mark-label align-bottom">Empty</span></span>
	<span class="right-mark" style="bottom: 25%"><span class="mark-label">Start</span></span>
	<span class="right-mark" style="bottom: 50%"><span class="mark-label">Middle</span></span>
	<span class="right-mark" style="bottom: 75%"><span class="mark-label">Almost</span></span>
	
</span>

<span class="progress vertical large" style="height: 200px; margin-right: 15px;float:left;">

	
	<span class="inner-mark" style="bottom: 25%"></span>
	<span class="inner-mark" style="bottom: 50%"></span>
	<span class="inner-mark" style="bottom: 75%"></span>
  

	
	<span class="progress-text">35%</span>

	
	<span class="progress-bar red-gradient glossy" style="height: 35%">
		<span class="stripes animated"></span>
		<span class="progress-text">35%</span>
	</span>
</span>

 -->
 <!--  </div>  --> 
 
 
<p style="display: none;"><br/>Note: These widgets are customizable to meet your requirements. <br/>Click on settings page to alter the default behavior.</p>

   <script type="text/javascript">
  
    var A_callback = {
                    A_execute : function(){
                                    var fetchDashboardElements = 'fetchDashboardElements';
                                    var gadgetType             = 'Alerts';
                                    var widgetsPos             = 9;
                                    
                                    //var alert_a = setInterval(function(){     //Feb14th.. Placed outside of object.
                                    
                                     /* //Feb27th.. This will be the test for our error gadget.. */
                                     /*
                                     var gadgetType             = 'error_gadget';
                                    
                                       //Feb27th.. temporary commenting out..
                                     $.ajax({
                                      type: 'POST',
                                      url: '/Helios_Jan_4/dash/Dash',     //UIDashboardController::Dash().. 
                                      data: {'ajaxErrorRequest' : gadgetType},
                                      success: function(stringified){
                                       alert(stringified);
                                       //var data_obj = $.parseJSON(stringified);
                                       //console.log(data_obj);
                                       
                                      } //end success callback..
                                     }); //end test ajax for error gadget..
                                     */
                                    
                                    
                                    
                                     $.ajax({
                                      type: 'POST',
                                      url: '<?php echo Yii::app()->baseUrl; ?>/dash/Dash',     //UIDashboardController::Dash().. 
                                      data: {'ajaxForwardRequest' : fetchDashboardElements, 'gadgetType' : gadgetType, 'widgetsPos' : widgetsPos},
                                      success: function(stringified){
                                       alert(stringified);
                                       
                                       
                                       var data_obj = $.parseJSON(stringified);
                                       //console.log(data_obj); 
      
                                       var legacy_record_count_alerts = 0; 
                                       var alert_b = setInterval(function(){
                                        if(legacy_record_count_alerts == data_obj[0].data_value.length) //Abhinandan. Asserting that ALL the elements contain the same exact number within its own legacy records array..
                                        {
                                         clearInterval(alert_b);
                                        }
                                        else{
                                         var data_count   = data_obj.length;
                                         var parent_div = document.getElementById('alerts');
                                             parent_div.innerHTML = "";
                                         
                                         for(var hb_i=0; hb_i < data_count; ++hb_i){    
                                          var elementType  = data_obj[hb_i].element_type;
                                          var currentColor = data_obj[hb_i].data_value[legacy_record_count_alerts][elementType][1];      //Abhinandan. Asserting that there is only 1x record fetched from server..
                                          var dataValue    = data_obj[hb_i].data_value[legacy_record_count_alerts][elementType][0];
                                       
                                          var upperLimit   = data_obj[hb_i].element_setpoint[0][0];
                                          
                                          //var current_pbar_height = 'current' + i;
                                          
                                          var pbar_height  = 0;
                                       
                                          var division_output = (dataValue / upperLimit);
                                          var totalPercentage = ( division_output * 100).toFixed(0);
      
                                          if( totalPercentage >= 100 ){
                                           pbar_height = 100;
                                          }else{
                                           pbar_height = totalPercentage; 
                                          }
      
                                          //alert('totalPercentage is ' + totalPercentage);
      
                                          //var parent_div = document.getElementById('alerts');
                                          parent_div.innerHTML = "<span class='vertical large' style='height: 200px; margin-right: 15px;width:15px;float:left;'><span class='left-mark' style='bottom: 1px'><span class='mark-label align-bottom'>0%</span></span><span class='left-mark' style='bottom: 25%'><span class='mark-label'>25%</span></span><span class='left-mark' style='bottom: 50%'><span class='mark-label'>50%</span></span><span class='left-mark' style='bottom: 75%'><span class='mark-label'>75%</span></span><span class='right-mark' style='bottom: 1px'><span class='mark-label align-bottom'>Empty</span></span><span class='right-mark' style='bottom: 25%'><span class='mark-label'>Start</span></span><span class='right-mark' style='bottom: 50%'><span class='mark-label'>Middle</span></span><span class='right-mark' style='bottom: 75%'><span class='mark-label'>Almost</span></span></span><span class='progress vertical large' style='height: 200px; margin-right: 15px;float:left;'><span class='inner-mark' style='bottom: 25%'></span><span class='inner-mark' style='bottom: 50%'></span><span class='inner-mark' style='bottom: 75%'></span><span class='progress-text'>" + totalPercentage + "%</span><span class='progress-bar " + currentColor + "-gradient glossy' style='height: " + pbar_height + "%'><span class='stripes animated'></span><span class='progress-text'>" + totalPercentage + "% (" + dataValue + ")</span></span></span>";   
                                         
                                         } //end for loop..
                                         
                                         ++legacy_record_count_alerts;
                                                   
                                        }  //end else..
                                       }, 3000);
                                       
                                       
                                       
                                      } //end success..
                                     });
                                    
                                     
                                     
                                    // }, 20000);  //end setInterval @alert_a ..      //Feb14th..           
                    } //A_execute
    }; //A_callback
    
    
    
    
    A_callback.A_execute();
    
    /* //Abhinandan. Mar2nd commenting out for debugging the client-side..
    var alert_a = setInterval(function(){
     A_callback.A_execute(); 
    }, 20000);
    */
    
 </script>


