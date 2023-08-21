<?php

class CateOnlineController extends Controller
{
	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIndex()
	{	
		$cate_type = 1;
		if(isset(Yii::app()->user->authitem_name)){
			if(Yii::app()->user->authitem_name == 'company'){
				$cate_type = 2;
			}
		}

		$criteria=new CDbCriteria;
		$criteria->compare('cate_type',$cate_type);
		$dataProvider=new CActiveDataProvider('CateOnline',array(
			'criteria'=>$criteria,
	        'pagination'=>array(
	        	'pageSize'=>12,
	        ),
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=CateOnline::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
