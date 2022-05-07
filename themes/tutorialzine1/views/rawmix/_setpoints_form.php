
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'set-points-form',
     'htmlOptions'=>array("class"=>"form has-validation" ,"novalidate"=>"novalidate"),
    //   'class'=>'form'    ,                             
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
        ));
?>
<section class="ui-widget-content ui-corner-bottom form">


    <div class="grid_2">
        <div class="clearfix">

            <label class="form-label" for="form-name">Name <small>Enter set point name</small></label>

            <div class="form-input">

                <?php echo $form->textField($model, 'sp_name', array('size' => 60, 'maxlength' => 100,'class'=>'s-input','required'=>'required')); ?>
            </div>

        </div>

            <div class="clearfix">

        <label class="form-label" for="form-website">Lower level<small></small></label>

        <div class="form-input">
            <?php echo $form->numberField($model, 'sp_tolerance_llevel', array('size' => 10, 'maxlength' => 10,'class'=>'s-input')); ?>
        </div>

    </div>
            <div class="clearfix">

        <label class="form-label" for="form-timezone">Status <small></small></label>

        <div class="form-input">
            <?php echo $form->numberField($model, 'sp_status',array('class'=>'s-input','readonly'=>false)); ?>
        </div>

    </div>

    </div>
    <div class="grid_2">
        <div class="clearfix">

            <label class="form-label" for="form-email">Value <small></small></label>

            <div class="form-input">
                <?php echo $form->numberField($model, 'sp_value_num', array('size' => 10, 'maxlength' => 10,'class'=>'s-input')); ?>
            </div>

        </div>
           <div class="clearfix">

        <label class="form-label" for="">Tolerance level (+-)<small></small></label>

        <div class="form-input">

            <?php echo $form->numberField($model, 'sp_tolerance_ulevel', array('size' => 10, 'maxlength' => 10,'class'=>'s-input')); ?>

        </div>

    </div>
          <div class="clearfix">

        <label class="form-label" for="">Priority<small></small></label>

        <div class="form-input">
            <?php echo $form->numberField($model, 'sp_priority',array('class'=>'s-input','readonly'=>false)); ?>
        </div>

    </div>
    </div>
    <?php echo $form->hiddenField($model, 'sp_id'); ?>
    <?php echo $form->hiddenField($model, 'product_id'); ?>


</section>
<?php $this->endWidget(); ?>