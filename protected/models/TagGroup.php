<?php

/**
 * This is the model class for table "tag_group".
 *
 * The followings are the available columns in table 'tag_group':
 * @property string $tagGroupID
 * @property string $tagGroupName
 * @property string $rtaMasterID
 * @property string $massflowWeight
 * @property string $goodDataSecondsWeight
 */
class TagGroup extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $totalTags;
    public $startTime;
    public $endTime;
    public $datetimeFormat;

    public function __construct() {
        $this->datetimeFormat = RmSettings::getValueFromKey('GLOBAL_TIME_FORMAT', 'Y-m-d H:i:s');
    }

    public function tableName() {
        return 'tag_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tagGroupName, rtaMasterID, massflowWeight, goodDataSecondsWeight', 'required'),
            array('tagGroupName', 'length', 'max' => 120),
            array('rtaMasterID', 'length', 'max' => 4),
            array('massflowWeight, goodDataSecondsWeight', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('tagGroupID, tagGroupName, rtaMasterID, massflowWeight, goodDataSecondsWeight', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tagGroupID' => Yii::t('app', 'Tag Group'),
            'tagGroupName' => Yii::t('app', 'Tag Group Name'),
            'rtaMasterID' => Yii::t('app', 'Rta Master'),
            'massflowWeight' => Yii::t('app', 'Massflow Weight'),
            'goodDataSecondsWeight' => Yii::t('app', 'Good Data Seconds Weight'),
            'totalTags' => Yii::t('app', 'No of Tags'),
            'startTime' => Yii::t('app', 'Start Time'),
            'endTime' => Yii::t('app', 'End Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('tagGroupID', $this->tagGroupID, true);
        $criteria->compare('tagGroupName', $this->tagGroupName, true);
        $criteria->compare('rtaMasterID', $this->rtaMasterID, true);
        $criteria->compare('massflowWeight', $this->massflowWeight, true);
        $criteria->compare('goodDataSecondsWeight', $this->goodDataSecondsWeight, true);


        //massflowWeight , goodDataSecondsWeight
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TagGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAllTags() {

        $queuedTags = $this->getQuedTags();
        $completedTags = $this->getCompletedTags();

        return array('queuedTags' => $queuedTags, 'completedTags' => $completedTags);
    }

    public function getCompletedTags() {

        if (!isset ($_REQUEST['page']) ) {  
            $page = 1;  
        } else {  
            $page = $_REQUEST['page'];  
        }
        $results_per_page = 20;  
        $page_first_result = ($page-1) * $results_per_page;  
        
        $tagGroupID = $this->tagGroupID;
        $tagNameOnly = isset($_POST['search_name_only']) ? isset($_POST['search_name_only']) : false;
  

        if ($tagNameOnly) {

            $tagName = isset($_POST['tagGroup_tagName']) ? $_POST['tagGroup_tagName'] : "999";
		
	    $tagWhere =	($tagName != "999")	? "tagName LIKE '%" . $tagName . "%' and" : "";

            $query = "select * from rta_tag_index_completed where $tagWhere tagGroupID = $tagGroupID   ORDER BY LocalendTime DESC";
        } else if (isset($_POST['tagGroup_startDate']) && $_POST['tagGroup_endDate']) {
            $strtDateStirng = $_POST["tagGroup_startDate"] . " " . $_POST["tagGroup_startTime"];
            $endDateString = $_POST["tagGroup_endDate"] . " " . $_POST["tagGroup_endTime"];
            $startDateTime = date('Y-m-d H:i:s', strtotime($strtDateStirng));
            $endDateTime = date('Y-m-d H:i:s', strtotime($endDateString));
            $tagGroupID = isset($_POST['tagGroup_tagGroupID']) ? $_POST['tagGroup_tagGroupID'] : $tagGroupID;
            $tagName = isset($_POST['tagGroup_tagName']) ? $_POST['tagGroup_tagName'] : "999";

	    $tagWhere =	($tagName != "999")	? "tagName LIKE '%" . $tagName . "%' and" : "";

            $query = "select * from rta_tag_index_completed where $tagWhere tagGroupID = $tagGroupID  and LocalendTime >'$startDateTime' AND LocalendTIme < '$endDateTime' ORDER BY LocalendTime DESC";
        } else {

            $query = "select * from rta_tag_index_completed where tagGroupID = $tagGroupID ORDER BY LocalendTime DESC";
        }

        $results = Yii::app()->db->createCommand($query)->queryAll();
        
        //AB82321
        $number_of_result = count($results);
        $number_of_page = ceil ($number_of_result / $results_per_page);  
        $limitAdditionQry = "";//"" LIMIT " . $page_first_result . ',' . $results_per_page;

        $finalQuery = $query . $limitAdditionQry;
        var_dump($finalQuery);
//        die();
        $results = Yii::app()->db->createCommand($finalQuery)->queryAll();        

        return $results;
    }

    public function getQuedTags() {

        
        $tagGroupID = $this->tagGroupID;
        if (isset($_POST['tagGroup_startDate']) && $_POST['tagGroup_endDate']) {
            $strtDateStirng = $_POST["tagGroup_startDate"] . " " . $_POST["tagGroup_startTime"];
            $endDateString = $_POST["tagGroup_endDate"] . " " . $_POST["tagGroup_endTime"];
            $startDateTime = date('Y-m-d H:i:s', strtotime($strtDateStirng));
            $endDateTime = date('Y-m-d H:i:s', strtotime($endDateString));

            $query = "select * from rta_tag_index_queued where tagGroupID = $tagGroupID  and LocalendTime >'$startDateTime' AND LocalendTIme < '$endDateTime' ORDER BY LocalendTime DESC";
        } else {


            $query = "select * from rta_tag_index_queued where tagGroupID = $tagGroupID ORDER BY LocalendTime DESC";
        }
        $query = "select * from rta_tag_index_queued where tagGroupID = $tagGroupID ORDER BY LocalendTime DESC";
        $results = Yii::app()->db->createCommand($query)->queryAll();
        return $results;
    }

    public static function getDefaultTagGroupID() {

        $tagGroups = TagGroup::model()->findAll(" 1 order by tagGroupID DESC ");
        return $tagGroups[0]->tagGroupID;
    }

    public function getItems() {

        $completedSql = 'select count(tagGroupID) as total from rta_tag_index_completed where tagGroupID =' . $this->tagGroupID;

        $queuedSql = 'select count(tagGroupID) as total from rta_tag_index_queued where tagGroupID =' . $this->tagGroupID;

        $completedCount = Yii::app()->db->createCommand($completedSql)->queryScalar();
        $queuedCount = Yii::app()->db->createCommand($queuedSql)->queryScalar();


        return $completedCount + $queuedCount;
    }

    public static function getTagById($id){
        
        $completedTag = TagCompleted::model()->findByPk($id);
        
        if($completedTag){
            return $completedTag;
        }
        
        $queuedTag = TagQueued::model()->findByPk($id);
        if($queuedTag){
            return $queuedTag; 
        }
        
        return false;
        
    }
    public function getViewLink() {

        $url = Yii::app()->createAbsoluteUrl("tagGroup", array("id" => $this->tagGroupID));

        $link = "<a href='$url'>" . $this->tagGroupName . "</a>";
        return $link;
    }

    public function getStartTime() {
        $compStartTimeSql = 'select min(LocalstartTime) as minTime from rta_tag_index_completed where tagGroupID =' . $this->tagGroupID;
        $queuedStartTimeSql = 'select min(LocalstartTime) as minTime from rta_tag_index_queued where tagGroupID =' . $this->tagGroupID;


        $compStartTime = Yii::app()->db->createCommand($compStartTimeSql)->queryScalar();
        $queuedStartTime = Yii::app()->db->createCommand($queuedStartTimeSql)->queryScalar();

        $compStartTime = $compStartTime == null ? date('Y-m-d H:i:s') : $compStartTime;
        $queuedStartTime = $queuedStartTime == null ? date('Y-m-d H:i:s') : $compStartTime;

        if (strtotime($compStartTime) < strtotime($queuedStartTime)) {

            return date($this->datetimeFormat, strtotime($compStartTime));
        } else {

            return date($this->datetimeFormat, strtotime($queuedStartTime));
        }
    }

    public function getEndTime() {


        $compEndTimeSql = 'select max(LocalendTime) as maxTime from rta_tag_index_completed where tagGroupID =' . $this->tagGroupID;
        $queuedEndTimeSql = 'select max(LocalendTime) as maxTime from rta_tag_index_queued where tagGroupID =' . $this->tagGroupID;


        $compEndTime = Yii::app()->db->createCommand($compEndTimeSql)->queryScalar();
        $queuedEndTime = Yii::app()->db->createCommand($queuedEndTimeSql)->queryScalar();

        $compStartTime = $compStartTime == null ? date('Y-m-d H:i:s', 0) : $compStartTime;
        $queuedStartTime = $queuedStartTime == null ? date('Y-m-d H:i:s', 0) : $compStartTime;

        if (strtotime($compEndTime) > strtotime($queuedEndTime)) {


            return date($this->datetimeFormat, strtotime($compEndTime));
        } else {

            return date($this->datetimeFormat, strtotime($queuedEndTime));
        }
    }

}
