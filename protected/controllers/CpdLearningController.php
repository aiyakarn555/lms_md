<?php

class CpdLearningController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	// public $layout='//layouts/column2';

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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','cpddelete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
		$model=new CpdLearning;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['CpdLearning']))
		{
			if(isset($_POST['User']))
				{
					$user= User::model()->findByPk(Yii::app()->user->id);
					$user->attributes=$_POST['User'];
					$user->save();
					// $register = new RegistrationForm;
					$register = RegistrationForm::model()->findByPk(Yii::app()->user->id);
					$regs_pic = new RegistrationForm;
					$regs_pic->id = $register->id;
				}
			$model->attributes=$_POST['CpdLearning'];
			$pic = CUploadedFile::getInstance($model,'pic_file');
			if(isset($pic)) {
				$uglyName = strtolower($pic->name);
	            $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
	            $beautifulName = trim($mediocreName, '_') . "." . $pic->extensionName;
	            $register->pic_cardid = $beautifulName;
	            // $register->save(false);

		  //       $model->user_id = Yii::app()->user->id;
				// $model->create_date = date('Y-m-d H:i:s');
			
				if($register->save(false)){
					if(isset($pic))
					{
						Yush::init($regs_pic);
						$originalPath = Yush::getPath($regs_pic, Yush::SIZE_ORIGINAL, $register->pic_cardid);
						$thumbPath = Yush::getPath($regs_pic, Yush::SIZE_THUMB, $register->pic_cardid);
						$smallPath = Yush::getPath($regs_pic, Yush::SIZE_SMALL, $register->pic_cardid);
						// Save the original resource to disk
						$pic->saveAs($originalPath);

						// Create a small image
						$smallImage = Yii::app()->phpThumb->create($originalPath);
						$smallImage->resize(385, 220);
						$smallImage->save($smallPath);

						// Create a thumbnail
						$thumbImage = Yii::app()->phpThumb->create($originalPath);
						$thumbImage->resize(350, 200);
						$thumbImage->save($thumbPath);

					}
					Yii::app()->user->setFlash('cpd','ยืนยันสำเร็จ');
	                Yii::app()->user->setFlash('messages','ยืนยันบัตรประชาชนสำเร็จ');
	                if(!$model->course_id){
		            	$this->redirect(array('/category/index'));
		            }
					$this->redirect(array('/course/detail','id'=>$model->course_id));
				}
			} 
			Yii::app()->user->setFlash('cpderror','ยืนยันไม่สำเร็จ');
            Yii::app()->user->setFlash('messages','ยืนยันบัตรประชาชนไม่สำเร็จ');
            $course = CourseOnline::model()->findByPK($model->course_id);
            // $this->refresh();
			$this->redirect(array('/course/index','id'=>$course->cate_id));				
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CpdLearning']))
		{
			$model->attributes=$_POST['CpdLearning'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
        // we only allow deletion via POST request
        $this->loadModel($id)->delete();
	}

	public function actionCpddelete($id){
		// $cpd = CpdLearning::model()->findByPk($id);
		// $course_id = $cpd->course_id;
		// $course = CourseOnline::model()->findByPk($course_id);
		// $cate_id = $course->cate_id;
		// $cpd->update_date = date('Y-m-d H:i:s');
		// $cpd->active = 0;
		$register = RegistrationForm::model()->findByPk(Yii::app()->user->id);
		$register->pic_cardid = null;
	    // $register->save();
		if($register->save()){
			Yii::app()->user->setFlash('cpddelete','ล้างข้อมูลสำเร็จ');
	        Yii::app()->user->setFlash('messages','ล้างข้อมูลสำเร็จ กรุณาบันทึกข้อมูลใหม่');
    	} else {
    		Yii::app()->user->setFlash('cpddeleteerror','ล้างข้อมูลไม่สำเร็จ');
        	Yii::app()->user->setFlash('messages','ล้างข้อมูลไม่สำเร็จ กรุณาทำรายการใหม่หรือติดต่อผู้ดูแล');
    	}
		$this->redirect(array('//course/index',
			'id'=>$id
        ));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CpdLearning');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id)
	{
		$model=new CpdLearning('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CpdLearning']))
			$model->attributes=$_GET['CpdLearning'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CpdLearning the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CpdLearning::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CpdLearning $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cpd-learning-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
