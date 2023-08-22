<?php

class OrgcontrolController extends Controller
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
				'actions'=>array('index','view','Save_categories'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$model=new OrgDepart;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgDepart']))
		{
			$model->attributes=$_POST['OrgDepart'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['OrgDepart']))
		{
			$model->attributes=$_POST['OrgDepart'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		// $dataProvider=new CActiveDataProvider('OrgDepart');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));

		$orgdepart=OrgDepart::model()->findAll(array(
			'condition'=>'orgchart_id='.$id,
		));
		$chk_orgdepart = array();
		if($orgdepart){
			foreach ($orgdepart as $key => $value) {
				$chk_orgdepart[] = $value->depart_id;
			}

		}

		
		$department=Department::model()->findAll();
		$chk_department = array();
		if($department){
			foreach ($department as $key => $value) {
				$chk_department[] = $value->id;
			}
		}


		// $result_orgdepart = array_diff($chk_orgdepart, $chk_department);
		$result_department = array_diff($chk_department, $chk_orgdepart);
		// var_dump($result_department);
		// exit();

		

		$this->render('index',array(
			'result_department'=> $result_department,
			'orgdepart'=>$orgdepart,
		));
	}

	public function actionSave_categories(){

		if(isset($_POST['categories'])) {

			$json = $_POST['categories'];
			$json2 = $_POST['categories2'];

			$data = json_decode($json, true);
			// var_dump($this->parseJsonArray($data));
			// exit();

			

			foreach (json_decode($json2, true) as $key => $value) {
				$orgc = OrgDepart::model()->findByPk($value['id']);
				if($orgc){
					$orgc->delete();
				}
				// echo $_GET['id'];
				// if(isset($value['children'])){
				foreach ($value['children'] as $key_children => $value_children) {
					$orgc2 = OrgCourse::model()->findByPk($value_children['id']);
					if($orgc2){
						$orgc2->delete();
					}
				}

			}
			
			foreach ($this->parseJsonArray($data) as $key => $value) {

				$orgc = OrgDepart::model()->findByPk($value['id']);
				if($orgc){
					// $course_online = CourseOnline::model()->findByPk($orgc->course_id);
					$orgc->parent_id = $value['parentID'];
					$orgc->save();
					// echo $value['id'];
				}else{
					$orgc = new OrgDepart;
					$orgc->orgchart_id = $_POST['org_id'];
					$orgc->depart_id = $value['id'];
					$orgc->parent_id = $value['parentID'];
					$orgc->active = 'y';
					$orgc->save();
				}

			}


		} else {
			echo "Noooooooo";
		}
	}
	
	public function parseJsonArray($jsonArray, $parentID = 0) 
	{
		$return = array();
		foreach ($jsonArray as $subArray) {
			$returnSubSubArray = array();
			if (isset($subArray['children'])) {
				$returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
			}
			$return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
			$return = array_merge($return, $returnSubSubArray);
		}
		return $return;
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrgDepart('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrgDepart']))
			$model->attributes=$_GET['OrgDepart'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrgDepart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrgDepart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrgDepart $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='org-depart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
