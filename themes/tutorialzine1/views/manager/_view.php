<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lay_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lay_id), array('view', 'id'=>$data->lay_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('a_href')); ?>:</b>
	<?php echo CHtml::encode($data->a_href); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subname')); ?>:</b>
	<?php echo CHtml::encode($data->subname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gadPlacement')); ?>:</b>
	<?php echo CHtml::encode($data->gadPlacement); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_layout')); ?>:</b>
	<?php echo CHtml::encode($data->default_layout); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_updated')); ?>:</b>
	<?php echo CHtml::encode($data->last_updated); ?>
	<br />


</div>