<?php

class CourseController extends Controller
{
    public function filters() 
    {
        return array(
            'rights',
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
		$model = new Course;

		if(isset($_POST['Course']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Course'];

			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
	        if(!empty($course_picture)){
	            $fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
            	$model->course_picture = $fileNamePicture;
	        }

	        $model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
			$model->course_date = ClassFunction::DateSearch($model->course_date);
			$model->course_book_date = ClassFunction::DateSearch($model->course_book_date);

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($course_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->course_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->course_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->course_picture);
			            // Save the original resource to disk
			            $course_picture->saveAs($originalPath);

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
		$model->course_rector_date = ClassFunction::UpdateDate($model->course_rector_date);
		$model->course_date = ClassFunction::UpdateDate($model->course_date);
		$model->course_book_date = ClassFunction::UpdateDate($model->course_book_date);

		$imageShow = $model->course_picture;
		if(isset($_POST['Course']))	
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Course'];

			$imageOld = $model->course_picture; // Image Old

			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
	        if(!empty($course_picture)){
	            $fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
            	$model->course_picture = $fileNamePicture;
	        }
			
			$model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
			$model->course_date = ClassFunction::DateSearch($model->course_date);
			$model->course_book_date = ClassFunction::DateSearch($model->course_book_date);

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($course_picture))
		        	{
						Yii::app()->getDeleteImageYush('course',$model->id,$imageShow);
		        	}
		        	
					if(isset($course_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
			            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->course_picture);
			            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->course_picture);
			            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->course_picture);
			            // Save the original resource to disk
			            $course_picture->saveAs($originalPath);

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

        if($model->course_picture != '')
        	Yii::app()->getDeleteImageYush('course',$model->id,$model->course_picture);

        $model->course_picture = null;
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
		$model=new Course('search');
		$model->unsetAttributes();
		if(isset($_GET['Course']))
			$model->attributes=$_GET['Course'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Course::model()->coursecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
