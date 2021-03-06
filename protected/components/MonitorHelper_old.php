<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MonitorHelper
 *
 * @author veda
 */
class MonitorHelper {
    //put your code here

    /**
     * 
     * @param AnalysisDataProvider $monitorObject
     */
    private $elments;
    

    public function __construct() {
        
    }

    /**
     * 
     * @param array $elements
     */
    public function setElements($elements) {

        $this->elements= $elements;
    }

    /**
     * 
     * @return array
     */
    public function getElements() {
        return $this->elements;
    }

    public function renderMonitorTable($monitorObject) {

        $elements = $monitorObject->getElements();

        $data = $monitorObject->getData();
        $interValCol = $monitorObject->geInterval($data);

        $tableRow = '';

        foreach ($elements as $element) {

            $tRow = '';
            $tRow = "<th>" . Yii::t('app', $element) . "</th>";
            $rowdata = LabUtility::getColumn($data, $element);

            $isSP = $this->isSetpoint($element);
            if ($isSP) {
                $tRow .= $this->renderSpRow($rowdata, $element);
            } else {
                $tRow .= $this->renderElementRow($rowdata);
            }

            $tableRow .= "<tr>" . $tRow . "</tr>";
        }


        echo "<table class='full list-table'> ";

        $this->buiildHeader($interValCol);

        echo "$tableRow";

        echo "</table>";
    }

    public function buiildHeader($interValCol) {

        echo '<tr>';

        echo '<th class="ui-state-default ui-corner-top"> ' . Yii::t('app', 'Element') . ' </th>';
        
        foreach ($interValCol as $key => $interal) {

            $timeSelect = CHtml::dropDownList('Typelist[name]', $interal['unit'], array('5' => Yii::t('app', '5 Min'),
                        '10' => Yii::t('app', '10 Min'),
                        '15' => Yii::t('app', '15 Min'),
                        '30' => Yii::t('app', '30 Min'),
                        '60' => Yii::t('app', '1 Hr')), array('empty' => Yii::t('app', 'Select Option'), 'style' => 'max-width:50px', 'intervalType' => 'time', 'intervalName' => $key, 'class' => 'interval-range')
            );

            $intervalVal = isset($_SESSION[$key]) ? $_SESSION[$key] : $interal['unit'];
            $tonsSelect = CHtml::dropDownList('Typelist[name]', $intervalVal, array('500' => '500 Tons', '1000' => ' 1000 Tons'), array('empty' => 'Select Option', 'style' => 'max-width:80px', 'intervalType' => 'tons', 'intervalName' => $key, 'class' => 'interval-range')
            );
            if ($interal['type'] == 'time') {

                echo '<th class="ui-state-default ui-corner-top">' . $timeSelect . '</th>';
            } else {

                echo '<th class="ui-state-default ui-corner-top">' . $tonsSelect . '</th>';
            }
        }

        echo '</tr>';
    }

    public function buildRow($data) {

        $row = '';
        foreach ($data as $value) {

            $row .= "<td> $value</td>";
        }

        return $row;
    }

    public function renderElementRow($rowData) {
        $row = '';
        foreach ($rowData as $value) {

            $row .= "<td> $value</td>";
        }

        return $row;
    }

    public function renderSpRow($rowData, $spName) {
        $row = '';

        foreach ($rowData as $value) {

            $cellStyle = $this->getSPCellStyle($spName, $value);
            $row .= "<td class='$cellStyle'> $value</td>";
        }

        return $row;
    }

    /**
     * 
     * @param int $value
     */
    public function getSPCellStyle($spName, $value) {

        $cellStyle = '';
        $spModel = SetPoints::model()->find('sp_name = :sp_name', array(':sp_name' => $spName));

        if (($value >= ($spModel->sp_value_num + $spModel->sp_tolerance_ulevel)) || ($value <= ($spModel->sp_value_num  - $spModel->sp_tolerance_llevel))) {
            $cellStyle = 'sp-error';
        } else {
            $cellStyle = 'sp-info';
        }

        return $cellStyle;
    }

    public function isSetpoint($ele) {

        $spExits = SetPoints::model()->exists('sp_name = :sp_name', array(':sp_name' => $ele));
        return $spExits;
    }

    public function renderTagWidget() {

        $elements = $this->getElements();
        ?>

        <table class="full list-table">
            <tr>
                <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Tag ID') ?></th>
                <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Tag Name') ?></th>
                <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Start Time') ?></th>
                <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'End Time') ?></th>

                <?php
                foreach ($elements as $ele) {
                    echo '<th class="ui-state-default ui-corner-top">' . $ele . '</th>';
                }
                ?>

            </tr>
            <?php
	        $tagsQuery = 'select * from rta_tag_index_queued order by LocalendTime desc limit 5';
	
	        $completedTags = Yii::app()->db->createCommand($tagsQuery)->queryAll();

            foreach ($completedTags as $tag) {

                $interval = new IntervalObject();

                $interval->setStartTime($tag['LocalstartTime']);
                $interval->setEndTime($tag['LocalendTime']);
                //setStartTime
                //setEndTime
                $analysisDataProvider = new AnalysisDataProvider();
                $analysisDataProvider->setElements($elements);

                $record = $analysisDataProvider->getIntervalAvg($interval);

                echo '<tr>';
                $viewUrl = Yii::app()->createAbsoluteUrl('tagSettings/TagView', array('id' => $tag['tagID'], 'type' => 'queued'));

                echo '<th> <a  style="color:blue;" href="' . $viewUrl . '">' . $tag['tagID'] . '</a></th>';
                echo '<th> <a  style="color:blue;" href="' . $viewUrl . '">' . $tag['tagName'] . ' (Q)</a></th>';
                
                echo '<th>'. $tag['LocalstartTime'] . '</th>';
                
                echo '<th> ' . $tag['LocalendTime'] . '</th>';
                
                foreach ($elements as $ele) {


                    $cellValue = isset($record[$ele]) ? $record[$ele] : '-';
                    echo '<th>' . $cellValue . '</th>';
                }

                echo '</tr>';
            }
            
	        
	        if(count($completedTags ) < 5) {
	        	$nlv = 5 - count($completedTags ); 
	        	$tagsQuery2 = 'select * from rta_tag_index_completed order by LocalendTime desc limit ' . $nlv;
	
	        	$completedTags2 = Yii::app()->db->createCommand($tagsQuery2)->queryAll();

	            foreach ($completedTags2 as $tag) {
	
	                $interval = new IntervalObject();
	
	                $interval->setStartTime($tag['LocalstartTime']);
	                $interval->setEndTime($tag['LocalendTime']);
	                //setStartTime
	                //setEndTime
	                $analysisDataProvider = new AnalysisDataProvider();
	                $analysisDataProvider->setElements($elements);
	
	                $record = $analysisDataProvider->getIntervalAvg($interval);
	
	                echo '<tr>';
	                $viewUrl = Yii::app()->createAbsoluteUrl('tagSettings/TagView', array('id' => $tag['tagID'], 'type' => 'completed'));
	
	                echo '<th> <a  style="color:blue;" href="' . $viewUrl . '">' . $tag['tagID'] . '</a></th>';
	                echo '<th> <a style="color:blue;" href="' . $viewUrl . '">' . $tag['tagName'] . ' (C)</a></th>';
	                
	                echo '<th>'. $tag['LocalstartTime'] . '</th>';
	                
	                echo '<th> ' . $tag['LocalendTime'] . '</th>';
	                
	                foreach ($elements as $ele) {
	
	
	                    $cellValue = isset($record[$ele]) ? $record[$ele] : '-';
	                    echo '<th>' . $cellValue . '</th>';
	                }
	
	                echo '</tr>';
	            }
	        	
	        }
            
            ?>
        </table>

        <?php
    }

    public function renderTagPileWidget() {

        $styleAr = array("border-bottom:200px solid #689fb5 !important",
        				 "border-bottom:200px solid #674c77 !important");
        $stlyInc = 0;

        $elements = $this->getElements();
        $tagsQuery = 'select * from rta_tag_index_queued order by LocalendTime desc limit 2';

        $completedTags = Yii::app()->db->createCommand($tagsQuery)->queryAll();        

        foreach ($completedTags as $tag) {

            $interval = new IntervalObject();

            $interval->setStartTime($tag['LocalstartTime']);
            $interval->setEndTime($tag['LocalendTime']);
            //setStartTime
            //setEndTime
            $analysisDataProvider = new AnalysisDataProvider();
            $analysisDataProvider->setElements($elements);

            $record = $analysisDataProvider->getIntervalAvg($interval);
            $record['tagName'] = $tag['tagName'];
            $style = $styleAr[$stlyInc];
            $stlyInc++;
            $pileObject = new PileGraph($elements, $record, $style);

            $pileObject->render();
        }
        
        
        if(count($completedTags ) < 2) {
	        $nlv = 2 - count($completedTags ); 
        	$tagsQuery2 = 'select * from rta_tag_index_completed order by LocalendTime desc limit ' . $nlv;

        	$completedTags = Yii::app()->db->createCommand($tagsQuery2)->queryAll();

	        foreach ($completedTags as $tag) {
	
	            $interval = new IntervalObject();
	
	            $interval->setStartTime($tag['LocalstartTime']);
	            $interval->setEndTime($tag['LocalendTime']);
	            //setStartTime
	            //setEndTime
	            $analysisDataProvider = new AnalysisDataProvider();
	            $analysisDataProvider->setElements($elements);
	
	            $record = $analysisDataProvider->getIntervalAvg($interval);
	            $record['tagName'] = $tag['tagName'];
	            $style = $styleAr[$stlyInc];
	            $stlyInc++;
	            $pileObject = new PileGraph($elements, $record, $style);
	
	            $pileObject->render();
	        }

        }
        
    }

    public function renderSpWidget() {
        ?>


        <table class="full list-table">
            <thead>
                <tr> <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Name') ?></th>
                    <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Value') ?></th>
                    <th class="ui-state-default ui-corner-top"><?php echo Yii::t('app', 'Tolerance') ?> </th>
                    <th class="ui-state-default ui-corner-top"></th>
                </tr>

            </thead>
            <tbody>
                <?php
                $setPoint = SetPoints::model()->findAll();


                foreach ($setPoint as $sp) {

                    echo '<tr id="' . $sp['sp_name'] . '_view">';

                    echo '<th>' . $sp['sp_name'] . '</th>';
                    echo '<th id="' . $sp['sp_name'] . '_value">' . $sp['sp_value_num'] . '</th>';
                    echo '<th id=' . $sp['sp_name'] . '_tolerance>' . $sp['sp_tolerance_ulevel'] . '</th>';

                    echo '<th><span  data-id="' . $sp['sp_name'] . '" class="sp_edit ui-button-icon-primary ui-icon ui-icon-pencil"></span></th>';
                    echo '</tr>';


                    echo '<tr  id="' . $sp['sp_name'] . '_form" style="visibility:collapse"> ';

                    echo '<th><input type="hidden" id="' . $sp['sp_name'] . '_sp_id" value="' . $sp['sp_id'] . '" />' . $sp['sp_name'] . '</th>';
                    echo '<th> <input id="' . $sp['sp_name'] . '_sp_value_num" type="text" value="' . $sp['sp_value_num'] . '"/ size="4"> </th>';
                    echo '<th> <input id="' . $sp['sp_name'] . '_sp_tolerance_ulevel" type="text" value="' . $sp['sp_tolerance_ulevel'] . '" size="4"/> </th>';

                    echo '<th><span  data-id="' . $sp['sp_name'] . '" class="sp_save   ui-button-icon-primary ui-icon ui-icon-disk"></span></th>';
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>



        <?php
    }

}
