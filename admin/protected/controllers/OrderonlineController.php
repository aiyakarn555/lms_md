<?php

class OrderonlineController extends Controller
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

	public function actionReportOrderonline() 
	{
	    $model = new Orderonline('search');
	    $model->unsetAttributes();

        if(Yii::app()->user->getState('ReportOrderonline'))
        {
        	$model = Yii::app()->user->getState('ReportOrderonline');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

	    $this->render('reportorderonline', array('model' => $model, 'production' => $production));
	} 

	public function actionCreate()
	{
		$model=new Orderonline;

		if(isset($_POST['Orderonline']))
		{
			$model->attributes=$_POST['Orderonline'];
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

		if(isset($_POST['Orderonline']))
		{
			$model->attributes=$_POST['Orderonline'];
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
		//Query Id True
		$modelOrder = new Orderonline;
		$modelOrderDelete = $this->loadModel($id);
		$UserDelete = $modelOrderDelete->user_id;
		$count = $modelOrder->model()->countByAttributes(array('order_id'=> $id,'user_id'=>$UserDelete,'active'=>'y'));
        if($count == 1){
			$lessonModel = Lesson::model()->findAll(array(
				'condition'=>'course_id=:course_id',
					'params'=>array(':course_id'=>$this->loadModel($id)->orderonlines->shop_id)
			));
			foreach ($lessonModel as $key => $value){
			    $user = Yii::app()->getModule('user')->user();
			    $learnLesson = $user->learns(
			        array(
			            'condition'=>'lesson_id=:lesson_id',
			            'params' => array(':lesson_id' => $value->id)
			        )
			    );
				//tblReturn
				tblReturn::model()->deleteAllByAttributes(array(
				    'lesson_id'=>$this->loadModel($id)->orderonlines->shop_id,
				    'user_id'=>$UserDelete
				));
			    if($value->fileCount != 0 && $learnLesson){
					$lessonModel = Learn::model()->findAll(array(
						'condition'=>'lesson_id=:lesson_id AND user_id=:user_id',
							'params'=>array(':lesson_id'=>$value->id,':user_id'=>$UserDelete)
					));
					foreach ($lessonModel as $keylesson => $valuelesson) {
						LearnFile::model()->deleteAllByAttributes(array(
						    'learn_id'=>$valuelesson->learn_id,
						    'user_id_file'=>$UserDelete
						));
					}
					Learn::model()->deleteAllByAttributes(array(
					    'lesson_id'=>$value->id,
					    'user_id'=>$UserDelete
					));
					//Log 
					Logques::model()->deleteAllByAttributes(array(
					    'lesson_id'=>$value->id,
					    'user_id'=>$UserDelete
					));
					Logchoice::model()->deleteAllByAttributes(array(
					    'lesson_id'=>$value->id,
					    'user_id'=>$UserDelete
					));
					//Score
					Score::model()->deleteAllByAttributes(array(
					    'lesson_id'=>$value->id,
					    'user_id'=>$UserDelete
					));
			    }
			}
			OrderDetailonline::model()->findByPk($this->loadModel($id)->orderonlines->order_detail_id)->delete();
			$this->loadModel($id)->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(index));
			
        }else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
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
		$model=new Orderonline('search');
		$model->unsetAttributes();

		if(isset($_GET['Orderonline']))
		{
			$model->attributes=$_GET['Orderonline'];
		}
		Yii::app()->user->setState('ReportOrderonline',$model);

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Orderonline::model()->orderonlinecheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orderonline-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
