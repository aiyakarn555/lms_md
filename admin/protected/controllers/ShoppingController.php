<?php

class ShoppingController extends Controller
{
    public function filters() 
    {
        return array(
            'rights- toggle, switch, qtoggle',
        );
    }

	public function actions()
	{
	    return array(
            'toggle'=>'ext.jtogglecolumn.ToggleAction',
            'switch'=>'ext.jtogglecolumn.SwitchAction',
            'qtoggle'=>'ext.jtogglecolumn.QtoggleAction',
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
		$model = new Shopping;

		if(isset($_POST['Shopping']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Shopping'];

			$shop_picture = CUploadedFile::getInstance($model, 'shop_picture');
	        if(!empty($shop_picture)){
	            $fileNamePicture = $time."_Picture.".$shop_picture->getExtensionName();
            	$model->shop_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($shop_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->shop_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->shop_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->shop_picture);
			            // Save the original resource to disk
			            $shop_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(250);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->id));
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
		$imageShow = $model->shop_picture;
		if(isset($_POST['Shopping']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Shopping'];

			$imageOld = $model->shop_picture; // Image Old

			$shop_picture = CUploadedFile::getInstance($model, 'shop_picture');
	        if(!empty($shop_picture)){
	            $fileNamePicture = $time."_Picture.".$shop_picture->getExtensionName();
            	$model->shop_picture = $fileNamePicture;
	        }

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($shop_picture))
		        	{
						Yii::app()->getDeleteImageYush('Shopping',$model->id,$imageShow);
		        	}
		        	
					if(isset($shop_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->shop_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->shop_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->shop_picture);
			            // Save the original resource to disk
			            $shop_picture->saveAs($originalPath);

			            // Create a small image
			            $smallImage = Yii::app()->phpThumb->create($originalPath);
			            $smallImage->resize(110);
			            $smallImage->save($smallPath);

			            // Create a thumbnail
			            $thumbImage = Yii::app()->phpThumb->create($originalPath);
			            $thumbImage->resize(250);
			            $thumbImage->save($thumbPath);
					}

					$this->redirect(array('view','id'=>$model->id));
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
	    
        if($model->shop_picture != '')
        	Yii::app()->getDeleteImageYush('Shopping',$model->id,$model->shop_picture);

        $model->shop_picture = null;
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
		$model=new Shopping('search');
		$model->unsetAttributes();
		if(isset($_GET['Shopping']))
			$model->attributes=$_GET['Shopping'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Shopping::model()->shoppingcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shopping-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
