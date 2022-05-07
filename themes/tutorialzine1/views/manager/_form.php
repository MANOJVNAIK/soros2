<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'layouts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'a_href'); ?>
		<?php echo $form->textArea($model,'a_href',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'a_href'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subname'); ?>
		<?php echo $form->textField($model,'subname',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'subname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gadPlacement'); ?>
		<?php echo $form->textArea($model,'gadPlacement',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'gadPlacement'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'default_layout'); ?>
		<?php echo $form->textField($model,'default_layout',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'default_layout'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_updated'); ?>
		<?php echo $form->textField($model,'last_updated'); ?>
		<?php echo $form->error($model,'last_updated'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->