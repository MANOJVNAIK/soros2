<?php

class LayoutController extends BaseController
{
	public function actionIndex()
	{
		
        $id = $_REQUEST['id'];
		
        $sql = 'select name from layouts where layout_id = \''.$id.'\'';
		
        $layoutName = Yii::app()->db->createCommand($sql)->queryScalar();
		
		$query = 'select * from layout_widgets where layout_id = \''.$id.'\'';
        $widgets =Yii::app()->db->createCommand($query)->queryAll();

		
		$this->sendSuccessResponse(array($widgets,["layout_name" => $layoutName]));

	}
	public function actionCreate() {

        
        $formData = $this->request;
        

        // $string = '{"layoutId":1,"layoutName":"Template1","widgets":[{"widgetId":2,"type":"Table","size":"col-md-12","settings":{"data_columns":["TimeStamp","MgO","Al2O3","CaO","LSF","SM","IM","TPH"]}},{"widgetId":3,"type":"Chart","size":"col-md-3"},{"widgetId":4,"type":"Chart","size":"col-md-3"},{"widgetId":5,"type":"Chart","size":"col-md-3"},{"widgetId":6,"type":"Chart","size":"col-md-3"}]}';
        // $string  = json_encode($formData["layout"],true);
        // $data = json_decode($string, true);
        $data = $formData["layout"];
		
        $layoutModel = new Layouts;
        $layoutModel->name = $data['layoutName'];

        $layoutModel->user_id = 1;
        $layoutModel->created_by = 1; //Yii::$app->user->id;
        $layoutModel->created_on = date("Y-m-d H:i:s");
        $layoutModel->type = "dashbord";

        
        
        if ($layoutModel->save()) {
            foreach ($data["widgets"] as $id => $widget) {


                $layoutWidget = new LayoutWidgets;
                $layoutWidget->layout_id = $layoutModel->layout_id;
                $layoutWidget->position = $id;
                $layoutWidget->type = $widget['type'];
                $layoutWidget->created_on = date("Y-m-d H:i:s");
                $layoutWidget->created_by = 1;

                $layoutWidget->title = $widget['title'];

                $layoutWidget->updated_on = date("Y-m-d H:i:s");

                $layoutWidget->updated_by = 1;
                
                $layoutWidget->settings = json_encode($widget["settings"]);
                
               $layoutWidget->save();
               
                
            }

            $this->sendSuccessResponse(array('message'=>'Inserted Successfully'));
        } else {
//              var_dump($layoutModel->errors);
			$this->sendFailedResponse(array('message'=>'Not Inserted'));
        }

//        Yii::$app->api->sendSuccessResponse(json_decode($formData["layout"]));
}
public function actionUpdate() {

        
	$formData = $this->request;
        $data = $formData["layout"];
        $id = $data["id"];
		// var_dump($formData);
		// die();
        $layoutModel = $this->loadModel($id);

        $layoutModel->name = $data["layoutName"];

        $layoutModel->user_id = 1;
        $layoutModel->created_by = 1; //Yii::$app->user->id;
        $layoutModel->created_on = date("Y-m-d H:i:s");
        $layoutModel->type = "dashbord";
        
			
        if ($layoutModel->save()) {
            $sql = 'DELETE FROM layout_widgets WHERE layout_id = '.$id.'';
			
			Yii::app()->db->createCommand($sql)->queryAll();
          foreach ($data["widgets"] as $id => $widget) {
               
                $layoutWidget = new LayoutWidgets;
               
                //$layoutWidget = new LayoutWidgets();
                $layoutWidget->layout_id = $layoutModel->layout_id;
                $layoutWidget->position = $id;
                $layoutWidget->type = $widget['type'];
                $layoutWidget->created_on = date("Y-m-d H:i:s");
                $layoutWidget->created_by = 1;

                $layoutWidget->title = $widget['title'];

                $layoutWidget->updated_on = date("Y-m-d H:i:s");

                $layoutWidget->updated_by = 1;
                
                $layoutWidget->settings = json_encode($widget["settings"]);
                
               $layoutWidget->save();
               
            }
			$this->sendSuccessResponse(array('message'=>'Updated Successfully'));
        } else {
//              var_dump($layoutModel->errors);
			$this->sendFailedResponse(array('message'=>'Not Updated'));
//        Yii::$app->api->sendSuccessResponse(json_decode($formData["layout"]));
}}


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
	public function loadModel($id)
	{
		$model=Layouts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}