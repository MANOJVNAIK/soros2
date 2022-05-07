<?php

class RtaTagIndexCompletedController extends BaseController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$result = $this->loadModel($id);
		$this->sendSuccessResponse(array($result));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$columnData = $this->request;
		$model=new RtaTagIndexCompleted;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->rtaMasterID = $columnData["rtaMasterID"];
        $model->status = $columnData["status"];
        $model->tagName = $columnData["tagName"];
        $model->tagGroupID = $columnData["tagGroupID"];
        $model->LocalstartTime = $columnData["LocalstartTime"];
        $model->LocalendTime = $columnData["LocalendTime"];
        $model->goodDataSecondsWeight = $columnData["goodDataSecondsWeight"];
        $model->massflowWeight = $columnData["massflowWeight"];
        $model->validTag = $columnData["validTag"];
        $model->endTic = $columnData["endTic"];
        $model->startTic = $columnData["startTic"];
        $model->goodDataSecs = $columnData["goodDataSecs"];
        $model->avgMassFlowTph = $columnData["avgMassFlowTph"];
        $model->totalTons = $columnData["totalTons"];
        $model->Ash = $columnData["Ash"];
        $model->Sulfur = $columnData["Sulfur"];
        $model->Moisture = $columnData["Moisture"];
        $model->BTU = $columnData["BTU"];
        $model->Na2O = $columnData["Na2O"];
        $model->SO2 = $columnData["SO2"];
        $model->TPH = $columnData["TPH"];
        $model->SiO2 = $columnData["SiO2"];
        $model->Al2O3 = $columnData["Al2O3"];
        $model->Fe2O3 = $columnData["Fe2O3"];
        $model->TEST = $columnData["TEST"];
        $model->CAL_ID = $columnData["CAL_ID"];
        $model->MAFBTU = $columnData["MAFBTU"];
        $model->CaO = $columnData["CaO"];
        $model->MgO = $columnData["MgO"];
        $model->K2O = $columnData["K2O"];
        $model->TiO2 = $columnData["TiO2"];
        $model->Mn2O3 = $columnData["Mn2O3"];
        $model->P2O5 = $columnData["P2O5"];
        $model->SO3 = $columnData["SO3"];
        $model->Cl = $columnData["Cl"];
        $model->LOI = $columnData["LOI"];
        $model->LSF = $columnData["LSF"];
        $model->SM = $columnData["SM"];
        $model->AM = $columnData["AM"];
        $model->IM = $columnData["IM"];
        $model->C4AF = $columnData["C4AF"];
        $model->NAEQ = $columnData["NAEQ"];
        $model->C3S = $columnData["C3S"];
        $model->C3A = $columnData["C3A"];
        $model->SourceDeployed = $columnData["SourceDeployed"];
        $model->SourceStored = $columnData["SourceStored"];
        $model->CPS = $columnData["CPS"];
        $model->K = $columnData["K"];
        $model->V2O5 = $columnData["V2O5"];
        $model->CdO = $columnData["CdO"];
        $model->GCV = $columnData["GCV"];
        $model->CPS_det1 = $columnData["CPS_det1"];
        $model->CPS_Det2 = $columnData["CPS_Det2"];
		
		if($model->save()){
			$this->sendSuccessResponse(array('message'=>'Created Succesfully'));
		}else{
			
			$this->sendFailedResponse(array('message'=>'Not Created'));
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$columnData = $this->request;
		
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->rtaMasterID = $columnData["rtaMasterID"];
        $model->status = $columnData["status"];
        $model->tagName = $columnData["tagName"];
        $model->tagGroupID = $columnData["tagGroupID"];
        $model->LocalstartTime = $columnData["LocalstartTime"];
        $model->LocalendTime = $columnData["LocalendTime"];
        $model->goodDataSecondsWeight = $columnData["goodDataSecondsWeight"];
        $model->massflowWeight = $columnData["massflowWeight"];
        $model->validTag = $columnData["validTag"];
        $model->endTic = $columnData["endTic"];
        $model->startTic = $columnData["startTic"];
        $model->goodDataSecs = $columnData["goodDataSecs"];
        $model->avgMassFlowTph = $columnData["avgMassFlowTph"];
        $model->totalTons = $columnData["totalTons"];
        $model->Ash = $columnData["Ash"];
        $model->Sulfur = $columnData["Sulfur"];
        $model->Moisture = $columnData["Moisture"];
        $model->BTU = $columnData["BTU"];
        $model->Na2O = $columnData["Na2O"];
        $model->SO2 = $columnData["SO2"];
        $model->TPH = $columnData["TPH"];
        $model->SiO2 = $columnData["SiO2"];
        $model->Al2O3 = $columnData["Al2O3"];
        $model->Fe2O3 = $columnData["Fe2O3"];
        $model->TEST = $columnData["TEST"];
        $model->CAL_ID = $columnData["CAL_ID"];
        $model->MAFBTU = $columnData["MAFBTU"];
        $model->CaO = $columnData["CaO"];
        $model->MgO = $columnData["MgO"];
        $model->K2O = $columnData["K2O"];
        $model->TiO2 = $columnData["TiO2"];
        $model->Mn2O3 = $columnData["Mn2O3"];
        $model->P2O5 = $columnData["P2O5"];
        $model->SO3 = $columnData["SO3"];
        $model->Cl = $columnData["Cl"];
        $model->LOI = $columnData["LOI"];
        $model->LSF = $columnData["LSF"];
        $model->SM = $columnData["SM"];
        $model->AM = $columnData["AM"];
        $model->IM = $columnData["IM"];
        $model->C4AF = $columnData["C4AF"];
        $model->NAEQ = $columnData["NAEQ"];
        $model->C3S = $columnData["C3S"];
        $model->C3A = $columnData["C3A"];
        $model->SourceDeployed = $columnData["SourceDeployed"];
        $model->SourceStored = $columnData["SourceStored"];
        $model->CPS = $columnData["CPS"];
        $model->K = $columnData["K"];
        $model->V2O5 = $columnData["V2O5"];
        $model->CdO = $columnData["CdO"];
        $model->GCV = $columnData["GCV"];
        $model->CPS_det1 = $columnData["CPS_det1"];
        $model->CPS_Det2 = $columnData["CPS_Det2"];
		
		if($model->save()){
			$this->sendSuccessResponse(array('message'=>'Updated Succesfully'));
		}else{
			
			$this->sendFailedResponse(array('message'=>'Not Updated'));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->sendSuccessResponse(array('message'=>'Deleted successfully'));

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$result = Yii::app()->db->createCommand()
		->select()
		->from('rta_tag_index_completed')
		->queryAll();
		$this->sendSuccessResponse(array('data'=>$result));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RtaTagIndexCompleted('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RtaTagIndexCompleted']))
			$model->attributes=$_GET['RtaTagIndexCompleted'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RtaTagIndexCompleted the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RtaTagIndexCompleted::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RtaTagIndexCompleted $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rta-tag-index-completed-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
