<?php

class LearnResetController extends Controller
{
    public function init()
    {
        // parent::init();
        // $this->lastactivity();
        if(Yii::app()->user->id == null){
                $this->redirect(array('site/index'));
            }
        
    }

    public function filters(){
        return array( 'accessControl');
    }



    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('reset_user', 'view', 'get_dialog_learn', 'get_dialog_exam', 'resetdetail'),
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



    public function actionResetUser()   // หน้าแรก
    {

        // $criteria = new CDbCriteria;
        // // $criteria->join = 'LEFT JOIN tbl_score a ON user.id = a.user_id'; 
        // $criteria->with = array('courseScore','score');
        // $criteria->group = 'courseScore.user_id , score.user_id';
        // $userAll = User::model()->findAll($criteria);
        // $arrScore = array();
        // $arrCourseScore = array();
        // foreach($userAll as $value){

        //     foreach($value->courseScore as $cs){
        //         $arrCourseScore[] = $cs->user_id;
        //     }

        //     foreach($value->score as $s){
        //         $arrScore[] = $s->user_id;
        //     }
        // }
        // $arrUser =  array_unique( array_merge($arrCourseScore, $arrScore) );
        // // $unique=array_unique( array_merge($arrCourseScore, $arrScore) );
        // // $master_arr =array_diff($unique, $arrCourseScore);
        // $criteria = new CDbCriteria;
        // $criteria->with = array('profile');
        // $criteria->addInCondition('id', $arrUser);    
        // $model = User::model()->findAll($criteria);
        // print_r($model);
        // print_r($arrScore);

        $model = new User('searchReset');
        if(isset($_GET['Learn'])){
            $model->attributes = $_GET['Learn'];
            $model->searchname = $_GET['Learn']['searchname'];
        }

        $this->render('reset_user',array(
            'model'=>$model,
        ));
    }




    public function actionSaveResetPre() {  // Reset สอบก่อนเรียน บทเรียน
        $user_id = $_POST['id'];
        $lesson = json_decode($_POST['checkedList']);
        $reset_type = $_POST['reset_type'];
        $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ข้อมูลการเรียนบทเรียนต่อไปนี้ <br>';

        foreach ($lesson as $key => $value) {
            $val = array();
            $val = explode(",", $value);
            $course_id = $val[0];
            $lesson_id = $val[1];
            $learn_id = $val[2];
            $gen_id = $val[3];


            $logReset = new LogReset;
            $logReset->user_id = $user_id;
            $logReset->course_id = $course_id;
            $logReset->lesson_id = $lesson_id;
            $logReset->gen_id = $gen_id;
            $logReset->reset_description = $_POST['description'];
            $logReset->reset_date = date('Y-m-d h:i:s');
            $logReset->reset_by = Yii::app()->user->id;
            $logReset->reset_type = 2;

            if ($logReset->save()){
                // $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '"');

                $score = Score::model()->findAllByAttributes(array(
                    'user_id' => $user_id,
                    'lesson_id' => $lesson_id,
                    'course_id' => $course_id,
                    'gen_id' => $gen_id,
                    //'type'=>'pre',
                    'active' => 'y'
                ));

            foreach ($score as $key1 => $sc) {
                $sc->active = 'n';
                $sc->save(false);

                Logques::model()->deleteAll(array(
                    'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));

                Logchoice::model()->deleteAll(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson_id,':user_id' => $user_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));
            }

            $learn = Learn::model()->findAllByAttributes(array(
                'user_id' => $user_id,
                'lesson_id' => $lesson_id,
                'course_id' => $course_id,
                'gen_id' => $gen_id,
                'lesson_active' => 'y'
            ));

            foreach ($learn as $key => $data) {
                $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '" AND gen_id="'.$gen_id.'"');

                $LearnNote = LearnNote::model()->findAll('user_id="' . $user_id . '" AND gen_id="'.$gen_id.'"');

                foreach ($LearnNote as $key => $value_note) {
                    $value_note->active = 'n';
                    $value_note->save(false);
                }

                $data->lesson_status = null;
                $data->lesson_active = 'n';
                $data->save(false);

            }

            //Reset Course    exam final
            $courseScore = Coursescore::model()->findAll(array(
                'condition' => 'course_id=:course_id AND user_id=:user_id AND active = "y" AND gen_id=:gen_id AND type="post"',
                'params' => array(':course_id' => $course_id,':user_id' => $user_id, ':gen_id'=>$gen_id)
            ));

            foreach ($courseScore as $valScore) {

               Courselogques::model()->deleteAll(array(
                'condition' => 'user_id=:user_id AND course_id=:course_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':user_id' => $user_id,':course_id' => $course_id,':score_id'=>$valScore->score_id, ':gen_id'=>$gen_id)));

               Courselogchoice::model()->deleteAll(array(
                'condition' => 'course_id=:course_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':course_id' => $course_id,':user_id' => $user_id,':score_id'=>$valScore->score_id, ':gen_id'=>$gen_id)));

               $valScore->active = 'n';
               $valScore->save();
            }

            }else{
                var_dump($logReset->getErrors());
            }

            $lessonS = Lesson::model()->findByPk($lesson_id);
            $courseMsg .= ($key+1).". <b>หลักสูตร : </b> ".$lessonS->courseonlines->course_title.'<br> <b>บทเรียน : </b>'.$lessonS->title.'<br>';
            $reset_type = $_POST['reset_type'];

        }

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        $courseMsg .= '<br><span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
        $model = Users::model()->findByPk($user_id);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profiles->firstname;
        $to['lastname'] = $model->profiles->lastname;
        $subject = 'แจ้งเตือน ระบบ reset สอบวัดผลก่อนเรียน';
        $message = "หัวช้อ : แจ้งเตือนระบบ reset <br> <br>";
        $message .= "เรียน ".$model->profiles->firstname." ".$model->profiles->lastname."<br> <br>";
        $message .= "<div style=\"text-indent: 4em;\">";
        $message .= $courseMsg."</div>";
        $send = Helpers::lib()->SendMail($to,$subject,$message);

        echo $reset_type;
    }



    public function actionSaveResetLearn()  // Reset การเรียน
    {
        $user_id = $_POST['id'];
        $lesson = json_decode($_POST['checkedList']);
        $reset_type = $_POST['reset_type'];        
        $courseMsg = ""; // $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ข้อมูลการเรียนบทเรียนต่อไปนี้ <br>';
        $courseMsg_en = "";

        foreach ($lesson as $key => $value) {
            $val = array();
            $val = explode(",", $value);
            $course_id = $val[0];
            $lesson_id = $val[1];
            $learn_id = $val[2];
            $gen_id = $val[3];

            $logReset = new LogReset;
            $logReset->user_id = $user_id;
            $logReset->course_id = $course_id;
            $logReset->lesson_id = $lesson_id;
            $logReset->gen_id = $gen_id;
            $logReset->reset_description = $_POST['description'];
            $logReset->reset_date = date('Y-m-d h:i:s');
            $logReset->reset_by = Yii::app()->user->id;
            $logReset->reset_type = '0';

            if ($logReset->save()){

                $learn = Learn::model()->findAllByAttributes(array(
                    'user_id' => $user_id,
                    'lesson_id' => $lesson_id,
                    'gen_id' => $gen_id,
                    'course_id' => $course_id,
                    'lesson_active' => 'y'
                ));

                if ($learn) {
                    foreach ($learn as $key => $data) {
                        $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '" AND gen_id="'.$gen_id.'"');
                        $LearnNote = LearnNote::model()->findAll('user_id="' . $user_id . '" AND gen_id="'.$gen_id.'"');
                        foreach ($LearnNote as $key => $value_note) {
                            $value_note->active = 'n';
                            $value_note->save(false);
                        }
                        $score = Score::model()->findAllByAttributes(array(
                            'user_id' => $user_id,
                            'lesson_id' => $lesson_id,
                            'course_id' => $course_id,
                            'gen_id' => $gen_id,
                            // 'type'=>'post',
                            'active' => 'y'
                        ));
                        foreach ($score as $key1 => $sc) {
                            $sc->active = 'n';
                            $sc->save(false);

                            Logques::model()->deleteAll(array(
                                'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                                'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));

                            Logchoice::model()->deleteAll(array(
                                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                                'params' => array(':lesson_id' => $lesson_id,':user_id' => $user_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));
                        }

                        $data->lesson_status = null;
                        $data->lesson_active = 'n';
                        $data->save(false);

                    }

                     //Reset Course    exam final
                    $courseScore = Coursescore::model()->findAll(array(
                        'condition' => 'course_id=:course_id AND user_id=:user_id AND gen_id=:gen_id AND type="post"',
                        'params' => array(':course_id' => $course_id,':user_id' => $user_id, ':gen_id'=>$gen_id)
                    ));

                    foreach ($courseScore as $valScore) {
                       $valScore->active = 'n';
                       $valScore->save();
                   }

                }

            }else{
                var_dump($logReset->getErrors());
            }

            Passcours::model()->deleteAll(array(
                'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:passcours_user AND gen_id=:gen_id',
                'params' => array(':passcours_cours' => $course_id,':passcours_user' => $user_id, ':gen_id'=>$gen_id)));

            $reset_type = $_POST['reset_type'];

            $lessonS = Lesson::model()->findByPk($lesson_id);
            $courseMsg .= ($key+1).". <b>หลักสูตร : </b> ".$lessonS->courseonlines->course_title.'<br> <b>บทเรียน : </b>'.$lessonS->title.'<br>';
            $courseMsg_en .= ($key+1).". <b>Course : </b> ".$lessonS->courseonlines->course_title.'<br> <b>Chapter : </b>'.$lessonS->title.'<br>';
        }

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        $courseMsg .= '<span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
        $courseMsg_en .= '<span style="color:red">Reason : '.$_POST['description'].'</span>';
        $model = Users::model()->findByPk($user_id);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profiles->firstname;
        $to['lastname'] = $model->profiles->lastname;
        $subject = 'Study reset system\ ระบบการแจ้งเตือน Reset การเรียน';
        $message = "เรื่อง : แจ้งเตือนการ Reset การเรียน <br>";
        $message .= "เรียน ".$model->profiles->firstname." ".$model->profiles->lastname."<br>";
        $message .= "ผู้ดูแลระบบดำเนินการ Reset การเรียนของหลักสูตรดังต่อไปนี้ <br>";
        // $message .= "<div style=\"text-indent: 4em;\">";
        $message .= $courseMsg;

        $message .= "<br>Subject: Study reset notification.<br>";
        $message .= "Dear: ".$model->profiles->firstname_en." ".$model->profiles->lastname_en."<br>";
        $message .= "The administrator has performs a reset of course study as follows.<br>";
        // $message .= "<div style=\"text-indent: 4em;\">";
        $message .= $courseMsg_en;

        $send = Helpers::lib()->SendMail($to,$subject,$message);

        echo $reset_type;

    }


    public function actionSaveResetPost() // Reset สอบหลังเรียน บทเรียน
    {
        $user_id = $_POST['id'];
        $lesson = json_decode($_POST['checkedList']);
        $reset_type = $_POST['reset_type'];
        $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ข้อมูลการเรียนบทเรียนต่อไปนี้ <br>';

        foreach ($lesson as $key => $value) {
            $val = array();
            $val = explode(",", $value);
            $course_id = $val[0];
            $lesson_id = $val[1];
            $learn_id = $val[2];
            $gen_id = $val[3];

            $logReset = new LogReset;
            $logReset->user_id = $user_id;
            $logReset->course_id = $course_id;
            $logReset->gen_id = $gen_id;
            $logReset->lesson_id = $lesson_id;
            $logReset->reset_description = $_POST['description'];
            $logReset->reset_date = date('Y-m-d h:i:s');
            $logReset->reset_by = Yii::app()->user->id;
            $logReset->reset_type = 3;

            if ($logReset->save()){
                // $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '"');

                $score = Score::model()->findAllByAttributes(array(
                    'user_id' => $user_id,
                    'lesson_id' => $lesson_id,
                    'gen_id' => $gen_id,
                    'course_id' => $course_id,
                    'type'=>'post',
                    'active' => 'y'
                ));

            foreach ($score as $key1 => $sc) {
                $sc->active = 'n';
                $sc->save(false);

                Logques::model()->deleteAll(array(
                    'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));

                Logchoice::model()->deleteAll(array(
                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':lesson_id' => $lesson_id,':user_id' => $user_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));
            }


                $learn = Learn::model()->findAllByAttributes(array(
                    'user_id' => $user_id,
                    'lesson_id' => $lesson_id,
                    'course_id' => $course_id,
                    'gen_id' => $gen_id,
                    'lesson_active' => 'y'
                ));

                foreach ($learn as $key => $data) {
                    $data->lesson_status = null;
                    $data->save(false);
                }


                 //Reset Course    exam final
                $courseScore = Coursescore::model()->findAll(array(
                    'condition' => 'course_id=:course_id AND user_id=:user_id AND active = "y" AND gen_id=:gen_id AND type="post"',
                    'params' => array(':course_id' => $course_id,':user_id' => $user_id, ':gen_id'=>$gen_id)
                ));


                foreach ($courseScore as $valScore) {

                   Courselogques::model()->deleteAll(array(
                    'condition' => 'user_id=:user_id AND course_id=:course_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':user_id' => $user_id,':course_id' => $course_id,':score_id'=>$valScore->score_id, ':gen_id'=>$gen_id)));

                   Courselogchoice::model()->deleteAll(array(
                    'condition' => 'course_id=:course_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                    'params' => array(':course_id' => $course_id,':user_id' => $user_id,':score_id'=>$valScore->score_id, ':gen_id'=>$gen_id)));

                   $valScore->active = 'n';
                   $valScore->save();
                }

            }else{
                var_dump($logReset->getErrors());
            }

            $lessonS = Lesson::model()->findByPk($lesson_id);
            $courseMsg .= ($key+1).". <b>หลักสูตร : </b> ".$lessonS->courseonlines->course_title.'<br> <b>บทเรียน : </b>'.$lessonS->title.'<br>';

            $reset_type = $_POST['reset_type'];

        } // foreach


        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }


        $courseMsg .= '<br><span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
        $model = Users::model()->findByPk($user_id);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profiles->firstname;
        $to['lastname'] = $model->profiles->lastname;
        $subject = 'แจ้งเตือน ระบบ reset สอบวัดผลหลังเรียน';
        $message = "หัวช้อ : แจ้งเตือนระบบ reset <br> <br>";
        $message .= "เรียน ".$model->profiles->firstname." ".$model->profiles->lastname."<br> <br>";
        $message .= "<div style=\"text-indent: 4em;\">";
        $message .= $courseMsg."</div>";
        $send = Helpers::lib()->SendMail($to,$subject,$message);

        echo $reset_type;
    }


    public function actionSaveResetExam()
    {
        $type_test = $_POST['type_test'];
        $user_id = $_POST['id'];
        $courseData = json_decode($_POST['checkedList']);
        $reset_type = $_POST['reset_type'];
        // $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ผลสอบวัดผลหลักสูตรต่อไปนี้ <br>';
        $courseMsg = "";
        $courseMsg_en = "";

        foreach ($courseData as $key => $value) {
            $ex = explode("_", $value);
            $value = $ex[0];
            $gen_id = $ex[1];
                    // $scoreLesson = Score::model()->deleteAll('user_id="' . Yii::app()->user->id . '" AND lesson_id="' . $value->id . '"');

            $logReset = new LogReset;
            $logReset->user_id = $user_id;
            $logReset->course_id = $value;
            $logReset->gen_id = $gen_id;
            $logReset->reset_description = $_POST['description'];
            $logReset->reset_date = date('Y-m-d h:i:s');
            $logReset->reset_type = 1;
            $logReset->reset_by = Yii::app()->user->id;

            if($logReset->save()){

                    if($type_test == 'pre'){ // หลักสูตร สอบก่อนเรียน

                        $score = Score::model()->findAllByAttributes(array(
                            'user_id' => $user_id,
                            'course_id' => $value,
                            'gen_id' => $gen_id,
                            'active' => 'y'
                        ));

                        foreach ($score as $key1 => $sc) {
                            $sc->active = 'n';
                            $sc->save(false);

                            Logques::model()->deleteAll(array(
                                'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                                'params' => array(':user_id' => $user_id,':lesson_id' => $sc->lesson_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));

                            Logchoice::model()->deleteAll(array(
                                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                                'params' => array(':lesson_id' => $sc->lesson_id,':user_id' => $user_id,':score_id'=>$sc->score_id, ':gen_id'=>$gen_id)));

                        } // foreach ($score


                        $learn = Learn::model()->findAllByAttributes(array(
                            'user_id' => $user_id,
                            'course_id' => $value,
                            'gen_id' => $gen_id,
                            'lesson_active' => 'y'
                        ));

                    foreach ($learn as $key => $data) {

                        $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '" AND gen_id="'.$gen_id.'"');

                        $LearnNote = LearnNote::model()->findAll('user_id="' . $user_id . '" AND gen_id="'.$gen_id.'"');
                        foreach ($LearnNote as $key => $value_note) {
                            $value_note->active = 'n';
                            $value_note->save(false);
                        }

                        $data->lesson_status = null;
                        $data->lesson_active = 'n';
                        $data->save(false);

                    } // foreach ($learn

                    $sql_text_type_post = "";
                    $sql_text2 = "";
                    $sql_text_type_course = "";

                }else{ // $type_test == 'pre'  // หลักสูตร สอบหลังเรียน

                    $sql_text_type_post = " AND type='post'";
                    $sql_text_type_course = " AND type='course'";
                    $sql_text2 = " AND test_type='post'";
                }


                $courseScore = Coursescore::model()->findAll(array(
                    'condition' => 'course_id=:course_id AND user_id=:user_id AND active = "y" AND gen_id=:gen_id'.$sql_text_type_post,
                    'params' => array(':course_id' => $value,':user_id' => $user_id, ':gen_id'=>$gen_id)
                ));
            

                TempCourseQuiz::model()->deleteAll(array(
                    'condition' => 'course_id=:course_id AND user_id=:user_id AND gen_id=:gen_id'.$sql_text_type_course,
                    'params' => array(':course_id' => $value,':user_id' => $user_id, ':gen_id'=>$gen_id)
                ));

                foreach ($courseScore as $valScore) {
                    $valScore->active = 'n';
                    $valScore->save();
                }
            }


            if($type_test == 'course'){
                $type_test == 'post';
            }

            Courselogques::model()->deleteAll(array(
                'condition' => 'course_id=:course_id AND user_id=:user_id AND gen_id=:gen_id'.$sql_text2,
                'params' => array(':course_id' => $value,':user_id' => $user_id, ':gen_id'=>$gen_id)));

            Courselogchoice::model()->deleteAll(array(
                'condition' => 'course_id=:course_id AND user_id=:user_id AND gen_id=:gen_id'.$sql_text2,
                'params' => array(':course_id' => $value,':user_id' => $user_id, ':gen_id'=>$gen_id)));

            Passcours::model()->deleteAll(array(
                'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:passcours_user AND gen_id=:gen_id',
                'params' => array(':passcours_cours' => $value,':passcours_user' => $user_id, ':gen_id'=>$gen_id)));

            $courseName = CourseOnline::model()->findByPk($value);
            $courseMsg .= ($key+1)." หลักสูตร : ".$courseName->course_title.'<br>';
            $courseMsg_en .= ($key+1)." Course : ".$courseName->course_title.'<br>';



        } // foreach coursedata

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        $courseMsg .= '<span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
        $model = Users::model()->findByPk($user_id);
        $to['email'] = $model->email;
        $to['firstname'] = $model->profiles->firstname;
        $to['lastname'] = $model->profiles->lastname;
        $subject = 'Exams reset system\ ระบบการแจ้งเตือน Reset ผลการทดสอบ';
        $message = "เรื่อง : แจ้งเตือนการ Reset ผลการทดสอบ <br>";
        $message .= "เรียน: ".$model->profiles->firstname." ".$model->profiles->lastname."<br>";
        $message .= "ผู้ดูแลระบบดำเนินการ Reset ผลการทดสอบหลักสูตรดังต่อไปนี้ <br>";
        // $message .= "<div style=\"text-indent: 4em;\">";
        $message .= $courseMsg;

        //eng
        $message .= "<br> Subject: Exams reset notification. <br>";
        $message .= "Dear: ".$model->profiles->firstname_en." ".$model->profiles->lastname_en."<br>";
        $message .= "The administrator has performs a reset of course exams as follows. <br>";
        $message .= $courseMsg_en;
        $message .= '<span style="color:red">Reason : '.$_POST['description'].'</span>';



        $send = Helpers::lib()->SendMail($to,$subject,$message);

        echo $reset_type;

    }


















































    public function actionIndex()
    {
      $this->render('index');
    }
    //// USER ////
  public function actionShowResetCourse()
  {
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                'select'=>'lesson_id, id, user_id',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id
                inner join tbl_course_online on tbl_course_online.course_id = tbl_lesson.course_id',
                'group'=>'tbl_course_online.course_id',
                'order'=>'tbl_course_online.course_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_course', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetLearnCourse()
{
    if (($_POST['stdID'] != '') && ($_POST['courseID'] != '')) {
        $stdID = $_POST['stdID'];
        $courseID = $_POST['courseID'];
        $lesson = Lesson::model()->findAll('course_id=' . $courseID . ' AND active="y"');
        foreach ($lesson as $lessonItems) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lessonItems->id);
            $criteria->addCondition('user_id=' . $stdID);
            $criteria->addCondition('gen_id=' . $gen_id);
            $learnDel = Learn::model()->find($criteria);
            if($learnDel){
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $learnDel->learn_id);
                $criteria2->addCondition('user_id_file=' . $stdID);
                $criteria2->addCondition('gen_id=' . $gen_id);
                $learnFileDel = LearnFile::model()->findAll($criteria2);
                foreach ($learnFileDel as $key => $value) {
                    $value->delete();
                }
                $learnDel->delete();
            }
        }
    }
}

public function actionShowResetLesson()
{
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                'select'=>'lesson_id, id, user_id',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id',
                'group'=>'Learn.lesson_id',
                'order'=>'Learn.lesson_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_lesson', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetLearnLesson()
{
    if (($_POST['stdID'] != '') && ($_POST['lessonID'] != '')) {
        $stdID = $_POST['stdID'];
        $lessonID = $_POST['lessonID'];
        $lesson = Lesson::model()->find('id=' . $lessonID . ' AND active="y"');
        if($lesson){
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lesson->id);
            $criteria->addCondition('user_id=' . $stdID);
            $criteria->addCondition('gen_id=' . $gen_id);
            $learnDel = Learn::model()->find($criteria);
            if($learnDel){
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $learnDel->learn_id);
                $criteria2->addCondition('user_id_file=' . $stdID);
                $criteria2->addCondition('gen_id=' . $gen_id);
                $learnFileDel = LearnFile::model()->findAll($criteria2);
                foreach ($learnFileDel as $key => $value) {
                    $value->delete();
                }
                $learnDel->delete();
            }
        }
    }
}

public function actionShowResetExam()
{
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Score', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                    // 'select'=>'lesson_id, score_id, user_id, type',
                'alias'=>'Score',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Score.lesson_id',
                    // 'group'=>'Score.lesson_id',
                'order'=>'Score.lesson_id ASC,Score.type DESC'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_exam', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetScoreLesson()
{
    if (($_POST['stdID'] != '') && ($_POST['scoreID'] != '')) {
        $stdID = $_POST['stdID'];
        $scoreID = $_POST['scoreID'];
        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id=' . $stdID);
        $criteria->addCondition('score_id=' . $scoreID);
        $criteria->addCondition('gen_id=' . $gen_id);
        $score = Score::model()->find($criteria);
        if($score){
                // print_r($score);exit();
            $criteria = new CDbCriteria;
            $criteria->addCondition('user_id=' . $stdID);
            $criteria->addCondition('score_id=' . $scoreID);
            $criteria->addCondition('gen_id=' . $gen_id);
            $modelLogChoice = Logchoice::model()->deleteAll($criteria);
            $modelLogQues = Logques::model()->deleteAll($criteria);
            $score->delete();
        }
    }
}

public function actionMultiDelete_exam_lesson()
{
    header('Content-type: application/json');
    if(isset($_POST['chk']))
    {
        foreach($_POST['chk'] as $val)
        {
            $this->actionDelete_lesson_score($val);
        }
    }
}

public function actionDelete_lesson_score($id)
{

    $model_Score = Score::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));
    $model_Logchoice = Logchoice::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));
    $model_Logques = Logques::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));

    if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
}

    //// USER ////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //// UNIVERSITY ////

public function actionShowResetCourseUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, user_id, student_house',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id
                inner join tbl_course_online on tbl_course_online.course_id = tbl_lesson.course_id
                inner join tbl_users on tbl_users.id = Learn.user_id
                inner join university on university.id = tbl_users.student_house',
                'group'=>'tbl_course_online.course_id',
                'order'=>'tbl_course_online.course_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_course_uni', array(
            'uni' => $uni,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetLearnCourseUni()
{
    if (($_POST['uniID'] != '') && ($_POST['courseID'] != '')) {
        $uniID = $_POST['uniID'];
        $courseID = $_POST['courseID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $lesson = Lesson::model()->findAll('course_id=' . $courseID . ' AND active="y"');
        foreach ($lesson as $lessonItems) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lessonItems->id);
            $criteria->addInCondition('user_id', $ids);
            $criteria->addInCondition('gen_id', $gen_id);
            $learnDel = Learn::model()->findAll($criteria);
            foreach ($learnDel as $key => $value) {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $value->learn_id);
                $criteria2->addInCondition('gen_id', $gen_id);
                $criteria2->addInCondition('user_id_file', $ids);
                LearnFile::model()->deleteAll($criteria2);
            }
            Learn::model()->deleteAll($criteria);
        }
    }
}

public function actionShowResetLessonUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, user_id, student_house',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id
                inner join tbl_users on tbl_users.id = Learn.user_id
                inner join university on university.id = tbl_users.student_house',
                'group'=>'Learn.lesson_id',
                'order'=>'Learn.lesson_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_lesson_uni', array(
            'uni' => $uni,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetLearnLessonUni()
{
    if (($_POST['uniID'] != '') && ($_POST['lessonID'] != '')) {
        $uniID = $_POST['uniID'];
        $lessonID = $_POST['lessonID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition('lesson_id=' . $lessonID);
        $criteria->addInCondition('user_id', $ids);
        $criteria->addInCondition('gen_id', $gen_id);
        $learnDel = Learn::model()->findAll($criteria);
        $idl = array();
        foreach ($learnDel as $learnItems) {
            $idl[] = $learnItems->learn_id;
        }
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('learn_id', $idl);
        $criteria2->addInCondition('user_id_file', $ids);
        $criteria2->addInCondition('gen_id', $gen_id);
        LearnFile::model()->deleteAll($criteria2);
        Learn::model()->deleteAll($criteria);
    }
}

public function actionShowResetExamLessonUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Score', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, score_id, user_id, type',
                'alias'=>'Score',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Score.lesson_id
                inner join tbl_users on tbl_users.id = Score.user_id
                inner join university on university.id = tbl_users.student_house',
                'group'=>'Score.lesson_id',
                'order'=>'Score.lesson_id ASC,Score.type DESC'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_exam_uni', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetScoreLessonUni()
{
    if (($_POST['uniID'] != '') && ($_POST['lessonID'] != '')) {
        $uniID = $_POST['uniID'];
        $lessonID = $_POST['lessonID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition('lesson_id=' . $lessonID);
        $criteria->addInCondition('user_id', $ids);
        $criteria->addInCondition('gen_id', $gen_id);
        $score = Score::model()->findAll($criteria);
        if($score){
            foreach ($score as $key => $value) {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('score_id=' . $value->score_id);
                $criteria2->addCondition('gen_id=' . $value->gen_id);
                $modelLogChoice = Logchoice::model()->deleteAll($criteria2);
                $modelLogQues = Logques::model()->deleteAll($criteria2);
            }
            $score = Score::model()->deleteAll($criteria);
        }
    }
}
    //// UNIVERSITY ////




public function actionReset_university()
{
    $model=new TbUniversity('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['University']))
            $model->attributes=$_GET['University'];

        $this->render('reset_university',array(
            'model'=>$model,
        ));
    }




    public function actionUser_reset_learn()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $model_learn = Learn::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_learnfile = LearnFile::model()->deleteAll(array(
                'condition' => 'user_id_file=' . $id,
            ));
        }
    }

    public function actionUser_reset_score()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $model_Score = Score::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_Logchoice = Logchoice::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_Logques = Logques::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
        }
    }


    public function actionDelete_user_learn($id)
    {

        $model_learn = Learn::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_learnfile = LearnFile::model()->deleteAll(array(
            'condition' => 'user_id_file=' . $id,
        ));

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDelete_user_score($id)
    {

        $model_Score = Score::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_Logchoice = Logchoice::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_Logques = Logques::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    public function actionMultiDelete_learn_user()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_user_learn($val);
            }
        }
    }
    public function actionMultiDelete_score_user()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_user_score($val);
            }
        }
    }






    //===============================================University===========================================//

    public function actionUniversity_reset_learn()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $university_user = User::model()->findAll(array(
                'condition' => 'student_house=' . $id,
            ));
            if ($university_user) {
                foreach ($university_user as $user) {
                    $model_learn = Learn::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_learnfile = LearnFile::model()->deleteAll(array(
                        'condition' => 'user_id_file=' . $user->id,
                    ));
                }
            }
        }
    }


    public function actionUniversity_reset_score()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $university_user = User::model()->findAll(array(
                'condition' => 'student_house=' . $id,
            ));
            if ($university_user) {
                foreach ($university_user as $user) {
                    $model_Score = Score::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_Logchoice = Logchoice::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_Logques = Logques::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                }
            }
        }

    }



    public function actionDelete_learn($id)
    {

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $id,
        ));
        if ($university_user) {
            foreach ($university_user as $user) {
                $model_learn = Learn::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_learnfile = LearnFile::model()->deleteAll(array(
                    'condition' => 'user_id_file=' . $user->id,
                ));
            }
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDelete_score($id)
    {
        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $id,
        ));
        if ($university_user) {
            foreach ($university_user as $user) {
                $model_Score = Score::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_Logchoice = Logchoice::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_Logques = Logques::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
            }
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    public function actionMultiDelete_learn()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_learn($val);
            }
        }
    }

    public function actionMultiDelete_score()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_score($val);
            }
        }
    }

    public function actionGet_dialog_learn()
    {
        $type = 'learn';
        $user_id = $_POST['user_id'];
        $test = '';
        $criteria = new CDbCriteria();
        $criteria->condition = "user_id = $user_id AND lesson_active = 'y' AND courseonline.active = 'y'";
        $criteria->group = "t.course_id ,t.gen_id";
        $course = learn::model()->with('course')->findAll($criteria);
  //var_dump($course);exit();
        $respon = '';
        $respon = $this->renderPartial('_modal_learn',array('course' => $course,'user_id' => $user_id,'type' => $type));
    }

    public function actionGet_dialog_pre()
    {
        $type = 'pre';
        $user_id = $_POST['user_id'];
        $test = '';
        $criteria = new CDbCriteria();
        $criteria->condition = "t.user_id = $user_id AND t.active='y' AND t.type='pre' AND courseonline.active = 'y'";
        $criteria->group = "t.course_id , t.gen_id";
        $course = Score::model()->with('course')->findAll($criteria);


        $respon = '';
        $respon = $this->renderPartial('_modal_pre',array('course' => $course,'user_id' => $user_id,'type' => $type));
    }

    public function actionGet_dialog_post()
    {
        $type = 'post';
        $user_id = $_POST['user_id'];
        $test = '';
        $criteria = new CDbCriteria();
        $criteria->condition = "t.user_id = $user_id AND t.active='y' AND t.type='post' AND courseonline.active = 'y'";
        $criteria->group = "t.course_id ,t.gen_id";
        $course = Score::model()->with('course')->findAll($criteria);

        $respon = '';
        $respon = $this->renderPartial('_modal_post',array('course' => $course,'user_id' => $user_id,'type' => $type));
    }
















    public function actionGet_dialog_exam()
    {

    //     $course = MtAuthCourseName::model()->with('course')->findAll(array(
    //         'condition' => 'user_id=:user_id AND course.cgid != 1 AND course.cgid != 3',
    //         'params' => array('user_id' => $user_id))
    // );
    //     $respon = '';
    //     $respon = $this->renderPartial('_modal_exam',array('course' => $course,'user_id' => $user_id,'type' => $type));

     $type = 'exam';
     $user_id = $_POST['user_id'];
     $type_test = $_POST['type'];
     $test = '';
     $criteria = new CDbCriteria();
     $criteria->condition = "user_id = $user_id AND courseonline.active = 'y' AND t.type= '".$type_test."'";
     $criteria->group = "t.course_id ,t.gen_id";
     $course = Coursescore::model()->with('course')->findAll($criteria);

     $respon = '';
     $respon = $this->renderPartial('_modal_exam',array('course' => $course,'user_id' => $user_id,'type' => $type,'type_test' => $type_test));


     exit();
 }




public function actionResetDetail(){
    $id = $_POST['id'];
    $model = new LogReset('search');
    $model->unsetAttributes();

    if($id != null){
        $model->user_id = $id;
        $respon = $this->renderPartial('_reset_detail',array('model' => $model));
    }

    echo $respon;
}

public function actionGet_dialog_all()
{
    $user_id = $_POST['user_id'];

    $form = "
    <div class='col-md-12'>
    <form action='LearnReset/ResetLearnLesson' method='post'>
    <input type='hidden' name='reset_type' value='all'>
    <input type='checkbox' id='checkAll' /> เลือกทั้งหมด
    <br>
    ";

    $learn = Learn::model()->findAll(array(
        'condition' => 'user_id=' . $user_id.' order by course_id',
    ));

    if($learn){
        foreach($learn as $key => $value){
            $course_id[$value['course_id']] = $value['course_id'];
            $lesson_id[$value['course_id']][$value['lesson_id']] = $value['lesson_id'];
        }

        foreach($course_id as $key => $cid){
            $course_data = MtCourseName::model()->find(array('condition'=>'cnid = '.$cid));
            $form .= "<input type='checkbox'name=course_id[]  value=".$cid." /> ".$course_data['course_name'];
            $form .= "<br>";
            $form .="<ul style='list-style-type: none;'>";
            foreach($lesson_id[$key] as $cnid => $lid){
                $lesson_data = LessonList::model()->find(array('condition'=>'lid = '.$lid));
                $form .= "<li><input type='checkbox'name=lesson_id[]  value=".$lid." /> ".$lesson_data['lesson_name'];
                $form .= "</li>";
            }
            $form .= "</ul>";
        }
    }


    $form .= "</form>
    </div>
    <script>

    $('#checkAll').change(function () {
        $('input:checkbox').prop('checked', $(this).prop('checked'));
    });
    </script>
    ";
    echo $form;
    exit();
}

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
    public function actionCheckCourseAccept(){
        $user = Users::model()->findByPk(Yii::app()->user->id);
        $type =  $_POST['reset_type'];
        $attr = array();
        $attr['status'] = true;
        if($user->superuser!=1){
            $lesson = json_decode($_POST['checkedList']);
            $criteria=new CDbCriteria;
            $criteria->with = array('course');
            $criteria->compare('user_id',$user->id);
            $criteria->addInCondition('course_id',$lesson);
            $courseSelect = MtAuthCourseName::model()->findAll($criteria);
            foreach ($courseSelect as $key => $value) {
                if($value->course->cn_accept_certificate == '1' && $value->approve_certificate=='y'){
                    $attr['status'] = false;
                    $attr['course'] .= $value->course->course_name;
                    } /*else {
                        if($type == 'exam'){
                            if($value->course->cn_accept_final_exam == '1' && $value->approve_exams=='y'){
                                $attr['status'] = false;
                                $attr['course'] .= $value->course->course_name;
                            }
                        } else {
                           if($value->course->cn_accept_result_exam == '1' && $value->approve_result_exam=='y'){
                                $attr['status'] = false;
                                $attr['course'] .= $value->course->course_name;
                            }
                        }
                    }*/
                }
            }
            echo json_encode($attr);
        }

        public function actionConfirmPass(){
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $passChk = md5($_POST['passInput']);
            if($user->password == $passChk){
                echo true;
            } else {
                echo false;
            }
        }
        protected function performAjaxValidation($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='reset-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }

    }