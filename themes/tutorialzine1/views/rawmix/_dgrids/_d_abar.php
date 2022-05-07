<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/growl.js"></script>
<script type="text/javascript">

$(document).ready(function(){
$.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/getLogMessagesPopBox',
	   data: { 'counter' : 1 },
	   success: function(stringified){
		   if(stringified > 0){
		   		$("#rawMixBadger").html(stringified);
		   		$("#rawMixBadger").attr("class","badge");
		   		$("#rawMixBadger" ).effect( "pulsate", { times: 15 }, "slow" );

		   }else {
			   $("#rawMixBadger").attr("class","");   
		   }
	   }
});
});
$("#rawMixBadgerLi").click(function(){
	var fetchDashboardElements = "fetchDashboardElements";
	var gadgetType             = "AlarmBar";
	var writeScript			   = 1;  
	var show999 			   = 1;
	  $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/getLogMessagesPopBox',
	   data: { 'cTime' : '<?php echo date("Y-m-d H:i:s"); ?>' },
	   success: function(stringified){
	      //alert('success, stringified is ' + stringified);return;
	      success_data_obj = $.parseJSON(stringified);
	      console.log(success_data_obj);
	      var zero_index = success_data_obj[0];
	       
	       //Set up the form prior to showing data..
	       firstDiv_parent               = document.createElement('div');
	       firstDiv_parent.id            = 'alertBarHtml';
	       firstDiv_parent.style.display = 'none';
	       
	       //Feb27th..
	       //firstDiv_parent.innerHTML = "<div class='ui widget'><div class='wrapped' style='background:transparent;'><p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + zero_index.color + ";'>" + zero_index.occurredAt + " : </span>" + zero_index.description + "</p></div></div>"; 
	        firstDiv_parent.innerHTML = zero_index.custom_message;
	        
			firstDiv_parent.innerHTML += '<div class="wrapped" style="background:transparent;"><script>$(".in_popchecker").click(function(){'+
											'var popid = $(this).attr("title");'+
											'$.ajax({type: "POST",url: "<?php echo Yii::app()->baseUrl; ?>/dash/updtLogMessagesPopBox",'+
												   'data: { "makeread" : popid },'+
												   'success: function(stringified){$("#in_popchecker"+popid +" img").attr("src","<?php echo Yii::app()->theme->baseUrl; ?>/images/navicons/23.png");}' +
											'});'+
										'});';
			firstDiv_parent.innerHTML += '</div>';
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

	       showAlertBar(1);		    
		    
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
		        timeout = setTimeout( function(){showAlertBar(1);},900 );
		    	$("#hidInputAlertBar").val(1);      //From zero to 1..
		    
		    }
		    else
		    {

			if(show999) {
				//AllRead
				show999 = 0;
				ardynamicRecord               = document.createElement('div');
				ardynamicRecord.id            = 'hidDisp' + 999;
				   
				ardynamicRecord.style.display = 'none';
			    
				ardynamicRecord.innerHTML = complete_data_obj[999].custom_message;
	         	ardynamicRecord.innerHTML += '<script>$(".in_popchecker").click(function(){'+
					'var popid = $(this).attr("title");'+
					'$.ajax({type: "POST",url: "<?php echo Yii::app()->baseUrl; ?>/dash/updtLogMessagesPopBox",'+
						   'data: { "makeread" : popid },'+
						   'success: function(stringified){ $("#in_popchecker"+popid +" img").attr("src","<?php echo Yii::app()->theme->baseUrl; ?>/images/navicons/23.png");}' +
					'});'+
					'});';				
			    document.body.appendChild(ardynamicRecord);    
			    //alert($("#hidDisp" + 999).html());
			    var newhtml =  $("#hidDisp" + 999).html() + $("#growlstatusDiv").html();
			    $("#growlstatusDiv").html( newhtml ); 
		    }			    
			 if(complete_data_obj[did]){
		     	//New..
		     	dynamicRecord               = document.createElement('div');
	         	dynamicRecord.id            = 'hidDisp' + did;
	         	dynamicRecord.style.display = 'none';
	         	//alert(did);
	         	//Feb27th..
	         	//dynamicRecord.innerHTML = "<p style='vertical-align: bottom;color:white;line-height: 18px;'><span style='color:" + complete_data_obj[did].color + ";'>" + complete_data_obj[did].occurredAt + " : </span>" + complete_data_obj[did].description + "</p>"; 
	         	dynamicRecord.innerHTML = complete_data_obj[did].custom_message;

	         	dynamicRecord.innerHTML += '<script>$(".in_popchecker").click(function(){'+
												'var popid = $(this).attr("title");'+
												'$.ajax({type: "POST",url: "<?php echo Yii::app()->baseUrl; ?>/dash/updtLogMessagesPopBox",'+
													   'data: { "makeread" : popid },'+
													   'success: function(stringified){ $("#in_popchecker"+popid +" img").attr("src","<?php echo Yii::app()->theme->baseUrl; ?>/images/navicons/23.png");}' +
												'});'+
											'});';
	        
	        	document.body.appendChild(dynamicRecord);
		     
		    	$("#growlstatusDiv").append( $("#hidDisp" + did).html() );         ////
		        timeout = setTimeout(function(){showAlertBar(did+1);},900 );
			 }//object exists
		    }//else
	      }//function
	      
		   		  

		        
		    
	   } //end complete..
	   
	  }); //end ajax.. 		 
});//end rawMixBadgerLi
</script>