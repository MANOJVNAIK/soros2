  <!--- This is Gadget Form for Tables ---->
<script>
 var countMe=1;
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
      
      
      
      
      
      
      
      $( "#Table-dialog-form" ).dialog(
      {
       autoOpen: false,  
       height: 450,
       width:  400,
       modal: true,
       scrolling:false, 
       buttons: {			
         "Add gadget": function(){
          
           /*
           * Abhinandan. Step 1/2; Stuffing object from what the user entered..           
           * 
           * Sample row_data_obj ...
           *            
           * var row_data_obj = {
           *         row2 : {
           *                tr_id : "row2",
           *                td_content : "Element 1" 
           *         },
           *
           *         row3 : {
           *                tr_id : "row3",
           *                td_content : "Element 2"
           *         }
           *
           */                      
           //Abhinandan. Also reference line 197 for how all <tr>...<td> share similar attributes..
           var row_data_obj = {};
           var table       = document.getElementById("Table_latest_activity");
           var numRows     = table.rows.length;   // Counts total 'rows' subarray(s)..
           
           for(var i=1; i<numRows; ++i){
            var tr_id = table.rows[i].id;
            
            //row_data_arr[i-1] = tr_id;  //works, but now I need associative keys..
            row_data_obj[tr_id] = {};  //In javascript, must declare new object prior to stuffing it..
            row_data_obj[tr_id]['tr_id']    = tr_id;
                    
            var td_data = table.rows[i].getElementsByTagName('td');
            for(var j=0; j<td_data.length; ++j){
             var j = td_data[j].innerHTML; 
             
             row_data_obj[tr_id]['td_content'] = j; 
            }//inner for loop..
            
           }//outter for loop..
           
            console.log(row_data_obj); 
  
            /* Abhinandan. Step 2/2; Serializing the built-up object as a JSON string, THEN storing into hidden div.. */
            var storedTableEntries = document.getElementById('Table-storedTableEntries');
                storedTableEntries.value = JSON.stringify(row_data_obj);
            alert('storedTableEntries.value is ' + storedTableEntries.value);
            
            
            /*
            *  2x variables for ajax call:
            *            
            *  storedTableEntries.value
            *  gadgetDataId            
            *              
            */             
            var gadgetDataId = document.getElementById("gadgetDataId");
                gadgetDataId = gadgetDataId.value;
            
            
            //Ajax here for table gadget..  
            $.ajax({
                 type: 'POST',
                  url: '/Helios_Jan_4/dash/Create',   //if Castor, change to '/dev/Helios_Jan_4/dash/Create'
                  data: {'gadget_data_id' : gadgetDataId, 'saved_table_options' : storedTableEntries.value},
                  success: function(message){                          
                   alert('message is ' + message);
                  }
            });
             
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
     
              
    })
    
    function addTableEntry()
    {
     var item = document.getElementById("tableItems");
     item_value = item.value;
     
     countMe++;  //Begin at 2..
    
     $("#placeholder1").remove();
     //var dummy = "<tr class='closeable' id='row"+countMe+"'><td>"+item_value+"<a href='#' id='id_removeItem' style='color:blue' onclick='removeItem("+countMe+")' > (remove)</href></td><td>--</td><td>--</td></tr>";   
     var dummy = "<tr class='closeable' id='row"+countMe+"'><td>"+item_value+"</td><td><a href='#' id='id_removeItem' style='color:blue' onclick='removeItem("+countMe+")' > (remove)</href></td></tr>";
     //var dummy2 = '<li class="ui-widget message info closeable" id="listItem'+countMe+'">'+item+'<span class="ui-icon-circle-close remove" onclick="removeItem('+countMe+')">Remove</span></li>';
  
     $("#tableEntry").append(dummy);      //Abhinandan. Jan11th: Append <tr> to parent <thead> ..
     //$("#selectedItems").append(dummy2);
    }
    
    
    /*
    *  Abhinandan.
    *   First item has countMe = 2..    
    */    
    function removeItem(countMe) 
    {
     $("#row"+countMe).remove();
    }
    
    </script>
    
    
    
    
    
    
    <div id="Table-dialog-form" title="Enter parameters"> 
     <input id="Table-storedTableContents" value="" type="hidden" />  <!-- Abhinandan. ie 'Aluminum'**** -->
     
   <section class="clearfix">
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2>Add a new Gadget</h2>
			</header>
      
			<section> <!-- Begin Add a New Gadget Form section -->
			 <form class="form has-validation" >
       
			  <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-email" class="form-label">
			 	 	Choose Items<em>*</em>
			 	 	<small>Choose items.</small>
			 	 </label>
         <div class="form-input">
          <select id="tableItems" name="dataItems" maxlength="30" onchange="addTableEntry()">
			 	 	 <option value="Aluminium">Aluminium%</option>
			 	 	 <option value="Sulphur">Sulphur%</option>
           <option value="Element 1">Element 1%</option>
           <option value="Element 2">Element 2%</option>
			 	  </select>                          
			 	 </div> <!-- end  form-input class -->
			 	</div>	<!-- end  clearfix class -->
                                
                                    
                                
                                      <ul id="selectedItems">
                                          
                                      </ul>
			 	</div>  <!-- end  form-action clearfix -->
         
        
                               <!-- <span onclick="showCount()" class="button-blue">Show Count</span>-->
			 	<div class="clear"></div>
                                
                                
                                <div class="clear"></div>
                                <br><br>
                                
                                
                                <div id="widget-latestactivity" class="portlet collapsible ui-widget ui-widget-content ui-corner-all">

                                    <header class="ui-widget-header ui-corner-top">

                                        <h2>Latest Activity</h2>

                                    <a role="button" class="portlet-collapse ui-corner-all" href="#"><span class="ui-icon ui-icon-circle-minus">Expand/Collapse</span></a></header>

                                    <section class="no-padding clearfix ui-widget-content ui-corner-bottom">

                                        <table id="Table_latest_activity" class="full">

                                            <thead>

                                                <tr>

                                                    <th class="ui-state-default">Element</th>

                                                    <th class="ui-state-default">Action Item</th>

                                                    <!-- <th class="ui-state-default">1Hr Det</th> -->  <!-- Abhinandan. -->

                                                </tr>

                                            </thead>

                                            <tbody id="tableEntry">

                                                <tr id="placeholder1"><td columspan="3">Select Item in drop down list to add</td></tr>
                                         
                                            </tbody>

                                        </table>

                                    </section>

                                </div>
			 	<div class="clear"><br/></div>
			 </form>
			</section>  <!-- End Add a New Gadget Form section -->
		 </div>
    </div>
   </section>
    
  </div>
    
    
  <!-- LEGACY
  <div id="Table-dialog-form" title="Enter parameters">  
   <section class="clearfix">
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2>Add a new Gadget</h2>
			</header>
			<section> LEGACY --> <!-- Begin Add a New Gadget Form section -->
      <!-- LEGACY
			 <form class="form has-validation" >	    		 	
        <div class="clear"></div>
			 	<div class="clearfix">
			 	 <label for="form-email" class="form-label">
			 	 	Choose Items<em>*</em>
			 	 	<small>Choose items.</small>
			 	 </label>
                                  <div class="form-input">
                                     <select id="dataItems" name="dataItems" maxlength="30">
			 	 	 <option value="1">Aluminium%</option>
			 	 	 <option value="2">Sulphur%</option> 	 
                                    </select>
			 	 </div> LEGACY --> <!-- end  form-input class -->
			 	 <!-- LEGACY </div> --> <!-- end  clearfix class -->
         <!--
			 	<div class="form-action clearfix">
			 	 <button class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" type="button" data-icon-primary="ui-icon-circle-check" role="button" aria-disabled="false">
			 		<span class="ui-button-text">Reset Gadget</span>
			 	 </button>
			 	</div> LEGACY --> <!-- end  form-action clearfix --> 
			 	 <!-- LEGACY
         <div class="clear"></div>
			 	<div class="clear"><br/></div>
			 </form>
			</section> LEGACY --> <!-- End Add a New Gadget Form section -->
      <!-- LEGACY
		 </div>
    </div>
   </section>
  </div>
   LEGACY -->
   
  
  <!---End of Gadget Form for Tables------> 
  
  
  
  
  
  
  