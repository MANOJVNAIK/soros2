<script>
    $(document).ready(function(){
    
    
    function checkLength( o, n, min, max ){
    //if( o.val().length > max || o.val().length < min )
    if( o.length > max || o.length < min )
    {
     o.addClass( "ui-state-error" );
     updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
     return false;
    }else{
     return true;
    }
   }//end CheckLength()..
 
   function checkRegexp( o, regexp, n ){
    if( !( regexp.test( o ) ) ) 
    {
     o.addClass( "ui-state-error" );
     updateTips( n );
     return false;
    }else{
     return true;
    }
   }//end checkRegexp()..
   
   
   /* 
   * Abhinandan.
   *  Method  userSelectedValue()
   *   @param  dom_element  ie The dom element passed in..
   *   @param  d_value      ie If no selection made, then defined here..
   *   
   *   @return  The value selected by user || the default value..               
   */
   function userSelectedValue(dom_element, d_value){
    if(dom_element && dom_element.value != "")
    {
     return dom_element.value;
    }
    else{
     return d_value;
    }
   }//end userSelectedValue()..
   
   
    
   
    
    
    
    
        
   $("#Charts-dialog-form").dialog({
       autoOpen: false,  
       height: 450,
       width: 605,
       modal: true,
       scrolling:false,
       buttons:{
           
           "Add gadget": function(){
  
             var gadgetDataId = document.getElementById("gadgetDataId");   //ie 353
                 gadgetDataId = gadgetDataId.value;     
             
             var chart_type = document.getElementById('Charts-storedChartType');
                 chart_type = userSelectedValue(chart_type, 'normal');    
                 
             var x_axis_item = document.getElementById('Charts-storedXAxis');
                 x_axis_item = userSelectedValue(x_axis_item, 'aluminum');   
                
             var y_axis_item = document.getElementById('Charts-storedYAxis');
                 y_axis_item = userSelectedValue(y_axis_item, 'single');
                
             var choose_items = document.getElementById('Charts-storedChooseItems');
                 choose_items = userSelectedValue(choose_items, 'Copper');     
            
             //alert('PRE-ajax, chart thread C_i, gadgetDataId is ' + gadgetDataId + ', chart_type is ' + chart_type + ', x_axis_item is ' + x_axis_item + ', y_axis_item is ' + y_axis_item + ', choose_items is ' + choose_items);
            
             $.ajax({
                type: 'POST',
                url: '/Helios_Jan_4/dash/Create',   //if Castor, change to '/dev/Helios_Jan_4/dash/Create'
                data: {'gadgetDataId' : gadgetDataId, 'chart_type' : chart_type, 'x_axis_item' : x_axis_item, 'y_axis_item' : y_axis_item, 'choose_items' : choose_items},
                success: function(message){
                  //alert('message is ' + message)
                }
             });
             
             addGadget();
             $( this ).dialog("close");
                               
           }, //end Add Gadget()..
               "Cancel":function(){
               $(this).dialog('close');
           }
       }
   }
    );
        
    });
    </script>
    
  
    
    
    
  <!--- This is Gadget Form for Chart ---->
  <div id="Charts-dialog-form" title="Enter parameters">
   <input id="Charts-storedChartType" value="" type="hidden" />    <!-- Abhinandan. ie 'Candle-Stand', 'Pie-Chart', 'Normal-Plot' -->
   <input id="Charts-storedXAxis" value="" type="hidden" />        <!-- Abhinandan. ie 'Aluminum' -->
   <input id="Charts-storedYAxis" value="" type="hidden" />        <!-- Abhinandan. ie 'single-set', 'double-set', 'triple-set' -->
   <input id="Charts-storedChooseItems" value="" type="hidden" />  <!-- Abhinandan. ie 'Aluminum' -->
    
   <section class="clearfix">
   
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2>Variable Settings</h2>
			</header>
      
			<section> <!-- Begin Add a New Gadget Form section -->
			 <form class="form has-validation" >
			  
			 	<div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-gadgetType" class="form-label">
			 	 	Chart Type<em>*</em>
			 	 	<small>Choose the type of chart.</small>
			 	 </label>
			 	 <div class="form-input">
			 	 	<select id="chartType" name="chartType" maxlength="30" onchange="gadgetChart.storeChartType(this.value, 'Charts-storedChartType')" >
			 	 	 <option value="candle">Candle-Stand</option>
			 	 	 <option value="pie">Pie-Chart</option>
			 	 	 <option value="normal">Normal-Plot</option>
			 	 	 
			 	  </select>
			 	 </div> <!-- end  form-input class -->
			 	</div>  <!-- end  clearfix class -->
         
         
			 	<div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-detectorSource" class="form-label">
			 	  X-Axis<em>*</em>
			 	 	<small>Choose X-Axis Value.</small>
			 	 </label>
			 	 <div class="form-input">
			 	 	<select id="xValue" name="xValue" maxlength="30" onchange="gadgetChart.storeXAxis(this.value, 'Charts-storedXAxis')">
			 	 	 <option value="aluminium">Aluminium%</option>
			 	 	 <option value="sulphur">Sulphur%</option>
			 	 	 <option value="iron">Iron%</option>
			 	 	</select>
			 	 </div> <!-- end  form-input class -->
			 	</div> <!-- end clearfix class -->
                                
                                
                                <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-detectorSource" class="form-label">
			 	  Y-Axis<em>*</em>
			 	 	<small>Choose Y-Axis Value.</small>
			 	 </label>
			 	 <div class="form-input">
			 	 	<select id="yValue" name="yValue" maxlength="30" onchange="gadgetChart.storeYAxis(this.value, 'Charts-storedYAxis')">
			 	 	 <option value="singleset">Single-set</option>
			 	 	 <option value="doubleset">Double-set</option>
			 	 	 <option value="tripleset">Triple-set</option>
			 	 	</select>
			 	 </div> <!-- end  form-input class -->
			 	</div> <!-- end clearfix class -->
         
         
                                <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-email" class="form-label">
			 	 	Choose Items<em>*</em>
			 	 	<small>Choose items.</small>
			 	 </label>
                                  <div class="form-input">                                 
                                     <select id="dataItems" name="dataItems" maxlength="30" onchange="gadgetChart.storeChooseItems(this.value, 'Charts-storedChooseItems')">
			 	 	 <option value="copper">Copper%</option>
			 	 	 <option value="silver">Silver%</option>
			 	 	 
                                    </select>
			 	 </div> <!-- end  form-input class -->
			 	</div>	<!-- end  clearfix class -->
                                
        
        <!-- Abhinandan. Removed Jan10th as per Abhi request.. -->
        <!-- <div class="form-action clearfix">
			 	 <button class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" type="button" data-icon-primary="ui-icon-circle-check" role="button" aria-disabled="false">
			 		<span class="ui-button-text">Reset Gadget</span>
			 	 </button>
			 	</div> -->  <!-- end  form-action clearfix -->
         
        
			 	<div class="clear"></div>
			 	<div class="clear"><br/></div>
			 </form>
			</section>  <!-- End Add a New Gadget Form section -->
		 </div>
    </div>
   </section>
    
  </div>
  
  <!---End of Gadget Form for Chart------>
  