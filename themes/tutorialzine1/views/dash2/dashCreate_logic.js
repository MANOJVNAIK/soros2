// JavaScript Document



 //Outside the Initialization function; Invoked by a form's "onchange" event..
 var customizeButtons = {
     
     getSize : function(){
      var hidden_customizeBut_size = document.getElementById("hidden_customizeBut_size");
      return hidden_customizeBut_size.value; 
     },
    
     getGadgetPrefix: function( _gadgetType_ ){
                       //alert('getGadgetPrefix, _gadgetType_.value is ' + _gadgetType_.value);   //ie Charts..
                        
                        //var whichGadget_value = _gadgetType_.value;
                        var whichGadget_value = _gadgetType_;
                        
                      
                        /*If the gadgetType == 'Charts' then do nothing..*/
                        if(whichGadget_value == 'Charts')
                        {
                         //var ul_customizeBut = 'ignore'; 
                         var ul_customizeBut = document.getElementById('Charts_ul_customizeBut');   
                        }
                        else if(whichGadget_value == 'Alerts')
                        { 
                         var ul_customizeBut = document.getElementById('Alerts_ul_customizeBut'); 
                        }
                        else if(whichGadget_value == 'IdiotLights')  
                        {
                         var ul_customizeBut = document.getElementById('IdiotLights_ul_customizeBut'); 
                        }
                        else if(whichGadget_value == 'LiveStatus')  
                        {
                          //alert('whichGadget_value is ' + whichGadget_value);
                         var ul_customizeBut = document.getElementById('LiveStatus_ul_customizeBut'); 
                          //alert('ul_customizeBut is ' + ul_customizeBut);
                        }
                        
                        return ul_customizeBut;
     },
     
     setSize : function(size){
       var hidden_customizeBut_size = document.getElementById("hidden_customizeBut_size");
           hidden_customizeBut_size.value = size;
           //alert('size set was ' + hidden_customizeBut_size.value);
           return true;          
     },
    
    removeElem : function(v,s){

      if(s =="C")
     	var gadget_data_source   = document.getElementById("Charts_gadget_data_source");  // '#gadget_data_source' is located here 1x @ createDash.php
      else
     	var gadget_data_source   = document.getElementById("Tables_gadget_data_source");  // '#gadget_data_source' is located here 1x @ createDash.php

      gadget_data_source.value = gadget_data_source.value.replace(new RegExp(v, 'g'),'');
      gadget_data_source.value = gadget_data_source.value.replace(new RegExp(";;", 'g'),';');
      var nVals = gadget_data_source.value.split(";");

	  this.formTableElements(nVals,s);
      return true;
    
    },     
    
    setGroupStyle : function(v){
    
    	if(v == "individual")
    	{
    		document.getElementById("chartElementsTable").display = "";
    	}
    	else
    		document.getElementById("chartElementsTable").display = "";
    	
    	document.getElementById("gadget_groupStyle").value = v;
    },

    setChartStyle : function(v){
    	document.getElementById("gadget_chartStyle").value = v;
    },
    
	     
     setCDataSource : function(ds){
      var dispType   = document.getElementById("gadget_groupStyle").value;
      var gadget_data_source   = document.getElementById("Charts_gadget_data_source");  // '#gadget_data_source' is located here 1x @ createDash.php

          //console.log(gadget_data_source.value);
	  if(dispType =="individual")
	  {
	        var tt_gadget_data_source = ";" + ds;
		    var tnVals = tt_gadget_data_source.split(";");
	        gadget_data_source.value = tt_gadget_data_source;
		  	this.formTableElements(tnVals,"C");
	  }
	  else
	  {
                //To avoid inserting new element while updating the chart gadget
                 if(ds == '999')   {
                      var t_gadget_data_source = gadget_data_source.value; 
                 }else{
	          var t_gadget_data_source = gadget_data_source.value + ";" + ds;
                 }
		      var nVals = t_gadget_data_source.split(";");

			  if(((nVals.length-1) > 0) && ((nVals.length-1) <=3))
			  {
			    gadget_data_source.value = t_gadget_data_source;
			  	this.formTableElements(nVals,"C");
			  }
			  else if((nVals.length-1) >3)
			  {
			  	alert("You can only add three elements into the set for now!");
			  }
	  } // else displayType=individual

      return true;
     },
     
	     
     setTDataSource : function(ds){
      var gadget_data_source   = document.getElementById("Tables_gadget_data_source");  // '#gadget_data_source' is located here 1x @ createDash.php

	  {
	          var t_gadget_data_source = gadget_data_source.value + ";" + ds;
		      var nVals = t_gadget_data_source.split(";");
                      	 //console.log(nVals);

			  if(((nVals.length-1) > 0) && ((nVals.length-1) <=10))
			  {
			    gadget_data_source.value = t_gadget_data_source;
			  	this.formTableElements(nVals,"T");
			  }
			  else if((nVals.length-1) >10)
			  {
			  	alert("You can only add 10 elements into the gadget for now!");
			  }
	  } // else displayType=individual

      return true; 
     },
     
     
     formTableElements : function(nVals,vl){
	    var nValsTable = "";
	    var nrowColor  = "evenr";

		for (var i=0;i<nVals.length;i++)
		{
			if(!(/^\s*$/).test(nVals[i]))
			{
				nrowColor  = ((i%2==0)? "evenr" : "odde");	  	
				nValsTable += "<tr class=' " + nrowColor + " '><td>" + nVals[i] + "</td><td>" 
				+ 
				"<a onclick='customizeButtons.removeElem(\"" + nVals[i] + "\", \"" + vl + "\")' class='button ui-button' data-icon-only='true' data-icon-primary='ui-icon-circle-close' role='button'><span class='ui-button-icon-primary ui-icon ui-icon-circle-close'></span></a>"
				+
				"</td></tr>";
			}
		}
		if(vl =="C")
			document.getElementById("chartElementsBody").innerHTML = nValsTable;
		else
			document.getElementById("tablesElementsBody").innerHTML = nValsTable;
		
		return true;     
     },
     /* AB352014 Adding anothe Table Type value */
     setTableType: function(tableTypeValue, target_dropDownID, basePath) {
     if(tableTypeValue == "none")
     	return;


	  $(".loadingPart").append("<div id='loadedcontainer'><p id='contentLoad'>" +
                   "<img id='loadinggraphic' width='16' height='16' src='<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader-eeeeee.gif' /> " +
                   "Loading...</p></div>");

     
      $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
           type: 'POST',
           url: basePath + '/dash/GetDataTables',
           data: { 'table_type' : tableTypeValue },
           success: function(tables){    
			$("#loadedcontainer").remove();
            document.getElementById( target_dropDownID ).options.length = 0;

            var obj = $.parseJSON(tables);

            var toption = document.createElement('option');
            toption.setAttribute( "value", "none");
            toption.innerHTML = "Select Table";
            document.getElementById( target_dropDownID ).appendChild(toption);

            for(var i=0; i<obj.length; ++i)
            {
             var option = document.createElement('option');
                 option.setAttribute( "value", obj[i].charAt(0)+ obj[i].slice(1) );  //Abhinandan. Capitalize first letter..
                 option.innerHTML = obj[i].charAt(0).toUpperCase() + obj[i].slice(1);               //""..
                document.getElementById( target_dropDownID ).appendChild(option);
            }  
           }//success
      });  //end ajax..
      
     
     },
     
     setDetectorSource : function(detector_source, target_dropDownID, basePath){ 
      //document.getElementById( target_dropDownID ).innerHTML = "";
      //console.log(basePath);
      //var real_table_name = document.getElementById(detector_source).innerHTML;
      var real_table_name = detector_source;

      $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
           type: 'POST',
           url: basePath + '/dash/GetDataSourceColumnsFromTable',
           data: { 'table_name' : real_table_name },
           success: function(columns){

            document.getElementById( target_dropDownID ).options.length = 0;

            var obj = $.parseJSON(columns);

            var toption = document.createElement('option');
            toption.setAttribute( "value", "none");
            toption.innerHTML = "Select Table";
            document.getElementById( target_dropDownID ).appendChild(toption);

            for(var i=0; i<obj.length; ++i)
            {
             var option = document.createElement('option');
                 option.setAttribute( "value", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );  //Abhinandan. Capitalize first letter..
                 option.innerHTML = obj[i].charAt(0).toUpperCase() + obj[i].slice(1);               //""..
                document.getElementById( target_dropDownID ).appendChild(option);
            }             
           }
      });  //end ajax..
      
      var target_dropDownIDv = target_dropDownID.replace(new RegExp("dataSource", 'g'),'');
          target_dropDownIDv = target_dropDownIDv.replace(new RegExp("element_dataItems", 'g'),'');
          
      //alert(target_dropDownIDv);
      var gadget_detector_source   = document.getElementById(target_dropDownIDv + "gadget_detector_source");  // '#gadget_detector_source' is located here 1x @ createDash.php
      gadget_detector_source.value = detector_source;
  
      return true;
     },
     
     statusLightsDisplay : function(){
      this.display('forwarded_request_statusLightsDisplay');
     },
     
     liveStatusDisplay : function(size){
      if(size == 'default'){
       size = 'large';         //Set default size to large..
      }
      this.setSize(size);
      this.display('forwarded_request_liveStatusDisplay');
     },
     
     chartsDisplay : function(size){
      if(size == 'default'){
       size = 'large';         //Set default size to large..
      }
      document.getElementById("hidden_customizeBut_size").value = size;
      var chusernosize   = document.getElementById("Charts_hidden_userNoSizeSelection");  // '#gadget_detector_source' is located here 1x @ createDash.php
      chusernosize.value = "no";
      this.setSize(size);     
      this.display('forwarded_request_chartsDisplay');
     },
     
     tablesDisplay : function(size){

      if(size == 'default'){
       size = 'large';         //Set default size to large..
      }
      document.getElementById("hidden_customizeBut_size").value = size;
      var tausernosize   = document.getElementById("Tables_hidden_userNoSizeSelection");  // '#gadget_detector_source' is located here 1x @ createDash.php
      tausernosize.value = "no";
      this.setSize(size);      
      this.display('forwarded_request_tablesDisplay');
     },
     
     alertsDisplay : function(){
      this.display('forwarded_request_alertsDisplay');
     },
     
     display : function(size){
        
        var _gadgetType_ = "";
        if(size == "forwarded_request_statusLightsDisplay"){
         _gadgetType_ = 'IdiotLights'; 
         size = 'large';                  
        }
        else if(size == "forwarded_request_liveStatusDisplay"){
         _gadgetType_ = 'LiveStatus'; 
         size = this.getSize();  
         //alert('size gotten was ' + size);                 
        }
        else if(size == "forwarded_request_chartsDisplay"){ 
        //size = 'large';
        size = document.getElementById("hidden_customizeBut_size").value;
         this.setSize(size); 
         return true;                 
        }
        else if(size == "forwarded_request_tablesDisplay"){  
        //size = 'large';
        size = document.getElementById("hidden_customizeBut_size").value;
         this.setSize(size); 
         return true;                 
        }
        else if(size == "forwarded_request_alertsDisplay"){
         _gadgetType_ = 'Alerts'; 
         size = 'small';                  
        }
        else if( size != "forwarded_request_statusLightsDisplay" ){
          _gadgetType_ = document.getElementById("gadgetType").value;
          //alert('display, _gadgetType_ is ' + _gadgetType_ );
        }
        
      
       //Abhinandan. Set Prefix (ie gadgetType)..
       var ul_customizeBut = this.getGadgetPrefix( _gadgetType_ );  //// HEAD..
        //alert('ul_customizeBut iss ' + ul_customizeBut);
       
        
       if( ul_customizeBut == 'ignore' )   //Abhinandan.  'ignore' is assigned for Charts.. see getGadgetPrefix().. Note: 'ignore' indicates that we should NOT invoke logic whenver user selects value from 'size' dropdown (inside 'dialog-form' FORM)..
        {
         alert('holla');
         return true;
        } 
       else if( (ul_customizeBut != 'ignore') && (size=='small' || size=='default' || size=='noUserSizeSelected') )  //Abhinandan., noUserSizeSelected referenced by dialog-form jquery 'next' button.. 
       {
        //alert('inside else if, size is ' + size); 
        ul_customizeBut.innerHTML = ""; //clear all li's from 'ul'..
         
        var li_customizeBut_1       = document.createElement("li");
            
            
            /* Abhinandan. Having scoping problems, statically written instead of passing document.getElementByid('gadgetType') as  2nd parameter to 'editGadget()'.. */
            //if( _gadgetType_.value == 'Alerts' ){
            if( _gadgetType_ == 'Alerts' ){ 
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"Alerts\")' title='Customize the Alerts item' ><span id='AlertsblockA'>+<br>Customize</span></a><input id='hAlerts-1' value='' type='hidden'/><input id='settingsAlerts-1' value='' type='hidden'/><input id='chosenColorSubset-Alerts-1' value='' type='hidden'/><input id='chosenColorSet-Alerts-1' value='' type='hidden'/><input id='chosenDataItem-Alerts-1' value='' type='hidden'/><input id='chosenShowValue-Alerts-1' value='' type='hidden'/><input id='userNoDataItemSelection-Alerts-1' value='yes' type='hidden'/>";
            
             var hidden_userNoSizeSelection = document.getElementById("Alerts_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                 
                 ul_customizeBut.appendChild(li_customizeBut_1);
            }
            //else if( _gadgetType_.value == 'Live_Status' ){
            else if( _gadgetType_ == 'LiveStatus' ){ 
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockA'>+<br>Customize</span></a><input id='hLiveStatus-1' value='' type='hidden'/><input id='settingsLiveStatus-1' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-1' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-1' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-1' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-1' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-1' value='yes' type='hidden'/>";
            
             var hidden_userNoSizeSelection = document.getElementById("LiveStatus_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                 
                 ul_customizeBut.appendChild(li_customizeBut_1);
            }
   
            this.setSize(size);  //Set hidden div, for future dynamic page sizing..
        
        
       }
       else if( (ul_customizeBut != 'ignore') && (size=='medium') )
       {
        //alert('inside else if, size is ' + size);
        ul_customizeBut.innerHTML = ""; //clear all li's from 'ul'..
       
        var li_customizeBut_1       = document.createElement("li");
        var li_customizeBut_2       = document.createElement("li");
        var li_customizeBut_3       = document.createElement("li");
        
            
            //else if( _gadgetType_.value == 'Live_Status' ){ //Dynamically render "Live_Status"..
            if( _gadgetType_ == 'LiveStatus' ){ 
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockA'>+<br>Customize</span></a><input id='hLiveStatus-1' value='' type='hidden'/><input id='settingsLiveStatus-1' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-1' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-1' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-1' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-1' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-1' value='yes' type='hidden'/>";
            
             li_customizeBut_2.className = "dash-order";
             li_customizeBut_2.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"2\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockB'>+<br>Customize</span></a><input id='hLiveStatus-2' value='' type='hidden'/><input id='settingsLiveStatus-2' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-2' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-2' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-2' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-2' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-2' value='yes' type='hidden'/>";
       
             li_customizeBut_3.className = "dash-order";
             li_customizeBut_3.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"3\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockC'>+<br>Customize</span></a><input id='hLiveStatus-3' value='' type='hidden'/><input id='settingsLiveStatus-3' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-3' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-3' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-3' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-3' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-3' value='yes' type='hidden'/>";
            
             var hidden_userNoSizeSelection = document.getElementById("LiveStatus_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                 //alert('hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
                
             ul_customizeBut.appendChild(li_customizeBut_1);
             ul_customizeBut.appendChild(li_customizeBut_2);
             ul_customizeBut.appendChild(li_customizeBut_3);
            
            }
            
           
            this.setSize(size);
            
       }
       else if( (ul_customizeBut != 'ignore') && (size=='large') )
       {
        //alert('inside else if, size is ' + size); 
        ul_customizeBut.innerHTML = ""; //clear all li's from 'ul'..
        
        //Declaring all the possible elements we Could have.. 
        var li_customizeBut_1       = document.createElement("li");
        var li_customizeBut_2       = document.createElement("li");
        var li_customizeBut_3       = document.createElement("li");
        var li_customizeBut_4       = document.createElement("li");
        var li_customizeBut_5       = document.createElement("li");
        var li_customizeBut_6       = document.createElement("li");
        var li_customizeBut_7       = document.createElement("li");
        var li_customizeBut_8       = document.createElement("li");
        var li_customizeBut_9       = document.createElement("li");
        var li_customizeBut_10      = document.createElement("li");
        
            
            //else if( _gadgetType_.value == 'Live_Status' ){ //Dynamically render "Live_Status"..
            if( _gadgetType_ == 'LiveStatus' ){ 
             //alert('inside _gadgetType_ is ' + _gadgetType_ );
             
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockA'>+<br>Customize</span></a><input id='hLiveStatus-1' value='' type='hidden'/><input id='settingsLiveStatus-1' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-1' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-1' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-1' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-1' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-1' value='yes' type='hidden'/>";
            
             li_customizeBut_2.className = "dash-order";
             li_customizeBut_2.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"2\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockB'>+<br>Customize</span></a><input id='hLiveStatus-2' value='' type='hidden'/><input id='settingsLiveStatus-2' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-2' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-2' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-2' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-2' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-2' value='yes' type='hidden'/>";
       
             li_customizeBut_3.className = "dash-order";
             li_customizeBut_3.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"3\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockC'>+<br>Customize</span></a><input id='hLiveStatus-3' value='' type='hidden'/><input id='settingsLiveStatus-3' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-3' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-3' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-3' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-3' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-3' value='yes' type='hidden'/>";
             
             li_customizeBut_4.className = "dash-order";
             li_customizeBut_4.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"4\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockD'>+<br>Customize</span></a><input id='hLiveStatus-4' value='' type='hidden'/><input id='settingsLiveStatus-4' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-4' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-4' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-4' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-4' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-4' value='yes' type='hidden'/>"; 
        
             li_customizeBut_5.className = "dash-order";
             li_customizeBut_5.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"5\",\"LiveStatus\")' title='Customize the Live Status item' ><span id='LiveStatusblockE'>+<br>Customize</span></a><input id='hLiveStatus-5' value='' type='hidden'/><input id='settingsLiveStatus-5' value='' type='hidden'/><input id='chosenColorSubset-LiveStatus-5' value='' type='hidden'/><input id='chosenColorSet-LiveStatus-5' value='' type='hidden'/><input id='chosenDataItem-LiveStatus-5' value='' type='hidden'/><input id='chosenShowValue-LiveStatus-5' value='' type='hidden'/><input id='userNoDataItemSelection-LiveStatus-5' value='yes' type='hidden'/>"; 
            
             var hidden_userNoSizeSelection = document.getElementById("LiveStatus_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                //alert('hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
                
             ul_customizeBut.appendChild(li_customizeBut_1);
             ul_customizeBut.appendChild(li_customizeBut_2);
             ul_customizeBut.appendChild(li_customizeBut_3);
             ul_customizeBut.appendChild(li_customizeBut_4);
             ul_customizeBut.appendChild(li_customizeBut_5);
            
            }
            
            
            //else if( _gadgetType_.value == 'IdiotLights' ){
            else if( _gadgetType_ == 'IdiotLights' ){ 
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockA'>+<br>Customize</span></a><input id='hIdiotLights-1' value='' type='hidden'/><input id='settingsIdiotLights-1' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-1' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-1' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-1' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-1' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-1' value='yes' type='hidden'/>";
            
             li_customizeBut_2.className = "dash-order";
             li_customizeBut_2.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"2\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockB'>+<br>Customize</span></a><input id='hIdiotLights-2' value='' type='hidden'/><input id='settingsIdiotLights-2' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-2' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-2' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-2' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-2' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-2' value='yes' type='hidden'/>";
       
             li_customizeBut_3.className = "dash-order";
             li_customizeBut_3.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"3\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockC'>+<br>Customize</span></a><input id='hIdiotLights-3' value='' type='hidden'/><input id='settingsIdiotLights-3' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-3' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-3' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-3' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-3' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-3' value='yes' type='hidden'/>";
             
             li_customizeBut_4.className = "dash-order";
             li_customizeBut_4.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"4\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockD'>+<br>Customize</span></a><input id='hIdiotLights-4' value='' type='hidden'/><input id='settingsIdiotLights-4' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-4' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-4' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-4' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-4' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-4' value='yes' type='hidden'/>"; 
        
             li_customizeBut_5.className = "dash-order";
             li_customizeBut_5.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"5\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockE'>+<br>Customize</span></a><input id='hIdiotLights-5' value='' type='hidden'/><input id='settingsIdiotLights-5' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-5' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-5' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-5' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-5' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-5' value='yes' type='hidden'/>"; 
             
             li_customizeBut_6.className = "dash-order";
             li_customizeBut_6.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"6\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockF'>+<br>Customize</span></a><input id='hIdiotLights-6' value='' type='hidden'/><input id='settingsIdiotLights-6' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-6' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-6' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-6' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-6' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-6' value='yes' type='hidden'/>";
             
             li_customizeBut_7.className = "dash-order";
             li_customizeBut_7.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"7\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockG'>+<br>Customize</span></a><input id='hIdiotLights-7' value='' type='hidden'/><input id='settingsIdiotLights-7' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-7' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-7' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-7' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-7' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-7' value='yes' type='hidden'/>";
             
             li_customizeBut_8.className = "dash-order";
             li_customizeBut_8.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"8\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockH'>+<br>Customize</span></a><input id='hIdiotLights-8' value='' type='hidden'/><input id='settingsIdiotLights-8' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-8' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-8' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-8' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-8' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-8' value='yes' type='hidden'/>";
             
             li_customizeBut_9.className = "dash-order";
             li_customizeBut_9.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"9\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockI'>+<br>Customize</span></a><input id='hIdiotLights-9' value='' type='hidden'/><input id='settingsIdiotLights-9' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-9' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-9' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-9' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-9' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-9' value='yes' type='hidden'/>";
             
             li_customizeBut_10.className = "dash-order";
             li_customizeBut_10.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love' href='#' onclick='editGadget(\"10\",\"IdiotLights\")' title='Customize the Lights item' ><span id='IdiotLightsblockJ'>+<br>Customize</span></a><input id='hIdiotLights-10' value='' type='hidden'/><input id='settingsIdiotLights-10' value='' type='hidden'/><input id='chosenColorSubset-IdiotLights-10' value='' type='hidden'/><input id='chosenColorSet-IdiotLights-10' value='' type='hidden'/><input id='chosenDataItem-IdiotLights-10' value='' type='hidden'/><input id='chosenShowValue-IdiotLights-10' value='' type='hidden'/><input id='userNoDataItemSelection-IdiotLights-10' value='yes' type='hidden'/>";
             
             
             var hidden_userNoSizeSelection = document.getElementById("IdiotLights_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                 
             ul_customizeBut.appendChild(li_customizeBut_1);
             ul_customizeBut.appendChild(li_customizeBut_2);
             ul_customizeBut.appendChild(li_customizeBut_3);
             ul_customizeBut.appendChild(li_customizeBut_4);
             ul_customizeBut.appendChild(li_customizeBut_5);
             ul_customizeBut.appendChild(li_customizeBut_6);
             ul_customizeBut.appendChild(li_customizeBut_7);
             ul_customizeBut.appendChild(li_customizeBut_8);
             ul_customizeBut.appendChild(li_customizeBut_9);
             ul_customizeBut.appendChild(li_customizeBut_10);
            }
            
            else if( _gadgetType_ == 'Charts' ){
             li_customizeBut_1.className = "dash-order";
             li_customizeBut_1.innerHTML = "<a class='button-gray ui-corner-all' data-icon-primary='love'  href='#' onclick='editGadget(\"1\",\"Charts\")' title='Customize the Charts item' ><span id='ChartsblockA'>+<br>Customize</span></a><input id='hCharts-1' value='' type='hidden'/><input id='settingsCharts-1' value='' type='hidden'/><input id='chosenColorSubset-Charts-1' value='' type='hidden'/><input id='chosenColorSet-Charts-1' value='' type='hidden'/><input id='chosenDataItem-Charts-1' value='' type='hidden'/><input id='chosenShowValue-Charts-1' value='' type='hidden'/><input id='userNoDataItemSelection-Charts-1' value='yes' type='hidden'/>";
            
             var hidden_userNoSizeSelection = document.getElementById("Charts_hidden_userNoSizeSelection");
                 hidden_userNoSizeSelection.value = "no";
                 
             ul_customizeBut.appendChild(li_customizeBut_1);
            }
            
        
        this.setSize(size);
        
        //Abhinandan. Go ahead and mark the user as having MADE a selection from 'size' dropdown box.
        
      
       }
        
     }//end display..
 }; //end customize buttons...




var test_object_A = {
                      actionable : function(){
                       return "actionable here";
                      }
   };
     
     
      
   $(function(){
   
   
   
   
      
  /* Abhinandan. Button Handlers */   
     $( "#addDiv" ).button().click(function(){
         
         
                                        var selected = $("#isLayoutSelected").val();
                                        
                                        if(selected=='yes')
                                            {
                                                $("#select-gadget" ).dialog( "open" );
                                            }
                                            else{
                                                 $("#select-layout-dialog").dialog("open");
                                            }
                                        //$("#select-layout-dialog").dialog("open");
                                     //$( "#select-gadget" ).dialog( "open" );
                                     //$( "#select-gadget" ).dialog( "open" );
                                     //$("#dialog-form-new").dialog( "open" ); 
                                  }
                             ); 
                                                    
      
    });  
    
    
    
    /* 
 *  Abhinandan, Jan 10th 2013..
 *   Purpose: For example in _statusGadget.php:
 *    i.)   ul id = Live_StatusgadgetColorList is unique 
 *    ii.)  Every gadget has its own unique 'ul'
 *    iii.) So we pass in dynamic @var 'static_gadgetType' 
 *          to reference that ie '_statusGadget.php' for which
 *          the color set changes (when the user selects value
 *          from drop-down )..
 *              
 *   Choice 1 = 3 color,
 *   Choice 2 = 5 color..
 *  Referenced by: _alertGadget.php  
 *   
 */ 
 var gadgetColors = {
     
     /*
     *  Method  fetchSetPoints()
     *   @param  static_gadgetType                      ie 'alert'      
     *   @param  whichBlock                             ie '1' -> '5' (depends on 'small' || 'medium' || 'large') ...
     *   @param  static_gadgetType_FirstUpper_singular  ie  'Alert'     
     *                                                       
     *   @return array  ie parsed array..     
     */               
     fetchSetPoints : function(static_gadgetType, whichBlock, static_gadgetType_FirstUpper_singular){
      //alert('fetchSetPoints(), static_gadgetType is ' + static_gadgetType);
      //alert('fetchSetPoints(), whichBlock is ' + whichBlock);
      
      
      /* LEGACY
      var chosenSetPoints = document.getElementById('edit-' + static_gadgetType + '-dialog-chosenSetPoints');
          chosenSetPoints = chosenSetPoints.value;
      */
      
      /* NEW Jan25th 2013.. */     // ie hAlert-1
      var chosenSetPoints_new = document.getElementById('h' + static_gadgetType_FirstUpper_singular + '-' + whichBlock);
          chosenSetPoints_new = chosenSetPoints_new.value;
          
      //alert('fetchSetPoints(), chosenSetPoints_new is' + chosenSetPoints_new);
              
          
      //alert('fetchSetPoints(), chosenSetPoints.value is ' + chosenSetPoints);
      
      //var chosenSetPoints_obj = $.parseJSON(chosenSetPoints);   //LEGACY
      
      var chosenSetPoints_obj = $.parseJSON(chosenSetPoints_new);  //NEW Jan25th 2013...
      console.log(chosenSetPoints_obj);
      
      return chosenSetPoints_obj;
      
     },
     
     /*
     *  Method  saveSetPoints()
     *   @Invokee                              ie  $("#edit-alert-dialog").dialog, "Save" button ...     
     *   @param  choice                        ie  3set || 5set
     *   @param  static_gadgetType             ie  'alert' 
     *   @param  static_gadgetType_UpperFirst  ie  'Alerts'   
     *   @param  chosenColorSubset             ie  '0' || '1' || '2' ...     
     *   
     *   @return string  serialized JSON   ie Collection of 'number => color' values..                
     */          
     saveSetPoints : function(set, static_gadgetType, chosenColorSubset, static_gadgetType_UpperFirst, default_or_original){
      //alert('saveSetPoints here!');
      //alert('set is ' + set + ', static_gadgetType is ' + static_gadgetType + ', chosenColorSubset is ' + chosenColorSubset + ', static_gadgetType_UpperFirst is ' + static_gadgetType_UpperFirst);
      
      var data_arr = [];
      
      if( default_or_original == 'original' )
      {    
       if(set == '3set')   //3set..
       {
        //alert('saveSetPoints(), set == 3set');
        var greenField  = document.getElementById(chosenColorSubset+ "_greenField");      //****LEFT OFF HERE.. need to assign a unique id, to tell WHICH customize block we are referring to... 
            greenField  = greenField.value;
           
        var orangeField = document.getElementById(chosenColorSubset+ "_orangeField");
            orangeField = orangeField.value;
           
        var redField    = document.getElementById(chosenColorSubset+ "_redField");
            redField    = redField.value;
           
        data_arr.push('"green":' + '"' + greenField + '"' );
        data_arr.push('"orange":' + '"' + orangeField + '"' );
        data_arr.push('"red":' + '"' + redField + '"' );
       
       
       
       }//end if 3set..
       else if(set == '5set')   //5set..
       {
        var greenField  = document.getElementById(chosenColorSubset+ "_greenField");
            greenField  = greenField.value;
           
        var orangeField = document.getElementById(chosenColorSubset+ "_orangeField");
            orangeField = orangeField.value;
           
        var redField    = document.getElementById(chosenColorSubset+ "_redField");
            redField    = redField.value;
           
        var blueField  = document.getElementById(chosenColorSubset+ "_blueField");
            blueField  = blueField.value;
           
        var grayField  = document.getElementById(chosenColorSubset+ "_grayField");
            grayField  = grayField.value;
           
        data_arr.push('"green":' + '"' + greenField + '"' );
        data_arr.push('"orange":' + '"' + orangeField + '"' );
        data_arr.push('"red":' + '"' + redField + '"' );
        data_arr.push('"blue":' + '"' + blueField + '"' );
        data_arr.push('"gray":' + '"' + grayField + '"' );
       
       }//end if 5set..
       
       /*
       *  Abhinandan.
       *   Save our array into JSON format.
       *   @return array back to invokee..            
       */            
       var data_str_start = '{';
       var data_str_end   = '}';
       var data_str_cont = '';
       for(var i=0; i<data_arr.length-1; ++i){
        data_str_cont += data_arr[i] + ',';
       }
        data_str_cont += data_arr[data_arr.length-1];  //Grab the last value from array manually, since we do not want the comma (', ') appended to our string..
        data_str_cont = data_str_start + data_str_cont + data_str_end;
        //alert('saveSetPoint, data_str_cont is ' + data_str_cont);
       
        //Abhinandan. Jan23rd: Willbe used for fetching back..
        //var obj    = $.parseJSON(data_str_cont);
        //alert('obj.orange is ' + obj.orange);
       
        /*
        //Abhinandan. Go ahead and mark hidden div as having "settings_saved" for future use (next time dialog opens it checks for "settings_saved" )..
        var loadFirstTime = document.getElementById('edit-' + static_gadgetType_UpperFirst + '-dialog-loadFirstTime');
        loadFirstTime.value = "settings_saved";
        */
       
        return data_str_cont;
       
      }   
      else if( default_or_original == 'default' )  //If user forgot to enter threshold values..
      {  
       //alert('inside default_or_original'); 
        data_arr.push('"green":' + '"1' + '"' );
        data_arr.push('"orange":' + '"2' + '"' );
        data_arr.push('"red":' + '"3' + '"' );
        
        var data_str_start = '{';
        var data_str_end   = '}';
        var data_str_cont = '';
        for(var i=0; i<data_arr.length-1; ++i){
         data_str_cont += data_arr[i] + ',';
        }
        data_str_cont += data_arr[data_arr.length-1];  //Grab the last value from array manually, since we do not want the comma (', ') appended to our string..
        data_str_cont = data_str_start + data_str_cont + data_str_end;
        
        return data_str_cont;
      }
      
      
       
     },
     
     /*
     *  Method  setShowValue()
     *   @param  showValue                            ie  'True' || 'False'
     *   @param  static_gadgetType                    ie  'Alert'
     *   @param  static_gadgetType_UpperFirst_plural  ie  'Alerts'        
     */          
     setShowValue : function(showValue, static_gadgetType, static_gadgetType_UpperFirst_plural){
           //alert('setShowValue, showValue is ' + showValue);
      var whichBlock = document.getElementById('edit-' + static_gadgetType_UpperFirst_plural + '-dialog-currentCustomizeBlock').value;
      
      var chosenShowValue = document.getElementById('chosenShowValue-' + static_gadgetType + '-' + whichBlock);
          
          chosenShowValue.value = showValue;
          if(chosenShowValue.value == 'true')
          {
           chosenShowValue.value = 'TRUE';
          }
          else if(chosenShowValue.value == 'false')
          {
           chosenShowValue.value = 'FALSE';
          }
          
      //alert('setShowValue, chosenShowValue.value is ' + chosenShowValue.value);
        
      return true;
     },
      
     
     /*
     *  Method: alternate() 
     *   @param  choice                                  ie  '0' || '1' || '2'     
     *   @param  static_gadgetType                       ie  'Alerts'
     *   @param  static_gadgetType_FirstLower_singular   ie 'Alerts' 
     *   @param  static_gadgetType_FirstUpper_singular   ie 'Alerts'         
     */           
     alternate : function(choice, static_gadgetType, static_gadgetType_FirstLower_singular, static_gadgetType_FirstUpper_singular ){
      //alert('inside alternate');
      /* Jan 25th 2013.. NEW */
      var whichBlock = document.getElementById('edit-' + static_gadgetType + '-dialog-currentCustomizeBlock');
          whichBlock = whichBlock.value;
       //alert('alternate(), whichBlock is ' + whichBlock + '');    
  
      if(choice==0)  //3set chosen.. jQuery dialog load for first time @ 'choice' = 0..
      {
       //alert('choice is ' + choice);
       var ul = document.getElementById(static_gadgetType + "gadgetColorList");   //Abhinandan: Jan15th 2013..
       ul.innerHTML = ""; //clear all li's from 'ul'.. 
       
       var greenli = document.createElement("li");
       greenli.className = "dash-order isotope-item extrasm";
       greenli.innerHTML = "<a class='small button-green' href='javascript:void(0)'> </a><br/><input id='0_greenField' type='text' size='1' value='' />"; 
       
       var orangeli = document.createElement("li");
       orangeli.className = "dash-order isotope-item extrasm";
       orangeli.innerHTML = "<a class='small button-orange' href='javascript:void(0)'></a><br/><input id='0_orangeField' type='text' size='1' value='' />";
       
       var redli  = document.createElement("li");
       redli.className = "dash-order isotope-item extrasm";
       redli.innerHTML = "<a class='small button-red' href='javascript:void(0)'></a><br/><input id='0_redField' type='text' size='1' value='' />";    
       
       ul.appendChild(greenli);
       ul.appendChild(orangeli);
       ul.appendChild(redli);
       
       this.setChosenColor(choice, static_gadgetType_FirstLower_singular, whichBlock, static_gadgetType_FirstUpper_singular); 
         
      }
      else if(choice==1) //3set chosen.. 
      {
       //alert('choice is ' + choice);
       var ul = document.getElementById(static_gadgetType + "gadgetColorList");   //Abhinandan: Jan15th 2013..
       ul.innerHTML = ""; //clear all li's from 'ul'.. 
       
       var greenli = document.createElement("li");
       greenli.className = "dash-order isotope-item extrasm";
       greenli.innerHTML = "<a class='small button-green' href='javascript:void(0)'> </a><br/><input id='1_greenField' type='text' size='1' value='' />"; 
       
       var orangeli = document.createElement("li");
       orangeli.className = "dash-order isotope-item extrasm";
       orangeli.innerHTML = "<a class='small button-orange' href='javascript:void(0)'></a><br/><input id='1_orangeField' type='text' size='1' value='' />";
       
       var redli  = document.createElement("li");
       redli.className = "dash-order isotope-item extrasm";
       redli.innerHTML = "<a class='small button-red' href='javascript:void(0)'></a><br/><input id='1_redField' type='text' size='1' value='' />";    
       
       ul.appendChild(greenli);
       ul.appendChild(orangeli);
       ul.appendChild(redli);
       
       this.setChosenColor(choice, static_gadgetType_FirstLower_singular, whichBlock, static_gadgetType_FirstUpper_singular);
      }
      else if(choice==2)  //5set chosen..
      {
       //alert('choice is ' + choice);
       var ul = document.getElementById(static_gadgetType + "gadgetColorList");   //Abhinandan: Jan15th 2013..
       ul.innerHTML = ""; //clear all li's from 'ul'..
       
       var greenli = document.createElement("li");
       greenli.className = "dash-order isotope-item extrasm";
       greenli.innerHTML = "<a class='small button-green' href='javascript:void(0)'> </a><br/><input id='2_greenField' type='text' size='1' value='' />"; 
       
       var orangeli = document.createElement("li");
       orangeli.className = "dash-order isotope-item extrasm";
       orangeli.innerHTML = "<a class='small button-orange' href='javascript:void(0)'></a><br/><input id='2_orangeField' type='text' size='1' value='' />";
       
       var redli  = document.createElement("li");
       redli.className = "dash-order isotope-item extrasm";
       redli.innerHTML = "<a class='small button-red' href='javascript:void(0)'></a><br/><input id='2_redField' type='text' size='1' value='' />";    
       
       var blueli = document.createElement("li");
       blueli.className = "dash-order isotope-item extrasm";
       blueli.innerHTML = "<a class='small button-blue' href='javascript:void(0)'></a><br/><input id='2_blueField' type='text' size='1' value='' />"
       
       var grayli = document.createElement("li");
       grayli.className = "dash-order isotope-item extrasm";
       grayli.innerHTML = "<a class='small button-gray' href='javascript:void(0)'></a><br/><input id='2_grayField' type='text' size='1' value='' />";
       
       ul.appendChild(greenli);
       ul.appendChild(orangeli);
       ul.appendChild(redli);
       ul.appendChild(blueli);
       ul.appendChild(grayli);
       
       this.setChosenColor(choice, static_gadgetType_FirstLower_singular, whichBlock, static_gadgetType_FirstUpper_singular);
      }
      
      //Show "saved" values back to user, dynamic to each 'Customize block' ...check if "settings_saved" or "settings_clean" doesn't matter because when the above 'if' gets loaded, it wipes out pre-existing values for the color/values pair.. 
      var loadFirstTime = document.getElementById('edit-' + static_gadgetType + '-dialog-loadFirstTime');
          loadFirstTime = loadFirstTime.value;
       //alert('loadFirstTime is ' + loadFirstTime);  
          
      /* Jan 25th 2013 : NEW.. */
      var loadFirstTime_new = document.getElementById('settings' + static_gadgetType_FirstUpper_singular + '-' + whichBlock); //FIX HERE!!! 
          loadFirstTime_new = loadFirstTime_new.value;
        //alert('loadFirstTime_new is ' + loadFirstTime_new);
      
      /*  LEGACY  
      var chosenColor = document.getElementById('edit-' + static_gadgetType_FirstLower_singular + '-dialog-chosenColorSet');
          chosenColor = chosenColor.value;   //ie 3set or 5set..       
      */
      
      
      //NEW Jan25th 2013..
      var chosenColor = document.getElementById('chosenColorSet-' + static_gadgetType_FirstUpper_singular + '-' + whichBlock);
          chosenColor = chosenColor.value;  //ie 3set or 5set..
        //alert('chosenColor is ' + chosenColor);
      
      
      //NEW Jan25th 2013..
      //if(loadFirstTime == "settings_saved")   //Only wish to own the parsed array, NOT the serialized array.. 
      if(loadFirstTime_new == "settings_saved")
      {
       //alert('loadFirstTime_new is ' + loadFirstTime_new);
       
       //chosenSetPoints_obj = this.fetchSetPoints(static_gadgetType_FirstLower_singular);  //LEGACY..
       chosenSetPoints_obj = this.fetchSetPoints(static_gadgetType_FirstLower_singular, whichBlock, static_gadgetType_FirstUpper_singular);   //NEW Jan25th 2013..
       
       console.log(chosenSetPoints_obj);
       
       if('green' in chosenSetPoints_obj)
       {
        var fillGreen = document.getElementById(choice + "_greenField");
            fillGreen.value = chosenSetPoints_obj.green;
       }
        
       if('orange' in chosenSetPoints_obj)
       {
        var fillOrange = document.getElementById(choice + "_orangeField");
            fillOrange.value = chosenSetPoints_obj.orange;
       }    
       
       if('red' in chosenSetPoints_obj)
       {
        var fillRed = document.getElementById(choice + "_redField");
            fillRed.value = chosenSetPoints_obj.red;
       }    
                                                                         /*************FIX HERE!!! ***////
       if('blue' in chosenSetPoints_obj && (chosenColor == '5set') )    //Abhinandan. Jan25th: Check to see if '5set' , without this it was throwing a null error..
       {
        var fillBlue = document.getElementById(choice + "_blueField");
            fillBlue.value = chosenSetPoints_obj.blue;
       }
       
       if('gray' in chosenSetPoints_obj && (chosenColor == '5set') )    //Abhinandan. Jan25th: Check to see if '5set' , without this it was throwing a null error..
       {
        var fillGray = document.getElementById(choice + "_grayField");
            fillGray.value = chosenSetPoints_obj.gray;
       }
                
      }
       
     },    //comma goes here..
     
     
     /*
     *  Method:  chooseItem()
     *   @param  static_gadgetType  ie 'alert'    
     *   @param  dropdown           ie 'element'
     *   
     *   @REF:  For html markup, please reference '_alertGadget.php'  ..          
     *   
     *   @var whichElement  ie  Element 1 (The currently selected element text)..          
     */          
     chooseItem : function(static_gadgetType, dropdown){
      //alert('chooseItem here');
      var default_dataItem = 'Choose element';   //IMPORTANT: case sensitive.
      var chosenDataItem = document.getElementById('edit-' + static_gadgetType + '-dialog-chosenDataItem');
      if(chosenDataItem && chosenDataItem.value != "")
      {
       //alert("chosenDataItem.value is " + chosenDataItem.value);
        var whichElement = $('#' + static_gadgetType + '-form-input .' + static_gadgetType + 'dataItems').children("[selected]").text();
        //alert('The current whichElement is ' + whichElement);
           
      }
      else if(chosenDataItem && chosenDataItem.value == "")   //If the selection has not been saved, reset it back to 'Chose Element'..
      {
       //var whichElement = $('#alerts-form-input .alertdataItems').children("[selected]").text();   
       var whichElement = $('#' + static_gadgetType + '-form-input .' + static_gadgetType + 'dataItems').children("[selected]").text();
       var whichElementDD = document.getElementById(static_gadgetType + '_' + dropdown + '_dataItems');
       
        if(whichElement != default_dataItem)
        {
         //alert('prealpha, whichElementDD.selectedIndex = ' + whichElementDD.selectedIndex);
         //alert('alpha, whichElement is ' + whichElement + ', default_dataItem is ' + default_dataItem);
         for(var i=0; i<whichElementDD.options.length; ++i){
          //alert('i is ' + i + ', whichElementDD.options.length is ' + whichElementDD.options.length);
          //alert(whichElementDD.options[i].text);
          if(whichElementDD.options[i].text == default_dataItem)
          {
           //alert('bravo, ' + whichElementDD.options[i].text + ' = ' + default_dataItem);
           whichElementDD.selectedIndex = i;
           //alert( 'whichElementDD.selectedIndex equals ' + i);
           //alert( 'whichElementDD.selectedIndex equals ' + whichElementDD.selectedIndex);
           
           
           //whichElementDD.innerHTML = "";
           
           break;
          }
         } //end for..
        } //end if the current whichElement is different from our normally default selected whichElement (ie 'Element 1'  !=  'Chose Element' )
      } //end else if..
      
      return true;
     },        //comma here..
     
     
     /*
     *  @param dataItem                               ie 'Element 1'
     *  @param static_gadgetType_lowercase            ie 'alert' 
     *  @param static_gadgetType_UpperFirst_singular  ie 'Alert' 
     *  @param static_gadgetType_UpperFirst_plural    ie 'Alerts'             
     */     
     setChosenDataItem : function(dataItem, static_gadgetType_lowercase, static_gadgetType_UpperFirst_singular, static_gadgetType_UpperFirst_plural){
      //alert('setChosenDataItem, dataItem is ' + dataItem + ', static_gadgetType_lowercase is ' + static_gadgetType_lowercase);
      
      //Current 'Customize Button' the user is working setting properties on..
      var whichBlock = document.getElementById('edit-' + static_gadgetType_UpperFirst_plural + '-dialog-currentCustomizeBlock');
          whichBlock = whichBlock.value;
      
      //Abhinandan. Define the dataItem (ie Element 1) for the specific 'Customize' Block ...
      var chosenDataItem = document.getElementById('chosenDataItem-' + static_gadgetType_UpperFirst_singular + '-' + whichBlock);  
          chosenDataItem.value = dataItem;
            
      //alert('chosenDataItem.value is ' + chosenDataItem.value);
      
      
      //**** Jan26th: Might have to re-define the element here...............
      //Abhinandan. Then indicate that the user DID make a selection..
      
      //var hidden_userNoDataItemSelection = document.getElementById(static_gadgetType_lowercase + "hidden_userNoDataItemSelection");
       var hidden_userNoDataItemSelection = document.getElementById('userNoDataItemSelection-' + static_gadgetType_UpperFirst_singular + '-' + whichBlock); 
       hidden_userNoDataItemSelection.value = "no";
      
       
       
     },  //comma here..
     
     
     
     /*
     *  Method setChosenColor()
     *  @Invokee                                          gadgetColors.alternate()  ...  
     *  @param   choice                                  ie '0' || '1' || '2' 
     *  @param   static_gadgetType_FirstLower_singular   ie  'alert'         
     *
     */          
     setChosenColor : function(choice, static_gadgetType_FirstLower_singular, whichBlock, static_gadgetType_FirstUpper_singular){
      //alert('setChosenColor here, choice is ' + choice);
      
      var flavor = '';
      if( (choice == '1') || (choice == '0') )
      {
       flavor = '3set';
      }
      else if(choice == '2')
      {
       flavor = '5set';
      }
      
       
      
      /*  LEGACY
      var chosenColor = document.getElementById('edit-' + static_gadgetType_FirstLower_singular + '-dialog-chosenColorSet');
      chosenColor.value = flavor;
      */
      
      
      //NEW Jan25th 2013..
      var chosenColor = document.getElementById('chosenColorSet-' + static_gadgetType_FirstUpper_singular + '-' + whichBlock);
          chosenColor.value = flavor;
        //alert('inside setChosenColor(), chosenColor.value is ' + chosenColor.value);
      
      /* LEGACY
      var chosenColorSubset = document.getElementById('edit-' + static_gadgetType_FirstLower_singular + '-dialog-chosenColorSubset');
      chosenColorSubset.value = choice;
      */
      
      //NEW Jan25th 2013..
      var chosenColorSubset = document.getElementById('chosenColorSubset-' + static_gadgetType_FirstUpper_singular + '-' + whichBlock);
          chosenColorSubset.value = choice;
        //alert('inside setChosenColor(), chosenColorSubset.value is ' + chosenColorSubset.value);
      
      return true;
     }
 };
 
 
 
 
 
 
 
 /*
 *  Object  gadgetChart
 *   Invokee @Form  Charts-dialog-form ( _chartGadget.php ) 
 */  
  var gadgetChart = {
      storeChartType : function(chartType, hidden_id){
        var hidden_id = document.getElementById(hidden_id);
            hidden_id.value = chartType;
        alert('gadgetChart, storeChartType, hidden_id.value is' + hidden_id.value);
      },
      
      storeXAxis : function(XAxis, hidden_id){
        var hidden_id = document.getElementById(hidden_id);
            hidden_id.value = XAxis;
        alert('gadgetChart, storeXAxis, hidden_id.value is ' + hidden_id.value);
      },
      
      storeYAxis : function(YAxis, hidden_id){
        var hidden_id = document.getElementById(hidden_id);
            hidden_id.value = YAxis;  
        alert('gadgetChart, storeYAxis, hidden_id.value is ' + hidden_id.value);
      },
      
      storeChooseItems : function(ChooseItems, hidden_id){
        var hidden_id = document.getElementById(hidden_id);
            hidden_id.value = ChooseItems;
       alert('gadgetChart, storeChooseItems, hidden_id.value is ' + hidden_id.value);
      },
      
      //Invoked by jquery 'Charts-pre-dialog-form'
      storeDetectorSource : function(detectorSource, hidden_id){
       var storedDetectorSource = document.getElementById(hidden_id);
           storedDetectorSource.value = detectorSource;
           
       alert('gadgetChart, storedDetectorSource.value is ' + storedDetectorSource.value);
           
      },
                   
      storeDataSource : function(dataSource, hidden_id){
       var storedDataSource = document.getElementById(hidden_id);
           storedDataSource.value = dataSource;
           
       alert('gadgetChart, storedDataSource.value is ' + storedDataSource.value);
      }
      //End invoked..
  };
  
  
  /*
  *  Object  gadgetTable
  *   Invokee @Form  Table-pre-dialog-form ( _tableGadget.php ) 
  */  
  var gadgetTable = {
    //Invoked by jquery 'Table-pre-dialog-form'
    storeDetectorSource : function(detectorSource, hidden_id){
      var storedDetectorSource = document.getElementById(hidden_id);
          storedDetectorSource.value = detectorSource;
           
      alert('gadgetTable, storedDetectorSource.value is ' + storedDetectorSource.value);
           
    },
                   
    storeDataSource : function(dataSource, hidden_id){
      var storedDataSource = document.getElementById(hidden_id);
          storedDataSource.value = dataSource;
           
      alert('gadgetTable, storedDataSource.value is ' + storedDataSource.value);
    }
      //End invoked..
  };
  
  $.curCSS = function (element, attrib, val) {
    $(element).css(attrib, val);
};