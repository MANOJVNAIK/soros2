<?php
/* @var $this ProductProfileController */
/* @var $model ProductProfile */


$addLink = Yii::app()->createAbsoluteUrl('rawmix/settings');

$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;

$postSubmitYes = @$_REQUEST["reloadHid"];
if($postSubmitYes) {
	header("Location: $baseUrl/rawmix/calib");
}

$productProfileSerializeUrl = Yii::app()->createAbsoluteUrl('rawmix/ActiveProfile');
$viewProfileLogUrl = Yii::app()->createAbsoluteUrl('rawmix/ViewProfileLog');
$checkNameAvailablity = Yii::app()->createAbsoluteUrl('rawmix/CheckNameAvailable');
$deleteProfileUrl = Yii::app()->createAbsoluteUrl('rawmix/DeleteProfileLog');

//view_profile_log_url
$cs->registerScript('profileConf', ""
	. "var product_profile_serialize_url = '{$productProfileSerializeUrl}';"
	. "var view_profile_log_url = '{$viewProfileLogUrl}';"
	. "var check_name_avilable_url = '{$checkNameAvailablity}';"
	. "var delete_profile_url = '{$deleteProfileUrl}';", CClientScript::POS_BEGIN);
?>
<section class="main-section grid_8">
    <nav class="">
	<!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
	<?php
	$layoutY = $this->layout;
	$them = Yii::app()->theme->name;

	$this->renderPartial('rawmixLeftMenu');
	?>
    </nav>
    <div class="main-content">

	<section class="container_6 clearfix">
	    <!-- Tabs inside Portlet -->
	    <div class="grid_6 leading">


		<div class="portlet collapsible" id="widget-latestactivity">

		    <header class="ui-widget-header ui-corner-topui-widget-header ui-corner-top">

			<h2><?php echo Yii::t('admin',"Product Profile");?></h2>

		    </header>

		    <section class="no-padding clearfix">
<div class="clearfix">  <br>
	<!--
			<a class="button pull-left" style="margin:5px;"  href="<?php echo $addLink ?>"  data-icon-primary="ui-icon-circle-plus" > Add Profile </a>
	 -->


			<table class="full clearfix list-table" style="border-top:1px solid graytext;margin-top: 25px; ">
			    <thead>
			    <th  style="width:5%" class="ui-state-default" ><input type="checkbox"></th>
			    <th  style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"Product Id");?></th>
			    <th  style="width:15%" class="ui-state-default"><?php echo Yii::t('admin',"Active");?></th>
			    <th  style="width:30%" class="ui-state-default"><?php echo Yii::t('admin',"Product Name");?></th>
			    <th style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"Created");?></th>
			    <th style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"Updated");?></th>
			    <th style="width:10%" class="ui-state-default">
				<img width="30" src="<?php echo Yii::app()->theme->baseUrl ?>/images/navicons/20.png">
			    </th>
			    </thead>

			    <tbody>
				<?php
				$this->widget('zii.widgets.CListView', array(
				    'dataProvider' => $dataProvider,
				    'itemView' => '_product_profile_row',
					'summaryText' => '',
					'emptyText' => Yii::t('app', 'No Results Found')
				));
				?>
			    </tbody>

			</table>
	     </div>
	     <br/><br/>

		    <div class="clearfix">
			<header class="ui-widget-header ui-corner-top">
				<h2><?php echo Yii::t("admin","Profile History")?></h2>
			</header>
			<section class="ui-widget-content ui-corner-bottom">
				    <div class="clearfix">
			<table class="full clearfix list-table" style="border-top:1px solid graytext;margin-top: 25px;margin-bottom:200px; ">
			    <thead>

			    <th  style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"SI");?></th>
			    <th  style="width:20%" class="ui-state-default"><?php echo Yii::t('admin',"Product Name");?></th>
			    <th  style="width:20%" class="ui-state-default"><?php echo Yii::t('admin',"Profile Name");?></th>
			     <th  style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"User Id");?></th>

			    <th style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"Created");?></th>
			    <th style="width:10%" class="ui-state-default"><?php echo Yii::t('admin',"Updated");?></th>
			    <th style="width:10%" class="ui-state-default">
				<img width="30" src="<?php echo Yii::app()->theme->baseUrl ?>/images/navicons/20.png">
			    </th>
			    </thead>

			    <tbody>
				<?php
				$this->widget('zii.widgets.CListView', array(
				    'dataProvider' => $dataProfileLog,
				    'itemView' => '_profile_log_row',
					'summaryText' => '',
					'emptyText' => Yii::t('app', 'No Results Found')
				));
				?>
			    </tbody>

			</table>
					</div>
					</section>
					</div>
		    </section>
		</div>
	    </div>
	</section>
    </div>
</section>

<input type="hidden" id="h_select_product_id" name=""/>


<div style='display:none'>
    <div id="active-confirm-dialog" title="Warning">
<div class="ui-widget message closeable">

				    <div class="ui-state-error  ui-corner-all">

					<p>


					  <?php echo Yii::t('admin',"It will overwrite previous product profile");?>
					 .<br/>
					<?php echo Yii::t('admin',"Do you want to continue?"); ?>

					</p>

				    </div>

				</div>

    </div>


      <div id="profile-delete-confirm-dialog" title="Warning">
	    <div class="ui-state-error  ui-corner-all">

		<h5 >
		      <span class="ui-icon ui-icon-alert" style="display:inline"></span>

		     <?php echo Yii::t('admin',"Do you want to delete this Profile?"); ?>
		   </h5>
	    </div>

      </div>

    <div id="profile-name-form">
	<form class="form has-validation">

	    <div class="clearfix">

		<label class="form-label" for="form-name">    <?php echo Yii::t('admin',"Profile Name");?> <em>*</em><small><?php echo Yii::t('admin',"Enter Unique Profile name");?></small></label>

		<div class="form-input">

		    <input required="required" name="profile_name" id="profile_name" type="text">

		</div>

	    </div>

	</form>

	<div class="clearfix">

	    <div class="form-input">
		<button onclick="checkProfileNameAvilablity()"> <?php echo Yii::t('admin',"Check Availability");?></button>
	    </div>

	</div>

    </div>

    <div id="view-profile">


    </div>

</div>

<form id="reloader" method="post" action="<?php echo $baseUrl; ?>/rawmix/admin">
	<input type="hidden" name="reloadHid" id="reloadHid" value="1"/>
</form>
<style type="text/css">
#cssmenu a:hover{background:#C1FFC1;color:black}
</style>
<script type="text/javascript">

    window.onload = function() {

	$('#cssmenu').prepend('<div id="menu-button">Menu</div>');
	$('#cssmenu #menu-button').live('click', function() {
	    var menu = $(this).next('ul');
	    if (menu.hasClass('open')) {
		menu.removeClass('open');
	    }
	    else {
		menu.addClass('open');
	    }
	});


$("#profile-delete-confirm-dialog").dialog({
	    autoOpen: false,
	    height: 150,
	    width: 300,
	    modal: true,

	    buttons: {
		"Delete": function() {

		   deleteProfileLog();

		    $(this).dialog("close");
		},
		Cancel: function() {
		    $(this).dialog("close");
		}
	    },
	    close: function() {

	    }
	});
	$("#active-confirm-dialog").dialog({
	    autoOpen: false,
	    height: 200,
	    width: 400,
	    modal: true,

	    buttons: {
		"Continue": function() {

		    viewProfileLog();

		    $(this).dialog("close");
		},
		Cancel: function() {
		    $(this).dialog("close");
		}
	    },
	    close: function() {

	    }
	});


	$("#profile-name-form").dialog({
	    autoOpen: false,
	    height: 180,
	    width: 500,
	    modal: true,
	    open: function(event, ui) {

	    },
	    buttons: {
		"Save": function() {

		    makeProfileSerialise();
		    $(this).dialog("close");
		},
		Cancel: function() {
		    $(this).dialog("close");
		}
	    },
	    close: function() {

	    }
	});

	$("#view-profile").dialog({
	    autoOpen: false,
	    height: 600,
	    width: 1000,
	    modal: true,
	    open: function(event, ui) {

	    },
	    buttons: {
		"Activate": function() {


		    $("#profile-name-form").dialog("open");
		    $(this).dialog("close");
		},
		Cancel: function() {
		    $(this).dialog("close");
		}
	    },
	    close: function() {

	    }
	});
    }

    function confirmDeleteProfileLog(plid){

    $('#h_select_product_id').val(plid);
      $("#profile-delete-confirm-dialog").dialog("open");
    }

    function confirmActivation(pid) {

	$("#h_select_product_id").val(pid);
	$("#active-confirm-dialog").dialog("open");
    }


    function  viewProfileLog() {

	var pid = $('#h_select_product_id').val();

	$.ajax({
	    url: view_profile_log_url,
	    type: "GET",
	    data: {pid: pid},
	    success: function(message) {


		$('#view-profile').dialog("open");

		$('#view-profile').html(message)
		// alert(message);


	    }
	});
	return false;

    }
    function makeProfileSerialise() {

	var pid = $('#h_select_product_id').val();

	//var name = $('#product_name').val();
	var name = $('#profile_name').val();


	$.ajax({
	    url: product_profile_serialize_url,
	    type: "GET",
	    data: {pid: pid, pname: name},
	    success: function(response) {

		//location.reload();
		var msg = JSON.parse(response);

		alert("Profile Switched successfully !");
		$("#reloader").submit();

	    }
	});
	return false;
    }


    function checkProfileNameAvilablity() {

	var name = $('#product_name').val();

	$.ajax({
	    url: check_name_avilable_url,
	    type: "GET",
	    data: {pname: name},
	    success: function(response) {

		if (response == "1") {

		    alert('Name is available');
		} else {

		    alert('Name is not available');
		}

	    }});
	return false;

    }


    function deleteProfileLog(){

	var pid = $('#h_select_product_id').val();
	$.ajax({
	    url: delete_profile_url,
	    type: "GET",
	    data: {pid: pid},
	    success: function(response) {

		var message = JSON.parse(response)
		console.log(message);


		//If success
		if(message['error'] == 0){

		    alert(message['message']);
		    location.reload();
		}
		else{
		     alert(message['message']);
		}
	    }});
	return false;

    }


</script>