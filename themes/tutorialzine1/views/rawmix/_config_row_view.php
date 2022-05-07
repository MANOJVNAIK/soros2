
<?php

$convAr = array("rm_settings" => "Generic-Settings", "rm_source" => "Feeder-Settings", "rm_set_points" => "Set-Points-Settings", "rm_element_composition" => "Lab-Analysis");
$spAr = $data;

$i = 0;
$timeStamp = $spAr["c_updated"];
$cdesc = $spAr["c_var_desc"];
$ctype = $spAr["c_table_name"];
$cid = $spAr["cid"];

$type = isset($convAr[$ctype]) ? $convAr[$ctype] : $ctype;
if ($cid % 2 == 0) {
    echo '<tr class="gradeA odd">';
} else {
    echo '<tr class="gradeB even">';
}
echo '<td>' . $timeStamp . '</td>';
echo '<td >' . $type . '</td>';
echo '<td style="text-align:left;padding-left:10px;">' . $cdesc . '</td>';
echo '</tr>';

$i++;
?>
