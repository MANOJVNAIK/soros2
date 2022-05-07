<?php

class ChartController extends BaseController
{
	public function actionIndex()
	{
		$element =Yii::app()->request->getParam('element','MgO');
		$startTimeString = date("Y-m-d H:i:s", time() - (8*60 *60));
        $endTimeString = date("Y-m-d H:i:s");
		$startTime =Yii::app()->request->getParam('start_time',$startTimeString);
        $endTime = Yii::app()->request->getParam('end_time',$endTimeString);

		$result = Yii::app()->db->createCommand()
		->select('LocalendTime,'.$element)
		->from('analysis_a1_a2_blend')
		->where('LocalendTime','>=',':LocalendTime', array(':LocalendTime'=>$startTime))
		->andWhere('LocalendTime','<=',':LocalendTime', array(':LocalendTime'=>$endTime))
		->queryAll();
		$this->sendSuccessResponse(array('data'=>$result));

		// var_dump($result);
		// die();
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}