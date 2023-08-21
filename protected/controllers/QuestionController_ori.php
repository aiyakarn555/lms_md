<?php
class QuestionController extends Controller
{
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
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','score'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionIndex($id)
    {
        $lesson = Lesson::model()->findByPk($id);

        if( ! Helpers::lib()->CheckBuyItem($lesson->course_id,false))
        {
            Yii::app()->user->setFlash('CheckQues', array(
                'msg'   => 'เกิดข้อผิดพลาด',
                'class' => 'error'
            ));

            $this->redirect(array('//courseOnline/index', 'id'=>Yii::app()->user->getState('getLesson')));
        }

        if($lesson)
        {
            $lessonStatus = Helpers::lib()->checkLessonPass($lesson);
        }

        $isPreTest = Helpers::isPretestState($id);
        $testType  = $isPreTest ? 'pre':'post';

        if($lessonStatus == "notLearn" && ! $isPreTest || $lessonStatus == "learning")
        {
            Yii::app()->user->setFlash('CheckQues', "คุณยังไม่มีสิทธิ์ทำแบบทดสอบ");
            $this->redirect(array(
                '//courseOnline/index','id'=>Yii::app()->user->getState('getLesson')
            ));
        }
        else if($lessonStatus == "pass" || $isPreTest)
        {
            $countManage = Manage::Model()->count("id=:id AND active=:active AND type=:type", array(
                "id"     => $id,
                "active" => "y",
                "type"   => $testType
            ));

            // Not found and redirect
            if( ! $countManage)
            {
                Yii::app()->user->setFlash('CheckQues', array(
                    'msg'   => 'ขณะนี้ยังไม่มีข้อสอบ',
                    'class' => 'error'
                ));

                $this->redirect(array(
                    '//courseOnline/index',
                    'id'=>Yii::app()->user->getState('getLesson')
                ));
            }

            $LessonModel = Lesson::model()->find(array(
                'condition' => 'id=:id',
                'params'    => array(':id' => $id)
            ));

            $countScore = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND type=:type", array(
                "lesson_id" => $id,
                "user_id"   => Yii::app()->user->id,
                "type"      => 'post',
            ));

            if($countScore == $LessonModel->cate_amount) //สอบครบจำนวน
            {
                $countScorePast = Score::model()->findAll(array(
                    'condition' => ' lesson_id = "'.$id.'"
                        AND user_id    = "'.Yii::app()->user->id.'"
                        AND score_past = "y"
                        AND type       = "post"
                    ',
                ));

                if(!empty($countScorePast))
                {
                    // Pass
                    Yii::app()->user->setFlash('CheckQues', array(
                        'msg'   => 'คุณสอบผ่านแล้ว',
                        'class' => 'success'
                    ));

                    $this->redirect(array('//courseOnline/index', 'id' => Yii::app()->user->getState('getLesson')));
                }
                else
                {
                    // Not Pass
                    Yii::app()->user->setFlash('CheckQues', array(
                        'msg'   => 'คุณสอบไม่ผ่าน หมดสิทธิสอบ',
                        'class' => 'error'
                    ));

                    $this->redirect(array('//courseOnline/index', 'id' => Yii::app()->user->getState('getLesson')));
                }
            }
            else
            {
                $countScorePast = Score::Model()->count("lesson_id=:lesson_id AND user_id=:user_id AND score_past=:score_past AND type=:type", array(
                    "lesson_id"  => $id,
                    "user_id"    => Yii::app()->user->id,
                    "score_past" => "y",
                    "type"       => "post",
                ));

                if(!empty($countScorePast))
                {
                    Yii::app()->user->setFlash('CheckQues', array(
                        'msg'   => 'คุณสอบผ่านแล้ว',
                        'class' => 'success'
                    ));

                    $this->redirect(array('//courseOnline/index', 'id' => Yii::app()->user->getState('getLesson')));
                }
                else
                {
                    // Config default pass score 60 percent
                    $scorePercent = 60;

                    $manage = new CActiveDataProvider('Manage',array(
                        'criteria'=>array(
                            'condition' => ' id = "'.$id.'" AND active = "y" AND type = "'.$testType.'" '
                        ))
                    );

                    $model = array();
                    foreach ($manage->getData() as $i=>$value)
                    {
                        $model[] = Question::getLimitData($value['group_id'],$value['manage_row'], $isPreTest);
                    }

                    if(count($model) != null || count($model) != 0)
                    {

                        if( isset($_POST['Question']) )
                        {
                            $modelScore            = new Score;
                            $modelScore->lesson_id = $id;
                            $modelScore->user_id   = Yii::app()->user->id;
                            $modelScore->type      = $testType;
                            $modelScore->save();

                            $scoreSum = 0;
                            $countAllQuestion = 0;

                            foreach ($_POST['Question'] as $keyEachQuestion => $eachQuestion)
                            {
                                $countAllQuestion += count($eachQuestion);

                                foreach ($eachQuestion as $key => $value)
                                {
                                    $keyAnswer = $value['choiceAnswer'];

                                    $question = Question::model()->with('chioce')->find("question.ques_id=:id", array(
                                        "id" => $value['ques_id'],
                                    ));

                                    // Save Logques
                                    $modelLogques            = new Logques;
                                    $modelLogques->lesson_id = $id; // $_GET ID
                                    $modelLogques->score_id  = $modelScore->score_id;
                                    $modelLogques->ques_id   = $question->ques_id;
                                    $modelLogques->user_id   = Yii::app()->user->id;
                                    $modelLogques->test_type = $testType;
                                    $modelLogques->ques_type = $question->ques_type;
                                    $modelLogques->save();

                                    // Checkbox case
                                    $defaultValidAnswerCheckboxLength = 0;
                                    $answerLength = 0;
                                    $keyAnswerCheckboxList = array();

                                    if ($question->ques_type == 1)
                                    {
                                    	if(is_array($keyAnswer)){
	                                        foreach ($keyAnswer as $keyCheckboxAnswer => $keyAnswerCheckbox)
	                                        {
	                                            $keyAnswerCheckboxList[] = $keyAnswerCheckbox;
	                                        }
                                    	}

                                        $answerLength = count($keyAnswerCheckboxList);

                                        foreach($question->chioce as $keyChoice => $choice )
                                        {
                                            if ($choice->choice_answer == "1")
                                            {
                                                ++$defaultValidAnswerCheckboxLength;
                                            }
                                        }
                                    }

                                    $sumValidAnswerCheckbox = 0;
                                    foreach($question->chioce as $keyChoice => $choice )
                                    {
                                        // Save Logchoice
                                        $modelLogchoice                   = new Logchoice;
                                        $modelLogchoice->lesson_id        = $id; // $_GET ID
                                        $modelLogchoice->logchoice_select = 1;
                                        $modelLogchoice->score_id         = $modelScore->score_id;
                                        $modelLogchoice->choice_id        = $choice->choice_id;
                                        $modelLogchoice->ques_id          = $question->ques_id;
                                        $modelLogchoice->user_id          = Yii::app()->user->id;
                                        $modelLogchoice->test_type        = $testType;
                                        $modelLogchoice->ques_type        = $question->ques_type;
                                        $modelLogchoice->is_valid_choice  = $choice->choice_answer == "1" ? '1':'0';


                                        if($question->ques_type == 1 && in_array($keyChoice, $keyAnswerCheckboxList))
                                        {
                                            ++$sumValidAnswerCheckbox;
                                            // Checkbox case
                                            if ($choice->choice_answer == "1" && $defaultValidAnswerCheckboxLength == $answerLength && $sumValidAnswerCheckbox == $defaultValidAnswerCheckboxLength)
                                            {
                                                ++$scoreSum;
                                            }

                                            $modelLogchoice->logchoice_answer = 1;
                                        }
                                        else if($question->ques_type == 2 && $keyChoice == $keyAnswer && $keyAnswer !='')
                                        {
                                        	//echo '$keyChoice = '.$keyChoice.' == $keyAnswer = '.$keyAnswer."<br>";
                                            // radio case
                                            if ($choice->choice_answer == "1")
                                            {
                                                ++$scoreSum;
                                            }
                                            $modelLogchoice->logchoice_answer = 1;
                                        }
                                        else
                                        {
                                            $modelLogchoice->logchoice_answer = 0;
                                        }

                                        // Save Logchoice
                                        $modelLogchoice->save();
                                    }
                                }
                            }

                            //exit;

                            $sumPoint = $scoreSum*100/$countAllQuestion;

                            Score::model()->updateByPk($modelScore->score_id, array(
                                'score_number'  => $scoreSum,
                                'score_total'   => $countAllQuestion,
                                'score_past'    => ($sumPoint >= $scorePercent) ? 'y':'n',
                            ));

                            if(Helpers::lib()->CheckTestingPass($lesson->course_id,false,true) && ! $isPreTest)
                            {
                                $CheckPasscoursCheck = Passcours::model()->find(array(
                                    'condition' => 'passcours_cours=:id AND passcours_user=:user', 'params' => array(
                                        ':id'   => $lesson->course_id,
                                        ':user' => Yii::app()->user->id
                                    )
                                ));

                                if(!isset($CheckPasscoursCheck))
                                {
                                    //////// Save PassCourseOnline //////////
                                    $modelPasscours                     = new Passcours;
                                    $modelPasscours->passcours_cours    = $lesson->course_id;
                                    $modelPasscours->passcours_user     = Yii::app()->user->id;
                                    $modelPasscours->passcours_date     = date("Y-m-d H:i:s");
                                    $modelPasscours->save();
                                }
                            }

                            if ( ! $isPreTest)
                            {
                                $this->redirect(
                                    array('score','id' => $modelScore->score_id)
                                );
                            }

                            Yii::app()->user->setFlash('CheckQues', array(
                                'msg'   => 'คุณทำข้อสอบ Pre-Test เรียบร้อยแล้ว',
                                'class' => 'success'
                            ));

                            $this->redirect(array(
                                '//courseOnline/index',
                                'id' =>Yii::app()->user->getState('getLesson')
                            ));

                        }

                        $this->render('index',array(
                            'model'     => $model,
                            'lesson'    => $lesson
                        ));

                    }
                    else
                    {

                        Yii::app()->user->setFlash('CheckQues', array(
                            'msg'   => 'ขณะนี้ยังไม่มีข้อสอบ',
                            'class' => 'error'
                        ));

                        $this->redirect(array(
                            '//courseOnline/index',
                            'id' =>Yii::app()->user->getState('getLesson')
                        ));
                    }
                }
            }
        }
        else
        {
            Yii::app()->user->setFlash('CheckQues', array(
                'msg'   => 'เกิดข้อผิดพลาด',
                'class' => 'error'
            ));

            $this->redirect(array('//courseOnline/index', 'id'=>Yii::app()->user->getState('getLesson')));
        }
    }

    public function actionScore($id)
    {
        $model = Score::model()->findByPk($id);
        if($model->user_id != Yii::app()->user->id)
        {
            Yii::app()->user->setFlash('CheckQues', "เกิดข้อผิดพลาด ไม่สามารถตรวจสอบได้");
            $this->redirect(array('//categoryLesson/index'));
        }
        else
        {
            $this->render('score',array('model'=>$model));
        }
    }

    public function loadModel($id)
    {
        $model=Question::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
