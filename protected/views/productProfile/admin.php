<?php
/* @var $this ProductProfileController */
/* @var $model ProductProfile */

$this->breadcrumbs=array(
	'Product Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ProductProfile', 'url'=>array('index')),
	array('label'=>'Create ProductProfile', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-profile-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Product Profiles</h1>

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
	'id'=>'product-profile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'product_id',
		'user_id',
		'product_name',
		'created_on',
		'updated_on',
		'target_flow',
		/*
		'max_flow_deviation',
		'estimate_lsq_mins',
		'sensitivity',
		'control_period_mins',
		'actual_fpm',
		'actual_tph',
		'default_profile',
		'status',
		'comment',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
