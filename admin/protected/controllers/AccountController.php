<?php

class AccountController extends Controller
{
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
                'actions' => array('view'),
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
    
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new Account;

		if(isset($_POST['Account']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Account'];

			$cms_picture = CUploadedFile::getInstance($model, 'cms_picture');
	        if(!empty($cms_picture)){
	            $fileNamePicture = $time."_Picture.".$cms_picture->getExtensionName();
            	$model->cms_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($cms_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->cms_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->cms_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->cms_picture);
			            // Save the original resource to disk
			            $cms_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(240);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->cms_id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$imageShow = $model->cms_picture;
		if(isset($_POST['Account']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Account'];

			$imageOld = $model->cms_picture; // Image Old

			$cms_picture = CUploadedFile::getInstance($model, 'cms_picture');
	        if(isset($cms_picture)){
	            $fileNamePicture = $time."_Picture.".$cms_picture->getExtensionName();
            	$model->cms_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($cms_picture))
		        	{
						Yii::app()->getDeleteImageYush('account',$model->id,$imageShow);
		        	}

					if(isset($cms_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->cms_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->cms_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->cms_picture);
			            // Save the original resource to disk
			            $cms_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(240);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->cms_id));
				}
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

        if($model->cms_picture != '')
        	Yii::app()->getDeleteImageYush('Account',$model->id,$model->cms_picture);

        $model->cms_picture = null;
	    $model->save();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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

	public function actionIndex()
	{
		$model=new Account('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Account::model()->accountcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
