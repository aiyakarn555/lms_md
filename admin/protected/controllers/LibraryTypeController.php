<?php

class LibraryTypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view', 'sequence'),
				'users'=>array('*'),
			),
			// array('allow', // allow authenticated user to perform 'create' and 'update' actions
			// 	'actions'=>array('create','update'),
			// 	'users'=>array('@'),
			// ),
			// array('allow', // allow admin user to perform 'admin' and 'delete' actions
			// 	'actions'=>array('admin','delete'),
			// 	'users'=>array('admin'),
			// ),
			array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
            	'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
            	'expression' => 'AccessControl::check_access()',
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LibraryType;

		if(isset($_POST['LibraryType']))
		{
			$model->attributes=$_POST['LibraryType'];

			// $model->library_type = str_replace(' ', '', $model->library_type);
			// $model->library_type = strtolower($model->library_type);


			if($model->save()){
				$model->sortOrder = $model->library_type_id;
				$model->save();

				$this->redirect(array('view','id'=>$model->library_type_id));
			}
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

		if(isset($_POST['LibraryType']))
		{
			$model->attributes=$_POST['LibraryType'];

			// $model->library_type = str_replace(' ', '', $model->library_type);
			// $model->library_type = strtolower($model->library_type);


			if($model->save()){
				$this->redirect(array('view','id'=>$model->library_type_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// $this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	public function actionMultiDelete()
	{	
		if(isset($_POST['chk'])) {
			foreach($_POST['chk'] as $val) {
				$this->actionDelete($val);
			
			}
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new LibraryType('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';

		if(isset($_GET['LibraryType']))
			$model->attributes=$_GET['LibraryType'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LibraryType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LibraryType']))
			$model->attributes=$_GET['LibraryType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$cur_items = LibraryType::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = LibraryType::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LibraryType the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LibraryType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LibraryType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='library-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
