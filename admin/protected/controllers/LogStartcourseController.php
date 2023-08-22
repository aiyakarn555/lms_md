<?php

class LogStartcourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	
	public $layout='//layouts/column2';

	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
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
            array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
                'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
                'expression' => 'AccessControl::check_access()',
                ),
            array('deny',  // deny all users
                'users' => array('*'),
                ),
            );
    }

    public function actionIndex()
    {
    	$model = new LogStartcourse('search');
    	$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LogStartcourse']))
			$model->attributes=$_GET['LogStartcourse'];

		$this->render('index',array(
			'model'=>$model,
		));
    }

    public function actionSendOrgChart()
    {
        $model=new SendMailAlertCourse();
        $model->unsetAttributes();
        if(isset($_GET['SendMailAlertCourse']))

            $model->attributes=$_GET['SendMailAlertCourse'];

        $this->render('SendOrgChart',array('model'=>$model));
    }

    
    public function actionSendMailMessage()
    {
    	$id = $_POST['id'];
    	if ($id != null) {
	    	$LogStartcourse = LogStartcourse::model()->findByPk($id);
	    	$User = User::model()->findByPk($LogStartcourse->user_id);

	    	$criteria = new CDbCriteria;
            $criteria->compare('course_id', $LogStartcourse->course_id);
            $criteria->compare('lang_id', 1);
            $criteria->compare('active', 'y');
            $CourseOnline = CourseOnline::model()->find($criteria);
	    
	    	$criteria = new CDbCriteria;
            $criteria->compare('gen_id', $LogStartcourse->gen_id);
            $criteria->compare('active', 'y');
	    	$CourseGeneration = CourseGeneration::model()->find($criteria);

			$profile = Profile::model()->findByPk($LogStartcourse->user_id);
    		
    	$to['email'] = $User->email;
		$to['firstname'] = $User->profile->firstname;
		$to['lastname'] = $User->profile->lastname;
		$message = $this->renderPartial('_mail_CourseAlart',array('User' => $User,'CourseOnline'=> $CourseOnline,'CourseGeneration'=>$CourseGeneration),true);
		if($message){
			 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
	
		}
		$this->redirect(array('index'));
		}
    }

    public function actionMultiSendMailMessages()
    {
    	if (isset($_POST['chk'])) {
    		foreach ($_POST['chk'] as $key => $value) {
    			$LogStartcourse = LogStartcourse::model()->findByPk($value);
	    		$User = User::model()->findByPk($LogStartcourse->user_id);

		    	$criteria = new CDbCriteria;
	            $criteria->compare('course_id', $LogStartcourse->course_id);
	            $criteria->compare('lang_id', 1);
	            $criteria->compare('active', 'y');
	            $CourseOnline = CourseOnline::model()->find($criteria);
		    
		    	$criteria = new CDbCriteria;
	            $criteria->compare('gen_id', $LogStartcourse->gen_id);
	            $criteria->compare('active', 'y');
		    	$CourseGeneration = CourseGeneration::model()->find($criteria);

				$profile = Profile::model()->findByPk($LogStartcourse->user_id);
				$to['email'] = $User->email;
				$to['firstname'] = $User->profile->firstname;
				$to['lastname'] = $User->profile->lastname;
				$message = $this->renderPartial('_mail_CourseAlart',array('User' => $User,'CourseOnline'=> $CourseOnline,'CourseGeneration'=>$CourseGeneration),true);
				if($message){
					 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
			
				}
    		}
    	}
    }

    public function actionSendMailMessageCourse()
    {
    	$id = $_POST['id'];
    	if ($id != null) {
	    	// $LogStartcourse = LogStartcourse::model()->findByPk($id);
	    	$User = User::model()->findByPk($id);

	    	$criteria = new CDbCriteria;
            $criteria->compare('course_id', $_POST['course_id']);
            $criteria->compare('lang_id', 1);
            $criteria->compare('active', 'y');
            $CourseOnline = CourseOnline::model()->find($criteria);
	    
	    	$criteria = new CDbCriteria;
            $criteria->compare('course_id', $_POST['course_id']);
            $criteria->compare('active', 'y');
	    	$CourseGeneration = CourseGeneration::model()->find($criteria);

			$profile = Profile::model()->findByPk($id);
    		
    	$to['email'] = $User->email;
		$to['firstname'] = $User->profile->firstname;
		$to['lastname'] = $User->profile->lastname;
		$message = $this->renderPartial('_mail_CourseAlartCourse',array('User' => $User,'CourseOnline'=> $CourseOnline,'CourseGeneration'=>$CourseGeneration),true);
		if($message){
			 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
	
		}
		$this->redirect(array('index'));
		}
    }

    public function actionMultiSendMailCourseMessages()
    {
    	if (isset($_POST['chk'])) {

    		foreach ($_POST['chk'] as $key => $value) {
 
	    		$User = User::model()->findByPk($value);

		    	$criteria = new CDbCriteria;
	            $criteria->compare('course_id', $_POST['course'][$key]);
	            $criteria->compare('lang_id', 1);
	            $criteria->compare('active', 'y');
	            $CourseOnline = CourseOnline::model()->find($criteria);
		    
		    	$criteria = new CDbCriteria;
		    	$criteria->compare('course_id', $_POST['course'][$key]);
	            $criteria->compare('status', 1);
	            $criteria->compare('active', 'y');
		    	$CourseGeneration = CourseGeneration::model()->find($criteria);

				$profile = Profile::model()->findByPk($value);
				$to['email'] = $User->email;
				$to['firstname'] = $User->profile->firstname;
				$to['lastname'] = $User->profile->lastname;
				$message = $this->renderPartial('_mail_CourseAlartCourse',array('User' => $User,'CourseOnline'=> $CourseOnline,'CourseGeneration'=>$CourseGeneration),true);
				if($message){
					 $send = Helpers::lib()->SendMail($to,'แจ้งเตือนสมัครเข้าเรียนระบบ',$message);
			
				}
    		}
    	}
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Manage the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LogStartcourse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Manage $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='LogStartcourse-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionListTypeEmployee()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='type_employee_id=:type_employee_id AND active=:active';
			$criteria->params=array(':type_employee_id'=>$_POST['employee_id'],':active'=>'y');
			$criteria->order = 'sortOrder ASC';
			$model = Department::model()->findAll($criteria);
			if ($model) {

				$sub_list = Yii::app()->session['lang'] == 1?'Select Department ':'เลือกแผนก';
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
				}
				echo ($data); 
			}else{
				echo '<option value = "">ไม่พบข้อมูล</option>';

			}
		}

	public function actionListDepartment()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='department_id=:department_id AND active=:active';
			$criteria->params=array(':department_id'=>$_POST['department_id'],':active'=>'y');
			$criteria->order = 'sortOrder ASC';
			$model = Position::model()->findAll($criteria);
			if ($model) {

				$sub_list = Yii::app()->session['lang'] == 1?'Select Position ':'เลือกตำแหน่ง';
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->id.'"'.'>'.$value->position_title.'</option>';
				}
				echo ($data); 
			}else{
				echo '<option value = "">ไม่พบข้อมูล</option>';

			}
		}

	public function actionListGen()
		{
			$criteria= new CDbCriteria;
			$criteria->condition='course_id=:course_id AND active=:active';
			$criteria->params=array(':course_id'=>$_POST['course_id'],':active'=>'y');
			$model = CourseGeneration::model()->findAll($criteria);
			if ($model) {

				$sub_list = Yii::app()->session['lang'] == 1?'Select Gen ':'เลือกรุ่น';
				$data = '<option value ="">'.$sub_list.'</option>';
				foreach ($model as $key => $value) {
					$data .= '<option value = "'.$value->gen_id.'"'.'>'.$value->gen_title.'</option>';
				}
				echo ($data); 
			}else{
				echo '<option value = "">ไม่พบข้อมูล</option>';

			}
		}
}
