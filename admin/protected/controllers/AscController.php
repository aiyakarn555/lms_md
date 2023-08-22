<?php

class AscController extends Controller
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

	public function actionCreate()
	{
		$model = new Asc;

		if(isset($_POST['Asc']))
		{
			$model->attributes=$_POST['Asc'];
			if($model->validate())
			{
				if($model->save()){
					$this->redirect(array('asc/index'));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['Asc']))	
		{
			$model->attributes=$_POST['Asc'];

			if($model->validate())
			{
				if($model->save())
				{
					$this->redirect(array('asc/index'));
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
	    $model->delete();

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
		$model=new Asc('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Asc']))
			$model->attributes=$_GET['Asc'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Asc::model()->findByPk($id);
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

//	public function actionSequence()
//	{
//		if(isset($_POST['items']) && is_array($_POST['items']))
//		{
//			$SortArray = array();
//			foreach ($_POST['items'] as $key => $value)
//			{
//				$checkSort = File::model()->findByPk($value);
//				$SortArray[] = $checkSort->file_position;
//			}
//
//			usort($SortArray, function ($a, $b){ return substr($b, -2) - substr($a, -2); });
//
//			$i = 0;
//			foreach ($_POST['items'] as $item)
//			{
//				File::model()->updateByPk($_POST['items'][$i], array(
//					'file_position'=>$SortArray[$i],
//				));
//				$i++;
//			}
//		}
//	}

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
