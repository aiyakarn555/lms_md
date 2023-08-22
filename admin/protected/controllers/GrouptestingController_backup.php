<?php

class GrouptestingController extends Controller
{
    public function filters() 
    {
        return array(
            'rights',
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
		$model=new Grouptesting;

		if(isset($_POST['Grouptesting']))
		{
			$model->attributes=$_POST['Grouptesting'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->group_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Grouptesting']))
		{
			$model->attributes=$_POST['Grouptesting'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->group_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

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
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) 
		{
	        foreach($_POST['chk'] as $val) 
	        {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex()
	{
		$model=new Grouptesting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grouptesting']))
			$model->attributes=$_GET['Grouptesting'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Grouptesting::model()->grouptestingcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='grouptesting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
