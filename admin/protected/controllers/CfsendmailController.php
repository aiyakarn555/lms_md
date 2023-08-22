<?php

class CfsendmailController extends Controller
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
    

	public function actionIndex($id = 1)
	{

		$model = $this->loadModel($id);
		if(isset($_POST['Cfsendmail']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['Cfsendmail'];

			if($model->validate())
			{
				$model->save();
			}
		}

		$this->render('form',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Cfsendmail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Email-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
