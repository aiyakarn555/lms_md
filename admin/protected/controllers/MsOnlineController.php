create<?php

class MsOnlineController extends Controller
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
            	'actions' => array('index', 'view','MultiDelete','update','delete','create'),
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

		$model=new MsOnline;
		 // $attendees = array('type' => 'required','status'=> array('response' => 'none', 'time'=> '0001-01-01T00:00:00Z'),'emailAddress' =>array('name' => 'Test', 'address'=> 'aiyakarn2540@gmail.com') );
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MsOnline']))
		{

			$time = date("dmYHis");
			$model->attributes=$_POST['MsOnline'];

			$ms_teams_picture = CUploadedFile::getInstance($model, 'ms_teams_picture');
			if(!empty($ms_teams_picture)){
				$fileNamePicture = $time."_Picture.".$ms_teams_picture->getExtensionName();
				$model->ms_teams_picture = $fileNamePicture;
			}

			if($model->validate())
			{

               	$str = $model->start_date;
               	$end = $model->end_date;


				// $token = Helpers::lib()->sendApiToken();
                // $Meeting = Helpers::lib()->sendApiCreateMeeting($token ,$model->name_ms_teams,$model->detail_ms_teams,$str,$end,$model->time_start_date , $model->time_end_date);


                // if($Meeting == null){
                // 	$this->render('create',array(
                // 		'model'=>$model,
                // 	));
                // }

                // $model->url_join_meeting = $Meeting;

                $model->start_date = date_format(date_create($str." ".$model->time_start_date), "Y-m-d H:i:s");
                $model->end_date = date_format(date_create($end." ".$model->time_end_date), "Y-m-d H:i:s");
                // 2022-01-23 20:57:00

                if($model->save())
                {
                	if(Yii::app()->user->id){
                		Helpers::lib()->getControllerActionId();
                	}

                	$time = date("dmYHis");
                	$intro_video = CUploadedFile::getInstance($model, 'intro_video');
                	$uploadFile = CUploadedFile::getInstance($model, 'intro_video');

                	if (isset($uploadFile)) {
                		$beautifulName = $time.$model->id."_On.".$uploadFile->extensionName;
                		$model->intro_video = $beautifulName;
                	}

                	if(isset($intro_video))
                	{
                		$tempSave = CUploadedFile::getInstance($model, 'intro_video');
                		$fileName = $beautifulName;
                		$model->intro_video = $fileName;
                		$Pathuploadfile = Yii::app()->basePath.'/../../uploads/msonline/'.$fileName;

						if(!empty($tempSave))  
						{
							$tempSave->saveAs($Pathuploadfile);
						} else {
							var_Dump($model->getErrors());
							exit();
						}
					}
					$model->save(false);


                	if(isset($ms_teams_picture))
                	{
						/////////// SAVE IMAGE //////////
                		Yush::init($model);
                		$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->ms_teams_picture);
                		$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->ms_teams_picture);
                		$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->ms_teams_picture);
			            // Save the original resource to disk
                		$ms_teams_picture->saveAs($originalPath);

			            // Create a small image
                		$smallImage = Yii::app()->phpThumb->create($originalPath);
                		$smallImage->resize(110);
                		$smallImage->save($smallPath);

			            // Create a thumbnail
                		$thumbImage = Yii::app()->phpThumb->create($originalPath);
                		$thumbImage->resize(250);
                		$thumbImage->save($thumbPath);

                	}

                	$this->redirect(array('index'));
                }
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
		$old_vdo_path = $model->intro_video;
		$imageShow = $model->ms_teams_picture;
		if(isset($_POST['MsOnline']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['MsOnline'];
			$ms_teams_picture = CUploadedFile::getInstance($model, 'ms_teams_picture');
			if(!empty($ms_teams_picture)){
				$fileNamePicture = $time."_Picture.".$ms_teams_picture->getExtensionName();
				$model->ms_teams_picture = $fileNamePicture;
			}

			if($model->validate())
			{

                $str = $model->start_date;
                $end = $model->end_date;

                $model->start_date = date_format(date_create($str." ".$model->time_start_date), "Y-m-d H:i:s");
                $model->end_date = date_format(date_create($end." ".$model->time_end_date), "Y-m-d H:i:s");

				if($model->save())
				{
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}

					if( !isset($_POST['MsOnline'][intro_video]) ){
						$model->intro_video = $old_vdo_path;
					}

					$time = date("dmYHis");
					$intro_video = CUploadedFile::getInstance($model, 'intro_video');
					$uploadFile = CUploadedFile::getInstance($model, 'intro_video');

					if (isset($uploadFile)) {
						$beautifulName = $time.$model->id."_On.".$uploadFile->extensionName;
						$model->intro_video = $beautifulName;
					}

					if(isset($intro_video))
					{
						$tempSave = CUploadedFile::getInstance($model, 'intro_video');
						$fileName = $beautifulName;
						$model->intro_video = $fileName;
						$Pathuploadfile = Yii::app()->basePath.'/../../uploads/msonline/'.$fileName;

						if(!empty($tempSave))  
						{
							$tempSave->saveAs($Pathuploadfile);
						} else {
							var_Dump($model->getErrors());
							exit();
						}
					}

					$model->save(false);


					if(isset($ms_teams_picture))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->ms_teams_picture);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->ms_teams_picture);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->ms_teams_picture);
			            // Save the original resource to disk
						$ms_teams_picture->saveAs($originalPath);

			            // Create a small image
						$smallImage = Yii::app()->phpThumb->create($originalPath);
						$smallImage->resize(110);
						$smallImage->save($smallPath);

			            // Create a thumbnail
						$thumbImage = Yii::app()->phpThumb->create($originalPath);
						$thumbImage->resize(250);
						$thumbImage->save($thumbPath);

					}

					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow

		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		$model->active = 'n';
		//var_dump($model);exit();
		if($model->ms_teams_picture != '')
			Yii::app()->getDeleteImageYush('msteams',$model->id,$model->ms_teams_picture);

		$model->ms_teams_picture = null;
		$model->save(false);

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new MsOnline('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MsOnline']))
			$model->attributes=$_GET['MsOnline'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MsOnline('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MsOnline']))
			$model->attributes=$_GET['MsOnline'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MsOnline the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MsOnline::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MsOnline $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ms-teams-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
