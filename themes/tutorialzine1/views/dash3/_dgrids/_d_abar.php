<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/growl.js"></script>
<script type="text/javascript">
	
	var fetchDashboardElements = "fetchDashboardElements";
	var gadgetType             = "AlarmBar";
  
  $.ajax({
   type: 'POST',
   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Dash',
   data: { 'ajaxForwardRequest' : fetchDashboardElements, 'gadgetType' : gadgetType },
   success: function(stringified){
      //alert('success, stringified is ' + stringified);
      success_data_obj = $.parseJSON(stringified);
      console.log(success_data_obj);
      var zero_index = success_data_obj[0];
      
       
       //Set up the form prior to showing data..
       firstDiv_parent               = document.createElement('div');
       firstDiv_parent.id            = 'alertBarHtml';
       firstDiv_parent.style.display = 'none';
       
       //Feb27th..
       //firstDiv_parent.innerHTML = "<div class='ui widget'><div class='wrapped' style='background:transparent;'><p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + zero_index.color + ";'>" + zero_index.occurredAt + " : </span>" + zero_index.description + "</p></div></div>"; 
        firstDiv_parent.innerHTML = "<div class='ui widget'><div class='wrapped' style='background:transparent;'><p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + zero_index.color + ";'>" + zero_index.logged_time + " : </span>" + zero_index.custom_message + "</p></div></div>";
        document.body.appendChild(firstDiv_parent);
      
      
      
       secondDiv_parent               = document.createElement('div');
       secondDiv_parent.id            = 'hiddenValDiv'; 
       secondDiv_parent.innerHTML     = "<input type='hidden' value='zero' id='hidInputAlertBar'/>";
        document.body.appendChild(secondDiv_parent);
       
        
   }, //end success..
   complete: function(stringified){
    
    //alert('complete, responseText is ' + stringified.responseText);
    var complete_data_obj = $.parseJSON(stringified.responseText);        // Abhinandan. '.responseText' for the "complete" callback, unlike 'success'..
    
    var timeout = null;
	    
      function showAlertBar(did) {
       //alert('@param did  is ' + did);
      	var newInnerHtml = $("#alertBarHtml").html();     /// The first message shown..
      	var hidVal       = $("#hidInputAlertBar").val();    //zero..

        
      	if(hidVal == "zero")
      	{
      	 //alert('inside zero block');
	       $.Growl.show(newInnerHtml, {
	          'title'  : "",
	          'timeout': false
	        });
	        timeout = setTimeout( function(){showAlertBar(1);},5000 );
	    	$("#hidInputAlertBar").val(1);      //From zero to 1..
	    
	      }
	    else
	    {
	     //New..
	     dynamicRecord               = document.createElement('div');
       dynamicRecord.id            = 'hidDisp' + did;
       dynamicRecord.style.display = 'none';
       
       //Feb27th..
       //dynamicRecord.innerHTML = "<p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + complete_data_obj[did].color + ";'>" + complete_data_obj[did].occurredAt + " : </span>" + complete_data_obj[did].description + "</p>"; 
         dynamicRecord.innerHTML = "<p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + complete_data_obj[did].color + ";'>" + complete_data_obj[did].logged_time + " : </span>" + complete_data_obj[did].custom_message + "</p>";
        
         
        document.body.appendChild(dynamicRecord);
	     
	    	$("#growlstatusDiv").append( $("#hidDisp" + did).html() );         ////
	        timeout = setTimeout(function(){showAlertBar(did+1);},5000 );
	    }
      }//function
      
	  showAlertBar(1); 
    
   } //end complete..
   
  }); //end ajax..
  
  
</script>
 
 