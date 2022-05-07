
	 <script src="<?php echo Yii::app()->baseUrl ?>/themes/tutorialzine1/js/highCharts/highstock.js" type="text/javascript"></script>
	 <script src="<?php echo  Yii::app()->baseUrl ?>/themes/tutorialzine1/js/highCharts/modules/exporting.js" type="text/javascript"></script>

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

        ?>
    </nav>
    <div class="main-content" >

        <section class="container_6 clearfix" style="padding-top:0px !important;">

            <!-- Tabs inside Portlet -->
            <div class="grid_6 leading">
                <header class="ui-widget-header ui-corner-top">
                    <h2><?php echo Yii::t('leftmenu', 'Graphs'); ?></h2>

                </header>
                <section id="section_rawMix" class="ui-widget-content ui-corner-bottom" >

                    <div class="clearfix padding" style="padding:5px;border:1px solid lightgray;">
                        <form  name="plotoryformsubmit" id="plotoryformsubmit" method="post" action="#">
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'Start Time') ?> <em>*</em></label>
                                <div class="form-input">
                                    <input type="text" required="required" name="plotTimeRangeStart" id="timeRangeStart" value="<?php echo $strtStr; ?>" >
                                    <span>
                                        <input type="text" name="plotTimeRangeStart_time" id="plotTimeRangeStart_time" class="timepick" size="5" maxlength="5" />
                                        <input type="hidden" name="start_date" id="start_dateString" class="timepick" size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="clearfix flLeft">
                                <label class="form-label" for="form-name"><?php echo Yii::t('dash', 'End Time') ?> <em>*</em></label>
                                <div class="form-input"><input type="text" required="required" name="plotTimeRangeEnd" id="timeRangeEnd" value="<?php echo $endStr; ?>" >
                                    <span>
                                        <input type="text" name="plotTimeRangeEnd_time" id="plotTimeRangeEnd_time" class="timepick" size="5" maxlength="5" />
                                        <input type="hidden" name="end_date" id="end_dateString" class="timepick" size="5" maxlength="5" />
                                    </span>
                                </div>
                            </div>
                            <div class="form-action clearfix flLeft" style="width:150px;">
                                <label class="form-label" for="form-name"><?php echo Yii::t('leftmenu', 'History') ?> </label>
                                <div class="form-input">
                                    <button id="plotoryformsubmitBut" data-icon-primary="ui-icon-circle-check" type="button" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span><span class="ui-button-text">
                                        <?php echo Yii::t('dash', 'SUBMIT') ?>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
        </section>
	</div>
	<div class="grid_6 leading"                    
			<section class="ui-widget-content ui-corner-bottom">
			<?php

			$gr_elements = HeliosUtility::getAvgElements();

			if(count($gr_elements) > 0){
				$rowCnt = 0;
				foreach($gr_elements as $grEle) {
					if($grEle != "" && $grEle != " " && $grEle != "LocalendTime")
					DashHelper::getMeIndvChart($grEle,$rowCnt++, 1);
				}//foreach
			}//if count


			?>
			</section>
            </div><!--  grid_6 -->
        </section><!-- section -->
    </div><!-- main -->
</section><!-- section main -->
<?php
	$currentDate = date("m-d-Y");
?>
<script type="text/javascript">

    var series = <?php echo CJSON::encode($series)?> ;
    
    $('#timeRangeStart').datepicker();
    $('#timeRangeEnd').datepicker();
    $('#plotTimeRangeStart').datepicker();
    $('#plotTimeRangeEnd').datepicker();

    var currentTime = new Date();
    var chours = currentTime.getHours();
    var cminutes = currentTime.getMinutes();
    var cTime = chours + ":" + cminutes;

    $('#plotTimeRangeStart_time').val();
    $('#plotTimeRangeEnd_time').val();

    $('#timeRangeStart').val(<?php echo "'{$currentDate}'"; ?>);
    $('#timeRangeEnd').val(<?php echo "'{$currentDate}'"; ?>);

    $("#plotoryformsubmitBut").click(function () {
        var plotcurSTime = $('#timeRangeStart').val() + " " + $('#plotTimeRangeStart_time').val();
        var plotcurETime = $('#timeRangeEnd').val() + " " + $('#plotTimeRangeEnd_time').val();

        $("#start_dateString").val(plotcurSTime);
        $("#end_dateString").val(plotcurETime);
        $("#plotoryformsubmit").submit();
    });	

</script>
