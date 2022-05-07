<?php
/* @var $model RtaDerivedConfig */
/* @var $form CActiveForm */

$model = new ConfigMaster;
?>


<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Config Master</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">


                                    <!--<li class="prev"><a href="#">« Prev</a></li>-->

                                    <li class="next"><a href="#rta-physical-config">Next »</a></li>


                                </ul>
        
        <div class="clearfix">
            
        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">


        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-config-db-form',
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

                <label class="form-label" for="form-name">DB Name <em>*</em><small>Enter Db Name</small></label>

                <div class="form-input"> <?php echo $form->textField($model, 'DB_ID_string', array('required'=>'required')); ?></div>

                    <?php echo $form->hiddenField($model, 'rtaMasterID'); ?>
            </div>
            
            <div class="clearfix">

                <label class="form-label" for="form-name"> Rta Config Table<small></small></label>

                <div class="form-input">
                <?php 
                 
                    $rtConfigTable = array('rta_physical_config'=>'Rta Physical Config','rta_derived_config'=>'Rta Derived Config','rta_averaged_config'=>'Rta Averaged Config');
                
                    echo CHtml::dropDownList('ConfigMaster[rta_physical_config]', '', $rtConfigTable, array('empty' => 'Select Option', 'class' => 'from-input'));
                
                
                ?>
                </div>

            </div>
            
            
            <div class="clearfix">

                <label class="form-label" for="form-name">DB Write Active <em></em><small></small></label>

                
                    <div class="form-input">
                <?php 
                
                $dbWriteActiveOptions = array(0=>'Inactive',1=>'Active');
                echo CHtml::dropDownList('ConfigMaster[DBwriteActive]', '', $dbWriteActiveOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                
                ?>
                    </div>
            </div>
            
            
            
            <div class="clearfix">

                <label class="form-label" for="form-name">Data Type <em></em><small></small></label>

                <div class="form-input">
                    
                <?php 
                
                $dataType = array('raw_spectrum'=>'Raw Spectrum','aligned_spectrum'=>'Aligned Spectrum','3in1_spectrum'=>'3 In 1 Spectrum','raw_coef'=>'Raw coef','analysis'=>'Analysis','alignment'=>'Alignment');
                echo CHtml::dropDownList('ConfigMaster[data_type]', '', $dataType, array('empty' => 'Select Option', 'class' => 'from-input'));?>
            </div>
                
            </div>
            
            
            <div class="clearfix">

                <label class="form-label" for="form-name">Write Frequency</label>

                <div class="form-input"> <?php echo $form->numberField($model, 'write_frequency', array('size' => 10, )); ?></div>

            </div>
            <div class="clearfix">

                <label class="form-label" for="form-name">DB counter</label>

                <div class="form-input"> <?php echo $form->numberField($model, 'DB_counter', array('size' => 10, )); ?></div>

            </div>
            
            
            <div class="clearfix">

                <label class="form-label" for="form-name"> Time Conversion Mass flow weight </label>

                <div class="form-input"> <?php echo $form->numberField($model, 'timeConversionMassflowWeight', array( 'step'=>'any' )); ?></div>

            </div>
            
            
            <div class="clearfix">

                <label class="form-label" for="form-name">User comments</label>

                <div class="form-input"> <?php echo $form->textArea($model, 'UserComments', array()); ?></div>

            </div>





            <div class="form-action clearfix leading">

                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->






    </section>

</div>
