<?php

// @var News
class NewsController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//		);
//	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
//	public function actionView($id)
//	{
//		$this->render('view',array(
//			'model'=>$this->loadModel($id),
//		));
//	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
//	public function actionCreate()
//	{
//		$model=new News;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['News']))
//		{
//			$model->attributes=$_POST['News'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->cms_id));
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
//	public function actionUpdate($id)
//	{
//		$model=$this->loadModel($id);
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['News']))
//		{
//			$model->attributes=$_POST['News'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->cms_id));
//		}
//
//		$this->render('update',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
//	public function actionDelete($id)
//	{
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
          	}

            $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
           }

           $criteria = new CDbCriteria;
           $criteria->compare('active', y);
           $criteria->compare('lang_id', $langId);
           if(isset($_POST["cms_title"])){
           	$criteria->compare('cms_title',$_POST["cms_title"],true);
           }
           $criteria->order = 'sortOrder  ASC';

           if($_POST["sort"] == 2){
           	$criteria->order = 'update_date ASC';
           }else if($_POST["sort"] == 1){
           	$criteria->order = 'update_date  DESC';

           }

           $news = News::model()->findAll($criteria); 

            $this->render('index',array('label'=>$label,'news'=>$news,'textold'=>$_POST["cms_title"],"sort"=>$_POST["sort"]));
	}
        public function actionDetail($id)
	{

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$id = $_GET['id'];
		//News


		// if(Yii::app()->session['lang'] != 1){
			$news_data = News::model()->findByAttributes(array(
			'active'=>'y',
			'cms_id'=>$id,
		   ));
		// }else{
		// 	$news_data = News::model()->findByAttributes(array(
		// 		'active'=>'y',
		// 		'cms_id'=>$id,
		// 	));
		// }
		$this->pageTitle = $news_data->cms_title;

		$dateNow  = date("d-m-Y");
		$ipaddress = '';

		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		$criteria = new CDbCriteria;
		$criteria->compare('ip_visit', $ipaddress);
		$criteria->compare('cms_id', $id);
		$modelCount = CounterNews::model()->findAll($criteria);


		$ip_Old = [];
		$date_Old = [];
		foreach ($modelCount as $key => $value) {
			$ip_Old[] = $value->ip_visit;
			$date_Old[] = $value->date_visit;			 
		}

		$count = new CounterNews;
		
		if(in_array($ipaddress, $ip_Old) && !in_array($dateNow, $date_Old)){ //ไอพี่เก่า วันใหม่
			$count->date_visit = $dateNow;
			$count->ip_visit = $ipaddress;
			$count->cms_id = $id;
			$count->visit = 1;
			$count->save();
		}else if(!in_array($ipaddress, $ip_Old) && in_array($dateNow, $date_Old)){ //ไอพี่ใหม่ วันเก่า
			$count->date_visit = $dateNow;
			$count->ip_visit = $ipaddress;
			$count->cms_id = $id;
			$count->visit = 1;
			$count->save();
		}else if(!in_array($ipaddress, $ip_Old) && !in_array($dateNow, $date_Old)){ //ไอพี่ใหม่ วันใหม่
			$count->date_visit = $dateNow;
			$count->ip_visit = $ipaddress;
			$count->cms_id = $id;
			$count->visit = 1;
			$count->save();
		}

		$criteria = new CDbCriteria;
		$criteria->compare('cms_id', $id);
		$count = CounterNews::model()->count($criteria);

		$this->render('news-detail',array(
			'news_data'=>$news_data,
			'count'=>$count,
		));
	}

	/**
	 * Manages all models.
	 */
//	public function actionAdmin()
//	{
//		$model=new News('search');
//		$model->unsetAttributes();  // clear any default values
//		if(isset($_GET['News']))
//			$model->attributes=$_GET['News'];
//
//		$this->render('admin',array(
//			'model'=>$model,
//		));
//	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
