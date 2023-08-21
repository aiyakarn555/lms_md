<?php

class Questionnaire_courseController extends Controller
{
//    public $layout = '//layouts/column2';

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

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'out', 'report'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIndex($id,$gen = 0)
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

        $courseTeacher = $this->loadModel($id);

        $course_id_root = $courseTeacher->course_id;

        $course = CourseOnline::model()->findByPk($courseTeacher->course_id);
        $gen_id = $gen != 0 ? $gen : $course->getGenID($course->course_id);

        // if ($langId != 1) {
        //     $course = CourseOnline::model()->find("parent_id=".$course->course_id." AND lang_id =".$langId);
        //     $courseTeacher = CourseTeacher::model()->find("course_id=".$course->course_id);
        // }

        // echo '<pre>';var_dump($courseTeacher);exit();
        $questAns = QQuestAns_course::model()->find("user_id='" . Yii::app()->user->id . "' AND course_id='" . $courseTeacher->course_id . "' AND header_id='" . $courseTeacher->survey_header_id . "' AND teacher_id='" . $courseTeacher->teacher_id . "' AND gen_id='".$gen_id."'");
        // if ($questAns) {
        //     $this->redirect(array('/course/detail', 'id' => $courseTeacher->course_id));
        //     echo "คุณเคยทำแบบสอบถามแล้ว";
        //     // exit;
        // }
        $PaQuest = false;
        if ($courseTeacher) {

            $checkAnswer = QQuestAns_course::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'course_id' => $course_id_root, 'gen_id'=>$gen_id
            ));

            if (!$checkAnswer) {
                $course_check = CourseOnline::model()->findAll("parent_id=".$course_id_root);
                foreach ($course_check as $key => $value) {
                    $checkAnswer_parent = QQuestAns_course::model()->findByAttributes(array(
                        'user_id' => Yii::app()->user->id,
                        'course_id' => $value->course_id, 'gen_id'=>$gen_id
                    ));
                    if ($checkAnswer_parent) {
                        $PaQuest = true;
                    }
                }
            }else{
                $PaQuest = true;
            }
            // $passQuest = QQuestAns_course::model()->find(array(
            //     'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $courseTeacher->course->course_id . '"'." AND gen_id='".$gen_id."'",
            // ));
            // $countSurvey = count($passQuest);
            // if ($passQuest) {
            //     $PaQuest = true;
            // }
        }else{
            $PaQuest = true;
        }

        if($PaQuest){ //ทำแบบสอบถามแล้ว
            $this->redirect(array('/course/questionnaire', 'id' => $course_id_root,'gen'=>$gen_id));
        }

        if (isset($_POST['choice'])) {
            $log = new QQuestAns_course;
            $log->user_id = Yii::app()->user->id;
            $log->course_id = $courseTeacher->course_id;
            $log->gen_id = $gen_id;
            $log->header_id = $courseTeacher->survey_header_id;
            $log->teacher_id = $courseTeacher->teacher_id;
            $log->date = date('Y-m-d H:i:s');
            $log->save();

            if (isset($_POST['choice']['input'])) {
                foreach ($_POST['choice']['input'] as $option_choice_id => $value) {
                    $answers = new QAnswers_course;
                    $answers->user_id = Yii::app()->user->id;
                    $answers->gen_id = $gen_id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_text = $value;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['radio'])) {
                foreach ($_POST['choice']['radio'] as $question_id => $option_choice_id) {
                    $answers = new QAnswers_course;
                    $answers->gen_id = $gen_id;
                    $answers->user_id = Yii::app()->user->id;
                    $answers->choice_id = $option_choice_id;
                    if (isset($_POST['choice']['radioOther'][$question_id][$option_choice_id])) {
                        $answers->answer_text = $_POST['choice']['radioOther'][$question_id][$option_choice_id];
                    }
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['checkbox'])) {
                foreach ($_POST['choice']['checkbox'] as $question_id => $checkboxArray) {
                    foreach ($checkboxArray as $key => $option_choice_id) {
                        $answers = new QAnswers_course;
                        $answers->gen_id = $gen_id;
                        $answers->user_id = Yii::app()->user->id;
                        $answers->choice_id = $option_choice_id;
                        if (isset($_POST['choice']['checkboxOther'][$question_id][$option_choice_id])) {
                            $answers->answer_text = $_POST['choice']['checkboxOther'][$question_id][$option_choice_id];
                        }
                        $answers->quest_ans_id = $log->id;
                        $answers->save();
                    }
                }
            }

            if (isset($_POST['choice']['contentment'])) {
                foreach ($_POST['choice']['contentment'] as $option_choice_id => $score) {
                    $answers = new QAnswers_course;
                    $answers->gen_id = $gen_id;
                    $answers->user_id = Yii::app()->user->id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_numeric = $score;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['text'])) {
                foreach ($_POST['choice']['text'] as $option_choice_id => $value) {
                    $answers = new QAnswers_course;
                    $answers->gen_id = $gen_id;
                    $answers->user_id = Yii::app()->user->id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_textarea = $value;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }
            $this->redirect(array('/course/questionnaire', 'id' => $course_id_root,'gen'=>$gen_id));
        }
        // var_dump($courseTeacher);exit();
        $this->render('index2', array(
            'questionnaire' => $courseTeacher,
            'label' => $label,
            'labelCourse' => $labelCourse,
            'course' => $course,
        ));
    }

    public function actionReport($id)
    {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $courseTeacher = $this->loadModel($id);
//		$criteria=new CDbCriteria;
//		$criteria->addCondition('teacher_id='.$courseTeacher->teacher_id);
//		$criteria->addCondition('course_id='.$courseTeacher->course_id);

//		$courseTeacher = QQuestAns_course::model()->find($criteria);

        $this->render('report', array(
            'questionnaire' => $courseTeacher,
        ));
    }

    public function actionOut($id)
    {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        $user = User::model()->find("username = '" . $_GET['username'] . "' AND email = '" . $_GET['username'] . "'");
        if (!$user) {
            echo "คุณไม่มีสิทธิ์ทำแบบสอบถาม";
            exit;
        }
        $header = QHeader::model()->findByPk($id);
        $questAns = QQuestAns_course::model()->find("user_id='" . $user->id . "' AND header_id='" . $header->survey_header_id . "' AND gen_id IS NULL");

        if ($questAns) {
            echo "คุณเคยทำแบบสอบถามแล้ว";
            exit;
        }

        if (isset($_POST['choice'])) {
            $log = new QQuestAns_course;
            $log->user_id = $user->id;
            $log->header_id = $header->survey_header_id;
            $log->teacher_id = $_GET['teacher_id'];
            $log->date = date('Y-m-d H:i:s');
            $log->save();

            if (isset($_POST['choice']['input'])) {
                foreach ($_POST['choice']['input'] as $option_choice_id => $value) {
                    $answers = new QAnswers_course;
                    $answers->user_id = $user->id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_text = $value;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['radio'])) {
                foreach ($_POST['choice']['radio'] as $question_id => $option_choice_id) {
                    $answers = new QAnswers_course;
                    $answers->user_id = $user->id;
                    $answers->choice_id = $option_choice_id;
                    if (isset($_POST['choice']['radioOther'][$question_id][$option_choice_id])) {
                        $answers->answer_text = $_POST['choice']['radioOther'][$question_id][$option_choice_id];
                    }
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['checkbox'])) {
                foreach ($_POST['choice']['checkbox'] as $question_id => $checkboxArray) {
                    foreach ($checkboxArray as $key => $option_choice_id) {
                        $answers = new QAnswers_course;
                        $answers->user_id = $user->id;
                        $answers->choice_id = $option_choice_id;
                        if (isset($_POST['choice']['checkboxOther'][$question_id][$option_choice_id])) {
                            $answers->answer_text = $_POST['choice']['checkboxOther'][$question_id][$option_choice_id];
                        }
                        $answers->quest_ans_id = $log->id;
                        $answers->save();
                    }
                }
            }

            if (isset($_POST['choice']['contentment'])) {
                foreach ($_POST['choice']['contentment'] as $option_choice_id => $score) {
                    $answers = new QAnswers_course;
                    $answers->user_id = $user->id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_numeric = $score;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            if (isset($_POST['choice']['text'])) {
                foreach ($_POST['choice']['text'] as $option_choice_id => $value) {
                    $answers = new QAnswers_course;
                    $answers->user_id = $user->id;
                    $answers->choice_id = $option_choice_id;
                    $answers->answer_textarea = $value;
                    $answers->quest_ans_id = $log->id;
                    $answers->save();
                }
            }

            $this->redirect(array('/course/index'));

        }
        $this->render('out', array(
            'header' => $header,
        ));
    }

    public function loadModel($id)
    {
        $model = CourseTeacher::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
