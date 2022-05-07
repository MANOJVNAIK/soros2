<?php
/* @var $this MoniterColumnsController */
/* @var $model MoniterColumns */

$this->breadcrumbs=array(
	'Moniter Columns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MoniterColumns', 'url'=>array('index')),
	array('label'=>'Create MoniterColumns', 'url'=>array('create')),
	array('label'=>'View MoniterColumns', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MoniterColumns', 'url'=>array('admin')),
);
?>

<h1>Update MoniterColumns <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>