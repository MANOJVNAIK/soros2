<?php
use yii\web\Response;
use yii\helpers\Json;
class AnalysisController extends BaseController
{
	public function actionIndex()
	{
		$startTimeString = date("Y-m-d H:i:s", time() - (8*60 *60));
        $endTimeString = date("Y-m-d H:i:s");
		$startTime =Yii::app()->request->getParam('start_time',$startTimeString);
        $endTime = Yii::app()->request->getParam('end_time',$endTimeString);
		$page = ((int)(Yii::app()->request->getParam('page',0)));
        $pageSize =((int)(Yii::app()->request->getParam('page_size',10)));

		$result = Yii::app()->db->createCommand()
		->select()
		->from('analysis_a1_a2_blend')
		->where('LocalendTime','>=',':LocalendTime', array(':LocalendTime'=>$startTime))
		->andWhere('LocalendTime','<=',':LocalendTime', array(':LocalendTime'=>$endTime))
		->limit($pageSize,10)
		->offset($page*$pageSize,0)
		->queryAll();
		$this->sendSuccessResponse(array('data'=>$result));
	}
	public function actionHourlyAverage(){
		
		$startTimeString = date("Y-m-d H:i:s", time() - (8*60 *60));
        $endTimeString = date("Y-m-d H:i:s");
		$startTime =Yii::app()->request->getParam('start_time',$startTimeString);
        $endTime = Yii::app()->request->getParam('end_time',$endTimeString);
		$intervalStartTime = strtotime($startTime);
		$intervalEndTime = strtotime($startTime)+ (60*60);
		$res = [];
		
		while(($intervalEndTime) <= strtotime($endTime)){
			$intervalEndTimeTM = (date("Y-m-d H:i:s",$intervalEndTime));
			$intervalStartTimeTM = (date("Y-m-d H:i:s",$intervalStartTime));
					
					// $result = Yii::app()->db->createCommand()
					// ->select('Avg(MgO),LocalendTime,Avg(K2O)')
					// ->from('analysis_a1_a2_blend')
					// ->where('LocalendTime','>=',':LocalendTime', array(':LocalendTime'=>$intervalStartTimeTM))
					// ->andWhere('LocalendTime','<=',':LocalendTime', array(':LocalendTime'=>$intervalEndTimeTM))
					// ->queryAll();
						$sql = 'select COALESCE(Avg(MgO), 0 ) as MgO,LocalendTime,COALESCE(Avg(K2O), 0 ) as K2O
						from analysis_a1_a2_blend
						where LocalendTime >= \''.$intervalStartTimeTM.'\' and LocalendTime <= \''.$intervalEndTimeTM.'\'';
				
						$result = Yii::app()->db->createCommand($sql)->queryAll();
							if($result[0]['LocalendTime'] == NULL){
								$result[0]['LocalendTime'] = $intervalStartTimeTM;
							}
		 				$res[] = $result;
					$intervalStartTime = ($intervalEndTime);
					$intervalEndTime = (($intervalEndTime)+ (60*60));
		}
		$this->sendSuccessResponse(array('data'=>$res));

	}
	public function actionHourlyAverageelement(){
		
		$startTimeString = date("Y-m-d H:i:s", time() - (8*60 *60));
        $endTimeString = date("Y-m-d H:i:s");
		$startTime =Yii::app()->request->getParam('start_time',$startTimeString);
        $endTime = Yii::app()->request->getParam('end_time',$endTimeString);
		$elements =Yii::app()->request->getParam('elements','K2O,MgO');
		$elementArray = explode(',',$elements);
		$sqlSelect = [];
		foreach($elementArray as $ele){
			$sqlSelect[] = 'COALESCE(Avg('.$ele.'), 0 ) as '.$ele.''; 
		}
		$subSql = implode(',',$sqlSelect);
		$intervalStartTime = strtotime($startTime);
		$intervalEndTime = strtotime($startTime)+ (60*60);
		$res = [];
		
		while(($intervalEndTime) <= strtotime($endTime)){
			$intervalEndTimeTM = (date("Y-m-d H:i:s",$intervalEndTime));
			$intervalStartTimeTM = (date("Y-m-d H:i:s",$intervalStartTime));
					
					// $result = Yii::app()->db->createCommand()
					// ->select('Avg(MgO),LocalendTime,Avg(K2O)')
					// ->from('analysis_a1_a2_blend')
					// ->where('LocalendTime','>=',':LocalendTime', array(':LocalendTime'=>$intervalStartTimeTM))
					// ->andWhere('LocalendTime','<=',':LocalendTime', array(':LocalendTime'=>$intervalEndTimeTM))
					// ->queryAll();
						$sql = 'select LocalendTime,'.$subSql.'
						from analysis_a1_a2_blend
						where LocalendTime >= \''.$intervalStartTimeTM.'\' and LocalendTime <= \''.$intervalEndTimeTM.'\'';
				
						$result = Yii::app()->db->createCommand($sql)->queryAll();
							if($result[0]['LocalendTime'] == NULL){
								$result[0]['LocalendTime'] = $intervalStartTimeTM;
							}
		 				$res[] = $result;
					$intervalStartTime = ($intervalEndTime);
					$intervalEndTime = (($intervalEndTime)+ (60*60));
		}
		$this->sendSuccessResponse(array('data'=>$res));

	}
	public function actionAverage(){
	
		$startTime =Yii::app()->request->getParam('start_time');
        $endTime = Yii::app()->request->getParam('end_time');
		$selectSql = [];
		$sql = "select varValue from rm_settings where varKey = 'SOROS_ELEMENTS'";
		$res = Yii::app()->db->createCommand($sql)->queryScalar();
		$query = "select varValue from rm_settings where varKey = 'MINIMUM_TPH'";
		$minTPH = (int)Yii::app()->db->createCommand($query)->queryScalar();
		$element = explode(',',$res);
		foreach($element as $key => $value){
			$selectSql[] = 'Avg('.$value.') as '.$value;
		}
		$subSql = implode(',',$selectSql);
		$sql = 'select '.$subSql.'
						from analysis_a1_a2_blend
						where LocalendTime >= \''.$startTime.'\' and LocalendTime <= \''.$endTime.'\' and TPH > \''.$minTPH.'\'';
				
						$result = Yii::app()->db->createCommand($sql)->queryAll();
						// var_dump($result);
						// die();
						$result[0]['LocalstartTime'] = $startTime;
						$result[0]['LocalendTime'] = $endTime;

						$this->sendSuccessResponse(array('data'=>$result));
	}
	public function actionTonsRange(){
		$sumTons =(int)Yii::app()->request->getParam('sum_tons');
		
		$sql = "select max(dataID) from analysis_a1_a2_blend";
		$maxId = Yii::app()->db->createCommand($sql)->queryScalar();
		$totalTonSum = 0;
		$count = 0;
		$rowsEle = [];
		for($i=$maxId;$i>0;$i--){
			if($totalTonSum <= $sumTons){
				$rowQuery = 'select * from analysis_a1_a2_blend where dataID = '.$i.'';
				$rowElements = Yii::app()->db->createCommand($rowQuery)->queryAll();
				$rowsEle[] = $rowElements;
				$query = 'select totalTons from analysis_a1_a2_blend where dataID = '.$i.'';
				$totalTons = Yii::app()->db->createCommand($query)->queryScalar();
				$totalTonSum = $totalTonSum + $totalTons;
				$count++;
			}
		}
		// var_dump($totalTonSum/$count,$rowsEle);
		// die();
		$this->sendSuccessResponse(array('Average'=>$totalTonSum/$count,'rowElements'=>$rowsEle));
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
	// public function init() {//Abhi :: Figure out a better place for this to be applied.
	// 	//$defDTime = Yii::$app->params['defaultDateTime'];
	// 	//date_default_timezone_set($defDTime);
	// 			$this->request = json_decode(file_get_contents('php://input'), true);
	// 			if ($this->request && !is_array($this->request)) {
	// 				Yii::$app->api->sendFailedResponse(['Invalid Json']);
	// 			}
	// 		}
		
}