<?php

class ExamsOnlineController extends Controller
{

  public function init()
    {
      parent::init();

    if (Yii::app()->user->id == null) {

        Yii::app()->user->setFlash('msg','Please log in');
        Yii::app()->user->setFlash('icon','warning');

        $this->redirect(array('site/index'));
        exit();
    }


    $this->lastactivity();
}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        	$criteria = new CDbCriteria;
            $criteria->with = array('teams');
            $criteria->compare('teams.active','y');
            $criteria->compare('user_id',Yii::app()->user->id);
            // $criteria->compare('t.status','y');
            $criteria->addCondition('teams.end_date >= :date_now');
            $criteria->params[':date_now'] = date('Y-m-d H:i');
            $criteria->order = 'teams.id';
            $modelTemp = OnlineTemp::model()->findAll($criteria);

            foreach ($modelTemp as $keytemp => $valTemp) {
                $teams_id[] = $valTemp->ms_teams_id;
            }
            
                $criteria = new CDbCriteria;
                $criteria->addIncondition('id',$teams_id);
                if(isset($_POST["course_title"])){
                	$criteria->compare('name_ms_teams',$_POST["course_title"],true);
                }
                $criteria->compare('active', 'y');
                if($_POST["sort"] == 2){
                	$criteria->order = 'id ASC';
                }else{
                	$criteria->order = 'id DESC';
                }
		$MsTeams = MsOnline::model()->findAll($criteria);

		$this->render('index',array('MsTeams'=>$MsTeams,'textold'=>$_POST["course_title"]));
	}


	public function actionDetail($id) {

    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }
 
    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
    }

      $label = MenuCourse::model()->find(array(
        'condition' => 'lang_id=:lang_id',
        'params' => array(':lang_id' => $langId)
    ));
    if(!$label){
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => 1)
        ));
    }

    $course = MsOnline::model()->findByPk($id);
    $lessonList = LessonOnline::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND ms_teams_id=' . $id, 'order' => 'lesson_no'));
    
    $user = Yii::app()->getModule('user')->user();

            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);

            if (!empty(Yii::app()->user->id)) {
                $gen_id = 0;
                $logtime = LogStartOnline::model()->find(array(
                    'condition'=>'ms_teams_id=:id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
                    'params' => array(':id' => $id, ':user_id' => Yii::app()->user->id , ':active' => 'y', ':gen_id'=>$gen_id)
                ));

                if (empty($logtime)) {
     
                        $now = date('Y-m-d H:i:s');

                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create(date_format(date_create($course->end_date),"Y-m-d"));
                        $diff=date_diff($date1,$date2);
                        $day =  $diff->format("%a");

                        $logtime = new LogStartOnline;
                        $logtime->user_id = Yii::app()->user->id;
                        $logtime->ms_teams_id = $id;
                        $logtime->start_date = $now;
                        $logtime->end_date = date_format(date_create($course->end_date),"Y-m-d");
                        $logtime->course_day = $day;
                        $logtime->gen_id = $gen_id;
                        $logtime->save();


                }else if(!empty($logtime)){
                    if(date_format(date_create($logtime->end_date),"Y-m-d") != date_format(date_create($course->end_date),"Y-m-d")) {
                    	$date1=date_create(date('Y-m-d'));
                        $date2=date_create(date_format(date_create($course->end_date),"Y-m-d"));
                        $diff=date_diff($date1,$date2);
                        $days =  $diff->format("%a");

                        $logtime->end_date = date_format(date_create($course->end_date),"Y-m-d");
                        $logtime->course_day = $days;
                        $logtime->save();
                    }
                }
            }

            if($logtime){

            	$courseDateExpire =  $course->end_date;
            	$dateStart=date_create();
            	$dateEnd=date_create($logtime->end_date);
            	$diff=date_diff($dateStart,$dateEnd);
            	$diff = $diff->format("%a");
            if($diff < 0 || (date('Y-m-d') > date($courseDateExpire))){//$course->course_date_end
                //set Flash
            	Yii::app()->user->setFlash('msg', 'คุณหมดเวลาเรียนแล้ว');
            	$this->redirect(array('course/bookingcourse'));
            }
            
        }

        $this->render('detail', array(
            'lessonList' => $lessonList,
            'course' => $course,
            'label' => $label,
            'logtime' => $logtime,
            'diff' => $diff,
        ));
    }




    public function actionBookingexamsonline(){


        $teams_none = [];

        $criteriaTemp = new CDbCriteria;
        $criteriaTemp->compare('status','y');
        $criteriaTemp->compare('user_id',Yii::app()->user->id);
        $teamsTemp = OnlineTemp::model()->findAll($criteriaTemp);

         foreach ($teamsTemp as $keyste => $valte) {
            $teams_none[] = $valte->ms_teams_id;
        }


        $criteria = new CDbCriteria;
        $criteria->addNotIncondition('id',$teams_none);
        $criteria->compare('active', 'y');
        $criteria->addCondition('end_date >= :date_now');
        $criteria->params[':date_now'] = date('Y-m-d H:i');
        $criteria->order = 'name_ms_teams ASC';
        $MsOnline = MsOnline::model()->findAll($criteria);

                                                            
     $this->render('bookingcourse',array('msteams'=>$MsOnline));       

    }

    // $id
    public function actionBookingexamsDetail($id){
        $teams = MsOnline::model()->findByPk($id);

        $this->render('bookingteamsdetail',array('teams'=>$teams));                                             
    }


     public function actionBookingMsTeamsSave(){

        $id = $_POST["course_id"];
        $type_price = $_POST["type_price"];
        $tempoldid = $_POST["tempoldid"];


         $course = MsOnline::model()->find(array(
            'condition'=>'id=:id ',
            'params' => array(':id' => $id)
        ));

        $course = MsOnline::model()->findByPk($id);

        $gen_id = 0;
        $modelOld = OnlineTemp::model()->find(
            array(
                'condition' => 'ms_teams_id=:ms_teams_id AND user_id=:user_id AND gen_id=:gen_id',
                'params' => array(':ms_teams_id'=>$id, ':user_id'=>Yii::app()->user->id, ':gen_id'=>$gen_id)
            )
        );

        if(!$modelOld){
          $model = new OnlineTemp;
          $model->ms_teams_id = $id;
          $model->gen_id = $gen_id;
          $model->user_id = Yii::app()->user->id;
          $model->create_date = date('Y-m-d H:i:s');
          $model->type_price = $type_price;


          if ($_FILES['file_payment']['tmp_name'] != "") {
            $tempFile   = $_FILES['file_payment'];
            $path = "coursepayment";
            $uploadDir = Yii::app()->getUploadPath(null);
            $uploadDir = $uploadDir.'../';

            if (!is_dir($uploadDir.$path."/")) {
                mkdir($uploadDir.$path."/", 0777, true);
            }

            $uploadDir = $uploadDir.$path."/";
            $fileParts = pathinfo($tempFile['name']);
            $fileType = strtolower($fileParts['extension']);
            $rnd = rand(0,999999999);
            $fileName = "{$rnd}-.".$fileType;
            $targetFile = $uploadDir.$fileName;
            if (file_put_contents($targetFile,file_get_contents($tempFile["tmp_name"]))) {
              $model->file_payment = $fileName;

          }
      }

            if($type_price == 0){
                $model->status = 'y';
            }else{
                $model->status = 'n';
            }   

            if($model->save(false)){
                $this->redirect(array('course/bookingcourse'));
            }
        }else{
            if($tempoldid != ""){


                $courseTemp = OnlineTemp::model()->findByPk((int)$tempoldid);

                if ($_FILES['file_payment']['tmp_name'] != "") {
                    $tempFile   = $_FILES['file_payment'];
                    $path = "coursepayment";
                    $uploadDir = Yii::app()->getUploadPath(null);
                    $uploadDir = $uploadDir.'../';

                    if (!is_dir($uploadDir.$path."/")) {
                        mkdir($uploadDir.$path."/", 0777, true);
                    }

                    $uploadDir = $uploadDir.$path."/";
                    $fileParts = pathinfo($tempFile['name']);
                    $fileType = strtolower($fileParts['extension']);
                    $rnd = rand(0,999999999);
                    $fileName = "{$rnd}-.".$fileType;
                    $targetFile = $uploadDir.$fileName;
                    if (file_put_contents($targetFile,file_get_contents($tempFile["tmp_name"]))) {
                      $courseTemp->file_payment = $fileName;
                  }
              }
              if($courseTemp->save(false)){
                  $this->redirect(array('course/bookingcourse'));
              }
            }
              $this->redirect(array('course/bookingcourse'));
        }
      
    $this->redirect(array('course/bookingcourse'));
    
    }


	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}