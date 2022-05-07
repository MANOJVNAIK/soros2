	
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'source-form',
    'htmlOptions' => array('class' => 'form has-validation'),
    //   'class'=>'form'    ,
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
	));
?>

<section class="ui-widget-content ui-corner-bottom form">



    <div class="grid_2">

	<div class="clearfix">

	    <label class="form-label" for="form-name"> <?php echo Yii::t("rm_settings","Name")?>  <em>*</em><small> <?php echo Yii::t("rm_settings","Enter Source name")?></small></label>

	    <div class="form-input">

		<?php echo $form->textField($model, 'src_name', array('size' => 60, 'maxlength' => 100, 'class' => 's-input' ,'required'=>'required')); ?>
	    </div>

	</div>
	<div class="clearfix">


	    <label class="form-label" for="form-email"><?php echo Yii::t("rm_settings","Type")?> </label>

	    <div class="form-input">
		<?php echo $form->textField($model, 'src_type', array('size' => 60, 'maxlength' => 100, 'class' => 's-input')); ?>
	    </div>


	</div>
	<div class="clearfix">
		
		<?php
			$model->src_min_feedrate = $model->src_min_feedrate* 100;
		?>
	    <label class="form-label" for="form-website"><?php echo Yii::t("rm_settings","Min Feed Rate")?> </label>

	    <div class="form-input">
		<?php echo $form->numberField($model, 'src_min_feedrate', array('size' => 10, 'maxlength' => 10, 'class' => 's-input')); ?>
	    </div>

	</div>



    </div>
    <div class="grid_2">
	
	<div class="clearfix">

	    <label class="form-label" for="form-upload"><?php echo Yii::t("rm_settings","Status")?><small></small></label>

	    <div class="form-input">
		<?php echo $form->numberField($model, 'src_status_mode', array('size' => 10, 'maxlength' => 10, 'class' => 's-input')); ?>


		<?php echo $form->hiddenField($model, 'product_id', array('size' => 10, 'maxlength' => 10, 'class' => 's-input')); ?>
		<?php echo $form->hiddenField($model, 'src_id', array('size' => 10, 'maxlength' => 10, 'class' => 's-input')); ?>
	    </div>

	</div>
	<div class="clearfix">

	    <label class="form-label" for="form-birthday"><?php echo Yii::t("rm_settings","Delay")?><small></small></label>

	    <div class="form-input">
		<?php echo $form->numberField($model, 'src_delay', array('size' => 60, 'maxlength' => 100, 'class' => 's-input')); ?>
	    </div>

	</div>
	<div class="clearfix">

	    <label class="form-label" for="form-password-check"><?php echo Yii::t("rm_settings","Max Feed Rate")?><small></small></label>

	    <div class="form-input">
		
		<?php
			$model->src_max_feedrate = $model->src_max_feedrate* 100;
		?>
		<?php echo $form->numberField($model, 'src_max_feedrate', array('size' => 10, 'maxlength' => 10, 'class' => 's-input')); ?>

	    </div>

	</div>

    </div>
</section>



<?php $this->endWidget(); ?>
