<?php

class QuestionController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    
    public function actionPreExams($id=null,$gen = 0)
    {
        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;

        } else {
            $langId = Yii::app()->session['lang'];
        }

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $isPreTest = Helpers::isPretestState($id);
        $testType = $isPreTest ? 'pre' : 'post';
        $testType = (empty($_GET['type'])) ?  $testType: $_GET['type'];
        // if ($langId == 1) {
            $lesson = Lesson::model()->findByPk($id);
            $gen_id = $gen != 0 ? $gen : $lesson->CourseOnlines->getGenID($lesson->course_id);
            $manage = Manage::Model()->findAll("id=:id AND type=:type", array("id" => $id,":type" => $testType));
        // }else{
        //     $lesson = Lesson::model()->findByPk($id);
        //     $lesson_parent = Lesson::model()->find("parent_id=".$id." AND lang_id =".$langId);
        //     $gen_id = $lesson->CourseOnlines->getGenID($lesson->course_id);
        //     $manage = Manage::Model()->findAll("id=:id AND type=:type", array("id" => $lesson_parent->id,":type" => $testType));
        // }

       /* $Question = Question::model()->with('chioce')->findAll("question.group_id=:group_id AND chioce.choice_answer=:choice_answer", array(
                                    "group_id" => $manage->group_id,
                                    "choice_answer" => 1,
                                ));*/
         if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
            }else{
                $langId = Yii::app()->session['lang'];
                Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
            }

            $label = MenuCoursequestion::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                    ));
            if(!$label){
                $label = MenuCoursequestion::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                    ));
            }

            $labelCourse = MenuCourse::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                    ));
            if(!$labelCourse){
                $labelCourse = MenuCourse::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                    ));
            }


        $arr_id_ques = array();
        foreach ($manage as $key => $value) {   
                $total_score += $value->manage_row;
                $check_ques = Question::model()->findAll("active='y' AND ques_type=4 AND group_id='".$value->group_id."'");
                if (!empty($check_ques)) {
                    foreach ($check_ques as $keyy => $valuee) {
                        $arr_id_ques[] = $valuee->ques_id;
                    }
                }else{
                    $check_ques = Question::model()->findAll("active='y' AND ques_type=3 AND group_id='".$value->group_id."'");
                    if(!empty($check_ques)){
                        $total_score = 0;
                        foreach ($check_ques as $key => $value) {
                            $total_score += $value->max_score;
                        }
                    }
                }
            }

            $num_choice = 0;
            if(!empty($arr_id_ques)){
                foreach ($arr_id_ques as $key => $value) {
                $check_choice = Choice::model()->findAll("active='y' AND choice_answer=1 AND choice_type='dropdown' AND ques_id='".$value."'");
                     if (!empty($check_choice)) {
                        $num_choice = $num_choice+count($check_choice);
                     }
                }
            }
            
        $currentQuiz = TempQuiz::model()->find(array(
            'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND gen_id=:gen_id order by id",
            'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType, ':gen_id'=>$gen_id)
        ));
        // Not found and redirect
        if (!$manage) {
            Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
            Yii::app()->user->setFlash('class', "error");

            $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
        }
        if($currentQuiz){
            Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id,$lesson->course_id);
            $this->redirect(array('question/index',
                'id' => $lesson->id,
                'type' => $testType,
                'labelCourse' =>$labelCourse,
                'gen'=>$gen_id
            ));
        } else {
            Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id,$lesson->course_id);
            $this->render('pre_exams',array(
                'lesson' => $lesson,
                //'manage' => $manage,
                'num_choice'=>$num_choice,
                'total_score' => $total_score,
                'label'=>$label,
                'labelCourse' => $labelCourse,
                'testType' => $testType,
                'gen'=>$gen_id
            ));
        }
    }

    public function actionIndex($id=null,$gen = 0)
    {        
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
        $label = MenuCoursequestion::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuCoursequestion::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        $labelCourse = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$labelCourse){
            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $quesType_ = 2; // เช็คว่ามี ข้อสอบ 3 บรรยาย ไหม
        $type_question = 0; // ประเภทข้อสอบ


        $id = isset($_POST['lesson_id']) ? $_POST['lesson_id'] : $id;
        $user_lesson = User::model()->findByPk(Yii::app()->user->id);
        // $to['email'] = $user_lesson->email;
        // $to['firstname'] = $user_lesson->profile->firstname;
        // $to['lastname'] = $user_lesson->profile->lastname;

        // $to_admin1['email'] = $user_lesson->profile->advisor_email1;
        // $to_admin1['firstname'] = $user_lesson->profile->firstname;
        // $to_admin1['lastname'] = $user_lesson->profile->lastname;

        // $to_admin2['email'] = $user_lesson->profile->advisor_email2;
        // $to_admin2['firstname'] = $user_lesson->profile->firstname;
        // $to_admin2['lastname'] = $user_lesson->profile->lastname;
//        Helpers::lib()->SendMail($to,"คุณสอบผ่านแล้ว",'คุณสอบผ่านแล้ว');

        // if ($langId == 1) {
            $lesson = Lesson::model()->findByPk($id);
            $course = CourseOnline::model()->findByPk($lesson->course_id);
        // }else{
        //     $lesson = Lesson::model()->findByPk($id);
        //     $lesson_parent = Lesson::model()->find("parent_id=".$id." AND lang_id =".$langId);
        // }

        $gen_id = $gen != 0 ? $gen : $lesson->CourseOnlines->getGenID($lesson->course_id);

        if (!Helpers::lib()->CheckBuyItem($lesson->course_id, false)) {
            if(Yii::app()->session['lang'] == 2){
                Yii::app()->user->setFlash('CheckQues',$label->label_alert_error);
            }else{
                Yii::app()->user->setFlash('CheckQues', "error");
            }
            Yii::app()->user->setFlash('class','error');

            $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id,
                'label'=>$label));
        }

        // $isPreTest = Helpers::isPretestState($id);
        // $isPostTest = Helpers::isPosttestState($id);
        // $testType = $isPreTest ? 'pre' : 'post';

        $isChkPreTest = $_GET['type'] == 'pre';
        $testType = $isChkPreTest ? 'pre' : 'post';
        $isPreTest = ($isChkPreTest == 'pre')? true : false;

        if ($lesson) {
            Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id, $lesson->course_id);
            $lessonStatus = Helpers::lib()->checkLessonPass($lesson,$gen_id);
        }

        $ManageCheck = Manage::Model()->findAll("id=:id AND active=:active AND type=:type", array(
            "id" => $id,
            "active" => "y",
            "type" => $testType
        ));
        $typeExam = 2;
        foreach ($ManageCheck as $key => $value) {
            foreach($value->question as $keyQuestion =>$valueQuestion){
                if($valueQuestion->ques_type == 3){
                    $typeExam = 3;
                }
            }
        }
        if ($lessonStatus == "pass" || $isPreTest) {
            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                "lesson_id" => $id,
                "user_id" => Yii::app()->user->id,
                "type" => $testType, ':gen_id'=>$gen_id
            ));

            $countManage = Manage::Model()->count("id=:id AND active=:active AND type=:type", array(
                "id" => $id,
                "active" => "y",
                "type" => $testType
            ));

            // Not found and redirect

            if (!$countManage) {

                Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
                Yii::app()->user->setFlash('class','error');

                $this->redirect(array(
                    '//course/detail',
                    'lesson_id' => $id,
                    'id' => $lesson->course_id,
                    'label'=>$label,
                    'gen'=>$gen_id
                ));
            }
            
            if ($countScore == $lesson->cate_amount || ($countScore > 0 && $isPreTest)) //สอบครบจำนวน
            {

                $countScorePast = Score::model()->findAll(array(
                    'condition' => ' lesson_id = "' . $id . '"
                    AND user_id    = "' . Yii::app()->user->id . '"
                    AND type       = "' . $testType . '"
                    AND score_past = "y"
                    AND active       = "y"
                    AND gen_id     = "'.$gen_id.'"
                    ',
                ));


                if (count($countScorePast) > 0) {
                    if($course->hidden_score != "y"){
                        // Pass
                        Yii::app()->user->setFlash('CheckQues',$label->label_alert_testPass);
                        Yii::app()->user->setFlash('class','success');
                    }
               
                    $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id,
                        'label'=>$label));
                } else {
                    // Not Pass
                    if($typeExam == 3){
                        $countScoreNotConfirm = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND confirm=:confirm AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                            "lesson_id" => $id,
                            "user_id" => Yii::app()->user->id,
                            "confirm" => "0",
                            "type" => $testType, ':gen_id'=>$gen_id
                        ));
                        if (!empty($countScoreNotConfirm)) {
                            Yii::app()->user->setFlash('CheckQues',"รอการตรวจข้อสอบบรรยาย");
                            Yii::app()->user->setFlash('class','warning');
                            $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id));
                        }
                    }else{
                        if($course->hidden_score != "y"){
                            Yii::app()->user->setFlash('CheckQues',$label->label_alert_testFail);
                            Yii::app()->user->setFlash('class','error');
                        }
                        $this->redirect(array('//course/detail', 'id' => $lesson->course_id, 'lesson_id' => $id,'gen'=>$gen_id,'label'=>$label));
                    }
                    
                }
            } else {
                $countScorePast = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND score_past=:score_past AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                    "lesson_id" => $id,
                    "user_id" => Yii::app()->user->id,
                    "score_past" => "y",
                    "type" => $testType, ':gen_id'=>$gen_id
                ));

                
                if($typeExam == 3){
                    $countScoreNotConfirm = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND confirm=:confirm AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                        "lesson_id" => $id,
                        "user_id" => Yii::app()->user->id,
                        "confirm" => "0",
                        "type" => $testType, ':gen_id'=>$gen_id
                    ));
                    if (!empty($countScoreNotConfirm)) {
                        Yii::app()->user->setFlash('CheckQues',"รอการตรวจข้อสอบบรรยาย");
                        Yii::app()->user->setFlash('class','warning');
                        $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id));
                    }
                }
                
    
                if (!empty($countScorePast)) {
                    if($course->hidden_score != "y"){
                      //pass
                      Yii::app()->user->setFlash('CheckQues',$label->label_alert_testPass);
                      Yii::app()->user->setFlash('class','success');
                    }
                  
                    $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id));
                } else {
                    // Config default pass score 60 percent
                    //$settings = Setting::model()->find();
//                    $scorePercent = 60;
                    $scorePercent = $lesson->cate_percent;
                    // if (isset($lesson_parent)) {
                    //     $manage = new CActiveDataProvider('Manage', array(
                    //         'criteria' => array(
                    //             'condition' => ' id = "' . $lesson_parent->id . '" AND active = "y" AND type = "' . $testType . '" '
                    //         ))
                    // );
                    // }else{
                        $manage = new CActiveDataProvider('Manage', array(
                            'criteria' => array(
                                'condition' => ' id = "' . $id . '" AND active = "y" AND type = "' . $testType . '" '
                            ))
                    );
                    // }

                    $temp_all = TempQuiz::model()->findAll(array(
                        'condition' => "user_id=".Yii::app()->user->id." and lesson=".$id." and type='".$testType."' AND gen_id='".$gen_id."'"
                    ));

                    if(empty($temp_all)){            
                        $countchoice = 0;
                        $created_date_temp = date("Y-m-d H:i:s");
                        foreach ($manage->getData() as $i => $value) {
                         $modelQuestion[] = Question::getLimitData($value['group_id'], $value['manage_row']);
                         foreach($modelQuestion as $key1 => $ques){
                            foreach($ques as $key2 => $val){
                                $temp_test = new TempQuiz;
                                $temp_test->user_id = Yii::app()->user->id;
                                $temp_test->lesson = $lesson->id;
                                $temp_test->gen_id = $gen_id;
                                $temp_test->group_id = $val['group_id'];
                                $temp_test->ques_id = $val['ques_id'];
                                $temp_test->type = $testType;
                                $choice = array();
                                $choiceData = array();
                                $choiceData = $val['chioce'];
                                $arrType4Answer = array();
                                $Type4Question = array();
                                foreach ($choiceData as $key => $val_choice) {
                                    if($val_choice->choice_type != 'dropdown'){
                                    // if($val_choice->choice_type != 'radio'){
                                        $choice[] = $val_choice->choice_id;
                                        // echo 'NO';
                                    }else{
                                        $ranNumber = rand(1, 10000000);
                                        if($val_choice->choice_answer == 2){
                                            $arrType4Answer[$ranNumber] = $val_choice->choice_id;
                                        }
                                        if($val_choice->choice_answer == 1){
                                            $choice[] = $val_choice->choice_id;
                                        }
                                    }
                                }                               
                               
                               
                                if($arrType4Answer){
                                    ksort($arrType4Answer);
                                    $choiceA = array();
                                    foreach ($arrType4Answer as $key => $arrTypeVal) {
                                        $choiceA[] = $arrTypeVal;
                                    }
                                    $choice = array_merge($choice,$choiceA);
                                }

                                $criteria=new CDbCriteria;
                                $criteria->addInCondition('choice_id',$choice);
                                $criteria->order = 'RAND() ';
                                $rand_choice =  Choice::model()->findAll($criteria);
                                $choice_array = [];
                                $num_checkk = 1;
                                $num_check_2 = 0;
                                foreach ($rand_choice as $key => $val_choice) {
                                    if($val_choice->choice_answer == 1 && $val_choice->choice_type == 'dropdown'){
                                        $choice_array[count($rand_choice)-$num_checkk] = $val_choice->choice_id;
                                        $num_checkk++;
                                    }else{
                                        $choice_array[$num_check_2] = $val_choice->choice_id;
                                        $num_check_2++;
                                    }
                                }

                                ksort($choice_array);
                                $temp_test->question = json_encode($choice_array);

                                // $temp_test->question = json_encode($choice);
                                $temp_test->number = $key2+1;
                                $temp_test->status = 0;
                                if($key2==0){
                                    $temp_test->time_start = new CDbExpression('NOW()');
                                    $temp_test->time_up = $lesson->time_test*60;
                                }
                                $temp_test->created_date = $created_date_temp;
                                $temp_test->save();
                            }
                        }
                    }
                } 
                if(is_numeric($_POST['actionEvnt'])){
                    $sql_number = 'AND number = '.$_POST['actionEvnt'];
                } else {
                    $sql_number = 'AND status="0"';
                }
                /*if(isset($_POST['number'])){
                    $sql_number = 'AND number = '.$_POST['number'];
                } else {
                    $sql_number = 'AND status="0"';
                }*/
                $currentQuiz = TempQuiz::model()->find(array(
                    'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type ".$sql_number." AND gen_id=:gen_id order by id",
                    'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType, ':gen_id'=>$gen_id)
                ));
                
                if(empty($currentQuiz)){
                    $currentQuiz = TempQuiz::model()->find(array(
                        'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND gen_id=:gen_id order by id",
                        'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType, ':gen_id'=>$gen_id)
                    ));
                }

                $model = Question::getTempData($currentQuiz['ques_id']);
                if(count($model) != null || count($model) != 0) {                     
                    if(isset($_POST['actionEvnt'])){                                                 
                        if(isset($_POST['Choice'])){         
                            foreach ($_POST['Question_type'] as $question_id => $value) {
                                $update_temp = TempQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and lesson=".$lesson->id." and ques_id=".$question_id." and type='".$testType."' AND gen_id='".$gen_id."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = json_encode($_POST['Choice'][$question_id]);
                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }
                        }

                        if(isset($_POST["answer_sort"])){
                            $_POST["answer_sort"] = explode(",", $_POST["answer_sort"]);
                             foreach ($_POST['Question_type'] as $question_id => $value) {
                                $update_temp = TempQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and lesson=".$lesson->id." and ques_id=".$question_id." and type='".$testType."' AND gen_id='".$gen_id."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = json_encode($_POST["answer_sort"]);
                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }
                        }

                        if(isset($_POST['dropdownVal'])){                           

                            foreach ($_POST['Question_type'] as $question_id => $value) {
                                $update_temp = TempQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and lesson=".$lesson->id." and ques_id=".$question_id." and type='".$testType."' AND gen_id='".$gen_id."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = json_encode($_POST['dropdownVal']);

                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }
                        }

                        if(isset($_POST['lecture'])){
                            // var_dump($_POST['Question_type']);exit();

                            foreach ($_POST['Question_type'] as $question_id => $value) {

                                $update_temp = TempQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and lesson=".$lesson->id." and ques_id=".$question_id." and type='".$testType."' AND gen_id='".$gen_id."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = $_POST['lecture'];

                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }

                        }


                        if($_POST['actionEvnt']=="save" || $_POST['actionEvnt']=="timeup"){
                            $modelCoursescore = new Score;
                            $modelCoursescore->lesson_id = $id;
                            $modelCoursescore->gen_id = $gen_id;
                           //$modelCoursescore->manage_id = $value['group_id'];
                            $modelCoursescore->type = $testType;
                            $modelCoursescore->course_id = $lesson->course_id;
                            $modelCoursescore->user_id = Yii::app()->user->id;
                            $modelCoursescore->save();

                            $temp_accept = TempQuiz::model()->findAll(
                               array('condition' => "user_id=".Yii::app()->user->id." and lesson=".$id." and type='".$testType."' AND gen_id='".$gen_id."'"
                           )); 
                            $countAllCoursequestion = 0;
                            $scoreSum = 0;

                            foreach ($temp_accept as $key => $value) {
                                $result = 0;

                                if($value->quest->ques_type==1){
                                    $countAllCoursequestion += 1;

                                    $coursequestion = Question::model()->with('chioce')->find("question.ques_id=:id", array(
                                        "id" => $value->ques_id,
                                    ));
                                    $choiceUserAnswerArray = array();
                                    if (isset($value->ans_id)) {
                                        $choiceUserAnswerArray = json_decode($value->ans_id);
                                    } 

                                    $choiceCorrect = $coursequestion->chioce(array(
                                        'condition' => 'choice_answer=1'
                                    ));

                                    $choiceCorrectArray = array();
                                    foreach ($choiceCorrect as $choiceCorrectItem) {
                                        $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                                    }
                                    sort($choiceUserAnswerArray);
                                    if ($choiceUserAnswerArray === $choiceCorrectArray) {
                                        $scoreSum++;
                                        $result = 1;
                                    }
                                    
                                    foreach ($coursequestion->chioce as $keyChoice => $choice) {
                                            // Save Logchoice
                                        $modelCourselogchoice = new Logchoice;
                                            $modelCourselogchoice->lesson_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                                            $modelCourselogchoice->logchoice_answer = (in_array($choice->choice_id, $choiceUserAnswerArray)) ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }

                                        // Save Logques
                                        $modelCourselogques = new Logques;
                                        $modelCourselogques->lesson_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;

                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                }else if($value->quest->ques_type==3){
                                    $countAllCoursequestion += $value->quest->max_score;
                                    $scoreTotal += $value->quest->max_score;
                                    $coursequestion = Question::model()->findByPk($value->ques_id);

                                    $result = 0;
                                            // Save Logchoice
                                    $modelCourselogchoice = new Logchoice;
                                            $modelCourselogchoice->lesson_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = '0';
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = '0';
                                            $modelCourselogchoice->logchoice_answer = '0';
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        // Save Logques
                                            $modelCourselogques = new Logques;
                                        $modelCourselogques->lesson_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->logques_text = $value->ans_id;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                }else if($value->quest->ques_type==6){
                                    $countAllCoursequestion += 1;

                                    $coursequestion = Question::model()->with('chioce')->find("question.ques_id=:id", array(
                                        "id" => $value->ques_id,
                                    ));
                                    $choiceUserAnswerArray = array();
                                    if (isset($value->ans_id)) {
                                        // $choiceUserAnswerArray = json_decode($value->ans_id);
                                        $choiceUserAnswerArray = $value->ans_id;
                                    } 

                                    $choiceCorrect = $coursequestion->chioce(array(
                                        'condition' => 'choice_answer=1'
                                    ));

                                    $choiceCorrectArray = array();
                                    foreach ($choiceCorrect as $choiceCorrectItem) {
                                        $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                                    }
                                    // sort($choiceUserAnswerArray);
                                    $choiceCorrectArray = json_encode($choiceCorrectArray);
                                    if ($choiceUserAnswerArray === $choiceCorrectArray) {
                                        $scoreSum++;
                                        $result = 1;
                                    }
                                    
                                    foreach ($coursequestion->chioce as $keyChoice => $choice) {
                                            // Save Logchoice
                                        $modelCourselogchoice = new Logchoice;
                                            $modelCourselogchoice->lesson_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                                            $modelCourselogchoice->logchoice_answer = ($choiceUserAnswerArray === $choiceCorrectArray) ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }

                                        // Save Logques
                                        $modelCourselogques = new Logques;
                                        $modelCourselogques->lesson_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                } else if($value->quest->ques_type==2){
                                        $countAllCoursequestion += 1;
                                        $coursequestion = Question::model()->with('chioce')->find("question.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));
                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            $choiceUserAnswerArray = json_decode($value->ans_id);
                                        } 

                                        $choiceCorrect = $coursequestion->chioce(array(
                                            'condition' => 'choice_answer=1'
                                        ));

                                        $choiceCorrectArray = array();
                                        foreach ($choiceCorrect as $choiceCorrectItem) {
                                            $choiceCorrectArray[] = $choiceCorrectItem->choice_id;
                                        }
                                        
                                        if ($choiceUserAnswerArray === $choiceCorrectArray) {
                                            $scoreSum++;
                                            $result = 1;
                                        }
                                        foreach ($coursequestion->chioce as $keyChoice => $choice) {
                                            // Save Logchoice
                                            $modelCourselogchoice = new Logchoice;
                                            $modelCourselogchoice->lesson_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;                                            
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                                            $modelCourselogchoice->logchoice_answer = (in_array($choice->choice_id, $choiceUserAnswerArray)) ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }

                                        // Save Logques
                                        $modelCourselogques = new Logques;
                                        $modelCourselogques->lesson_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                } else if($value->quest->ques_type==4){
                                    $coursequestion = Question::model()->with('chioce')->find("question.ques_id=:id", array(
                                        "id" => $value->ques_id,
                                    ));

                                    $choiceUserAnswerArray = array();
                                    if (isset($value->ans_id)) {
                                        $choiceUserAnswerArray = json_decode($value->ans_id);
                                    } 

                                    $choiceUserQuestionArray = array();
                                    // $choiceUserQuestionArray = $coursequestion->chioce(array(
                                        //     'condition' => 'choice_answer=1'
                                        // ));
                                    // var_dump(count($choiceUserAnswerArray));
                                     // var_dump(json_decode($value->question)); 
                                     // var_dump(count(json_decode($value->question))); 

                                     $key_atart = count(json_decode($value->question))-count($choiceUserAnswerArray);

                                     // var_dump(count(json_decode($value->question)));
                                     // var_dump(count($choiceUserAnswerArray));
                                     // var_dump($key_atart);
                                     foreach (json_decode($value->question) as $key_q => $value_q) {
                                        // var_dump($key_q);
                                        // var_dump($key_atart." <= ".$key_q);
                                        if($key_atart <= $key_q){
                                            $choiceUserQuestionArray[] = Choice::model()->findByPk($value_q);
                                        }
                                     }

                                     // var_dump($choiceUserQuestionArray);

                                     // exit();




                                    $choiceCorrectIDs = array();
                                    $choiceIsQuest = array();
                                    // var_dump("<pre>");

                                    // var_dump($choiceUserQuestionArray); // ช้อย ข้อถูก
                                    // var_dump($choiceUserAnswerArray); //ช้อย คำตอบ



                                    foreach ($choiceUserQuestionArray as $key => $value) {
                                        $countAllCoursequestion += 1;
                                        $choiceIsQuest[] = $value->choice_id;
                                        $choiceCorrectID['Anschoice_id'] = $choiceUserAnswerArray[$key];
                                        $checkValue = 0;

                                        $AnsChoice = $coursequestion->chioce(array(
                                            'condition' => 'choice_id='.$choiceUserAnswerArray[$key].
                                                            ' AND reference IS NOT NULL '
                                        ));

                                        // var_dump($AnsChoice);
                                        // var_dump($AnsChoice[0]->reference." == ".$value->choice_id);
                                        if($AnsChoice){                                           
                                            if($AnsChoice[0]->reference == $value->choice_id){
                                                $checkValue = 1;
                                                $scoreSum++;
                                                $result = 1;
                                            }
                                        }
                                         
                                        $choiceCorrectID['checkVal'] = $checkValue;
                                        $choiceCorrectIDs[$value->choice_id] = $choiceCorrectID;
                                     
                                    }

                                    $quest_score = 0;
                                    foreach ($coursequestion->chioce as $keyChoice => $choice) {
                                        $is_valid_choice = 0;
                                        $logchoice_answer = 0;

                                        $modelCourselogchoice = new Logchoice;
                                            $modelCourselogchoice->lesson_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;


                                            $checkChoice_quest = (in_array($choice->choice_id, $choiceIsQuest)) ? $choice->choice_id : 0;

                                            if($checkChoice_quest!=0){  
                                                                                            
                                                $logchoice_answer = $choiceCorrectIDs[$checkChoice_quest]['Anschoice_id'];
                                                // var_dump("choice_id");
                                                // var_dump($choice->choice_id);                                                
                                                // var_dump($logchoice_answer);
                                                // var_dump("logchoice_answer");
                                                // var_dump("<br>");
                                                // var_dump($choiceCorrectIDs[$checkChoice_quest]['checkVal']);
                                                if($choiceCorrectIDs[$checkChoice_quest]['checkVal'] == 1){
                                                    $is_valid_choice = 1;
                                                    $quest_score ++;
                                                }

                                            }

                                            $modelCourselogchoice->logchoice_answer = $logchoice_answer;
                                            $modelCourselogchoice->is_valid_choice = $is_valid_choice == 1 ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }
                                          
                                    //         echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><pre>';
                                    //     var_dump($modelCourselogchoice);
                                    //     echo '-------------';
                                    // exit();
                          
                                     $modelCourselogques = new Logques;
                                        $modelCourselogques->lesson_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $quest_score;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }
                                            
                                }
                            }
                                    // exit();

                                $sumPoint = $scoreSum * 100 / $countAllCoursequestion;
                                Score::model()->updateByPk($modelCoursescore->score_id, array(
                                    'score_number' => $scoreSum,
                                    'update_date' => date('Y-m-d H:i:s'),
                                    'score_total' => $countAllCoursequestion,
                                    'score_past' => ($sumPoint >= $scorePercent) ? 'y' : 'n',
                                ));
                                $modelScore = Score::model()->findByPk($modelCoursescore->score_id);
                                $courseStats = Helpers::lib()->checkCoursePass($lesson->course_id);
                                $courseManageHave = Helpers::lib()->checkHaveCourseTestInManage($lesson->course_id);
                                if($courseStats == "pass" && !$isPreTest && !$courseManageHave){
                            $coruse_percents =  Helpers::lib()->percent_CourseGen($lesson->course_id, $gen_id);
                            $checkpasscouse =  Helpers::lib()->checkpasscouse($coruse_percents,$lesson->course_id, $gen_id);

                                    // $passCoursModel = Passcours::model()->findByAttributes(array(
                                    //     'passcours_cates' => $lesson->CourseOnlines->cate_id,
                                    //     'passcours_user' => Yii::app()->user->id, 'gen_id'=>$gen_id
                                    //     ));
                                    // if (!$passCoursModel) {
                                    //     $modelPasscours = new Passcours;
                                    //     $modelPasscours->passcours_cates = $lesson->CourseOnlines->cate_id;
                                    //     $modelPasscours->passcours_cours = $lesson->course_id;
                                    //     $modelPasscours->gen_id = $gen_id;
                                    //     $modelPasscours->passcours_user = Yii::app()->user->id;
                                    //     $modelPasscours->passcours_date = new CDbExpression('NOW()');
                                    //     $modelPasscours->save();
                                    // }
                                }
                                $this->actiondeleteTemp($id,$testType,$gen_id);
                                $this->renderPartial('exams_finish', array(
                                    'quesType_'=>$type_question,
                                    'model' => $model,
                                    'lesson' => $lesson,
                                    'temp_all' => $temp_all,
                                    'quesType' => $quesType_,
                                    'testType' => $testType,
                                    'modelScore' => $modelScore,
                                    'label'=>$label,
                                    'labelCourse' => $labelCourse,
                                    'course' => $course,
                                    'gen'=>$gen_id,
                                ));
                        } else {
                            // echo '<pre>';
                            //     var_dump($_POST['dropdownVal']);
                            //     exit();        
                                $temp_count = count($temp_all);
                                if($_POST['actionEvnt']=="next"){
                                    $idx = $_POST['idx_now']+1;
                                    if($_POST['idx_now'] == $temp_count)$idx=1;
                                } elseif($_POST['actionEvnt']=="previous") {
                                    $idx = $_POST['idx_now']-1;
                                    if($_POST['idx_now'] == 1)$idx = $temp_count;
                                } else {
                                    $idx = $_POST['actionEvnt'];
                                }
                                $count_no_select = TempQuiz::model()->count(array(
                                    'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType, ':gen_id'=>$gen_id)
                                ));

                                $last_ques = $count_no_select == 0 ? 1 : 0;
                                $currentQuiz = TempQuiz::model()->find(array(
                                    'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND number=:number AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType,':number' => $idx, ':gen_id'=>$gen_id)
                                ));
                                $model = Question::getTempData($currentQuiz['ques_id']);
                                $temp_all = TempQuiz::model()->findAll(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and lesson=".$id." and type='".$testType."' AND gen_id='".$gen_id."'"
                                ));
                                $countExam = count($temp_all) - $count_no_select;
                                $this->renderPartial('exams_next', array(
                                    'model' => $model,
                                    'lesson' => $lesson,
                                    'temp_all' => $temp_all,
                                    'testType' => $testType,
                                    'currentQuiz' => $currentQuiz,
                                    'last_ques' => $last_ques,
                                    'countExam' => $countExam,
                                    'label'=>$label,
                                    'labelCourse'=>$labelCourse,
                                    'gen'=>$gen_id,
                                ));
                            }
                    } else {      
                            $count_no_select = TempQuiz::model()->count(array(
                                'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => $testType, ':gen_id'=>$gen_id)
                            ));

                            $last_ques = $count_no_select == 0 ? 1 : 0;
                            $temp_all = TempQuiz::model()->findAll(array(
                                'condition' => "user_id=".Yii::app()->user->id." and lesson=".$id." and type='".$testType."' AND gen_id='".$gen_id."'"
                            ));
                            $countExam = count($temp_all) - $count_no_select;
                            $this->render('exams', array(
                                'model' => $model,
                                'lesson' => $lesson,
                                'temp_all' => $temp_all,
                                'testType' => $testType,
                                'currentQuiz' => $currentQuiz,
                                'last_ques' => $last_ques,
                                'countExam' => $countExam,
                                'time_up' => $temp_all[0]->time_up,
                                'label'=>$label,
                                'labelCourse'=>$labelCourse,
                                'gen'=>$gen_id,
                            ));
                        }
                    } else {
                        Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
                        Yii::app()->user->setFlash('class','error');

                        $this->redirect(array(
                            '//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id
                        ));
                    }
                }
            }
        } else {
            if(Yii::app()->session['lang'] == 2){
                Yii::app()->user->setFlash('CheckQues',$label->label_alert_error);
            }else{
                Yii::app()->user->setFlash('CheckQues', "error");
            }
            Yii::app()->user->setFlash('class','error');

            $this->redirect(array('//course/detail', 'id' => $lesson->course_id,'gen'=>$gen_id, 'lesson_id' => $id));
        }
    }
    
    public function actionExamsFinish()
    {
        $this->render('exams-finish');
    }

    public function actionResetpost($id=null,$course=null)
    {
        $lesson_model = Lesson::model()->findByPk($id);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $learn = Learn::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_id=:lesson AND lesson_active=:lesson_active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':lesson_active' => 'y', ':gen_id'=>$gen_id)
        ));

        foreach ($learn as $key => $value) {

            LearnFile::model()->deleteAll(array(
                'condition' => "learn_id=:learn_id AND user_id_file=:user_id_file AND gen_id=:gen_id",
                'params' => array(':learn_id' => $value->learn_id , ':user_id_file' => Yii::app()->user->id, ':gen_id'=>$gen_id)
            ));


            $value->lesson_active = 'n';
            $value->save(false);
        }

        $score = Score::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_id=:lesson AND type=:type AND active=:active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $id,':type' => 'post',':active' => 'y', ':gen_id'=>$gen_id)
        ));

        foreach ($score as $key => $value) {

            Logques::model()->deleteAll(array(
                'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':user_id' => Yii::app()->user->id,':lesson_id' => $id,':score_id'=>$value->score_id, ':gen_id'=>$gen_id)));

            Logchoice::model()->deleteAll(array(
                'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $id,':user_id' => Yii::app()->user->id,':score_id'=>$value->score_id, ':gen_id'=>$gen_id)));
            $value->active = 'n';
            $value->save(false);
        }
        $this->redirect(array('/course/detail/', 'id' => $course));

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

    public function actiondeleteTemp($lesson_id=null,$type=null,$gen_id=null){
       TempQuiz::model()->deleteAll(array(
        'condition' => "user_id=:user_id AND lesson=:lesson AND type=:type AND gen_id=:gen_id",
        'params' => array(':user_id' => Yii::app()->user->id,':lesson' => $lesson_id,':type'=>$type, ':gen_id'=>$gen_id)
        )); 
    }

    public function actionSaveTimeExam(){
        $lesson_model = Lesson::model()->findByPk($_POST['lesson_id']);
        $gen_id = $lesson_model->CourseOnlines->getGenID($lesson_model->course_id);

        $temp_time_start = TempQuiz::model()->find(array(
            'condition' => "user_id=".Yii::app()->user->id." and lesson=".$_POST['lesson_id']." and time_start is not null AND gen_id='".$gen_id."'"
        )); 
        if($temp_time_start){
            $temp_time_start->time_up = $_POST['time'];
               // echo ($temp_time_start->update()) ? 'success' : 'error';
            if($temp_time_start->update()){
                $state = 'success';
            }else{
                $state = 'error';
            }
        }else{
            $state = 'error';
        }
        echo $state;
    }

      public function actionWebcam()
    {
        $this->render('webcam');
    }
      

   }