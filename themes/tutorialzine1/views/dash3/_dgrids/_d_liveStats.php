                        
                     
                        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/themes/tutorialzine1/js/json2.js" ></script>
                        
                        
                        
                        <script type="text/javascript">
                         
                         $('header').addClass( function(index, currentClass){
                          var addedClass;
                          if( currentClass === "" )
                          {
                           addedClass = "ui-widget-header ui-corner-top";
                          }
                          return addedClass;
                         });
                         
                        
                        </script>
                        
                        
                        <!-- <fieldset id="fieldset_main" class="fieldset-buttons ui-corner-all" style="height: 168px;">  -->
                            <!--
                            <legend class="buttonset-legend">
                                <span id="dashboardview-filter" class="buttonset">
                                    <input type="radio" name="dashboardview" id="dashboardview-orders" value=".dash-order"  /><label for="dashboardview-orders"><?php echo Yii::t('app','Critical'); ?></label>
                                    <input type="radio" name="dashboardview" id="dashboardview-statistics" value=".dash-stat" checked /><label for="dashboardview-statistics"><?php echo Yii::t('app','Real-Time'); ?></label>
                                </span>
                            </legend>
                            -->
                            
                            <!--
                             <ul id="top_ul" class="isotope-widgets isotope-container iStatus">
                                
                             </ul>
                            -->
                            
                       <!-- </fieldset> -->
                          
                             
                        <script type="text/javascript">
          
                          
                          //var section = document.getElementById('section_' + '<?php echo $this->test_A; ?>' );  //Mar7th NO work..
                          
                          
                          /*
                          var hid_unique_gadget = document.createElement('input');                        //Abhinandan. New. Set the hidden div to be unique, so that way the clientside .js knows what to look for...
                              hid_unique_gadget.type  = "hidden";
                              
                              hid_unique_gadget.id    = "unique_gadget_" + '<?php echo $this->test_A; ?>'; 
                              hid_unique_gadget.value = '<?php echo $this->test_A; ?>';
                              
                              //alert('hid_unique_gadget.value ' + hid_unique_gadget.value);  //Mar7th Works!!
                              //alert('<?php echo $this->test_A; ?>'); 
                          */
                              
                              
                             
                              
                            //section.appendChild(hid_unique_gadget);
                            
                            //alert('hid_unique_gadget.value is ' + hid_unique_gadget.value);
                          
                          //var fieldset = document.getElementById('fieldset_main_' + hid_unique_gadget.value); ////
                          
                          /*
                          var legend   = document.createElement('legend');
                              legend.className = "buttonset-legend";
                              legend.innerHTML = "<span id='dashboardview-filter' class='buttonset'><input type='radio' name='dashboardview' id='dashboardview-orders' value='.dash-order'  /><label for='dashboardview-orders'>Critical</label><input type='radio' name='dashboardview' id='dashboardview-statistics' value='.dash-stat' checked /><label for='dashboardview-statistics'>Real-Time</label></span>";
        
                              fieldset.appendChild(legend);
                           */
                          
                              
                        </script>     
                        
                        <!-- Abhinandan Feb 4th 2013: -->
                        
                        
                        
                        <script type="text/javascript">
                          
                         alert('<?php echo Yii::app()->params["bullseye"]?>'); 
                          
                         //1st time page load, show elements PRIOR to invoking setInterval (see @bottom)...
                       
                       /*
                       *  Abhinandan.
                       *   Feb12th 2013:  Fetch Order:
                       *    1.) Every 20 seconds, request all records for each given element inside the gadget.
                       *    2.) Every 3 seconds, display the value & color for that element (before moving on).
                       *    
                       *    @Repeat: See step 1.                                                                                            
                       */                       
                  
                        var LS_callback = {
                                       LS_execute : function(){
                                                         var fetchDashboardElements = 'fetchDashboardElements';
                                                         var gadgetType             = 'Live_Status';
                                                         
                                                                  
                                                        //var a = setInterval(function(){  //Feb14th.. Placed outside of object.
                                                          
                                                          /* 
                                                          $.ajax({
                                                                type: 'POST',
                                                                url: '<?php echo Yii::app()->baseUrl; ?>/dash/Dash',     //UIDashboardController::Dash().. 
                                                                data: {'ajaxForwardRequest' : fetchDashboardElements, 'gadgetType' : gadgetType},
                                                                success: function(stringified){
                                                           */     
                                                                 /*
                                                                 var div_parent = document.createElement('div');
                                                                     div_parent.className = "grid_6 portlet ui-sortable clearfix padMargin collapsible";
                                                                     div_parent.id        = "Live_Status";
                                                                     div_parent.draggable = "true";
                                                                     
                                                                     div_parent.innerHTML = "<header><h2>Live Status</h2></header>";  //Left out the following:  '<div  draggable="true" >
                                                                  
                                                                var section_parent = document.createElement('section');
                                                                    section_parent.id = "section_0";
                                                                    
                                                                var fieldset_parent = document.createElement('fieldset');
                                                                    fieldset_parent.id = "fieldset_main_0";
                                                                    fieldset_parent.className = "fieldset-buttons ui-corner-all";
                                                                    fieldset_parent.style.height = "168px";
                                                                    
                                                                    fieldset_parent.innerHTML = "<ul id='top_ul_0' class='isotope-widgets isotope-container iStatus'></ul><ul id='top_ul' class='isotope-widgets isotope-container iStatus'></ul>";
                                                                    
                                                                    var legend   = document.createElement('legend');
                                                                        legend.className = "buttonset-legend";
                                                                        legend.innerHTML = "<span id='dashboardview-filter' class='buttonset'><input type='radio' name='dashboardview' id='dashboardview-orders' value='.dash-order'  /><label for='dashboardview-orders'>Critical</label><input type='radio' name='dashboardview' id='dashboardview-statistics' value='.dash-stat' checked /><label for='dashboardview-statistics'>Real-Time</label></span>";
        
                                                                        fieldset_parent.appendChild(legend);
                                                                    
                                                                    
                                                                section_parent.appendChild(fieldset_parent);
                                                                div_parent.appendChild(section_parent);
                                                                
                                                                var grid_6 = document.getElementById('grid_6_top');
                                                                grid_6.appendChild(div_parent);
                                                                */
                                                                
                                                                
                                                              /*
                                                                var data_obj     = $.parseJSON(stringified);
                                                                        
                                                                //console.log(data_obj);
                                                                
                                                                //alert(data_obj[0].data_value.length);
                                                               
                                                                
                                                                var legacy_record_count = 0;
                                                                 var b = setInterval(function(){
                                                                  //if(legacy_record_count == 4)
                                                                  if(legacy_record_count == data_obj[0].data_value.length) //Abhinandan. Asserting that ALL the elements contain the same exact number within its own legacy records array..
                                                                  {
                                                                   clearInterval(b);
                                                                  }
                                                                  else{
                                                                   //Abhinandan.  Refresh timestamps in db, if not appearing..
                                                                   //alert('legacy_record_count is ' + legacy_record_count);  
                                                                   var data_count   = data_obj.length;   //Abhinandan. Must clear 1x outside for loop..
                                                                   
                                                                   
                                                                   //var ul = document.getElementById('top_ul_' + hid_unique_gadget.value);
                                                                   
                                                                   //var ul = document.getElementById('top_ul_' + unique_gadget);
                                                                   var ul = document.getElementById('top_ul');
                                                                       ul.innerHTML = "";
                                                                       
                                                                   
                                                                   for(var hb_i=0; hb_i < data_count; ++hb_i){
                                                                    var element_type   = data_obj[hb_i].element_type;   
                                                                    var currentColor   = data_obj[hb_i].data_value[legacy_record_count][element_type][1];
                                                                    var data_value     = data_obj[hb_i].data_value[legacy_record_count][element_type][0]; 
                                                                    var a_id           = data_obj[hb_i].dom_unique_attribute;  
                            
                                                                    //Dynamically create @ .js
                                                                    currentElement = document.createElement('li');
                                                                    currentElement.className = "dash-order";
                                                                    currentElement.innerHTML = "<a id='" + a_id + "'  class='button-" + currentColor + " ui-corner-all' href='#'><strong class='animJq'>" + data_value + "</strong><span>" + element_type + "</span></a>";      //Abhinandan. Feb20th.. quite possibly need to create variable (server side) which detects the 'element_type' (ie 'Aluminum') AND translates that into the appropriate language (as per user settings AND the translate tables in the db)..
                                                                     //currentElement.innerHTML = "<a id='" + a_id + "'  class='button-" + currentColor + " ui-corner-all' href='#'><strong class='animJq'>" + data_value + "</strong><span>" + '<?php echo Yii::t('elements', 'element_type' ); ?>' + "</span></a>";    //Yii::t('cmenu_home', 'home')
                                
                                                                    ul.appendChild(currentElement);                                                                                                                                                                              
                                                                   }//end for loop.. 
                                                                   
                                                                   
                                                                   
                                                                    //Attach animate events to colors:
                                                                    //  Find a tags and attach events if color is of our interest..                                                                  
                                                                   
                                                                  
                                                                   var ul = document.getElementById('top_ul');
                                                                   //var ul = document.getElementById('top_ul_' + unique_gadget);
                                                                   
                                                                   var a_items = ul.getElementsByTagName('a');
                                                                   for(var k = 0; k < a_items.length; ++k){
                                                                    if(a_items[k].className == 'button-red ui-corner-all')       //Abhinandan.  Shake for 'red' only...
                                                                    {
                                                                    
                                                                     niftyplayer('niftyPlayer1').playToggle();  //Abhinandan. Feb20th..
                                                                     
                                                                     var shake_id = a_items[k].id;   //Abhinandan. Must be declared outside the 'animate' event..
                                                                     $(".animJq").animate({opacity:1},2000,"linear",function(){
                                                                      $('#' + shake_id).effect("shake", { times:1 }, 100);    //Abhinandan. Better appearance is when used with the <a> element..
                                                                     });
                                                                    }
                                                                   } 
                                                                     
                                                                   ++legacy_record_count;
                                                                  }
                                                                 }, 3000);  //end setInterval @b..
                                                                 
                                                                } //end success..
                                                              }); //end ajax..
                                                              
                                                              */ //March8th commenting out for debugging..
                                                                 
                                                            // }, 20000);  //end setInterval @a ..   //Feb14th.. 
                                       }  //LS_execute
                        };  //LS_callback
                        
                        
                        
                         
                        LS_callback.LS_execute();
                        
                        /* //Abhinandan. Mar2nd commenting out for debugging the client-side..
                        var a = setInterval(function(){ 
                         LS_callback.LS_execute();  //Must be unique, else it could call upon another gadget..
                        }, 20000); 
                        */
                        
                         
                        </script>
                        
                      