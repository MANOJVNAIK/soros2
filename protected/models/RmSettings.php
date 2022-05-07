<?php

/**
 * This is the model class for table "rm_settings".
 *
 * The followings are the available columns in table 'rm_settings':
 * @property string $varName
 * @property string $varKey
 * @property string $varValue
 */
class RmSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rm_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('varName, varKey, varValue', 'required'),
			array('varName, varValue', 'length', 'max'=>500),
			array('varKey', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('varName, varKey, varValue', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'varName' => 'Var Name',
			'varKey' => 'Var Key',
			'varValue' => 'Var Value',
		);
	    }

	    /*     * *
	     * 
	     */

	    public static function getValueFromKey($key, $default) {

	        $result = Yii::app()->db->createCommand('select * from rm_settings where varKey="' . $key . '"')->queryRow();
	        $value = isset($result['varValue']) ? $result['varValue'] : $default;

	        return $value;
	    }

	    public static function setValueByKey($key, $value) {


	        $updQ = "UPDATE rm_settings set varValue='$value' WHERE varName = '$key'";

	        $resl = Yii::app()->db->createCommand($updQ)->query();
	        return $resl;
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

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('varName',$this->varName,true);
		//$criteria->compare('varKey',$this->varKey,true);
		$criteria->compare('varValue',$this->varValue,true);
		$criteria->addInCondition('varName', array('CHL_QTY',
							   'DEF_PLANT_CODE',
							   'WCL_SWITCH_CALIBRATION_FLAG',
							   'CAL_PROFILE_ACTIVE',
							   'AP_UNLOAD_CONFIRM_URL',
							   'AP_HEALTH_CHECK_URL',
							   'PB2_CLOSE_EXISTINGS_TAGS',
							   'RFID_TAGGRP_ID'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RmSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
