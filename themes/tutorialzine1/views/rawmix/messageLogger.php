
<section class="main-section grid_8">
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;
        $currentTimeTick = time();


        $language = Yii::app()->language;

        $this->renderPartial('rawmixLeftMenu');
        $strtStr = '';
        $endStr = '';


        $starTime = "";
        $endTime = "";
        if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {


            $newStDate = date('Y-m-d H:i:s', strtotime($_REQUEST['start_date']));
            $newEDate = date('Y-m-d H:i:s', strtotime($_REQUEST['end_date']));
        } else {

            $newStDate = date('Y-m-d H:i:s', $currentTimeTick - (60 * 60 * 24 * 30));
            $newEDate = date('Y-m-d H:i:s', $currentTimeTick);
        }

        $cQuery = "SELECT * FROM rm_config_log where c_table_name!='rm_error_dialog' and c_updated >= '{$newStDate}' and c_updated <= '{$newEDate}' ORDER BY c_updated DESC";

        $ccommand = Yii::app()->db->createCommand("SELECT count(*) as count FROM  rm_config_log where c_table_name!='rm_error_dialog' and c_updated >= '{$newStDate}' and c_updated <= '{$newEDate}' ORDER BY c_updated DESC");
        $countRow = $ccommand->queryRow();
        $totalCount = $countRow['count'];
        ?>
    </nav>
    <div class="main-content" >

        <section class="container_6 clearfix" >

            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading">
                <header class="ui-widget-header ui-corner-top">
                    <h2><?php echo Yii::t('history', 'Configuration change history.'); ?></h2>

                </header>
                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="height:600px;">

                    <div class="clearfix padding" style="padding:5px;border:1px solid lightgray;">
                        <form  name="historyformsubmit" id="historyformsubmit" method="get" action="#">
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'Start Time') ?> <em>*</em></label>
                                <div class="form-input">
                                    <input type="text" required="required" name="histTimeRangeStart" id="timeRangeStart" autocomplete="off" value="<?php echo date('Y-m-d',strtotime($newStDate )); ?>" >
                                    <span>
                                        <input type="text" name="histTimeRangeStart_time" id="histTimeRangeStart_time" class="timepick" size="5" maxlength="5" <?php echo date('H:i',strtotime($newStDate) ); ?>/>
                                        <input type="hidden" name="start_date" id="start_dateString" class="" size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'End Time') ?> <em>*</em></label>
                                <div class="form-input"><input type="text" required="required" name="histTimeRangeEnd" id="timeRangeEnd" value="<?php echo date('Y-m-d',strtotime($newEDate )); ?>" >
                                    <span>
                                        <input type="text" name="histTimeRangeEnd_time" id="histTimeRangeEnd_time" class="timepick" size="5" maxlength="5" value="<?php echo date('H:i',strtotime($newEDate )); ?>" />
                                        <input type="hidden" name="end_date" id="end_dateString" class="" size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="form-action clearfix flLeft" style="width:150px;">
                                <label class="form-label" for="form-name"><?php echo Yii::t('leftmenu', 'History') ?> </label>
                                <div class="form-input">
                                    <button id="historyformsubmitBut" data-icon-primary="ui-icon-circle-check" type="button" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">
                                        <?php echo Yii::t('dash', 'SUBMIT') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="showStats" title="" style="margin:10px;height:auto;">
                        <div style="width:100%;height:auto;">

                            <div style="margin:0 auto; width:auto;">
                                <section id="sidebarpaneDialog-1" style="height:auto">
                                    <table class="customStyle" style="width:100%;font-size:18px;border:1px solid #F0F0F0;">
                                        <thead>

                                                <?php
                                                echo '<tr>';
                                                echo '<th class="ui-state-default"  style="font-weight:bold;"> '
                                                 . Yii::t('app', 'Time-Stamp')
                                                 . '</th>';
                                                echo '<th class="ui-state-default" style="font-weight:bold;"> '
                                                 . Yii::t('dash', 'Change Type')
                                                 . ' </th>';
                                                echo '<th class="ui-state-default" style="font-weight:bold;text-align:left !important;padding-left:10px  !important;"> '
                                                 . Yii::t('dash', 'Change Description')
                                                 . '</th>';
                                                echo '</tr>';
                                                ?>

                                        </thead>
                                        <tbody>
                                            <?php
                                            $dataProvider = new CSqlDataProvider($cQuery, array(
    'keyField' => 'cid',
    'totalItemCount' => $totalCount,
    'pagination' => array(
        'pageSize' => 10,
    ),
        ));
                                            $data = $dataProvider->data;

                                            $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_config_row_view',
    'template' => ' {items} ',
    'emptyText' => Yii::t('app', 'No Results Found')
                                            ));
                                            ?>

                                        </tbody>
                                    </table>

                                    <?php
                                    $this->widget('CLinkPager', array(
    'pages' => $dataProvider->getPagination(),
    'firstPageLabel' => 'First',
    'lastPageLabel' => 'Last',
    'prevPageLabel' => '<<  ',
    'nextPageLabel' => ' >>',
    'htmlOptions' => array('class' => ' pagination pull-right'),
    'hiddenPageCssClass' => 'hide',
    'internalPageCssClass' => 'pagenum',
    'header' => '',
                                    ));
                                    ?>
                                </section>
                            </div><!--  float right -->
                        </div><!--  auto -->
                    </div><!--  showstats -->
                </section>
            </div><!--  grid_6 -->
        </section><!-- section -->
    </div><!-- main -->
</section><!-- section main -->
<?php
$currentDate = date("m-d-Y");
?>
<script type="text/javascript">

    $('#timeRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
    $('#timeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});
    $('#histTimeRangeStart').datepicker({dateFormat: 'yy-mm-dd'});
    $('#histTimeRangeEnd').datepicker({dateFormat: 'yy-mm-dd'});

    var currentTime = new Date();
    var chours = currentTime.getHours();
    var cminutes = currentTime.getMinutes();
    var cTime = chours + ":" + cminutes;

    $('#histTimeRangeStart_time').val();
    $('#histTimeRangeEnd_time').val();

    $('#timeRangeStart').val();
    $('#timeRangeEnd').val();

    $("#historyformsubmitBut").click(function () {
        var histcurSTime = $('#timeRangeStart').val() + " " + $('#histTimeRangeStart_time').val();
        var histcurETime = $('#timeRangeEnd').val() + " " + $('#histTimeRangeEnd_time').val();

        $("#start_dateString").val(histcurSTime);
        $("#end_dateString").val(histcurETime);
        $("#historyformsubmit").submit();
    });

    $('.timepick').timeslider({ showValue: true, clickable: true});
</script>
