(function($, undefined) {
    $.fn.dashbrd = function(params)
    {
        if(!params.autoSave)
        {
            $( "#dash-column td").sortable({
                opacity: 0.8,
                connectWith: "#dash-column td"
            });
        }
        else
        {
         //alert('inside dashboard.js');
            $( "#dash-column td").sortable({
                connectWith: "#dash-column td",
                opacity: 0.8,
                
                stop: function(){
                                 var serializedObj = document.getElementById('fetchLayoutGadgets_tempArr').value; 
                                 var jobject       = JSON.parse( serializedObj );
                                  //console.log(jobject);
                                 var result        = new Array();
                                 var widgetWidth   = new Array();   //Abhinandan. new..
                                 var widStringVal  = new Array();   //Abhinandan. new..
                   
                                 var i = 0;
                                 var j = 0;
                    
                                 var widString_obj = {};
                    
                                 $('#dash-column td').each(function()
                                 {
                                  
                                  result[i++] = $(this).sortable('toArray');    //Returns a serialized array, for the items nested within the 'dash-column td' container..
                                  console.log(result);       //result is: [ [Alerts_1010], [Alerts_1011] ]
                                  //widString_obj[result] = document.getElementById(result + '_Hid').value; 
                                  var test = document.getElementById(result + '_Hid');
                                   //console.log(test.value);
                                 });
                    
                    //console.log('wikkens');
                    //console.log(widString_obj);
                   
                     
                     //WORKING..legacy..
                    /*
                    var widString_obj = {};
                    var Live_Status = document.getElementById('Live_Status_Hid');
                        widString_obj['Live_Status'] = Live_Status.value;
                        
                    var Charts      = document.getElementById('Charts_Hid');
                        widString_obj['Charts']      = Charts.value;
                        
                    var Alerts      = document.getElementById('Alerts_Hid');
                        widString_obj['Alerts']      = Alerts.value;
                        
                    var Meter_Gauge = document.getElementById('Meter_Gauge_Hid');   
                        widString_obj['Meter_Gauge'] = Meter_Gauge.value;
                        
                    var System_Messages = document.getElementById('System_Messages_Hid');
                        widString_obj['System_Messages'] = System_Messages.value; 
                        
                    var AlarmBar        = document.getElementById('AlarmBar_Hid');
                        widString_obj['AlarmBar']        = AlarmBar.value;
                        
                    var IdiotLights     = document.getElementById('IdiotLights_Hid');  
                        widString_obj['IdiotLights']     = IdiotLights.value;
                    
                    */     
           
                   /*
                    var widStringVal = ''; 
                    for(var k1 in widString_obj){
                     widStringVal += k1 + ":" + widString_obj[k1] + ";"; 
                    }  
                    
                 
                    
                    //console.log(result);
                    //console.log(widStringVal);        
                    //console.log(--i);
                    
                    
                    //debug post parameters:
                   //  var result = 'debug_result';
                   //  var widStringVal = 'debug_widStringVal';
                   //  var i = 5;
                     
                     console.log(params.saveUrl);
                    $.post(
                     params.saveUrl, 
                     {
                      columnsCount: --i,
                      widgetsPos: result,
                      widString: widStringVal  
                     },
                     function(data)
                     {
                      //alert('data is ' + data);
                     } 
                    );
                    return true;
                  */
                  
                  
                  $.post(
                     params.saveUrl, 
                     {
                      result: result  
                     },
                     function(msg)
                     {
                      alert(msg);
                     } 
                    );
                    return true;
               
                } //end stop function()..
                
                
            });   //end sortable widget..
            
        }

        $( ".dash-column").disableSelection();

        // Expand All Portlets
        $('#all_expand').click(function()
        {
            $( "#dashboard .ui-sortable .ui-widget-header .ui-icon" ).removeClass( "ui-icon-circle-plus" ).addClass( "ui-icon-circle-minus" );
            $( "#dashboard .ui-sortable .ui-widget-header .ui-icon" ).parents( ".portlet" ).find( "#dashboard .ui-sortable .ui-corner-bottom" ).show();
        }
        );

        // Collapse All Portlets
        $('#all_collapse').click(function()
        {
            $( "#dashboard .ui-sortable .ui-widget-header .ui-icon" ).removeClass( "ui-icon-circle-minus" ).addClass( "ui-icon-circle-plus" );
            $( "#dashboard .ui-sortable .ui-widget-header .ui-icon" ).parents( ".portlet" ).find( "#dashboard .ui-sortable .ui-corner-bottom" ).hide();
        }
        );

        // Open All Portlets
        $('#all_open').click(function()
        {
            $('#dashboard').show();
            $('#all_open:visible').hide();
            $('#all_close:hidden').show();

            $('#all_open').hide();
            $('#all_close').show();
        }
        );

        // Close All Portlets
        $('#all_close').click(function()
        {
            $('#dashboard').hide();
            $('#all_close:visible').hide();
            $('#all_open:hidden').show();

            $('#all_close').hide();
            $('#all_open').show();
        }
        );

        $('#all_save').click(function()
        {
           var result = new Array(),
               widgetWidth = new Array(),
               widStringVal = new Array(),
               i = 0;
           	   j = 0;
            $('#dash-column td').each(function()
            {
                result[i++] = $(this).sortable('toArray');
            });
            
            //widgetWidth = $("input:hidden").serializeArray();
            widgetWidth = $("#divHolder input:hidden").serializeArray();    //Abhinandan. ref 'Helios_Jan_4'
            jQuery.each(widgetWidth, function(j, field){
            	widStringVal += field.name + ":" + field.value + ";";
              });            

            $.post(params.saveUrl, {
                widgetsPos: result,
                widString: widStringVal,
                columnsCount: --i
                },
                function(data){
       	 			                       

                    $('#msgSave').show('slow').delay(1500).hide('slow');
                }
            );
            return false;
        }
        );
    }
	
  														
	var counterValue = parseInt($('.bubble').html());
	function removeAnimation(){
		setTimeout(function() {
			$('.bubble').removeClass('animating');
		}, 1000);			
	}

	function animatebubble(){
		counterValue;
		$('.bubble').html(counterValue).addClass('animating');
		removeAnimation();
	}	
    
	$("#notifTrig").click(function(e) {
		$("#notifTrigUl").show();
	    e.preventDefault();	
	    animatebubble();	
	});
  

  /*   //Abhinandan. : Some of the following code below (not sure which yet) is responsible for showing the drop-down items..
	mainNav = $('#bodyLeftMenu>li');
	
  mainNav.find('ul').siblings().addClass('hasUl').append('<span class="hasDrop icon16 ui-icon ui-icon-arrowthick-1-s" />');
	
  mainNavLink = mainNav.find('a').not('.subUlList a');
	
  mainNavLinkAll = mainNav.find('a');
	
  mainNavSubLink = mainNav.find('.subUlList a').not('.subUlList li .subUlList a');
	
  mainNavCurrent = mainNav.find('a.current');


	//hover magic add blue color to icons when hover - remove or change the class if not you like.
	
	mainNavLinkAll.hover(
	  function () {
	    $(this).find('span.icon16').addClass('blue');
	  }, 
	  function () {
	    $(this).find('span.icon16').removeClass('blue');
	  }
	);
	

	//click magic
	mainNavLink.click(function(event) {
		$this = $(this);
		if($this.hasClass('hasUl')) {
			event.preventDefault();
			if($this.hasClass('drop')) {
				$(this).siblings('ul.subUlList').slideUp(500).siblings().removeClass('drop');
			} else {
				$(this).siblings('ul.subUlList').slideDown(500).siblings().addClass('drop');
			}			
		} else {
			//has no ul so store a cookie for change class.
			//alert
		}
	});

  
	$(".hasDrop").hover(function(e) {
		return false;
	});
	
	*/
	
	
})(jQuery);
