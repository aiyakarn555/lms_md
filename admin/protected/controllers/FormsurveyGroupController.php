<?php

class FormsurveyGroupController extends Controller
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
		$model=new FormsurveyGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FormsurveyGroup']))
		{
			$model->attributes=$_POST['FormsurveyGroup'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->fg_id));
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

		if(isset($_POST['FormsurveyGroup']))
		{
			$model->attributes=$_POST['FormsurveyGroup'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->fg_id));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new FormsurveyGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FormsurveyGroup']))
			$model->attributes=$_GET['FormsurveyGroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=FormsurveyGroup::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FormsurveyGroup $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='formsurvey-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
