<?php

class CoursequestionController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionPreExams($id=null,$gen = 0)
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

        $isPreTest = Helpers::isPretestStateCourse($id);
        $course = CourseOnline::model()->findByPk($id);
        $gen_id = $gen != 0 ? $gen : $course->getGenID($course->course_id);

        $que_type = $isPreTest ? 'pre' : 'course';
        if(isset($_GET['type'])){
            $que_type = $_GET['type']; // pre
        }


        if ($langId == 1) {
            $course = CourseOnline::model()->findByPk($id);
        }else{
            $course = CourseOnline::model()->findByPk($id);
            $course_parent = CourseOnline::model()->find("parent_id=".$id." AND lang_id =".$langId);
        }

        $Coursemanage = Coursemanage::Model()->find("id=:id AND active=:active AND type=:type", 
            array("id" => $id,"active" => "y", ":type"=>$que_type));
        
        if (isset($course_parent)) {
            $Coursemanage = Coursemanage::Model()->find("id=:id AND active=:active AND type=:type", 
            array("id" => $course_parent->id,"active" => "y", ":type"=>$que_type));

            if(!isset($Coursemanage)){
                $Coursemanage = Coursemanage::Model()->find("id=:id AND active=:active AND type=:type", 
                array("id" => $course_parent->parent_id,"active" => "y", ":type"=>$que_type));
            }
        }

        $Question = Coursequestion::model()->with('choices')->findAll("ques.group_id=:group_id AND choices.choice_answer=:choice_answer", array(
            "group_id" => $Coursemanage->group_id,
            "choice_answer" => 1,
        ));

        if(empty($Question)){ // ถ้าไม่มีช้อย แสดงว่าเป็นข้อเขียน
            $Question = Coursequestion::model()->with('choices')->findAll("ques.group_id=:group_id AND ques_type=3", array(
                "group_id" => $Coursemanage->group_id,
            ));
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

        if($Question[0]->ques_type == 3){

           foreach ($Question as $key => $value) {   
                $total_score += $value->max_score;
           }   

        }else{
            $total_score = $Coursemanage->manage_row;
        }

       

        $currentQuiz = TempCourseQuiz::model()->find(array(
            'condition' => "user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type order by id",
            'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id, ':gen_id'=>$gen_id, ':type'=>$que_type)
        ));
        // Not found and redirect
        if (!$Coursemanage) {
            Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
            Yii::app()->user->setFlash('class', "error");

            $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
        }
        if($currentQuiz){
            $this->redirect(array('coursequestion/index',
                'id' => $course->course_id,
                'labelCourse' => $labelCourse,
                'type' => $que_type,
                'gen'=>$gen_id
            ));
        } else {
            $this->render('pre_exams',array(
                'type'=>$que_type,
                'course' => $course,
                'manage' => $Coursemanage,
                'total_score' => $total_score,
                'label'=>$label,
                'labelCourse' => $labelCourse,
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

        $que_type = "course";
        if(isset($_GET['type'])){
            $que_type = $_GET['type']; // pre
        }
        $quesType_ = 2; // เช็คว่ามี ข้อสอบ 3 บรรยาย ไหม
        $type_question = 0; // ประเภทข้อสอบ

        $id = isset($_POST['course_id']) ? $_POST['course_id'] : $id;
        if(Yii::app()->user->id){
            $course = CourseOnline::model()->findByPk($id);
            $gen_id = $gen != 0 ? $gen : $course->getGenID($course->course_id);
            $courseStatus = Helpers::lib()->checkCoursePass($id,$gen_id);

            if ($langId != 1) {
                $course_parent = CourseOnline::model()->find("parent_id=".$id." AND lang_id =".$langId);
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

            $status_precorse = false;
            $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
            if($checkHaveCoursePreTest){
                $checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id);
                if($checkHaveScoreCoursePreTest){  // true=ไม่มีคะแนน สอบได้   false=มีคะแนน ไม่ต้องสอบละ
                    $status_precorse = true;
                }
            }
            // var_dump($courseStatus);
            // var_dump($status_precorse);
            // die();
            if ($courseStatus == "notPass" && $status_precorse == false) { 
                Yii::app()->user->setFlash('CheckQues', $label->label_alert_noPermisTest);
                Yii::app()->user->setFlash('class', "error");

                $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
            } else if ($courseStatus == "pass" || $status_precorse == true) {
                $countCoursemanage = Coursemanage::Model()->count("id=:id AND active=:active AND type=:type", array(
                    "id" => $id,
                    "active" => "y",
                    "type"=>$que_type,
                ));

                // Not found and redirect
                if (!$countCoursemanage) {
                    Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
                    Yii::app()->user->setFlash('class', "error");

                    $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
                }

                if($que_type == "course"){
                    $que_type = "post";
                }
                $countCoursescore = Coursescore::Model()->count("course_id=:course_id AND user_id=:user_id and active = 'y' AND gen_id=:gen_id AND type=:type", array(
                    "course_id" => $id,
                    "user_id" => Yii::app()->user->id, ':gen_id'=>$gen_id, ':type'=>$que_type

                ));

                

                if ($countCoursescore == $course->cate_amount) //สอบครบจำนวนครั้งที่กำหนดไว้
                {
                    $countCoursescorePast = Coursescore::model()->findAll(array(
                        'condition' => ' course_id = "' . $id . '"
                        AND user_id    = "' . Yii::app()->user->id . '"
                        AND score_past = "y" and active = "y"
                        '." AND gen_id='".$gen_id."' AND type='".$que_type."'",
                    ));
                    
                    if (!empty($countCoursescorePast) && $course->hidden_score != "y") {
                        if($course->hidden_score != "y"){
                            // Pass
                            Yii::app()->user->setFlash('CheckQues',$label->label_alert_testPass);
                            Yii::app()->user->setFlash('class', "success");
                        }
                        $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
                    } else {
                        if($course->hidden_score != "y"){
                            // Not Pass
                            Yii::app()->user->setFlash('CheckQues', $label->label_alert_testFail);
                            Yii::app()->user->setFlash('class', "error");
                        }
                        $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
                    }
                } else {                          
                    $countCoursescorePast = Coursescore::Model()->count("course_id=:course_id AND user_id=:user_id AND score_past=:score_past  and active = 'y' AND gen_id=:gen_id AND type=:type", array(
                        "course_id" => $id,
                        "user_id" => Yii::app()->user->id,
                        "score_past" => "y", ':gen_id'=>$gen_id, ':type'=>$que_type
                    ));

                    $chk_passssss = 1;
                    if (!empty($countCoursescorePast) && $chk_passssss == 2) {

                        // Yii::app()->user->setFlash('CheckQues', $label->label_alert_testPass);
                        // Yii::app()->user->setFlash('class', "success");

                        // $this->redirect(array('//course/detail', 'id' => $id));
                    } else {
                        // Config default pass score 60 percent
                        $scorePercent = $course->percen_test;
                        if($que_type == "post"){
                            $que_type = "course";
                        }



                        $manage = new CActiveDataProvider('Coursemanage', array(
                            'criteria' => array(
                                'condition' => ' id = "' . $id . '" AND active = "y" AND type="'.$que_type.'"'
                            ))
                    );


                        $temp_all = TempCourseQuiz::model()->findAll(array(
                            'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                        ));

                        if (isset($course_parent)) {
                            $manage = new CActiveDataProvider('Coursemanage', array(
                                'criteria' => array(
                                    'condition' => ' id = "' . $course_parent->id . '" AND active = "y" AND type="'.$que_type.'"'
                                )));

                            if(count($manage->getData()) == 0 ){
                                $manage = new CActiveDataProvider('Coursemanage', array(
                                    'criteria' => array(
                                        'condition' => ' id = "' . $course_parent->parent_id . '" AND active = "y" AND type="'.$que_type.'"'
                                    )));
                            }
                        }

                        // $model = array();
                        if(!$temp_all){     
                            foreach ($manage->getData() as $i => $value) {
                             $modelQuestion[] = Coursequestion::getLimitData($value['group_id'], $value['manage_row'], $isPreTest);
                             foreach($modelQuestion as $key1 => $ques){
                                foreach($ques as $key2 => $val){                                
                                    $temp_test = new TempCourseQuiz;
                                    $temp_test->user_id = Yii::app()->user->id;
                                    $temp_test->course_id = $id;
                                    $temp_test->gen_id = $gen_id;
                                    $temp_test->group_id = $val['group_id'];
                                    $temp_test->ques_id = $val['ques_id'];
                                    $temp_test->type = $que_type;
                                    $choice = array();
                                    $choiceData = array();
                                    $choiceData = $val['choices'];
                                    $arrType4Answer = array();
                                    $Type4Question = array();

                                    foreach ($choiceData as $key => $val_choice) {
                                        if($val_choice->choice_type != 'dropdown'){
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

                                    // array_rand($choice); //Random choice

                                    $criteria=new CDbCriteria;
                                    $criteria->addInCondition('choice_id',$choice);
                                    $criteria->order = 'RAND() ';
                                    $rand_choice =  Coursechoice::model()->findAll($criteria);
                                    $choice_array = [];
                                    $num_checkk = 1;
                                    $num_check_2 = 0;
                                    foreach ($rand_choice as $key => $val_choice) {
                                        // $choice_array[] = $val_choice->choice_id;

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
                                    $temp_test->number = $key2+1;
                                    $temp_test->status = 0;
                                    if($key2==0){
                                        $temp_test->time_start = new CDbExpression('NOW()');
                                        $temp_test->time_up = $course->time_test*60;
                                    }
                                    $temp_test->save();
                                }
                            }
                        }
                    }
                    /*if(isset($_GET['number'])){
                        $sql_number = 'AND number = '.$_GET['number'];
                    } else {
                        $sql_number = 'AND status="0"';
                    }*/
                    if(is_numeric($_POST['actionEvnt'])){
                        $sql_number = 'AND number = '.$_POST['actionEvnt'];
                    } else {
                        $sql_number = 'AND status="0"';
                    }

                    $currentQuiz = TempCourseQuiz::model()->find(array(
                        'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND gen_id=:gen_id $sql_number order by id",
                        'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id, ':gen_id'=>$gen_id, ':type'=>$que_type)
                    ));

                    if(empty($currentQuiz)){
                        $currentQuiz = TempCourseQuiz::model()->find(array(
                            'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND gen_id=:gen_id order by id",
                            'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id, ':gen_id'=>$gen_id, ':type'=>$que_type)
                        ));
                    }
                    $model = Coursequestion::getTempData($currentQuiz['ques_id']);

                    if (count($model) != null || count($model) != 0) {
                        if(isset($_POST['actionEvnt'])){
                            if(isset($_POST['Choice'])){
                                foreach ($_POST['Question_type'] as $question_id => $value) {
                                    $update_temp = TempCourseQuiz::model()->find(array(
                                        'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." and ques_id=".$question_id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                    ));
                                    $update_temp->status = 1;
                                    $update_temp->ans_id = json_encode($_POST['Choice'][$question_id]);
                                    $update_temp->update();
                                }
                            }

                            if(isset($_POST["answer_sort"])){
                            $_POST["answer_sort"] = explode(",", $_POST["answer_sort"]);
                             foreach ($_POST['Question_type'] as $question_id => $value) {
                                $update_temp = TempCourseQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." and ques_id=".$question_id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = json_encode($_POST["answer_sort"]);
                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }
                        }

                            if(isset($_POST['dropdownVal'])){         
                                foreach ($_POST['Question_type'] as $question_id => $value) {

                                    $update_temp = TempCourseQuiz::model()->find(array(
                                        'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." and ques_id=".$question_id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                    ));

                                    $update_temp->status = 1;
                                    $update_temp->ans_id = json_encode($_POST['dropdownVal']);

                                    if(!$update_temp->update()) var_dump($update_temp->getErrors());
                                }
                            }

                            if(isset($_POST['lecture'])){
                            // var_dump($_POST['Question_type']);exit();

                            foreach ($_POST['Question_type'] as $question_id => $value) {

                                $update_temp = TempCourseQuiz::model()->find(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." and ques_id=".$question_id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                ));
                                $update_temp->status = 1;
                                $update_temp->ans_id = $_POST['lecture'];

                                if(!$update_temp->update()) var_dump($update_temp->getErrors());
                            }

                        }


                            if($_POST['actionEvnt']=="save" || $_POST['actionEvnt']=="timeup"){
                                if(isset($_GET['type'])){
                                    $type = $_GET['type'];
                                }else{
                                    $type = "post";
                                }

                                if($type == "course"){
                                    $type = "post";
                                }
                                $modelCoursescore = new Coursescore;
                                $modelCoursescore->course_id = $id;
                                $modelCoursescore->gen_id = $gen_id;
                                $modelCoursescore->type = $type;
                                $modelCoursescore->user_id = Yii::app()->user->id;
                                $modelCoursescore->save();

                                $temp_accept = TempCourseQuiz::model()->findAll(
                                   array('condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                               )); 
                                $countAllCoursequestion = 0;
                                $scoreSum = 0;


                                foreach ($temp_accept as $key => $value) {
                                    $result = 0;
                                    if($value->quest->ques_type==1){
                                        $countAllCoursequestion += 1;
                                        $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));
                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            $choiceUserAnswerArray = json_decode($value->ans_id);
                                        } 

                                        $choiceCorrect = $coursequestion->choices(array(
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
                                        foreach ($coursequestion->choices as $keyChoice => $choice) {
                                            // Save Logchoice
                                            $modelCourselogchoice = new Courselogchoice;
                                            $modelCourselogchoice->course_id = $id; // $_GET ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->test_type = $type;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = $choice->choice_answer == "1" ? '1' : '0';
                                            $modelCourselogchoice->logchoice_answer = (in_array($choice->choice_id, $choiceUserAnswerArray)) ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }

                                        // Save Logques
                                        $modelCourselogques = new Courselogques;
                                        $modelCourselogques->course_id = $id; // $_GET ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $type;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;
                                        if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                    }if($value->quest->ques_type==6){
                                        $countAllCoursequestion += 1;
                                        $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));
                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            // $choiceUserAnswerArray = json_decode($value->ans_id);
                                            $choiceUserAnswerArray = $value->ans_id;
                                        } 

                                        $choiceCorrect = $coursequestion->choices(array(
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
                                        foreach ($coursequestion->choices as $keyChoice => $choice) {
                                            // Save Logchoice
                                            $modelCourselogchoice = new Courselogchoice;
                                            $modelCourselogchoice->course_id = $id; // $_GET ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->test_type = $type;
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
                                        $modelCourselogques = new Courselogques;
                                        $modelCourselogques->course_id = $id; // $_GET ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $type;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;
                                         if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                    }else if($value->quest->ques_type==3){   //textarea
                                        $countAllCoursequestion += $value->quest->max_score;
                                        $coursequestion = CourseQuestion::model()->findByPk($value->ques_id);

                                        $result = 0;
                                            // Save Logchoice
                                        $modelCourselogchoice = new Courselogchoice;
                                            $modelCourselogchoice->course_id = $id; // $_GET ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->test_type = $type;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id =  '0';
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                            $modelCourselogchoice->is_valid_choice = '0';
                                            $modelCourselogchoice->logchoice_answer = '0';
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();

                                        // Save Logques

                                            $modelCourselogques = new Courselogques;
                                        $modelCourselogques->course_id = $id; // $_GET ID
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $type;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->logques_text = $value->ans_id;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;
                                         if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }

                                    }else if($value->quest->ques_type==2){
                                        $countAllCoursequestion += 1;
                                        $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));
                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            $choiceUserAnswerArray = json_decode($value->ans_id);
                                        } 

                                        $choiceCorrect = $coursequestion->choices(array(
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
                                        foreach ($coursequestion->choices as $keyChoice => $choice) {
                                            // Save Logchoice
                                            $modelCourselogchoice = new Courselogchoice;
                                            $modelCourselogchoice->course_id = $id; // $_GET ID
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->test_type = $type;
                                            $modelCourselogchoice->logchoice_select = 1;
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
                                        $modelCourselogques = new Courselogques;
                                        $modelCourselogques->course_id = $id; // $_GET ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $type;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;
                                         if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }
                                            
                                    } else if($value->quest->ques_type==4){ 

                                        $coursequestion = Coursequestion::model()->with('choices')->find("ques.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));                                        

                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            $choiceUserAnswerArray = json_decode($value->ans_id);
                                        } 

                                        $choiceUserQuestionArray = array();
                                        // $choiceUserQuestionArray = $coursequestion->choices(array(
                                        //     'condition' => 'choice_answer=1'
                                        // ));

                                        $key_atart = count(json_decode($value->question))-count($choiceUserAnswerArray);




                                        foreach (json_decode($value->question) as $key_q => $value_q) {
                                        if($key_atart <= $key_q){
                                            // var_dump($value_q);
                                            $choiceUserQuestionArray[] = Coursechoice::model()->findByPk($value_q);
                                        }
                                     }


                                        $choiceCorrectIDs = array();
                                        $choiceIsQuest = array();

                                        foreach ($choiceUserQuestionArray as $key => $value) {
                                            $countAllCoursequestion += 1;
                                            $choiceIsQuest[] = $value->choice_id;
                                            $choiceCorrectID['Anschoice_id'] = $choiceUserAnswerArray[$key];
                                            $checkValue = 0;

                                            $AnsChoice = $coursequestion->choices(array(
                                                'condition' => 'choice_id='.$choiceUserAnswerArray[$key].
                                                ' AND reference IS NOT NULL '
                                            ));

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
                                        //            echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><pre>';
                                        //     var_dump($choiceCorrectIDs);
                                        //     echo '-------------';
                                        // exit();

                                        $quest_score = 0;
                                        foreach ($coursequestion->choices as $keyChoice => $choice) {                            

                                            $is_valid_choice = 0;
                                            $logchoice_answer = 0;

                                            $modelCourselogchoice = new Courselogchoice;
                                                $modelCourselogchoice->course_id = $id; // $_POST ID
                                                $modelCourselogchoice->gen_id = $gen_id;
                                                $modelCourselogchoice->logchoice_select = 1;
                                                $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                                $modelCourselogchoice->choice_id = $choice->choice_id;
                                                $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                                $modelCourselogchoice->user_id = Yii::app()->user->id;
                                                $modelCourselogchoice->ques_type = $coursequestion->ques_type;
                                                $modelCourselogchoice->test_type = $type;


                                                $checkChoice_quest = (in_array($choice->choice_id, $choiceIsQuest)) ? $choice->choice_id : 0;

                                                if($checkChoice_quest!=0){  

                                                    $logchoice_answer = $choiceCorrectIDs[$checkChoice_quest]['Anschoice_id'];
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


                                            $modelCourselogques = new Courselogques;
                                            $modelCourselogques->course_id = $id; // $_POST ID
                                            $modelCourselogques->gen_id = $gen_id;
                                            $modelCourselogques->score_id = $modelCoursescore->score_id;
                                            $modelCourselogques->ques_id = $value->ques_id;
                                            $modelCourselogques->user_id = Yii::app()->user->id;
                                            $modelCourselogques->test_type = $type;
                                            $modelCourselogques->ques_type = $coursequestion->ques_type;
                                            $modelCourselogques->result = $quest_score;
                                            $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;
                                            if($coursequestion->ques_type == 3){
                                                $quesType_ = 1;
                                            }
                                        }
                                    }
                                    $sumPoint = $scoreSum * 100 / $countAllCoursequestion;
                                    if($quesType_ == 1){
                                    Coursescore::model()->updateByPk($modelCoursescore->score_id, array(
                                        'score_number' => $scoreSum,
                                        'update_date' => date('Y-m-d H:i:s'),
                                        'score_total' => $countAllCoursequestion,
                                        'score_past' => 'n',
                                    ));
                                }else{
                                    Coursescore::model()->updateByPk($modelCoursescore->score_id, array(
                                        'score_number' => $scoreSum,
                                        'update_date' => date('Y-m-d H:i:s'),
                                        'score_total' => $countAllCoursequestion,
                                        'score_past' => ($sumPoint >= $scorePercent) ? 'y' : 'n',
                                    ));
                                }
                                    $modelScore = Coursescore::model()->findByPk($modelCoursescore->score_id);
                                    if ($sumPoint >= $scorePercent && $modelCoursescore->type != "pre") { // สอบ post ถึงจะผ่าน
                                        // $passCoursModel = Passcours::model()->findByAttributes(array(
                                        //     'passcours_cates' => $course->cate_id,
                                        //     'passcours_user' => Yii::app()->user->id,
                                        //     'gen_id' => $gen_id
                                        // ));
                                        // if (!$passCoursModel) {
                                        //     $modelPasscours = new Passcours;
                                        //     $modelPasscours->passcours_cates = $course->cate_id;
                                        //     $modelPasscours->gen_id = $gen_id;
                                        //     $modelPasscours->passcours_cours = $course->course_id;
                                        //     $modelPasscours->passcours_user = Yii::app()->user->id;
                                        //     $modelPasscours->passcours_date = new CDbExpression('NOW()');
                                        //     $modelPasscours->save();
                                        // }

                                        $coruse_percents =  Helpers::lib()->percent_CourseGen($course->course_id, $gen_id);
                                        $checkpasscouse =  Helpers::lib()->checkpasscouse($coruse_percents,$course->course_id, $gen_id);
                            
                                        $this->SendMailLearn($course->course_id);  // final ผ่าน ส่ง อีเมล์
                                    }elseif($modelCoursescore->type != "pre" && ($countCoursescore+1) == $course->cate_amount){
                                        $this->SendMailLearn($course->course_id); // final สอบครบจำนวน แต่ยังไม่ผ่าน                     
                                    }
                                    $this->actiondeleteTemp($id);
                                    Helpers::lib()->checkDateStartandEnd(Yii::app()->user->id,$course->course_id);
                                    // $this->SendMailLearn($course->course_id);
                                    $this->renderPartial('exams_finish', array(
                                        'quesType_'=>$type_question,
                                        'model' => $model,
                                        'testType' => $type,
                                        'quesType' => $quesType_,
                                        'course' => $course,
                                        'temp_all' => $temp_all,
                                        'modelScore' => $modelScore,
                                        'label'=>$label,
                                        'labelCourse'=>$labelCourse,
                                        'gen'=>$gen_id
                                    ));
                                } else {                          
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

                                    $count_no_select = TempCourseQuiz::model()->count(array(
                                        'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                        'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id, ':gen_id'=>$gen_id, ':type'=>$que_type)
                                    ));
                                    $last_ques = $count_no_select == 0 ? 1 : 0;
                                    $currentQuiz = TempCourseQuiz::model()->find(array(
                                        'condition' => "user_id=:user_id AND course_id=:course_id AND type=:type AND number=:number AND gen_id=:gen_id order by id",
                                        'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id,':number' => $idx, ':gen_id'=>$gen_id, ':type'=>$que_type)
                                    ));
                                    $model = Coursequestion::getTempData($currentQuiz['ques_id']);
                                    $temp_all = TempCourseQuiz::model()->findAll(array(
                                        'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                    ));
                                    $countExam = count($temp_all) - $count_no_select;
                                    $this->renderPartial('exams_next', array(
                                        'model' => $model,
                                        'course' => $course,
                                        'temp_all' => $temp_all,
                                        'currentQuiz' => $currentQuiz,
                                        'last_ques' => $last_ques,
                                        'countExam' => $countExam,
                                        'label'=>$label,
                                        'labelCourse'=>$labelCourse,
                                        'gen'=>$gen_id
                                    ));
                                }
                            } else {

                                $temp_all = TempCourseQuiz::model()->findAll(array(
                                    'condition' => "user_id=".Yii::app()->user->id." and course_id=".$id." AND gen_id='".$gen_id."' AND type='".$que_type."'"
                                ));
                                $count_no_select = TempCourseQuiz::model()->count(array(
                                    'condition' => "user_id=:user_id AND type=:type AND course_id=:course_id AND status='0' AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $id, ':gen_id'=>$gen_id, ':type'=>$que_type)
                                ));

                                $last_ques = $count_no_select == 0 ? 1 : 0;
                                $countExam = count($temp_all) - $count_no_select;

                                $this->render('exams', array(
                                    'model' => $model,
                                    'course' => $course,
                                    'currentQuiz' => $currentQuiz,
                                    'temp_all' => $temp_all,
                                    'time_up' => $temp_all[0]->time_up,
                                    'last_ques' => $last_ques,
                                    'countExam' => $countExam,
                                    'label'=>$label,
                                    'labelCourse'=>$labelCourse
                                ));
                            }
                        } else {
                            Yii::app()->user->setFlash('CheckQues',$label->label_alert_noTest);
                            Yii::app()->user->setFlash('class', "error");

                            $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
                        }
                    }
                }
            } else {
                if(Yii::app()->session['lang'] == 2){
                Yii::app()->user->setFlash('CheckQues',$label->label_alert_error);
            }else{
                Yii::app()->user->setFlash('CheckQues', "error");
            }
                Yii::app()->user->setFlash('class', "error");

                $this->redirect(array('//course/detail', 'id' => $id,'gen' => $gen_id));
            }
        } else {
            Yii::app()->user->setFlash('regiserror', $label->label_alert_expired);
            Yii::app()->user->setFlash('messages', $label->label_alert_plsLogin);
            $this->redirect(array(
                "//site/index",
            ));
        }
    }

    public function actionScore($id)
    {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $model = Coursescore::model()->findByPk($id);
        if ($model->user_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('CheckQues', "เกิดข้อผิดพลาด ไม่สามารถตรวจสอบได้");
            $this->redirect(array('//categoryLesson/index'));
        } else {
            $this->render('score', array('model' => $model));
        }
    }

    public function actionScoreAll($id)
    {
        $que_type = "course";
        if(isset($_GET['type'])){
            $que_type = $_GET['type']; // pre
        }

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        if($que_type == "course"){
                    $que_type = "post";
                }
        $course_model = CourseOnline::model()->findByPk($id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        $model = Coursescore::model()->findAll(array(
            'condition' => 'course_id=' . $id . ' and active = "y" AND user_id=' . Yii::app()->user->id." AND gen_id='".$gen_id."' AND type='".$que_type."'",
        ));
        $this->render('scoreAll', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Coursequestion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coursequestion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actiondeleteTemp($lesson_id=null){

        $que_type = "course";
        if(isset($_GET['type'])){
            $que_type = $_GET['type']; // pre
        }

        $course_model = CourseOnline::model()->findByPk($lesson_id);
        $gen_id = $course_model->getGenID($course_model->course_id);
        
        TempCourseQuiz::model()->deleteAll(array(
            'condition' => "user_id=:user_id AND course_id=:course_id AND gen_id=:gen_id AND type=:type",
            'params' => array(':user_id' => Yii::app()->user->id,':course_id' => $lesson_id, ':gen_id'=>$gen_id, ':type'=>$que_type)
        )); 
    }
    public function actionSaveTimeExam(){
        $que_type = "course";
        if(isset($_GET['type'])){
            $que_type = $_GET['type']; // pre
        }

        $course_model = CourseOnline::model()->findByPk($_POST['course_id']);
        $gen_id = $course_model->getGenID($course_model->course_id);
       $temp_time_start = TempCourseQuiz::model()->find(array(
        'condition' => "user_id=".Yii::app()->user->id." and course_id=".$_POST['course_id']." and time_start is not null AND gen_id='".$gen_id."' AND type='".$que_type."'"
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
     // $temp_time_start->time_up = $_POST['time'];
     // echo ($temp_time_start->update()) ? 'success' : 'error';
}

public function SendMailLearn($id){

    $user_id = Yii::app()->user->id;
    $modelUser = User::model()->findByPk($user_id);
    $modelCourseName = CourseOnline::model()->findByPk($id);
    $gen_id = $modelCourseName->getGenID($modelCourseName->course_id);
    $criteria = new CDbCriteria;
    $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
    $criteria->compare('t.course_id',$id);
    $criteria->compare('t.gen_id',$gen_id);
    $criteria->compare('t.user_id',$user_id);
    $criteria->compare('lesson_active','y');
    $criteria->compare('les.active','y');

    $learn = Learn::model()->findAll($criteria);
    $message = $this->renderPartial('_email',array(
        'user_id'=>$user_id,
        'modelUser'=>$modelUser,
        'modelCourseName'=>$modelCourseName,
        'learn'=>$learn,
    ),true);
    $to = array();
    $filepath = array();
        //$email_ref = $modelMember->m_ref_email1;
       $to['email'] = $modelUser->email;//'chalermpol.vi@gmail.com';
        // $to['email'] = 'jojo99za@gmail.com';//'chalermpol.vi@gmail.com';
       $to['firstname'] = $modelUser->profile->firstname;
       $to['lastname'] = $modelUser->profile->lastname;
       // $subject = 'ผลการเรียน หลักสูตร  : ' . $modelCourseName->course_title;
       $subject = 'Exams score\ ผลการทดสอบหลักสูตร  : ' . $modelCourseName->course_title;

       if($message){
         if(Helpers::lib()->SendMail($to, $subject, $message)){
        //if(Helpers::lib()->SendMailLearnPass($to, $subject, $message)){
            $model = new LogEmail;
            $model->user_id = $user_id;
            $model->course_id = $id;
            $model->gen_id = $gen_id;
            $model->message = $message;
            if(!$model->save())var_dump($model->getErrors()); 
        }
    }
}



}
