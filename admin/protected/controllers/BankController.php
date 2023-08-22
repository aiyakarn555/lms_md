<?php

class BankController extends Controller
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
		$model = new Bank;

		if(isset($_POST['Bank']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Bank'];

			$bank_picture = CUploadedFile::getInstance($model, 'bank_picture');
	        if(!empty($bank_picture)){
	            $fileNamePicture = $time."_Picture.".$bank_picture->getExtensionName();
            	$model->bank_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($bank_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->bank_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->bank_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->bank_picture);
			            // Save the original resource to disk
			            $bank_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(250);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->bank_id));
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
		$imageShow = $model->bank_picture;
		
		if(isset($_POST['Bank']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Bank'];

			$imageOld = $model->bank_picture; // Image Old

			$bank_picture = CUploadedFile::getInstance($model, 'bank_picture');
	        if(!empty($bank_picture)){
	            $fileNamePicture = $time."_Picture.".$bank_picture->getExtensionName();
            	$model->bank_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($bank_picture))
		        	{
						Yii::app()->getDeleteImageYush('bank',$model->id,$imageShow);
		        	}

					if(isset($bank_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->bank_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->bank_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->bank_picture);
			            // Save the original resource to disk
			            $bank_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(250);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->bank_id));
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

        if($model->bank_picture != '')
        	Yii::app()->getDeleteImageYush('bank',$model->id,$model->bank_picture);

        $model->bank_picture = null;
	    $model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
		$model=new Bank('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bank']))
			$model->attributes=$_GET['Bank'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Bank::model()->bankcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bank-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
