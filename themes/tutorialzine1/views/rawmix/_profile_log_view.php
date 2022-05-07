<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$sourceList = unserialize($productLogModel->source);

$setPointsList = unserialize($productLogModel->setpoints);

$elementList =  unserialize($productLogModel->elements);

?>


   <section class="container_6 clearfix">
			    <!-- Accordion Section -->
			    <div class="grid_6 portlet">
				<div id="forcedTabsDiv" class="tabs ui-tabs ui-widget ui-widget-content ui-corner-all">

				      <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top">
					<li class="ui-state-default ui-corner-top"><a class="forcedTab" href="#pane-1"><?php echo Yii::t('rm_settings',"Sources");?></a></li>
					<li class="ui-state-default ui-corner-top"><a class="forcedTab" href="#pane-2"><?php echo Yii::t('rm_settings',"Set Points");?></a></li>
					<li class="ui-state-default ui-corner-top"><a class="forcedTab" href="#pane-3"><?php echo Yii::t('rm_settings',"Source Elements");?></a></li>
				    </ul>
<script type="text/javascript">
	$(".forcedTab").click(function() {
		var tabId = $(this).attr("href");
		$(".ui-tabs-panel").removeClass("ui-tabs-hide");
		$(".ui-tabs-panel").removeClass("ui-state-active");
		$(".ui-tabs-panel").removeClass("ui-tabs-selected");

		$("#pane-1").addClass("ui-tabs-hide");
		$("#pane-2").addClass("ui-tabs-hide");
		$("#pane-3").addClass("ui-tabs-hide");

		$(tabId).removeClass("ui-tabs-hide");
		$(tabId).addClass("ui-state-active");
		$(tabId).addClass("ui-tabs-selected");
	});
</script>

				    <section id="pane-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-selected ui-state-active">
					<table class="full list-table margin-top-20" >
	<thead>
	<tr><th class="ui-state-default ui-corner-top">
	  <?php echo Yii::t('rm_settings',"Source Name");?>
	</th>
	 <th class="ui-state-default ui-corner-top">
	  <?php echo Yii::t('rm_settings',"Source Status");?>
	</th>
	<th class="ui-state-default ui-corner-top">
	   <?php echo Yii::t('rm_settings',"Source Priority");?>
	</th>
	<th class="ui-state-default ui-corner-top">
	  <?php echo Yii::t('rm_settings',"Source Cost");?>
	</th>
	<th class="ui-state-default ui-corner-top">
	  <?php echo Yii::t('rm_settings',"Source Min Feed Rate");?>
	</th>
	<th class="ui-state-default ui-corner-top">
	  <?php echo Yii::t('rm_settings',"Source Max Feed Rate");?>
	</th>

	</tr></thead>
	<tbody>

	    <?php foreach ($sourceList as $item ):?>
	    <tr>
		<td><?php echo $item['src_name']; ?></td>
		<td><?php echo sprintf("%d", $item['src_status_mode']); ?></td>
		<td><?php echo sprintf("%d", $item['src_priority']); ?></td>
		 <td><?php echo sprintf("%2.2f", $item['src_cost'] ); ?></td>
		 <td><?php echo sprintf("%2.0f", $item['src_min_feedrate'] * 100); ?> %</td>
		 <td><?php echo sprintf("%2.0f", $item['src_max_feedrate'] * 100); ?> %</td>

	    </tr>
	    <?php endforeach;?>
	</tbody>
    </table>

				    </section>

				    <section id="pane-2"  class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">


      <table class="full margin-top-20 list-table" >

    <thead>
				    <tr>
				     <th class="ui-state-default ui-corner-top">
				   <?php echo Yii::t('rm_settings',"Set-Point Name");?>
				    </th>
				     <th class="ui-state-default ui-corner-top">
				       <?php echo Yii::t('rm_settings',"Set-Point Active");?>
				    </th>
				     <th class="ui-state-default ui-corner-top">
				       <?php echo Yii::t('rm_settings',"Set-Point Value");?>
				    </th>
				    <th class="ui-state-default ui-corner-top">
				      <?php echo Yii::t('rm_settings',"Set-Point Tolerance Minium");?>
				    </th>
				    <th class="ui-state-default ui-corner-top">
				       <?php echo Yii::t('rm_settings',"Set-Point Tolerance Maximum");?>
				    </th>
				    <th class="ui-state-default ui-corner-top">
				       <?php echo Yii::t('rm_settings',"Priority");?>
				    </th>

				    </tr>
    </thead>
				    <tbody >

					<?php foreach ($setPointsList as $item ):?>
					<tr>
					    <td><?php echo $item['sp_name']?></td>
					    <td><?php echo sprintf("%d", $item['sp_status']	); ?></td>
					    <td><?php echo sprintf("%04.2f", $item['sp_value_num']); ?></td>
					    <td><?php echo sprintf("%04.2f", $item['sp_tolerance_llevel']) ?></td>
					    <td><?php echo sprintf("%04.2f", $item['sp_tolerance_ulevel']) ?></td>
					    <td><?php echo sprintf("%04.2f", $item['sp_priority']) ?></td>

					</tr>
					<?php endforeach;?>
				    </tbody>
				</table>

				  </section>

				   <section id="pane-3"  class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">

<div id="element-composition-list">


    <table class="full list-table margin-top-20">
	<thead>
	    <tr>

		<th class="ui-state-default ui-corner-top">
		   <?php echo Yii::t('rm_settings',"Element Name");?>
		</th>
		<th class="ui-state-default ui-corner-top">
		   <?php echo Yii::t('rm_settings',"Element  Value");?>
		</th>

		<th class="ui-state-default ui-corner-top">
		    <?php echo Yii::t('rm_settings',"Estimated prob error");?>
		</th>
		<th class="ui-state-default ui-corner-top">
		   <?php echo Yii::t('rm_settings',"Estimated Min");?>
		</th>
		<th class="ui-state-default ui-corner-top">
		  <?php echo Yii::t('rm_settings',"Estimated Max");?>
		</th>


	    </tr></thead>
	<tbody id="element-list">

<?php foreach ($elementList as $item): ?>
		<tr>
		    <td><?php echo $item['element_name'] ?></td>
		    <td><?php echo sprintf("%04.2f", $item['element_value']); ?> </td>
		    <td> <?php echo sprintf("%04.2f", $item['estimated_prob_error']); ?></td>
		    <td> <?php echo sprintf("%04.2f", $item['estimated_min']); ?></td>
		    <td> <?php echo sprintf("%04.2f", $item['estimated_max']); ?> </td>

		</tr>
<?php endforeach; ?>
	</tbody>
    </table>
</div>


				    </section><!--  pane 3 -->


				</div>
			    </div>
			    <!-- End Accordion Section -->

   </section>
