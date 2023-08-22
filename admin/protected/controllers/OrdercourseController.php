<?php

class OrdercourseController extends Controller
{
    public function filters() 
    {
        return array(
            'rights- toggle, switch, qtoggle',
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

	public function actionReportOrderCourse() 
	{
	    $model = new Ordercourse('search');
	    $model->unsetAttributes();

        if(Yii::app()->user->getState('ReportOrderCourse'))
        {
        	$model = Yii::app()->user->getState('ReportOrderCourse');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

	    $this->render('reportordercourse', array('model' => $model, 'production' => $production));
	} 

	public function actionCreate()
	{
		$model=new Ordercourse;

		if(isset($_POST['Ordercourse']))
		{
			$model->attributes=$_POST['Ordercourse'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Ordercourse']))
		{
			$model->attributes=$_POST['Ordercourse'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
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
	    $model->save(false);

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
		$model=new Ordercourse('search');
		$model->unsetAttributes();
		if(isset($_GET['Ordercourse']))
		{
			$model->attributes=$_GET['Ordercourse'];
		}
		Yii::app()->user->setState('ReportOrderCourse',$model);
			
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Ordercourse::model()->ordercoursecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ordercourse-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
