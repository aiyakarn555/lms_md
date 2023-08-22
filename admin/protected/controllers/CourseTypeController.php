<?php

class CourseTypeController extends Controller
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
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	  public function init()
    {
    	parent::init();
    	$this->lastactivity();

    }

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
		$model=new CourseType;

		if(isset($_POST['CourseType'])) {
			$model->attributes=$_POST['CourseType'];

			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			if($model->save()){
				$model->sortOrder = $model->type_id;
				$model->save();

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
				if($model->parent_id == 0){
					$rootId = $model->type_id;
				}else{
					$rootId = $model->parent_id;
				}

				foreach ($langs as $key => $lang) {
					$models = CourseType::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
					if(!$models){
						$Root = CourseType::model()->findByPk($rootId);
						Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มประเภท '.$Root->type_name .',ภาษา '.$lang->language);

						$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
						exit(); 
					}
				}
				$this->redirect(array('index','id'=>$rootId));
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


		if(isset($_POST['CourseType']))
		{
			$model->attributes=$_POST['CourseType'];
			if($model->save()){
				// $this->redirect(array('view','id'=>$model->type_id));

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				
				$this->redirect(array('index','id'=>$rootId));				

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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new CourseType('search');
		$model->unsetAttributes();
		if(isset($_GET['CourseType']))
			$model->attributes=$_GET['CourseType'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CourseType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseType']))
			$model->attributes=$_GET['CourseType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CourseType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CourseType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CourseType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionajaxGetCategory(){
        if(isset($_POST["value"]) && $_POST["value"] != ""){  

            $list_model = Category::model()->findAll(array(
                'select'=>'cate_id, cate_title',
                'condition'=>'active="y" AND lang_id="1" AND type_id="'.$_POST['value'].'"',
                'order'=>'cate_title ASC'
            ));   

            ?> <option disabled="" selected="" value="">Select Course Group</option> <?php
            foreach ($list_model as $key => $value) {
                ?> <option value="<?= $value->cate_id ?>"><?= $value->cate_title ?></option> <?php
            }
        }        
    }

}
