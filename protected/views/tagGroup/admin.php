<style>
    .link-column a{
        color: blue ! important;
    }
</style>
<?php



$this->breadcrumbs = array(
    'Tag Groups' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TagGroup', 'url' => array('index')),
    array('label' => 'Create TagGroup', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tag-group-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<section class="main-section grid_8">
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->

<?php
$baseUrl = Yii::app()->basePath;

$createTag = Yii::app()->createAbsoluteUrl('tagGroup/create');

$menuFile = $baseUrl . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "themes" . DIRECTORY_SEPARATOR . "tutorialzine1" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "pageDefaults" . DIRECTORY_SEPARATOR . "authLeftMenu.php";
include_once($menuFile);
?>

    </nav>
    <div class="main-content">

        <div class="clear"><br/></div>
        <section class="container_6 clearfix">

            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading">
                <header class="ui-widget-header ui-widget-header-blue ui-corner-top">
                    <h2> <?php echo Yii::t('app', 'Tag Groups') ?></h2>

                </header>

                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="min-height:600px;">

                    <section id="portlet-set-point"  class=" ui-tabs-panel ui-widget-content ui-corner-bottom">


                        <a data-icon-primary="ui-icon-circle-plus" href="<?php echo $createTag ?>" class="pull-right ui-button ui-widget ui-state-highlight ui-corner-all ui-state-focus ui-button-text-icon-primary" role="button" style="font-weight:bold;">
                        <span class="ui-button-icon-primary ui-icon ui-icon-circle-plus"></span><span class="ui-button-text">
                                <?php echo Yii::t('app', 'New Tag-Group') ?>   
                            </span>
                        </a>

                        <div class="clearfix">

                        </div>


<?php
$dateTimeFormat = RmSettings::getValueFromKey("GLOBAL_TIME_FORMAT", 'Y-m-d H:i:s');
$this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'taggroups-grid',
                            'dataProvider' => $model->search(),
     //'filter' => $model,
                            'itemsCssClass' => 'displaytab full list-table',
                            'summaryText' => '',
                            'columns' => array(
                                /* 'lay_id', */
                                /* 'a_href', */
                                /* 'gadPlacement', */
        array(
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->tagGroupName',
            'urlExpression' => 'Yii::app()->createUrl("/tagGroup/" . $data->tagGroupID)',
            'header' => 'Tag Group Name'
        ),
                                  array(// display 'create_time' using an expression
                                    'name' => 'totalTags',
                                    'value' => '$data->getItems()',
                                ),
                                  array(// display 'create_time' using an expression
                                    'name' => 'startTime',
                                    'value' => '$data->getStartTime()',
                                ),
                                array(// display 'create_time' using an expression
                                    'name' => 'endTime',
                                    'value' => '$data->getEndTime()',
                                ),
//                                array(
//                                    'class' => 'CButtonColumn',
//            'template' => '{view}{update}{delete}',
//            'header' => 'Action'
//                                ),
                                array(
                                    'class' => 'CButtonColumn',
                                    'template' => '{update}{delete}',
                                    'buttons' => array
                                        (
                                        
                                        'delete' => array
                                            (
//                                            'url' => '"#$data->tagGroupID"',
                                            'url'=>'Yii::app()->baseUrl . \'/TagGroup/delete/\'.$data->tagGroupID',
                                            'visible' => '1',
//                                            'options' => array('class' => 'TagGroupDelete', 'alt' => "{$data->tagGroupID}"),
                                        //'options'=>array('onclick'=>$data->id),
                                        ),
                                    ),
                                ), //array*/
                            ), //columns
));
?>

                    </section>
                </section>
            </div>
        </section>

    </div>
</section>

