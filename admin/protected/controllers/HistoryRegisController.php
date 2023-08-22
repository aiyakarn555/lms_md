<?php

class HistoryRegisController extends Controller
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

    public function actionCourseDocumentTemp()
    {

    	$model=new CourseTemp('search_document_history');
        $model->unsetAttributes();  

        if(isset($_GET['CourseTemp']))
        	$model->attributes=$_GET['CourseTemp'];
			$model->courseTi=$_GET['CourseTemp']['courseTi'];
			$model->fullname=$_GET['CourseTemp']['fullname'];
			$model->datestr = $_GET['CourseTemp']['datestr'];
			$model->dateend = $_GET['CourseTemp']['dateend'];
			

    	$this->render('course_document_temp',array(
    		'model'=>$model
    	));

    }

    public function actionMsteamsDocumentTemp()
    {

    	$model=new MsteamsTemp('search_document_history');
        $model->unsetAttributes();  

        if(isset($_GET['MsteamsTemp']))
        	$model->attributes=$_GET['MsteamsTemp'];
			$model->courseTi=$_GET['MsteamsTemp']['courseTi'];
			$model->fullname=$_GET['MsteamsTemp']['fullname'];
			$model->datestr = $_GET['MsteamsTemp']['datestr'];
			$model->dateend = $_GET['MsteamsTemp']['dateend'];
			

    	$this->render('ms_teams_document_temp',array(
    		'model'=>$model
    	));

    }

    public function actionCoursePaymentTemp()
    {

    	$model=new CourseTemp('search_payment_history');
        $model->unsetAttributes();  

        if(isset($_GET['CourseTemp']))
        	$model->attributes=$_GET['CourseTemp'];
			$model->courseTi=$_GET['CourseTemp']['courseTi'];
			$model->fullname=$_GET['CourseTemp']['fullname'];
			$model->datestr = $_GET['CourseTemp']['datestr'];
			$model->dateend = $_GET['CourseTemp']['dateend'];
			
    	$this->render('course_Payment_temp',array(
    		'model'=>$model
    	));

    }

    public function actionMsteamsPaymentTemp()
    {

    	$model=new MsteamsTemp('search_payment_history');
        $model->unsetAttributes();  

        if(isset($_GET['MsteamsTemp']))
        	$model->attributes=$_GET['MsteamsTemp'];
			$model->courseTi=$_GET['MsteamsTemp']['courseTi'];
			$model->fullname=$_GET['MsteamsTemp']['fullname'];
			$model->datestr = $_GET['MsteamsTemp']['datestr'];
			$model->dateend = $_GET['MsteamsTemp']['dateend'];
			

    	$this->render('ms_teams_Payment_temp',array(
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
    	$this->redirect(array('/HistoryRegis/CourseDocumentTemp'));
    }

}
