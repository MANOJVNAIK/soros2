
<section class="main-section grid_8">
    <nav class="">

        <?php
        $baseUrl = Yii::app()->basePath;

        $menuFile = $baseUrl . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "themes" . DIRECTORY_SEPARATOR . "tutorialzine1" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "pageDefaults" . DIRECTORY_SEPARATOR . "authLeftMenu.php";
        include_once($menuFile);
        $tripInfo = TagQueuedHelper::getTripInfo($tagObject->tagID);

        $activeCalibrationFile = WclRfidCalMap::findActiveCalibFile($tripInfo["w_matCode"]);
        ?>
    </nav>
    <div class="main-content">
        <section class="container_6 clearfix">
            <div class="grid_6 leading" style="min-height:250px !important;">

                <header class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-widget-header-blue ui-corner-top">
                 
                </header>
                <section id="create" class="ui-tabs-panel ui-widget-content ui-corner-bottom">


                    <?php
                    /* @var $this WclRfidLogMessagesController */
                    /* @var $model WclRfidLogMessages */


                    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#wcl-rfid-log-messages-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
                    ?>

                    <div class="search-form" style="display:none">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div><!-- search-form -->

                    <div class="clearfix"  style="min-height:600px">

                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'wcl-rfid-log-messages-grid',
                            'dataProvider' => $dataProvider,
                            'filter' => $model,
                            'columns' => array(
                                //'logid',
                                'message_type',
                                //'short_descrip',
                                'long_descrip',
                                'trip_id',
                                'unloaderID',
                                'timestamp',
                            /*
                              'vehNo',
                              'flag',
                              array(
                              'class'=>'CButtonColumn',
                              ),
                             */
                            ),
                        ));
                        ?>
                    </div> 


                </section>
            </div>
            <div class="clear"><br/></div>
        </section>
    </div>
</section>

