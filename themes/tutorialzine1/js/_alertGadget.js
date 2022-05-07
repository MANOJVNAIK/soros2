   
<script type="text/javascript">
    
    $(document).ready(function(){
      
      /*
      *  Abhinandan.
      *  showItemSet() for '_statusGadget' :
      *   @param whichBlock The '+ Customize' Button we are customizing..           
      *
      */
      function showItemSet(whichBlock){
       //alert('showItemSet, a.)');
       if(whichBlock=='1')
       {
        //var block = document.getElementById("blockA");
        var block = document.getElementById("AlertsblockA");
        //alert('showItemSet, b.)');
        //alert('showItemSet, block is 1 and block innerHTML is ' + block.innerHTML );
       }
       else if(whichBlock=='2')
       {
        var block = document.getElementById("AlertsblockB");
       }
       else if(whichBlock=='3')
       {
        var block = document.getElementById("AlertsblockC");
       }
       else if(whichBlock=='4')
       {
        var block = document.getElementById("AlertsblockD");
       }
       else if(whichBlock=='5')
       {
        var block = document.getElementById("AlertsblockE");
       }
          
       //var chosenDataItem = document.getElementById("edit-alert-dialog-chosenDataItem");
       var chosenDataItem = document.getElementById('chosenDataItem-Alert-' + whichBlock);
       //alert('showItemSet, c.)');
       //var hidden_userNoDataItemSelection = document.getElementById("alerthidden_userNoDataItemSelection"); 
       var hidden_userNoDataItemSelection = document.getElementById('userNoDataItemSelection-Alert-' + whichBlock);  //Check if user made a selection or not..
       //alert('showItemSet, d.)');
       if( hidden_userNoDataItemSelection.value == 'yes' ) //If user did not make a selection..
       {
        var chosenDataItem_value = "Element 1";      //Default value is static, if user did NOT make selection..
        chosenDataItem = document.getElementById('chosenDataItem-Alert-' + whichBlock); //Go ahead and SET the chosenDataItem as our default value "Element 1"..
        chosenDataItem.value = chosenDataItem_value;
        //alert('Alpha '+ chosenDataItem.value);
       }
       else if( hidden_userNoDataItemSelection.value == 'no' )
       {
        //var chosenDataItem_value = chosenDataItem.value;
        var chosenDataItem_value = document.getElementById('chosenDataItem-Alert-' + whichBlock);
            chosenDataItem_value = chosenDataItem_value.value;
        //alert('Bravo '+ chosenDataItem_value);
       }
       
       block.innerHTML = chosenDataItem_value;
       $(this).dialog('close');              
       return true;
      }
                  
      
      /*
      *  Abhinandan.
      *  countTheActual()      
      *   @param whichBlock The '+ Customize' Button we are customizing.. 
      *             
      */ 
      /*     
      function countTheActual(whichBlock){
       var ul = document.getElementById("gadgetColorList");
       var li_count_total = ul.childNodes.length;
       var li_count_actual = 0;
       var i = 0;
       
       if(whichBlock=='1')
       {
        var block = document.getElementById("blockA");
       }
       else if(whichBlock=='2')
       {
        var block = document.getElementById("blockB");
       }
       else if(whichBlock=='3')
       {
        var block = document.getElementById("blockC");
       }
       else if(whichBlock=='4')
       {
        var block = document.getElementById("blockD");
       }
       else if(whichBlock=='5')
       {
        var block = document.getElementById("blockE");
       }
         
        
       while(i < li_count_total){
        if(ul.childNodes[i].nodeType != 3)
        {
         li_count_actual++;
        }
        i++;
       }//end while..
        
       block.innerHTML = li_count_actual + ' set chosen.';
       $(this).dialog('close'); 
                     
       return true;
       
      }//end countTheActual()..  
      */
      
      
       $( "#Alerts-dialog-form" ).dialog(
      {
       autoOpen: false,  
       height: 350,
       //width: newWidth,
       width: 'auto',       //Abhinandan. Jan11th 2013..
       modal: true,
       scrolling:false, 
       buttons: {			
         "Show gadget": function(){
                  
                                 addGadget();
                                 $( this ).dialog("close");
                       
         }, //end Add Gadget()..
         
         "Cancel": function(){
                  
                    $( this ).dialog( "close" );
                    
                    
         } //end Close()..
                 
        },  //end buttons obj..
        close: function(){
                 allFields.val( "" ).removeClass( "ui-state-error" );
        }
      } //end parameter object for 'dialog' event..
     );  //end dialog event..
     
       
      
    
       $("#edit-alert-dialog").dialog({
       open: function(){
       
        //Abhinandan. Jan25th 2013: 
         // i.) NEED TO make the 'choose color set DD' automatically open to '3set'..
         // ii.) THEN load the value saved by the 'customize Block' ...
       
        //Current 'Customize Button' the user is working setting properties on..
        var whichBlock = document.getElementById("edit-Alerts-dialog-currentCustomizeBlock");
            whichBlock = whichBlock.value;
        
        //alert('open button, whichBlock.value is ' + whichBlock);
        
        
        /* LEGACY
        var chosenColorSubset = document.getElementById("edit-alert-dialog-chosenColorSubset");   //Jan25th: NEEDS to include the 'whichBlock'...
            chosenColorSubset = chosenColorSubset.value;
        */
        
        
        // Jan25th 2013..
        var chosenColorSubset = document.getElementById('chosenColorSubset-Alert-' + whichBlock);
            chosenColorSubset = chosenColorSubset.value;
        
         
        if(chosenColorSubset == "")
        {
         chosenColorSubset = 0;
        }
        //@param  chosenColorSubset ...  
        gadgetColors.alternate(chosenColorSubset, 'Alerts', 'alert', 'Alert');         //This is for first time .dialog load.. (regardless of having serialized settings or not)...
        gadgetColors.chooseItem('alert', 'element');      //Attempts to reset the value back to default, OR the user's pre-defined SAVED value..                  
        //gadgetColors.chooseItem('alert', 'set');          /***** Jan 25th 2013.. ***/                                                  
          
          //var target = $('#alerts-form-input > select option:first-child').text();
          
          //var target = $('#alerts-form-input .alertdataItems').val();

         
       },
       autoOpen: false,  
       height: 450,
       title:"Assign Set Points",
       width: 500,
       modal: true,
       scrolling:false,
       buttons:{
           "save" : function(){
           
             //Current 'Customize Button' the user is working setting properties on..
             var whichBlock = document.getElementById("edit-Alerts-dialog-currentCustomizeBlock").value;
             //alert('save button, whichBlock.value is ' + whichBlock);
             
             
             //@param  for 'gadgetColors.saveSetPoints()'
             /* LEGACY
             var saved_chosenColorSet = document.getElementById("edit-alert-dialog-chosenColorSet");  //ie 3set or 5set..
                 saved_chosenColorSet = saved_chosenColorSet.value;
             */
             
             //NEW Jan25th 2013..
             var saved_chosenColorSet = document.getElementById('chosenColorSet-Alert-' + whichBlock);
             saved_chosenColorSet = saved_chosenColorSet.value;   //ie 3set or 5set..
             //alert('save button, saved_chosenColorSet is ' + saved_chosenColorSet);
             
             /* LEGACY
             var chosenColorSubset = document.getElementById("edit-alert-dialog-chosenColorSubset");  //ie '0' || '1' || '2' ...
                 chosenColorSubset = chosenColorSubset.value;
             */
             
             //NEW Jan25th 2013..
             var saved_chosenColorSubset = document.getElementById('chosenColorSubset-Alert-' + whichBlock);
             saved_chosenColorSubset = saved_chosenColorSubset.value;
             //alert('save button, saved_chosenColorSubset is ' + saved_chosenColorSubset);
                                     
                
             var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'alert', saved_chosenColorSubset, 'Alerts');  
             //alert('save button, json_str passed back is ' + json_str);      
             
             
             //STORE our jsonified string into hidden div for future retrieval.. //****************** Jan25th 2013 ****//
             /*
             var chosenSetPoints = document.getElementById("edit-alert-dialog-chosenSetPoints");
             chosenSetPoints.value = json_str;
             */
             
             
             //NEW Jan25th 2013.. STORE our jsonified string into hidden div for future retrieval..
             var saved_chosenSetPoints_new = document.getElementById('hAlert-' + whichBlock);
             saved_chosenSetPoints_new.value = json_str;  ////*******///
             //alert('saved_chosenSetPoints_new.value (containing the json string) is ' + saved_chosenSetPoints_new.value);
             
             //alert("edit-alert-dialog-chosenSetPoints is now " + chosenSetPoints.value);
             
             
             
             
             
             //Abhinandan. Go ahead and mark hidden div as having "settings_saved" for future use (next time dialog opens it checks for "settings_saved" )..
             /* LEGACY
             var loadFirstTime = document.getElementById("edit-Alerts-dialog-loadFirstTime");
                 loadFirstTime.value = "settings_saved"; 
              //alert(loadFirstTime.value);
             */
              
             
              //Jan 25th 2013... 
             //Abhinandan. Go ahead and mark hidden div as having "settings_saved" for future use (next time dialog opens it checks for "settings_saved" )..
             var saved_loadFirstTime_new = document.getElementById('settingsAlert-' + whichBlock);
                 saved_loadFirstTime_new.value = "settings_saved";  
                //alert('saved_loadFirstTime_new.value is ' + saved_loadFirstTime_new.value);                                                                  ///**********
                       
             
             /*
             *  Abhinandan. Jan 11th 2013: 
             *           i.) Instead of invoking 'countTheActual()' 
             *                which places ie "3 set chosen" upon 
             *                the 'Customize Button' ..
             *                
             *           ii.) (Abhi's request) Go ahead and invoke
             *                 the showItemSet(), which places
             *                 ie "Element 1" upon the 'Customize Button' ..                                                    
             */             
              
             //i.)
             //countTheActual(whichBlock);
             
             //ii.)
             showItemSet(whichBlock);  //User sees this..   
             
              
              
              //Abhinandan. Prepare for ajax call..
              var chosenDataItem = document.getElementById('chosenDataItem-Alert-' + whichBlock);
                  chosenDataItem = chosenDataItem.value;
              
              
              var element_colorset   = saved_chosenColorSet;
              
              var gadgetDataId = document.getElementById('gadgetDataId');
                  gadgetDataId = gadgetDataId.value;
              
              // 'order_location' @  'gadlay_elements' Table..  
              var order_location = whichBlock;
              
              // 'show_value' @ 'gadlay_elements' Table.. 
              var show_value = document.getElementById('chosenShowValue-Alert-' + whichBlock);
                  if(show_value && show_value.value != "")                //Last minute js check prior to send to server..
                  {
                   show_value = show_value.value;
                  }
                  else if(show_value && show_value.value == "")
                  {
                   show_value = "FALSE";
                  }
                  
                  
              
              // Jan 26th 2013:  LEFT OFF HERE!!!!  alert the variables prior to invoking the ajax call..
              //alert('Pre-Ajax, chosenDataItem is ' + chosenDataItem + ', element_colorset is ' + element_colorset + ', gadgetDataId is ' + gadgetDataId + 'order_location is ' + order_location + ', show_value is ' + show_value);
              
              var parsed_saved_chosenSetPoints_new = document.getElementById('hAlert-' + whichBlock);
                  parsed_saved_chosenSetPoints_new = parsed_saved_chosenSetPoints_new.value;
              
              
              $.ajax({
                type: 'POST',
                url: '/Helios/dash/Create',   // if Castor, change to '/dev/Helios_Jan_4/dash/Create'
                //data: {'element_type' : chosenDataItem, 'gadget_data_id' : gadgetDataId, 'order_location' : order_location, 'element_colorset' : element_colorset, 'element_setpoint' : saved_chosenSetPoints_new,'show_value' : show_value},
                data: {'element_type' : chosenDataItem, 'gadget_data_id' : gadgetDataId, 'order_location' : order_location, 'element_colorset' : element_colorset, 'element_setpoint' : parsed_saved_chosenSetPoints_new ,'show_value' : show_value},
                success: function(message){
                           //alert('Element ajax callback, message is ' + message);
                }
              });
              
              
               
             $(this).dialog('close');
           },
           "close" : function(){
              $(this).dialog('close');
              gadgetColors.alternate('0','Alerts', 'alert', 'Alert');   //Also for clearing out fields on 'close' .. also for first time .dialog load..
           }
       }
   }
    );
        
    })
    
    

</script>
   <!--- This is Gadget Form for Alert ---->
  <div id="Alerts-dialog-form" title="Alert Gadget" > <!-- Jan23rd @ 10:40am --> 
      <p><h3> Customize Buttons</h3> Each button represents individual display blocks you want
      	to monitor. <br/>Click on the buttons to assign properties to them.</p>
      
	                <section> 
                   <input id="hidden_customizeBut_size" value="" type="hidden">
                   <input id="hidden_customizeBut_data_source" value="asdf" type="hidden">   <!--- --->          
                   <ul class="isotope-widgets isotope-container" id="Alerts_ul_customizeBut">
                    
                    <!-- Abhinandan. Intentionally left dummy 'li' element. This space is actually dynamically filled. See customizeButtons.display() -->
                    <!-- Note: The '1' being passed into 'editAlert' represents the "whichBlock" inside 'countTheActual()' -->
                    <!-- Abhinandan. : See 'createDash.php, customizeButtons.display() to see the 'a href' when " + Customize " is clicked -->
                    <li class="dummy_li">                                                    
                     <a class="dummy_a " data-icon-primary="love"  href="#" onclick="dummy()" title="dummyTitle" >
                      <span id="dummyBlock">+<br>Customize</span>
                     </a>
                     <input id="dummy_id" value="" type="hidden"/>
                    </li>
                          
                   </ul>
                  </section>
  </div> 
  
      <div id="edit-alert-dialog" >
       <input id="edit-Alerts-dialog-currentCustomizeBlock" value="" type="hidden" />   <!-- Abhinandan. -->
       <input id="edit-alert-dialog-chosenDataItem" value="" type="hidden" />           <!-- Abhinandan. The value indicates which Chosen Element we selected (ie Element 1, Element 2, etc..) -->
       <input id="edit-alert-dialog-chosenColorSet" value="" type="hidden" />           <!-- Abhinandan. Indicates which colorset (ie 3set vs 5set) the user selected -->
       <input id="edit-alert-dialog-chosenColorSubset" value="" type="hidden" />        <!-- Abhinandan. Indicates '0' for 3set, '1' for 3set, and '2' for 5set.. '0' and '1' both share 3set because '0' refers to dialog load first time (3set), and '1' refers to user selected (3set) -->
       <input id="edit-alert-dialog-chosenShowValue" value="" type="hidden" />          <!-- Abhinandan. Indicates either True or False, checkbox show value or not -->
       <input id="edit-alert-dialog-chosenSetPoints" value="" type="hidden" />          <!-- Abhinandan. Serialized JSON formatted string, for colors & text boxes, each pair respectively -->
       <input id="edit-Alerts-dialog-loadFirstTime" value="" type="hidden" />            <!-- Abhinandan. Either "settings_clean" or "settings_saved" -->
       <input type="hidden" id="alerthidden_userNoDataItemSelection" value="yes">  <!-- Abhinandan. 'Yes' indicates no 'dataItem' was selected from drop-down.. -->
        
       <form class="form has-validation" >
       
			  <div class="clear"></div>
         <div class="clearfix">
         
			 	  <label for="form-email" class="form-label">
			 	 	 Choose Item <em>*</em>
			 	 	 <small>Choose Item set.</small>
			 	  </label>
          <div class="form-input" id="alert-form-input">                                
           <select id="alert_element_dataItems" class="alertdataItems"  name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text,'alert', 'Alert', 'Alerts')">  <!-- Abhinandan. -->
			 	 	  <option value="0" selected="selected">Choose element</option>
			 	 	  <option value="1">Element 1</option>
            <option value="2">Element 2</option>
            <option value="3">Element 3</option>
           </select>
			 	  </div> <!-- end  form-input class -->
			 	 </div> <!-- end clearfix class -->
         		 	
         <div class="clear"></div>
			 	  <div class="clearfix">
          
         
          
			 	   <label for="form-email" class="form-label">
			 	 	  Choose Color set<em>*</em>
			 	 	  <small>Choose color set.</small>
			 	   </label>
           <div class="form-input">                                  <!-- Jan25th 2013: removed:    -->
            <select id="alert_set_dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value,'Alerts','alert','Alert')" >  <!-- Abhinandan: See createDash.php for function object location -->
			 	 	   <option value="1" selected="selected" >3 Color set</option>
			 	 	   <option value="2">5 Color set</option>
            </select>
			 	   </div> <!-- end  form-input class -->
			 	  </div>	<!-- end  clearfix class -->                       
         
         <div class="clear"></div>
          <div class="clearfix">
           
          
			 	   <label for="form-email" class="form-label"> 
			 	    Show Actual value
			 	 	  <small>Show Actual value.</small>
			 	   </label>
           <div class="form-input">
            <input type="checkbox" name="showvalue" onchange="gadgetColors.setShowValue(this.checked, 'Alert', 'Alerts' )">
			 	   </div> <!-- end  form-input class -->
			 	  </div>	<!-- end  clearfix class -->
           
          <!-- Abhinandan. Default colors when the page loads for the first time.. -->
          <!-- Abhinandan. Jan 10th 2013: Removed the commented out li elements, because they are mistakenly counted by 'childNodes.length' -->                        
          <div class="clear"></div>
          <div class="clearfix">
           <label for="form-setPoints" class="form-label">
			 	 	  Define set points.
            <small>Assign colors.</small>
			 	   </label>
           
           <!-- Abhinandan. Jan11th 2013; Bug Fix: Removed 'isotope-container' class, was causing read-only text fields.. -->
           <!-- <ul id="gadgetColorList" class="isotope-widgets isotope-container"> -->
           <ul id="AlertsgadgetColorList" class="isotope-widgets">
            <!-- Abhinandan. To determine color "button" size, goto 'createDash.php', top of page styling -->
            <!-- Input size refers to the number of characters the field can display at once. -->
            <li class="dash-order isotope-item extrasm" > <a class="small button-green" href="javascript:void(0)"> </a><br/><input type="text" size="1" /></li> 
            <li class="dash-order isotope-item extrasm" > <a class="small button-orange" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
            <li class="dash-order isotope-item extrasm" > <a class="small button-red" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li> 
           </ul>
                    
         	</div> <!-- end clearfix class -->
        
			 	<div class="clear"></div>
			 	<div class="clear"><br/></div>
			 </form>
          
          
      </div>
                      
  

       
   <section class="clearfix" id="alert-par-form" style="display:none">
	  <div class="grid_6">
              
		 <div class="portlet">
			<header>
			 <h2>Add a new Gadget</h2>
			</header>
      
			<section> <!-- Begin Add a New Gadget Form section -->
		
                           
                            <form class="form has-validation" >
			  
			 	<div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-gadgetType" class="form-label">
			 	 	Choose Color<em>*</em>
			 	 	<small>Choose the color.</small>
			 	 </label>
			 	 <div class="form-input">
			 	 	<select id="colorType" name="colorType" maxlength="30">
			 	 	 <option value="red">Red</option>
			 	 	 <option value="green">green</option>
			 	 	 <option value="orange">Orange</option>
			 	 	 
			 	  </select>
			 	 </div> <!-- end  form-input class -->
			 	</div>  <!-- end  clearfix class -->
         
         
         
                                <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-email" class="form-label">
			 	 	Choose Items<em>*</em>
			 	 	<small>Choose items.</small>
			 	 </label>
                                  <div class="form-input">
                                     <select id="dataItems" name="dataItems" maxlength="30">
			 	 	 <option value="1">Aluminium1%</option>
			 	 	 <option value="2">Aluminium2%</option>
			 	 	 
                                    </select>
			 	 </div> <!-- end  form-input class -->
			 	</div>	<!-- end  clearfix class -->

                                
                                
                                <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-gadgetType" class="form-label">
			 	 	Choose Levels<em>*</em>
			 	 	<small>Choose levels.</small>
			 	 </label>
			 	 <div class="form-input">
			 	 	<select id="levelType" name="levelType" maxlength="30">
			 	 	 <option value="3_colors">3-colors</option>
			 	 	 <option value="4_colors">4-colors</option>
			 	 	 <option value="5_colors">5-colors</option>
			 	 	 
			 	  </select>
			 	 </div> <!-- end  form-input class -->
			 	</div>  <!-- end  clearfix class -->
                                
        
			 	<div class="form-action clearfix">
			 	 <button class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" type="button" data-icon-primary="ui-icon-circle-check" role="button" aria-disabled="false">
			 		<span class="ui-button-text">Reset Gadget</span>
			 	 </button>
			 	</div>  <!-- end  form-action clearfix -->
         
        
			 	<div class="clear"></div>
			 	<div class="clear"><br/></div>
			 </form>
			</section>  End Add a New Gadget Form section -->
		 </div>
    </div>
   </section>
    
  </div>
  
  <!---End of Gadget Form for Alert------>
  
