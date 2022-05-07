
<?php
$defaultHour *= 3600;

if (isset($_REQUEST['sTime'])) {

    $startTime = date('Y-m-d H:i:s', strtotime($_REQUEST['sTime']));
    $endTime = date('Y-m-d H:i:s', strtotime($_REQUEST['eTime']));
} else {


    //  $currentTimeTick = strtotime('2018-08-23 02:50:24');

    $currentTimeTick = time();

    $tmpDatw = date('Y-m-d H', time());
    $HourTime = strtotime($tmpDatw . ":00:00");


    if ($currentTimeTick > $HourTime) {

        $currentTimeTick = $HourTime + ( $defaultHour);
    }

    $endTime = date('Y-m-d H:i:s', $currentTimeTick);
    $startTime = date('Y-m-d H:i:s', $currentTimeTick - (24 * 3600));
}

$elements = array('LocalendTime', 'SiO2', 'Al2O3', 'Fe2O3', 'CaO', 'KH', 'SM', 'AM', 'TPH');
$displayElements = array('Endtime', 'SiO2', 'Al2O3', 'Fe2O3', 'CaO', 'KH', 'SM', 'AM', 'TPH');
?>

<table id="avg-table" class="customStyle dataTable no-footer" >

    <thead>

        <?php
        foreach ($displayElements as $dele) {

            echo "<th class='ui-state-default '>  " . $dele . " </th>";
        }
        ?>
    </thead>
    <tbody>


        <?php
        $i = (int) strtotime($endTime);

        $stopTime = (int) strtotime($startTime);

        // var_dump($tmpDatw.":00:00"); 
        // var_dump($endTime,$startTime); 




        $dispAr = array();
        while ($i > $stopTime) {
            $rowTr = "";
            $sTime = date('Y-m-d H:i:s', $i - $defaultHour);
            $eTime = date('Y-m-d H:i:s', $i);


            //echo $sTime . " , " . $eTime . "<br/>";
            $avgArray = getaIntervalAvg($sTime, $eTime);

            if (array_sum($avgArray) > 0):
                $rowTr .= "<tr>";
                foreach ($elements as $ele) {

                    $rowTr .= "<td> " . $avgArray[$ele] . " </td>";
                }

                $rowTr .= "</tr>";
            endif;

            $i -= $defaultHour;

            array_push($dispAr, $rowTr);
        }
        //$dispAr = array_reverse($dispAr);
        foreach ($dispAr as $erow)
            echo $erow;
        ?>



    </tbody>
</table>



<?php

function getaIntervalAvg($startDate, $endTime) {

    $sql = "select * from analysis_A1_A2_Blend  where LocalendTime >= '" . $startDate . "'  AND LocalendTime <= '" . $endTime . "' ORDER BY LocalendTime DESC";
    //echo $sql . "<br/>";
    $elements = array('LocalendTime', 'Al2O3', 'SiO2', 'Fe2O3', 'MgO', 'CaO', 'KH', 'IM', 'AM', 'SM', 'TPH');

    $average = array();


    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $acQuery = 'select * from ac_settings ';
    $acResults = Yii::app()->db->createCommand($acQuery)->query();
    $acSettings = array();

    foreach ($acResults as $item) {
        $acSettings[$item['element_name']] = $item;
    }

    foreach ($result as $rawData) {
        
        $query = "select * from rm_settings where varKey = 'ANALYZER_FILTER_BAD_RECORDS' ";
        $result = Yii::app()->db->createCommand($query)->queryRow();
        if ($result && $result['varValue'])
            $setting_filter_bad_records = (int) $result['varValue'];
        //Filter Here
        if($setting_filter_bad_records)
           $row = DashHelper::validateAndSetAnalyzerRecordUsingRange($rawData,$acSettings);
        else
            $row = $rawData;

        $row = DashHelper::validateAndSetAnalyzerRecordUsingRange($rawData,$acSettings);
        foreach ($elements as $ele) {

            //PAWANH1 - convert from string to float

            $tAl2O3 = (float) $row['Al2O3'];

            $tSiO2 = (float) $row['SiO2'];

            $tFe2O3 = (float) $row['Fe2O3'];

            $tCaO = (float) $row['CaO'];

            //$eTime
            //Calculate formulas
            if ($ele == 'LocalendTime') {
                // $formulaVal = (($tCaO - 1.65 * $tAl2O3 - 0.35 * $tFe2O3) / (2.80 * $tSiO2));
                $row[$ele] = $endTime;
            } else
            if ($ele == 'KH') {
                if ($tSiO2 > 0)
                    $formulaVal = (($tCaO - 1.65 * $tAl2O3 - 0.35 * $tFe2O3) / (2.80 * $tSiO2));
                else
                    $formulaVal = 0.0;
                $row[$ele] = $formulaVal;
            } else if ($ele == "SM") {
                if (($tAl2O3 + $tFe2O3) > 0)
                    $formulaVal = round((( $tSiO2) / ($tAl2O3 + $tFe2O3)), 3);
                else
                    $formulaVal = 0.0;
                $row[$ele] = $formulaVal;
            } else if ($ele == "AM") {
                if ($tFe2O3 > 0)
                    $formulaVal = round(( $tAl2O3 / $tFe2O3), 3);
                else
                    $formulaVal = 0.0;
                $row[$ele] = $formulaVal;
            }

            //
            if($row['totalTons'] !== 0)
            $average[$ele][] = $row[$ele];
        }
    }

    $eleAvg = array();
    foreach ($average as $key => $tmpArray) {


        if ($key == 'totalTons') {

            $sum = array_sum($tmpArray);
            $eleAvg[$key] = round($sum, 3);

            continue;
        }



        if ($key == 'LocalendTime') {

            $eleAvg[$key] = ($tmpArray[0]);
            continue;
        }
        $count = count($tmpArray);
        $sum = array_sum($tmpArray);
        $avg = $sum / $count;
        $eleAvg[$key] = round($avg, 3);
    }

    return $eleAvg;
}
?>			
