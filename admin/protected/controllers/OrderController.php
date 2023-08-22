<?php

class OrderController extends Controller
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

	public function actionCreate()
	{
		$model=new Order;

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
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

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];

			//Yii::import('application.modules.user.models.User');
			//$user = User::model()->findAll(array("condition"=>" id = '".$model->user_id."' "));

			//$user = User::model()->findByPk($model->user_id);
			//$sumMoney = $user->point_user+$model->order_point;

			//User::model()->updateByPk($model->user_id,array('point_user'=>$sumMoney));

			// var_dump($user->point_user);
			// var_dump($model->user_id);
			// echo '<hr>';
			// var_dump($model->order_cost);
			// exit();

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
	    $model->save();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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

	public function actionIndex()
	{
		$model=new Order('search');
		$model->unsetAttributes();
		if(isset($_GET['Order']))
		{
			$model->attributes=$_GET['Order'];
		}
		Yii::app()->user->setState('ReportOrder',$model);

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionReportOrder() 
	{
	    $model = new Order('search');
	    $model->unsetAttributes();

        if(Yii::app()->user->getState('ReportOrder'))
        {
        	$model = Yii::app()->user->getState('ReportOrder');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

	    $this->render('reportorder', array('model' => $model, 'production' => $production));
	} 

	public function loadModel($id)
	{
		$model=Order::model()->ordercheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
