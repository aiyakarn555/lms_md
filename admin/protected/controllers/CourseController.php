<?php

class CourseController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
 
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
		$model = new CourseOnline;

		if(isset($_POST['CourseOnline']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['CourseOnline'];

			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
	        if(!empty($course_picture)){
	            $fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
            	$model->course_picture = $fileNamePicture;
	        }

	        $model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
	        $model->course_book_date = ClassFunction::DateSearch($model->course_book_date);

			if($model->validate())
			{
				if($model->save())
				{
					$model->sortOrder = $model->course_id;
					$model->save();

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
		$model->course_book_date = ClassFunction::UpdateDate($model->course_book_date);

		$imageShow = $model->course_picture;
		if(isset($_POST['CourseOnline']))	
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['CourseOnline'];

			$imageOld = $model->course_picture; // Image Old

			$course_picture = CUploadedFile::getInstance($model, 'course_picture');
	        if(!empty($course_picture)){
	            $fileNamePicture = $time."_Picture.".$course_picture->getExtensionName();
            	$model->course_picture = $fileNamePicture;
	        }
	        
	        $model->course_rector_date = ClassFunction::DateSearch($model->course_rector_date);
	        $model->course_book_date = ClassFunction::DateSearch($model->course_book_date);

			if($model->validate())
			{
				if($model->save())
				{
		        	if(isset($imageShow) && isset($course_picture))
		        	{
						Yii::app()->getDeleteImageYush('courseonline',$model->id,$imageShow);
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
        	Yii::app()->getDeleteImageYush('courseonline',$model->id,$model->course_picture);

        $model->course_picture = null;
	    $model->save();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		header('Content-type: application/json');
		if(isset($_POST['chk'])) {
	        foreach($_POST['chk'] as $val) {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex()
	{
		$model=new CourseOnline('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseOnline']))
			$model->attributes=$_GET['CourseOnline'];

		//var_dump($model->dbCriteria);
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionPrintPDF($id,$user)
	{
	    $CheckPasscours = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $id,
				':user' => $user
			)
	    ));
		if(isset($CheckPasscours))
		{
	        $mPDF1 = Yii::app()->ePdf->mpdf();
	        $mPDF1->setDisplayMode('fullpage');
	        $mPDF1->setAutoFont();
	        $mPDF1->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
	        $mPDF1->Output();
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function loadModel($id)
	{
		$model=CourseOnline::model()->courseonlinecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = Course::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = Course::model()->findByPk($_POST['items'][$i]);
//				echo $item->sortOrder." = ".$cur_items[$i]->sortOrder."<br>";
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

}
