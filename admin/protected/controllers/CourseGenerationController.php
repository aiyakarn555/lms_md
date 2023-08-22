<?php

class CourseGenerationController extends Controller
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
				'actions'=>array('index','view', 'delete', 'Active', 'MultiDelete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'delete', 'Active', 'MultiDelete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'Active', 'MultiDelete'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new CourseGeneration;
		$model->course_id = $id;

			if(isset($_POST['CourseGeneration']))
			{
				$model->attributes=$_POST['CourseGeneration'];
				
				if($_POST['CourseGeneration']['gen_period_start'] == ""){
					$model->gen_period_start = null;
				}
				if($_POST['CourseGeneration']['gen_period_end'] == ""){
					$model->gen_period_end = null;
				}				
				$model->scenario = 'validateCheck';

				if ($model->validate()) {
					if($model->save()){
						if($model->status == 1){ // เปิดรุ่น ได้แค่ รุ่นเดียว
							$model_check = CourseGeneration::model()->findAll("course_id='".$id."' AND gen_id != '".$model->gen_id."'");
							if(!empty($model_check)){
							foreach ($model_check as $key => $value) {
								$model_edit = CourseGeneration::model()->findByPk($value->gen_id);
								if($model_edit->status != 2){
									$model_edit->status = 2;
									$model_edit->save(false);
								}
							}
						}
						}
						if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
						$this->redirect(array('index','id'=>$id));
					}
				}
			}

			$this->render('create',array(
				'model'=>$model,
			));
	// $this->redirect(array('course/index'));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['CourseGeneration']))
			{
				$model->attributes = $_POST['CourseGeneration'];
				$model->gen_detail = $_POST['CourseGeneration']['gen_detail'];

				if($_POST['CourseGeneration']['gen_period_start'] == ""){
					$model->gen_period_start = null;
				}
				if($_POST['CourseGeneration']['gen_period_end'] == ""){
					$model->gen_period_end = null;
				}
				$model->scenario = 'validateCheck';

				if($model->save()){
					if($model->status == 1){ // เปิดรุ่น ได้แค่ รุ่นเดียว
						$model_check = CourseGeneration::model()->findAll("course_id='".$model->course_id."' AND gen_id != '".$model->gen_id."'");
						if(!empty($model_check)){
						foreach ($model_check as $key => $value) {
							$model_edit = CourseGeneration::model()->findByPk($value->gen_id);
							if($model_edit->status != 2){
								$model_edit->status = 2;
								$model_edit->save(false);
							}
						}
					}
					}
					if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
						$this->redirect(array('index','id'=>$model->course_id));

					// if(Yii::app()->user->id){
					// 	Helpers::lib()->getControllerActionId();
					// }
					// $this->redirect(array('view','id'=>$model->gen_id));
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
		$model=$this->loadModel($id);
		$model->active = 'n';
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

	}

	public function actionMultiDelete()
	{
		// header('Content-type: application/json');
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		$model=new CourseGeneration('search');		
		$model->unsetAttributes();  // clear any default values
		$model->course_id = $id;
		$model->active = 'y';
		if(isset($_GET['CourseGeneration']))
			$model->attributes=$_GET['CourseGeneration'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CourseGeneration('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseGeneration']))
			$model->attributes=$_GET['CourseGeneration'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionActive($id){
		$model = CourseGeneration::model()->find("gen_id = '".$id."'");

		if($model->status == 2){
			// $model_check = CourseGeneration::model()->findAll("course_id='".$model->course_id."' AND gen_id != '".$model->gen_id."'");
			// if(!empty($model_check)){
			// 	foreach ($model_check as $key => $value) {
			// 		$model_edit = CourseGeneration::model()->findByPk($value->gen_id);
			// 		if($model_edit->status != 2){
			// 			$model_edit->status = 2;
			// 			$model_edit->save(false);
			// 		}
			// 	}
			// }

			$model->status = 1;
			$model->save();
		}else{
			$model->status = 2;
			$model->save();
		}
		$this->redirect(array('/courseGeneration/index/'.$model->course_id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CourseGeneration the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CourseGeneration::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CourseGeneration $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-generation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
