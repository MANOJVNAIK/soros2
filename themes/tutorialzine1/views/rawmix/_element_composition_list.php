


    <table class="full list-table margin-top-20">
	<thead>
	    <tr>

		<th class="ui-state-default ui-corner-top">
		 <?php echo Yii::t('rm_settings','Element Name');?>
		</th>
		<th class="ui-state-default ui-corner-top">
		  <?php echo Yii::t('rm_settings','Element  Value');?>
		</th>

		<th class="ui-state-default ui-corner-top">
		    <?php echo Yii::t('rm_settings','Estimated prob error');?>
		</th>
		<th class="ui-state-default ui-corner-top">
		 <?php echo Yii::t('rm_settings','Estimated Min');?>
		</th>
		<th class="ui-state-default ui-corner-top">
		 <?php echo Yii::t('rm_settings','Estimated Max');?>
		</th>

		<th class="ui-state-default ui-corner-top">
		   <img width="30" src="<?php echo Yii::app()->theme->baseUrl?>/images/navicons/20.png">
		</th>
	    </tr></thead>
	<tbody id="element-list">

<?php foreach ($dataList as $item): ?>
		<tr>
		    <td><?php echo $item->element_name ?></td>
		    <td><?php echo sprintf("%4.2f", $item->element_value * 100); ?> </td>
		    <td> <?php echo sprintf("%4.2f", $item->estimated_prob_error * 100); ?></td>
		    <td> <?php echo sprintf("%4.2f", $item->estimated_min ); ?></td>
		    <td> <?php echo sprintf("%4.2f", $item->estimated_max ); ?> </td>
		    <th>
			<a onclick="return updateElementComposition('<?php echo $item->element_id ?>')" data-icon-only="true" data-icon-primary="ui-icon-pencil" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span><span class="ui-button-text">
                                <?php echo Yii::t('app', "Edit Element"); ?>&nbsp;</span></a>
			<a onclick="return deleteConfirm('element_composition','<?php echo $item->element_id ?>')" data-icon-only="true" data-icon-primary="ui-icon-trash" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-button-icon-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-trash"></span><span class="ui-button-text">
                                <?php echo Yii::t('app', "Delete Element"); ?>&nbsp;</span></a>
		    </th>
		</tr>
<?php endforeach; ?>
	</tbody>
    </table>

