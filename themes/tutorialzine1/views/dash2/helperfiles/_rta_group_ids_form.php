<?php
/* @var $this RtaAverageGroupidsController */
/* @var $model RtaAverageGroupids */
/* @var $form CActiveForm */
?>
<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Derived Config</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">


                                    <li class="prev"><a href="#rta-db-config">« Prev</a></li>

                                    <li class="next"><a href="#rta-avg-config">Next »</a></li>


                                </ul>
        
        <div class="clearfix">
            
        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rta-average-groupids-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'rtaMasterID'); ?>
		<?php echo $form->textField($model,'rtaMasterID',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'rtaMasterID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groupAveragingID'); ?>
		<?php echo $form->textField($model,'groupAveragingID',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'groupAveragingID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
    </section>
</div>