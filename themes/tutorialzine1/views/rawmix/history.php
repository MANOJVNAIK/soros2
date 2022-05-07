
<section class="main-section grid_8">
    <nav class="">
        <!-- Abhinandan. Invoke the script responsible for rendering the Left Side Bar Menu upon page load.. -->
        <?php
        if (isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])) {

            $starTime = date('Y-m-d H:i:s', strtotime($_REQUEST['start_date']));
            $endTime = date('Y-m-d H:i:s', strtotime($_REQUEST['end_date']));
        } else {

            $endTime = date('Y-m-d H:i:s', time());
            $starTime = date('Y-m-d H:i:s', time() - (8 * 3600)); //30 day back
        }


        $hQuery = "SELECT * FROM  rm_user_submitted_dump WHERE updated >= '{$starTime}' and updated <= '{$endTime}' ORDER BY updated DESC";

        $csql = "SELECT count(*) as count FROM  rm_user_submitted_dump WHERE updated >= '{$starTime}' and updated <= '{$endTime}'  ORDER BY updated DESC";

        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;


        $language = Yii::app()->language;

        $this->renderPartial('rawmixLeftMenu');
        ?>
    </nav>
    <div class="main-content" >

        <section class="container_6 clearfix" >

            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading">
                <header class="ui-widget-header ui-corner-top">
                    <h2><?php echo Yii::t('history', 'Proposed Feed Rates History'); ?></h2>

                </header>
                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" style="height:600px;">

                    <div class="clearfix padding" style="padding:5px;border:1px solid lightgray;">
                        <form  name="historyformsubmit" id="historyformsubmit" method="post" action="#">
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name">
                                    <?php echo Yii::t('dash', 'Start Time'); ?>
                                    <em>*</em></label>
                                <div class="form-input">

                                    <input type="text" required="required" name="histTimeRangeStart" 
                                           id="timeRangeStart" value="<?php echo date('Y-m-d', strtotime($starTime)) ?>" >
                                    <span>
                                        <input type="text" name="histTimeRangeStart_time" 
                                               id="histTimeRangeStart_time" class="timepick" size="5" maxlength="5"  value="<?php echo date('H:i', strtotime($starTime)) ?>"/>
                                        <input type="hidden" name="start_date" id="start_dateString" class="" size="5" maxlength="5"  />
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name">
                                    <?php echo Yii::t('dash', 'End Time'); ?>

                                    <em>*</em></label>
                                <div class="form-input"><input type="text" required="required"
                                                               name="histTimeRangeEnd" id="timeRangeEnd" 
                                                               value="<?php echo date('Y-m-d', strtotime($endTime)) ?>" >
                                    <span>
                                        <input type="text" name="histTimeRangeEnd_time"
                                               id="histTimeRangeEnd_time" class="timepick" size="5" maxlength="5" 
                                               value="<?php echo date('H:i', strtotime($endTime)) ?>"/>
                                        <input type="hidden" name="end_date" id="end_dateString" class="" size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="form-action clearfix flLeft" style="width:150px;">
                                <label class="form-label" for="form-name">

                                    <?php echo Yii::t('leftmenu', 'History'); ?></label>
                                <div class="form-input">
                                    <button id="historyformsubmitBut" data-icon-primary="ui-icon-circle-check" type="button" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">
                                            <?php echo Yii::t('dash', 'SUBMIT') ?></span></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="showStats" title="" style="margin:10px;height:500px;">
                        <div class="grid_6" style="width:100%;height:auto;">

                            <section id="sidebarpaneDialog-1" style="height:auto">
                                <form name="proposedformsubmit" id="proposedformsubmit" method="post" action="#">
                                    <table id="hisTable" class="customStyle" style="width:100% !important;;font-size:8px;border:1px solid #F0F0F0;">
                                        <thead>

                                            <?php
                                            $sql = "SELECT sp_name,sp_value_num,sp_measured FROM `rm_set_points` WHERE sp_status=1 " .
                                                    "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
                                            $command = Yii::app()->db->createCommand($sql);

                                            $spList = $command->query()->readAll();
                                            $colstr = "";
                                            $spNamesList = '';
                                            array_push($spList, Array("sp_name" => "Al2O3", "sp_value_num" => 0));
//						array_push($spList, Array( "sp_name" => "SiO2","sp_value_num" => 0));
//array_push($spList, Array( "sp_name" => "Fe2O3","sp_value_num" => 0));
//array_push($spList, Array( "sp_name" => "CaO","sp_value_num" => 0));
//array_push($spList, Array( "sp_name" => "MgO","sp_value_num" => 0));
//array_push($spList, Array( "sp_name" => "K2O","sp_value_num" => 0));

                                            foreach ($spList as $spAr) {
                                                $spNamesList .= '<th class="ui-state-default"  style="font-size:12px;">' . $spAr["sp_name"] . '</th>';
                                            }

                                            $sql = "SELECT src_id,src_name,src_measured_feedrate,src_min_feedrate,src_max_feedrate,src_proposed_feedrate ,src_actual_feedrate FROM `rm_source` WHERE 1 " .
                                                    "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
                                            $command = Yii::app()->db->createCommand($sql);

                                            $srcList = $command->query()->readAll();
                                            $i = 0;
                                            $totalFeedR = 0;
                                            $colLen = count($srcList);
                                            $spLen = count($spList);
                                            echo '<tr>';
                                            echo '<th class="ui-state-default" >  </th>';
                                            echo '<th class="ui-state-default" colspan="' . $spLen . '">';
                                            echo Yii::t('dash', 'Analyzer Results');

                                            echo '</th>';
                                            echo '<th class="ui-state-default" colspan="' . $colLen . '">';
                                            echo Yii::t('dash', 'Proposed');
                                            echo '</th>';
                                            echo '<th class="ui-state-default" colspan="' . $colLen . '">';
                                            echo Yii::t('dash', 'Submitted');
                                            echo '</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<th class="ui-state-default"  style="font-size:12px;">';
                                            echo Yii::t('dash', 'TimeStamp');

                                            echo '</th>';
                                            echo $spNamesList;
                                            foreach ($srcList as $spAr) {
                                                $srcnamestring = str_replace("New_LimeStone", "Lime(N)", $spAr["src_name"]);
                                                $srcnamestring = str_replace("Old_LimeStone", "Lime(O)", $srcnamestring);
                                                $srcnamestring = str_replace("New_Sand", "Sand(N)", $srcnamestring);
                                                $srcnamestring = str_replace("Old_Sand", "Sand(O)", $srcnamestring);
                                                $srcnamestring = str_replace("New_Iron", "Iron(N)", $srcnamestring);
                                                $srcnamestring = str_replace("Old_Iron", "Iron(O)", $srcnamestring);
                                                $srcnamestring = str_replace("Bottom_Ash", "Ash", $srcnamestring);
                                                echo '<th class="ui-state-default" style="font-size:12px;">' . Yii::t('dash',$srcnamestring) . '</th>';
//                                                echo '<th class="ui-state-default" style="font-size:12px;">' . Yii::t('dash', $srcnamestring) . '</th>';
                                            }
                                            foreach ($srcList as $spAr) {
                                                $srcnamestring = str_replace("New_LimeStone", "Lime(N)", $spAr["src_name"]);
                                                $srcnamestring = str_replace("Old_LimeStone", "Lime(O)", $srcnamestring);
                                                $srcnamestring = str_replace("New_Sand", "Sand(N)", $srcnamestring);
                                                $srcnamestring = str_replace("Old_Sand", "Sand(O)", $srcnamestring);
                                                $srcnamestring = str_replace("New_Iron", "Iron(N)", $srcnamestring);
                                                $srcnamestring = str_replace("Old_Iron", "Iron(O)", $srcnamestring);
                                                $srcnamestring = str_replace("Bottom_Ash", "Ash", $srcnamestring);

                                                
                                                echo '<th class="ui-state-default" style="font-size:12px;">' . Yii::t('dash',$srcnamestring) . '</th>';
//                                                echo '<th class="ui-state-default" style="font-size:12px;">' . Yii::t('dash', $srcnamestring) . '</th>';
                                            }
                                            echo '</tr>';
                                            ?>

                                        </thead>
                                        <tbody>
                                            <?php
                                            if (0)
                                                echo $hQuery;

                                            $ccommand = Yii::app()->db->createCommand($csql);
                                            $countRow = $ccommand->queryRow();
                                            $totalCount = $countRow['count'];

                                            $dataProvider = new CSqlDataProvider($hQuery, array(
                                                'keyField' => 'id',
                                                'totalItemCount' => $totalCount,
                                                'pagination' => array(
                                                    'pageSize' => 10,
                                                ),
                                            ));

                                            $data = $dataProvider->data;

                                            //$spLen
                                            $this->widget('zii.widgets.CListView', array(
                                                'dataProvider' => $dataProvider,
                                                'itemView' => '_history_row_view',
                                                'template' => ' {items} ',
                                                'emptyText' => '',
                                                
					        'viewData' => array( 'spLen' => $spLen,
						),
                                            ));
                                            ?>

                                        </tbody>
                                    </table>
				    
                                    <?php
					if ($dataProvider->totalItemCount <= 0)
					echo '<section><div class="ui-widget ui-widget-content clearfix" style="width:100%;text-align:center;color:red;">'.Yii::t('app', 'No Results Found').'</div></section>';

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
                                </form>
                            </section>
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

    setTimeout(function () {
        location.reload();
    }, 60000);
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

<?php
$importExportFeature2 = 'dom: "Tt",' .
        '"tableTools": {
										"sSwfPath": "' . Yii::app()->theme->baseUrl . '/js/swf/copy_csv_xls_pdf.swf",
										"aButtons": [
										  "copy",
										  "xls",
										  "print",
										  {
											"sExtends": "collection",
											"sButtonText": "Save",
											"aButtons": ["csv", "xls"]
										  }
										]
						}';

echo '
	<script type="text/javascript" src="' . Yii::app()->theme->baseUrl . '/js/jquery.min_new.js' . '" ></script>
	<script type="text/javascript" src="' . Yii::app()->theme->baseUrl . '/js/jquery.dataTables.min.js' . '" ></script>
	<script type="text/javascript" src="' . Yii::app()->theme->baseUrl . '/js/dataTables.tableTools.min.js' . '" ></script>

	<script type="text/javascript">
	 var SM_callback444 = {
		SM_execute : function(SM_stored_values){
			var oTableavg = $("#hisTable").dataTable({
				"sPaginationType": "full_numbers",
				"bLengthChange": true,
				"bFilter": false,
				"bSort": true,
				"bInfo": true,
				"bAutoWidth": true,
				"bDestroy": true,
				"iDisplayLength": 25,
				' . $importExportFeature2 . '
			});
			oTableavg.fnSort( [ [0,"desc"] ] );
			
			return true;
		}
	}
	SM_callback444.SM_execute();
</script>';
