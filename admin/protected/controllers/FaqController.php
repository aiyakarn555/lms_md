<?php

class FaqController extends Controller
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
	// public function init()
	// {
	// 	parent::init();
	// 	$this->lastactivity();

	// }
	public function init()
	{
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
		}
		parent::init();
		if (isset($_GET['lang_id']) || isset($_GET['parent_id']) ) {

			$langId = $_GET['lang_id'];
			if($langId != 1 && $actionName != "Faqtype/create"){
			$lang = Language::model()->findByPk($langId);
			$parentId = $_GET['parent_id'];
			$Root = Faq::model()->findByAttributes(array('faq_nid_'=> $parentId,'active'=>'y'));
			$cateRoot = FaqType::model()->findByAttributes(array('parent_id'=> $Root->faq_type_id,'lang_id'=>$langId,'active'=>'y'));
			$cateMain = FaqType::model()->findByAttributes(array('faq_type_id'=> $Root->faq_type_id,'active'=>'y'));
			if(!$cateRoot){
				Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหมวดคำถาม '.$cateMain->faq_type_title_TH .',ภาษา '.$lang->language);
				$this->redirect(array('Faqtype/index'));
				exit();
			}
			}
		}
		$this->lastactivity();
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
	// 		'rights',
	// 	);
	// }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view','test'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

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

    public function actionTest()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('test');
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Faq;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Faq']))
		{
			$model->attributes=$_POST['Faq'];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			if($model->save()){
				$model->sortOrder = $model->id;
			    $model->faq_THanswer = CHtml::decode($model->faq_THanswer);
                $model->save();
				$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->faq_nid_;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							$models = Faq::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
							if(!$models){
								$Root = Faq::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มคำถาม '.$Root->faq_THtopic .',ภาษา '.$lang->language);
					          	// $this->redirect(array('Category/index'));
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
					}
			}

				if(Yii::app()->user->id){
    				Helpers::lib()->getControllerActionId();
    			}

				$this->redirect(array('view','id'=>$model->faq_nid_));
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

		if(isset($_POST['Faq']))
		{
			$model->attributes=$_POST['Faq'];
			if($model->save())
				if(Yii::app()->user->id){
    				Helpers::lib()->getControllerActionId();
    			}

				$this->redirect(array('view','id'=>$model->faq_nid_));
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
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$parent_id = $model->faq_nid_;
        $modelChildren = Faq::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
              ));
        	foreach ($modelChildren as $key => $value) {
				 $value->active = 'n';
				 $value->save();
        	}
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
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Faq('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Faq']))
			$model->attributes=$_GET['Faq'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
//	public function actionAdmin()
//	{
//		$model=new Faq('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['Faq']))
//			$model->attributes=$_GET['Faq'];
//
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Faq the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Faq::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Faq $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = Faq::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
            // Check 1 by 1 and update if neccessary

        foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = Faq::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = Faq::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                 // var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = Faq::model()->findByPk($_POST['items'][$i]);
                        $items->sortOrder = $cur_items[$i]->sortOrder ;
                        $items->save(false);
                        
                    }
                    if ($modellang2->parent_id != null) {
                        $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
                        $modellang2->save(false);   
                    }
                    
                } 
            }
        }        
    }
}
}
