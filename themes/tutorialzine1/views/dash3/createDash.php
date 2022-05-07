  <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/views/dash/dashCreate_logic.js"></script>
  <script type="text/javascript">
   var basePath = '<?php echo Yii::app()->baseUrl; ?>';  //Used by 'dashCreate_logic.js, customizeButtons.setDetectorSource()';
  </script>

<section class="main-section grid_8">
 <nav class="">
   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
  <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
 </nav>

 <div class="main-content">
  <header>
	<ul class="action-buttons clearfix">
		<li><a href="<?php echo Yii::app()->baseUrl;?>/manager/admin" class="button ui-state-highlight" data-icon-primary="ui-icon-person" ><?php echo Yii::t('Dashboard', 'Administrator')?></a></li>
	</ul>
	    <h2 id="layout-title"><?php echo Yii::t('Dashboard', 'Create/Update Layouts') ?></h2>
    <p>
		<?php echo Yii::t('Dashboard', 'Create, Update and Delete layout settings using this page. Please note only admins can delete layouts') ?>.
    </p>
    <br/>
  </header>
  <section class="container_6 clearfix">
   <div class="grid_6">
	<br/>
    <div class="portlet ui-widget ui-widget-content ui-corner-all ">
     <header class="ui-widget-header ui-corner-top">
			<h2><?php echo Yii::t('Dashboard', 'Layout Settings') ?></h2>
		 </header>
     <section class="ui-widget-content ui-corner-bottom">
      <div class="clearfix">

       <div style="float:left;width:50%;">
	<span style="width:150px;"><?php echo Yii::t('Dashboard','Create a new layout')?> :</span>
	 <input type="hidden" id="addNewLayout_btn_click" value="false" />
		  <button class="button" id="addNewLayout"><?php echo Yii::t('Dashboard', 'New layout')?> </button>
		  <button class="button" id="addNewGadget" name="addNewGadget">+ <?php echo Yii::t('Dashboard', 'Gadget')?></button>
		<input id="addNewGadget_hidden" type="hidden" value="hide" />
		</div>

       <div style="float:left;width:50%;">
				<span style="width:150px;"><?php echo Yii::t('Dashboard', 'Update/Switch layout') ?>:</span>

	 <?php
				if (isset($layouts)) {
	   $list = CHtml::listData($layouts, 'lay_id', 'subname');
	   echo CHtml::dropDownList('layout', $category=0, $list, array(
									'empty'    => 'Select a Layout',
									'onchange' =>'selectLayout("default")',
									'id'       => 'eLayouts1')
									);
	  } //end if..
	 ?>

       </div>

	  <section class="container_6 clearfix">

	  </section>



	  <?php
		/*Ranga Language Translation 4-9-2014
	    $translate=Yii::app()->translate;
	    //in your layout add
	    echo $translate->dropdown();
	    echo $translate->editLink('Edit translations page');
	    //link to the page where you check for all unstranslated messages of the system
	    echo $translate->missingLink('Missing translations page');
	    */


	  ?>


      </div>
     </section>    <!-- End  ui-widget-content ui-corner-bottom -->
    </div>  <!-- End   portlet ui-widget ui-widget-content ui-corner-all -->


    <!-- Feb22nd 2013: Where we want to show the gadgets when a specific layout is selected.. -->
    <div class="clearfix"><br/>
	<input type="hidden" name="layoutButtonsVals" id="layoutButtonsVals" value="0" />
	</div>
		<div class="portlet ui-widget ui-widget-content ui-corner-all ">
		 <header class="ui-widget-header ui-corner-top" id="buttonsHolder">
			<h2 id="layout_workshop_h2"> <?php echo Yii::t('Dashboard', 'Layout Workshop')?>
			 <div id="layoutbuttons" style="float:right;display:none;">
				<button class="button ui-button ui-button-text-icon-primary" role="button" aria-disabled="false" id="addDiv" title="<?php echo Yii::t('Dashboard', 'Add Gadget')?>" data-icon-primary="ui-icon-plus">
				 <span class="ui-button-icon-primary ui-icon ui-icon-plus"></span><span class="ui-button-text" id="addDivBut"><?php echo Yii::t('Dashboard', 'Add Gadget')?></span>
				</button>
				<button onclick="saveLayoutGadget()" class="button ui-button ui-button-text-icon-primary" role="button" aria-disabled="false" id="all_saveb" title="<?php echo Yii::t('Dashboard', 'Save state')?>" data-icon-primary="ui-icon-disk">
				 <span class="ui-button-icon-primary ui-icon ui-icon-disk icon-book"></span>
				    <span class="ui-button-text" id="all_save" onclick="saveLayoutGadget()"><?php echo Yii::t('Dashboard', 'Save') ?></span>
				</button>
			 </div>
			</h2>	 <!-- end layout_workshop_h2 -->
		 </header>
		 <section class="ui-widget-content ui-corner-bottom">

      <!-- Layout settings main window -->
		  <div class="clearfix" id="shadedworkshop_parent">
		   <div class="shaded" id="shadedworkshop">
			<img id="nolayoutloaded" class="noimgshaded" alt="No Layout loaded" />
		</div>

		   <!-- shaded -->
		   <div id='dashboard' class="sortable">
			  <!-- <div class="clearfix"><br/></div> -->
				 <table id="dash-column" style="width:100%;">
				  <tr>
					 <td id="divHolder" style="vertical-align: top; width:100%; padding-top:10px"></td>
				  </tr>
				 </table>
			  </div>  <!-- end clearfix div -->

	<!-- dashboard -->
			 </div>

			 <!-- Layout settings main window -->
		 </section>
		</div>  <!-- end portlet ui-widget ui-widget-content ui-corner-all -->


		<!-- Abhinandan Feb22nd 2013: The rendered gadgets for each layout should go inside here.. -->
    <div class="grid_5" id="portlet-pane-2">
		 <div class="grid_5"></div>
	  </div><!-- End  grid_5 #portlet-pane-2, Layout Content -->
   </div>  <!-- end grid_6 leading -->
  </section> <!-- End outter  container_6 clearfix  -->

 </div>  <!-- end main-content -->


 <!-- New Layout -->
  <div id="dialog-form-new" title="Create a New Layout">
   <section class="clearfix">

     <h5><?php echo Yii::t('Dashboard', 'new_layout_msg')?></h5>
	 <div class="grid_8">
		<div class="portlet">
			<form class="form has-validation" >
				<div class="clear"></div>
				<div class="clearfix">
					<label for="form-gadgetName" class="form-label">
						<?php echo Yii::t('Dashboard', 'Layout Name')?><em>*</em>
						<small><?php echo Yii::t('Dashboard', 'The name of the Template')?>.</small>
					 </label>
					 <div class="form-input">
						<input type="text" id="layoutName" name="layoutName" maxlength="50" value="" />
						<input type="hidden" id="userId" value="">
						<input type="hidden" id="layoutId" value="">
						<input type="hidden" id="gadgetDataId" value="">
					 </div>
				</div>
				<div id="ajaxLoadSuccess"></div>
				<div class="clear"></div>
				<div class="clear"><br/></div>
			</form>
		</div>
   </div>
  </section>
 </div>


 <!-- Select a Gadget -->
 <!-- Abhinandan. To fix the pictures, goto "tutorialzine1/css/cu_style.css" -->
 <div id="select-gadget" title="Select A Gadget">
	<h5><?php echo Yii::t('Dashboard', "Let's start with giving a name to this new layout") ?>.</h5>

  <ul class="isotope-contacts clearfix">
   <li class="button ui-corner-all index-p" onclick="selectGadget('Alerts')" data-id="66f6d7ff16d37e3bde9643358c98cfe1">
    <div class="photo alerts"><div></div></div>
		<div class="fullname"><?php echo Yii::t('Dashboard', 'ALERT') ?> </div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Add an alert for') ?></div>
		<div class="email"><?php echo Yii::t('Dashboard', 'custom alert') ?></div>
		<div class="bday"><?php echo Yii::t('Dashboard', 'notifications') ?>.</div>
   </li>

   <li class="button ui-corner-all index-a" onclick="selectGadget('IdiotLights')"data-id="0e0678531c72bfefd18ec2eba8cb3ff7">
    <div class="photo lights" >
     <div></div>
    </div>
    <div class="fullname"><?php echo Yii::t('Dashboard', 'LIGHTS')?> </div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Easy-to-show lights') ?></div>
		<div class="email"><?php echo Yii::t('Dashboard', 'can better monitor') ?></div>
		<div class="bday"><?php echo Yii::t('Dashboard', 'system settings') ?>.</div>
   </li>

   <li class="button ui-corner-all index-b" onclick="selectGadget('LiveStatus')" data-id="b3869c81ff2c12d0be71b0bcecf70fc4">
    <div class="photo livestats" >
     <div></div>
    </div>
    <div class="fullname"><?php echo Yii::t('Dashboard', 'LIGHTS')?> </div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Keep an eye on elemental') ?></div>
		<div class="email"><?php echo Yii::t('Dashboard', 'percentages, averages,') ?></div>
		<div class="bday"><?php echo Yii::t('Dashboard', 'and real-time statistics') ?>.</div>
   </li>

   <li class="button ui-corner-all index-p" onclick="selectGadget('Charts')" data-id="fac966a9a5a4b273ac162dbe130bc9ab">
    <div class="photo charts" ><div></div></div>
    <div class="fullname"><?php echo Yii::t('Dashboard', 'PLOT/GRAPH')?></div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Uncover correlations') ?></div>
		<div class="email"><?php echo Yii::t('Dashboard', 'between different') ?></div>
		<div class="bday"><?php echo Yii::t('Dashboard', 'sets of data') ?>.</div>
   </li>

   <li class="button ui-corner-all index-a" onclick="selectGadget('Tables')" data-id="4975cfc1717e0f7f1f8387bc3d78b78e">
    <div class="photo tables" >
     <div></div>
    </div>
    <div class="fullname"><?php echo Yii::t('Dashboard', 'TABLES')?></div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Tables help you') ?></div>
		<div class="email"><?php echo Yii::t('Dashboard', 'derive intelligence') ?></div>
		<div class="bday"><?php echo Yii::t('Dashboard', 'from multiple sources') ?>.</div>
   </li>

   <li class="button ui-corner-all index-k" onclick="#" data-id="bcd25054edf383c3f5154bf98084f8a6">
    <div class="photo gauge" ><div></div></div>
		<div class="fullname"><?php echo Yii::t('Dashboard', 'Not Available') ?>!</div>
    <div class="name"></div>
		<div class="city"><?php echo Yii::t('Dashboard', 'Wait for') ?> </div>
		<div class="email"><?php echo Yii::t('Dashboard', 'Future Updates') ?></div>
    <div class="bday"></div>
   </li>

  </ul>
 </div>


 <!-- ALERTS; Add a new Gadget -->
 <!-- Abhinandan. 'Yes' indicates no size was selected. -->
 <div id="Alerts-dialog-form" title="Specify Gadget Properties">
  <section class="clearfix">
		<div class="fltRight">
			<img height="150" width="150" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/snaps/alerts.png"/>
		</div>
	 <div class="grid_6">
		<div class="portlet">
		 <header>
			<h2> <?php echo Yii::t('Dashboard', 'Alert Gadget')?>
			</h2>
		 </header>

		 <section>
		  <form class="form has-validation" >
			 <input type="hidden" id="Alerts_hidden_userNoSizeSelection" value="yes">

	<div class="clear"></div>
	<div class="clearfix">
				 <label for="form-gadgetName" class="form-label">
					<?php echo Yii::t('Dashboard', 'Gadget Name')?><em>*</em>
					 <small><?php echo Yii::t('Dashboard', 'Shown as the Gadget header')?>.</small>
				 </label>
				 <div class="form-input">
				  <input type="text" id="Alerts_gadgetName" name="Alerts_gadgetName" value="" maxlength="30"/>
				 </div>
				</div>

				<div class="clear"></div>
				<div class="clearfix">
				 <label for="form-gadgetType" class="form-label">
					<?php echo Yii::t('Dashboard', 'Gadget Type')?><em>*</em>
					 <small><?php echo Yii::t('Dashboard', 'Selected the type of Gadget')?>.</small>
				 </label>
				 <div class="form-input">
				  <input id="Alerts_gadgetType" name="Alerts_gadgetType" value="Alerts"  type="text" disabled>
				 </div>
				</div>

			<div class="clear"></div>
				<div class="clearfix">
			  <input type="hidden" id="Alerts_gadget_detector_source" name="Alerts_gadget_detector_source" value="" />
				  <label for="form-detectorSource" class="form-label">
				   <?php echo Yii::t('Dashboard', 'Data Source')?><em>*</em>
					  <small><?php echo Yii::t('Dashboard', 'Choose the source of information')?>.</small>
				  </label>
				  <div class="form-input">
					 <select id="detectorSource" name="detectorSource" maxlength="30" onchange="customizeButtons.setDetectorSource(this.value, 'Alerts_element_dataItems', basePath)">
					  <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
			     </select>
				  </div>
				</div>

			<div class="clear"></div>
				<div class="clearfix">
				 <label for="form-email" class="form-label">
					<?php echo Yii::t('Dashboard', 'Size')?><em>*</em>
					 <small><?php echo Yii::t('Dashboard', 'Choose size for Gadget')?>.</small>
				 </label>
			 <div class="form-input">
				  <select id="gadgetSize" name="gadgetSize" maxlength="30" onchange="customizeButtons.alertsDisplay()" >
					 <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					 <option value="small"><?php echo Yii::t('Dashboard', 'Small')?></option>
				  </select>
				 </div>
				</div>

				<div class="clear"></div>
				<div class="clear"><br/></div>
			 </form>
			</section>

		 </div>
    </div>
   </section>

  </div>


  <!-- IdiotLights-dialog-form -->
  <div id="IdiotLights-dialog-form" title="Specify Gadget Properties">
   <section class="clearfix">
		<div style="margin:0 auto;width:350px;">
			<img height="30" width="300" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/snaps/ilights_m.png"/>
		</div>
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2><?php echo Yii::t('Dashboard', 'Status Lights Gadget')?></h2>
			</header>

			<section>
			 <form class="form has-validation" >
			  <input type="hidden" id="IdiotLights_hidden_userNoSizeSelection" value="yes">

			<div class="clear"></div>
				 <div class="clearfix">
				  <label for="form-gadgetName" class="form-label">
					<?php echo Yii::t('Dashboard', 'Gadget Name')?> <em>*</em>
					  <small><?php echo Yii::t('Dashboard', 'Shown as the Gadget header')?>.</small>
				  </label>
				  <div class="form-input">
					 <input type="text" id="IdiotLights_gadgetName" name="IdiotLights_gadgetName" value="" maxlength="30"/>
				  </div>
				 </div>

				 <div class="clear"></div>
				  <div class="clearfix">
				   <label for="form-gadgetType" class="form-label">
				   <?php echo Yii::t('Dashboard', 'Gadget Type')?>  <em>*</em>
					   <small> <?php echo Yii::t('Dashboard', 'Selected the type of Gadget')?> .</small>
				   </label>
				   <div class="form-input">
					  <input id="IdiotLights_gadgetType" name="IdiotLights_gadgetType" value="IdiotLights"  type="text" disabled>
				   </div>
				  </div>

				   <div class="clear"></div>
				   <div class="clearfix">
			<input type="hidden" id="IdiotLights_gadget_detector_source" value="" />
				     <label for="form-detectorSource" class="form-label">
				       <?php echo Yii::t('Dashboard', 'Data Source')?>Data Source<em>*</em>
					     <small> <?php echo Yii::t('Dashboard', 'Choose the source of information')?>.</small>
				     </label>
				     <div class="form-input">
					    <select id="IdiotLights_detectorSource" name="IdiotLights_detectorSource" maxlength="30" onchange="customizeButtons.setDetectorSource(this.value, 'IdiotLights_element_dataItems', basePath)">
					     <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
			</select>
				     </div>
				   </div>
			<div class="clear"></div>
				     <div class="clearfix">
				      <label for="form-email" class="form-label">
					    <?php echo Yii::t('Dashboard', 'Size')?> <em>*</em>
					      <small> <?php echo Yii::t('Dashboard', 'Choose size for Gadget')?>.</small>
				      </label>
				<div class="form-input">
				       <select id="IdiotLights_gadgetSize" name="IdiotLights_gadgetSize" maxlength="30" onchange="customizeButtons.statusLightsDisplay()" >
					      <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					      <option value="large"><?php echo Yii::t('Dashboard', 'Large')?></option>
				       </select>
				      </div>
				     </div>

				     <div class="clear"></div>
				     <div class="clear"><br/></div>
			 </form>
			</section>
		 </div>
    </div>
   </section>
  </div>

  <!-- LiveStatus-dialog-form -->
  <div id="LiveStatus-dialog-form" title="Specify Gadget Properties">
   <section class="clearfix">
		<div style="margin:0 auto;width:350px;">
			<img height="90" width="300" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/snaps/livestat.png"/>
		</div>
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2><?php echo Yii::t('Dashboard', 'Live Status Gadge')?>t</h2>
			</header>

			<section>
			 <form class="form has-validation" >
			  <input type="hidden" id="LiveStatus_hidden_userNoSizeSelection" value="yes">

			<div class="clear"></div>
				 <div class="clearfix">
				  <label for="form-gadgetName" class="form-label">
					 <?php echo Yii::t('Dashboard', 'Gadget Name')?><em>*</em>
					  <small><?php echo Yii::t('Dashboard', 'Shown as the gadget header')?>.</small>
				  </label>
				  <div class="form-input">
					 <input type="text" id="LiveStatus_gadgetName" name="LiveStatus_gadgetName" value="" maxlength="30"/>
				  </div>
				 </div>

				 <div class="clear"></div>
				  <div class="clearfix">
				   <label for="form-gadgetType" class="form-label">
				   <?php echo Yii::t('Dashboard', 'Gadget Type')?> <em>*</em>
					   <small><?php echo Yii::t('Dashboard', 'Selected the type of Gadget')?>.</small>
				   </label>
				   <div class="form-input">
					  <input id="LiveStatus_gadgetType" name="LiveStatus_gadgetType" value="LiveStatus"  type="text" disabled>
				   </div>
				  </div>

				   <div class="clear"></div>
				   <div class="clearfix">
			<input type="hidden" id="LiveStatus_gadget_detector_source" value="" />
				     <label for="form-detectorSource" class="form-label">
				      <?php echo Yii::t('Dashboard', 'Data Source')?><em>*</em>
					     <small><?php echo Yii::t('Dashboard', 'Choose the source of information')?>.</small>
				     </label>
				     <div class="form-input">
					    <select id="LiveStatus_detectorSource" name="LiveStatus_detectorSource" maxlength="30" onchange="customizeButtons.setDetectorSource(this.value, 'LiveStatus_element_dataItems', basePath)">
					     <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					    </select>
				     </div>
				   </div>

			 <div class="clear"></div>
				     <div class="clearfix">
				      <label for="form-email" class="form-label">
					    <?php echo Yii::t('Dashboard', 'Size')?> <em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose size for Gadget')?>.</small>
				      </label>
			  <div class="form-input">
				       <select id="LiveStatus_gadgetSize" name="LiveStatus_gadgetSize" maxlength="30" onchange="customizeButtons.liveStatusDisplay(this.value)" >
					      <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					      <option value="small"><?php echo Yii::t('Dashboard', 'Small')?></option>
					      <option value="medium"><?php echo Yii::t('Dashboard', 'Medium')?></option>
					      <option value="large"><?php echo Yii::t('Dashboard', 'Large')?></option>
				       </select>
				      </div>
				     </div>

				     <div class="clear"></div>
				     <div class="clear"><br/></div>
			 </form>
			</section>
		 </div>
    </div>
   </section>
  </div>

  <!-- Charts-dialog-form -->
  <div id="Charts-dialog-form" title="Specify Gadget Properties">
   <section class="clearfix">
		<div style="margin-left:70px;width:300px;">
			<img height="90" width="250" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/snaps/charts.png"/>
		</div>
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2><?php echo Yii::t('Dashboard', 'Charts Gadget')?></h2>
			</header>

			<section>
			 <form class="form has-validation" >
			  <input type="hidden" id="Charts_hidden_userNoSizeSelection" value="yes">

			<div class="clear"></div>
				 <div class="clearfix">
				  <label for="form-gadgetName" class="form-label">
					 <?php echo Yii::t('Dashboard', 'Gadget Name')?><em>*</em>
					  <small><?php echo Yii::t('Dashboard', 'Shown as the gadget header')?>.</small>
				  </label>
				  <div class="form-input">
					 <input type="text" id="Charts_gadgetName" name="Charts_gadgetName" value="" maxlength="30"/>
				  </div>
				 </div>

				 <div class="clear"></div>
				  <div class="clearfix">
				   <label for="form-gadgetType" class="form-label">
				    <?php echo Yii::t('Dashboard', 'Gadget Type')?><em>*</em>
					   <small><?php echo Yii::t('Dashboard', 'Selected the type of Gadget')?>.</small>
				   </label>
				   <div class="form-input">
					  <input id="Charts_gadgetType" name="Charts_gadgetType" value="Charts"  type="text" disabled>
				   </div>
				  </div>

				<div class="clear"></div>
				   <div class="clearfix">
			<input type="hidden" id="Charts_gadget_detector_source" value="" />
				     <label for="form-detectorSource" class="form-label">
				     <?php echo Yii::t('Dashboard', 'Data Source')?> <em>*</em>
					     <small><?php echo Yii::t('Dashboard', 'Choose the data source')?>.</small>
				     </label>
				     <div class="form-input">
					     <select id="Charts_detectorSource" name="Charts_detectorSource" maxlength="30" onchange="customizeButtons.setDetectorSource(this.value, 'Charts_dataSource', basePath)">
							<option value="none"><?php echo Yii::t('Dashboard', 'Select Table')?></option>
					<option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					    </select>
				     </div>
				   </div>

				<div class="clear"></div>
				    <div class="clearfix">
			<input type="hidden" id="gadget_groupStyle" value="individual" />
				      <label for="form-email" class="form-label">
					    <?php echo Yii::t('Dashboard', 'Chart Style')?> <em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose the Chart style')?>.</small>
				      </label>
					<div class="form-input">
				       <select id="Charts_groupStyle" name="Charts_groupStyle" maxlength="30" onchange="customizeButtons.setGroupStyle(this.value)">
					      <option value="individual"><?php echo Yii::t('Dashboard', 'Individual')?></option>
					      <option value="grouped"><?php echo Yii::t('Dashboard', 'Grouped')?></option>
					      <option value="hgrouped"><?php echo Yii::t('Dashboard', 'Horizontal Set')?></option>
			       </select>
				      </div>
				    </div>

				<div class="clear"></div>
				    <div class="clearfix">
			<input type="hidden" id="gadget_chartStyle" value="simple" />
				      <label for="form-email" class="form-label">
					     <?php echo Yii::t('Dashboard', 'Grouping Style')?><em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose the display style')?>.</small>
				      </label>
					<div class="form-input">
				       <select id="Charts_chartStyle" name="Charts_chartStyle" maxlength="30" onchange="customizeButtons.setChartStyle(this.value)">
					      <option value="simple"><?php echo Yii::t('Dashboard', 'Simple Graph')?></option>
					      <option value="aspline"><?php echo Yii::t('Dashboard', 'Area Spline')?></option>
					      <option value="saspline"><?php echo Yii::t('Dashboard', 'Selectable Area Spline')?></option>
			       </select>
				      </div>
				    </div>

				<div class="clear"></div>
				    <div class="clearfix">
			<input type="hidden" id="Charts_gadget_data_source" name="Charts_gadget_data_source" value="" />
				      <label for="form-email" class="form-label">
					     <?php echo Yii::t('Dashboard', 'Choose Items')?><em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose the item set')?>.</small>
				      </label>
					<div class="form-input">
				       <select id="Charts_dataSource" name="Charts_dataSource" maxlength="30" onchange="customizeButtons.setCDataSource(this.value)">
					      <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
			       </select>
				      </div>
				    </div>

			<div class="clear"></div>
				     <div class="clearfix">
				      <label for="form-email" class="form-label">
					    <?php echo Yii::t('Dashboard', 'Size')?> <em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose size for Gadget')?>.</small>
				      </label>
			<div class="form-input">

			<input id="hidden_customizeBut_size" value="" type="hidden">

				      <select id="Charts_gadgetSize" name="Charts_gadgetSize" maxlength="30" onchange="customizeButtons.chartsDisplay(this.value)" >
				 <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					      <option value="medium"><?php echo Yii::t('Dashboard', 'Medium')?></option>
					      <option value="large"><?php echo Yii::t('Dashboard', 'Large')?></option>
				       </select>
				      </div>
				     </div>

				     <div class="clear"></div>
				     <div class="clear"><br/></div>
			 </form>
			</section>
		 </div>
    </div> <!-- Grid6 -->
    <div class="grid_2" style="float:left !important;margin-left:40px;">
		<table id="chartElementsTable" style="width:200px !important;">
			<thead>
			<tr>
			<th class="ui-widget-header ui-corner-top"><?php echo Yii::t('Dashboard', 'Elements')?></th>
			<th class="ui-widget-header ui-corner-top">
				<a class="button ui-button" data-icon-only="true" data-icon-primary="ui-icon-circle-close" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-circle-close"></span></a>
			</th>
			</tr></thead>
				<tbody id="chartElementsBody"></tbody>
			</table>
			<p><strong><?php echo Yii::t('Dashboard', 'Double click on (X) to delete items')?>.</strong></p>
    </div>

   </section>
  </div>

  <!-- Tables-dialog-form -->
  <div id="Tables-dialog-form" title="Specify Gadget Properties">
   <section class="clearfix">
		<div style="margin-left:70px;width:300px;">
			<img height="90" width="250" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/snaps/tables.png"/>
		</div>
	  <div class="loadingPart" style="width:200px;margin:10px auto;"></div>
	  <div class="grid_6">
		 <div class="portlet">
			<header>
			 <h2><?php echo Yii::t('Dashboard', 'Elements')?>Tables Gadget</h2>
			</header>

			<section>
			 <form class="form has-validation" >
			  <input type="hidden" id="Tables_hidden_userNoSizeSelection" value="yes">

			<div class="clear"></div>
				 <div class="clearfix">
				  <label for="form-gadgetName" class="form-label">
					<?php echo Yii::t('Dashboard', 'Elements')?> Gadget Name<em>*</em>
					  <small><?php echo Yii::t('Dashboard', 'Elements')?>Shown as the gadget header.</small>
				  </label>
				  <div class="form-input">
					 <input type="text" id="Tables_gadgetName" name="Tables_gadgetName" value="" maxlength="30"/>
				  </div>
				 </div>

				 <div class="clear"></div>
				  <div class="clearfix">
				   <label for="form-gadgetType" class="form-label">
				    <?php echo Yii::t('Dashboard', 'Elements')?>Gadget Type<em>*</em>
					   <small><?php echo Yii::t('Dashboard', 'Elements')?>Select the type of Gadget.</small>
				   </label>
				   <div class="form-input">
					  <input id="Tables_gadgetType" name="Tables_gadgetType" value="Tables"  type="text" disabled>
				   </div>
				  </div>

				 <div class="clear"></div>
				  <div class="clearfix">
				   <label for="form-gadgetType" class="form-label">
				    <?php echo Yii::t('Dashboard', 'Table Type')?><em>*</em>
					   <small><?php echo Yii::t('Dashboard', 'Select the type of Table')?>.</small>
				   </label>
				   <div class="form-input">
					    <select id="Tables_tableType" name="Tables_tableType" maxlength="30" onchange="customizeButtons.setTableType(this.value, 'Tables_detectorSource', basePath)">
					     <option value="none"><?php echo Yii::t('Dashboard', 'Select Type')?></option>
					     <option value="analysis"><?php echo Yii::t('Dashboard', 'Elements')?></option>
					     <option value="averages"><?php echo Yii::t('Dashboard', 'Averages')?></option>
				</select>
				   </div>
				  </div>

			   <div class="clear"></div>
				   <div class="clearfix">
			<input type="hidden" id="Tables_gadget_detector_source" value="" />
				     <label for="form-detectorSource" class="form-label">
				      <?php echo Yii::t('Dashboard', 'Data Source')?><em>*</em>
					     <small><?php echo Yii::t('Dashboard', 'Choose the data source')?>.</small>
				     </label>
				     <div class="form-input">
					    <select id="Tables_detectorSource" name="Tables_detectorSource" maxlength="30" onchange="customizeButtons.setDetectorSource(this.value, 'Tables_dataSource', basePath)">
					     <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
				</select>
				     </div>
				   </div>


				<div class="clear"></div>
				    <div class="clearfix">
			<input type="hidden" id="Tables_gadget_data_source" id="Tables_gadget_data_source" value="" />
				      <label for="form-email" class="form-label">
					     <?php echo Yii::t('Dashboard', 'Choose Items')?><em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose the item set')?>.</small>
				      </label>
				<div class="form-input">
				       <select id="Tables_dataSource" name="Tables_dataSource" maxlength="30" onchange="customizeButtons.setTDataSource(this.value)">
					      <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
				</select>
				      </div>
				    </div>

			<div class="clear"></div>
				     <div class="clearfix">
				      <label for="form-email" class="form-label">
					     <?php echo Yii::t('Dashboard', 'Size')?><em>*</em>
					      <small><?php echo Yii::t('Dashboard', 'Choose size for Gadget')?>.</small>
				      </label>
	      <div class="form-input">

	      <input id="hidden_customizeBut_size" value="" type="hidden">

				      <select id="Tables_gadgetSize" name="Tables_gadgetSize" maxlength="30" onchange="customizeButtons.tablesDisplay(this.value)" >
				 <option value="default"><?php echo Yii::t('Dashboard', 'Default')?></option>
					      <option value="medium"><?php echo Yii::t('Dashboard', 'Medium')?></option>
					      <option value="large"><?php echo Yii::t('Dashboard', 'Large')?></option>
				       </select>
				      </div>
				     </div>

				     <div class="clear"></div>
				     <div class="clear"><br/></div>
			 </form>
			</section>
		 </div>
    </div> <!-- Grid6 -->
    <div class="grid_2" style="float:left !important;margin-left:40px;">
		<table id="tablesElementsTable" style="width:200px !important;">
			<thead>
			<tr>
			<th class="ui-widget-header ui-corner-top"><?php echo Yii::t('Dashboard', 'Elements')?></th>
			<th class="ui-widget-header ui-corner-top">
				<a class="button ui-button" data-icon-only="true" data-icon-primary="ui-icon-circle-close" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-circle-close"></span></a>
			</th>
			</tr></thead>
				<tbody id="tablesElementsBody"></tbody>
			</table>
			<p><strong><?php echo Yii::t('Dashboard', 'Double click on (X) to delete items')?>.</strong></p>
    </div>

   </section>
  </div>

  <!-- Invoked by Alerts' "Alerts-dialog-form" dialog; post ajax -->
  <!-- Clicking on the 'Customize' button invokes the editGadget() method -->
  <!-- Abhinandan. Intentionally left dummy 'li' element. This space is actually dynamically filled. See customizeButtons.display() -->
   <!-- Note: The '1' being passed into 'editAlert' represents the "whichBlock" inside 'countTheActual()' -->
   <!-- Abhinandan. : See 'createDash.php, customizeButtons.display() to see the 'a href' when " + Customize " is clicked -->
  <div id="Alerts-dialog-form-customize" title="Alerts" >
  <p>
  <?php echo Yii::t('Dashboard', 'Each button represents individual display blocks you want to monitor.
     <br/>Click on the button to assign properties to it')?>  .</p>
   <section>
    <input id="hidden_customizeBut_size" value="" type="hidden">
    <input id="hidden_customizeBut_data_source" value="asdf" type="hidden">

    <ul class="isotope-widgets isotope-container" id="Alerts_ul_customizeBut" style="height:200px !important;">

     <li class="dummy_li">
      <a class="dummy_a " data-icon-primary="love"  href="#" onclick="dummy()" title="dummyTitle" >
       <span id="dummyBlock">+<br/>Customize</span>
      </a>
      <input id="dummy_id" value="" type="hidden"/>
     </li>
    </ul>
   </section>
 </div>


 <div id="IdiotLights-dialog-form-customize" title="Status Indicators" >
  <p>
     <?php echo Yii::t('Dashboard', 'Each button represents individual display blocks you want to monitor.
     Click on the button to assign properties to it')?></p>
   <section>
    <input id="hidden_customizeBut_size" value="" type="hidden">
    <input id="hidden_customizeBut_data_source" value="asdf" type="hidden">

    <ul class="isotope-widgets isotope-container" id="IdiotLights_ul_customizeBut" style="width:900px;height:200px !important;">

     <li class="dummy_li">
      <a class="dummy_a " data-icon-primary="love"  href="#" onclick="dummy()" title="dummyTitle" >
       <span id="dummyBlock">+<br>Customize</span>
      </a>
      <input id="dummy_id" value="" type="hidden"/>
     </li>
    </ul>
   </section>
 </div>



 <div id="LiveStatus-dialog-form-customize" title="Live Status" >
  <p>
      <?php echo Yii::t('Dashboard', 'Each button represents individual display blocks you want to monitor.
     Click on the button to assign properties to it')?></p>
   <section>
    <input id="hidden_customizeBut_size" value="" type="hidden">
    <input id="hidden_customizeBut_data_source" value="asdf" type="hidden">

    <ul class="isotope-widgets isotope-container" id="LiveStatus_ul_customizeBut" style="height:200px !important;">


     <li class="dummy_li">
      <a class="dummy_a " data-icon-primary="love"  href="#" onclick="dummy()" title="dummyTitle" >
       <span id="dummyBlock">+<br>Customize</span>
      </a>
      <input id="dummy_id" value="" type="hidden"/>
     </li>
    </ul>
   </section>
 </div>



 <div id="Charts-dialog-form-customize" title="Charts" >
  <p>
   <h3> Customize Buttons</h3>
      <?php echo Yii::t('Dashboard', 'Each button represents individual display blocks you want to monitor.
     <br/>Click on the button to assign properties to it')?></p>
   <section>
    <!-- <input id="hidden_customizeBut_size" value="" type="hidden"> -->
    <input id="hidden_customizeBut_data_source" value="asdf" type="hidden">

    <ul class="isotope-widgets isotope-container" id="Charts_ul_customizeBut">


     <li class="dummy_li">
      <a class="dummy_a " data-icon-primary="love"  href="#" onclick="dummy()" title="dummyTitle" >
       <span id="dummyBlock">+<br>Customize</span>
      </a>
      <input id="dummy_id" value="" type="hidden"/>
     </li>
    </ul>
   </section>
 </div>






  <!-- Assign Set Points; Invoked by the editGadget() method -->
  <!-- Abhinandan. Default colors when the page loads for the first time.. -->
       <!-- Abhinandan. Jan 10th 2013: Removed the commented out li elements, because they are mistakenly counted by 'childNodes.length' -->
 <!-- Abhinandan. Jan11th 2013; Bug Fix: Removed 'isotope-container' class, was causing read-only text fields.. -->
	 <!-- <ul id="gadgetColorList" class="isotope-widgets isotope-container"> -->
 <!-- Abhinandan. To determine color "button" size, goto 'createDash.php', top of page styling -->
	  <!-- Input size refers to the number of characters the field can display at once. -->

 <!-- Abhinandan. edit-Alerts-dialog-chosenDataItem: The value indicates which Chosen Element we selected (ie Element 1, Element 2, etc..) -->
 <!-- Abhinandan. edit-Alerts-dialog-chosenColorSet: Indicates which colorset (ie 3set vs 5set) the user selected -->
 <!-- Abhinandan. edit-Alerts-dialog-chosenColorSubset: Indicates '0' for 3set, '1' for 3set, and '2' for 5set.. '0' and '1' both share 3set because '0' refers to dialog load first time (3set), and '1' refers to user selected (3set) -->
 <!-- Abhinandan. edit-Alerts-dialog-chosenShowValue: Indicates either True or False, checkbox show value or not -->
 <!-- Abhinandan. edit-Alerts-dialog-chosenSetPoints: Serialized JSON formatted string, for colors & text boxes, each pair respectively -->
 <!-- Abhinandan. edit-Alerts-dialog-loadFirstTime: Either "settings_clean" or "settings_saved" -->
 <!-- Abhinandan. alerthidden_userNoDataItemSelection: 'Yes' indicates no 'dataItem' was selected from drop-down.. -->
 <div id="edit-Alerts-dialog" >
  <input id="edit-Alerts-dialog-currentCustomizeBlock" value="" type="hidden" />     <!-- whichBlock: 1,2,3, etc.. -->
  <input id="edit-Alerts-dialog-chosenDataItem" value="" type="hidden" />
  <input id="edit-Alerts-dialog-chosenColorSet" value="" type="hidden" />
  <input id="edit-Alerts-dialog-chosenColorSubset" value="" type="hidden" />
  <input id="edit-Alerts-dialog-chosenShowValue" value="" type="hidden" />
  <input id="edit-Alerts-dialog-chosenSetPoints" value="" type="hidden" />
  <input id="edit-Alerts-dialog-loadFirstTime" value="" type="hidden" />
  <input type="hidden" id="alerthidden_userNoDataItemSelection" value="yes">

  <form class="form has-validation" >
   <div class="clear"><br/></div>
    <div class="clearfix">
     <label for="form-email" class="form-label">
		 <?php  echo Yii::t('Dashboard','Choose Item')?>  <em>*</em>
			 <small> <?php  echo Yii::t('Dashboard','Choose Item set')?>.</small>
		 </label>
     <div class="form-input" id="alert-form-input">
      <select id="Alerts_element_dataItems" class="alertdataItems"  name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text,'Alerts', 'Alerts', 'Alerts')">
		   <option value="0" selected="selected"><?php  echo Yii::t('Dashboard','Choose Status Option')?></option>
			 <!--
       <option value="1">H Peak</option>
       <option value="2">Detector Temp</option>
       <option value="3">Good Data Seconds</option>
       <option value="4">Alignment Gain</option>
       <option value="5">PMT Avg Volts</option>
       <option value="6">Alignment Offset</option>
       <option value="7">Mass Flow</option>
       <option value="8">Belt Speed</option>
       <option value="9">Daemon Running</option>
       <option value="10">Avg Mass Flow</option>
       -->
      </select>
		 </div>
		</div>

    <div class="clear"></div>
		 <div class="clearfix">
      <label for="form-email" class="form-label">
			 <?php  echo Yii::t('Dashboard','Choose Color set')?><em>*</em>
			  <small> <?php  echo Yii::t('Dashboard','Choose color set')?>.</small>
			 </label>
       <div class="form-input">
	<select id="alert_set_dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value,'Alerts','Alerts','Alerts')" >
			   <option value="1" selected="selected" ><?php  echo Yii::t('Dashboard','3 Color sett')?> </option>
			   <option value="2"><?php  echo Yii::t('Dashboard','5 Color set')?> </option>
	</select>
			 </div>
			</div>

      <div class="clear"></div>
       <div class="clearfix">
	<label for="form-email" class="form-label">
				<?php  echo Yii::t('Dashboard','Show Actual value')?>
				  <small><?php  echo Yii::t('Dashboard','Show Actual value')?>.</small>
				</label>
	<div class="form-input">
	 <input type="checkbox" name="showvalue" onchange="gadgetColors.setShowValue(this.checked, 'Alerts', 'Alerts' )">
				</div>
			 </div>


       <div class="clear"></div>
	<div class="clearfix">
	 <label for="form-setPoints" class="form-label">
				 <?php  echo Yii::t('Dashboard','Define set points')?> .
	   <small><?php  echo Yii::t('Dashboard','Assign colors')?>.</small>
				 </label>


	 <ul id="AlertsgadgetColorList" class="isotope-widgets">

	  <li class="dash-order isotope-item extrasm" > <a class="small button-green" href="javascript:void(0)"> </a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-orange" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-red" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	 </ul>
	</div>

				<div class="clear"></div>
				<div class="clear"><br/></div>
  </form>
 </div>


 <!-- Assign Set Points; Invoked by the editGadget() method -->
 <div id="edit-IdiotLights-dialog" >
  <input id="edit-IdiotLights-dialog-currentCustomizeBlock" value="" type="hidden" />     <!-- whichBlock: 1,2,3, etc.. -->
  <input id="edit-IdiotLights-dialog-chosenDataItem" value="" type="hidden" />
  <input id="edit-IdiotLights-dialog-chosenColorSet" value="" type="hidden" />
  <input id="edit-IdiotLights-dialog-chosenColorSubset" value="" type="hidden" />
  <input id="edit-IdiotLights-dialog-chosenShowValue" value="" type="hidden" />
  <input id="edit-IdiotLights-dialog-chosenSetPoints" value="" type="hidden" />
  <input id="edit-IdiotLights-dialog-loadFirstTime" value="" type="hidden" />
  <input type="hidden" id="alerthidden_userNoDataItemSelection" value="yes">

  <form class="form has-validation" >
   <div class="clear"></div>
    <div class="clearfix">
     <label for="form-email" class="form-label">
		 <?php  echo Yii::t('Dashboard','Choose Item')?>  <em>*</em>
			 <small><?php  echo Yii::t('Dashboard','Choose Item set')?>.</small>
		 </label>
     <div class="form-input" id="alert-form-input">
      <select id="IdiotLights_element_dataItems" class="alertdataItems"  name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text,'IdiotLights', 'IdiotLights', 'IdiotLights')">
		   <option value="0" selected="selected"><?php  echo Yii::t('Dashboard','Choose Status Option')?></option>
			 <option value="1">H Peak</option>
       <option value="2">Detector Temp</option>
       <option value="3">Good Data Seconds</option>
       <option value="4">Alignment Gain</option>
       <option value="5">PMT Avg Volts</option>
       <option value="6">Alignment Offset</option>
       <option value="7">Mass Flow</option>
       <option value="8">Belt Speed</option>
       <option value="9">Daemon Running</option>
       <option value="10">Avg Mass Flow</option>
      </select>
		 </div>
		</div>

    <div class="clear"></div>
		 <div class="clearfix">
      <label for="form-email" class="form-label">
			 <?php  echo Yii::t('Dashboard','Choose Color set')?><em>*</em>
			  <small><?php  echo Yii::t('Dashboard','Choose color set')?>.</small>
			 </label>
       <div class="form-input">
	<select id="alert_set_dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value,'IdiotLights','IdiotLights','IdiotLights')" >
			   <option value="1" selected="selected" ><?php  echo Yii::t('Dashboard','3 Color set')?></option>
			   <option value="2"><?php  echo Yii::t('Dashboard','5 Color set')?></option>
	</select>
			 </div>
			</div>

      <div class="clear"></div>
       <div class="clearfix">
	<label for="form-email" class="form-label">
				<?php  echo Yii::t('Dashboard','Show Actual value')?>
				  <small><?php  echo Yii::t('Dashboard','Show Actual value')?>.</small>
				</label>
	<div class="form-input">
	 <input type="checkbox" name="showvalue" onchange="gadgetColors.setShowValue(this.checked, 'IdiotLights', 'IdiotLights' )">
				</div>
			 </div>


       <div class="clear"></div>
	<div class="clearfix">
	 <label for="form-setPoints" class="form-label">
				 <?php  echo Yii::t('Dashboard','Define set points')?> .
	   <small><?php  echo Yii::t('Dashboard','Assign colors')?>.</small>
				 </label>


	 <ul id="IdiotLightsgadgetColorList" class="isotope-widgets">

	  <li class="dash-order isotope-item extrasm" > <a class="small button-green" href="javascript:void(0)"> </a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-orange" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-red" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	 </ul>
	</div>

				<div class="clear"></div>
				<div class="clear"><br/></div>
  </form>
 </div>




 <!-- Assign Set Points; Invoked by the editGadget() method -->
 <div id="edit-LiveStatus-dialog" >
  <input id="edit-LiveStatus-dialog-currentCustomizeBlock" value="" type="hidden" />     <!-- whichBlock: 1,2,3, etc.. -->
  <input id="edit-LiveStatus-dialog-chosenDataItem" value="" type="hidden" />
  <input id="edit-LiveStatus-dialog-chosenColorSet" value="" type="hidden" />
  <input id="edit-LiveStatus-dialog-chosenColorSubset" value="" type="hidden" />
  <input id="edit-LiveStatus-dialog-chosenShowValue" value="" type="hidden" />
  <input id="edit-LiveStatus-dialog-chosenSetPoints" value="" type="hidden" />
  <input id="edit-LiveStatus-dialog-loadFirstTime" value="" type="hidden" />
  <input type="hidden" id="alerthidden_userNoDataItemSelection" value="yes">

  <form class="form has-validation" >
   <div class="clear"></div>
    <div class="clearfix">
     <label for="form-email" class="form-label">
		 <?php  echo Yii::t('Dashboard','Choose Item')?>  <em>*</em>
			 <small><?php  echo Yii::t('Dashboard','Choose Item set')?>.</small>
		 </label>
     <div class="form-input" id="alert-form-input">
      <select id="LiveStatus_element_dataItems" class="alertdataItems"  name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text,'LiveStatus', 'LiveStatus', 'LiveStatus')">
			 <option value="0" selected="selected"> <?php  echo Yii::t('Dashboard','Choose element')?></option>
			 <option value="1">Aluminum</option>
       <option value="2">Silicon</option>
       <option value="3">Calcium</option>
      </select>
		 </div>
		</div>

    <div class="clear"></div>
		 <div class="clearfix">
      <label for="form-email" class="form-label">
			<?php  echo Yii::t('Dashboard','Choose Color set')?> <em>*</em>
			  <small><?php  echo Yii::t('Dashboard','Choose color set')?>.</small>
			 </label>
       <div class="form-input">
	<select id="alert_set_dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value,'LiveStatus','LiveStatus','LiveStatus')" >
			   <option value="1" selected="selected" ><?php  echo Yii::t('Dashboard','3 Color set')?></option>
			   <option value="2"><?php  echo Yii::t('Dashboard','5 Color set')?></option>
	</select>
			 </div>
			</div>

      <div class="clear"></div>
       <div class="clearfix">
	<label for="form-email" class="form-label">
				<?php  echo Yii::t('Dashboard','Show Actual value')?>
				  <small><?php  echo Yii::t('Dashboard','Show Actual value')?>.</small>
				</label>
	<div class="form-input">
	 <input type="checkbox" name="showvalue" onchange="gadgetColors.setShowValue(this.checked, 'LiveStatus', 'LiveStatus' )">
				</div>
			 </div>


       <div class="clear"></div>
	<div class="clearfix">
	 <label for="form-setPoints" class="form-label">
				  <?php  echo Yii::t('Dashboard','Define set points')?>.
	   <small><?php  echo Yii::t('Dashboard','Assign colors')?>.</small>
				 </label>


	 <ul id="LiveStatusgadgetColorList" class="isotope-widgets">

	  <li class="dash-order isotope-item extrasm" > <a class="small button-green" href="javascript:void(0)"> </a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-orange" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-red" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	 </ul>
	</div>

				<div class="clear"></div>
				<div class="clear"><br/></div>
  </form>
 </div>




 <!-- Assign Set Points; Invoked by the editGadget() method -->
 <div id="edit-Charts-dialog" >
  <input id="edit-Charts-dialog-currentCustomizeBlock" value="" type="hidden" />     <!-- whichBlock: 1,2,3, etc.. -->
  <input id="edit-Charts-dialog-chosenDataItem" value="" type="hidden" />
  <input id="edit-Charts-dialog-chosenColorSet" value="" type="hidden" />
  <input id="edit-Charts-dialog-chosenColorSubset" value="" type="hidden" />
  <input id="edit-Charts-dialog-chosenShowValue" value="" type="hidden" />
  <input id="edit-Charts-dialog-chosenSetPoints" value="" type="hidden" />
  <input id="edit-Charts-dialog-loadFirstTime" value="" type="hidden" />
  <input type="hidden" id="Chartshidden_userNoDataItemSelection" value="yes">

  <form class="form has-validation" >
   <div class="clear"></div>
    <div class="clearfix">
     <label for="form-email" class="form-label">
		 <?php  echo Yii::t('Dashboard','Choose Item')?>  <em>*</em>
			 <small><?php  echo Yii::t('Dashboard','Choose Item set')?>.</small>
		 </label>
     <div class="form-input" id="Charts-form-input">
      <select id="Charts_element_dataItems" class="alertdataItems"  name="dataItems" maxlength="30" onchange="gadgetColors.setChosenDataItem(this.options[this.selectedIndex].text,'Charts', 'Charts', 'Charts')">
		   <option value="0" selected="selected"><?php  echo Yii::t('Dashboard','Choose Status Option')?></option>
			 <option value="1">Aluminum</option>
       <option value="2">Silicon</option>
       <option value="3">Calcium</option>
      </select>
		 </div>
		</div>

    <div class="clear"></div>
		 <div class="clearfix">
      <label for="form-email" class="form-label">
			<?php  echo Yii::t('Dashboard','Choose Color set')?> <em>*</em>
			  <small><?php  echo Yii::t('Dashboard','Choose Color set')?>.</small>
			 </label>
       <div class="form-input">
	<select id="Charts_set_dataItems" name="dataItems" maxlength="30" onchange="gadgetColors.alternate(this.value,'Charts','Charts','Charts')" >
			   <option value="1" selected="selected" ><?php  echo Yii::t('Dashboard','3 Color set')?></option>
			   <option value="2"><?php  echo Yii::t('Dashboard','5 Color set')?></option>
	</select>
			 </div>
			</div>

      <div class="clear"></div>
       <div class="clearfix">
	<label for="form-email" class="form-label">
				<?php  echo Yii::t('Dashboard','Show Actual value')?>
				  <small><?php  echo Yii::t('Dashboard','Show Actual value')?>.</small>
				</label>
	<div class="form-input">
	 <input type="checkbox" name="showvalue" onchange="gadgetColors.setShowValue(this.checked, 'Charts', 'Charts' )">
				</div>
			 </div>


       <div class="clear"></div>
	<div class="clearfix">
	 <label for="form-setPoints" class="form-label">
				  <?php  echo Yii::t('Dashboard','Define set points')?>.
	   <small><?php  echo Yii::t('Dashboard','Assign colors')?>.</small>
				 </label>


	 <ul id="ChartsgadgetColorList" class="isotope-widgets">

	  <li class="dash-order isotope-item extrasm" > <a class="small button-green" href="javascript:void(0)"> </a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-orange" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	  <li class="dash-order isotope-item extrasm" > <a class="small button-red" href="javascript:void(0)"></a><br/><input type="text" size="1" /></li>
	 </ul>
	</div>

				<div class="clear"></div>
				<div class="clear"><br/></div>
  </form>
 </div>



  <input type="hidden" id="gadgetType" value="">
  <input type="hidden" id="gadgetId" value="">
  <input type="hidden" id="Alerts_sGadgetType" value="">
  <input type="hidden" id="IdiotLights_sGadgetType" value="">
  <input type="hidden" id="Charts_sGadgetType" value="">
  <input type="hidden" id="Tables_sGadgetType" value="">
  <input type="hidden" id="LiveStatus_sGadgetType" value="">
  <input type="hidden" id="addNewGadget_existing_layout_lay_id" value="">

  <input type="hidden" id="isLayoutSelected" value="no">

  <input type="hidden" id="fetchLayoutGadgets_tempArr" value="">

  <?php
    //Abhinandan. Render these FIRST before we can utilize the jquery dialog event
    //$this->renderPartial('stubs/_statusGadget');
    //$this->renderPartial('stubs/_lightGadget');
    $this->renderPartial('stubs/_alertGadget');
    //$this->renderPartial('stubs/_tableGadget');
    //$this->renderPartial('stubs/_chartGadget');
    //$this->renderPartial('stubs/_gaugeGadget');
  ?>












 <?php
  /*
  *  Abhinandan.
  *  @var  $portlets Array stuffed @return ' $this->applyUserPref() '
  *     i.) Mimics the structure found in DashController.php
  */
  //Controller::fb('count of portlets[0] is ' .count($portlets[0]) );   //count of portlets[0] is 7
  //Controller::fb('number of columns is ' .$columns );                 //number of columns is 2

  //Controller::fb($portlets);    //Abhinandan. Jan13th 2013..

  //Abhinandan. Default, used for hash lookup by the $portlets array..
  $gridArr = array(
	       0 => 2,
	       2 => 1,
	       4 => 3,
	       6 => 4
  );


  for($i=0; $i < $columns; $i++)  //12/17, Abhinandan: Note: count($portlets) = 1.. so this loop is pretty ineffective..
  {
   if( !empty($portlets[$i]) )
   {
    foreach($portlets[$i] as $row){ ?>  <!-- //$row represents each sub-array within $portlets.. -->

     <div id="<?php echo $row['id'] ?>_HDiv" style="display:none;">
      <div class="grid_<?php
			 if($row['size'][0])
			 {
			  echo $gridArr[ $row['size'][0] ];	 //echo the Value in $gridArr, given the key from 'size' array..
			 }
			 else{
			  echo '2';                           //else echo 2..
								   }
							   ?> portlet ui-sortable clearfix padMargin collapsible" title="<?php
															   if($row['size'][0])
										       {
															    echo $gridArr[$row['size'][0]];
															   }
															   else{
																echo '2';
																											   }
																										   ?>" draggable="true" id="<?php
																													      echo $row['id'];  //ie 'Live_Status'
																													    ?>">
       <header>
	<ul class="pagination clearfix leading minusPad" >

	 <li class="page">
		<span class="spacer"></span>
	       </li>

	 <li class="page">
		<a href="#" alt="#<?php echo $row['id']; ?>" class="ui-icon-circle-close-ATag" ><span class="ui-button-icon-primary ui-icon ui-icon-circle-close"/></a>
	       </li>

	       <li class="page title">
		      <?php echo $row['title'] ?>
	       </li>

	       <?php if($row['size'][0] && $row['size'][0] != 2)
				       { ?>
	       <li class="last fRight <?php if($row['size'][0]==6) echo 'current cY'; if(!in_array(6,$row['size'])) echo 'disabled'; ?> " id="<?php echo $row['id']; ?>_lBut">
		      <a href="#"  <?php if(in_array(6,$row['size'])) /*echo "onClick='changeCss(\"#".$row['id']."\", \"l\", \"6\"); return false;'" */ echo "onClick='changeCssSize(\"".$row['id']."\", \"l\", \"6\"); return false;'"; ?> title="Large Box"  > L</a>
	       </li>

	       <li class="last fRight <?php if($row['size'][0]==4) echo 'current cY'; if(!in_array(4,$row['size'])) echo 'disabled'; ?> " id="<?php echo $row['id']; ?>_mBut">
		<a href="#"  <?php if(in_array(6,$row['size'])) /* echo "onClick='changeCss(\"#".$row['id']."\", \"m\", \"4\"); return false;'" */ echo "onClick='changeCssSize(\"".$row['id']."\", \"m\", \"4\"); return false;'" ; ?> title="Medium Box"  > M</a>
	       </li>

	 <?php
				       } ?>
	 <li class="last fRight">
	  <a id="editGadget" onclick="customizeGadget('<?php echo $row['title'] ?>')" href="javascript:void(0)" title="Edit <?php echo $row['title'] ?>" ><span class="ui-button-icon-primary ui-icon ui-icon-pencil"/></a>
	 </li>

	 <input type="hidden" id="<?php echo $row['id'] ?>_Hid" name="<?php echo $row['id'] ?>" value="<?php echo $row['size'][0]; ?>"/>

	</ul>
       </header>
       <section>
       <?php
	       if(@$row['renderContent'])
	 {
		      $dataProvider = $row['info']['dataProvider'];
		      $this->renderPartial($row['view'], array('dataProvider'=>$dataProvider), $row['flag']);
	       }
	 else{
		echo $row['content'];
	       }
       ?>
       </section>
      </div>  <!-- end "grid_x" where x is an integer -->



 <script type="text/javascript">

  //alert( 'addNewGadget_hidden.value is ' + document.getElementById("addNewGadget_hidden").value + '');

  $(function(){
   //Intitialization

   //Abhinandan. July9th 2013: New ( all 'xxx_HDiv' will be re-created inside 'dumpLayout()' function )..
    $( "#Alerts_HDiv" ).remove();
    $( "#IdiotLights_HDiv").remove();
    $( "#Live_Status_HDiv").remove();
    $( "#Charts_HDiv").remove();
    $( "#System_Messages_HDiv").remove();
   // end construction July9th 2013..


   var addNewGadget_hidden = document.getElementById("addNewGadget_hidden");
   if(addNewGadget_hidden.value == 'hide'){
    $("#addNewGadget").hide();
   }else{
    $("#addNewGadget").show();
   }


   $(".msgtip").tooltip();
    var gname = $( "#gadgetName" ),
	gsize = $( "#gadgetSize" ),
	gtype = $( "#gadgetType" ),
	detsource = $( "#detectorSource" ),
	datasource = $( "#dataSource" ),
	allFields = $( [] ).add( gname ).add( gtype ).add( detsource ).add( datasource ).add( gsize ),
	tips = $( ".validateTips" );

	  var sArray = Array();
	   sArray['large']  = 4;
		 sArray['medium'] = 3;
		 sArray['small']  = 1;


    /*
    *   Generic Functions
    */

    function updateTips(t){
     tips.text( t ).addClass( "ui-state-highlight" );

     setTimeout(function(){
      tips.removeClass( "ui-state-highlight", 1500 );
     }, 500);
    } //end updateTips()..

    function checkLength( o, n, min, max ){
     if( o.val().length > max || o.val().length < min )
     {
      o.addClass( "ui-state-error" );
      updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
      return false;
     }else{
      return true;
     }
    } //end CheckLength()..

    function checkRegexp( o, regexp, n ){
     if( !( regexp.test( o.val() ) ) )
     {
      o.addClass( "ui-state-error" );
      updateTips( n );
      return false;
     }else{
      return true;
     }
    } //end checkRegexp()..





   $( "#Alerts-dialog-form" ).dialog(
      {
       autoOpen: false,
       height: 450,

       width: 650,
       modal: true,
       scrolling:false,
       buttons: {
		 "Next":function(){
		     saveAlertGadget();
		 }, //next button  funtin() end here

		 "Close": function(){
			    $( this ).dialog( "close" );
			    var layoutContents = document.getElementById('layoutName').value = "";
		 } //end Close()..

	},  //end buttons obj..
	close: function(){
		 allFields.val( "" ).removeClass( "ui-state-error" );
	}
      } //end main object for 'dialog' event..
     );  //end dialog event..







    //New Layout Handler
    $( "#dialog-form-new" ).dialog(
     {
      autoOpen: false,
      height: 450,

      width: 605,
      modal: true,
      scrolling:false,
      buttons: {
		"Next": function(){
				   var layoutName = 'layoutName';    //The element id, containing the value (entered by the user)..
				   var layoutContents = document.getElementById(layoutName).value;

									$.ajax({
				    type: 'POST',
				    url: '<?php echo Yii::app()->baseUrl; ?>/dash/CheckName',
				    data: {'layoutContents' : layoutContents},
				    success: function(stringified){

					   if(stringified != "Success")
					   {
							var baseU = "<?php echo Yii::app()->baseUrl; ?>";
						    $("#ajaxLoadSuccess").html('Layout name already exists!<img src="'+baseU + '/images/cancel.png" alt="" />');
							return;
										}

						   /*
						   *   Abhinandan. Jan21st 2013:
						   *         i.) Save Layout to Helios..
						   *         ii.) @success callback : save uid to hidden element @ '#userId'
						   *
						   */
						   $.ajax({
						    type: 'POST',
						    url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
						    data: {'layoutContents' : layoutContents},
						    success: function(stringified){
						     var obj    = $.parseJSON(stringified);
						     var userId = document.getElementById('userId');
							 userId.value = obj.user_id;

						     var layoutId = document.getElementById('layoutId');
							 layoutId.value = obj.lay_id;

						     return true;
						    }//success
						   }); //end ajax..

						   $("#isLayoutSelected").val('yes');
						   $( "#dialog-form-new" ).dialog("close");
						   $("#select-gadget").dialog( "open" );

				    }//success
				   });  //end ajax

		}, //end Add Gadget()..

		"Cancel": function(){
				     $( this ).dialog( "close" );
				     var layoutContents = document.getElementById('layoutName').value = "";
		}  //end Close()..

      },  //end buttons

      close: function(){
			allFields.val( "" ).removeClass( "ui-state-error" );
      }
     } //end main object for 'dialog' event..
    );  //end "#dialog-form-new" ..



   //Select Gadget (close button)
   $("#select-gadget").dialog(
    {
     autoOpen: false,
     height: 480,

     width: 640,
     modal: true,
     scrolling:false,
     buttons: {
	       "Cancel":function(){
		   $(this).dialog('close');
		   var layoutContents = document.getElementById('layoutName').value = "";    //The element id, containing the value (entered by the user)..
	       }
     }
    }
   );




     $( "#IdiotLights-dialog-form" ).dialog(
      {
       autoOpen: false,
       height: 500,

       width: 500,
       modal: true,
       scrolling:false,
       buttons: {
		 "Next":function(){
				   //alert('inside Next button');
				   var bValid = true;

				   if( bValid )
				   {

				    var gg = gtype.val();   //Abhinandan. Jan9th: For example, gg = 'Table' ..
				    var gt = $("#IdiotLights_gadgetType").val();

				    var gadget_data_id = $('#gadgetId').val();
				    $("#IdiotLights_sGadgetType").val(gt);

				     //To clear  all existing value
				     $('#gadgetId').val('');
				    /*
				    *  Abhinandan. Jan11th:
				    *   Check and make sure the user made a size selection.
				    *    if( hidden_userNoSizeSelection.value == "no" ) .. proceed..
				    *     else if( hidden_userNoSizeSelection == "yes" ) .. set by default.. invoke customizeButtons.display("noUserSizeSelected")..
				    */
				    var hidden_userNoSizeSelection = document.getElementById("IdiotLights_hidden_userNoSizeSelection");

				    if( hidden_userNoSizeSelection.value == "yes" || hidden_userNoSizeSelection.value == "no")
				    {
				     //alert('inside OR, hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
				     if(hidden_userNoSizeSelection.value == "yes"){
				      customizeButtons.statusLightsDisplay();    //LEGACY..
				     }


				     var gadgetName = 'IdiotLights_gadgetName';
				     var gadgetName = document.getElementById(gadgetName).value;

				     var userId     = document.getElementById('userId');
					 userId     = userId.value;

				     var gadgetType = document.getElementById('gadgetType');
					 gadgetType = gadgetType.value;

				     var gadget_detector_source = document.getElementById('IdiotLights_gadget_detector_source');
					 gadget_detector_source = gadget_detector_source.value;

								 var gadget_data_source = ''; //No Data Source for IdiotLights
				     //var gadget_data_source = document.getElementById('IdiotLights_gadget_data_source');
				     //    gadget_data_source = gadget_data_source.value;

				     var gadgetSize = customizeButtons.getSize();


				     //alert( document.getElementById('addNewGadget_existing_layout_lay_id').value );
				     //alert( document.getElementById('addNewLayout_btn_click').value );

				    //

				    if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && (document.getElementById('addNewLayout_btn_click').value == 'false') ){  //If adding gadgets to existing layout..
					 var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					 layoutId   = layoutId.value;
					 //alert('IdiotLights-dialog-form, layoutId is of the current layout ' + layoutId + '');
					 //var post_call = 1;
					}
					else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && (document.getElementById('addNewLayout_btn_click').value == 'true') ){ //If this is a brand new layout..
					 var layoutId   = document.getElementById("layoutId");
					 layoutId   = layoutId.value;
					 //alert('IdiotLights-dialog-form, layoutId is of the current layout ' + layoutId + '');
					 //var post_call = 0;
					}


				    //var layoutId   = document.getElementById("layoutId");
				    //    layoutId   = layoutId.value;

				    //customizeButtons.display( gadgetSize );  //User size was already selected by the user..

				    $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: {'gadget_data_id':gadget_data_id,'gadgetName' : gadgetName, 'userId' : userId, 'gadgetType' : gadgetType, 'gadget_detector_source' : gadget_detector_source, 'gadget_data_source' : gadget_data_source, 'gadgetSize' : gadgetSize, 'layoutId' : layoutId},
					   success: function(gadget_data_id){

					    var gadgetDataId = document.getElementById("gadgetDataId");
					    gadgetDataId.value = gadget_data_id;

					   }
				    });  //end ajax..

					  //alert('gg is ' + gg);
					  $("#"+gg+"-dialog-form-customize").dialog("open");
						$( this ).dialog( "close" );

				   }  //end if OR..



				 }  //end  if  bValid..

		 },

		 "Close": function(){
			    $( this ).dialog( "close" );
			    var layoutContents = document.getElementById('layoutName').value = "";
		 } //end Close()..

	},  //end buttons obj..
	close: function(){
		 allFields.val( "" ).removeClass( "ui-state-error" );
	}
      } //end main object for 'dialog' event..
     );  //end dialog event..




     $( "#LiveStatus-dialog-form" ).dialog(
      {
       autoOpen: false,
       height: 500,

       width: 500,
       modal: true,
       scrolling:false,
       buttons: {
		 "Next":function(){
				   //alert('inside Next button');
				   var bValid = true;

					     /*
				   var gadgetSize = sArray[gsize.val()];   //Abhinandan. var gadgetSize now holds integer..

				   allFields.removeClass( "ui-state-error" );

				   bValid = bValid && checkLength( gname, "Gadget Name", 3, 16 );
				   bValid = bValid && checkRegexp( gname, /^[a-z]([0-9a-z_])+$/i, "Gadget Name may consist of a-z, 0-9, underscores, begin with a letter." );

				  alert('bvalid is ' + bValid); //Returns false..go back and fix later..
				  */

				   if( bValid )
				   {
				     //alert('bValid is ' + bValid);
				    var gg = gtype.val();   //Abhinandan. Jan9th: For example, gg = 'Table' ..
				     //alert('gg is ' + gg);
				    var gt = $("#LiveStatus_gadgetType").val();
				     //alert('gt is ' + gt);

				    $("#LiveStatus_sGadgetType").val(gt);
				     //alert('LiveStatus_sGadgetType.value is ' + LiveStatus_sGadgetType.value);


				    /*
				    *  Abhinandan. Jan11th:
				    *   Check and make sure the user made a size selection.
				    *    if( hidden_userNoSizeSelection.value == "no" ) .. proceed..
				    *     else if( hidden_userNoSizeSelection == "yes" ) .. set by default.. invoke customizeButtons.display("noUserSizeSelected")..
				    */
				    var hidden_userNoSizeSelection = document.getElementById("LiveStatus_hidden_userNoSizeSelection");

				    if( hidden_userNoSizeSelection.value == "yes" || hidden_userNoSizeSelection.value == "no")
				    {
				     //alert('inside OR, hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
				     if(hidden_userNoSizeSelection.value == "yes"){
				      customizeButtons.liveStatusDisplay('default');    //LEGACY..
				     }


				     var gadget_data_id =  $('#gadgetId').val();
				     //To clear  all existing value
				     $('#gadgetId').val('');
				     var gadgetName = 'LiveStatus_gadgetName';
				     var gadgetName = document.getElementById(gadgetName).value;

				     var userId     = document.getElementById('userId');
					 userId     = userId.value;

				     var gadgetType = document.getElementById('gadgetType');
					 gadgetType = gadgetType.value;
					 if(gadgetType == 'LiveStatus'){
					  gadgetType = 'Live_Status';
					 }

				     var gadget_detector_source = document.getElementById('LiveStatus_gadget_detector_source');
					 gadget_detector_source = gadget_detector_source.value;

									 var gadget_data_source = ''; //No Data Source for LiveStatus

				     //var gadget_data_source = document.getElementById('LiveStatus_gadget_data_source');
				     //    gadget_data_source = gadget_data_source.value;

				     var gadgetSize = customizeButtons.getSize();


				    //alert( document.getElementById('addNewGadget_existing_layout_lay_id').value );
				    //alert( document.getElementById('addNewLayout_btn_click').value );

				    //

				    if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && (document.getElementById('addNewLayout_btn_click').value == 'false') ){  //If adding gadgets to existing layout..
					 var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					 layoutId   = layoutId.value;
					 //alert('LiveStatus-dialog-form, layoutId is of the current layout ' + layoutId + '');
					 //var post_call = 1;
					}
					else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && (document.getElementById('addNewLayout_btn_click').value == 'true') ){ //If this is a brand new layout..
					 var layoutId   = document.getElementById("layoutId");
					 layoutId   = layoutId.value;
					 //alert('LiveStatus-dialog-form, layoutId is of the current layout ' + layoutId + '');
					 //var post_call = 0;
					}


				    //var layoutId   = document.getElementById("layoutId");
				    //    layoutId   = layoutId.value;

				    //alert('pre-ajax is gadgetName ' + gadgetName + ', userId ' + userId + ', gadgetType ' + gadgetType + ', gadget_detector_source ' + gadget_detector_source + ', gadget_data_source ' + gadget_data_source + ', gadgetSize ' + gadgetSize + ', layoutId ' + layoutId + '');

				    $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: {'gadget_data_id':gadget_data_id,'gadgetName' : gadgetName, 'userId' : userId, 'gadgetType' : gadgetType, 'gadget_detector_source' : gadget_detector_source, 'gadget_data_source' : gadget_data_source, 'gadgetSize' : gadgetSize, 'layoutId' : layoutId},
					   success: function(gadget_data_id){

					    var gadgetDataId = document.getElementById("gadgetDataId");
					    gadgetDataId.value = gadget_data_id;

					   }
				    });  //end ajax..

					  //alert('gg is ' + gg);
					  //LiveStatus-dialog-form-customize
					  $("#LiveStatus-dialog-form-customize").dialog("open");
						$( this ).dialog( "close" );

				   }  //end if OR..



				 }  //end  if  bValid..

		 },

		 "Close": function(){
			    $( this ).dialog( "close" );
			    var layoutContents = document.getElementById('layoutName').value = "";
		 } //end Close()..

	},  //end buttons obj..
	close: function(){
		 allFields.val( "" ).removeClass( "ui-state-error" );
	}
      } //end main object for 'dialog' event..
     );  //end dialog event..




     //Charts-dialog-form..
     $( "#Charts-dialog-form" ).dialog(
      {
       autoOpen: false,
       height: 650,

       width: 750,
       modal: true,
       scrolling:false,
       buttons: {
		 "Show Gadget":function(){

		   //alert('inside Show Gadget button');
		   var bValid = true;

		     /*
		   var gadgetSize = sArray[gsize.val()];   //Abhinandan. var gadgetSize now holds integer..

		   allFields.removeClass( "ui-state-error" );

		   bValid = bValid && checkLength( gname, "Gadget Name", 3, 16 );
		   bValid = bValid && checkRegexp( gname, /^[a-z]([0-9a-z_])+$/i, "Gadget Name may consist of a-z, 0-9, underscores, begin with a letter." );

		  alert('bvalid is ' + bValid); //Returns false..go back and fix later..
		  */

		   if( bValid )
		   {
		    //alert('inside bValid');
		    var gg = gtype.val();   //Abhinandan. Jan9th: For example, gg = 'Table' ..
		    var gt = $("#Charts_gadgetType").val();
		     //alert('gg is ' + gg);
		     //alert('gt is ' + gt);
		    $("#Charts_sGadgetType").val(gt);
		     //alert( document.getElementById("Charts_sGadgetType").value );

		    addGadget('Charts');

		    /*
		    *  Abhinandan. Jan11th:
		    *   Check and make sure the user made a size selection.
		    *    if( hidden_userNoSizeSelection.value == "no" ) .. proceed..
		    *     else if( hidden_userNoSizeSelection == "yes" ) .. set by default.. invoke customizeButtons.display("noUserSizeSelected")..
		    */

		    var hidden_userNoSizeSelection = document.getElementById("Charts_hidden_userNoSizeSelection");

				    if( hidden_userNoSizeSelection.value == "yes" || hidden_userNoSizeSelection.value == "no")
		    {
		     //alert('inside OR, hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
		     if(hidden_userNoSizeSelection.value == "yes"){
				      //TempAbhiChange
		      customizeButtons.chartsDisplay("default");    //LEGACY..
				      //customizeButtons.chartsDisplay(6);
		     }


		     var gadgetId = $('#gadgetId').val();
		     //To clear  all existing value
		     $('#gadgetId').val('');
		     var gadgetName = 'Charts_gadgetName';
		     var gadgetName = document.getElementById(gadgetName).value;

		     var userId     = document.getElementById('userId');
			 userId     = userId.value;

		     var gadgetType = document.getElementById('gadgetType');
			 gadgetType = gadgetType.value;

		     var gadget_detector_source = document.getElementById('Charts_gadget_detector_source');
			 gadget_detector_source = gadget_detector_source.value;

		     var gadget_data_source = document.getElementById('Charts_gadget_data_source');
			 gadget_data_source = gadget_data_source.value;

		     var gadgetSize = customizeButtons.getSize();

					var  gadget_chart_style = document.getElementById('gadget_chartStyle');
						 gadget_chart_style = gadget_chart_style.value;

					var  gadget_group_style = document.getElementById('gadget_groupStyle');
						 gadget_group_style = gadget_group_style.value;

		    if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && ( document.getElementById('addNewLayout_btn_click').value == 'false' ) ){  //If adding gadgets to existing layout..
			 var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
			 layoutId   = layoutId.value;
			 var post_call = 1;
			}
			else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && ( document.getElementById('addNewLayout_btn_click').value == 'true' ) ){ //If this is a brand new layout..
			 var layoutId   = document.getElementById("layoutId");
			 layoutId   = layoutId.value;
			 var post_call = 0;
			}

		    //var layoutId   = document.getElementById("layoutId");
		    //    layoutId   = layoutId.value;


		    //alert('pre-ajax, gadgetName is ' + gadgetName + ', userId is ' + userId + ', gadgetType is ' + gadgetType + ', gadget_detector_source is ' + gadget_detector_source + ', gadget_data_source is ' + gadget_data_source + ', gadgetSize is ' + gadgetSize + ',gadget_group_style is ' + gadget_group_style + ', gadget_chart_style is ' + gadget_chart_style + ',  layoutId is ' + layoutId + '');

		    $.ajax({
			   type: 'POST',
			   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
			   data: {'gadget_data_id':gadgetId,'gadgetName' : gadgetName, 'userId' : userId,
					  'gadgetType' : gadgetType, 'gadget_detector_source' : gadget_detector_source,
					  'gadget_data_source' : gadget_data_source, 'gadgetSize' : gadgetSize,
					  'gadget_group_style' : gadget_group_style, 'gadget_chart_style' : gadget_chart_style,
					  'layoutId' : layoutId},
			   success: function(gadget_data_id){
			    //alert(gadget_data_id);
			    var gadgetDataId = document.getElementById("gadgetDataId");
			    gadgetDataId.value = gadget_data_id;
			    document.getElementById('Charts_gadget_data_source').value="";

			   }
		    });  //end ajax..


		    if( (post_call == 1) || (post_call == 0) ){
			 selectLayout( layoutId );
			}


			  //alert('gg is ' + gg);
			  //$("#"+gg+"-dialog-form-customize").dialog("open");



			    $( this ).dialog( "close" );

		   }  //end if OR..



		 }  //end  if  bValid..

		 },

		 "Close": function(){
			    $( this ).dialog( "close" );
			    var layoutContents = document.getElementById('layoutName').value = "";
		 } //end Close()..

	},  //end buttons obj..
	close: function(){
		 allFields.val( "" ).removeClass( "ui-state-error" );
	}
      } //end main object for 'dialog' event..
     );  //end dialog event..




     //Tables-dialog-form..
     $( "#Tables-dialog-form" ).dialog(
      {
       autoOpen: false,

       height: 650,
       width: 750,
       modal: true,
       scrolling:false,
       buttons: {
		 "Show Gadget":function(){

				   //alert('inside Next button');
				   var bValid = true;


				   //var gadgetSize = sArray[gsize.val()];   //Abhinandan. var gadgetSize now holds integer..

				   //allFields.removeClass( "ui-state-error" );

				   //bValid = bValid && checkLength( gname, "Gadget Name", 3, 16 );
				   //bValid = bValid && checkRegexp( gname, /^[a-z]([0-9a-z_])+$/i, "Gadget Name may consist of a-z, 0-9, underscores, begin with a letter." );

				  //alert('bvalid is ' + bValid); //Returns false..go back and fix later..


				   if( bValid )
				   {
				    //alert('inside bValid');
				    var gg = gtype.val();   //Abhinandan. Jan9th: For example, gg = 'Table' ..
				    var gt = "System_Messages";
				     //alert('gg is ' + gg);
				     //alert('gt is ' + gt);
				    $("#Tables_sGadgetType").val(gt);
				     //alert( document.getElementById("Tables_sGadgetType").value );

				    addGadget('Tables');


				    //  Abhinandan. Jan11th:
				    //   Check and make sure the user made a size selection.
				    //    if( hidden_userNoSizeSelection.value == "no" ) .. proceed..
				    //     else if( hidden_userNoSizeSelection == "yes" ) .. set by default.. invoke customizeButtons.display("noUserSizeSelected")..

				    var hidden_userNoSizeSelection = document.getElementById("Tables_hidden_userNoSizeSelection");

				    if( hidden_userNoSizeSelection.value == "yes" || hidden_userNoSizeSelection.value == "no")
				    {
				     //alert('inside OR, hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
				     if(hidden_userNoSizeSelection.value == "yes"){
				      customizeButtons.tablesDisplay("default");    //LEGACY..
				     }


				     var gadget_data_id =  $('#gadgetId').val();
				     //To clear  all existing value
				     $('#gadgetId').val('');
				     var gadgetName = 'Tables_gadgetName';
				     var gadgetName = document.getElementById(gadgetName).value;

				     var userId     = document.getElementById('userId');
					 userId     = userId.value;

				     var gadgetType = document.getElementById('gadgetType');
					 gadgetType = gadgetType.value;


				     var gadget_detector_source = document.getElementById('Tables_gadget_detector_source');
					 gadget_detector_source = gadget_detector_source.value;

				     var gadget_data_source = document.getElementById('Tables_gadget_data_source');
					 gadget_data_source = gadget_data_source.value;

				     var gadgetSize = customizeButtons.getSize();


				    if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && ( document.getElementById('addNewLayout_btn_click').value == 'false' ) ){  //If adding gadgets to existing layout..
					 var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					 layoutId   = layoutId.value;
					 var post_call = 1;
					}
					else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && ( document.getElementById('addNewLayout_btn_click').value == 'true' ) ){ //If this is a brand new layout..
					 var layoutId   = document.getElementById("layoutId");
					 layoutId   = layoutId.value;
					 var post_call = 0;
					}

				    //var layoutId   = document.getElementById("layoutId");
					//layoutId   = layoutId.value;


				    //alert('pre-ajax, gadgetName is ' + gadgetName + ', userId is ' + userId + ', gadgetType is ' + gadgetType + ', gadget_detector_source is ' + gadget_detector_source + ', gadget_data_source is ' + gadget_data_source + ', gadgetSize is ' + gadgetSize + ', layoutId is ' + layoutId + '');

				    $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: {'gadget_data_id':gadget_data_id,'gadgetName' : gadgetName, 'userId' : userId, 'gadgetType' : gadgetType, 'gadget_detector_source' : gadget_detector_source, 'gadget_data_source' : gadget_data_source, 'gadgetSize' : gadgetSize, 'layoutId' : layoutId},
					   success: function(gadget_data_id){

					    var gadgetDataId = document.getElementById("gadgetDataId");
					    gadgetDataId.value = gadget_data_id;
					    document.getElementById('Tables_gadget_data_source').value="";

					   }
				    });  //end ajax..

					if( (post_call == 1) || (post_call == 0) ){
					 selectLayout( layoutId );
					}


					  //alert('gg is ' + gg);
					  //$("#"+gg+"-dialog-form-customize").dialog("open");



						$( this ).dialog( "close" );

				   }  //end if OR..



				 }  //end  if  bValid..

		 },

		 "Close": function(){
			    $( this ).dialog( "close" );
			    var layoutContents = document.getElementById('layoutName').value = "";
		 } //end Close()..

	},  //end buttons obj..
	close: function(){
		 allFields.val( "" ).removeClass( "ui-state-error" );
	}
      } //end main object for 'dialog' event..
     );  //end dialog event..

    //Assign Set Points (handler)
    $("#edit-IdiotLights-dialog").dialog(
     {
      open: function(){
		   //alert('inside edit-IdiotLights-dialog OPEN');
		       var whichBlock = document.getElementById("edit-IdiotLights-dialog-currentCustomizeBlock");
			   whichBlock = whichBlock.value;
			   //alert('whichBlock is ' + whichBlock);

		       var saved_loadFirstTime_new = document.getElementById('settingsIdiotLights-' + whichBlock);
			   saved_loadFirstTime_new = saved_loadFirstTime_new.value;
			   //alert('open(), saved_loadFirstTime_new is ' + saved_loadFirstTime_new);

		       var chosenColorSubset = document.getElementById('chosenColorSubset-IdiotLights-' + whichBlock);
			   chosenColorSubset = chosenColorSubset.value;
			   //alert('open(), chosenColorSubset is ' + chosenColorSubset);

		       if(chosenColorSubset == "")
		       {
			chosenColorSubset = 0;
		       }


		       gadgetColors.alternate(chosenColorSubset, 'IdiotLights', 'IdiotLights', 'IdiotLights');  //Upon open, AUTOMATICALLY saves 3-set by default..

		       //gadgetColors.chooseItem('IdiotLights', 'element');      //Attempts to reset the value back to default, OR the user's pre-defined SAVED value..

      },

      autoOpen: false,
      height: 450,
      title:"Assign Set Points",

      width: 500,
      modal: true,
      scrolling:false,
      buttons: {
		"save" : function(){


				    var whichBlock = document.getElementById("edit-IdiotLights-dialog-currentCustomizeBlock").value;
				     //alert('inside save, whichBlock is ' + whichBlock);
				    var singularFirstUpper = 'IdiotLights';  //I made them already purposely plural..
				    var pluralFirstUpper   = 'IdiotLights';  // ""..

				    //  -----
				    var saved_chosenColorSet = document.getElementById('chosenColorSet-IdiotLights-' + whichBlock);
					saved_chosenColorSet = saved_chosenColorSet.value;
					       //alert('save(), saved_chosenColorSet is ' + saved_chosenColorSet);

				    var saved_chosenColorSubset = document.getElementById('chosenColorSubset-IdiotLights-' + whichBlock);
					saved_chosenColorSubset = saved_chosenColorSubset.value;
					      //alert('save(), saved_chosenColorSubset is ' + saved_chosenColorSubset);

				    var saved_chosenSetPoints_new = document.getElementById('hIdiotLights-' + whichBlock);  //This dynanamic hidden field wasn't working between dialog forms..
					saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    //var saved_chosenSetPoints_new = document.getElementById('hIdiotLights_customize-' + whichBlock);
					//saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    var greenField  = document.getElementById(saved_chosenColorSubset+ "_greenField");      //****LEFT OFF HERE.. need to assign a unique id, to tell WHICH customize block we are referring to...
					greenField  = greenField.value;

				    var orangeField = document.getElementById(saved_chosenColorSubset+ "_orangeField");
					orangeField = orangeField.value;

				    var redField    = document.getElementById(saved_chosenColorSubset+ "_redField");
					redField    = redField.value;

				    if( greenField < 1 || orangeField < 1 || redField < 1 ){  //User did not enter any threshold values..
					 //alert('All colors input boxes were not entered. Attempting to invoke default save().');
					 var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'IdiotLights', saved_chosenColorSubset, 'IdiotLights', 'default');

					 saved_chosenSetPoints_new = json_str;

					 //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
					 document.getElementById('hIdiotLights-' + whichBlock).value = saved_chosenSetPoints_new;

					 //alert('save(), default saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }
				    else if( greenField > 0 || orangeField > 0 || redField > 0 ){ //User did enter threshold values..
				     //alert('All color WERE entered. Attempting to invoke original save(). ');
				     var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'IdiotLights', saved_chosenColorSubset, 'IdiotLights', 'original');

				     saved_chosenSetPoints_new = json_str;

				     //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
				     document.getElementById('hIdiotLights-' + whichBlock).value = saved_chosenSetPoints_new;

				     //alert('save(), original saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }


				    showItemSet(whichBlock, singularFirstUpper, pluralFirstUpper);  // ie places "Aluminum" upon the 'Customize Button' ..

				    $(this).dialog('close');



		},

		"close" : function(){
				     $(this).dialog('close');
				     gadgetColors.alternate('0','IdiotLights', 'IdiotLights', 'IdiotLights');   //Also for clearing out fields on 'close' .. also for first time .dialog load..
		}
      }
     }
    );



    //Assign Set Points (handler)
    $("#edit-Alerts-dialog").dialog(
     {
      open: function(){
		   //alert('inside edit-Alerts-dialog OPEN');
		       var whichBlock = document.getElementById("edit-Alerts-dialog-currentCustomizeBlock");
			   whichBlock = whichBlock.value;
			   //alert('whichBlock is ' + whichBlock);

		       var saved_loadFirstTime_new = document.getElementById('settingsAlerts-' + whichBlock);
			   saved_loadFirstTime_new = saved_loadFirstTime_new.value;
			   //alert('open(), saved_loadFirstTime_new is ' + saved_loadFirstTime_new);

		       var chosenColorSubset = document.getElementById('chosenColorSubset-Alerts-' + whichBlock);
			   chosenColorSubset = chosenColorSubset.value;
			   //alert('open(), chosenColorSubset is ' + chosenColorSubset);

		       if(chosenColorSubset == "")
		       {
			chosenColorSubset = 0;
		       }


		       gadgetColors.alternate(chosenColorSubset, 'Alerts', 'Alerts', 'Alerts');  //Upon open, AUTOMATICALLY saves 3-set by default..

		       //gadgetColors.chooseItem('IdiotLights', 'element');      //Attempts to reset the value back to default, OR the user's pre-defined SAVED value..

      },

      autoOpen: false,
      height: 450,
      title:"Assign Set Points",

      width: 600,
      modal: true,
      scrolling:false,
      buttons: {
		"save" : function(){


				    var whichBlock = document.getElementById("edit-Alerts-dialog-currentCustomizeBlock").value;
				     //alert('inside save, whichBlock is ' + whichBlock);
				    var singularFirstUpper = 'Alerts';  //I made them already purposely plural..
				    var pluralFirstUpper   = 'Alerts';  // ""..

				    //  -----
				    var saved_chosenColorSet = document.getElementById('chosenColorSet-Alerts-' + whichBlock);
					saved_chosenColorSet = saved_chosenColorSet.value;
					       //alert('save(), saved_chosenColorSet is ' + saved_chosenColorSet);

				    var saved_chosenColorSubset = document.getElementById('chosenColorSubset-Alerts-' + whichBlock);
					saved_chosenColorSubset = saved_chosenColorSubset.value;
					      //alert('save(), saved_chosenColorSubset is ' + saved_chosenColorSubset);

				    var saved_chosenSetPoints_new = document.getElementById('hAlerts-' + whichBlock);  //This dynanamic hidden field wasn't working between dialog forms..
					saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    //var saved_chosenSetPoints_new = document.getElementById('hIdiotLights_customize-' + whichBlock);
					//saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    var greenField  = document.getElementById(saved_chosenColorSubset+ "_greenField");
					greenField  = greenField.value;

				    var orangeField = document.getElementById(saved_chosenColorSubset+ "_orangeField");
					orangeField = orangeField.value;

				    var redField    = document.getElementById(saved_chosenColorSubset+ "_redField");
					redField    = redField.value;

				    if( greenField < 1 || orangeField < 1 || redField < 1 ){  //User did not enter any threshold values..
					 //alert('All colors input boxes were not entered. Attempting to invoke default save().');
					 var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'Alerts', saved_chosenColorSubset, 'Alerts', 'default');

					 saved_chosenSetPoints_new = json_str;

					 //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
					 document.getElementById('hAlerts-' + whichBlock).value = saved_chosenSetPoints_new;

					 //alert('save(), default saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }
				    else if( greenField > 0 || orangeField > 0 || redField > 0 ){ //User did enter threshold values..
				     //alert('All colors WERE entered. Attempting to invoke original save(). ');
				     var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'Alerts', saved_chosenColorSubset, 'Alerts', 'original');

				     saved_chosenSetPoints_new = json_str;

				     //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
				     document.getElementById('hAlerts-' + whichBlock).value = saved_chosenSetPoints_new;

				     //alert('save(), original saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }


				    showItemSet(whichBlock, singularFirstUpper, pluralFirstUpper);  // ie places "Aluminum" upon the 'Customize Button' ..

				    $(this).dialog('close');



		},

		"close" : function(){
				     $(this).dialog('close');
				     gadgetColors.alternate('0','Alerts', 'Alerts', 'Alerts');   //Also for clearing out fields on 'close' .. also for first time .dialog load..

		}
      }
     }
    );




    //Assign Set Points (handler)
    $("#edit-LiveStatus-dialog").dialog(
     {
      open: function(){
		   //alert('inside edit-LiveStatus-dialog OPEN');
		       var whichBlock = document.getElementById("edit-LiveStatus-dialog-currentCustomizeBlock");
			   whichBlock = whichBlock.value;
			   //alert('whichBlock is ' + whichBlock);

		       var saved_loadFirstTime_new = document.getElementById('settingsLiveStatus-' + whichBlock);
			   saved_loadFirstTime_new = saved_loadFirstTime_new.value;
			   //alert('open(), saved_loadFirstTime_new is ' + saved_loadFirstTime_new);

		       var chosenColorSubset = document.getElementById('chosenColorSubset-LiveStatus-' + whichBlock);
			   chosenColorSubset = chosenColorSubset.value;
			   //alert('open(), chosenColorSubset is ' + chosenColorSubset);

		       if(chosenColorSubset == "")
		       {
			chosenColorSubset = 0;
		       }


		       gadgetColors.alternate(chosenColorSubset, 'LiveStatus', 'LiveStatus', 'LiveStatus');  //Upon open, AUTOMATICALLY saves 3-set by default..

		       //gadgetColors.chooseItem('IdiotLights', 'element');      //Attempts to reset the value back to default, OR the user's pre-defined SAVED value..

      },

      autoOpen: false,
      height: 450,
      title:"Assign Set Points",
      width: 500,

      modal: true,
      scrolling:false,
      buttons: {
		"save" : function(){

				    //alert('save() here!');
				    var whichBlock = document.getElementById("edit-LiveStatus-dialog-currentCustomizeBlock").value;
				     //alert('inside save, whichBlock is ' + whichBlock);
				    var singularFirstUpper = 'LiveStatus';  //I made them already purposely plural..
				    var pluralFirstUpper   = 'LiveStatus';  // ""..

				    //  -----
				    var saved_chosenColorSet = document.getElementById('chosenColorSet-LiveStatus-' + whichBlock);
					saved_chosenColorSet = saved_chosenColorSet.value;
					       //alert('save(), saved_chosenColorSet is ' + saved_chosenColorSet);

				    var saved_chosenColorSubset = document.getElementById('chosenColorSubset-LiveStatus-' + whichBlock);
					saved_chosenColorSubset = saved_chosenColorSubset.value;
					       //alert('save(), saved_chosenColorSubset is ' + saved_chosenColorSubset);

				    var saved_chosenSetPoints_new = document.getElementById('hLiveStatus-' + whichBlock);  //This dynanamic hidden field wasn't working between dialog forms..
					saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    //var saved_chosenSetPoints_new = document.getElementById('hIdiotLights_customize-' + whichBlock);
					//saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    var greenField  = document.getElementById(saved_chosenColorSubset+ "_greenField");
					greenField  = greenField.value;

				    var orangeField = document.getElementById(saved_chosenColorSubset+ "_orangeField");
					orangeField = orangeField.value;

				    var redField    = document.getElementById(saved_chosenColorSubset+ "_redField");
					redField    = redField.value;

				    if( greenField < 1 || orangeField < 1 || redField < 1 ){  //User did not enter any threshold values..
					  //alert('All colors input boxes were not entered. Attempting to invoke default save().');
					 var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'LiveStatus', saved_chosenColorSubset, 'LiveStatus', 'default');

					 saved_chosenSetPoints_new = json_str;

					 //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
					 document.getElementById('hLiveStatus-' + whichBlock).value = saved_chosenSetPoints_new;

					 //alert('save(), default saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }
				    else if( greenField > 0 || orangeField > 0 || redField > 0 ){ //User did enter threshold values..
				      //alert('All color WERE entered. Attempting to invoke original save(). ');
				     var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'LiveStatus', saved_chosenColorSubset, 'LiveStatus', 'original');

				     saved_chosenSetPoints_new = json_str;

				     //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
				     document.getElementById('hLiveStatus-' + whichBlock).value = saved_chosenSetPoints_new;

				      //alert('save(), original saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }


				    showItemSet(whichBlock, singularFirstUpper, pluralFirstUpper);  // ie places "Aluminum" upon the 'Customize Button' ..

				    $(this).dialog('close');



		},

		"close" : function(){
				     $(this).dialog('close');
				     gadgetColors.alternate('0','LiveStatus', 'LiveStatus', 'LiveStatus');   //Also for clearing out fields on 'close' .. also for first time .dialog load..
		}
      }
     }
    );



    //Assign Set Points (handler)
    $("#edit-Charts-dialog").dialog(
     {
      open: function(){
		   //alert('inside edit-IdiotLights-dialog OPEN');
		       var whichBlock = document.getElementById("edit-Charts-dialog-currentCustomizeBlock");
			   whichBlock = whichBlock.value;
			   //alert('whichBlock is ' + whichBlock);

		       var saved_loadFirstTime_new = document.getElementById('settingsCharts-' + whichBlock);
			   saved_loadFirstTime_new = saved_loadFirstTime_new.value;
			   //alert('open(), saved_loadFirstTime_new is ' + saved_loadFirstTime_new);

		       var chosenColorSubset = document.getElementById('chosenColorSubset-Charts-' + whichBlock);
			   chosenColorSubset = chosenColorSubset.value;
			   //alert('open(), chosenColorSubset is ' + chosenColorSubset);

		       if(chosenColorSubset == "")
		       {
			chosenColorSubset = 0;
		       }


		       gadgetColors.alternate(chosenColorSubset, 'Charts', 'Charts', 'Charts');  //Upon open, AUTOMATICALLY saves 3-set by default..

		       //gadgetColors.chooseItem('IdiotLights', 'element');      //Attempts to reset the value back to default, OR the user's pre-defined SAVED value..

      },

      autoOpen: false,
      height: 450,
      title:"Assign Set Points",
      width: 500,

      modal: true,
      scrolling:false,
      buttons: {
		"save" : function(){


				    var whichBlock = document.getElementById("edit-Charts-dialog-currentCustomizeBlock").value;
				     //alert('inside save, whichBlock is ' + whichBlock);
				    var singularFirstUpper = 'Charts';  //I made them already purposely plural..
				    var pluralFirstUpper   = 'Charts';  // ""..

				    //  -----
				    var saved_chosenColorSet = document.getElementById('chosenColorSet-Charts-' + whichBlock);
					saved_chosenColorSet = saved_chosenColorSet.value;
					       //alert('save(), saved_chosenColorSet is ' + saved_chosenColorSet);

				    var saved_chosenColorSubset = document.getElementById('chosenColorSubset-Charts-' + whichBlock);
					saved_chosenColorSubset = saved_chosenColorSubset.value;
					      //alert('save(), saved_chosenColorSubset is ' + saved_chosenColorSubset);

				    var saved_chosenSetPoints_new = document.getElementById('hCharts-' + whichBlock);  //This dynanamic hidden field wasn't working between dialog forms..
					saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    //var saved_chosenSetPoints_new = document.getElementById('hIdiotLights_customize-' + whichBlock);
					//saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;

				    var greenField  = document.getElementById(saved_chosenColorSubset+ "_greenField");      //****LEFT OFF HERE.. need to assign a unique id, to tell WHICH customize block we are referring to...
					greenField  = greenField.value;

				    var orangeField = document.getElementById(saved_chosenColorSubset+ "_orangeField");
					orangeField = orangeField.value;

				    var redField    = document.getElementById(saved_chosenColorSubset+ "_redField");
					redField    = redField.value;

				    if( greenField < 1 || orangeField < 1 || redField < 1 ){  //User did not enter any threshold values..
					 //alert('All colors input boxes were not entered. Attempting to invoke default save().');
					 var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'Charts', saved_chosenColorSubset, 'Charts', 'default');

					 saved_chosenSetPoints_new = json_str;

					 //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
					 document.getElementById('hCharts-' + whichBlock).value = saved_chosenSetPoints_new;

					 //alert('save(), default saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }
				    else if( greenField > 0 || orangeField > 0 || redField > 0 ){ //User did enter threshold values..
				     //alert('All color WERE entered. Attempting to invoke original save(). ');
				     var json_str = gadgetColors.saveSetPoints(saved_chosenColorSet, 'Charts', saved_chosenColorSubset, 'Charts', 'original');

				     saved_chosenSetPoints_new = json_str;

				     //DANGER!! -  Don't forget this step! Pass by value..permanently stores..
				     document.getElementById('hCharts-' + whichBlock).value = saved_chosenSetPoints_new;

				     //alert('save(), original saveSetPoints, saved_chosenSetPoints_new.value is ' + saved_chosenSetPoints_new);
				    }


				    showItemSet(whichBlock, singularFirstUpper, pluralFirstUpper);  // ie places "Aluminum" upon the 'Customize Button' ..

				    $(this).dialog('close');



		},

		"close" : function(){
				     $(this).dialog('close');
				     gadgetColors.alternate('0','Charts', 'Charts', 'Charts');   //Also for clearing out fields on 'close' .. also for first time .dialog load..
		}
      }
     }
    );




    //Alert Gadget - Customize Buttons (handler)
    //Shows what happens after the user saves their 'Assign Set Points'..
    $("#Alerts-dialog-form-customize").dialog(
     {
      autoOpen: false,
      height: 450,
      width: 600,       //Abhinandan. Jan11th 2013..

      modal: true,
      scrolling:false,
      buttons: {
		"Show gadget": function(){
					  addGadget('Alerts');

					  //Multiple blocks, so..
					  var temp_arr  = new Array();
					  var final_arr = new Array();
					  var wikkens_arr = {};
					  var count = 0;

					  if( customizeButtons.getSize() == 'small'){
					   count = 1;
					  }

					  //alert('count is ' + count);

					  for(var i=1; i<count+1; ++i){
					   var whichBlock = i;
					   //alert('inside for loop, whichBlock is ' + whichBlock);
					   var chosenDataItem = document.getElementById('chosenDataItem-Alerts-' + whichBlock);

					   var saved_chosenColorSet = document.getElementById('chosenColorSet-Alerts-' + whichBlock);
					       saved_chosenColorSet = saved_chosenColorSet.value;
					      //alert('saved_chosenColorSet is ' + saved_chosenColorSet + '');

					   var saved_chosenColorSubset = document.getElementById('chosenColorSubset-Alerts-' + whichBlock);
					      saved_chosenColorSubset = saved_chosenColorSubset.value;
					     //alert('saved_chosenColorSubset is ' + saved_chosenColorSubset + '');

					   var saved_chosenSetPoints_new = document.getElementById('hAlerts-' + whichBlock);
					       saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;
					       //alert('saved_chosenSetPoints_new is ' + saved_chosenSetPoints_new);

					   var gadgetDataId = document.getElementById('gadgetDataId');
					       gadgetDataId.value = gadgetDataId.value.replace(/['"]/g,'');
					   var show_value = document.getElementById('chosenShowValue-Alerts-' + whichBlock);
					   if(show_value && show_value.value != "")                //Last minute js check prior to send to server..
					   {
					    show_value = show_value.value;
					   }
					   else if(show_value && show_value.value == "")
					   {
					    show_value = "FALSE";
					   }
					   wikkens_arr[i] = {
							     element_type       : chosenDataItem.attributes[1].nodeValue,
							     element_colorset   : saved_chosenColorSet,
							     gadget_data_id     : gadgetDataId.value,
							     order_location     : whichBlock,
							     show_value         : show_value,
							     element_setpoint   : saved_chosenSetPoints_new

					   };

					   //temp_arr.push(gadgetDataId);  //2.)  Abhinandan, for reference..
					   //final_arr[ saved_chosenColorSet['attributes'][2].nodeValue ] = saved_chosenColorSet.attributes[1].nodeValue;

					  }
					  //console.log(temp_arr);
					  wikkens_arr.gadgetType = 'Alerts';
					   wikkens_arr.gadget_data_id = $('#gadgetId').val();
					   //To clear  all existing value
				     $('#gadgetId').val('');
					  //console.log(wikkens_arr);

					  $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: { 'large_data_type' : wikkens_arr },
					   success: function(message){
					    if(message)
					    {
					     alert('Message from server is ' + message);
					    }

					   }
					  });  //end ajax..


					  if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && ( document.getElementById('addNewLayout_btn_click').value == 'false' ) ){  //If adding gadgets to existing layout..
					   var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					       layoutId = layoutId.value;
					    //alert('LiveStatus-dialog-form-customize, existing layout about to invoke selectLayout ');
					   selectLayout( layoutId );
					  }
					  else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && ( document.getElementById('addNewLayout_btn_click').value == 'true' ) ){
					   var layoutId = document.getElementById('layoutId');
					       layoutId = layoutId.value;
					      selectLayout( layoutId );
					  }


					  $( this ).dialog("close");

		}, //end "Show gadget"..

		"Cancel": function(){
				     $( this ).dialog( "close" );
				     var layoutContents = document.getElementById('layoutName').value = "";
				     document.getElementById("Alerts_element_dataItems").innerHTML = "";
		} //end "Cancel"..

      },  //end buttons obj..

      close: function(){
			allFields.val( "" ).removeClass( "ui-state-error" );
      }
     }  //end main object for 'dialog' event..
    );  //end dialog event..




    //IdiotLights Gadget - Customize Buttons (handler)
    //Shows what happens after the user saves their 'Assign Set Points'..
    $("#IdiotLights-dialog-form-customize").dialog(
     {
      autoOpen: false,
      height: 350,
      width: 'auto',       //Abhinandan. Jan11th 2013..

      modal: true,
      scrolling:false,
      buttons: {
		"Show gadget": function(){
					  addGadget('IdiotLights');

					var gadget_data_id = $('#gadgetId').val();
					//To clear  all existing value
					 $('#gadgetId').val('');
					  //Multiple blocks, so..
					  var temp_arr  = new Array();
					  var final_arr = new Array();
					  var wikkens_arr = {};
					  for(var i=1; i<11; ++i){
					   var whichBlock = i;
					   var chosenDataItem = document.getElementById('chosenDataItem-IdiotLights-' + whichBlock);

					   var saved_chosenColorSet = document.getElementById('chosenColorSet-IdiotLights-' + whichBlock);
					       saved_chosenColorSet = saved_chosenColorSet.value;

					   var saved_chosenColorSubset = document.getElementById('chosenColorSubset-IdiotLights-' + whichBlock);
					      saved_chosenColorSubset = saved_chosenColorSubset.value;

					   var saved_chosenSetPoints_new = document.getElementById('hIdiotLights-' + whichBlock);
					       saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;
					       //alert('saved_chosenSetPoints_new is ' + saved_chosenSetPoints_new);

					   var gadgetDataId = document.getElementById('gadgetDataId');
					       gadgetDataId.value = gadgetDataId.value.replace(/['"]/g,'');
					   var show_value = document.getElementById('chosenShowValue-IdiotLights-' + whichBlock);
					   if(show_value && show_value.value != "")                //Last minute js check prior to send to server..
					   {
					    show_value = show_value.value;
					   }
					   else if(show_value && show_value.value == "")
					   {
					    show_value = "FALSE";
					   }
					   wikkens_arr[i] = {
							     element_type       : chosenDataItem.attributes[1].nodeValue,
							     element_colorset   : saved_chosenColorSet,
							     gadget_data_id     : gadgetDataId.value,
							     order_location     : whichBlock,
							     show_value         : show_value,
							     element_setpoint   : saved_chosenSetPoints_new

					   };

					   //temp_arr.push(gadgetDataId);  //2.)  Abhinandan, for reference..
					   //final_arr[ saved_chosenColorSet['attributes'][2].nodeValue ] = saved_chosenColorSet.attributes[1].nodeValue;

					  }
					  //console.log(temp_arr);
					  wikkens_arr.gadgetType = 'IdiotLights';
					  wikkens_arr.gadget_data_id = gadget_data_id;
					  console.log(wikkens_arr);

					  $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: { 'large_data_type' : wikkens_arr },
					   success: function(message){
					    if(message)
					    {
					     alert('Message from server is ' + message);
					    }

					   }
					  });  //end ajax..


					  /*
					  if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" ){  //If adding gadgets to existing layout..
					   var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					       layoutId = layoutId.value;
					   alert('IdiotLights-dialog-form-customize, existing layout about to invoke selectLayout ');
					   selectLayout( layoutId );
					  }
					  */

					  if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && ( document.getElementById('addNewLayout_btn_click').value == 'false' ) ){  //If adding gadgets to existing layout..
					   var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					       layoutId = layoutId.value;
					    //alert('IdiotLights-dialog-form-customize, existing layout about to invoke selectLayout ');
					   selectLayout( layoutId );
					  }
					  else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && ( document.getElementById('addNewLayout_btn_click').value == 'true' ) ){
					   var layoutId = document.getElementById('layoutId');
					       layoutId = layoutId.value;
					      selectLayout( layoutId );
					  }


					  $( this ).dialog("close");

		}, //end "Show gadget"..

		"Cancel": function(){
				     $( this ).dialog( "close" );
				     var layoutContents = document.getElementById('layoutName').value = "";
				     document.getElementById("IdiotLights_element_dataItems").innerHTML = "";
		} //end "Cancel"..

      },  //end buttons obj..

      close: function(){
			allFields.val( "" ).removeClass( "ui-state-error" );
      }
     }  //end main object for 'dialog' event..
    );  //end dialog event..




    //LiveStatus Gadget - Customize Buttons (handler)
    //Shows what happens after the user saves their 'Assign Set Points'..
    $("#LiveStatus-dialog-form-customize").dialog(
     {
      autoOpen: false,
      height: 350,
      width: 'auto',       //Abhinandan. Jan11th 2013..

      modal: true,
      scrolling:false,
      buttons: {
		"Show gadget": function(){
					  addGadget('LiveStatus');

					  //Multiple blocks, so..
					  var temp_arr  = new Array();
					  var final_arr = new Array();
					  var wikkens_arr = {};
					  var count = 0;

					  if( customizeButtons.getSize() == 'large'){
					   count = 5;
					  }
					  else if( customizeButtons.getSize() == 'medium'){
					   count = 3;
					  }
					  else if( customizeButtons.getSize() == 'small'){
					   count = 1;
					  }

					  //alert('count is ' + count);

					  for(var i=1; i<count+1; ++i){
					   var whichBlock = i;
					   //alert('inside for loop, whichBlock is ' + whichBlock);
					   var chosenDataItem = document.getElementById('chosenDataItem-LiveStatus-' + whichBlock);

					   var saved_chosenColorSet = document.getElementById('chosenColorSet-LiveStatus-' + whichBlock);
					       saved_chosenColorSet = saved_chosenColorSet.value;

					   var saved_chosenColorSubset = document.getElementById('chosenColorSubset-LiveStatus-' + whichBlock);
					      saved_chosenColorSubset = saved_chosenColorSubset.value;

					   var saved_chosenSetPoints_new = document.getElementById('hLiveStatus-' + whichBlock);
					       saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;
					       //alert('saved_chosenSetPoints_new is ' + saved_chosenSetPoints_new);

					   var gadgetDataId = document.getElementById('gadgetDataId');
					       gadgetDataId.value = gadgetDataId.value.replace(/['"]/g,'');
					   var show_value = document.getElementById('chosenShowValue-LiveStatus-' + whichBlock);
					   if(show_value && show_value.value != "")                //Last minute js check prior to send to server..
					   {
					    show_value = show_value.value;
					   }
					   else if(show_value && show_value.value == "")
					   {
					    show_value = "FALSE";
					   }
					   wikkens_arr[i] = {
							     element_type       : chosenDataItem.attributes[1].nodeValue,
							     element_colorset   : saved_chosenColorSet,
							     gadget_data_id     : gadgetDataId.value,
							     order_location     : whichBlock,
							     show_value         : show_value,
							     element_setpoint   : saved_chosenSetPoints_new

					   };

					   //temp_arr.push(gadgetDataId);  //2.)  Abhinandan, for reference..
					   //final_arr[ saved_chosenColorSet['attributes'][2].nodeValue ] = saved_chosenColorSet.attributes[1].nodeValue;

					  }
					  //console.log(temp_arr);
					  wikkens_arr.gadgetType = 'LiveStatus';
					  wikkens_arr.gadget_data_id  = $('#gadgetId').val();// $('#gadgetId').val(gadget_options['gadget_data_id']);
					  //To clear  all existing value
					    $('#gadgetId').val('');
					 // console.log(wikkens_arr);

					  $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: { 'large_data_type' : wikkens_arr },
					   success: function(message){
					    if(message)
					    {
					     alert('Message from server is ' + message);
					    }

					   }
					  });  //end ajax..


					  if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && ( document.getElementById('addNewLayout_btn_click').value == 'false' ) ){  //If adding gadgets to existing layout..
					   var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					       layoutId = layoutId.value;
					    //alert('LiveStatus-dialog-form-customize, existing layout about to invoke selectLayout ');
					   selectLayout( layoutId );
					  }
					  else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && ( document.getElementById('addNewLayout_btn_click').value == 'true' ) ){
					   var layoutId = document.getElementById('layoutId');
					       layoutId = layoutId.value;
					      selectLayout( layoutId );
					  }


					  $( this ).dialog("close");

		}, //end "Show gadget"..

		"Cancel": function(){
				     $( this ).dialog( "close" );
				     var layoutContents = document.getElementById('layoutName').value = "";
				     document.getElementById("LiveStatus_element_dataItems").innerHTML = "";
		} //end "Cancel"..

      },  //end buttons obj..

      close: function(){
			allFields.val( "" ).removeClass( "ui-state-error" );
      }
     }  //end main object for 'dialog' event..
    );  //end dialog event..




    //Charts Gadget - Customize Buttons (handler)
    //Shows what happens after the user saves their 'Assign Set Points'..
    $("#Charts-dialog-form-customize").dialog(
     {
      autoOpen: false,
      height: 350,
      width: 'auto',       //Abhinandan. Jan11th 2013..
      modal: true,
      scrolling:false,
      buttons: {
		"Show gadget": function(){
					  addGadget('Charts');

					  //Multiple blocks, so..
					  var temp_arr  = new Array();
					  var final_arr = new Array();
					  var wikkens_arr = {};
					  for(var i=1; i<11; ++i){
					   var whichBlock = i;
					   var chosenDataItem = document.getElementById('chosenDataItem-Charts-' + whichBlock);

					   var saved_chosenColorSet = document.getElementById('chosenColorSet-Charts-' + whichBlock);
					       saved_chosenColorSet = saved_chosenColorSet.value;

					   var saved_chosenColorSubset = document.getElementById('chosenColorSubset-Charts-' + whichBlock);
					      saved_chosenColorSubset = saved_chosenColorSubset.value;

					   var saved_chosenSetPoints_new = document.getElementById('hCharts-' + whichBlock);
					       saved_chosenSetPoints_new = saved_chosenSetPoints_new.value;
					       //alert('saved_chosenSetPoints_new is ' + saved_chosenSetPoints_new);

					   var gadgetDataId = document.getElementById('gadgetDataId');
					       gadgetDataId.value = gadgetDataId.value.replace(/['"]/g,'');
					   var show_value = document.getElementById('chosenShowValue-Charts-' + whichBlock);
					   if(show_value && show_value.value != "")                //Last minute js check prior to send to server..
					   {
					    show_value = show_value.value;
					   }
					   else if(show_value && show_value.value == "")
					   {
					    show_value = "FALSE";
					   }
					   wikkens_arr[i] = {
							     element_type       : chosenDataItem.attributes[1].nodeValue,
							     element_colorset   : saved_chosenColorSet,
							     gadget_data_id     : gadgetDataId.value,
							     order_location     : whichBlock,
							     show_value         : show_value,
							     element_setpoint   : saved_chosenSetPoints_new

					   };

					   //temp_arr.push(gadgetDataId);  //2.)  Abhinandan, for reference..
					   //final_arr[ saved_chosenColorSet['attributes'][2].nodeValue ] = saved_chosenColorSet.attributes[1].nodeValue;

					  }
					  //console.log(temp_arr);
					  wikkens_arr.gadgetType = 'Charts';
					  console.log(wikkens_arr);

					  $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: { 'large_data_type' : wikkens_arr },
					   success: function(message){
					    if(message)
					    {
					     alert('Message from server is ' + message);
					    }

					   }
					  });  //end ajax..


					  $( this ).dialog("close");

		}, //end "Show gadget"..

		"Cancel": function(){
				     $( this ).dialog( "close" );
				     var layoutContents = document.getElementById('layoutName').value = "";
		} //end "Cancel"..

      },  //end buttons obj..

      close: function(){
			allFields.val( "" ).removeClass( "ui-state-error" );
      }
     }  //end main object for 'dialog' event..
    );  //end dialog event..



  }); //end Initialization..



   //--- Form-related (non-dialog) controls ---



  //This method is invoked by  div id="select-gadget" when it is clicked..

  function saveAlertGadget(){
				   //alert('inside Next button');
				   var bValid = true;

				   if( bValid )
				   {

				     //alert('inside bValid!');

				    var gg = $( "#gadgetType" ).val();   //Abhinandan. Jan9th: For example, gg = 'Table' ..
				    var gt = $("#Alerts_gadgetType").val();

				    $("#Alerts_sGadgetType").val(gt);
				     //alert('Alerts_sGadgetType is ' + document.getElementById('Alerts_sGadgetType').value );

				    /*
				    *  Abhinandan. Jan11th:
				    *   Check and make sure the user made a size selection.
				    *    if( hidden_userNoSizeSelection.value == "no" ) .. proceed..
				    *     else if( hidden_userNoSizeSelection == "yes" ) .. set by default.. invoke customizeButtons.display("noUserSizeSelected")..
				    */
				    var hidden_userNoSizeSelection = document.getElementById("Alerts_hidden_userNoSizeSelection");

				    if( hidden_userNoSizeSelection.value == "yes" || hidden_userNoSizeSelection.value == "no")
				    {
				     //alert('inside OR, hidden_userNoSizeSelection.value is ' + hidden_userNoSizeSelection.value);
				     if(hidden_userNoSizeSelection.value == "yes"){
				      customizeButtons.alertsDisplay();    //LEGACY..
				     }


				     var gadget_id = $('#gadgetId').val();

				     //To clear  all existing value
				     $('#gadgetId').val('');

				     var gadgetName = 'Alerts_gadgetName';
				     var gadgetName = document.getElementById(gadgetName).value;

				     var userId     = document.getElementById('userId');
					 userId     = userId.value;

				     var gadgetType = document.getElementById('gadgetType');
					 gadgetType = gadgetType.value;

				     var gadget_detector_source = document.getElementById('Alerts_gadget_detector_source');
					 gadget_detector_source = gadget_detector_source.value;

				     //var gadget_id = $().

				     //var gadget_data_source = document.getElementById('Alerts_gadget_data_source');
				     //    gadget_data_source = gadget_data_source.value;
				     var gadget_data_source = '';  // No Data-Source Directly for Alerts

				     var gadgetSize = customizeButtons.getSize();

				     //alert( document.getElementById('addNewGadget_existing_layout_lay_id').value );
				     //alert( document.getElementById('addNewLayout_btn_click').value );

				    //

				    if( document.getElementById('addNewGadget_existing_layout_lay_id').value != "" && (document.getElementById('addNewLayout_btn_click').value == 'false') ){  //If adding gadgets to existing layout..
					 var layoutId = document.getElementById('addNewGadget_existing_layout_lay_id');
					 layoutId   = layoutId.value;
					 //alert('Alerts-dialog-form, layoutId is of the current layout ' + layoutId + '');

					}
					else if( document.getElementById('addNewGadget_existing_layout_lay_id').value == "" && (document.getElementById('addNewLayout_btn_click').value == 'true') ){ //If this is a brand new layout..
					 var layoutId   = document.getElementById("layoutId");
					 layoutId   = layoutId.value;
					 //alert('Alerts-dialog-form, layoutId is of the current layout ' + layoutId + '');

					}


				    //var layoutId   = document.getElementById("layoutId");
				    //    layoutId   = layoutId.value;

				    //customizeButtons.display( gadgetSize );  //User size was already selected by the user..

				    $.ajax({
					   type: 'POST',
					   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Create',
					   data: {'gadget_data_id':gadget_id,'gadgetName' : gadgetName, 'userId' : userId, 'gadgetType' : gadgetType, 'gadget_detector_source' : gadget_detector_source, 'gadget_data_source' : gadget_data_source, 'gadgetSize' : gadgetSize, 'layoutId' : layoutId},
					   success: function(gadget_data_id){

					    var gadgetDataId = document.getElementById("gadgetDataId");
					    gadgetDataId.value = gadget_data_id;

					   }
				    });  //end ajax..

					 // alert('gg is ' + gg);

					  $("#"+gg+"-dialog-form-customize").dialog("open");
						$("#"+gg+"-dialog-form").dialog( "close" );

				   }  //end if OR..



				 }  //end  if  bValid..

		 } // end of saveAlertsGadget();


  function updateAlertGadget(){
  }

  function saveIdiotLightsGadget(){
  }

  function updateIdiotLightsGadget(){
  }

  function saveLiveStatusGadget(){
  }

  function updateLiveStatusGadget(){
  }
  function saveChartsGadget(){
  }

  function updateChartsGadget(){
  }
  function saveTablesGadget(){
  }

  function updateTablesGadget(){
  }

  function selectGadget(gadgetType,update){


  $('#gadgetId').val('');

     if(update !== undefined)
	console.log(update);
   var gadgetSetting = document.getElementById('gadgetType');
       gadgetSetting.value = gadgetType;

   $( "#select-gadget" ).dialog( "close" );

   if(gadgetType == 'Charts'){     // #gadgetType for Charts is statically set inside ' _chartGadget.php ' ...
    $("#Charts-dialog-form").dialog( "open" );
    document.getElementById("Charts_detectorSource").innerHTML = "";
    $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
			var option = document.createElement('option');
		 option.setAttribute( "value", "none");  //Abhinandan. Capitalize first letter..
		 option.innerHTML = "Select Table";   //Make innerHTML just what it already is..
				  document.getElementById("Charts_detectorSource").appendChild(option);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("Charts_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
   else if(gadgetType == 'Alerts'){
    $("#Alerts-dialog-form").dialog( "open" );
    document.getElementById("detectorSource").innerHTML = "";
    $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. ..
		 option.innerHTML = obj[i].charAt(0).toUpperCase() + obj[i].slice(1) ;   //Capitalize first letter..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
   else if(gadgetType == 'Tables'){
    $("#Tables-dialog-form").dialog( "open" );
    document.getElementById("Tables_detectorSource").innerHTML = "";
    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
			var option = document.createElement('option');
		 option.setAttribute( "value", "none");  //Abhinandan. Capitalize first letter..
		 option.innerHTML = "Select Table";   //Make innerHTML just what it already is..
				  document.getElementById("Tables_detectorSource").appendChild(option);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("Tables_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
   else if(gadgetType == 'IdiotLights'){
    $("#IdiotLights-dialog-form").dialog( "open" );
    document.getElementById("IdiotLights_detectorSource").innerHTML = "";
    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i] );  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("IdiotLights_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
   else if(gadgetType == 'LiveStatus'){
    $("#LiveStatus-dialog-form").dialog( "open" );
    document.getElementById("LiveStatus_detectorSource").innerHTML = "";
    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("LiveStatus_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
  }  //end selectGadget()..

  function updateGadget(gadgetType,gadget_id){


    // alert(gadgetType)
      //  console.log(update);
      var detectorLookUp = {};

	detectorLookUp.Analysis_combined = 'analysis_combined'
	detectorLookUp.Analysis_detector_1 = 'analysis_detector_1';
	detectorLookUp.Analysis_detector_2 = 'analysis_detector_2';
	detectorLookUp.Analysis_info = 'analysis_info';

   var gadgetSetting = document.getElementById('gadgetType');
       gadgetSetting.value = gadgetType;

   $( "#select-gadget" ).dialog( "close" );

   if(gadgetType == 'Charts'){     // #gadgetType for Charts is statically set inside ' _chartGadget.php ' ...
    $("#Charts-dialog-form").dialog( "open" );
    document.getElementById("Charts_detectorSource").innerHTML = "";
    $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("Charts_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..


    //**  Get Chart  Gadget information  **/
    $.ajax({
	   type: 'GET',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetGadgetDetail',
	   data:{id:gadget_id},
	   success: function(tables){
		  var obj = $.parseJSON(tables);
		  var gadget_options = obj['gadget_options'];
		  var gadget_elements = obj['gadget_elements'];


		  //$('#gadgetId') common place to store gadget is : by lakshmi

		  $('#gadgetId').val(gadget_options['gadget_data_id']);

		  $('#Charts_gadgetName').val(gadget_options['gadget_name']);

		  $('#Charts_detectorSource').val(gadget_options['detector_source']);

		  $('#Charts_chartStyle').val(gadget_options['display_style']);

		  $('#Charts_groupStyle').val(gadget_options['group_style']);

		  customizeButtons.setGroupStyle(gadget_options['group_style'])

		   $('#Charts_gadgetSize').val(gadget_options['gadget_size']);


		  // console.log(gadget_options['group_style']);

		   customizeButtons.setDetectorSource(gadget_options['detector_source'], 'Charts_dataSource', basePath);

		  //To populate side table
		  $('#Charts_gadget_data_source').val(gadget_options['data_source']);
		   customizeButtons.setCDataSource('999');


		 // console.log(obj['gadget_options']);
	   }
    });  //end ajax..


   }
   else if(gadgetType == 'Alerts'){
    $("#Alerts-dialog-form").dialog( "open" );
    document.getElementById("detectorSource").innerHTML = "";

    $.ajax({                   //Populate the data source drop-down after clicking on 'Charts' icon..
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..



    //Alert Gadget information
      $.ajax({
	   type: 'GET',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetGadgetDetail',
	   data:{id:gadget_id},
	   success: function(tables){
		  var obj = $.parseJSON(tables);
		  var gadget_options = obj['gadget_options'];
		  var gadget_elements = obj['gadget_elements'];


		  //$('#gadgetId') common place to store gadget is : by lakshmi

		  $('#gadgetId').val(gadget_options['gadget_data_id']);

		  $('#Alerts_gadgetName').val(gadget_options['gadget_name']);

		  $('#detectorSource').val(gadget_options['detector_source']);

		  $('#gadgetSize').val(gadget_options['gadget_size']);


		  customizeButtons.setDetectorSource(gadget_options['detector_source'], 'Alerts_element_dataItems', basePath)


		 // console.log(obj['gadget_options']);
	   }
    });  //end ajax..


   }
   else if(gadgetType == 'System_Messages'){

    var gadgetSetting = document.getElementById('gadgetType');
       gadgetSetting.value = 'Tables';
    $("#Tables-dialog-form").dialog( "open" );
    document.getElementById("Tables_detectorSource").innerHTML = "";


    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i] );  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("Tables_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..



    //**  Get Table  Gadget information  **/
    $.ajax({
	   type: 'GET',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetGadgetDetail',
	   data:{id:gadget_id},
	   success: function(tables){
		  var obj = $.parseJSON(tables);
		  var gadget_options = obj['gadget_options'];
		  var gadget_elements = obj['gadget_elements'];


		  //$('#gadgetId') common place to store gadget is : by lakshmi

		  $('#gadgetId').val(gadget_options['gadget_data_id']);

		  $('#Tables_gadgetName').val(gadget_options['gadget_name']);

		  $('#Tables_detectorSource').val(gadget_options['detector_source']);

		  $('#Tables_gadgetSize').val(gadget_options['gadget_size']);


		  //To populate side table
		  $('#Tables_gadget_data_source').val(gadget_options['data_source']);

		  customizeButtons.setDetectorSource(gadget_options['detector_source'], 'Tables_dataSource', basePath);
		  customizeButtons.setTDataSource('');

		 // $('#Tables_gadget_data_source').val();


		 // console.log(obj['gadget_options']);
	   }
    });  //end ajax..


   }
   else if(gadgetType == 'IdiotLights'){



    document.getElementById("IdiotLights_detectorSource").innerHTML = "";
    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i] );  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("IdiotLights_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..


    $("#IdiotLights-dialog-form").dialog( "open" );

    //Get  IdiotLights Gadget information
      $.ajax({
	   type: 'GET',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetGadgetDetail',
	   data:{id:gadget_id},
	   success: function(tables){
		  var obj = $.parseJSON(tables);
		  var gadget_options = obj['gadget_options'];
		  var gadget_elements = obj['gadget_elements'];


		  //$('#gadgetId') common place to store gadget is : by lakshmi

		  $('#gadgetId').val(gadget_options['gadget_data_id']);

		  $('#IdiotLights_gadgetName').val(gadget_options['gadget_name']);

		  $('#IdiotLights_detectorSource').val(gadget_options['detector_source']);

		  $('#IdiotLights_gadgetSize').val(gadget_options['gadget_size']);

		  var detectorSourceTable = detectorLookUp[''+gadget_options['detector_source']+''];

	       // console.log(detectorSourceTable);
		customizeButtons.setDetectorSource(gadget_options['detector_source'] , 'IdiotLights_element_dataItems', basePath);



		  console.log(gadget_options['detector_source']);
		 // console.log(obj['gadget_options']);
	   }
    });  //end ajax..

   }
   else if(gadgetType == 'Live_Status'){
    $("#LiveStatus-dialog-form").dialog( "open" );
    document.getElementById("LiveStatus_detectorSource").innerHTML = "";

    //Get  Live_Status Gadget information
      $.ajax({
	   type: 'GET',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetGadgetDetail',
	   data:{id:gadget_id},
	   success: function(tables){
		  var obj = $.parseJSON(tables);
		  var gadget_options = obj['gadget_options'];
		  var gadget_elements = obj['gadget_elements'];


		  //$('#gadgetId') common place to store gadget is : by lakshmi

		  $('#gadgetId').val(gadget_options['gadget_data_id']);

		  $('#LiveStatus_gadgetName').val(gadget_options['gadget_name']);

		  $('#LiveStatus_detectorSource').val(gadget_options['detector_source']);

		  $('#LiveStatus_gadgetSize').val(gadget_options['gadget_size']);




		  customizeButtons.setDetectorSource(gadget_options['detector_source'], 'LiveStatus_element_dataItems', basePath)

		  //console.log(gadget_options['detector_source']);
	   }
    });  //end ajax..
    $.ajax({
	   type: 'POST',
	   url: '<?php echo Yii::app()->baseUrl; ?>/dash/GetDataSourceTables',
	   success: function(tables){
	    var obj = $.parseJSON(tables);
	    for(var i=0; i<obj.length; ++i)
	    {
	     var option = document.createElement('option');
		 option.setAttribute( "value", obj[i]);  //Abhinandan. Capitalize first letter..
		 option.innerHTML = obj[i];   //Make innerHTML just what it already is..
		 option.setAttribute( "id", obj[i].charAt(0).toUpperCase() + obj[i].slice(1) );
		document.getElementById("LiveStatus_detectorSource").appendChild(option);
	    }
	   }
    });  //end ajax..

   }
  }  //end updateGadget()..




 //  Method editGadget()
 //   Purpose: Handles the user "click" of the dynamically rendered 'Customize' block ..

 //   @param blockNumber        ie  1
 //   @param crusty_gadgetType  ie  Alerts

 function editGadget(blockNumber, crusty_gadgetType){
      //alert(blockNumber +' , ' + crusty_gadgetType);

      if(blockNumber =='1' || blockNumber =='2' || blockNumber =='3' || blockNumber =='4' || blockNumber =='5' || blockNumber =='6' || blockNumber =='7' || blockNumber =='8' || blockNumber =='9' || blockNumber =='10' )
      {
       if(crusty_gadgetType == "Alerts"){
	var blockHidden = document.getElementById('edit-Alerts-dialog-currentCustomizeBlock');
	blockHidden.value = blockNumber;
	//alert("blockHidden.value is " + blockHidden.value);
	$("#edit-Alerts-dialog").dialog("open");
       }
       else if(crusty_gadgetType == "LiveStatus"){
	var blockHidden = document.getElementById('edit-LiveStatus-dialog-currentCustomizeBlock');
	blockHidden.value = blockNumber;
	//alert("blockHidden.value is " + blockHidden.value);
	$("#edit-LiveStatus-dialog").dialog("open");
       }
       else if(crusty_gadgetType == "IdiotLights"){
	var blockHidden = document.getElementById('edit-IdiotLights-dialog-currentCustomizeBlock');
	blockHidden.value = blockNumber;
	//alert("blockHidden.value is " + blockHidden.value);
	$("#edit-IdiotLights-dialog").dialog("open");               ////left off here.. NEED TO FIX all the 3 vs 5 colors not opening up properly..
       }
       else if(crusty_gadgetType == "Charts"){
	var blockHidden = document.getElementById('edit-Charts-dialog-currentCustomizeBlock');
	blockHidden.value = blockNumber;
	//alert("blockHidden.value is " + blockHidden.value);
	$("#edit-Charts-dialog").dialog("open");               ////left off here.. NEED TO FIX all the 3 vs 5 colors not opening up properly..
       }
      }
   } //end editGadget()..




    //  Abhinandan.
    //  showItemSet() for '_statusGadget' :
    //   @param whichBlock The '+ Customize' Button we are customizing..

    function showItemSet(whichBlock, singularFirstUpper, pluralFirstUpper){
     if(whichBlock=='1')
     {
      var block = document.getElementById(pluralFirstUpper + "blockA");
     }
     else if(whichBlock=='2')
     {
      var block = document.getElementById(pluralFirstUpper + "blockB");
     }
     else if(whichBlock=='3')
     {
      var block = document.getElementById(pluralFirstUpper + "blockC");
     }
     else if(whichBlock=='4')
     {
      var block = document.getElementById(pluralFirstUpper + "blockD");
     }
     else if(whichBlock=='5')
     {
      var block = document.getElementById(pluralFirstUpper + "blockE");
     }
     else if(whichBlock=='6')
     {
      var block = document.getElementById(pluralFirstUpper + "blockF");
     }
     else if(whichBlock=='7')
     {
      var block = document.getElementById(pluralFirstUpper + "blockG");
     }
     else if(whichBlock=='8')
     {
      var block = document.getElementById(pluralFirstUpper + "blockH");
     }
     else if(whichBlock=='9')
     {
      var block = document.getElementById(pluralFirstUpper + "blockI");
     }
     else if(whichBlock=='10')
     {
      var block = document.getElementById(pluralFirstUpper + "blockJ");
     }

     var chosenDataItem = document.getElementById('chosenDataItem-' + singularFirstUpper + '-' + whichBlock);

     var hidden_userNoDataItemSelection = document.getElementById('userNoDataItemSelection-' + singularFirstUpper + '-' + whichBlock);  //Check if user made a selection or not..

     if( (hidden_userNoDataItemSelection.value == 'yes') ) //If user did not make a selection..
     {
      if(  (pluralFirstUpper != 'LiveStatus') && (pluralFirstUpper != 'IdiotLights') )  //If != LiveStatus AND != IdiotLights
      {
       var chosenDataItem_value = "Aluminum";
	   chosenDataItem = document.getElementById('chosenDataItem-' + singularFirstUpper + '-' + whichBlock); //Go ahead and SET the chosenDataItem as our default value "Element 1"..
	   chosenDataItem.value = chosenDataItem_value;
      }
      else if(  pluralFirstUpper == 'IdiotLights' )  //If == IdiotLights
      {
       var chosenDataItem_value = "H Peak";
	   chosenDataItem = document.getElementById('chosenDataItem-' + singularFirstUpper + '-' + whichBlock); //Go ahead and SET the chosenDataItem as our default value "Element 1"..
	   chosenDataItem.value = chosenDataItem_value;
      }
      else if(  pluralFirstUpper == 'LiveStatus' )  //If == LiveStatus
      {
       var chosenDataItem_value = "Silicon";
	   chosenDataItem = document.getElementById('chosenDataItem-' + singularFirstUpper + '-' + whichBlock); //Go ahead and SET the chosenDataItem as our default value "Element 1"..
	   chosenDataItem.value = chosenDataItem_value;
      }
     }
     else if( hidden_userNoDataItemSelection.value == 'no' )
     {
      var chosenDataItem_value = document.getElementById('chosenDataItem-' + singularFirstUpper + '-' + whichBlock);
	  chosenDataItem_value = chosenDataItem_value.value;
     }

     block.innerHTML = chosenDataItem_value;
     $(this).dialog('close');
     return true;

    } //end showItemSet()..



    function addGadget(type){
     //alert('inside addGadget');
     if(type == 'Alerts'){
      var gt = $("#Alerts_sGadgetType").val();
      //alert('gt is ' + gt);
     }
     else if(type == 'IdiotLights'){
      var gt = $("#IdiotLights_sGadgetType").val();
      //alert('addGadget, IdiotLights, gt is ' + gt);
     }
     else if(type == 'Charts'){
      //alert('inside Charts');
      var gt = $("#Charts_sGadgetType").val();
      //alert('addGadget, Charts, gt is ' + gt);
     }
     else if(type == 'Tables'){
      //alert('inside Tables');
      var gt = $("#Tables_sGadgetType").val();
      //alert('addGadget, Tables, gt is ' + gt);
     }
     else if(type == 'LiveStatus'){
      var gt = $("#LiveStatus_sGadgetType").val();
      if(gt == 'LiveStatus')
      {
       gt = 'Live_Status';
      }
      //alert('addGadget, LiveStatus, gt is now ' + gt);
     }

	   $("#divHolder").append($("#"+gt+"_HDiv").html());
    }


  function saveLayout(){


      $("#isLayoutSelected").val('yes');
      $("#new-layout-dialog").dialog("destroy");
      $("#select-gadget" ).dialog( "open" );
  }


  function openGadgetDirectory(){

      $("#select-layout-dialog").dialog("close")
      $("#select-gadget" ).dialog( "open" );

       $("#isLayoutSelected").val('yes');

  }

 $("#addNewLayout").click(function(){

   document.getElementById('addNewLayout_btn_click').value = "true";              //Signals that this is indeed going to be a new layout..
   document.getElementById('addNewGadget_existing_layout_lay_id').value = "";     //""..

   document.getElementById('addNewLayout').className = "button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only";
   $("#addNewGadget").hide();
   var divHolder = document.getElementById('divHolder');
       divHolder.innerHTML = "";

   document.getElementById('layout_workshop_h2').innerHTML = "";
   document.getElementById('layout_workshop_h2').innerHTML = "Layout Workshop";
   document.getElementById('layout-title').innerHTML = "";
   document.getElementById('layout-title').innerHTML = "Create/Update Layouts";

   document.getElementById('shadedworkshop').className = "shaded";


    $("#select-layout-dialog").dialog("close");
    $("#dialog-form-new").dialog("open");

 });


 $("#addNewGadget").click(function(){
    document.getElementById('addNewLayout_btn_click').value = "false"; //Signals that this is indeed going to be a gadget added to an existing layout..
    $("#select-layout-dialog").dialog("close");
    $("#select-gadget").dialog("open");

 });



  function selectTablet(tabletType){


      $( "#Alerts-dialog-form" ).dialog( "close" );
      $("#dialog-form").dialog( "open" );
  }



  /* Abhinandan.
  *To select existing layout
  *@param  opt  The layout selection from the drop-down
  */

 function selectLayout(opt)
 {
  var sw = document.getElementById('shadedworkshop');
  sw.className = "";
  if(sw.childNodes[0])
  {
   sw.removeChild( sw.childNodes[0] );
  }

  $("#addNewGadget").show();


  document.getElementById("addNewGadget_hidden").value = 'show';
  //addNewGadget
  var layout_workshop_h2 = document.getElementById('layout_workshop_h2');
      layout_workshop_h2.innerHTML = "";
      layout_workshop_h2.text      = "Layout Workshop ";

  var layout_title       = document.getElementById('layout-title');
      layout_title.innerHTML = "";
      layout_title.text      = "Create/Update Layouts";

  var layoutId = document.getElementById('layoutId');
  if(opt == 'default')   //yes..
  {
   //alert('selectLayout(), if');
   $('#divHolder').html('');
       layoutId.value = $('#eLayouts1').val();

       fetchLayoutGadgets( layoutId.value, 'firstTime' );
  }
  else{  //If we are adding gadgets to an existing layout..
   document.getElementById('divHolder').innerHTML = "";
   layoutId.value = opt;

   fetchLayoutGadgets( layoutId.value, 'moreGadgets' );
  }

  $("#isLayoutSelected").val('yes');
  $("#select-layout-dialog").dialog("close");
  $(this).dialog("close");

 }



 /*
 *  Abhinandan.
 *   @Invoked by selectLayout()..
 */

 function fetchLayoutGadgets(layId, firstOrmore)
 {
  //alert("Reloading all the gadgets: Please wait!");
  $("#shadedworkshop").html("<p id='contentLoader'>" +
				       "<img id='loadinggraphicer' width='16' height='16' src='<?php echo Yii::app()->baseUrl; ?>/images/ajax-loader-eeeeee.gif' /> " +
				       "Loading...</p>");

 window.setTimeout(function (){
  //b =0;
  $.ajax({
   type: 'POST',
   url: '<?php echo Yii::app()->baseUrl; ?>/dash/Getgadgets',
   data: { 'layoutId' : layId, 'firstOrmore' : firstOrmore },
   success: function(jsonGlist){
    //alert("Loading Gadgets");
    //alert("jsonGlist-Values" + jsonGlist);

    //Need to set hidden div with our 'message'.. gadget_data_id..
    $("#contentLoader").remove();
    var jobject = JSON.parse(jsonGlist);
    var layoutName = jobject['layoutName'];
    var layoutButtonsVals = $("#layoutButtonsVals").val();
  //  console.log(jobject);

    if(layoutButtonsVals == 0)
    {
	    $('#layout-title').text( layoutName );
	    $('#layout_workshop_h2').append( layoutName ); //Change Here
	    $("#buttonsHolder").append('<div id="layoutbuttons" style="float:right;margin-top:-25px;">'+
								//'<button id="DefSetLayout" onclick="return defLayCall('+layId+');" class="button butCall ui-button ui-state-success ui-corner-all ui-button-text-only"><span class="ui-button-text">Set Default-Layout</span></button>'+
								'<button id="DelLayout"  onclick="return delLayCall('+layId+');" class="button  butCall ui-button ui-state-error ui-corner-all ui-button-text-only"><span class="ui-button-text">Delete Layout</span></button></div>');
	    $("#layoutButtonsVals").val(1);
	}
    var temp_arr = new Array();

    for(key in jobject['layout_info']){
     if( (jobject['layout_info'][key]['distinct_gadget'] == false) || (jobject['layout_info'][key]['distinct_gadget'] == true) )
     {
      for(intIndex in jobject['layout_info'][key])
      {
       if( !isNaN( intIndex ) )
       {
	temp_arr[intIndex] = jobject['layout_info'][key][intIndex];
       }
      }
     }

     document.getElementById('fetchLayoutGadgets_tempArr').value = JSON.stringify(temp_arr);  //This serialized object will be used by 'dashboard.js' ...
    }
    for( var j=0; j<temp_arr.length; ++j )
    {
     var gid        = temp_arr[j]['gadget_data_id'];
     var gt         = temp_arr[j]['gadget_type'];
     var gname      = temp_arr[j]['gadget_name'];
     var g_wS_value = temp_arr[j]['gadget_widString_value'];

     document.getElementById('addNewGadget_existing_layout_lay_id').value = temp_arr[j]['lay_id']; //Set up top, incase the user wishes to add more gadgets to the layout..

     dumpLayout(j,gid, gt, gname, g_wS_value);
    }

   } //end success (ajax)..

  }); //end ajax..

  },200); //SetInterval

 }  //end  fetchLayoutGadgets()..


 //All of the ".setAttribute" nodes you see is because of:
 // $portlets (up top) only loads the current gadPlacement,
 //   therefore when we add ie 'Live_Status' for the first time,
 //   then we need to also add-in the proper "Live_Status_HDiv" to
 //   the document.body and append it(".._HDiv") to the "divHolder" element.
 //  IMPORTANT!!: Abhinandan. See Intitialization up top, here I am removing all the 'xxxx_HDiv' elements, as we will re-create them anyways see below inside function 'dumpLayout()'..
 function dumpLayout(plid, gid, gt, gname, g_wS_value)
 {
  //alert('inside dumpLayout, gid is ' + gid + ', gt is ' + gt + ', gname is ' + gname + ', g_wS_value is ' + g_wS_value + '');

  $("#addNewGadget_hidden").val("show");

  //Instructions: How to Test these values..
  //Go into 'gadlay_layouts' and change the 'default_layout' == 1
  // where the layout does NOT have any of the type of gadget (ie Live_Status)
  // you are testing for.
  // Then go to dash/Create and click on New Layout, try adding a gadget to see
  // the 'IMG' height/width change.
  var layoutIdVal = document.getElementById('layoutId').value;

  var png_lookup = {
		   Alerts : {
			     alias  : 'alerts',
			     size   : {
				      2 : {
					  height : 200,
					  width  : 200
				      }
			     }
		   },

		   Charts : {
			     alias  : 'charts',
			     size   : {

				      4 : {
					  height : 200,
					  width  : 450
				      },
				      6 : {
					  height : 200,
					  width  : 550
				      }
			     }
		   },

		   IdiotLights : {
			     alias  : 'ilights_m',
			     size   : {
				      6 : {
					  height : 100,
					  width  : 650
				      }
			     }
		   },

		   Live_Status : {
			     alias  : 'livestat',
			     size   : {
				      2 : {
					  height : 200,
					  width  : 200
				      },

				      4 : {
					  height : 200,
					  width  : 450
				      },

				      6 : {
					  height : 200,
					  width  : 550
				      }
			     }
		   },

		   System_Messages : {
			     alias  : 'tables',
			     size   : {

				      4 : {
					  height : 200,
					  width  : 450
				      },
				      6 : {
					  height : 200,
					  width  : 550
				      }
			     }
		   }
  };

  var sw = document.getElementById('shadedworkshop');
  sw.className = "";

  if(sw.childNodes.length > 0)   //Only remove once, since this method gets called multiple times..
  {
   sw.removeChild( sw.childNodes[0] );
  }
	var divHolder = document.getElementById('divHolder');
	var gt_HDiv = document.createElement("div");
	var g_wS_value_s = 0;

	gt_HDiv.setAttribute("id", gt + "_HDiv_" + gid + "" );       //Abhinandan: July9th 2013..
	gt_HDiv.setAttribute("style", "display:none;");

	/*Abhinandan Change 10-15-13 SuddenChange */
	if(g_wS_value == 6)
		g_wS_value_s = "6 size6to5";
	else if(g_wS_value == 2)
		g_wS_value_s = "2 size3to2";
	else
		g_wS_value_s = g_wS_value;

	//alert("size" + g_wS_value_s);

		gt_HDiv_child = document.createElement("div");
		gt_HDiv_child.setAttribute("class", "grid_" + g_wS_value_s + " portlet ui-sortable clearfix padMargin collapsible" );
		gt_HDiv_child.setAttribute("title", g_wS_value);
		gt_HDiv_child.setAttribute("draggable", "true");
		gt_HDiv_child.setAttribute("id", gt + ":" + gid);         //Abhinandan: July9th 2013..
		gt_HDiv.appendChild( gt_HDiv_child );

		gt_HDiv_child_header = document.createElement("header");
		gt_HDiv_child_header.setAttribute("class", "ui-widget-header ui-corner-top");
		gt_HDiv_child.appendChild( gt_HDiv_child_header );

		gt_HDiv_child_header_ul = document.createElement("ul");
		gt_HDiv_child_header_ul.setAttribute("class", "pagination clearfix leading minusPad");
		gt_HDiv_child_header.appendChild( gt_HDiv_child_header_ul );

		gt_HDiv_child_header_ul_li = document.createElement("li");
		gt_HDiv_child_header_ul_li.setAttribute("class", "page");
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li );

		gt_HDiv_child_header_ul_li_span = document.createElement("span");
		gt_HDiv_child_header_ul_li_span.setAttribute("class", "spacer");
		gt_HDiv_child_header_ul_li.appendChild( gt_HDiv_child_header_ul_li_span );

		gt_HDiv_child_header_ul_li_2 = document.createElement("li");
		gt_HDiv_child_header_ul_li_2.setAttribute("class", "page");
		gt_HDiv_child_header_ul_li_2.setAttribute("style", "padding-right:25px");
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_2 );

		gt_HDiv_child_header_ul_li_2_a = document.createElement("a");
		gt_HDiv_child_header_ul_li_2_a.setAttribute("class", "ui-icon-circle-close-ATag");
		gt_HDiv_child_header_ul_li_2_a.setAttribute("alt", "#" + gt);
		gt_HDiv_child_header_ul_li_2_a.setAttribute("onclick",  "return deleteGadget(\"" + plid + "\",\"" + layoutIdVal + "\",\"" + gid + "\")");
		gt_HDiv_child_header_ul_li_2.appendChild( gt_HDiv_child_header_ul_li_2_a );

		 gt_HDiv_child_header_ul_li_2_a_span = document.createElement("span");
		 gt_HDiv_child_header_ul_li_2_a_span.setAttribute("class", "ui-button-icon-primary ui-icon ui-icon-circle-close");
		gt_HDiv_child_header_ul_li_2_a.appendChild( gt_HDiv_child_header_ul_li_2_a_span );

		/* Edit Button added by Lakshmi on 07-02-2014
		 *
		 */
		gt_HDiv_child_header_ul_li_4 = document.createElement("li");
		gt_HDiv_child_header_ul_li_4.setAttribute("class", "page");
		gt_HDiv_child_header_ul_li_4.setAttribute("style", "padding-right:25px");
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_4 );

		gt_HDiv_child_header_ul_li_4_a = document.createElement("a");
		gt_HDiv_child_header_ul_li_4_a.setAttribute("class", "ui-icon-circle-close-ATag");
		gt_HDiv_child_header_ul_li_4_a.setAttribute("alt", "#" + gt);
		gt_HDiv_child_header_ul_li_4_a.setAttribute("onclick",  "return updateGadget(\"" + gt + "\",\"" + gid + "\")");
		gt_HDiv_child_header_ul_li_4.appendChild( gt_HDiv_child_header_ul_li_4_a );

		gt_HDiv_child_header_ul_li_4_a_span = document.createElement("span");
		gt_HDiv_child_header_ul_li_4_a_span.setAttribute("class", "ui-button-icon-primary ui-icon ui-icon-pencil");
		gt_HDiv_child_header_ul_li_4_a.appendChild( gt_HDiv_child_header_ul_li_4_a_span );


		gt_HDiv_child_header_ul_li_3 = document.createElement("li");
		gt_HDiv_child_header_ul_li_3.setAttribute("class", "page title");
		gt_HDiv_child_header_ul_li_3.innerHTML = gname;
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_3 );

		/*
	    //Only show 'M' and 'L' for Charts,Live_Status, and System_Messages gadgets..
		//if( gt == 'Charts' || gt == 'Live_Status' || gt == 'System_Messages' )
		//AbhiTempHidden
		if(0)
		{
			gt_HDiv_child_header_ul_li_4 = document.createElement("li");
			gt_HDiv_child_header_ul_li_4.setAttribute("id", gt + "_lBut");
			gt_HDiv_child_header_ul_li_4.setAttribute("class", "last fRight current cY");
			gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_4 );

			gt_HDiv_child_header_ul_li_4_a = document.createElement("a");
			gt_HDiv_child_header_ul_li_4_a.setAttribute("onclick", "changeCssSize('Charts', 'l', '6'); return false;");
			gt_HDiv_child_header_ul_li_4_a.setAttribute("href", "#");
			gt_HDiv_child_header_ul_li_4_a.innerHTML = "L";
			gt_HDiv_child_header_ul_li_4.appendChild( gt_HDiv_child_header_ul_li_4_a );

			gt_HDiv_child_header_ul_li_5 = document.createElement("li");
			gt_HDiv_child_header_ul_li_5.setAttribute("id", gt + "_mBut");
			gt_HDiv_child_header_ul_li_5.setAttribute("class", "last fRight");
			gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_5 );

			gt_HDiv_child_header_ul_li_5_a = document.createElement("a");
			gt_HDiv_child_header_ul_li_5_a.setAttribute("onclick", "changeCssSize('Charts', 'm', '4'); return false;");
			gt_HDiv_child_header_ul_li_5_a.setAttribute("href", "#");
			gt_HDiv_child_header_ul_li_5_a.innerHTML = "M";
			gt_HDiv_child_header_ul_li_5.appendChild( gt_HDiv_child_header_ul_li_5_a );
		}


		//Edit Gadget Option
		//AbhiTempHidden
		if(0)
		{
			gt_HDiv_child_header_ul_li_6 = document.createElement("li");
			gt_HDiv_child_header_ul_li_6.setAttribute("class", "last fRight");
			gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_li_6 );

			gt_HDiv_child_header_ul_li_6_a = document.createElement("a");
			gt_HDiv_child_header_ul_li_6_a.setAttribute("id", "editGadget");
			gt_HDiv_child_header_ul_li_6_a.setAttribute("href", "javascript:void(0)");
			gt_HDiv_child_header_ul_li_6_a.setAttribute("onclick", "alert( this.parentNode.parentNode.childNodes[5].value )");  //Abhinandan. Hardcoded for testing purposes..
			//            gt_HDiv_child_header_ul_li_6_a.setAttribute("onclick", "customizeGadget('Charts')");
			gt_HDiv_child_header_ul_li_6.appendChild( gt_HDiv_child_header_ul_li_6_a );

			gt_HDiv_child_header_ul_li_6_a_span = document.createElement("span");
			gt_HDiv_child_header_ul_li_6_a_span.setAttribute("class", "ui-button-icon-primary ui-icon ui-icon-pencil");
			gt_HDiv_child_header_ul_li_6_a.appendChild( gt_HDiv_child_header_ul_li_6_a_span );
		}
		*/

		gt_HDiv_child_header_ul_input = document.createElement("input");
		gt_HDiv_child_header_ul_input.setAttribute("id", gt + "_Hid");
		gt_HDiv_child_header_ul_input.setAttribute("type", "hidden");
		gt_HDiv_child_header_ul_input.setAttribute("value", g_wS_value);
		gt_HDiv_child_header_ul_input.setAttribute("name", gname);
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_input );

		gt_HDiv_child_header_ul_gid_input = document.createElement("input");    //Abhinandan. July9th 2013: Changed to set hidden gadget_id for use later by dashboard.js..
		gt_HDiv_child_header_ul_gid_input.setAttribute("id", gt + "_gid");
		gt_HDiv_child_header_ul_gid_input.setAttribute("type", "hidden");
		gt_HDiv_child_header_ul_gid_input.setAttribute("value", gid);
		gt_HDiv_child_header_ul_gid_input.setAttribute("name", gname);
		gt_HDiv_child_header_ul.appendChild( gt_HDiv_child_header_ul_gid_input );

		gt_HDiv_child_section = document.createElement("section");
		gt_HDiv_child_section.setAttribute("class", "ui-widget-content ui-corner-bottom");
		gt_HDiv_child.appendChild( gt_HDiv_child_section );

		gt_HDiv_child_section_div = document.createElement("div");
		gt_HDiv_child_section_div.setAttribute("id", gt + "1");
		gt_HDiv_child_section_div.setAttribute("style", "text-align:center; height:200px");
		gt_HDiv_child_section.appendChild( gt_HDiv_child_section_div );


		gt_HDiv_child_section_div_img = document.createElement("img");
		gt_HDiv_child_section_div_img.setAttribute("width", png_lookup[gt].size[g_wS_value].width );
		gt_HDiv_child_section_div_img.setAttribute("height", png_lookup[gt].size[g_wS_value].height );

		var baseUrl = '<?php echo Yii::app()->baseUrl; ?>' ;
		gt_HDiv_child_section_div_img.setAttribute("src", baseUrl + "/themes/tutorialzine1/images/snaps/" + png_lookup[gt].alias + ".png");
		gt_HDiv_child_section_div.appendChild( gt_HDiv_child_section_div_img );
	  document.body.appendChild( gt_HDiv );


    /*
    }else{
      gt_visible.className = "grid_" + g_wS_value + " portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all";

      alert('inside else loop');
      alert('gid is ' + gid + '');
      gt_HDiv_child_header_ul_gid_input = document.createElement("input");    //Abhinandan. July9th 2013: Changed to set hidden gadget_id for use later by dashboard.js..
	       gt_HDiv_child_header_ul_gid_input.setAttribute("id", gt + "_gid");
	       gt_HDiv_child_header_ul_gid_input.setAttribute("type", "hidden");
	       gt_HDiv_child_header_ul_gid_input.setAttribute("value", gid);
	       gt_HDiv_child_header_ul_gid_input.setAttribute("name", gname);
	      gt_visible.appendChild( gt_HDiv_child_header_ul_gid_input );

      var gt_Hid_input = document.getElementById( gt + "_Hid");  //Its like it already exists.. It lives inside gt_visible..
       gt_Hid_input.value = g_wS_value;
       //gt_Hid_input.value = gid;            //Abhinandan. July9th 2013: Changed to set hidden gadget_id for use later by dashboard.js..


    }
    */


   //var gt_visible   = document.getElementById( gt );
  //     gt_visible.className = "grid_" + g_wS_value + " portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all";



    /*
    $("#"+gt+"_HDiv .title").text(gname);                                          //ie #IdiotLights_HDiv     This is here to please the user..
    $("#divHolder").append($("#"+gt+"_HDiv").html());                             //Append to our parent div..
    document.getElementById('divHolder').className = "ui-sortable shaded";
    */

    //Abhinandan: July9th 2013: Made it so that each 'HDiv' is unique id 'Alerts_1010' , 'Alerts_1011' , etc..
    $("#"+gt+"_HDiv_"+gid+" .title").text(gname);
    $("#divHolder").append($("#"+gt+"_HDiv_"+gid+"").html());
    document.getElementById('divHolder').className = "ui-sortable shaded";



    //document.getElementById("divHolder").appendChild(type_Hid_gid);


   //alert('before changeCssSize(), gt is ' + gt + ', s is ' + s + ', gt_Hid_input.value is ' + gt_Hid_input.value);       //DEBUG not showing up properly..

   //changeCssSize(gt, s, gt_Hid_input.value);       //Show the actual sizes to the user..

 }//end Abhinandan. dumpLayout()..


function deleteGadget(plid,l,g) {
    //alert("Still need to form new widstring after deletion");

	var urldata = "<?php echo Yii::app()->baseUrl; ?>/gadgetsManager/delete/" + g;
	//alert(l+":"+g);
    $.ajax({
	   type: 'POST',
	   url: urldata,
	   data: {'lid' : l,'gid' : g,'plid' : plid},
	   success: function(response){
		   //alert(response);
		       //alert("Gadget Deleted Successfully!");
		       //fetchLayoutGadgets(l, 'firstTime');
		       window.location="<?php echo Yii::app()->baseUrl;?>/dash/create";
	   }
    });  //end ajax..

	return true;
}


 /*
 * Abhinandan.
*  changeCss() (originally borrowed from 'global.js')
*   1.) Assign grid size..
*
*    @param  str  t     .. '#IdiotLights'
*    @param  str  s     .. 'l'
*    @param  str  v     .. '6'
*
*/
function changeCssSize(t,s,v) {
	 alert('changeCssSize here!');
	 var parentW = document.getElementById(t);
	     parentW_title = parentW.title;
	  alert('changeCssSize(), parentW_title is ' + parentW_title );
	 var widArray = {
		  'l':'fit_table',
		  'm':4,
		  's':2
   };

	 var gridval  = widArray[s];

   document.getElementById(t + '_mBut').className = document.getElementById(t + '_mBut').className.replace('current','');
   document.getElementById(t + '_lBut').className = document.getElementById(t + '_mBut').className.replace('current','');
   document.getElementById(t + '_' + s + 'But').className = 'last fRight current cY';

   var tHid = document.getElementById(t + '_' + 'Hid');
       tHid.value = v;

   var what_replace = 'grid_' + parentW_title;
   document.getElementById(t).className = document.getElementById(t).className.replace(what_replace, '');
   if(gridval == 'fit_table'){
    document.getElementById(t).className = 'grid portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all';
   }
   else{
    document.getElementById(t).className = 'portlet ui-sortable clearfix padMargin collapsible ui-widget ui-widget-content ui-corner-all ' + 'grid_' + gridval;
   }
   parentW_title = gridval;


}

$('#chartElementsTable').dataTable( {
    "bPaginate": false,
    "bLengthChange": false,
    "bFilter": false,
    "bSort": false,
    "bInfo": false,
    "bAutoWidth": false,
    "bDestroy": true,
} );

$('#tablesElementsTable').dataTable( {
    "bPaginate": false,
    "bLengthChange": false,
    "bFilter": false,
    "bSort": false,
    "bInfo": false,
    "bAutoWidth": false,
    "bDestroy": true,
} );





function delLayCall(lid)
{
  $.ajax({
   type: 'POST',
   url: "<?php echo Yii::app()->baseUrl; ?>/manager/delete/"+lid,
   success: function(){
	window.location="<?php echo Yii::app()->baseUrl;?>/dash/create";
   },
  });
}

function defLayCall(lid)
{
  $.ajax({
   type: 'POST',
   url: "<?php echo Yii::app()->baseUrl; ?>/manager/update/"+lid,
   success: function(){
	alert("Default Layout has been updated to the current Layout!");
   },
  });
}
 </script>

	</section>
	<!-- Main Section End -->
    </div>

    <?php

 }}

}

?>

</section>