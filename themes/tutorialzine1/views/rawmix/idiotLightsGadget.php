<section class="container_6 clearfix" style="margin:0px auto;padding:10px;">

    <div class="grid_6">
        <fieldset class="fieldset-buttons ui-corner-all">
            <legend class="buttonset-legend">
                <span id="dashboardview-filter" class="buttonset">
                    <input type="radio" name="dashboardview" id="dashboardview-tickets" value=".dash-stat"  checked/><label for="dashboardview-tickets"><?php echo Yii::t('helios_rawmix_dash_radio', 'Statistics') ?></label>
                    <input type="radio" name="dashboardview" id="dashboardview-statistics" value=".dash-src" /><label for="dashboardview-statistics"><?php echo Yii::t('helios_rawmix_dash_radio', 'Feeders') ?></label>
                    <input type="radio" name="dashboardview" id="dashboardview-alerts" value=".dash-alert" /><label for="dashboardview-alerts"><?php echo Yii::t('helios_rawmix_dash_radio', 'Alerts') ?></label>
                </span>
            </legend>
            <ul class="isotope-widgets isotope-container">
                <?php
                $alertsArray = array();
                $colorArray = array(2 => "orange", 1 => "green", 0 => "red");

                $sql = "SELECT * FROM `rm_settings` WHERE varName like 'SRC%STATUS' ";
                $command = Yii::app()->db->createCommand($sql);

                $settList = array();

                $setList = $command->query()->readAll();
                foreach ($setList as $spAr) {
                    if ($spAr["varKey"] == "Engine" || strlen($spAr["varKey"] ) == 0)
                        continue;

                    echo '<li class="dash-src" style="width:125px;">';
                    if ((int) $spAr["varValue"] != 1) {
                        array_push($alertsArray, array("varKey" => $spAr["varKey"], "varValue" => $spAr["varValue"]));
                    }

                    $colorString = isset($colorArray[(int) $spAr["varValue"]]) ? $colorArray[(int) $spAr["varValue"]] : '';
                    echo '<a class="button-' . $colorString . ' ui-corner-all" href="#">';
                    echo '<span style="border:none;font-color:black;font-weight:bold;">' . Yii::t('dash', $spAr["varKey"]) . '</span>';
                    echo '</a>';
                    echo '</li>';
                    
                    
                    array_push($settList, $spAr["varKey"]);
                }

                $sql = "SELECT * FROM `rm_settings` WHERE varName like '%STATUS' OR varName='MASTER_CONTROL_MODE' OR varName='AUTOMODE' OR varName='STARVATION'";
                $command = Yii::app()->db->createCommand($sql);

                $srcList = $command->query()->readAll();
                foreach ($srcList as $spAr) {
                    
                    
                      //Filter empty values
                    
                    if(strlen($spAr["varKey"]) < 1)
                        continue;
                    if ($spAr["varKey"] == "Engine")
                        continue;

                    if ($spAr["varKey"] == "AUTO_TEST")
                        $spAr["varKey"] = "Automatic(T)";

                    if ($spAr["varKey"] == "MASTER_CONTROL_MODE")
                        $spAr["varKey"] = "S-CONTROL";

                    if (in_array($spAr["varKey"], $settList))
                        continue;

                    if ((int) $spAr["varValue"] != 1) {
                        array_push($alertsArray, array("varKey" => $spAr["varKey"], "varValue" => $spAr["varValue"]));
                    }

                    if ($spAr["varName"] == "STARVATION") {
                        $spAr["varKey"] = "Starvation";
                        if ($spAr["varValue"] > 0) {
                            $spAr["varValue"] = 0;
                        } else {
                            $spAr["varValue"] = 1;
                        }
                    }

                    echo '<li class="dash-stat" style="width:125px;">';
                    
                    $color = 0;
                    if (isset($colorArray) && ((int) $spAr["varValue"] < count($colorArray)))
                        $color = $colorArray[(int) $spAr["varValue"]];
                    echo '<a class="button-' . $color . ' ui-corner-all" href="#">';

                    echo '<span style="border:none;font-color:black;font-weight:bold;">'
                    . Yii::t('dash', $spAr["varKey"]) . '</span>';
                    echo '</a>';
                    echo '</li>';
                }

                foreach ($alertsArray as $spAr) {
                    
                    
                    //Filter empty values
                    
                    if(strlen($spAr["varKey"]) < 1)
                        continue;
                    
                    if ($spAr["varKey"] == "starvation")
                        $spAr["varKey"] = "Starvation";
                    echo '<li class="dash-alert" style="width:125px;">';

                    //PAWANH1-TODO: issue in button
                    $color = 0;
                    if (isset($colorArray) && ((int) $spAr["varValue"] < count($colorArray)))
                        $color = $colorArray[(int) $spAr["varValue"]];

                    echo '<a class="button-' . $color . ' ui-corner-all" href="#">';
                    echo '<span style="border:none;font-color:black;font-weight:bold;">' .
                    Yii::t('dash', $spAr["varKey"]) . '</span>';
                    echo '</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </fieldset>
    </div>

</section> 