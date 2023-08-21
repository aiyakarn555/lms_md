<?php

class QuestionOnlineController extends Controller
{

    public function init()
    {
        parent::init();

        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        } else {
            $langId = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
        }
        $label = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$label) {
            $label = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        if (Yii::app()->user->id == null) {


            $msg = $label->label_alert_msg_plsLogin;
            Yii::app()->user->setFlash('msg', $msg);
            Yii::app()->user->setFlash('icon', 'warning');



            $this->redirect(array('site/index'));
            exit();
        }


        $this->lastactivity();
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */

    public function actionPreExams($id = null)
    {
        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;
        } else {
            $langId = Yii::app()->session['lang'];
        }

        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }

        $isPreTest = Helpers::isPretestStateOnline($id);
        $testType = $isPreTest ? 'pre' : 'post';
        $testType = (empty($_GET['type'])) ?  $testType : $_GET['type'];

        $lesson = LessonOnline::model()->findByPk($id);
        $gen_id = 0;
        $manage = ManageOnline::Model()->findAll("id=:id AND type=:type", array("id" => $id, ":type" => $testType));


        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        } else {
            $langId = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
        }

        $label = MenuCoursequestion::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$label) {
            $label = MenuCoursequestion::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $labelCourse = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$labelCourse) {
            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }


        $arr_id_ques = array();
        foreach ($manage as $key => $value) {
            $total_score += $value->manage_row;
            $check_ques = QuestionOnline::model()->findAll("active='y' AND ques_type=4 AND group_id='" . $value->group_id . "'");
            if (!empty($check_ques)) {
                foreach ($check_ques as $keyy => $valuee) {
                    $arr_id_ques[] = $valuee->ques_id;
                }
            } else {
                $check_ques = QuestionOnline::model()->findAll("active='y' AND ques_type=3 AND group_id='" . $value->group_id . "'");
                if (!empty($check_ques)) {
                    $total_score = 0;
                    foreach ($check_ques as $key => $value) {
                        $total_score += $value->max_score;
                    }
                }
            }
        }

        $num_choice = 0;
        if (!empty($arr_id_ques)) {
            foreach ($arr_id_ques as $key => $value) {
                $check_choice = ChoiceOnline::model()->findAll("active='y' AND choice_answer=1 AND choice_type='dropdown' AND ques_id='" . $value . "'");
                if (!empty($check_choice)) {
                    $num_choice = $num_choice + count($check_choice);
                }
            }
        }

        $currentQuiz = TempQuizOnline::model()->find(array(
            'condition' => "user_id=:user_id AND lesson_teams_id=:lesson_teams_id AND type=:type AND gen_id=:gen_id order by id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson_teams_id' => $id, ':type' => $testType, ':gen_id' => $gen_id)
        ));
        // Not found and redirect
        if (!$manage) {
            Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
            Yii::app()->user->setFlash('class', "error");
            $this->redirect(array(
                "//examsonline/detail/$lesson->ms_teams_id",
            ));
        }
        if ($currentQuiz) {

            $this->redirect(array(
                'questiononline/index',
                'id' => $lesson->id,
                'type' => $testType,
                'labelCourse' => $labelCourse
            ));
        } else {

            $this->render('pre_exams', array(
                'lesson' => $lesson,
                //'manage' => $manage,
                'num_choice' => $num_choice,
                'total_score' => $total_score,
                'label' => $label,
                'labelCourse' => $labelCourse,
                'testType' => $testType
            ));
        }
    }

    public function actionIndex($id = null)
    {
        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }
        if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
            $langId = Yii::app()->session['lang'] = 1;
            Yii::app()->language = 'en';
        } else {
            $langId = Yii::app()->session['lang'];
            Yii::app()->language = (Yii::app()->session['lang'] == 1) ? 'en' : 'th';
        }
        $label = MenuCoursequestion::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$label) {
            $label = MenuCoursequestion::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        $labelCourse = MenuCourse::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if (!$labelCourse) {
            $labelCourse = MenuCourse::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }

        $quesType_ = 2; // เช็คว่ามี ข้อสอบ 3 บรรยาย ไหม
        $type_question = 0; // ประเภทข้อสอบ


        $id = isset($_POST['lesson_id']) ? $_POST['lesson_id'] : $id;
        $user_lesson = User::model()->findByPk(Yii::app()->user->id);

        if ($langId == 1) {
            $lesson = LessonOnline::model()->findByPk($id);
        } else {
            $lesson = LessonOnline::model()->findByPk($id);
            $lesson_parent = LessonOnline::model()->find("parent_id=" . $id . " AND lang_id =" . $langId);
        }

        $gen_id = 0;


        $isChkPreTest = $_GET['type'] == 'pre';
        $testType = $isChkPreTest ? 'pre' : 'post';
        $isPreTest = ($isChkPreTest == 'pre') ? true : false;

        if ($lesson) {
            $lessonStatus = Helpers::lib()->isPretestStateOnline($lesson);
        }

        if (!$lessonStatus || $isPreTest) {
            $countScore = ScoreOnline::Model()->count("lesson_teams_id=:lesson_teams_id AND user_id=:user_id AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                "lesson_teams_id" => $id,
                "user_id" => Yii::app()->user->id,
                "type" => $testType, ':gen_id' => $gen_id
            ));

            $countManage = ManageOnline::Model()->count("id=:id AND active=:active AND type=:type", array(
                "id" => $id,
                "active" => "y",
                "type" => $testType
            ));

            // Not found and redirect

            if (!$countManage) {

                Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
                Yii::app()->user->setFlash('class', 'error');

                $this->redirect(array(
                    '//examsonline/detail',
                    'lesson_id' => $id,
                    'id' => $lesson->ms_teams_id,
                    'label' => $label,
                ));
            }

            if ($countScore == $lesson->cate_amount) //สอบครบจำนวน
            {

                $countScorePast = ScoreOnline::model()->findAll(array(
                    'condition' => ' lesson_teams_id = "' . $id . '"
                    AND user_id    = "' . Yii::app()->user->id . '"
                    AND type       = "' . $testType . '"
                    AND active       = "y"
                    AND gen_id     = "' . $gen_id . '"
                    ',
                ));
                if (!empty($countScorePast)) {
                    // Pass
                    Yii::app()->user->setFlash('CheckQues', $label->label_alert_testPass);
                    Yii::app()->user->setFlash('class', 'success');
                    $this->redirect(array(
                        '//examsonline/detail', 'id' => $lesson->ms_teams_id, 'lesson_id' => $id,
                        'label' => $label
                    ));
                } else {
                    // Not Pass
                    Yii::app()->user->setFlash('CheckQues', $label->label_alert_testFail);
                    Yii::app()->user->setFlash('class', 'error');
                    $this->redirect(array('//examsonline/detail', 'id' => $lesson->ms_teams_id, 'lesson_id' => $id, 'label' => $label));
                }
            } else {
                $countScorePast = ScoreOnline::Model()->count("lesson_teams_id=:lesson_id AND user_id=:user_id AND score_past=:score_past AND type=:type AND active = 'y' AND gen_id=:gen_id", array(
                    "lesson_id" => $id,
                    "user_id" => Yii::app()->user->id,
                    "score_past" => "y",
                    "type" => $testType, ':gen_id' => $gen_id
                ));

                if (!empty($countScorePast)) {
                    //pass
                    Yii::app()->user->setFlash('CheckQues', $label->label_alert_testPass);
                    Yii::app()->user->setFlash('class', 'success');
                    $this->redirect(array('//examsonline/detail', 'id' => $lesson->ms_teams_id, 'lesson_id' => $id));
                } else {

                    $scorePercent = $lesson->cate_percent;

                    $manage = new CActiveDataProvider(
                        'ManageOnline',
                        array(
                            'criteria' => array(
                                'condition' => ' id = "' . $id . '" AND active = "y" AND type = "' . $testType . '" '
                            )
                        )
                    );

                    $temp_all = TempQuizOnline::model()->findAll(array(
                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                    ));

                    if (empty($temp_all)) {
                        $countchoice = 0;
                        $created_date_temp = date("Y-m-d H:i:s");
                        foreach ($manage->getData() as $i => $value) {
                            $modelQuestion[] = QuestionOnline::getLimitData($value['group_id'], $value['manage_row']);
                            foreach ($modelQuestion as $key1 => $ques) {
                                foreach ($ques as $key2 => $val) {
                                    $temp_test = new TempQuizOnline;
                                    $temp_test->user_id = Yii::app()->user->id;
                                    $temp_test->lesson_teams_id = $lesson->id;
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
                                        if ($val_choice->choice_type != 'dropdown') {
                                            // if($val_choice->choice_type != 'radio'){
                                            $choice[] = $val_choice->choice_id;
                                            // echo 'NO';
                                        } else {
                                            $ranNumber = rand(1, 10000000);
                                            if ($val_choice->choice_answer == 2) {
                                                $arrType4Answer[$ranNumber] = $val_choice->choice_id;
                                            }
                                            if ($val_choice->choice_answer == 1) {
                                                $choice[] = $val_choice->choice_id;
                                            }
                                        }
                                    }


                                    if ($arrType4Answer) {
                                        ksort($arrType4Answer);
                                        $choiceA = array();
                                        foreach ($arrType4Answer as $key => $arrTypeVal) {
                                            $choiceA[] = $arrTypeVal;
                                        }
                                        $choice = array_merge($choice, $choiceA);
                                    }

                                    $criteria = new CDbCriteria;
                                    $criteria->addInCondition('choice_id', $choice);
                                    $criteria->order = 'RAND() ';
                                    $rand_choice =  ChoiceOnline::model()->findAll($criteria);
                                    $choice_array = [];
                                    $num_checkk = 1;
                                    $num_check_2 = 0;
                                    foreach ($rand_choice as $key => $val_choice) {
                                        if ($val_choice->choice_answer == 1 && $val_choice->choice_type == 'dropdown') {
                                            $choice_array[count($rand_choice) - $num_checkk] = $val_choice->choice_id;
                                            $num_checkk++;
                                        } else {
                                            $choice_array[$num_check_2] = $val_choice->choice_id;
                                            $num_check_2++;
                                        }
                                    }

                                    ksort($choice_array);
                                    $temp_test->question = json_encode($choice_array);

                                    // $temp_test->question = json_encode($choice);
                                    $temp_test->number = $key2 + 1;
                                    $temp_test->status = 0;
                                    if ($key2 == 0) {
                                        $temp_test->time_start = new CDbExpression('NOW()');
                                        $temp_test->time_up = $lesson->time_test * 60;
                                    }
                                    $temp_test->created_date = $created_date_temp;
                                    $temp_test->save();
                                }
                            }
                        }
                    }
                    if (is_numeric($_POST['actionEvnt'])) {
                        $sql_number = 'AND number = ' . $_POST['actionEvnt'];
                    } else {
                        $sql_number = 'AND status="0"';
                    }
                    /*if(isset($_POST['number'])){
                    $sql_number = 'AND number = '.$_POST['number'];
                } else {
                    $sql_number = 'AND status="0"';
                }*/
                    $currentQuiz = TempQuizOnline::model()->find(array(
                        'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type " . $sql_number . " AND gen_id=:gen_id order by id",
                        'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => $testType, ':gen_id' => $gen_id)
                    ));

                    if (empty($currentQuiz)) {
                        $currentQuiz = TempQuizOnline::model()->find(array(
                            'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND gen_id=:gen_id order by id",
                            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => $testType, ':gen_id' => $gen_id)
                        ));
                    }

                    $model = QuestionOnline::getTempData($currentQuiz['ques_id']);
                    if (count($model) != null || count($model) != 0) {
                        if (isset($_POST['actionEvnt'])) {
                            if (isset($_POST['Choice'])) {
                                foreach ($_POST['Question_type'] as $question_id => $value) {
                                    $update_temp = TempQuizOnline::model()->find(array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $lesson->id . " and ques_id=" . $question_id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                                    ));
                                    $update_temp->status = 1;
                                    $update_temp->ans_id = json_encode($_POST['Choice'][$question_id]);
                                    if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                }
                            }

                            if (isset($_POST["answer_sort"])) {
                                $_POST["answer_sort"] = explode(",", $_POST["answer_sort"]);
                                foreach ($_POST['Question_type'] as $question_id => $value) {
                                    $update_temp = TempQuizOnline::model()->find(array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $lesson->id . " and ques_id=" . $question_id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                                    ));
                                    $update_temp->status = 1;
                                    $update_temp->ans_id = json_encode($_POST["answer_sort"]);
                                    if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                }
                            }

                            if (isset($_POST['dropdownVal'])) {

                                foreach ($_POST['Question_type'] as $question_id => $value) {
                                    $update_temp = TempQuizOnline::model()->find(array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $lesson->id . " and ques_id=" . $question_id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                                    ));
                                    $update_temp->status = 1;
                                    $update_temp->ans_id = json_encode($_POST['dropdownVal']);

                                    if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                }
                            }

                            if (isset($_POST['lecture'])) {
                                // var_dump($_POST['Question_type']);exit();

                                foreach ($_POST['Question_type'] as $question_id => $value) {

                                    $update_temp = TempQuizOnline::model()->find(array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $lesson->id . " and ques_id=" . $question_id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                                    ));
                                    $update_temp->status = 1;
                                    $update_temp->ans_id = $_POST['lecture'];

                                    if (!$update_temp->update()) var_dump($update_temp->getErrors());
                                }
                            }


                            if ($_POST['actionEvnt'] == "save" || $_POST['actionEvnt'] == "timeup") {
                                $modelCoursescore = new ScoreOnline;
                                $modelCoursescore->lesson_teams_id = $id;
                                $modelCoursescore->gen_id = $gen_id;
                                //$modelCoursescore->manage_id = $value['group_id'];
                                $modelCoursescore->type = $testType;
                                $modelCoursescore->ms_teams_id = $lesson->ms_teams_id;
                                $modelCoursescore->user_id = Yii::app()->user->id;
                                $modelCoursescore->save();

                                $temp_accept = TempQuizOnline::model()->findAll(
                                    array(
                                        'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
                                    )
                                );
                                $countAllCoursequestion = 0;
                                $scoreSum = 0;

                                foreach ($temp_accept as $key => $value) {
                                    $result = 0;

                                    if ($value->quest->ques_type == 1) {
                                        $countAllCoursequestion += 1;

                                        $coursequestion = QuestionOnline::model()->with('chioce')->find("question.ques_id=:id", array(
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
                                            $modelCourselogchoice = new LogchoiceOnline;
                                            $modelCourselogchoice->lesson_teams_id = $id; // $_POST ID
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
                                        $modelCourselogques = new LogquesOnline;
                                        $modelCourselogques->lesson_teams_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();

                                        $type_question = $coursequestion->ques_type;

                                        if ($coursequestion->ques_type == 3) {
                                            $quesType_ = 1;
                                        }
                                    } else if ($value->quest->ques_type == 3) {
                                        $countAllCoursequestion += $value->quest->max_score;
                                        $scoreTotal += $value->quest->max_score;
                                        $coursequestion = QuestionOnline::model()->findByPk($value->ques_id);

                                        $result = 0;
                                        // Save Logchoice
                                        $modelCourselogchoice = new LogchoiceOnline;
                                        $modelCourselogchoice->lesson_teams_id = $id; // $_POST ID
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
                                        $modelCourselogques = new LogquesOnline;
                                        $modelCourselogques->lesson_teams_id = $id; // $_POST ID
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
                                        if ($coursequestion->ques_type == 3) {
                                            $quesType_ = 1;
                                        }
                                    } else if ($value->quest->ques_type == 6) {
                                        $countAllCoursequestion += 1;

                                        $coursequestion = QuestionOnline::model()->with('chioce')->find("question.ques_id=:id", array(
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
                                            $modelCourselogchoice = new LogchoiceOnline;
                                            $modelCourselogchoice->lesson_teams_id = $id; // $_POST ID
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
                                        $modelCourselogques = new LogquesOnline;
                                        $modelCourselogques->lesson_teams_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if ($coursequestion->ques_type == 3) {
                                            $quesType_ = 1;
                                        }
                                    } else if ($value->quest->ques_type == 2) {
                                        $countAllCoursequestion += 1;
                                        $coursequestion = QuestionOnline::model()->with('chioce')->find("question.ques_id=:id", array(
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
                                            $modelCourselogchoice = new LogchoiceOnline;
                                            $modelCourselogchoice->lesson_teams_id = $id; // $_POST ID
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
                                        $modelCourselogques = new LogquesOnline;
                                        $modelCourselogques->lesson_teams_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $result;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if ($coursequestion->ques_type == 3) {
                                            $quesType_ = 1;
                                        }
                                    } else if ($value->quest->ques_type == 4) {
                                        $coursequestion = QuestionOnline::model()->with('chioce')->find("question.ques_id=:id", array(
                                            "id" => $value->ques_id,
                                        ));

                                        $choiceUserAnswerArray = array();
                                        if (isset($value->ans_id)) {
                                            $choiceUserAnswerArray = json_decode($value->ans_id);
                                        }

                                        $choiceUserQuestionArray = array();

                                        $key_atart = count(json_decode($value->question)) - count($choiceUserAnswerArray);

                                        foreach (json_decode($value->question) as $key_q => $value_q) {

                                            if ($key_atart <= $key_q) {
                                                $choiceUserQuestionArray[] = ChoiceOnline::model()->findByPk($value_q);
                                            }
                                        }

                                        $choiceCorrectIDs = array();
                                        $choiceIsQuest = array();



                                        foreach ($choiceUserQuestionArray as $key => $value) {
                                            $countAllCoursequestion += 1;
                                            $choiceIsQuest[] = $value->choice_id;
                                            $choiceCorrectID['Anschoice_id'] = $choiceUserAnswerArray[$key];
                                            $checkValue = 0;

                                            $AnsChoice = $coursequestion->chioce(array(
                                                'condition' => 'choice_id=' . $choiceUserAnswerArray[$key] .
                                                    ' AND reference IS NOT NULL '
                                            ));

                                            // var_dump($AnsChoice);
                                            // var_dump($AnsChoice[0]->reference." == ".$value->choice_id);
                                            if ($AnsChoice) {
                                                if ($AnsChoice[0]->reference == $value->choice_id) {
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

                                            $modelCourselogchoice = new LogchoiceOnline;
                                            $modelCourselogchoice->lesson_teams_id = $id; // $_POST ID
                                            $modelCourselogchoice->logchoice_select = 1;
                                            $modelCourselogchoice->gen_id = $gen_id;
                                            $modelCourselogchoice->score_id = $modelCoursescore->score_id;
                                            $modelCourselogchoice->choice_id = $choice->choice_id;
                                            $modelCourselogchoice->ques_id = $coursequestion->ques_id;
                                            $modelCourselogchoice->user_id = Yii::app()->user->id;
                                            $modelCourselogchoice->ques_type = $coursequestion->ques_type;


                                            $checkChoice_quest = (in_array($choice->choice_id, $choiceIsQuest)) ? $choice->choice_id : 0;

                                            if ($checkChoice_quest != 0) {

                                                $logchoice_answer = $choiceCorrectIDs[$checkChoice_quest]['Anschoice_id'];

                                                if ($choiceCorrectIDs[$checkChoice_quest]['checkVal'] == 1) {
                                                    $is_valid_choice = 1;
                                                    $quest_score++;
                                                }
                                            }

                                            $modelCourselogchoice->logchoice_answer = $logchoice_answer;
                                            $modelCourselogchoice->is_valid_choice = $is_valid_choice == 1 ? 1 : 0;
                                            // Save Courselogchoice
                                            $modelCourselogchoice->save();
                                        }

                                        $modelCourselogques = new LogquesOnline;
                                        $modelCourselogques->lesson_teams_id = $id; // $_POST ID
                                        $modelCourselogques->gen_id = $gen_id;
                                        $modelCourselogques->score_id = $modelCoursescore->score_id;
                                        $modelCourselogques->ques_id = $value->ques_id;
                                        $modelCourselogques->user_id = Yii::app()->user->id;
                                        $modelCourselogques->test_type = $testType;
                                        $modelCourselogques->ques_type = $coursequestion->ques_type;
                                        $modelCourselogques->result = $quest_score;
                                        $modelCourselogques->save();
                                        $type_question = $coursequestion->ques_type;
                                        if ($coursequestion->ques_type == 3) {
                                            $quesType_ = 1;
                                        }
                                    }
                                }
                                // exit();

                                $sumPoint = $scoreSum * 100 / $countAllCoursequestion;
                                ScoreOnline::model()->updateByPk($modelCoursescore->score_id, array(
                                    'score_number' => $scoreSum,
                                    'update_date' => date('Y-m-d H:i:s'),
                                    'score_total' => $countAllCoursequestion,
                                    'score_past' => ($sumPoint >= $scorePercent) ? 'y' : 'n',
                                ));
                                $modelScore = ScoreOnline::model()->findByPk($modelCoursescore->score_id);

                                $this->actiondeleteTemp($id, $testType, $gen_id);
                                $this->renderPartial('exams_finish', array(
                                    'quesType_' => $type_question,
                                    'model' => $model,
                                    'lesson' => $lesson,
                                    'temp_all' => $temp_all,
                                    'quesType' => $quesType_,
                                    'testType' => $testType,
                                    'modelScore' => $modelScore,
                                    'label' => $label,
                                    'labelCourse' => $labelCourse
                                ));
                            } else {
                                // echo '<pre>';
                                //     var_dump($_POST['dropdownVal']);
                                //     exit();        
                                $temp_count = count($temp_all);
                                if ($_POST['actionEvnt'] == "next") {
                                    $idx = $_POST['idx_now'] + 1;
                                    if ($_POST['idx_now'] == $temp_count) $idx = 1;
                                } elseif ($_POST['actionEvnt'] == "previous") {
                                    $idx = $_POST['idx_now'] - 1;
                                    if ($_POST['idx_now'] == 1) $idx = $temp_count;
                                } else {
                                    $idx = $_POST['actionEvnt'];
                                }
                                $count_no_select = TempQuizOnline::model()->count(array(
                                    'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => $testType, ':gen_id' => $gen_id)
                                ));

                                $last_ques = $count_no_select == 0 ? 1 : 0;
                                $currentQuiz = TempQuizOnline::model()->find(array(
                                    'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND number=:number AND gen_id=:gen_id order by id",
                                    'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => $testType, ':number' => $idx, ':gen_id' => $gen_id)
                                ));
                                $model = QuestionOnline::getTempData($currentQuiz['ques_id']);
                                $temp_all = TempQuizOnline::model()->findAll(array(
                                    'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
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
                                    'label' => $label,
                                    'labelCourse' => $labelCourse,
                                ));
                            }
                        } else {
                            $count_no_select = TempQuizOnline::model()->count(array(
                                'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND status='0' AND gen_id=:gen_id order by id",
                                'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => $testType, ':gen_id' => $gen_id)
                            ));

                            $last_ques = $count_no_select == 0 ? 1 : 0;
                            $temp_all = TempQuizOnline::model()->findAll(array(
                                'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $id . " and type='" . $testType . "' AND gen_id='" . $gen_id . "'"
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
                                'label' => $label,
                                'labelCourse' => $labelCourse,
                            ));
                        }
                    } else {
                        Yii::app()->user->setFlash('CheckQues', $label->label_alert_noTest);
                        Yii::app()->user->setFlash('class', 'error');

                        $this->redirect(array(
                            '//examsonline/detail', 'id' => $lesson->ms_teams_id, 'lesson_id' => $id
                        ));
                    }
                }
            }
        } else {
            if (Yii::app()->session['lang'] == 2) {
                Yii::app()->user->setFlash('CheckQues', $label->label_alert_error);
            } else {
                Yii::app()->user->setFlash('CheckQues', "error");
            }
            Yii::app()->user->setFlash('class', 'error');

            $this->redirect(array('//examsonline/detail', 'id' => $lesson->ms_teams_id, 'lesson_id' => $id));
        }
    }

    public function actionExamsFinish()
    {
        $this->render('exams-finish');
    }

    public function actionResetpost($id = null, $course = null)
    {
        $lesson_model = LessonOnline::model()->findByPk($id);
        $gen_id = 0;

        $score = ScoreOnline::model()->findAll(array(
            'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND active=:active AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $id, ':type' => 'post', ':active' => 'y', ':gen_id' => $gen_id)
        ));

        foreach ($score as $key => $value) {

            LogquesOnline::model()->deleteAll(array(
                'condition' => 'user_id=:user_id AND lesson_teams_id=:lesson_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':user_id' => Yii::app()->user->id, ':lesson_id' => $id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));

            LogchoiceOnline::model()->deleteAll(array(
                'condition' => 'lesson_teams_id=:lesson_id AND user_id=:user_id AND score_id=:score_id AND gen_id=:gen_id',
                'params' => array(':lesson_id' => $id, ':user_id' => Yii::app()->user->id, ':score_id' => $value->score_id, ':gen_id' => $gen_id)
            ));
            $value->active = 'n';
            $value->save(false);
        }
        $this->redirect(array('/examsonline/detail/', 'id' => $course));
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actiondeleteTemp($lesson_id = null, $type = null, $gen_id = null)
    {
        TempQuizOnline::model()->deleteAll(array(
            'condition' => "user_id=:user_id AND lesson_teams_id=:lesson AND type=:type AND gen_id=:gen_id",
            'params' => array(':user_id' => Yii::app()->user->id, ':lesson' => $lesson_id, ':type' => $type, ':gen_id' => $gen_id)
        ));
    }

    public function actionSaveTimeExam()
    {
        $lesson_model = LessonOnline::model()->findByPk($_POST['lesson_id']);
        $gen_id = 0;

        $temp_time_start = TempQuizOnline::model()->find(array(
            'condition' => "user_id=" . Yii::app()->user->id . " and lesson_teams_id=" . $_POST['lesson_id'] . " and time_start is not null AND gen_id='" . $gen_id . "'"
        ));
        if ($temp_time_start) {
            $temp_time_start->time_up = $_POST['time'];
            // echo ($temp_time_start->update()) ? 'success' : 'error';
            if ($temp_time_start->update()) {
                $state = 'success';
            } else {
                $state = 'error';
            }
        } else {
            $state = 'error';
        }
        echo $state;
    }

    public function actionWebcam()
    {
        $this->render('webcam');
    }


    public function actionFaceDetect()
    {

        $less = $_POST['lesson'];
        $cou_id = $_POST['cou'];
        $user_id = Yii::app()->user->id;
        $ques_type = $_POST['ques_type'];


        $model = CaptureExamsOnline::model()->find(array(
            'order' => 'id desc',
            'condition' => 'lesson_teams_id=:lesson AND user_id=:user_id AND ms_teams_id=:id AND ques_type=:ty AND file_name IS NOT NULL',
            'params' => array(':lesson' => $less, ':user_id' => $user_id, ':id' => $cou_id, ':ty' => $ques_type)
        ));

        $fol = 'exams_online_picture';

        $faceLast = Users::model()->notsafe()->findByPk($user_id);
        $hourDate = 6;
        if ($faceLast->face_time_last != null) {
            // $faceLast->face_time_last = date("Y-m-d H:i:s", time());
            // $faceLast->save(false);
            $date1 = new DateTime($faceLast->face_time_last);
            $date2 = new DateTime(date("Y-m-d H:i:s", time()));
            $diff = $date2->diff($date1);
            $hourDate = intval($diff->format('%h'));
        }

        if ($hourDate >= 6) {
            $faceLast->face_time_last = date("Y-m-d H:i:s", time());
            $faceLast->save(false);

            if ($model != null) {
                $chk_Face_image = Helpers::lib()->ApiFaceExamsImage($user_id, $fol, $cou_id, $model->file_name, $model->id);
                echo $chk_Face_image;
            } else {
                echo "nopass";
                exit();
            }
        } else {
            echo "pass";
            exit();
        }
    }
}
