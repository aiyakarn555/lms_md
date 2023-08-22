<?php

class MainMenuController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('view','MultiDeletes'),
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
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	// public function filters()
	// {
	// 	return array(
	// 		'accessControl', // perform access control for CRUD operations
	// 		'postOnly + delete', // we only allow deletion via POST request
	// 	);
	// }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
		// public function accessRules()
		// {
		// 	return array(
		// 		array('allow',  // allow all users to perform 'index' and 'view' actions
		// 			'actions'=>array('index','view'),
		// 			'users'=>array('*'),
		// 		),
		// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
		// 			'actions'=>array('create','update'),
		// 			'users'=>array('@'),
		// 		),
		// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
		// 			'actions'=>array('admin','delete'),
		// 			'users'=>array('admin'),
		// 		),
		// 		array('deny',  // deny all users
		// 			'users'=>array('*'),
		// 		),
		// 	);
		// }

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
		$model = new MainMenu;
		$form = '_form';
		$langId = 1;
		if(isset($_GET['lang_id']) || isset($_GET['parent_id'])){
			$langId = $_GET['lang_id'];
			$parentId = $_GET['parent_id'];

			$rootMenu = MainMenu::model()->findByPk($parentId);
		}
		if($rootMenu){
			$nameMenu = explode("/",$rootMenu->url);
			$nameMenu = $nameMenu[0];
			$value  = $this->checkMenu($nameMenu,$rootModel=false,$langId);
			
			if(!$label){
				$value  = $this->checkMenu($nameMenu,$rootModel=true,$langId);
			}
			$label = $value['modelNew']; 
			// $label = $value['label'];
			$form = $value['formName'];
			$nameModel = $value['nameModel'];
			// var_dump($modelNew);exit();

		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	if(isset($_POST['MainMenu']))
	{
		if($label){
			$label->attributes = $_POST[$nameModel];
			$label->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			// $label->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			if(!$label->save()){
				var_dump($label->getErrors());exit();
			}else{
				$label->save();
			}
			
		}
		
		
		// var_dump($_POST);exit();
		$model->attributes=$_POST['MainMenu'];
		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
		if($model->save()){
			if(Yii::app()->user->id){
				Helpers::lib()->getControllerActionId();
			}
			
			$this->redirect(array('admin','id'=>$model->id));
			
		}
	}

	$this->render('create',array(
		'model'=>$model,
		'label' => $label,
		'form' => $form,
	));
}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(isset($_GET['lang_id'])){
				$langId =  $_GET['lang_id'];
			}else{
				$langId =  1;
			}
		$model=$this->loadModel($id);
		$form = '_form';
		if($model->parent_id != 0){ //Model Children
			$modelRoot = MainMenu::model()->findByPk($model->parent_id);
			$nameMenu = explode("/",$modelRoot->url);
			$nameMenu = $nameMenu[0];
			$value  = $this->checkMenu($nameMenu,$rootModel=false,$langId);
			$label = $value['label'];
		}else{ //lang_id = 1
			$nameMenu = explode("/",$model->url);
			$nameMenu = $nameMenu[0];
			$value  = $this->checkMenu($nameMenu,$rootModel=true,$langId);
			$label = $value['label'];
		}
			$form = $value['formName'];
			$nameModel = $value['nameModel'];
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_POST['MainMenu']))
		{
			$this->updateModel($nameMenu,$langId,$_POST[$nameModel]);

			// $label->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			// $label->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			$model->attributes=$_POST['MainMenu'];

			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('admin','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'label' => $label,
			'form' => $form,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('MainMenu');
		$dataProvider=new CActiveDataProvider('MainMenu' ,array('criteria'=>array(
			'condition'=>'active="y"')));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionMultiDelete()
	{	

		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			}
			echo true;
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new MainMenu('search');
		$model->unsetAttributes();  // clear any default values
		$model->lang_id = 1;
		// $model->status = 'y';
		if(isset($_GET['MainMenu']))
			$model->attributes=$_GET['MainMenu'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MainMenu the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MainMenu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function checkMenu($nameMenu,$rootModel,$langId)
	{

		$criteria = new CDbCriteria();
		$criteria->compare('lang_id',$langId);

		switch (strtolower($nameMenu)) {
			    case "site":
			    	$modelNew = new MenuSite();
			    	$form = '_formSite';
			    	$nameModel = "MenuSite";
		
			    		$label = MenuSite::model()->find($criteria);
			    	
			        break;
			    case "about":
				    $modelNew = new MenuAbout();
				    $form = '_formAbout';
				    $nameModel = "MenuAbout";
				
			    		$label = MenuAbout::model()->find($criteria);
			    	
				    break;
				case "course":
				    $modelNew = new MenuCourse();
				    $form = '_formCourse';
				    $nameModel = "MenuCourse";
				  
			    		$label = MenuCourse::model()->find($criteria);
			    	
				    break;
				case "usability":
				    $modelNew = new MenuUsability();
				    $form = '_formUsability';
				    $nameModel = "MenuUsability";
			
			    		$label = MenuUsability::model()->find($criteria);
			    	
				    break;
				case "faq":
				    $modelNew = new MenuFaq();
				    $form = '_formFaq';
				    $nameModel = "MenuFaq";
				    
			    		$label = MenuFaq::model()->find($criteria);
			    	
				    break;
				case "contactusnew":
				    $modelNew = new MenuContactus();
				    $form = '_formContactus';
				    $nameModel = "MenuContactus";
				 
			    		$label = MenuContactus::model()->find($criteria);
			    	
				    break;
				case "registration":
				    $modelNew = new MenuRegistration();
				    $form = '_formRegistration';
				    $nameModel = "MenuRegistration";
				  
			    		$label = MenuRegistration::model()->find($criteria);
			    	
				    break;
				case "forgot_password":
				    $modelNew = new MenuForgotpassword();
				    $form = '_formForgotpassword';
				    $nameModel = "MenuForgotpassword";
				  
			    		$label = MenuForgotpassword::model()->find($criteria);
			    	
				    break;
				case "question":
				    $modelNew = new MenuCoursequestion();
				    $form = '_formCoursequestion';
				    $nameModel = "MenuCoursequestion";
				  
			    		$label = MenuCoursequestion::model()->find($criteria);
			    	
				    break; 
				case "search":
				    $modelNew = new MenuSearch();
				    $form = '_formSearch';
				    $nameModel = "MenuSearch";
				   
			    		$label = MenuSearch::model()->find($criteria);
			    	
				    break;
				case "privatemessage":
				    $modelNew = new MenuPrivatemessage();
				    $form = '_formPrivatemessage';
				    $nameModel = "MenuPrivatemessage";
				
			    		$label = MenuPrivatemessage::model()->find($criteria);
			    	
				    break; 

				case "webboard":
				    $modelNew = new MainMenu();
				    $form = '_form';
				    $nameModel = "MainMenu";
				
			    		$label = MainMenu::model()->find($criteria);
			    	
				    break; 

				case "virtualclassroom":
				    $modelNew = new MenuVroom();
				    $form = '_formVroom';
				    $nameModel = "MainVroom";
				
			    		$label = MenuVroom::model()->find($criteria);
			    	
				    break;

				case "video":
				    $modelNew = new MenuLibrary();
				    $form = '_formLibrary';
				    $nameModel = "MainLibrary";
				
			    		$label = MenuLibrary::model()->find($criteria);
			    	
				    break; 
			}
			
			$value = array('label'=>$label,'formName'=> $form,'nameModel'=> $nameModel,'modelNew'=>$modelNew);
		return $value;
	}

	public function updateModel($nameMenu,$lang_id,$value)
	{
		$ck = false;
		switch (strtolower($nameMenu)) {
			    case "site":
			    	$updateMenu = MenuSite::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
			    	$ck = $updateMenu->update();
			        break;
			    case "about":
				    $updateMenu = MenuAbout::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
			    	$ck = $updateMenu->update();
				    break;
				case "course":
				    $updateMenu = MenuCourse::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
			    	$ck = $updateMenu->update();
				    break;
				case "usability":
				    $updateMenu = MenuUsability::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
			    	$ck = $updateMenu->update();
				    break;
				case "faq":
				    $updateMenu = MenuFaq::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
			    	$ck = $updateMenu->update();
				    break;
				case "contactusnew":
				    $updateMenu = MenuContactus::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				case "registration":
				    $updateMenu = MenuRegistration::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				case "forgot_password":
				    $updateMenu = MenuForgotpassword::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				case "question":
				    $updateMenu = MenuCoursequestion::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				case "search":
				    $updateMenu = MenuSearch::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				case "privatemessage":
				    $updateMenu = MenuPrivatemessage::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;

				case "webboard":
				    $updateMenu = MainMenu::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;

				case "virtualclassroom":
				    $updateMenu = MainVroom::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;

				case "video":
				    $updateMenu = MenuLibrary::model()->find(array('condition' => "lang_id=".$lang_id));
			    	$updateMenu->attributes = $value;
				    break;
				    
			}
			$updateMenu->save();
		return $ck;
	}

	public function actionTest()
	{
		MenuSite::model()->updateAll(
            array('label_vdo' => "TESTSET"), 
            'lang_id = 2'
            );
	}


	/**
	 * Performs the AJAX validation.
	 * @param MainMenu $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='MainMenu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
