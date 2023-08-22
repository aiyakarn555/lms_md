<?php

class FaqTypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
//				'actions'=>array('index','view'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FaqType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$langs = Language::model()->findAll();
		if(isset($_POST['FaqType']))
		{
			$model->attributes=$_POST['FaqType'];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				// $model->

				$this->redirect(array('view','id'=>$model->faq_type_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'langs'=>$langs
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

		if(isset($_POST['FaqType']))
		{
			$model->attributes=$_POST['FaqType'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->faq_type_id);
				}
				$this->redirect(array('view','id'=>$model->faq_type_id));
			}
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
		 if ($model->save()) {
			$model_parent_id = FaqType::model()->findByAttributes(array('parent_id'=> $model->faq_type_id));
			$model_parent_id->active = 'n';
			$model_parent_id->save();
		}
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new FaqType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FaqType']))
			$model->attributes=$_GET['FaqType'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
//	public function actionAdmin()
//	{
//		$model=new FaqType('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['FaqType']))
//			$model->attributes=$_GET['FaqType'];
//
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FaqType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FaqType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FaqType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
        //     // Get all current target items to retrieve available sortOrders
        // $cur_items = FaqType::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
        //     // Check 1 by 1 and update if neccessary
	    // $j = 1;
        // foreach ($cur_items as $keys => $values) {
		// 	$all = FaqType::model()->findByPk($values->faq_type_id);
		// 	if(isset($all)){
		// 		$all->sortOrder = $j;
		// 		$all->save(false);
		// 	}
		// 	$j++;
        // }
		
		// if($j-1 == count($_POST['items'])){
			
		// }

		for ($i = 0; $i < count($_POST['items']); $i++) {
			$item = FaqType::model()->findByPk($_POST['items'][$i]);
			$item->sortOrder = $i;
			$item->save(false);

			$modellang2 = FaqType::model()->findByAttributes(array('parent_id'=>$item->faq_type_id)); 
			// var_dump($modellang2->sortOrder);exit();
			
			// if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
			// // 	if ($modellang2->parent_id == '') {
			// 		$items = FaqType::model()->findByPk($_POST['items'][$i]);
			// 		$items->sortOrder = $cur_items[$i]->sortOrder ;
			// 		$items->save(false);
					
			// // 	}
			// 	if ($modellang2->parent_id != null) {
				if(isset($modellang2)){
					$modellang2->sortOrder = $i ;
					$modellang2->save(false);   
				}
					
			// 	}
				
			// } 
		}
    }
}
}
