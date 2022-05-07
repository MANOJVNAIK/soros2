<?php
/* @var $model RtaAveragedConfig */
/* @var $form CActiveForm */


$model = new RtdShiftTimes;
?>



<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Average Config</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">

            <li class="skip"><a href="#rta-job-id">Skip</a></li>
            <li class="prev"><a href="#rta-avg-group-config">« Prev</a></li>

            <li class="next"><a href="#rta-job-id">Next »</a></li>


        </ul>

        <div class="clearfix">

        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">


        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-shift-times-form',
                 'htmlOptions' => array("class" => "form has-validation", "novalidate" => "novalidate"),
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>


            
            <div class="clearfix">

                <label class="form-label" for="form-name">
                    <?php echo $form->labelEx($model, 'rtaMasterID'); ?> 
                    
                    
                    <em></em><small></small></label>

                <div class="form-input"> 
                  <?php
                    $rtaMasterModel = ConfigMaster::model()->findAll();
                    $rtaMasterList = CHtml::listData($rtaMasterModel, 'rtaMasterID', 'DB_ID_string');
                    echo CHtml::dropDownList('RtaPhysicalConfig[rtaMasterID]', '', $rtaMasterList, array('empty' => 'Select Master Config', 'class' => 'rta-master-id'));

                  
                    ?>

                
                </div>

            </div>
            
	<div class="clearfix">
            <label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftStart1'); ?></label>
            <div class="form-input"> <?php echo $form->textField($model,'shiftStart1'); ?></div>
		<?php echo $form->error($model,'shiftStart1'); ?>
	</div>

	<div class="clearfix">
             <label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftDuration1'); ?></label>
            <div class="form-input"> <?php echo $form->textField($model,'shiftDuration1'); ?></div>
		
		<?php echo $form->error($model,'shiftDuration1'); ?>
	</div>

	<div class="clearfix">
            <label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftStart2'); ?></label>
            <div class="form-input"> <?php echo $form->textField($model,'shiftStart2'); ?></div>
		
		<?php echo $form->error($model,'shiftStart2'); ?>
	</div>

	<div class="clearfix">
            
                <label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftDuration2'); ?></label>
                <div class="form-input"> <?php echo $form->textField($model,'shiftDuration2'); ?></div>
		
		<?php echo $form->error($model,'shiftDuration2'); ?>
	</div>

	<div class="clearfix">
            <label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftStart3'); ?></label>
                <div class="form-input"> <?php echo $form->textField($model,'shiftStart3'); ?></div>
		
		<?php echo $form->error($model,'shiftStart3'); ?>
	</div>

	<div class="clearfix">
		<label class="form-label" for="form-name"><?php echo $form->labelEx($model,'shiftDuration3'); ?></label>
                <div class="form-input"> <?php echo $form->textField($model,'shiftDuration3'); ?></div>
		<?php echo $form->error($model,'shiftDuration3'); ?>
	</div>


            
    

          <div class="form-action clearfix">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button')); ?>
            </div>

<?php $this->endWidget(); ?>

        </div><!-- form -->

    </section>
</div>