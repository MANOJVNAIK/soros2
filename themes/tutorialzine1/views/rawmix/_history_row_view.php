
<?php

$ssql = "SELECT sp_name FROM `rm_set_points` WHERE sp_status=1 " .
        "AND product_id = (SELECT product_id FROM  `rm_product_profile` where default_profile=1);";
$command = Yii::app()->db->createCommand($ssql);

$sspList = $command->query()->readAll();

array_push($sspList, Array("sp_name" => "SiO2"));

$sub_sp_list = array();

foreach ($sspList as $ssid => $ssname) {
    $sub_sp_list[$ssname["sp_name"]] = 1;
}
//var_dump($sub_sp_list);exit();
$spAr = $data;

$spVals = '';
$prVals = '';
$smVals = "";
$i = 0;
$spValsCurAr = array();

$proposedVals = unserialize($spAr["proposed"]);
$submittedVals = unserialize($spAr["new_proposed"]);
$timeStamp = $spAr["updated"];
$setPointsAr = $spAr["setPoints"];
$rm_run_id = $spAr["id"];

if (0) {
    $searchTimer = date("y-m-d H:i", strtotime(trim($timeStamp)));

    for ($ii = 0; $ii < 60; $ii++) {
        $ai = (($ii < 10) ? ("0" . $ii) : $ii);
        $t_timeStamp = $searchTimer . ":" . $ai;
        if (isset($spValsAray[$t_timeStamp])) {
            $spValsCurAr = $spValsAray[$t_timeStamp];
            break;
        }
    }
    if (count($spValsCurAr) <= 0) {
        $spVals .= '<td colspan="' . $spLen . '">-</td>';
    } else {
        foreach ($spValsCurAr as $id => $vals) {
            if (($id != "TPH") && ($id != "LocalendTime"))
                $spVals .= '<td>' . round(($vals), 2) . '</td>';
        }
    }
}else {

    $sPointsArray = array();
    $prinCount = 0;
    $spsCols = "";
    $setPointsAr = unserialize($setPointsAr);
    $t_spAr = explode(";", $setPointsAr);
    if (count($t_spAr) > 1) {

        foreach ($t_spAr as $id => $val) {

            if (isset($val)) {
                $temp_spvals = explode(":", $val);
                if (count($temp_spvals) > 0) {
                    if (isset($sub_sp_list[$temp_spvals[0]])) {
                        $sPointsArray[$temp_spvals[0]] = $temp_spvals[1];
                        $spsCols .= '<td>' . round($temp_spvals[1], 2) . '</td>';
                        $prinCount++;
                    }
                } else {
                    $spsCols .= '<td>-</td>';
                }
            } else {
                $spsCols .= '<td>-</td>';
            }
        }
    } else {
        $spsCols .= '<td>-</td><td>-</td><td>-</td>';
    }
}

while ($prinCount < $spLen) {
    $spsCols .= '<td>-</td>';
    $prinCount++;
}

$cnt = 0;
foreach ($proposedVals as $vals) {
    $prVals .= '<td style="background:lightgray;">' . ($vals) . '</td>';
    $cnt++;
}
$tcnt = 0;
foreach ($submittedVals as $vals) {
    if ($tcnt >= $cnt)
        break;
    $smVals .= '<td>' . ($vals) . '</td>';
    $tcnt++;
}

if ($rm_run_id % 2 == 0) {
    echo '<tr class="gradeA odd">';
} else {
    echo '<tr class="gradeB even">';
}
echo '<td>' . date("y-m-d H:i", strtotime(trim($timeStamp))) . '</td>';
echo $spsCols;
echo $prVals;
echo $smVals;
echo '</tr>';

$i++;
?>
