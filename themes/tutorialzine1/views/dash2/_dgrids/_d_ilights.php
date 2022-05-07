
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
                        
                        
               <fieldset class="fieldset-buttons ui-corner-all" style="height: 168px;"> 
                <ul id="ul_iLights_parent" class="isotope-widgets isotope-container iLights">  
                    
                    <!--
                    <li class="dash-order">
                        <a class="button-orange ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','H_Peak'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-red ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Detector_Temp'); ?></span>
                        </a>
                    </li>                    
                    <li class="dash-order">
                        <a class="button-green ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Good_Data_Seconds'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-green ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Alignment_Gain'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-red ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','PMT_Avg_Volts'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-orange ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Alignment_Offset'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-orange ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Mass_Flow'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-red ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Belt_Speed'); ?></span>
                        </a>
                    </li>
                    <li class="dash-order">
                        <a class="button-orange ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Deamon_Running'); ?></span>
                        </a>
                    </li> 
                    <li class="dash-order">
                        <a class="button-green ui-corner-all" href="#">
                            <span><?php //echo Yii::t('app','Source_Health'); ?></span>
                        </a>
                    </li>
                    -->                    
                  
                   </ul>
                 </fieldset>  
                  
                  <script type="text/javascript">
                 
                  
                  /* Abhinandan. Feb11th Left off Here */
      
       //March11th: Commenting out.. for debugging @ DashHelper for now..
      /*            
      var IL_callback = {
                     IL_execute : function(){         
                                         var fetchDashboardElements = 'fetchDashboardElements';
                                         var gadgetType             = 'IdiotLights';
                                         var widgetsPos             = 1;
                                        
                                         $.ajax({
                                                type: 'POST',
                                                url: '<?php echo Yii::app()->baseUrl; ?>/dash/Dash',     //UIDashboardController::Dash().. 
                                                data: {'ajaxForwardRequest' : fetchDashboardElements, 'gadgetType' : gadgetType, 'widgetsPos' : widgetsPos},
                                                success: function(stringified){
                                                  alert(stringified);
                                                 
                                                 
                                                 var data_obj     = $.parseJSON(stringified);
                                                 //console.log(data_obj);
                     
                                                 var legacy_record_count = 0;
                                                 var b = setInterval(function(){
                                                  
                                                  //alert('inside setInterval @b');
                                                  //if(legacy_record_count == 4)
                                                  if(legacy_record_count == data_obj[0].data_value.length) //Abhinandan. Asserting that ALL the elements contain the same exact number within its own legacy records array..
                                                  {
                                                   clearInterval(b);
                                                  }
                                                  else{
                                                   //Abhinandan.  Refresh timestamps in db, if not appearing..
                                                   //alert('legacy_record_count is ' + legacy_record_count);  
                                                   var data_count   = data_obj.length;                                         
                                                   var ul = document.getElementById('ul_iLights_parent');    //Abhinandan. Must clear 1x outside for loop..
                                                       ul.innerHTML = "";
                                                                   
                                                   for(var hb_i=0; hb_i < data_count; ++hb_i){
                                                    var element_type   = data_obj[hb_i].element_type;   
                                                    var currentColor   = data_obj[hb_i].data_value[legacy_record_count][element_type][1];
                                                    var data_value     = data_obj[hb_i].data_value[legacy_record_count][element_type][0]; 
                                                    var a_id           = data_obj[hb_i].dom_unique_attribute;  
                            
                                                    //Dynamically create @ .js
                                                    currentElement = document.createElement('li');
                                                    currentElement.className = "dash-order";
                                                    currentElement.innerHTML = "<a id='" + a_id + "'  class='button-" + currentColor + " ui-corner-all' href='#'><span style='position:relative' >" + element_type + "</span></a>";    //data_value + element_type   style="display:block; background-color:red; width:100px;
                                
                                                    ul.appendChild(currentElement);  
                                                   }//end for loop..
                                                   
                                                   ++legacy_record_count;
                                                   
                                                  } //end else loop                                                                                          
                     
                                                 }, 3000);  //end setInterval @b..
                     
                                                
                     
                                                } //end success..
                                              });  //end ajax..
                                              
                                              
                     }  //IL_execute
      }; //IL_callback
      
      */                  
                        
                        
                        // IL_callback.IL_execute();
                       
                        /* //Abhinandan. Mar2nd commenting out for debugging the client-side..
                        var a_iLights = setInterval(function(){ 
                         IL_callback.IL_execute(); 
                        }, 20000); 
                        */
                       
                  </script>
                  
                  