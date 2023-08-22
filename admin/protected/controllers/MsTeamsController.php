<?php

class MsTeamsController extends Controller
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
            	'actions' => array('index', 'view','MultiDelete','update','delete','create','SetNameCode'),
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

		$model=new MsTeams;
		 $attendees = array('type' => 'required','status'=> array('response' => 'none', 'time'=> '0001-01-01T00:00:00Z'),'emailAddress' =>array('name' => 'Test', 'address'=> 'aiyakarn2540@gmail.com') );
		 $messageError = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MsTeams']))
		{

			$time = date("dmYHis");
			$model->attributes=$_POST['MsTeams'];
			$ms_teams_picture = CUploadedFile::getInstance($model, 'ms_teams_picture');
			if(!empty($ms_teams_picture)){
				$fileNamePicture = $time."_Picture.".$ms_teams_picture->getExtensionName();
				$model->ms_teams_picture = $fileNamePicture;
			}


			if($model->isNameSameCode == "n"){
				$code = MtCodeMd::model()->find(array(
					'condition'=>'code_md=:code_md ',
					'params' => array(':code_md' => $model->course_md_code)
				));
				if($code){
					$model->name_ms_teams = $code->name_md;
					$model->course_md_gm = $code->code_gm;
				}
			}

			$statusCheckTime = json_decode($this->checkTime($model->start_date,$model->end_date,$model->time_start_date,$model->time_end_date,$model->hostmail));
			if($statusCheckTime->status == "false"){
				$messageError = $statusCheckTime->date_duplicate;
			}
			if($model->validate() && $statusCheckTime->status == "true")
			{

               	$str = $model->start_date;
               	$end = $model->end_date;

               	$type = "zoom";
               	// $type = "msteam";

               	if($type == "msteam"){
               		$token = Helpers::lib()->sendApiToken();
               		$Meeting = Helpers::lib()->sendApiCreateMeeting($token ,$model->name_ms_teams,$model->detail_ms_teams,$str,$end,$model->time_start_date , $model->time_end_date);


               		if($Meeting == null){
               			$this->render('create',array(
               				'model'=>$model,
               			));
               		}
               		$model->url_join_meeting = $Meeting;
               	}elseif($type == "zoom"){
               		$phpZoomPath = Yii::getPathOfAlias('ext.zoom');
               		include($phpZoomPath . DIRECTORY_SEPARATOR . 'Zoom_Api.php');
               		$zoom_meeting = new Zoom_Api();

               		$start_date = date_format(date_create($model->start_date." ".$_POST["MsTeams"]["time_start_date"]), "Y-m-d H:i:s");
               		$end_date = date_format(date_create($model->end_date." ".$_POST["MsTeams"]["time_end_date"]), "Y-m-d H:i:s");
               		$data = array();
               		$data['topic'] 		= $_POST["MsTeams"]["name_ms_teams"];
               		$data['start_date'] = $start_date;
               		$data['end_date'] = $end_date;
               		$data['duration'] 	= $_POST["MsTeams"]["duration"];
               		$data['type'] 		= 8;
               		$hostModel = ZoomHosting::model()->findByPk($model->hostmail);
               		$host = $hostModel->hostmail;
               		$response = $zoom_meeting->createMeeting($data,$host);
               		$model->duration=$response->occurrences[0]->duration;
               		$model->url_join_meeting=$response->join_url;
               	}

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
                		$beautifulName = $time.$model->id."_Ms.".$uploadFile->extensionName;
                		$model->intro_video = $beautifulName;
                	}

                	if(isset($intro_video))
                	{
                		$tempSave = CUploadedFile::getInstance($model, 'intro_video');
                		$fileName = $beautifulName;
                		$model->intro_video = $fileName;
                		$Pathuploadfile = Yii::app()->basePath.'/../../uploads/msteams/'.$fileName;

						if(!empty($tempSave))  
						{
							$tempSave->saveAs($Pathuploadfile);
						} else {
							var_Dump($model->getErrors());
							exit();
						}
					}
					$model->type_ms_teams = 1; // 1 = ออนไลน์ 2 = ออนไลน์(สถาบัน)
					$model->status_ms_teams = 1; // 1 = ออนไลน์ 2 = ออนไลน์(สถาบัน)
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
			'model'=>$model,'messageError'=>$messageError
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
		if(isset($_POST['MsTeams']))
		{
			$time = date("dmYHis");
			$model->attributes=$_POST['MsTeams'];
			$ms_teams_picture = CUploadedFile::getInstance($model, 'ms_teams_picture');
			if(!empty($ms_teams_picture)){
				$fileNamePicture = $time."_Picture.".$ms_teams_picture->getExtensionName();
				$model->ms_teams_picture = $fileNamePicture;
			}

				$code = MtCodeMd::model()->find(array(
					'condition'=>'code_md=:code_md ',
					'params' => array(':code_md' => $model->course_md_code)
				));
				if($code){
					if($model->isNameSameCode == "n"){
						$model->name_ms_teams = $code->name_md;
					}
					$model->course_md_gm = $code->code_gm;
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

					if( !isset($_POST['MsTeams'][intro_video]) ){
						$model->intro_video = $old_vdo_path;
					}

					$time = date("dmYHis");
					$intro_video = CUploadedFile::getInstance($model, 'intro_video');
					$uploadFile = CUploadedFile::getInstance($model, 'intro_video');

					if (isset($uploadFile)) {
						$beautifulName = $time.$model->id."_Ms.".$uploadFile->extensionName;
						$model->intro_video = $beautifulName;
					}

					if(isset($intro_video))
					{
						$tempSave = CUploadedFile::getInstance($model, 'intro_video');
						$fileName = $beautifulName;
						$model->intro_video = $fileName;
						$Pathuploadfile = Yii::app()->basePath.'/../../uploads/msteams/'.$fileName;

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

	public function actionSetNameCode()
	{
		$id = $_POST['code'];

		$code = MtCodeMd::model()->findAll(array(
            'condition'=>'code_md=:code_md ',
            'params' => array(':code_md' => $id)
        ));
		$data = [];
		foreach($code as $c){
			$data['code_md'] = $c->code_md;
			$data['name_md'] = $c->name_md;
		}
		echo json_encode($data,true);

	}

	public function actionCheckTimeZoom()
	{
		
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$time_start_date = $_POST["time_start_date"];
		$time_end_date = $_POST["time_end_date"];
		$hostmail = $_POST["hostmail"];
        echo $this->checkTime($start_date,$end_date,$time_start_date,$time_end_date,$hostmail);
        exit();
	}

	public function checkTime($start_date,$end_date,$time_start_date,$time_end_date,$hostmail)
	{
		$start_date = $start_date;
		$end_date = $end_date;
		$time_start_date = $time_start_date;
		$time_end_date = $time_end_date;
		$hostmail = $hostmail;
		$array_alldays = $this->getTimePeroid($start_date,$end_date,$time_start_date,$time_end_date);

		$criteria = new CDbCriteria;
        $criteria->compare('hostmail',$hostmail);
        $criteria->compare('active','y');
        $meetings = MsTeams::model()->findAll($criteria);
        foreach ($meetings as $keyMeet => $valueMeet) {
        	$start = new DateTime($valueMeet->start_date);
        	$end = new DateTime($valueMeet->end_date);
        	$start_date_meet = $start->format('Y-m-d');
        	$end_date_meet = $end->format('Y-m-d');
        	$time_start_date_meet = $start->format('H:i:s');
        	$time_end_date_meet = $end->format('H:i:s');
        	$array_alldays_meet = $this->getTimePeroid($start_date_meet,$end_date_meet,$time_start_date_meet,$time_end_date_meet);
        	foreach ($array_alldays_meet as $key => $value) {
        		if(in_array($value,$array_alldays)){
        			return json_encode(["status"=>"false","date_duplicate"=>$value]);
        		}
        	}
        }
        return json_encode(["status"=>"true","date_duplicate"=>null]);
	}

	public function getTimePeroid($start_date,$end_date,$time_start_date,$time_end_date)
	{
		$date_start = new DateTime($start_date);
		$date_end = new DateTime($end_date);
		$interval = $date_start->diff($date_end);
		$array_alldays = [];
		if($interval->days == 0){
			$day_start = new DateTime($start_date." ".$time_start_date);
			$day_end = new DateTime($start_date." ".$time_end_date);
			$intervalTime = $day_start->diff($day_end);
			for ($i=0; $i <= $intervalTime->h ; $i++) { 
				$array_alldays[] = $day_start->format('Y-m-d H:i:s');
				$day_start->add(new DateInterval('PT1H0M0S'));
			}
		}else{
			$day_start1 = date_create($start_date." ".$time_start_date);
			$day_end1 = date_create($start_date." ".$time_end_date);
			$intervalTime = $day_start1->diff($day_end1);
			$day_start_Main = date_create($start_date);
			$day_end_main = date_create($end_date);
			$intervalDay = $day_start_Main->diff($day_end_main);
			for ($i=0; $i <= $intervalDay->days ; $i++) { 
				$daytime1 = date_create($day_start_Main->format('Y-m-d')." ".$time_start_date);
				for ($j=0; $j <= $intervalTime->h ; $j++) { 
					$array_alldays[] = $daytime1->format('Y-m-d H:i:s');
					$daytime1->add(new DateInterval('PT1H0M0S'));
				}
				$day_start_Main->add(new DateInterval('P1D'));
			}
		}
		return $array_alldays;
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new MsTeams('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MsTeams']))
			$model->attributes=$_GET['MsTeams'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MsTeams('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MsTeams']))
			$model->attributes=$_GET['MsTeams'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MsTeams the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MsTeams::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MsTeams $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ms-teams-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionStatusMsteam(){
		$id = $_POST['id'];
		$model = MsTeams::model()->findByPk($id);
        if($model->status_ms_teams == 1){
			$model->status_ms_teams = 0;
		}else{
			$model->status_ms_teams = 1;
		}
		$model->save(false);
	}

	public function actionUploadZoom($id){
		$this->render('uploadZoom',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionUploadImageZoom(){
		$path = 'msteam_upload';

        $uploadDir = Yii::app()->getUploadPath(null);
        $uploadDir = $uploadDir.'../';

        if (!is_dir($uploadDir.$path."/")) {
            mkdir($uploadDir.$path."/", 0777, true);
        }

        if (!is_dir($uploadDir.$path."/".$_POST['ms_teams_id']."/")) {
            mkdir($uploadDir.$path."/".$_POST['ms_teams_id']."/", 0777, true);
        }
		$save = [];
		for ($i=0; $i < count($_FILES["picture__input"]["name"]) ; $i++) {
			$date = $_POST['date']." ".$_POST['time'][$i];
			$timestamp = strtotime($date);
			$file_name = $_POST['ms_teams_id'].'-'.$timestamp;
			$file_extension = '.jpg';
			$full_path = $uploadDir.$path."/".$_POST['ms_teams_id']."/".$file_name.$file_extension;
			$success = file_put_contents($full_path, file_get_contents($_FILES["picture__input"]["tmp_name"][$i]));

			if($success){
				$model = new UploadMsTeams();
				$model->user_id = $_POST['user_id'];
				$model->ms_teams_id = $_POST['ms_teams_id'];
				$model->file_name = $file_name ;
				$model->active = "y" ;
				$model->upload_date = $_POST['date']." ".$_POST['time'][$i] ;
				$model->create_date = date("Y-m-d h:i:s");
				$model->update_date = date("Y-m-d h:i:s");
				$save[] = $model->save(false);	
			}else{
				$save[] = false;
			}
		
		}

		if(in_array(false, $save) ){
			echo 'false';
		}else{
			echo 'true';
		}
	
		
		
	
	}




	public function actionSendNotiByTeacher(){
		$course_id = $_POST['course_id'];
		$lesson_id = 0;
		$zoom_url = $_POST['zoom_url'];
		Helpers::lib()->sendNotiByTeacher($course_id,$lesson_id,'sercetAuthenMd',$zoom_url);
	}


}
