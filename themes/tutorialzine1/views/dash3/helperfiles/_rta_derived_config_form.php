<?php
/* @var $model RtaDerivedConfig */
/* @var $form CActiveForm */
$model = new RtaDerivedConfig
?>


<div class="portlet ui-widget ui-widget-content ui-corner-all">

    <header class="ui-widget-header ui-corner-top">

        <h2>Derived Config</h2>
        

        <ul class="pagination clearfix leading pull-right" style="position: absolute;right:0px;top:-15px;">

             <li class="prev"><a href="#rta-avg-config">Skip</a></li>
            <li class="prev"><a href="#rta-db-config">« Prev</a></li>

            <li class="next"><a href="#rta-avg-config">Next »</a></li>


        </ul>

        <div class="clearfix">

        </div>

    </header>

    <section class="ui-widget-content ui-corner-bottom">


        <div class="form">

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'rta-derived-config-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
            ));
            ?>



            <div class="clearfix">

                <label class="form-label" for="form-name">
                    
                    Rta Master Id <em>*</em><small></small>
                    
                   
                </label>

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
                   
                   Data Source rtaMasterId  <em>*</em><small></small>
                </label>

                <div class="form-input">
                    
                    
                <?php echo $form->textField($model, 'data_source_rtaMasterID', array('size' => 10, 'maxlength' => 10)); ?>

                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
                    <?php 
                    
                    $filterType = array('Moving_Average','Kalman');
                    
                    CHtml::dropDownList("RtaDerivedConfig[filter_type]",'',$filterType,array(''));
                    echo $form->labelEx($model, 'filter_type'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                    <?php echo $form->textField($model, 'filter_type', array('size' => 0, 'maxlength' => 0)); ?>

                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
                    <?php echo $form->labelEx($model, 'moving_avg_filter_sample_timespan'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                <?php echo $form->textField($model, 'moving_avg_filter_sample_timespan', array('size' => 10, 'maxlength' => 10)); ?>

                </div>

            </div>



            <div class="clearfix">

                <label class="form-label" for="form-name">
                <?php echo $form->labelEx($model, 'kalman_filter_sample_timespan'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                <?php echo $form->textField($model, 'kalman_filter_sample_timespan', array('size' => 10, 'maxlength' => 10)); ?>

                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
                 
                        Massflow Weight DerivedCfg
                       
                    <em></em><small></small>
                </label>

                <div class="form-input">
                    
                    
                    
                    <?php
                      $activeOptions = array(0=>'Inactive',1=>Active);
                    echo CHtml::dropDownList('RtaDerivedConfig[massflowWeight_derivedCfg]', '', $activeOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                
                    
                    
                  //  echo $form->textField($model, 'massflowWeight_derivedCfg', array('size' => 1, 'maxlength' => 1)); 
                    ?>

                </div>

            </div>


            <div class="clearfix">

                <label class="form-label" for="form-name">
                <?php echo $form->labelEx($model, 'goodDataSecondsWeight_derivedCfg'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                    <?php 
                        $activeOptions = array(0=>'Inactive',1=>Active);
                    echo CHtml::dropDownList('RtaDerivedConfig[goodDataSecondsWeight_derivedCfg]', '', $activeOptions, array('empty' => 'Select Option', 'class' => 'from-input'));
                
                 //   echo $form->textField($model, 'goodDataSecondsWeight_derivedCfg', array('size' => 1, 'maxlength' => 1)); ?>

                </div>

            </div>

            
            <div class="clearfix">

                <label class="form-label" for="form-name">
                <?php echo $form->labelEx($model, 'percentageGoodDataRequired'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                     <?php echo $form->textField($model, 'percentageGoodDataRequired', array('size' => 3, 'maxlength' => 3)); ?>
                </div>

            </div>
            
            <div class="clearfix">

                <label class="form-label" for="form-name">
                 <?php echo $form->labelEx($model, 'kalman_gain_Q'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                    <?php echo $form->textField($model, 'kalman_gain_Q'); ?>
                </div>

            </div>
            
             <div class="clearfix">

                <label class="form-label" for="form-name">
                <?php echo $form->labelEx($model, 'kalman_gain_R'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                  <?php echo $form->textField($model, 'kalman_gain_R'); ?>
                </div>

            </div>
            
             <div class="clearfix">

                <label class="form-label" for="form-name">
                <?php echo $form->labelEx($model, 'source_decay_comp'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                  <?php echo $form->textField($model, 'source_decay_comp', array('size' => 1, 'maxlength' => 1)); ?>
                </div>

            </div>
            
            
             <div class="clearfix">

                <label class="form-label" for="form-name">
                  <?php echo $form->labelEx($model, 'source_decay_ref_date'); ?>
                    <em></em><small></small>
                </label>

                <div class="form-input">
                <?php echo $form->textField($model, 'source_decay_ref_date'); ?>
                </div>

            </div>





     

        

            <div class="form-action">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button')); ?>
                
                
                
            </div>

<?php $this->endWidget(); ?>

        </div><!-- form -->
    </section>
</div>