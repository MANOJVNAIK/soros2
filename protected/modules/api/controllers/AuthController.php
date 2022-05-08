<?php

class AuthController extends BaseController
{
	public function actionIndex()
	{
		$this->render('index');
	}
        public function actionLogin()
	{
//		$this->render('index');
                
                $user = array('role' => 'superadmin',
                              'isEmailVerified' => false,  
                              'email' => 'admin@sabiainc.com',
                                'name' => 'Admin',
                                'companyId' => '61935e6d09c8b105708d356d',
                                'client_assigned' => ''
                    );
                $token = array('access'=> array("token" => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2MTlkZmM0OGY3ZThjNjRlMzA4ZjI3NzciLCJpYXQiOjE2NTE4MTc1MjIsImV4cCI6MTY1MTgxOTMyMiwidHlwZSI6ImFjY2VzcyJ9.3tDfXnyf2QawmcCywmEsFNld33BGNhDC3SZh6YSR8Yg","expires":"2022-05-06T06:42:02.161Z"},"refresh":{"token":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2MTlkZmM0OGY3ZThjNjRlMzA4ZjI3NzciLCJpYXQiOjE2NTE4MTc1MjIsImV4cCI6MTY1NDQwOTUyMiwidHlwZSI6InJlZnJlc2gifQ.B5rH9YIaGcwSmm3o6k1zn_6woNmI22_AsY82dH_oRak","expires":"2022-06-05T06:12:02.162Z'));
                $accessInfo = array("user" =>$user , 'tokens'=> $token );
                    
                
                
                $this->sendSuccessResponse($accessInfo);
//                echo '{"user":{"role":"superadmin","isEmailVerified":false,"email":"admin@pierian.com","name":"Super Admin","companyId":"61935e6d09c8b105708d356d",'
//                . '"client_assigned":[],"id":"619dfc48f7e8c64e308f2777"},"tokens":{"access":{"token":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2MTlkZmM0OGY3ZThjNjRlMzA4ZjI3NzciLCJpYXQiOjE2NTE4MTc1MjIsImV4cCI6MTY1MTgxOTMyMiwidHlwZSI6ImFjY2VzcyJ9.3tDfXnyf2QawmcCywmEsFNld33BGNhDC3SZh6YSR8Yg","expires":"2022-05-06T06:42:02.161Z"},"refresh":{"token":"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI2MTlkZmM0OGY3ZThjNjRlMzA4ZjI3NzciLCJpYXQiOjE2NTE4MTc1MjIsImV4cCI6MTY1NDQwOTUyMiwidHlwZSI6InJlZnJlc2gifQ.B5rH9YIaGcwSmm3o6k1zn_6woNmI22_AsY82dH_oRak","expires":"2022-06-05T06:12:02.162Z"}}}';
                
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