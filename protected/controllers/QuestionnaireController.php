<?php

class QuestionnaireController extends Controller
{
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
	public function accessRules()
	{
		/*return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','out','success'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);*/
	}
	public function actionquestionnaire(){
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$this->render('questionnaire');
	}
	public function actionView($id)
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIndex($id)
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$lesson = $this->loadModel($id);
		$gen_id = $lesson->CourseOnlines->getGenID($lesson->course_id);
		$questAns = Helpers::lib()->checkLessonQuestion($lesson);
		if($questAns){
			$this->redirect(array('/course/detail','id'=>$lesson->course_id));
			// echo "คุณเคยทำแบบสอบถามแล้ว";
			// exit;
		}
		if(isset($_POST['choice'])){
			$log = new QQuestAns;
			$log->user_id = Yii::app()->user->id;
			$log->lesson_id = $lesson->id;
			$log->gen_id = $gen_id;
			$log->header_id = $lesson->header->survey_header_id;
			$log->date = date('Y-m-d H:i:s');
			$log->save();

			if(isset($_POST['choice']['input'])){
				foreach ($_POST['choice']['input'] as $option_choice_id => $value) {
					$answers = new QAnswers;
					$answers->user_id = Yii::app()->user->id;
					$answers->choice_id = $option_choice_id;
					$answers->gen_id = $gen_id;
					$answers->answer_text = $value;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['radio'])){
				foreach ($_POST['choice']['radio'] as $question_id => $option_choice_id) {
					$answers = new QAnswers;
					$answers->user_id = Yii::app()->user->id;
					$answers->gen_id = $gen_id;
					$answers->choice_id = $option_choice_id;
					if(isset($_POST['choice']['radioOther'][$question_id][$option_choice_id])){
						$answers->answer_text = $_POST['choice']['radioOther'][$question_id][$option_choice_id];
					}
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['checkbox'])){
				foreach ($_POST['choice']['checkbox'] as $question_id => $checkboxArray) {
					foreach ($checkboxArray as $key => $option_choice_id) {
						$answers = new QAnswers;
						$answers->gen_id = $gen_id;
						$answers->user_id = Yii::app()->user->id;
						$answers->choice_id = $option_choice_id;
						if(isset($_POST['choice']['checkboxOther'][$question_id][$option_choice_id])){
							$answers->answer_text = $_POST['choice']['checkboxOther'][$question_id][$option_choice_id];
						}
						$answers->quest_ans_id = $log->id;
						$answers->save();
					}
				}
			}

			if(isset($_POST['choice']['contentment'])){
				foreach ($_POST['choice']['contentment'] as $option_choice_id => $score) {
					$answers = new QAnswers;
					$answers->user_id = Yii::app()->user->id;
					$answers->gen_id = $gen_id;
					$answers->choice_id = $option_choice_id;
					$answers->answer_numeric = $score;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['text'])){
				foreach ($_POST['choice']['text'] as $option_choice_id => $value) {
					$answers = new QAnswers;
					$answers->user_id = Yii::app()->user->id;
					$answers->choice_id = $option_choice_id;
					$answers->gen_id = $gen_id;
					$answers->answer_textarea = $value;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}
			$this->redirect(array('/course/detail','id'=>$lesson->course_id,'lesson_id'=>$lesson->id));

		}
		$this->render('index',array(
			'lesson'=>$lesson,
		));
	}

	public function actionOut($id)
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$header = QHeader::model()->findByPk($id);

		if(isset($_POST['choice'])){
			$log = new QQuestAns;
			// $log->user_id = $user->id;
			$log->header_id = $header->survey_header_id;
			$log->date = date('Y-m-d H:i:s');
			$log->save();

			if(isset($_POST['choice']['input'])){
				foreach ($_POST['choice']['input'] as $option_choice_id => $value) {
					$answers = new QAnswers;
					//$answers->user_id = $user->id;
					$answers->choice_id = $option_choice_id;
					$answers->answer_text = $value;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['radio'])){
				foreach ($_POST['choice']['radio'] as $question_id => $option_choice_id) {
					$answers = new QAnswers;
					//$answers->user_id = $user->id;
					$answers->choice_id = $option_choice_id;
					if(isset($_POST['choice']['radioOther'][$question_id][$option_choice_id])){
						$answers->answer_text = $_POST['choice']['radioOther'][$question_id][$option_choice_id];
					}
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['checkbox'])){
				foreach ($_POST['choice']['checkbox'] as $question_id => $checkboxArray) {
					foreach ($checkboxArray as $key => $option_choice_id) {
						$answers = new QAnswers;
						//$answers->user_id = $user->id;
						$answers->choice_id = $option_choice_id;
						if(isset($_POST['choice']['checkboxOther'][$question_id][$option_choice_id])){
							$answers->answer_text = $_POST['choice']['checkboxOther'][$question_id][$option_choice_id];
						}
						$answers->quest_ans_id = $log->id;
						$answers->save();
					}
				}
			}

			if(isset($_POST['choice']['contentment'])){
				foreach ($_POST['choice']['contentment'] as $option_choice_id => $score) {
					$answers = new QAnswers;
					//$answers->user_id = $user->id;
					$answers->choice_id = $option_choice_id;
					$answers->answer_numeric = $score;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			if(isset($_POST['choice']['text'])){
				foreach ($_POST['choice']['text'] as $option_choice_id => $value) {
					$answers = new QAnswers;
					//$answers->user_id = $user->id;
					$answers->choice_id = $option_choice_id;
					$answers->answer_textarea = $value;
					$answers->quest_ans_id = $log->id;
					$answers->save();
				}
			}

			$this->redirect(array('/questionnaire/success'));

		}
		$this->render('out',array(
			'header'=>$header,
		));
	}

	public function actionSuccess()
	{
		$this->render('success');
	}

	public function loadModel($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
