<?php

class ChatController extends Controller
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	// public function actionView($id)
	// {
	// 	$model1=Chat::model()->findByPk($id);

	// 	$criteria=new CDbCriteria;
	// 	$criteria->condition='chatcode="'.$model1->chatcode.'"';
	// 	$criteria->order = 'time DESC';
	// 	$model=new CActiveDataProvider('Chat',array(
	// 		'criteria'=>$criteria,
	// 	));

	// 	$this->render('view',array(
	// 		'model'=>$model,
	// 		'id'=>$id,
	// 		'code'=>$model1->chatcode,
	// 		 'dataProvider'=>$model,
	// 	));
	// }
	//
	public function actionView()
	{	
	 	$from=$_GET['from'];
	 	$to=$_GET['to'];

		$criteria=new CDbCriteria;
		$criteria->with=array('from_rel','to_rel');
		if(isset($_GET['start'])){
	 		$criteria->addBetweenCondition("t.sent",$start,$end,"AND");
	 	}
		$criteria->condition='t.direction=0 AND ((t.from='.$from.' AND t.to='.$to.') OR (t.from='.$to.' AND t.to='.$from.'))';
		$criteria->order = "t.sent desc";
 		$count = Cometchat::model()->count($criteria);
    	$pages=new CPagination($count);

    	$pages->pageSize=10;
    	$pages->applyLimit($criteria);
		$chat = Cometchat::model()->findAll($criteria);

		$this->render('view',array(
			'chat'=>$chat,
			'pages'=>$pages,
		));
	}
	public function actionCreate()
	{
		$model=new Chat;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Chat']))
		{
			$model->attributes=$_POST['Chat'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Chat']))
		{
			$model->attributes=$_POST['Chat'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionReport()
	{
		$from=$_GET['from'];
	 	$to=$_GET['to'];

		$criteria=new CDbCriteria;
		$criteria->with=array('from_rel','to_rel');
		if(isset($_GET['start'])){
	 		$criteria->addBetweenCondition("t.sent",$start,$end,"AND");
	 	}
		$criteria->condition='t.direction=0 AND ((t.from='.$from.' AND t.to='.$to.') OR (t.from='.$to.' AND t.to='.$from.'))';
		$criteria->order = "t.sent desc";
		$chat = Cometchat::model()->findAll($criteria);

		$this->render('view',array(
			'chat'=>$chat,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=Chat::model()->findByPk($id);
		// $model=Chat::model()->deleteAll('user_from='.$model->user_from);
		$model=Chat::model()->deleteAll('chatcode="'.$model->chatcode.'"');
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionDeleteChat()
	{
		$code=$_GET['code'];
		$model=Chat::model()->deleteAll('chatcode="'.$code.'"');
		$model=Chatroom::model()->delete('room_code="'.$code.'"');
		$this->redirect(array('admin'));
	}
	public function actionDeleteAllChat()
	{
		$code=$_GET['code'];
		$model=Chat::model()->deleteAll('chatcode="'.$code.'"');
		$model=Chatroom::model()->delete('room_code="'.$code.'"');
		$this->redirect(array('admin'));
	}
	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) 
		{
	        foreach($_POST['chk'] as $val) 
	        {
	            $model=Chat::model()->findByPk($val);
				// $model=Chat::model()->deleteAll('user_from='.$model->user_from);
				$model=Chat::model()->deleteAll('chatcode="'.$model->chatcode.'"');
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	            // 
	        }
	    }
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Chat('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Chat']))
			$model->attributes=$_GET['Chat'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$model=new Cometchat('search');
//		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cometchat'])){

				$model->attributes=$_GET['Cometchat'];
//				$criteria = new CDbCriteria();
//				$criteria->with=array('user');
//				$criteria->addBetweenCondition('time', $start, $end, 'AND');
//				$criteria->addCondition('user.id != 1');
//				$criteria->group='user_from';
//				$model= new CActiveDataProvider('Chat',array(
//					'criteria'=>$criteria,
//				));

		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Chat the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Chat::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Chat $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='chat-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
