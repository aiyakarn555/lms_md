<?php

class Problem_typeController extends Controller
{
    public function filters() 
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
        );
    }

    public function accessRules()
    {
    	return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('Sequence'),
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

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new ProblemType;

		if(isset($_POST['ProblemType']))
		{
			$model->Problem_title = $_POST['ProblemType'][Problem_title];
			$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
            $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
			$model->active = 'y';
			$model->create_date = date("Y-m-d H:i:s",time());
			if($model->validate())
			{
				if($model->save()){
					$this->redirect(array('Problem_type/index'));
				}
			} else {
				echo "<pre>";
				var_Dump($model->getErrors());
				exit();
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['ProblemType']))	
		{
			$model->Problem_title = $_POST['ProblemType'][Problem_title];

			if($model->validate())
			{
				if($model->save())
				{
					$this->redirect(array('Problem_type/index'));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model
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
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
	        foreach($_POST['chk'] as $val) {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex()
	{
		$model=new ProblemType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Problem_type']))
			$model->attributes=$_GET['Problem_type'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=ProblemType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = CourseOnline::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = CourseOnline::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}
}
?>