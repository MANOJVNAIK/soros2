<?php
/* @var $this RtaJobTableController */
/* @var $model RtaJobTable */
/* @var $form CActiveForm */

$model = new RtaJobTable;
?>

<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Job ID</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">


            <li class="prev"><a href="#rta-shift-times">« Prev</a></li>

            <li class="next"><a href="#">Next »</a></li>


        </ul>

        <div class="clearfix">

        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">

        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-job-id-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>




            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'jobStatus'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'jobStatus', array('size' => 11, 'maxlength' => 11)); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'linuxPID'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'linuxPID'); ?>


                </div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'start_time'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'start_time'); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'end_time'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'end_time'); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'backupTable'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'backupTable', array('size' => 40, 'maxlength' => 40)); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'tempTable'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'tempTable', array('size' => 40, 'maxlength' => 40)); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'regenTable'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'regenTable', array('size' => 40, 'maxlength' => 40)); ?>


                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'originalTable'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'originalTable', array('size' => 40, 'maxlength' => 40)); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'originalTableID'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'originalTableID'); ?>


                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'loopsFinished'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'loopsFinished'); ?>


                </div>

            </div>





            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'recordsRemaining'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'recordsRemaining'); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'recordsTotal'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'recordsTotal'); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'maxID'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'maxID'); ?>


                </div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'dateAdded'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'dateAdded'); ?>


                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'dateModified'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'dateModified'); ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'dateCompleted'); ?>


                    <em></em><small></small></label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'dateCompleted'); ?>


                </div>

            </div>

            <div class="form-action buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button')); ?>
            </div>

<?php $this->endWidget(); ?>

        </div><!-- form -->


    </section>
</div>