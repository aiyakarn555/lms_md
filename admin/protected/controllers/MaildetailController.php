<?php

class MaildetailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
		$model=new Maildetail;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Maildetail']))
		{
			$model->attributes=$_POST['Maildetail'];
				if($model->validate())
				{
					$model->save();
					$path = Yii::app()->basePath . '/../../uploads/filemail/';
					$file = CUploadedFile::getInstancesByName('file_name');
					if (isset($file) && count($file) > 0) {
						// go through each uploaded image
						foreach ($file as $key => $file_mail) {
							$uglyName = strtolower($file_mail->name);
							$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
							$fileName = trim($mediocreName, '_') . "." . $file_mail->extensionName;
							if ($file_mail->saveAs($path.$fileName)) {
								// add it to the main model now
								$file_add = new Mailfile();
								$file_add->maildetail_id = $model->id;
								$file_add->file_name = $fileName;
								$file_add->file_type = $file_mail->extensionName;
								$file_add->save();
							}
						}
					}

				}
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

		if(isset($_POST['Maildetail']))
		{
			$model->attributes=$_POST['Maildetail'];
			if($model->validate())
			{
				$model->save();
				$path = Yii::app()->basePath . '/../../uploads/filemail/';
				$file = CUploadedFile::getInstancesByName('file_name');
				if (isset($file) && count($file) > 0) {
					// go through each uploaded image
					foreach ($file as $key => $file_mail) {
						$uglyName = strtolower($file_mail->name);
						$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
						$fileName = trim($mediocreName, '_') . "." . $file_mail->extensionName;
						if ($file_mail->saveAs($path.$fileName)) {
							// add it to the main model now
							$file_add = new Mailfile();
							$file_add->maildetail_id = $model->id;
							$file_add->file_name = $fileName;
							$file_add->file_type = $file_mail->extensionName;
							$file_add->save();
						}
					}
				}

			}
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	//In controller
	public function actionDelete_file() {
		$path = Yii::app()->basePath . '/../../uploads/filemail/';
		$model = Mailfile::model()->findByPk($_POST['fid']);
		unlink($path.$model->file_name);
		$model->delete();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Maildetail');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Maildetail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Maildetail']))
			$model->attributes=$_GET['Maildetail'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Maildetail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Maildetail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Maildetail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='maildetail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
