<?php

/**
 * This is the model class for table "node_widget".
 *
 * The followings are the available columns in table 'node_widget':
 * @property integer $node_widget_id
 * @property integer $node_id
 * @property string $node_item_name
 * @property string $type
 * @property string $settings
 * @property string $created_on
 * @property integer $created_by
 * @property string $updated_on
 * @property integer $updated_by
 * @property integer $position
 */
class NodeWidget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'node_widget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('node_id, node_item_name, settings, created_by, updated_by, position', 'required'),
			array('node_id, created_by, updated_by, position', 'numerical', 'integerOnly'=>true),
			array('node_item_name, type', 'length', 'max'=>100),
			array('settings', 'length', 'max'=>500),
			array('created_on, updated_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('node_widget_id, node_id, node_item_name, type, settings, created_on, created_by, updated_on, updated_by, position', 'safe', 'on'=>'search'),
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
			'node_widget_id' => 'Node Widget',
			'node_id' => 'Node',
			'node_item_name' => 'Node Item Name',
			'type' => 'Type',
			'settings' => 'Settings',
			'created_on' => 'Created On',
			'created_by' => 'Created By',
			'updated_on' => 'Updated On',
			'updated_by' => 'Updated By',
			'position' => 'Position',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('node_widget_id',$this->node_widget_id);
		$criteria->compare('node_id',$this->node_id);
		$criteria->compare('node_item_name',$this->node_item_name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('settings',$this->settings,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_on',$this->updated_on,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NodeWidget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
