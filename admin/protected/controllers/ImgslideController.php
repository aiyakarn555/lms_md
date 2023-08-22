<?php

class ImgslideController extends Controller
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
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
           // array('allow',  // allow all users to perform 'index' and 'view' actions
           //     'actions' => array('index', 'view','update','delete' ,'create','MultiDelete'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new Imgslide;

		if(isset($_POST['Imgslide']))
		{
			$time = date("dmYHis");
			// $model->imgslide_link=$_POST['Imgslide'][imgslide_link];
			$model->imgslide_detail=$_POST['Imgslide'][imgslide_detail];
			$model->imgslide_title=$_POST['Imgslide'][imgslide_title];
			$model->imgslide_link=$_POST['Imgslide'][imgslide_link];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			// $imgslide_picture = CUploadedFile::getInstance($model, 'imgslide_picture');
			// if(!empty($imgslide_picture)){
			// 	$fileNamePicture = $time."_Picture.".$imgslide_picture->getExtensionName();
			// 	$model->imgslide_picture = $fileNamePicture;
			// }

			if ($_FILES['picture']['tmp_name'] != "") {
				$model->imgslide_picture = $_FILES['picture']['name'];
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					
					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "imgslide";
						$model_id = $model->imgslide_id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->imgslide_id);
							$model->imgslide_picture = $filename;
							$model->save();
						}
					}
				}

				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$imageShow = $model->imgslide_picture;
		if(isset($_POST['Imgslide']))
		{
			$time = date("dmYHis");
			// $model->imgslide_link=$_POST['Imgslide'][imgslide_link];
			$model->imgslide_detail=$_POST['Imgslide'][imgslide_detail];
			$model->imgslide_title=$_POST['Imgslide'][imgslide_title];
			$model->imgslide_link=$_POST['Imgslide'][imgslide_link];
			// $imageOld = $model->imgslide_picture; // Image Old

			// $imgslide_picture = CUploadedFile::getInstance($model, 'imgslide_picture');
			// if(isset($imgslide_picture)){
			// 	$fileNamePicture = $time."_Picture.".$imgslide_picture->getExtensionName();
			// 	$model->imgslide_picture = $fileNamePicture;
			// }

			if ($_FILES['picture']['tmp_name'] != "") {
				$model->imgslide_picture = $_FILES['picture']['name'];
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->imgslide_id);
					}
					// if(isset($imageShow) && isset($imgslide_picture))
					// {
					// 	Yii::app()->getDeleteImageYush('imgslide',$model->id,$imageShow);
					// }
                     
					// if(isset($imgslide_picture))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->imgslide_picture);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->imgslide_picture);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->imgslide_picture);
			  //           // Save the original resource to disk
					// 	$imgslide_picture->saveAs($originalPath);
					// 	$size = getimagesize($originalPath);
			  //           //if ($size[0] == 750 && $size[1] == 416) {
					// 	if (isset($size)) {
			  //           // Create a small image
					// 		$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 		$smallImage->resize(110);
					// 		$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 		$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 		$thumbImage->resize(1985,671);
					// 		$thumbImage->save($thumbPath);
					// 	} 
					// 	else {
					// 		unlink($originalPath);
					// 		$notsave = 1;
					// 		$this->render('create',array(
					// 			'model'=>$model,'notsave'=>$notsave));
					// 	}
					// }
					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "imgslide";
						$model_id = $model->imgslide_id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->imgslide_id);
							$model->imgslide_picture = $filename;
							$model->save();
						}
					}
				}
				$this->redirect(array('index','id'=>$model->imgslide_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';

		$parent = Imgslide::model()->find(array(
			'condition' => 'lang_id=:lang_id AND parent_id=:parent_id',
			'params' => array(':lang_id' => 2,':parent_id'=>$id)
		));

		if($parent){
			$parent->active = 'n';
			$parent->save(false);
		}

		$model->save(false);
		

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
		 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) 
		{
			foreach($_POST['chk'] as $val) 
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionIndex()
	{
		$model=new Imgslide('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';
		if(isset($_GET['Imgslide']))
			$model->attributes=$_GET['Imgslide'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Imgslide::model()->imgslidecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='imgslide-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
