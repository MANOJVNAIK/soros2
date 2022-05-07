<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	$model->lay_id,
);

$this->menu=array(
	array('label'=>'List Layouts', 'url'=>array('index')),
	array('label'=>'Create Layouts', 'url'=>array('create')),
	array('label'=>'Update Layouts', 'url'=>array('update', 'id'=>$model->lay_id)),
	array('label'=>'Delete Layouts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lay_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Layouts', 'url'=>array('admin')),
);
?>

<h1>View Layouts #<?php echo $model->lay_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lay_id',
		'user_id',
		'a_href',
		'subname',
		'gadPlacement',
		'default_layout',
		'last_updated',
	),
)); ?>
