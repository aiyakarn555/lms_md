<?php

class SignatureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
            	'actions' => array('index', 'view','active','delimg'),
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
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
		}*/

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
		$model=new Signature;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Signature']))
		{
			$model->attributes=$_POST['Signature'];
			$sign_picture = Slim::getImages('sign_path');
			$path = Yii::app()->basePath."/../../uploads/signature/";
			if ($sign_picture) {
				$model->sign_path = Helpers::lib()->uploadImage($sign_picture,$path);
				$image = Yii::app()->phpThumb->create($path.$model->sign_path);    
				// $image->resize(145, 145);
				$image->resize(125, 125);    
				$image->save($path.$model->sign_path);
			}
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionActive($id = null){

		if($id == null){
			$id = $_POST['id'];
		}
		$model = Signature::model()->findByPk($id);
		if($model->sign_hide == 1){
			$model->sign_hide = 0;
			$model->save(false);
		} else {
			$model->sign_hide = 1;
			$model->save(false);
		}
		// $this->redirect(array('/Signature/index'));
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
		$imageShow = $model->sign_path;
		
		if(isset($_POST['sign_path']))
		{
			$model->attributes=$_POST['sign_path'];
			$sign_picture = Slim::getImages('sign_path');
			$path = Yii::app()->basePath."/../../uploads/signature/";
			if ($sign_picture == false) {
				$model->sign_path = $imageShow;
			}else{
				if(@unlink($path.$imageShow)){
					// echo "delete";
				}else{
					// echo "error";
				}
				
				$model->sign_path = Helpers::lib()->uploadImage($sign_picture,$path);
				$image = Yii::app()->phpThumb->create($path.$model->sign_path);    
				//$image->resize(145, 145);
				$image->resize(125, 125);    
				$image->save($path.$model->sign_path);
			}
			
		}
		if(isset($_POST['Signature'])){
			
			$model->attributes=$_POST['Signature'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->sign_id);
				}
				$this->redirect(array('view','id'=>$model->sign_id));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        // Page
		$model = new Signature('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Signature']))
        	$model->attributes=$_GET['Signature'];

        $this->render('index',array(
        	'model'=>$model,
        ));
    }

	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Signature the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		// $model = Signature::model()->signaturecheck()->findByPk($id);
		$model = Signature::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionDelete($id)
	{
        //$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		if($model->sign_path != ''){
			$path = Yii::app()->basePath . "/../../uploads/signature/";
			@unlink($path . $model->sign_path);
			$model->sign_path = null;
		}
		// $model->update();
		$model->save();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	}

	public function actionMultiDelete()
	{
		header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionDelImg()
	{
		$id = $_POST['id'];
		$model = Signature::model()->findByPk($id);
		if(!empty($model)){
			$path = Yii::app()->basePath . "/../../uploads/signature/";
			@unlink($path . $model->sign_path);
			$model->sign_path = null;
			$model->update();
		}
		echo true;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Signature $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='signature-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
