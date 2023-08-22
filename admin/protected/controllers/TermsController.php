<?php

class TermsController extends Controller
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
            	'actions' => array('view'),
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
	// 		return array(
	// 				'rights',
	// 		);
	// }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionCreate()
    {
    	$model=new Terms;

    	if(isset($_POST['Terms']))
    	{
    		$model->attributes=$_POST['Terms'];
            $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
            $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
    		if($model->save())
    			$this->redirect(array('view','id'=>$model->id));
    	}
            // var_Dump($model->getErrors());exit();


    	$this->render('create',array(
    		'model'=>$model,
    	));
    }

    public function actionUpdate($id)
    {
    	$model=$this->loadModel($id);

    	if(isset($_POST['Terms']))
    	{
    		$model->attributes=$_POST['Terms'];
    		if($model->save()){
    			if(Yii::app()->user->id){
    				Helpers::lib()->getControllerActionId($model->id);
    			}
    			$this->redirect(array('view','id'=>$model->id));
    		}
    	}

    	$this->render('update',array(
    		'model'=>$model,
    	));
    }

	// public function actionDelete($id)
	// {
	// 	$this->loadModel($id)->delete();
	//
	// 	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	// 	if(!isset($_GET['ajax']))
	// 		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	// }

    public function actionIndex()
    {
    	$model=new Terms('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Terms'])){
			$model->attributes=$_GET['Terms'];
            $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
            $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

		$this->render('index',array(
			'model'=>$model,
		));
        }
        $this->render('index',array(
            'model'=>$model,
        ));
	}

	public function loadModel($id)
	{
		$model=Terms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='terms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
