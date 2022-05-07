<?php
/* @var $model RtaPhysicalConfig */
/* @var $form CActiveForm */

$model = new RtaPhysicalConfig;
?>
<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Physical Config</h2>
        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">


            <li class="prev"><a href="#rta-config-db">« Prev</a></li>

            <li class="next"><a href="#rta-db-config">Next »</a></li>


        </ul>

        <div class="clearfix">

        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">

        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-physical-config-form',
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


                <label class="form-label" for="form-name">Rta Master Id <em>*</em><small></small></label>

                <div class="form-input"> 
                    <?php
                    $rtaMasterModel = ConfigMaster::model()->findAll();
                    $rtaMasterList = CHtml::listData($rtaMasterModel, 'rtaMasterID', 'DB_ID_string');
                    echo CHtml::dropDownList('RtaPhysicalConfig[rtaMasterID]', '', $rtaMasterList, array('empty' => 'Select Master Config', 'class' => 'rta-master-id'));

                  
                    ?>
                </div>

            </div>

            <div class="clearfix">

                <label class="form-label" for="form-name">
                    IP Address
                </label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'IPaddress', array('size' => 20, 'maxlength' => 20)); ?>
                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'goodDataSecondsWeight_physicalCfg'); ?>
                </label>

                <div class="form-input"> 

                    <?php
                    $activeOptions = array(0 => 'Inactive', 1 => Active);
                    echo CHtml::dropDownList('RtaPhysicalConfig[goodDataSecondsWeight_physicalCfg]', '', $activeOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                    ?>

                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
                    <?php echo $form->labelEx($model, 'massflowWeight_physicalCfg'); ?>
                </label>

                <div class="form-input"> 


                    <?php
                    $activeOptions = array(0 => 'Inactive', 1 => Active);
                    echo CHtml::dropDownList('RtaPhysicalConfig[massflowWeight_physicalCfg]', '', $activeOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                    ?>


                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'analysis_timespan'); ?>
                </label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'analysis_timespan', array('size' => 10, 'maxlength' => 10)); ?>
                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'averaging_subinterval_secs'); ?>
                </label>

                <div class="form-input"> 
<?php echo $form->textField($model, 'averaging_subinterval_secs'); ?>
                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
<?php echo $form->labelEx($model, 'detectorID'); ?>
                </label>

                <div class="form-input"> 


<?php
$detectorSoueceList = array('Average' => 'Average', 'Detector 1' => 'Detector 1', 'Detector 2' => 'Dectector 2');
echo CHtml::dropDownList('RtaPhysicalConfig[detectorID]', '', $detectorSoueceList, array('empty' => 'Select Option', 'class' => 'from-input'));
?>

                </div>

            </div>






            <div class="form-action buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
            </div>

                <?php $this->endWidget(); ?>

        </div><!-- form -->
    </section>
</div>