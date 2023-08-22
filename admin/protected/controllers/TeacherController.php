<?php

class TeacherController extends Controller
{
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
//            'rights',
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
            	'actions' => array('index', 'view'),
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
    // public function filters() 
    // {
    //     return array(
    //         'rights',
    //     );
    // }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionCreate()
    {
    	$model = new Teacher;

    	if(isset($_POST['Teacher']))
    	{
    		$time = date("dmYHis");
    		$model->attributes=$_POST['Teacher'];

    		$teacher_picture = CUploadedFile::getInstance($model, 'picture');
    		if(!empty($teacher_picture)){
    			$fileNamePicture = $time."_Picture.".$teacher_picture->getExtensionName();
    			$model->teacher_picture = $fileNamePicture;
    		}

    		if($model->validate())
    		{
    			if($model->save())
    			{
    				if(Yii::app()->user->id){
    					Helpers::lib()->getControllerActionId();
    				}
    				if(isset($teacher_picture))
    				{
						/////////// SAVE IMAGE //////////
    					Yush::init($model);
    					$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->teacher_picture);
    					$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->teacher_picture);
    					$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->teacher_picture);
			            // Save the original resource to disk
    					$teacher_picture->saveAs($originalPath);

			            // Create a small image
    					$smallImage = Yii::app()->phpThumb->create($originalPath);
    					$smallImage->resize(110);
    					$smallImage->save($smallPath);

			            // Create a thumbnail
    					$thumbImage = Yii::app()->phpThumb->create($originalPath);
    					$thumbImage->resize(175);
    					$thumbImage->save($thumbPath);
    				}

    				$this->redirect(array('view','id'=>$model->teacher_id));
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
    	$imageShow = $model->teacher_picture;
    	if(isset($_POST['Teacher']))
    	{
    		$time = date("dmYHis");
    		$model->attributes=$_POST['Teacher'];

			$model->teacher_picture  = $imageShow; // Image Old
			$teacher_picture = CUploadedFile::getInstance($model, 'picture');
			if(isset($teacher_picture)){
				$fileNamePicture = $time."_Picture.".$teacher_picture->getExtensionName();
				$model->teacher_picture = $fileNamePicture;
			}
			if($model->validate())
			{
				if($model->save())
				{
					if(isset($imageShow) && isset($teacher_picture))
					{
						Yii::app()->getDeleteImageYush('teacher',$model->id,$imageShow);
					}

					if(isset($teacher_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->teacher_picture);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->teacher_picture);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->teacher_picture);
			            // Save the original resource to disk
						$teacher_picture->saveAs($originalPath);

			            // Create a small image
						$smallImage = Yii::app()->phpThumb->create($originalPath);
						$smallImage->resize(110);
						$smallImage->save($smallPath);

			            // Create a thumbnail
						$thumbImage = Yii::app()->phpThumb->create($originalPath);
						$thumbImage->resize(175);
						$thumbImage->save($thumbPath);
					}
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($model->teacher_id);
					}
					$this->redirect(array('view','id'=>$model->teacher_id));
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

		if($model->teacher_picture != '')
			Yii::app()->getDeleteImageYush('Teacher',$model->id,$model->teacher_picture);

		$model->teacher_picture = null;
		$model->save();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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
		echo true;
	}

	public function actionIndex()
	{
		$model = new Teacher('search');
		$model->unsetAttributes();
		if(isset($_GET['Teacher']))
			$model->attributes = $_GET['Teacher'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Teacher::model()->teachercheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='teacher-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
