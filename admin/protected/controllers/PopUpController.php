<?php

class PopupController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
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
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	// public function accessRules()
	// {
	// 	$model = User::model()->findallByAttributes(array('superuser'=>'1'));
	// 	$user = array();
	// 	foreach ($model as $key => $value) {
	// 		$user[$key]=$value->username;
	// 	}
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
	// 			'users'=>$user,
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
		$model = new Popup;

		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;


		if($model->lang_id == 2){
			$model_parent = Popup::model()->findByPk($model->parent_id);
			$model->start_date = $model_parent->start_date;
			$model->end_date = $model_parent->end_date;
		}

		if(isset($_POST['Popup']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Popup'];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

			// $pic_file = CUploadedFile::getInstance($model, 'pic_file');

			// if(!empty($pic_file)){
			// 	$fileNamePicture = $time."_Picture.".$pic_file->getExtensionName();
			// 	$model->pic_file = $fileNamePicture;
			// }
			if($model->validate())
			{
				$model->start_date = Yii::app()->dateFormatter->format("y-M-d",$model->start_date);
				$model->end_date = Yii::app()->dateFormatter->format("y-M-d",$model->end_date);
				if($model->save())
					$findid = Popup::model()->findbyattributes(array('name'=>$_POST['Popup'][name]));
				$model->sortOrder=$findid->id;
				$model->save(false);
				{
					// if(isset($pic_file))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_file);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_file);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_file);
			  //           // Save the original resource to disk
					// 	$pic_file->saveAs($originalPath);
					// 	$size = getimagesize($originalPath);
			  //           //if ($size[0] == 900 && $size[1] == 500) {
					// 	if (isset($size)) {
			  //            	// Create a small image
					// 		$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 		$smallImage->resize(110);
					// 		$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 		$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 		$thumbImage->resize(900);
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
						$path = "popup";
						$model_id = $model->id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->id);
							$model->pic_file = $filename;
							$model->save(false);
						}
					}

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->id;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {

							$new = Popup::model()->findByAttributes(array('lang_id'=> $lang->id, 'parent_id'=>$rootId));
							if(!$new){
								$popupRoot = Popup::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มป๊อปอัพ '.$popupRoot->name .',ภาษา '.$lang->language);
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
						}
						$this->redirect(array('admin'));  //'id'=>$model->id
				}
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
		$imageShow = $model->pic_file;
		if(isset($_POST['Popup']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Popup'];

			// $imageOld = $model->pic_file; // Image Old

			// $pic_file = CUploadedFile::getInstance($model, 'pic_file');
			// if(isset($pic_file)){
			// 	$fileNamePicture = $time."_Picture.".$pic_file->getExtensionName();
			// 	$model->pic_file = $fileNamePicture;
			// }

			if($model->validate())
			{
				$model->start_date = Yii::app()->dateFormatter->format("y-M-d",$model->start_date);
				$model->end_date = Yii::app()->dateFormatter->format("y-M-d",$model->end_date);
				if (!isset($pic_file)) {
					$model->pic_file = $imageShow;
				}

				if($model->save(false))
				{

					// if(isset($imageShow) && isset($pic_file))
					// {
					// 	Yii::app()->getDeleteImageYush('Popup',$model->id,$imageShow);
					// }

					// if(isset($pic_file))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 	$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_file);
					// 	$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_file);
					// 	$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_file);
			  //           // Save the original resource to disk
					// 	$pic_file->saveAs($originalPath);
					// 	$size = getimagesize($originalPath);
			  //           //if ($size[0] == 900 && $size[1] == 500) {
					// 	if (isset($size)) {
			  //            	// Create a small image
					// 		$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 		$smallImage->resize(110);
					// 		$smallImage->save($smallPath);

			  //           // Create a thumbnail
					// 		$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 		$thumbImage->resize(900);
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
						$path = "popup";
						$model_id = $model->id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->id);
							$model->pic_file = $filename;
							$model->save();
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
		$model = Popup::model()->findByPk($id);
		$modelChildren = Popup::model()->findAll(array(
			'condition'=>'parent_id=:parent_id',
			'params' => array(':parent_id' => $model->id)
		));
		foreach ($modelChildren as $key => $value) {
			// $value->delete();
			// $value->active = 'n';
			$value->del_status = 1;
			$value->save(false);
		}

		// $model->active = 'n';
		$model->del_status = 1;
		$model->save(false);
		// $this->loadModel($id)->delete();


		if($model->pic_file != '')
			Yii::app()->getDeleteImageYush('Popup',$model->id,$model->pic_file);


		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
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
		$dataProvider=new CActiveDataProvider('Popup',$poviderArray);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionTest()
	{
		var_dump("popUp");exit();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Popup('search');
		$model->unsetAttributes();  // clear any default values
		// $model->active = 'y';
		$model->del_status = 0;
		if(isset($_GET['Popup'])){
			$model->attributes=$_GET['Popup'];
		}

		// echo "<Pre>";print_r($model);exit;
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionActive($id){
    	$model = Popup::model()->findByPk($id);
             $modelChildren = Popup::model()->findAll(array(
            'condition'=>'parent_id=:parent_id',
            'params' => array(':parent_id' => $model->id)
              ));
            foreach ($modelChildren as $key => $value) {
                if($value->active == 'y'){
                    $value->active = 'n';
                    $value->save(false);
                } else {
                    $value->active = 'y';
                    $value->save(false);
                }
            }
    	if($model->active == 'y'){
    		$model->active = 'n';
    		$model->save(false);
    	} else {
    		$model->active = 'y';
    		$model->save(false);
    	}
    	$this->redirect(array('admin','id'=>$model->id));
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
		$model=Popup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='popup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = Popup::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			// for ($i = 0; $i < count($_POST['items']); $i++) {
			// 	$item = Popup::model()->findByPk($_POST['items'][$i]);
			// 	if ($item->sortOrder != $cur_items[$i]->sortOrder) {
			// 		$item->sortOrder = $cur_items[$i]->sortOrder ;
			// 		$item->save(false);
			// 	}
			// }
			foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = Popup::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = Popup::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                  //var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = Popup::model()->findByPk($_POST['items'][$i]);
                        $items->sortOrder = $cur_items[$i]->sortOrder ;
                        $items->save(false);
                        
                    }
                    if ($modellang2->parent_id != null) {
                        $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
                        $modellang2->save(false);   
                    }
                    
                } 
            }
        } 
		}
	}
}
