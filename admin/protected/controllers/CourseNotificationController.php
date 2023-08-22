<?php

class CourseNotificationController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
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
            // array('allow',  // allow all users to perform 'index' and 'view' actions
            //     'actions' => array('index', 'view'),
            //     'users' => array('*'),
            //     ),
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
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	// public function filters()
	// {
	// 	return array(
	// 		'accessControl', // perform access control for CRUD operations
	// 		'postOnly + delete', // we only allow deletion via POST request
	// 	);
	// }

	// /**
	//  * Specifies the access control rules.
	//  * This method is used by the 'accessControl' filter.
	//  * @return array access control rules
	//  */
	// public function accessRules()
	// {
	// 	return array(
	// 		array('allow',  // allow all users to perform 'index' and 'view' actions
	// 			'actions'=>array('index','view'),
	// 			'users'=>array('*'),
	// 		),
	// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
	// 			'actions'=>array('create','update'),
	// 			'users'=>array('@'),
	// 		),
	// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
	// 			'actions'=>array('admin','delete'),
	// 			'users'=>array('admin'),
	// 		),
	// 		array('deny',  // deny all users
	// 			'users'=>array('*'),
	// 		),
	// 	);
	// }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CourseNotification;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		// var_dump($_POST);exit();
		if(!empty($_POST['CourseNotification']))
		{
			$model->attributes=$_POST['CourseNotification'];
			// $array_id = $model->course_id_data;
			$array_id = $_POST['course_id'];
			// var_dump($_POST['CourseNotification']);
			// exit();
			if(is_array($array_id)){
				$value = '';
				$courses = $array_id;
				foreach ($courses as $key => $course) {
					$course_id=new CourseNotification;
					$course_id->attributes=$_POST['CourseNotification'];
					$course_id->course_id = $course;
					$course_id->notification_time = $_POST['CourseNotification']['notification_time'];
					$state = false;
					if($course_id->validate()){
						$course_id->end_date = Yii::app()->dateFormatter->format("y-M-d",strtotime($course_id->end_date));
						$course_id->create_date = date('Y-m-d H:i:s');
						$course_id->create_by = Yii::app()->user->id;
						$course_id->save();
						$state = true;
						if(Yii::app()->user->id){
							Helpers::lib()->getControllerActionId();
						}
						// $this->redirect(array('/coursenotification/index'));
					} else {
						$this->render('create',array(
							'model'=>$model,
						));
					}
				}
				if($state){
					$this->redirect(array('/courseNotification/index'));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CourseNotification']))
		{
			$model->attributes=$_POST['CourseNotification'];
			$model->end_date = Yii::app()->dateFormatter->format("y-M-d",strtotime($model->end_date));
			$model->update_date = date('Y-m-d H:i:s');
			$model->update_by = Yii::app()->user->id;
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('/courseNotification/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new CourseNotification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseNotification']))
			$model->attributes=$_GET['CourseNotification'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CourseNotification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseNotification']))
			$model->attributes=$_GET['CourseNotification'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CourseNotification the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CourseNotification::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CourseNotification $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-notification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
