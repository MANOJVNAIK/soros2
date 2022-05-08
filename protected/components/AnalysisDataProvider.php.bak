<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MonitorDashHelper
 *
 * @author veda
 */
define("TIME_CHECK", 0);

class AnalysisDataProvider {

    //put your code here
    private $elements;
    private $curDateTime;
    private $curTime;

    public function __construct($intervals) {

        $this->interval = $intervals;
        ;
        $this->curDateTime = date("Y-m-d H:i:s");
        $this->curTime = time();
    }

    public function setElements($elements) {
        $this->elements = $elements;
    }

    public function geInterval() {

        return $this->interval;
    }

    public function getElements() {
        return $this->elements;
    }

    public function getData() {
        $dataProvider = array();


        foreach ($this->interval as $key => $interval) {

            if ($interval['type'] == 'time') {
                $intervalObject = new IntervalObject($interval['unit']);
            } else {
                $intervalObject = new TonsInterval($interval['unit']);

                $intervalObject->init();
            }

            $rowAvg = $this->getIntervalAvg($intervalObject);


            //IF result found skip row
            if (empty($rowAvg)) {
                $dataProvider[$key] = array();
            } else {

                $dataProvider[$key] = $rowAvg;
            }
        }

        return $dataProvider;
    }

    public function logTime($icntr) {
        $stTime = date("Y-m-d H:i:s");
        $sltime = time();

        $time_diff = round($sltime - $this->curTime, 2);

        if (TIME_CHECK)
            echo "Time $icntr:$stTime ($sltime) Diff: $time_diff  <br/>";

        $this->curDateTime = $stTime;
        $this->curTime = $sltime;
    }

    /**
     *
     * @param IntervalObject $intervalObject
     * @return array
     */
    public function getIntervalAvg($intervalObject) {

        $this->logTime(21);
        $startDate = $intervalObject->getStartTime();
        $endTime = $intervalObject->getEndTime();

        $rmsquery = "select * from rm_settings where varKey = 'SOROS_DISPLAY_ELEMENTS' ";
        $result = Yii::app()->db->createCommand($rmsquery)->queryRow();
        if ($result && $result['varValue']) {
            $showCaseElements = $result['varValue'];
        }

        $ansql = "select $showCaseElements from analysis_A1_A2_Blend  where LocalendTime >= '" . $startDate . "'  AND LocalendTime <= '" . $endTime . "' AND totalTons != 0 ORDER BY LocalendTime DESC";
        $elements = $showCaseElements; // $this->getElements();

        $average = array();
        $dataResuts = Yii::app()->db->createCommand($ansql)->queryAll();

        $acQuery = 'select * from ac_settings ';
        $acResults = Yii::app()->db->createCommand($acQuery)->query();
        $acSettings = array();

        $this->logTime(22);

        foreach ($acResults as $item) {
            $acSettings[$item['element_name']] = $item;
        }

        $query = "select * from rm_settings where varKey = 'ANALYZER_FILTER_BAD_RECORDS' ";
        $result = Yii::app()->db->createCommand($query)->queryRow();
        if ($result && $result['varValue']) {
            $setting_filter_bad_records = (int) $result['varValue'];
        }

        $this->logTime(23);

        foreach ($dataResuts as $rawData) {

            //Filter Here
            if ($setting_filter_bad_records) {
                $row = DashHelper::validateAndSetAnalyzerRecordUsingRange($rawData, $acSettings);
            } else {
                $row = $rawData;
            }


            foreach (explode(',', $elements) as $ele) {


                $tAl2O3 = (float) $row['Al2O3'];

                $tSiO2 = (float) $row['SiO2'];

                $tFe2O3 = (float) $row['Fe2O3'];

                $tCaO = (float) $row['CaO'];


                //Calculate formulas
                if ($ele == 'LocalstartTime') {
                    $row[$ele] = $startDate;
                } elseif ($ele == 'LocalendTime') {

                    $row[$ele] = $endTime;
                }
                /*
                  elseif ($ele == 'KH') {
                  if ($tSiO2 > 0) {
                  $formulaVal = (($tCaO - 1.65 * $tAl2O3 - 0.35 * $tFe2O3) / (2.80 * $tSiO2));
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  } elseif ($ele == "SM") {
                  if (($tAl2O3 + $tFe2O3) > 0) {
                  $formulaVal = round((($tSiO2) / ($tAl2O3 + $tFe2O3)), 2);
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  }   elseif ($ele == 'C3S') {
                  if ($tSiO2 > 0) {
                  $formulaVal = round((4.07*$tCaO - 7.6*$tSiO2 - 6.72*$tAl2O3 - 1.43*$tFe2O3 - 2.852*$tSO3 ),3);
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  }  elseif ($ele == 'C3A') {
                  if ($tSiO2 > 0) {
                  $formulaVal = round((2.65 * $tAl2O3 - 1.69 * $tFe2O3),3);
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  } elseif ($ele == "AM") {
                  if ($tFe2O3 > 0) {
                  $formulaVal = round(($tAl2O3 / $tFe2O3), 2);
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  } elseif ($ele == "IM") {
                  if ($tFe2O3 > 0) {
                  $formulaVal = round(($tAl2O3 / $tFe2O3), 2);
                  } else {
                  $formulaVal = 0.0;
                  }
                  $row[$ele] = $formulaVal;
                  }
                 */

                //
                $average[$ele][] = $row[$ele];
            }
        }

        $this->logTime(24);

        $eleAvg = array();

        if (!empty($average)) {
            foreach ($average as $key => $tmpArray) {
                if ($key == 'totalTons') {
                    $sum = array_sum($tmpArray);
                    $eleAvg[$key] = round($sum, 2);

                    continue;
                }

                if ($key == 'LocalendTime') {
                    $eleAvg[$key] = ($tmpArray[0]);
                    continue;
                }
                if ($key == 'LocalstartTime') {
                    $eleAvg[$key] = array_pop($tmpArray);
                    continue;
                }
                $count = count($tmpArray);
                $sum = array_sum($tmpArray);
                $avg = $sum / $count;
                $eleAvg[$key] = round($avg, 2);
            }
        } else {


            foreach ($elements as $ele) {
                $eleAvg[$ele] = '-';
            }
        }

//        var_dump($eleAvg);
//        die();
        return $eleAvg;
    }

    public static function queryAvg($elements, $LocalstartTime, $LocalendTime) {

        foreach ($elements as $ele) {

            if ($ele == "totalTons") {
                $avgCol[] = "round(sum($ele) , 3) as $ele";
            } else {
                $avgCol[] = "round(avg($ele) , 3) as $ele";
            }
        }
        $colQuery = implode(' , ', $avgCol);
        $startTime = $LocalstartTime; //"2021-07-15 04:13:47"; 
        $endTime = $LocalendTime; //"2021-07-15 05:13:47";
        $whereQuery = "where LocalendTime >= '{$startTime}' AND  LocalendTime <= '{$endTime}'";

        $sql = "select min(LocalendTime) as LocalStartTime, max(LocalendTime) as LocalendTime, $colQuery from analysis_A1_A2_Blend " . $whereQuery;
        $results = Yii::app()->db->createCommand($sql)->queryRow();


        return $results;
    }

    public function getTagAvg($tagObject) {

        $this->logTime(21);
        $startDate = $tagObject->LocalstartTime;

        $endTime = $tagObject->LocalendTime;

        $rmsquery = "select * from rm_settings where varKey = 'SOROS_DISPLAY_ELEMENTS' ";
        $result = Yii::app()->db->createCommand($rmsquery)->queryRow();
        if ($result && $result['varValue']) {
            $showCaseElements = $result['varValue'];
        }

        $tagID = $tagObject->tagID;
        $subTags = SubTag::model()->findAll("tagID=:tagid", array(":tagid" => $tagID));
        $data = [];

        //If tag has sub tags
        if (count($subTags) > 0) {
            $avg = $this->getSubTagAvg($subTags);
        } else {

            $interval = new IntervalObject();

            $interval->setStartTime($startDate);
            $interval->setEndTime($endTime);
            //setStartTime
            //setEndTime
            $analysisDataProvider = new AnalysisDataProvider();
            $analysisDataProvider->setElements($showCaseElements);

            $avg = $analysisDataProvider->getIntervalAvg($interval);
        }

        $avg['LocalstartTime'] = $startDate;
        $avg['End-Time'] = $endTime;
        
        return $avg;
    }

    public function getSubTagAvg($subTags) {

        $rmsquery = "select * from rm_settings where varKey = 'SOROS_DISPLAY_ELEMENTS' ";
        $result = Yii::app()->db->createCommand($rmsquery)->queryRow();
        if ($result && $result['varValue']) {
            $showCaseElements = $result['varValue'];
        }
        foreach ($subTags as $sTag) {

            $interval = new IntervalObject();

            $interval->setStartTime($sTag['LocalstartTime']);
            $interval->setEndTime($sTag['LocalendTime']);
            //setStartTime
            //setEndTime
            $analysisDataProvider = new AnalysisDataProvider();
            $analysisDataProvider->setElements($showCaseElements);

            $data[] = $analysisDataProvider->getIntervalAvg($interval);
        }
        $average = [];
        foreach ($data as $row) {
            foreach (explode(',', $showCaseElements) as $ele) {
                $average[$ele] [] = $row[$ele];
            }
        }

        $eleAvg = array();

        if (!empty($average)) {
            foreach ($average as $key => $tmpArray) {
                if ($key == 'totalTons') {
                    $sum = array_sum($tmpArray);
                    $eleAvg[$key] = round($sum, 2);

                    continue;
                }

                if ($key == 'LocalendTime') {
                    $eleAvg[$key] = ($tmpArray[0]);
                    continue;
                }
                if ($key == 'LocalstartTime') {
                    $eleAvg[$key] = array_pop($tmpArray);
                    continue;
                }
                $count = count($tmpArray);
                $sum = array_sum($tmpArray);
                $avg = $sum / $count;
                $eleAvg[$key] = round($avg, 2);
            }
        } else {


            foreach ($elements as $ele) {
                $eleAvg[$ele] = '-';
            }
        }

        return $eleAvg;
    }

}
