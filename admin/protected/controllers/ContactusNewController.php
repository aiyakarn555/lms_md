<?php

class ContactusNewController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	
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
		// $model = User::model()->findallByAttributes(array('superuser'=>'1'));
		// $user = array();
		// foreach ($model as $key => $value) {
		// 	$user[$key]=$value->username;
		// }
		$access = array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('view','index', 'update','sequence'),
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
     
		return $access;
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
		$model = new ContactusNew;

		if(isset($_POST['ContactusNew']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['ContactusNew'];
			// $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			// $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			//  $con_image = CUploadedFile::getInstance($model, 'con_image');

			// if(!empty($con_image)){
			// 	$fileNamePicture = $time."_Picture.".$con_image->getExtensionName();
			// 	$model->con_image = $fileNamePicture;
			// }
			if ($_FILES['picture']['tmp_name'] != "") {
				$model->con_image = $_FILES['picture']['name'];
			}
			 if($model->validate())
			 {
				if($model->save()){
				$model->sortOrder=$model->id;
				$model->save(false);
					// if(isset($con_image))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->con_image);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->con_image);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->con_image);
			  //           // Save the original resource to disk
					// 	$con_image->saveAs($originalPath);
					// 	$size = getimagesize($originalPath);
			  //           //if ($size[0] == 900 && $size[1] == 500) {
					// 	if (isset($size)) {
			  //            	// Create a small image
					// 		$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 		$smallImage->resize(110);
					// 		$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 		$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 		$thumbImage->resize(266);
					// 		$thumbImage->save($thumbPath);
					// 	} else {
					// 		unlink($originalPath);
					// 		$model->delete();
					// 		$notsave = 1;
					// 		$this->render('create',array(
					// 			'model'=>$model,'notsave'=>$notsave));
					// 	}
					// }

					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "contactusnew";
						$model_id = $model->id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->id);
							$model->con_image = $filename;
							$model->save(false);
						}
					}
			 }
		}
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
		$imageShow = $model->con_image;
		if(isset($_POST['ContactusNew']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['ContactusNew'];

			// $imageOld = $model->pic_file; // Image Old

			// $con_image = CUploadedFile::getInstance($model, 'con_image');
			// if(isset($con_image)){
			// 	$fileNamePicture = $time."_Picture.".$con_image->getExtensionName();
			// 	$model->con_image = $fileNamePicture;
			// }
			if ($_FILES['picture']['tmp_name'] != "") {
				$model->con_image = $_FILES['picture']['name'];
			}
			if($model->validate())
			{
				// if (!isset($con_image)) {
				// 	$model->con_image = $imageShow;
				// }

				if($model->save(false))
				{

					// if(isset($con_image))
					// {
					// 	// Yii::app()->deleteImage('ContactusNew',$model->id);
					// 	$uploadDir = Yii::app()->getUploadPath(null);
					// $fileold = glob($uploadDir."".$model->id);

					// 	foreach($fileold as $file){
				 //              if(is_file($file)){
				 //                  unlink($file); // delete file
				 //                }             
				 //              }
					// }

					// if(isset($con_image))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->con_image);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->con_image);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->con_image);
			  //           // Save the original resource to disk
					// 	$con_image->saveAs($originalPath);
					// 	$size = getimagesize($originalPath);
			  //           //if ($size[0] == 900 && $size[1] == 500) {
					// 	if (isset($size)) {
			  //            	// Create a small image
					// 		$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 		$smallImage->resize(110);
					// 		$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 		$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 		$thumbImage->resize(266);
					// 		$thumbImage->save($thumbPath);
					// 	} else {
					// 		unlink($originalPath);
					// 		$notsave = 1;
					// 		$this->render('create',array(
					// 			'model'=>$model,'notsave'=>$notsave));
					// 	}
					// }

					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "contactusnew";
						$model_id = $model->id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->id);
							$model->con_image = $filename;
							$model->save(false);
						}
					}

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}

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
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		// $model = ContactusNew::model()->findByPk($id);
  //            $modelChildren = Popup::model()->findAll(array(
  //           'condition'=>'parent_id=:parent_id',
  //           'params' => array(':parent_id' => $model->id)
  //             ));
  //           foreach ($modelChildren as $key => $value) {
  //           	$value->delete();
                // if($value->active == 'y'){
                //     $value->active = 'n';
                //     $value->save(false);
                // } else {
                //     $value->active = 'y';
                //     $value->save(false);
                // }
           // }
    	// if($model->active == 'y'){
    	// 	$model->active = 'n';
    	// 	$model->save(false);
    	// } else {
    	// 	$model->active = 'y';
    	// 	$model->save(false);
    	// }

		// if($model->pic_file != '')
		// 	Yii::app()->getDeleteImageYush('ContactusNew',$model->id,$model->pic_file);

		// $model->pic_file = null;
		 $model->save(false);

		// if(Yii::app()->user->id){
		// 	Helpers::lib()->getControllerActionId();
		// }


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	// public function actionIndex()
	// {
	// 	$dataProvider=new CActiveDataProvider('Popup',$poviderArray);
	// 	$this->render('index',array(
	// 		'dataProvider'=>$dataProvider,
	// 	));
	// }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ContactusNew('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContactusNew'])){
			$model->attributes=$_GET['ContactusNew'];
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Popup the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ContactusNew::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Popup $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contactusNew-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = ContactusNew::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = ContactusNew::model()->findByPk($_POST['items'][$i]);

				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save(false);
					echo "ok";
                }else{
                	echo "no";
                } 
			}

// 			foreach ($cur_items as $keys => $values) {

//             for ($i = 0; $i < count($_POST['items']); $i++) {
//                 $item = ContactusNew::model()->findByPk($_POST['items'][$i]);

//                 if ($item->sortOrder != $cur_items[$i]->sortOrder) {
//                     $item->sortOrder = $cur_items[$i]->sortOrder ;
//                     $item->save(false);
//                     echo "ok";
//                 }else{
//                 	echo "no";
//                 } 
// exit();
//                 // $modellang2 = ContactusNew::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
//                 //   //var_dump($modellang2->sortOrder);exit();
                
//                 // if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
//                 //     if ($modellang2->parent_id == '') {
//                 //         $items = ContactusNew::model()->findByPk($_POST['items'][$i]);
//                 //         $items->sortOrder = $cur_items[$i]->sortOrder ;
//                 //         $items->save(false);
                        
//                 //     }
//                 //     if ($modellang2->parent_id != null) {
//                 //         $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
//                 //         $modellang2->save(false);   
//                 //     }
                    
//                 // } 
//             }
//         } 
		}
	}
}
