<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	$model->lay_id=>array('view','id'=>$model->lay_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Layouts', 'url'=>array('index')),
	array('label'=>'Create Layouts', 'url'=>array('create')),
	array('label'=>'View Layouts', 'url'=>array('view', 'id'=>$model->lay_id)),
	array('label'=>'Manage Layouts', 'url'=>array('admin')),
);
?>

<h1>Update Layouts <?php echo $model->lay_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>