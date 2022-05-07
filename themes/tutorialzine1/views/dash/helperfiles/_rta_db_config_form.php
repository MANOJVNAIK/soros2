<?php
/* @var $model RtaDerivedConfig */
/* @var $form CActiveForm */

$model = new RtaDbConfig;
?>


<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>DB Config</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">


            <li class="prev"><a href="#rta-physical-config">« Prev</a></li>

            <li class="next"><a href="#rta-derived-config">Next »</a></li>


        </ul>

        <div class="clearfix">

        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">


        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-db-config-form',
                'htmlOptions' => array("class" => "form has-validation", "novalidate" => "novalidate"),
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>



            <?php echo $form->errorSummary($model); ?>


            <div class="clearfix">

                <label class="form-label" for="form-name">DB Id String <em>*</em><small>Enter DB ID</small></label>

                <div class="form-input"> <?php echo $form->textField($model, 'DB_ID_string', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">Material ID </label>

                <div class="form-input"> <?php echo $form->textField($model, 'Material_ID', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">DB write Active </label>

                <div class="form-input"> 
                    <?php 
                     $activeOptions = array(0=>'Inactive',1=>'Active');
                    echo CHtml::dropDownList('RtaDbConfig[DBwriteActive]', '', $activeOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                
                   
                    ?></div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">Analysis Time span</label>

                <div class="form-input"> <?php echo $form->textField($model, 'analysis_timespan', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">Average Sub Interval Seconds</label>

                <div class="form-input"> <?php echo $form->textField($model, 'averaging_subinterval_secs', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">Write Frequency</label>

                <div class="form-input"> <?php echo $form->textField($model, 'write_frequency', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">Detector Id</label>

                <div class="form-input"> 

                    <?php
                    $detectorSoueceList = array('Average' => 'Average', 'Detector 1' => 'Detector 1', 'Detector 2' => 'Dectector 2');
                    echo CHtml::dropDownList('RtaDbConfig[detector_ID]', '', $detectorSoueceList, array('empty' => 'Select Option', 'class' => 'from-input'));
                    ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">DB counter</label>

                <div class="form-input"> <?php echo $form->textField($model, 'DB_counter', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">User Comments</label>

                <div class="form-input"> <?php echo $form->textArea($model, 'User_Comments', array('size' => 10, 'maxlength' => 10)); ?></div>

            </div>





            <div class="form-action clearfix">

                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
                            </div>

                <?php $this->endWidget(); ?>

        </div><!-- form -->






    </section>

</div>
