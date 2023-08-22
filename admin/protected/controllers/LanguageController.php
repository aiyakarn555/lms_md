<?php

class LanguageController extends Controller
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
		$model = new Language;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Language']))
		{
			// $image = CUploadedFile::getInstance($model, 'image');
			$model->attributes=$_POST['Language'];
			$time = date("dmYHis");

			// if(!empty($image)){
			// 	$fileNamePicture = $time."_lang.".$image->getExtensionName();
			// 	$model->image = $fileNamePicture;
			// }

			

			if($model->save()){

				// if(isset($image))
				// {
				// 		/////////// SAVE IMAGE //////////
				// 	Yush::init($model);
				// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->image);
				// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->image);
				// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->image);
			 //            // Save the original resource to disk
				// 	$image->saveAs($originalPath);

			 //            // Create a small image
				// 	$smallImage = Yii::app()->phpThumb->create($originalPath);
				// 	$smallImage->resize(30);
				// 	$smallImage->save($smallPath);

			 //            // Create a thumbnail
				// 	$thumbImage = Yii::app()->phpThumb->create($originalPath);
				// 	$thumbImage->resize(128);
				// 	$thumbImage->save($thumbPath);
				// }
				
				if ($_FILES['picture']['tmp_name'] != "") {
					$tempFile   = $_FILES['picture'];
					$path = "language";
					$model_id = $model->id;
					$base64_pic = $_POST["url_pro_pic"];
					$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
					if ($filename) {
						$model = $this->loadModel($model->id);
						$model->image = $filename;
						$model->save();
					}
				}


				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('admin','id'=>$model->id));
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
		$imageShow = $model->image;
		if(isset($_POST['Language']))
		{
			// $image = CUploadedFile::getInstance($model, 'image');
			$model->attributes=$_POST['Language'];
			$time = date("dmYHis");
			// if(!empty($image)){
			// 	$fileNamePicture = $time."_lang.".$image->getExtensionName();
			// 	$model->image = $fileNamePicture;
			// } else {
			// 	$model->image = $model->imageShow;
			// }
			
			if($model->save()){
				// if(isset($image))
				// {
				// 		/////////// SAVE IMAGE //////////
				// 	Yush::init($model);
				// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->image);
				// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->image);
				// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->image);
			 //            // Save the original resource to disk
				// 	$image->saveAs($originalPath);

			 //            // Create a small image
				// 	$smallImage = Yii::app()->phpThumb->create($originalPath);
				// 	$smallImage->resize(30);
				// 	$smallImage->save($smallPath);

			 //            // Create a thumbnail
				// 	$thumbImage = Yii::app()->phpThumb->create($originalPath);
				// 	$thumbImage->resize(128);
				// 	$thumbImage->save($thumbPath);
				// }

				if ($_FILES['picture']['tmp_name'] != "") {
					$tempFile   = $_FILES['picture'];
					$path = "language";
					$model_id = $model->id;
					$base64_pic = $_POST["url_pro_pic"];
					$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
					if ($filename) {
						$model = $this->loadModel($model->id);
						$model->image = $filename;
						$model->save();
					}
				}

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('admin','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow,
			
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
		// $dataProvider=new CActiveDataProvider('Language');
		$dataProvider=new CActiveDataProvider('Language' ,array('criteria'=>array(
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
		$model=new Language('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Language']))
			$model->attributes=$_GET['Language'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Language the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Language::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Language $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Language-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
