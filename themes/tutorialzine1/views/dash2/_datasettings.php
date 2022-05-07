                <?php
                $baseUrl = Yii::app()->baseUrl;
                $cs = Yii::app()->clientScript;
                $getDetectorSourceColumnsUrl = Yii::app()->createAbsoluteUrl('dash/GetDetectorSourceCoulmns');
                $savePrefUrl = Yii::app()->createAbsoluteUrl('dash/SaveColumnPreferences');
                $cs->registerScript("appconfig", ""
                        . "var get_datasource_column = '{$getDetectorSourceColumnsUrl}';"
                        . "var save_column_pref_url = '{$savePrefUrl}'", CClientScript::POS_END)
                ?>

                <link type="text/css" href="<?php echo $baseUrl ?>/js/plugins/multiselect/css/ui.multiselect.css" rel="stylesheet" />
                <script type="text/javascript" src="<?php echo $baseUrl ?>/js/plugins/multiselect/js/ui.multiselect.js"></script><script></script>

                <div class="grid_5"> 


                    <div class="portlet ui-widget ui-widget-content ui-corner-all grid_3 leading">
                        <header class="ui-widget-header ui-corner-top">
                            <h2>Select Table</h2>
                        </header>
                        <section class="ui-widget-content ui-corner-bottom">

                    <form class="form">

              

                                            <div class="clearfix">

                                                <label class="form-label" for="form-updates">Table Type<small></small></label>
                                                <div class="form-input">
                                                    <select name="table-type" onchange="selectTableType(this)">
                                                        <option value="analysis">Analysis</option>
                                                        <option vlaue="averages">Element Averages</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>

           

                    </form>


                        </section>
                    </div>

                    <div id="average-settings-table" class="portlet ui-widget ui-widget-content ui-corner-all grid_3 leading hide">
                        <header class="ui-widget-header ui-corner-top">
                            <h2>Element Average Table</h2>
                        </header>
                        <section class="ui-widget-content ui-corner-bottom">
                        </section>
                    </div>

                </div>


                <div class="grid_5 leading hide" id="analysis-settings-table">
                    <div class="portlet ui-widget ui-widget-content ui-corner-all">
                        <header class="ui-widget-header ui-corner-top">
                            <h2>Analysis Tables</h2>
                        </header>
                        <section class="ui-widget-content ui-corner-bottom">

                            <div>

                                <table class="full">
                                    <tr>
                                        <td>
                                            Table Type  
                                        </td>
                                        <td>



                                        </td>
                                    </tr>
                                </table>


                                <div style="width:500px">

                <?php
                $detectorSource = LogicalHelper::getAnalysisTables($mainDB);
                //var_dump($detectorSource);

                echo CHtml::dropDownList('data-source', '', $detectorSource, array('empty' => 'Select Datasource', 'class' => ''));
                ?>


                                    <a class="button" onclick="savePref()"> Save </a>


                                    <div id="column-pref">

                                    </div>


                                </div>  

                            </div>
                        </section>
                    </div>
                </div>





                <script type="text/javascript">
                    $(function() {

                        //$(".multiselect").multiselect();//

                        $('#data-source').live('change', function() {

                            var detector_source = $(this).val();
                            $.ajax({
                                url: get_datasource_column,
                                type: "GET",
                                data: {detector: detector_source},
                                success: function(html) {

                                    $('#column-pref').html(html);

                                    $(".multiselect").multiselect();

                                }
                            })//end of ajax
                        })//end of live

                    });


                    function savePref() {
                        // console.log($('#column-list').val());
                        var detector = $('#data-source').val();
                        var pref = $('#column-list').val();

                        $.ajax({
                            url: save_column_pref_url,
                            type: "POST",
                            data: {pref: pref, detector: detector},
                            success: function(html) {

                                //$('#column-pref').html(html);

                                //$(".multiselect").multiselect();

                            }
                        })
                    }
                </script>
