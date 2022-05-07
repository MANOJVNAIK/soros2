   
<script type="text/javascript">
    
    $(document).ready(function(){
      
      
                  
      
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
      
      
       
     
       
      
    
       
        
    })
    
    

</script>
  
   
  
      
                      
  

       
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
  