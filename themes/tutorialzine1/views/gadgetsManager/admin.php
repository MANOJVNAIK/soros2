<?php
$this->breadcrumbs=array(
	'Gadgets Datas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List GadgetsData', 'url'=>array('index')),
	array('label'=>'Create GadgetsData', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gadgets-data-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Gadgets Datas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'gadgets-data-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'gadget_data_id',
		'gadget_type',
		'lay_id',
		'widgetsPos',
		'gadget_name',
		'gadget_size',
		/*
		'last_updated',
		'data_source',
		'detector_source',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
