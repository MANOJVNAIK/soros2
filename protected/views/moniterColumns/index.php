<?php
/* @var $this MoniterColumnsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Moniter Columns',
);

$this->menu=array(
	array('label'=>'Create MoniterColumns', 'url'=>array('create')),
	array('label'=>'Manage MoniterColumns', 'url'=>array('admin')),
);
?>

<h1>Moniter Columns</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
