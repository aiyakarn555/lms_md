<?php

class ReportProblemController extends Controller
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
				'actions'=>array('index','view','ReportProblem'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ReportProblem'),
				'users'=>array('@'),
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
	// public function actionView($id)
	// {
	// 	$this->render('view',array(
	// 		'model'=>$this->loadModel($id),
	// 	));
	// }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionReportProblem()
	{
		
  //var_dump($_POST['ReportProblem']);exit();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportProblem']))
		{
			$ReportProblem = new ReportProblem;
			$ReportProblem->attributes=$_POST['ReportProblem'];
			$report_pic  = CUploadedFile::getInstance($ReportProblem, 'report_pic');
			$rnd = rand(0,9999999999);
			$fileName = "{$rnd}-{$report_pic}";
			$ReportProblem->report_pic = $fileName;
			$ReportProblem->report_date = date("Y-m-d H:i:s");
			if($ReportProblem->save()){
				if (isset($report_pic)) {

					$webroot = Yii::app()->basePath.'/../uploads/ReportProblem/'.$fileName;
					if(!empty($report_pic))  
					{
						$report_pic->saveAs($webroot);
					}
					
				}

				Yii::app()->user->setFlash('msg',"ผู้ดูแลระบบได้รับปัญหาที่ท่านแจ้งแล้ว กรุณารอรับอีเมลตอบกลับจากผู้ดูแลระบบ");
				Yii::app()->user->setFlash('icon', "success");
				$this->redirect(array('site/index'));
					
			}

			$this->redirect(array('site/index'));
				//$this->redirect(array('view','id'=>$model->id));
		}
		$this->redirect(array('site/index'));
		// $this->render('ReportProblem',array(
		// 	'model'=>$model,
		// ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	// public function actionUpdate($id)
	// {
	// 	$model=$this->loadModel($id);

	// 	// Uncomment the following line if AJAX validation is needed
	// 	// $this->performAjaxValidation($model);

	// 	if(isset($_POST['ReportProblem']))
	// 	{
	// 		$model->attributes=$_POST['ReportProblem'];
	// 		if($model->save())
	// 			$this->redirect(array('view','id'=>$model->id));
	// 	}

	// 	$this->render('update',array(
	// 		'model'=>$model,
	// 	));
	// }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	// public function actionDelete($id)
	// {
	// 	$this->loadModel($id)->delete();

	// 	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	// 	if(!isset($_GET['ajax']))
	// 		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	// }

	// /**
	//  * Lists all models.
	//  */
	// public function actionIndex()
	// {
	// 	$dataProvider=new CActiveDataProvider('ReportProblem');
	// 	$this->render('index',array(
	// 		'dataProvider'=>$dataProvider,
	// 	));
	// }

	// /**
	//  * Manages all models.
	//  */
	// public function actionAdmin()
	// {
	// 	$model=new ReportProblem('search');
	// 	$model->unsetAttributes();  // clear any default values
	// 	if(isset($_GET['ReportProblem']))
	// 		$model->attributes=$_GET['ReportProblem'];

	// 	$this->render('admin',array(
	// 		'model'=>$model,
	// 	));
	// }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ReportProblem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ReportProblem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ReportProblem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='report-problem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
