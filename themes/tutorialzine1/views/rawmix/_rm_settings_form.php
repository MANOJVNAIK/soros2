<?php
/* @var $this RmsettingsController */
/* @var $model Settings */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>


	  <div class="clearfix">

	    <label class="form-label" for="form-name"><?php echo Yii::t("rm_settings","Product Name")?></label>

	    <div class="form-input">
		<?php echo $form->textField($model, 'varName', array('size' => 60, 'maxlength' => 100,'precision'=>2, 'class'=>'','required'=>'required','disabled'=>'disabled')); ?>
	    <?php echo $form->hiddenField($model, 'varName')?>
	    </div>

	    </div>


	<div class="clearfix">

	      <label class="form-label" for="form-name"><?php echo Yii::t("rm_settings","Var Key")?></label>

	    <div class="form-input">
		<?php echo $form->textField($model, 'varKey', array('size' => 60, 'maxlength' => 100,'precision'=>2, 'class'=>'','required'=>'required','disabled'=>'disabled')); ?>
	      <?php echo $form->hiddenField($model, 'varKey')?>
	    </div>

	</div>

	<div class="clearfix">
	  <label class="form-label" for="form-name"><?php echo Yii::t("rm_settings","Var Value")?></label>

	    <div class="form-input">
		<?php echo $form->textField($model, 'varValue', array('size' => 60, 'maxlength' => 100,'precision'=>2, 'class'=>'','required'=>'required')); ?>
	    </div>


	</div>



<?php $this->endWidget(); ?>

</div><!-- form -->