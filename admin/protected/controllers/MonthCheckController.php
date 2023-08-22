<?php

class MonthCheckController extends Controller
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('view','MultiDeletes','create','update','delete','index','admin'),
            	'users' => array('*'),
            ),
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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
		$model = new MonthCheck;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MonthCheck']))
		{
			$model->attributes=$_POST['MonthCheck'];
			$model->type_user = 3;
			// $model->create_date = date("Y-m-d h:i:s");
			// $model->create_by = Yii::app()->user->id;
			
			if ($model->month_status == 'y') {
				$MonthCheck = MonthCheck::model()->findAll('type_user=' . $model->type_user . ' AND month_status="y"');
				if ($MonthCheck) {				
					foreach ($MonthCheck as $key => $value) {
					      $value['month_status'] = 'n';
					      $value->save();
					}
			 	}
			}
		
			$model->save();
			$this->redirect(array('admin','id'=>$model->id));
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
		if(isset($_POST['MonthCheck']))
		{
			$model->attributes=$_POST['MonthCheck'];
			if ($model->type_user == 3) {
				if ($model->month_status == 'y') {
				$MonthCheck = MonthCheck::model()->findAll('type_user=' . $model->type_user . ' AND month_status="y"');
				if ($MonthCheck) {				
					foreach ($MonthCheck as $key => $value) {
					      $value['month_status'] = 'n';
					      $value->save();
					}
			 	}
			}
			$model->save();
			$this->redirect(array('admin','id'=>$model->id));
			}else if($model->type_user == 5){
				if ($model->month_status == 'y') {
				$MonthCheck = MonthCheck::model()->findAll('type_user=' . $model->type_user . ' AND month_status="y"');
				if ($MonthCheck) {				
					foreach ($MonthCheck as $key => $value) {
					      $value['month_status'] = 'n';
					      $value->save();
					}
			 	}
			}
			$model->save();
			$this->redirect(array('personal','id'=>$model->id));
			}
	
			// $model->save();
			// $this->redirect(array('admin','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionCreate_personal()
	{
		$model = new MonthCheck;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MonthCheck']))
		{
			$model->attributes=$_POST['MonthCheck'];
			$model->type_user = 5;
			// $model->create_date = date("Y-m-d h:i:s");
			// $model->create_by = Yii::app()->user->id;

			if ($model->month_status == 'y') {
				$MonthCheck = MonthCheck::model()->findAll('type_user=' . $model->type_user . ' AND month_status="y"');
				if ($MonthCheck) {				
					foreach ($MonthCheck as $key => $value) {
					      $value['month_status'] = 'n';
					      $value->save();
					}
			 	}
			}
		
			$model->save();
			$this->redirect(array('personal','id'=>$model->id));
		}

		$this->render('create_personal',array(
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
		$model = $this->loadModel($id);
		if($id != 1){
			$model->active = 'n';
			$model->save(false);
			if(Yii::app()->user->id){
				Helpers::lib()->getControllerActionId();
			}
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
		// $dataProvider=new CActiveDataProvider('MonthCheck');
		$dataProvider=new CActiveDataProvider('MonthCheck' ,array('criteria'=>array(
			'condition'=>'active="y"')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionMultiDelete()
	{	

		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			}
			echo true;
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MonthCheck('search');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MonthCheck']))
			$model->attributes=$_GET['MonthCheck'];
       
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionPersonal()
	{
		$model=new MonthCheck('search');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MonthCheck']))
			$model->attributes=$_GET['MonthCheck'];
       
		$this->render('personal',array(
			'model'=>$model,
		));
	}

	public function actionActive($id){
    	$model = MonthCheck::model()->findByPk($id);
       
    	if($model->month_status == 'y'){	
    		$model->month_status = 'n';
    		$model->save(false);
    	} else if($model->month_status == 'n'){
            $model_month_status = MonthCheck::model()->findAll(array(
            'condition'=>'month_status=:month_status AND type_user=:type_user',
            'params' => array(':month_status' => 'y',':type_user'=>$model->type_user)
              ));
            
            foreach ($model_month_status as $key => $value) {
                if($value->month_status == 'y'){
                    $value->month_status = 'n';
                    $value->save(false);
                }
            }
    		$model->month_status = 'y';
    		$model->save(false);
    	}
    	$this->redirect(array('admin','id'=>$model->id));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MonthCheck the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MonthCheck::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MonthCheck $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='MonthCheck-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
