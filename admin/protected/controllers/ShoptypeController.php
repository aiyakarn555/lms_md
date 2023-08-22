<?php

class ShoptypeController extends Controller
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
		$model=new Shoptype;

		if(isset($_POST['Shoptype']))
		{
			$model->attributes=$_POST['Shoptype'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->shoptype_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Shoptype']))
		{
			$model->attributes=$_POST['Shoptype'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->shoptype_id));
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
		header('Content-type: application/json');
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
		$model=new Shoptype('search');
		$model->unsetAttributes();
		if(isset($_GET['Shoptype']))
			$model->attributes=$_GET['Shoptype'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Shoptype::model()->shoptypecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shoptype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
