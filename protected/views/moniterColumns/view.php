<?php
/* @var $this MoniterColumnsController */
/* @var $model MoniterColumns */

$this->breadcrumbs=array(
	'Moniter Columns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MoniterColumns', 'url'=>array('index')),
	array('label'=>'Create MoniterColumns', 'url'=>array('create')),
	array('label'=>'Update MoniterColumns', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MoniterColumns', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MoniterColumns', 'url'=>array('admin')),
);
?>

<h1>View MoniterColumns #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'value',
	),
)); ?>
