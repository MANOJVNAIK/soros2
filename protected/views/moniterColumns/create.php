<?php
/* @var $this MoniterColumnsController */
/* @var $model MoniterColumns */

$this->breadcrumbs=array(
	'Moniter Columns'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MoniterColumns', 'url'=>array('index')),
	array('label'=>'Manage MoniterColumns', 'url'=>array('admin')),
);
?>

<h1>Create MoniterColumns</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>