   
<script type="text/javascript">
    
    $(document).ready(function(){
      
      /*
      *  Abhinandan.
      *  showItemSet()
      *   @param whichBlock The '+ Customize' Button we are customizing..           
      *
      */
      function showItemSet(whichBlock){
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
       
       var chosenDataItem = document.getElementById("edit-alert-dialog-chosenDataItem");
       
       var hidden_userNoDataItemSelection = document.getElementById("hidden_userNoDataItemSelection"); //Check if user made a selection or not..
       if( hidden_userNoDataItemSelection.value == 'yes' ) //If user did not make a selection..
       {
        var chosenDataItem_value = "Element 1";      //Default value is static, if user did not make selection..
       }
       else if( hidden_userNoDataItemSelection.value == 'no' )
       {
        var chosenDataItem_value = chosenDataItem.value;
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
      
      
      
       $( "#Meter_Gauge-dialog-form" ).dialog(
      {
       autoOpen: false,  
       height: 350,
       width: 'auto',       
       modal: true,
       scrolling:false, 
       buttons: {			
         "Add gadget": function(){
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
       autoOpen: false,  
       height: 450,
       title:"Assign Set Points",
       width: 500,
       modal: true,
       scrolling:false,
       buttons:{
           "save" : function(){
           
             //Current 'Customize Button' the user is working setting properties on..
             var whichBlock = document.getElementById("edit-alert-dialog-currentCustomizeBlock").value;
             
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
             showItemSet(whichBlock);
               
             $(this).dialog('close');
           },
           "close" : function(){
              $(this).dialog('close');
           }
       }
   }
    );
        
    })
    
    

</script>
   <!--- This is Gadget Form for Alert ---->
  <div id="Meter_Gauge-dialog-form" title="Gauge Gadget">  
      <p><h3> Customize Buttons</h3> Each button represents individual display blocks you want
      	to monitor. <br/>Click on the buttons to assign properties to them.</p>
      
	                <section> 
                   <input id="hidden_customizeBut_size" value="" type="hidden"> 
                   <input id="hidden_customizeBut_data_source" value="" type="hidden">            
                   <ul class="isotope-widgets isotope-container" id="Meter_Gauge_ul_customizeBut">
                   
                   <!-- Note: The '1' being passed into 'editAlert' represents the "whichBlock" inside 'countTheActual()' -->
                    <!--First Customize Block -->
                    <li class="dash-order">                                                    
                     <a class="button-gray ui-corner-all " data-icon-primary="love"  href="#" onclick="editAlert('1')" title="Customize the alert item" >
                      <span id="blockA">+<br>Customize</span>
                     </a>
                     <input id="hAlert-1" value="" type="hidden"/>
                    </li>
                    
                    <!-- Second Customize Block -->
                    <li class="dash-order">
                     <a class="button-gray ui-corner-all " href="#" data-icon-primary="love" onclick="editAlert('2')" title="Customize the alert item" >
                      <span id="blockB">+<br>Customize</span>
                     </a>
                    <input id="hAlert-2" value="" type="hidden"/>
                    </li>
                     
                     <!-- Third Customize Block -->                   
                    <li class="dash-order">
                     <a class="button-gray ui-corner-all " onclick="editAlert('3')"href="#" title="Customize the alert item" >
                      <span id="blockC">+<br>Customize</span>
                     </a>
                     <input id="hAlert-3" value="" type="hidden"/>
                    </li>
                          
                   </ul>
                  </section>
  </div> 
  
      <div id="edit-alert-dialog">
       <input id="edit-alert-dialog-currentCustomizeBlock" value="" type="hidden" />   <!-- Abhinandan. -->
       <input id="edit-alert-dialog-chosenDataItem" value="" type="hidden" />           <!-- Abhinandan. -->
        <input type="hidden" id="hidden_userNoDataItemSelection" value="yes">  <!-- Abhinandan. 'Yes' indicates no 'dataItem' was selected from drop-down.. -->
        
       <form class="form has-validation" >
       
			  <div class="clear"></div>
         <div class="clearfix">
         
			 	  <label for="form-email" class="form-label">
			 	 	 Choose Item <em>*</em>
			 	 	 <small>Choose Item set.</small>
			 	  </label>
          <div class="form-input">
           <select id="dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text)">  <!-- Abhinandan. -->
			 	 	  <option value="0">Choose element</option>
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
           <div class="form-input">
            <select id="dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value)">  <!-- Abhinandan: See createDash.php for function object location -->
			 	 	   <option value="1">3 Color set</option>
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
            <input type="checkbox" name="showvalue">
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
           <ul id="gadgetColorList" class="isotope-widgets">
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
  