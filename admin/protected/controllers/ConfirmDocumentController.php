<?php

class ConfirmDocumentController extends Controller
{
	public function init()
	{
		if(Yii::app()->user->id == null){
			$this->redirect(array('site/index'));
		}
		parent::init();
		if (isset($_GET['lang_id']) || isset($_GET['parent_id']) ) {

			$langId = $_GET['lang_id'];
			if($langId != 1){
			$lang = Language::model()->findByPk($langId);
			$parentId = $_GET['parent_id'];
			$Root = CourseOnline::model()->findByAttributes(array('course_id'=> $parentId,'active'=>'y'));
			$cateRoot = Category::model()->findByAttributes(array('parent_id'=> $Root->cate_id,'lang_id'=>$langId,'active'=>'y'));
			$cateMain = Category::model()->findByAttributes(array('cate_id'=> $Root->cate_id,'active'=>'y'));
			if(!$cateRoot){
				Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหมวดหมู่'.$cateMain->cate_title .',ภาษา '.$lang->language);
				$this->redirect(array('Category/index'));
				exit();
			}
			}
		}
		$this->lastactivity();
	}

	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
			// 'rights- toggle, switch, qtoggle',
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
            	'actions' => array('index', 'view','edit_teacher','MultiDelete','save_categories','update','delete','create', 'Formcourse'),
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

    public function actions()
    {
    	return array(
    		'toggle'=>'ext.jtogglecolumn.ToggleAction',
    		'switch'=>'ext.jtogglecolumn.SwitchAction',
    		'qtoggle'=>'ext.jtogglecolumn.QtoggleAction',
    	);
    }

    public function actionCourseTemp()
    {

    	$model=new CourseTemp('search_document');
        $model->unsetAttributes();  

        if(isset($_GET['CourseTemp']))
        	$model->attributes=$_GET['CourseTemp'];
			$model->courseTi=$_GET['CourseTemp']['courseTi'];
			$model->fullname=$_GET['CourseTemp']['fullname'];
			

    	$this->render('course_temp',array(
    		'model'=>$model
    	));

    }

    public function actionMsteamsTemp()
    {

    	$model=new MsteamsTemp('search_document');
        $model->unsetAttributes();  

        if(isset($_GET['MsteamsTemp']))
        	$model->attributes=$_GET['MsteamsTemp'];
			$model->courseTi=$_GET['MsteamsTemp']['courseTi'];
			$model->fullname=$_GET['MsteamsTemp']['fullname'];
			

    	$this->render('ms_teams_temp',array(
    		'model'=>$model
    	));

    }

    public function actionLockDocumentCourse($id=null){
		if($id == null){
			$id = $_POST['id'];
		}
    	$model=CourseTemp::model()->findByPk($id);
    	if($model){
    		if($model->lock_document == 'n'){
    			$model->lock_document = 'y';	
    		}else{
    			$model->lock_document = 'n';	
    		}
    		$model->save();

    	}
    	$this->redirect(array('/ConfirmDocument/CourseTemp'));
    }

    public function actionLockDocumentMsteams($id=null){
		if($id == null){
			$id = $_POST['id'];
		}
    	$model=MsteamsTemp::model()->findByPk($id);
    	if($model){
    		if($model->lock_document == 'n'){
    			$model->lock_document = 'y';	
    		}else{
    			$model->lock_document = 'n';	
    		}
    		$model->save();

    	}
    	$this->redirect(array('/ConfirmDocument/MsteamsTemp'));
    }

    public function actionConfirmCourse()
    {
    	$type = $_POST['type'];
		$id = $_POST['id'];
		$description = $_POST['description'];

		$model=CourseTemp::model()->findByPk($id);
		if($model != null){
			if($type == 1){
				$model->status_document = 'y';
				$model->note_document = null;
			}else if($type == 2){
				$model->status_document = 'x';
				$model->note_document = $description;
			}
			$model->user_confirm = Yii::app()->user->id;
			$model->date_confirm = date("Y-m-d H:i:s");
			$model->date_confirm_document = date("Y-m-d H:i:s");
			if($model->save(false)){
				echo 'pass';
			}

		}else{
			echo 'nopass';
		}
	}

	public function actionManageStatusCourseDoc()
	{
		$array_id = $_POST['array_id'];
		$status = $_POST['status'];
		try {
			$criteria = new CDbCriteria;
			$criteria->compare('active', 'y');
			$criteria->addInCondition('id', $array_id);
			$model = CourseDocument::model()->findAll($criteria);
			foreach ($model as $key => $value) {
				if($status == "confirm"){
					$value->confirm_status = 'y';
				}else{
					$value->confirm_status = 'x';
				}
				$value->save();
			}
			echo "success";
		} catch (Exception $e) {
			echo "fail";
		}
	}

	public function actionDeleteCourseDoc()
	{
		$id = $_POST['id'];
		try {
			$criteria = new CDbCriteria;
			$criteria->compare('active', 'y');
			$criteria->compare('id', $id);
			$model = CourseDocument::model()->find($criteria);
			if($model){
				$model->active = "n";
				$model->save();
			}
			echo "success";
		} catch (Exception $e) {
			echo "fail";
		}
	}

	public function actionDeleteMsTeamsDoc()
	{
		$id = $_POST['id'];
		try {
			$criteria = new CDbCriteria;
			$criteria->compare('active', 'y');
			$criteria->compare('id', $id);
			$model = MsteamsDocument::model()->find($criteria);
			if($model){
				$model->active = "n";
				$model->save();
			}
			echo "success";
		} catch (Exception $e) {
			echo "fail";
		}
	}

	public function actionManageStatusMsTeamsDoc()
	{
		$array_id = $_POST['array_id'];
		$status = $_POST['status'];
		try {
			$criteria = new CDbCriteria;
			$criteria->compare('active', 'y');
			$criteria->addInCondition('id', $array_id);
			$model = MsteamsDocument::model()->findAll($criteria);
			foreach ($model as $key => $value) {
				if($status == "confirm"){
					$value->confirm_status = 'y';
				}else{
					$value->confirm_status = 'x';
				}
				$value->save();
			}
			echo "success";
		} catch (Exception $e) {
			echo "fail";
		}
	}

    public function actionConfirmMsTeams() {
		$type = $_POST['type'];
		$id = $_POST['id'];
		$description = $_POST['description'];

		$model=MsteamsTemp::model()->findByPk($id);
		if($model != null){
			if($type == 1){
				$model->status_document = 'y';
				$model->note_document = null;
			}else if($type == 2){
				$model->status_document = 'x';
				$model->note_document = $description;
			}

			$model->user_confirm = Yii::app()->user->id;
			$model->date_confirm = date("Y-m-d H:i:s");
			$model->date_confirm_document = date("Y-m-d H:i:s");
			if($model->save(false)){
				echo 'pass';
			}

		}else{
			echo 'nopass';
		}
	}



}
