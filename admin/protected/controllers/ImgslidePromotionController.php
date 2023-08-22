<?php

class ImgslidePromotionController extends Controller
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
		$model=new ImgslidePromotion;

		if(isset($_POST['ImgslidePromotion']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['ImgslidePromotion'];

			$imgslide_picture = CUploadedFile::getInstance($model, 'imgslide_picture');
	        if(!empty($imgslide_picture)){
	            $fileNamePicture = $time."_Picture.".$imgslide_picture->getExtensionName();
            	$model->imgslide_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($imgslide_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->imgslide_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->imgslide_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->imgslide_picture);
			            // Save the original resource to disk
			            $imgslide_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(730);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->imgslide_id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$imageShow = $model->imgslide_picture;

		if(isset($_POST['ImgslidePromotion']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['ImgslidePromotion'];

			$imageOld = $model->imgslide_picture; // Image Old

			$imgslide_picture = CUploadedFile::getInstance($model, 'imgslide_picture');
	        if(isset($imgslide_picture)){
	            $fileNamePicture = $time."_Picture.".$imgslide_picture->getExtensionName();
            	$model->imgslide_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($imgslide_picture))
		        	{
						Yii::app()->getDeleteImageYush('imgslidepromotion',$model->id,$imageShow);
		        	}

					if(isset($imgslide_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->imgslide_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->imgslide_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->imgslide_picture);
			            // Save the original resource to disk
			            $imgslide_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(730);
			            $thumbImage->save($thumbPath);
					}
		        	
					$this->redirect(array('view','id'=>$model->imgslide_id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,'imageShow'=>$imageShow
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->active = 'n';

        if($model->imgslide_picture != '')
        	Yii::app()->getDeleteImageYush('imgslidepromotion',$model->id,$model->imgslide_picture);

        $model->imgslide_picture = null;
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
		$model=new ImgslidePromotion('search');
		$model->unsetAttributes();
		if(isset($_GET['ImgslidePromotion']))
			$model->attributes=$_GET['ImgslidePromotion'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=ImgslidePromotion::model()->imgslidepromotioncheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='imgslide-promotion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
