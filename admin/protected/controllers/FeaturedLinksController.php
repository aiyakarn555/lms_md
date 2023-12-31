<?php

class FeaturedLinksController extends Controller
{
	public function filters() 
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete',
            // 'rights',
        );
	}

	public function accessRules()
	{
		return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','Sequence'),
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
		$model=new FeaturedLinks;

		if(isset($_POST['FeaturedLinks']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['FeaturedLinks'];

			$link_image = CUploadedFile::getInstance($model, 'link_image');

			if(!empty($link_image)){
				$fileNamePicture = $time."_Picture.".$link_image->getExtensionName();
				$model->link_image = $fileNamePicture;
			}


			if($model->validate())
			{
				if($model->save())
				{
					if(isset($link_image))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->link_image);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->link_image);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->link_image);
			            // Save the original resource to disk
						$link_image->saveAs($originalPath);
						$size = getimagesize($originalPath);
			            // if ($size[0] == 205 && $size[1] == 82) {
			            // Create a small image
						$smallImage = Yii::app()->phpThumb->create($originalPath);
						$smallImage->resize(110);
						$smallImage->save($smallPath);

			            // Create a thumbnail
						$thumbImage = Yii::app()->phpThumb->create($originalPath);
						$thumbImage->resize(205,82);
						$thumbImage->save($thumbPath);

			    //         } else {
			    //          	unlink($originalPath);
			    //          	$model->delete();
			    //          	$notsave = 1;
			    //          	$this->render('create',array(
							// 'model'=>$model,'notsave'=>$notsave));
			    //          }
					}
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
				}
				$this->redirect(array('admin','id'=>$model->link_id));
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

		$imageShow = $model->link_image;
		if(isset($_POST['FeaturedLinks']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['FeaturedLinks'];

			$imageOld = $model->link_image; // Image Old

			$link_image = CUploadedFile::getInstance($model, 'link_image');
			if(isset($link_image)){
				$fileNamePicture = $time."_Picture.".$link_image->getExtensionName();
				$model->link_image = $fileNamePicture;
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($imageShow) && isset($link_image))
					{
						Yii::app()->getDeleteImageYush('FeaturedLinks',$model->id,$imageShow);
					}

					if(isset($link_image))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->link_image);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->link_image);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->link_image);
			            // Save the original resource to disk
						$link_image->saveAs($originalPath);
						$size = getimagesize($originalPath);
						if ($size[0] == 205 && $size[1] == 82) {
			            // Create a small image
							$smallImage = Yii::app()->phpThumb->create($originalPath);
							$smallImage->resize(110);
							$smallImage->save($smallPath);

			            // Create a thumbnail
							$thumbImage = Yii::app()->phpThumb->create($originalPath);
							$thumbImage->resize(203,82);
							$thumbImage->save($thumbPath);
						} else {
							unlink($originalPath);
							$notsave = 1;
							$this->render('create',array(
								'model'=>$model,'notsave'=>$notsave));
						}
					}
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->link_id);
					}
				}

				$this->redirect(array('admin','id'=>$model->link_id));
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
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 0;

		if($model->link_image != '')
			Yii::app()->getDeleteImageYush('Popup',$model->id,$model->link_image);

		$model->link_image = null;
		$model->save(false);
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
		$dataProvider=new CActiveDataProvider('FeaturedLinks');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FeaturedLinks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FeaturedLinks']))
			$model->attributes=$_GET['FeaturedLinks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FeaturedLinks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FeaturedLinks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FeaturedLinks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='featured-links-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
