<?php

class ManualuserController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','viewpdf','Viewmanual','Viewvdo'),
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
		$model=new Manualuser;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Manualuser']))
		{
			$model->attributes=$_POST['Manualuser'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->m_id));
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

		if(isset($_POST['Manualuser']))
		{
			$model->attributes=$_POST['Manualuser'];
			if($model->save(false))
			{

				$pp_file = CUploadedFile::getInstance($model, 'pp_file');

				if(!empty($pp_file)){

					$oldfile = ManualSLide::model()->deleteAll(array(
						'condition' => 'manual_id = '.$id
					));
					$time = date('YmdHis');
					$fileNamePpt = $time."_ppt.".$pp_file->getExtensionName();
					$FileName = $model->m_id;
					$dirPpt = Yii::app()->basePath."/../uploads/manual/".$FileName."/";


					if(!is_dir($dirPpt)){
						mkdir($dirPpt,0777);
					}
					$pp_file->saveAs($dirPpt.$fileNamePpt);
					if ($model->m_type == 'ebook') {
						$ppName = $dirPpt.$fileNamePpt;

						if($_SERVER['HTTP_HOST'] == 'localhost'){
							$imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
						}else{
							$imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
						}
						$ppt_file = $ppName;
						$new_pdf_file  = str_replace(".pptx", ".pdf", $ppName);
						$new_pdf_file  = str_replace(".ppt", ".pdf", $new_pdf_file);

						exec($imagemagick.' "'.realpath($new_pdf_file).'" "'.realpath($dirPpt).'\slide.jpg"');

						$directory = realpath($dirPpt);
						$scanned_directory = array_diff(scandir($directory), array('..', '.'));
						$image_slide_len = count($scanned_directory)-1;
						ManualSLide::model()->deleteAll("manual_id='".$model->m_id."'");

						for ($i=0; $i < $image_slide_len; $i++) {
							$image_slide = new ManualSLide;
							$image_slide->manual_id = $model->m_id;
							$image_slide->image_slide_name = $i;
							$image_slide->save();
						}
						$pptFile = Yii::app()->file->set($dirPpt.$fileNamePpt);
						$pptFile->Delete();

						$pdfFile = Yii::app()->file->set($new_pdf_file);
						$pdfFile->Delete();
					}elseif ($model->m_type == 'pdf' || $model->m_type == 'vdo') {
						$model->m_address = $model->m_id.'/'.$fileNamePpt;

						$model->save(false);
					}

					$this->redirect(array('update','id'=>$model->m_id));
				}

				$this->redirect(array('index','id'=>$model->m_id));
			}
			//$this->redirect(array('view','id'=>$model->id));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Manualuser('search');
		$model->unsetAttributes();
		if (isset($_GET['Document']))
			$model->attributes = $_GET['Document'];
		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Manualuser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Manualuser']))
			$model->attributes=$_GET['Manualuser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Manualuser the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Manualuser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Manualuser $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='manualuser-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionViewpdf($id,$type=null)
	{
		
		if ($id == 1) {
			$file = 'Manual_admin.pdf';
		}else{
			$file = 'Manual_user.pdf';
		}
		$filepath = Yii::app()->basePath.'/../uploads/manual/' . $file;
		$typefile = explode(".",  $file);
		if(file_exists($filepath))
		{
			if ($typefile[sizeof($typefile)-1] == 'pdf') {
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="'.$filepath.'"');
				header('Content-Length: ' . filesize($filepath));
				readfile($filepath);

			}else{
				return Yii::app()->getRequest()->sendFile($file, @file_get_contents($filepath));
			}
		}else{
			echo 'ไม่พบไฟล์';exit();
		}
	}

}
