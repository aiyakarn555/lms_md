<?php

class GalleryController extends Controller
{
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
           // 	'actions' => array('index', 'view','update','delete' ,'create'),
           // 	'users' => array('*'),
           // ),
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

		$model = new Gallery;

		if(isset($_POST['Gallery'])){
           		 $type_id = $_POST['Gallery'][gallery_type_id];

				if(isset($_FILES['files']['tmp_name'])){

				foreach ($_FILES['files']['tmp_name'] as $key => $value) {
				   if($_FILES['files']['tmp_name'][$key] != ""){
				    $uploadDir = Yii::app()->getUploadPath(null);

				    if (!is_dir($uploadDir."../gallery/")) {
				     mkdir($uploadDir."../gallery/", 0777, true);
				    }
				    if (!is_dir($uploadDir."../gallery/"."images")) {
				     mkdir($uploadDir."../gallery/"."images", 0777, true);
				    }else{     
				     rmdir($uploadDir."../gallery/"."images");
				    }

					 $uploadDir = $uploadDir."..\\gallery\\"."images"."\\";

				     $tempFile   = $_FILES['files']['tmp_name'][$key];
				     $fileParts = pathinfo($_FILES['files']['name'][$key]);
				     $fileType = strtolower($fileParts['extension']);

 					 $file_name_original = $_FILES['files']['name'][$key];
				     $namepath = "gallery_".$type_id."_";
				     $rnd = rand(0,9999999999);
				     $fileName = $namepath."{$rnd}-{$session['idx']}".$file_name_original;
	
				     $targetFile = $uploadDir.$fileName;
				     move_uploaded_file($tempFile, $targetFile);

					  $ProAttachFile = new Gallery;
					  $ProAttachFile->image = $fileName;
				      $ProAttachFile->gallery_type_id = $type_id;
				      $ProAttachFile->save();

				  } // close if
				} // close foreach
				$this->redirect('index');
		    } //close (isset($_FILES['files']['tmp_name']))
		}// close isset($_POST['Gallery'])

		$this->render('create',array(
			'model'=>$model
		));
	} // close function

	public function actionUpdate($id)
	{

		$model = $this->loadModel($id);
		$imageShow = $model->image;

		if(isset($_POST['Gallery']))
		{
			$type_id = $_POST['Gallery'][gallery_type_id];
			$uploadDir = Yii::app()->getUploadPath(null);
			$checkEmpty = $_FILES['files']['tmp_name'];

			if(isset($_FILES['files']['tmp_name'])){

							if($type_id == $model->gallery_type_id){ //typeเก่า รูปใหม่

									//delete image old
									$imageOld = $model->image; // Image Old
								    $files = glob($uploadDir."../gallery/images/".$imageOld);
								     foreach($files as $file){ // iterate files
								      if(is_file($file)){
								        unlink($file); // delete file
								        $model->delete();
								       }       
							      	}

							      	foreach ($_FILES['files']['tmp_name'] as $key => $value) {
										   if($_FILES['files']['tmp_name'][$key] != ""){
										    $uploadDir = Yii::app()->getUploadPath(null);

										   if (!is_dir($uploadDir."../gallery/")) {
										     mkdir($uploadDir."../gallery/", 0777, true);
										    }
										    if (!is_dir($uploadDir."../gallery/"."images")) {
										     mkdir($uploadDir."../gallery/"."images", 0777, true);
										    }else{     
										     rmdir($uploadDir."../gallery/"."images");
										    }

											 $uploadDir = $uploadDir."..\\gallery\\"."images"."\\";

										     $tempFile   = $_FILES['files']['tmp_name'][$key];
										     $fileParts = pathinfo($_FILES['files']['name'][$key]);
										     $fileType = strtolower($fileParts['extension']);

						 					 $file_name_original = $_FILES['files']['name'][$key];
										     $namepath = "gallery_".$type_id."_";
										     $rnd = rand(0,9999999999);
										     $fileName = $namepath."{$rnd}-{$session['idx']}".$file_name_original;
							
										     $targetFile = $uploadDir.$fileName;
										     move_uploaded_file($tempFile, $targetFile);

											  $ProAttachFile = new Gallery;
											  $ProAttachFile->image = $fileName;
										      $ProAttachFile->gallery_type_id = $type_id;
										      $ProAttachFile->save();
										}
									}
							}else if($type_id != $model->gallery_type_id && $checkEmpty[0] == ""){ //typeใหม่ รูปเก่า
										$model->gallery_type_id = $type_id;
										$model->update();

							}else if($type_id != $model->gallery_type_id && $checkEmpty[0] != ""){ //typeใหม่ รูปใหม่

									//delete image old
									$imageOld = $model->image; // Image Old
								    $files = glob($uploadDir."../gallery/images/".$imageOld);
								     foreach($files as $file){ // iterate files
								      if(is_file($file)){
								        unlink($file); // delete file
								        $model->delete();
								       }       
							      	}

									foreach ($_FILES['files']['tmp_name'] as $key => $value) {
										   if($_FILES['files']['tmp_name'][$key] != ""){
										    $uploadDir = Yii::app()->getUploadPath(null);

										    if (!is_dir($uploadDir."../gallery/")) {
										     mkdir($uploadDir."../gallery/", 0777, true);
										    }
										    if (!is_dir($uploadDir."../gallery/"."images")) {
										     mkdir($uploadDir."../gallery/"."images", 0777, true);
										    }else{     
										     rmdir($uploadDir."../gallery/"."images");
										    }

											 $uploadDir = $uploadDir."..\\gallery\\"."images"."\\";

										     $tempFile   = $_FILES['files']['tmp_name'][$key];
										     $fileParts = pathinfo($_FILES['files']['name'][$key]);
										     $fileType = strtolower($fileParts['extension']);

						 					 $file_name_original = $_FILES['files']['name'][$key];
										     $namepath = "gallery_".$type_id."_";
										     $rnd = rand(0,9999999999);
										     $fileName = $namepath."{$rnd}-{$session['idx']}".$file_name_original;
							
										     $targetFile = $uploadDir.$fileName;
										     move_uploaded_file($tempFile, $targetFile);

											  $ProAttachFile = new Gallery;
											  $ProAttachFile->image = $fileName;
										      $ProAttachFile->gallery_type_id = $type_id;
										      $ProAttachFile->save();

										  } // close if
										} // close foreach
							}

				$this->redirect('../index');

			}//close if(isset($_FILES['files']['tmp_name'])){

		}//close if(isset($_POST['Gallery']))

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
		));
	}// close function


	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save();
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

		// var_dum(Yii::app()->basePath . '../';);exit();

		$model=new Gallery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Gallery::model()->gallerycheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
