  <script type="text/javascript">
   var basePath = '<?php echo Yii::app()->baseUrl; ?>';  //Used by 'dashCreate_logic.js, customizeButtons.setDetectorSource()';
  </script>

<section class="main-section grid_8">
 <nav class="">
   <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
  <?php include_once(LogicalHelper::osWrapper(dirname(__FILE__) . "\..\pageDefaults\authLeftMenu.php")); ?>
 </nav>
 
 <div class="main-content">
  <header>
   <h2 id="layout-title">Manage Layouts</h2>   
  </header>
  <section class="container_6 clearfix">
   <div class="grid_6">
    <div class="portlet ui-widget ui-widget-content ui-corner-all ">
     <header class="ui-widget-header ui-corner-top">
		  <h2>Update/Delete Layouts</h2>
		 </header>
     <section class="ui-widget-content ui-corner-bottom">  
      <div class="clearfix">
      
	 
<?php
$this->breadcrumbs=array(
	'Layouts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Layouts', 'url'=>array('index')),
	array('label'=>'Create Layouts', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('layouts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'layouts-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'itemsCssClass' =>'display',
	'columns'=>array(
		/*'lay_id',*/
		'user_id',
		/*'a_href',*/
		'subname',
		/*'gadPlacement',*/
		'default_layout',
		'last_updated',
		array(
			'class'=>'CButtonColumn',
                                     'template'=>'{delete}',
		),
	),
)); ?>

 </div>
	 </section>
	</div><!--portlet-->
	</div><!-- grid_6-->
</section><!--container-6-->
</div><!--main-content-->
</section><!--main-content grid_8-->