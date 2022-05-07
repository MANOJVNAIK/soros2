<!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->

<?php
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$cs->registerScriptFile($baseUrl . '/js/rawmix.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/formvalidator.js', CClientScript::POS_END);

$layoutNameCheckUrl = Yii::app()->createAbsoluteUrl('rawmix/checkProfileName');
$createProfileUrl = Yii::app()->createAbsoluteUrl('rawmix/CreateProfile');
$updateProfileUrl = Yii::app()->createAbsoluteUrl('rawmix/UpdateProfile'); //

$createSourceUrl = Yii::app()->createAbsoluteUrl('rawmix/CreateSource');
$loadSourceFormUrl = Yii::app()->createAbsoluteUrl('rawmix/loadSourceform');
$updateSourceFormUrl = Yii::app()->createAbsoluteUrl('rawmix/updateSource');
$deleteSourceUrl = Yii::app()->createAbsoluteUrl('rawmix/Deletesource');

$createSetPointUrl = Yii::app()->createAbsoluteUrl('rawmix/CreateSetPoints');
$loadSetpointFormUrl = Yii::app()->createAbsoluteUrl('rawmix/LoadSetpointForm');
$deleteSetpointform =  Yii::app()->createAbsoluteUrl('rawmix/deleteSetpoint');
$updateSetpointUrl =  Yii::app()->createAbsoluteUrl('rawmix/updateSetPoints');




$loadElementCompositionListUrl =Yii::app()->createAbsoluteUrl('rawmix/ElementCompostionList');
$loadElementCompositionFormUrl = Yii::app()->createAbsoluteUrl('rawmix/ElementCompostionForm');

$createElementCompositionformUrl = Yii::app()->createAbsoluteUrl('rawmix/CreateElementCompostion');
$updateElementCompositionformUrl = Yii::app()->createAbsoluteUrl('rawmix/updateElementCompostion');
$deleteElementCompositionUrl = Yii::app()->createAbsoluteUrl('rawmix/deleteElementCompostion');

$getProgressUrl = Yii::app()->createAbsoluteUrl('rawmix/GetProgress');
$sourceSelectUpdateUrl = Yii::app()->createAbsoluteUrl('rawmix/Sourcelist');



$cs->registerScript('appConfig', "var layout_name_check_url = '{$layoutNameCheckUrl}';"
	. "var creat_profile_url = '{$createProfileUrl}';"
	. "var creat_set_point_url = '{$createSetPointUrl}';"
	. "var load_setpoint_form_url = '{$loadSetpointFormUrl}';"
	. "var update_setpoint_url =    '{$updateSetpointUrl}';"
	. "var delete_set_point_url =   '{$deleteSetpointform}';"
	. "var load_source_form_url =   '{$loadSourceFormUrl}';"
	. "var create_source_url =     '{$createSourceUrl}';"
	. "var delete_source_url =      '{$deleteSourceUrl}';"
	. "var update_source_url =      '{$updateSourceFormUrl}';"
	. "var load_element_compostion_list = '{$loadElementCompositionListUrl}';"
	. "var load_element_composition__form_url = '{$loadElementCompositionFormUrl}';"
	. "var creat_element_composition_url = '{$createElementCompositionformUrl}';"
	. "var update_element_composition_url = '{$updateElementCompositionformUrl}';"
	. "var delete_element_composition_url = '$deleteElementCompositionUrl'; "
	. "var update_product_profile_url = '{$updateProfileUrl}';"
	. "var get_progress_url = '{$getProgressUrl}';"
	. "var update_source_select_url= '{$sourceSelectUpdateUrl}' ", CClientScript::POS_END);
?>

<style type="text/css">a.longSize {width:810px !important; margin-left:5px;}
</style>

<script type="text/javascript">

    var dashObj = {
	grabDashboardLayout: function(lay_id) {
	    $.ajax({
		type: 'POST',
		url: '<?php echo Yii::app()->baseUrl; ?>/dash/GrabdashboardLayout',
		data: {'lay_id': lay_id},
		success: function(msg) {
		    document.location.reload(true);
		}
	    }); //end ajax..
	} //grabDashboardLayout..
    };


</script>

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
	    <div class="grid_6 leading" style="min-height:250px !important;">

		<section>
		    <div class="tabs">
			<ul>
			    <li><a href="#portlet-product_profile"><?php echo Yii::t('rawmix','Product Profile')?> </a></li>
			    <li><a  data-tab="#portlet-set-point" href="#portlet-set-point"><?php echo Yii::t('rawmix','Set Points')?></a></li>
			    <li><a  data-tab="#portlet-source" href="#portlet-source"><?php echo Yii::t('rawmix','Sources')?></a></li>
			    <li><a  data-tab="#portlet-source-element" href="#portlet-source-element"><?php echo Yii::t('rawmix','Source-Elements')?></a></li>


			</ul>

			<div id="progress-bar" class="progress-bar" style="position:absolute;top:2px;right: 15px;width: 200px">
			  <!--<input id="progress-bar" type="range" value="0" min="0" max="100" step="25" />-->
			   <div data-show-value="true" data-value="10" class="progress ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="10">
			       <div  class="ui-progressbar-value ui-state-error ui-corner-left" style="width: 0%;"><b>0%</b></div>
			   </div>
			</div>
			<section id="portlet-product_profile">


			   <?php if($productModel->isNewRecord){?>
			    <!--Product Profile Form start Here-->
			    <form id="product-profile" class="form"  method="post">

				<div class="clearfix">

				    <label class="form-label" for="form-name"><?php echo Yii::t('rawmix','Name')?> <em>*</em><small><?php echo Yii::t('rawmix','Enter Profile name')?></small></label>

				    <div class="form-input">
					<input type="text" required="required" name="profile_name" id="product_name">
					<input type="hidden" required="required" name="profile_id" id="product_id">
				    </div>

				</div>


				<div class="form-action clearfix">

				    <button data-icon-primary="ui-icon-circle-check" type="submit" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text"><?php echo Yii::t('rawmix','OK')?></span></button>

				    <button type="reset" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false"><span class="ui-button-text">Reset</span></button>

				</div>

			    </form>
			    <!--Product Profile Form End Here-->
			   <?php } else {

			       $this->renderPartial('_product_form',array('model'=>$productModel));
			       ?>
			   <?php }?>



			</section>
			<section id="portlet-set-point" style='min-height:300px;' class="hide">
			   <a data-icon-primary="ui-icon-circle-plus" onclick="return addSetpoint()" href="javascript:void(0)" id="add-source" class="pull-right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-state-focus" role="button">

			     <?php echo Yii::t('rawmix','Add Set Point')?>
			    </a>





	<div class="clearfix">

	</div>
				 <?php if($productModel->isNewRecord){?>
				<div class="full" id="set-point-list">

				</div>

				 <?php } else {

				  $dataList = SetPoints::model()->findAll('product_id=:pid',array(':pid'=>$productModel->product_id));
				  $this->renderPartial('_setpoints_list',array('dataList'=>$dataList));
			       ?>
			   <?php }?>



				<div class="clearfix"><br/></div>




			    <div class="clearfix"></div>

				    <div class='full'>



				       <a id="set-point-prev" class='pull-left button ui-button ui-widget ui-state-default ui-corner-all'>
					 <?php echo Yii::t('rawmix','Previous')?>
				       </a>

					<a  id="set-point-next" class='pull-right ui-state-default ui-corner-top ui-state-disabled  ui-corner-all button ui-button ui-widget ui-button-text-only'>

					 <?php echo Yii::t('rawmix','Next')?>

					</a>

				    </div>
				<div class="clearfix"></div>


			</section>
			<section id="portlet-source" style='position: relative;min-height: 300px;' class="hide">


			    <a data-icon-primary="ui-icon-circle-plus" onclick="return addSource()" href="javascript:void(0)" id="add-source" class="pull-right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-state-focus" role="button">
				<span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span>
				<span class="ui-button-text"> <?php echo Yii::t('rawmix','Add Source')?> </span>
			    </a>

			    <div class="clearfix">

			    </div>

			    <div id="source-list">

			    <?php
			     if(!$productModel->isNewRecord){

				$dataList = Source::model()->findAll('product_id = :pid',array(':pid'=>$productModel->product_id));

			    $this->renderpartial('_source_list', array('dataList' => $dataList));

			     }




			    ?>




			</div>

			     <div class="clearfix"></div>

				    <div class='full'  style='margin-top: 20px;'>



				       <a id="source-prev" class='pull-left button ui-button ui-widget ui-state-default ui-corner-all'> <?php echo Yii::t('rawmix','Previous')?>    </a>

					<a id ="source-next" class='pull-right button ui-button ui-widget ui-state-default ui-corner-all' ><?php echo Yii::t('rawmix','Next')?> </a>

				    </div>
				<div class="clearfix"></div>
			</section>
			<section id="portlet-source-element" class="hide">

				 <a data-icon-primary="ui-icon-circle-plus" onclick="return addElementComposition()" href="javascript:void(0)" id="add-source" class="pull-right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-state-focus" role="button">
                                     <span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span><span class="ui-button-text"> 
                                         
                                        <?php echo Yii::t('rawmix','Add element ')?> 
                                     </span></a>



				 <div class="pull-left" id="source-select">
				     <span class="title-bold"><?php echo Yii::t('rawmix','Source')?>  </span>
				<?php

				$sorcesModel = Source::model()->findAll('product_id = :pid', array(':pid' => $productModel->product_id));
				$SourcList = CHtml::listData($sorcesModel, 'src_id', 'src_name');
				echo CHtml::dropDownList('selected-source-id', '', $SourcList, array('empty' => 'Select sector', 'class' => 'pull'));




				?>
				 </div>
				  <div class="clearfix"></div>
			      <div id="element-composition-list">


			     </div>
				    <div class='full margin-top-20'>



				       <a id="elelemt-prev" class='pull-left button ui-button ui-widget ui-state-default ui-corner-all'><?php echo Yii::t('rawmix','Previous')?> </a>
                                       <a  href="<?php echo Yii::app()->createAbsoluteUrl('rawmix/admin')?>" class='pull-right button ui-button ui-widget ui-state-default ui-corner-all'><?php echo Yii::t('rawmix','Finish')?> </a>


				    </div>
				<div class="clearfix"></div>

			</section>
		    </div>
		</section>

	    </div>
	    <!-- End Tabs inside Portlet -->
	</section>

    </div>
</section>

<div style='display:none'>
    <div id="setpoint-dialog-form" title="Set Point">

</div>

<div id="source-dialog-form" title="Source">

</div>


<div id="element_composition-dialog-form" title="Source Element composition">

</div>


<div id="set-point-delete-dialog-form">
  <?php echo Yii::t('rawmix','Are you sure you want to delete this set point?')?>
</div>



<div id="delete-confirm-dialog-form">
   <?php echo Yii::t('rawmix','Are you sure you want to delete this item?')?>
</div>



</div>
