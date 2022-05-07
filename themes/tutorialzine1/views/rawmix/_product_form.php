
<section class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
	'id' => 'product-profile-form',
	'htmlOptions'=> array('class'=>'form has-validation'),
	//   'class'=>'form'    ,
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => false,

    ));
    ?>
    <div class="grid_2">
	<div class="clearfix">

	    <label class="form-label" for="form-name"><?php echo Yii::t('rm_settings',"Product profile")?>  <em>*</em></label>

	    <div class="form-input">
		<?php echo $form->textField($model, 'product_name', array('size' => 60, 'maxlength' => 100,'precision'=>2, 'class'=>'','required'=>'required')); ?>
	    </div>

	</div>

    </div>
    <div class="grid_2">


	    <div class="clearfix">

	<label class="form-label" for="form-textarea"><small></small></label>

	<div class="form-input">

	</div>

    </div>


    </div>

    <div class="clearfix"></div>
    
    <div class='full'>
        
         <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Next') : Yii::t('app','Next'), array('class' => ' pull-right button ui-button ui-widget ui-state-default ui-corner-all')); ?>
       
    </div>
<div class="clearfix"></div>

    <?php echo $form->hiddenField($model, 'status'); ?>
    <?php echo $form->hiddenField($model, 'product_id'); ?>

    <?php $this->endWidget(); ?>

</section>