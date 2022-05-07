

			<section class="ui-widget-content ui-corner-bottom form">

			<?php
			$form = $this->beginWidget('CActiveForm', array(
			    'id' => 'element_compossition_form',
			    //   'class'=>'form'    ,
			    // Please note: When you enable ajax validation, make sure the corresponding
			    // controller action is handling ajax validation correctly.
			    // There is a call to performAjaxValidation() commented in generated controller code.
			    // See class documentation of CActiveForm for details on this.
			    'enableAjaxValidation' => false,
				));
			?>

			    <div class="clearfix">

				<label class="form-label" for="form-name"><?php echo Yii::t('rm_settings',"Element Name")?> <small></small></label>

				<div class="form-input">

				 <?php echo $form->textField($model,'element_name',array('size'=>60,'maxlength'=>100)); ?>
				</div>

			    </div>

			    <div class="clearfix">

				<label class="form-label" for="form-email"><?php echo Yii::t('rm_settings',"Element Value")?> <small></small></label>

				<div class="form-input">
				 <?php $model->element_value = $model->element_value * 100; ?>
				 <?php echo $form->textField($model,'element_value',array('size'=>10,'maxlength'=>10)); ?>
				</div>

			    </div>

			    <div class="clearfix">

				<label class="form-label" for="form-birthday"><?php echo Yii::t('rm_settings',"Element Type")?><small></small></label>

				<div class="form-input">
				 <?php echo $form->textField($model,'element_type'); ?>


				</div>

			    </div>

			    <div class="clearfix">

				<label class="form-label" for="form-username"><?php echo Yii::t('rm_settings',"Estimated Prob error")?>  <small></small></label>

				<div class="form-input">
				   <?php echo $form->textField($model,'estimated_prob_error'); ?>
				</div>

			    </div>

			    <div class="clearfix">

				<label class="form-label" for="form-password"><?php echo Yii::t('rm_settings',"Estimated Max")?><small></small></label>

				<div class="form-input">
				 <?php echo $form->textField($model,'estimated_max'); ?>
				</div>

			    </div>

			    <div class="clearfix">

				<label class="form-label" for="form-password-check"><?php echo Yii::t('rm_settings',"Estimated Min")?><small></small></label>

				<div class="form-input">

				 <?php echo $form->textField($model,'estimated_min'); ?>

				   <?php echo $form->hiddenField($model,'source_id'); ?>

				</div>

			    </div>


			     <div class="clearfix">
				 <label class="form-label" </label>
				<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button')); ?>

			    </div>


			    <?php $this->endWidget(); ?>

			</section>