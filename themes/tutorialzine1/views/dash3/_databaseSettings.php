<script type="text/javascript">
  $(function() {
    $( "#sortable" ).sortable({
      revert: true
    });
    $( "#sortable li" ).disableSelection();
  });
  </script>
<?php
        $baseUrl = Yii::app()->baseUrl ;
        $cs = Yii::app()->clientScript;
        
        $formSubmitionUrl = Yii::app()->createAbsoluteUrl('dash/SaveRtmaForm');
        $setDefaultLayoutUrl = Yii::app()->createAbsoluteUrl('dash/GrabdashboardLayout');
        
        
        
        
        $cs->registerScriptFile($baseUrl.'/js/rtma.js',CClientScript::POS_END);
        $cs->registerScript('rtmaConfig',""
                . "var form_submision_url = '{$formSubmitionUrl}';"
                . "var set_default_layout_url = '{$setDefaultLayoutUrl}';",
                        CClientScript::POS_BEGIN);

?>
  
<style type="text/css">
	.sortableDiv li { margin: 5px; padding: 5px; width: 150px; }
</style>
<!-- 
<div class="sortableDiv">

<ul id="sortable"  style="list-style:none;">
  <li class="ui-state-default">Item 1</li>
  <li class="ui-state-default">Item 2</li>
  <li class="ui-state-default">Item 3</li>
  <li class="ui-state-default">Item 4</li>
  <li class="ui-state-default">Item 5</li>
</ul>
</div> -->

<div class="grid_5">
    
    <section id="rtma-forms">
            
        <div id="rta-config-db" class="form-step form-active">
           
            <?php $this->renderPartial('helperfiles/_rta_config_db_form'); ?>
        </div>
        <div id="rta-physical-config" class="form-step ">
             <?php $this->renderPartial('helperfiles/_rta_physical_config_form'); ?>
        </div>
        
        <div id="rta-db-config" class="form-step ">
              <?php $this->renderPartial('helperfiles/_rta_db_config_form'); ?>
        </div>
        <div id="rta-derived-config" class="form-step ">
            
                <?php $this->renderPartial('helperfiles/_rta_derived_config_form'); ?>
            
        </div>
        
        <div id="rta-avg-config" class="form-step">
           <?php $this->renderPartial('helperfiles/_rta_avg_config_form'); ?>
        </div>
        <div id="rta-avg-group-config" class="form-step">
              <?php $this->renderPartial('helperfiles/_rta_avg_group_config_form'); ?>
        </div>
        
          
        <div id="rta-job-id" class="form-step">
            <?php $this->renderPartial('helperfiles/_rta_job_id_form'); ?>
            
        </div>
        <div id="rta-shift-times" class="form-step">
            <?php $this->renderPartial('helperfiles/_rta_shift_time_form'); ?>
        </div>
        <div id="" class="form-step">
            <?php //$this->renderPartial('helperfiles/_rta_avg_group_config_form'); ?>
        </div>
    </section>
</div>