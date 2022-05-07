<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-groups-profile-form',
	'enableAjaxValidation'=>true,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="row clearfix">
		<?php echo $form->labelEx($model,'hobbies'); ?>
		<?php echo $form->textField($model,'hobbies',array('size'=>30,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'hobbies'); ?>
	</div>
	<br/>
	<div class="row buttons clearfix" style="padding-left:65px;">							
		<button class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" type="submit" data-icon-primary="ui-icon-circle-check" role="button" aria-disabled="false">
			<span class="ui-button-text">Update External Profile</span>
		</button>		
		<?php //echo CHtml::ajaxSubmitButton(Yii::t('userGroupsModule.general','Update External Profile'), Yii::app()->baseUrl . '/userGroups/user/update/id/'.$user_id, array('update' => '#userGroups-container'), array('id' => 'submit-profile-'.$model->id.rand()) ); 
		?>
	</div>
<?php $this->endWidget(); ?>
</div>
<br/>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-groups-avatar-form',
	'action'=>array('/profile/load'),
	'htmlOptions'=> array(
		'enctype'=>'multipart/form-data',
	)
)); ?>
	<div class="row" >
		<?php echo $form->labelEx($model,'avatar',array('style'=>"margin-right:25px;")); ?>
		<?php echo CHtml::activeFileField($model,'avatar'); ?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>
	<br/>
	<div class="row buttons clearfix" style="padding-left:65px;">
		<button class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" type="submit" data-icon-primary="ui-icon-circle-check" role="button" aria-disabled="false">
			<span class="ui-button-text">Load avatar</span>
		</button>
	</div>

<?php $this->endWidget(); ?>
</div>