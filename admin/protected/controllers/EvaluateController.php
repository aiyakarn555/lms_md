<?php

class EvaluateController extends Controller
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
		$model=new Evaluate;

		if(isset($_POST['Evaluate']))
		{
			$model->attributes=$_POST['Evaluate'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->eva_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Evaluate']))
		{
			$model->attributes=$_POST['Evaluate'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->eva_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$model=new CourseOnline('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CourseOnline']))
			$model->attributes=$_GET['CourseOnline'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionAdmin($id = null)
	{
		if(isset($id) && $id != '')
		{
			$model=new Evaluate('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['Evaluate']))
				$model->attributes=$_GET['Evaluate'];

			$this->render('admin',array(
				'model'=>$model,
				'id' => $id
			));
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionUser($id = null)
	{
		if(isset($id) && $id != '')
		{
			$modelCourseOnline = CourseOnline::model()->findByPk($id);

			$modelEvalAns=new EvalAns('search');
			$modelEvalAns->unsetAttributes();  // clear any default values
			if(isset($_GET['EvalAns']))
			{
				$modelEvalAns->attributes=$_GET['EvalAns'];
			}
				

			$model=new User('search');
	        $model->unsetAttributes();  // clear any default values
	        if(isset($_GET['User']))
	        {
	        	$model->attributes=$_GET['User'];
	        }

	        $this->render('user',array(
	        	'modelEvalAns'=>$modelEvalAns,
	        	'modelCourseOnline'=>$modelCourseOnline,
	            'model'=>$model,
	            'id'=>$id
	        ));
	    }
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function loadModel($id)
	{
		$model=Evaluate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evaluate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
