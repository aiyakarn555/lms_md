<?php

class CourseStartController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPermission() {

		$respond = null;
		$respond['coursetype'] = null;

		//check user session first
		if(Yii::app()->user->id) {
			$curCourse = $_POST['course'];
			if($curCourse != '') {

				if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			            $langId = Yii::app()->session['lang'] = 1;
			        }else{
			            $langId = Yii::app()->session['lang'];
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

				//get course type
				$currentCourseOnlineModel = CourseOnline::model()->findByPk($curCourse);

				if($currentCourseOnlineModel) {

					$respond['coursetype'] = $currentCourseOnlineModel->cate_id;

					$date = date("Y-m-d H:i:s");
					$checkCourseStartDate = CourseStart::model()->find(array(
						'condition' => 'course_id = "' . $curCourse . '" AND user_id = "' . Yii::app()->user->id . '" AND status = "1"',
					));

					if($checkCourseStartDate) {
						if($currentCourseOnlineModel->cate_id == '1'){
							$criteria = new CDbCriteria;
							$criteria->compare('course_id',$curCourse);
							$criteria->compare('user_id',Yii::app()->user->id);
							$modelCourseTms = AuthCourse::model()->find($criteria);
							$courseDateExpire = $modelCourseTms->schedule->training_date_end;
						} else {
							$courseDateExpire =  $currentCourseOnlineModel->course_date_end;
						}
						//if has start learn already
						// $date_diff = date_diff(new DateTime($date), new DateTime($checkCourseStartDate->create_date));
						$date_diff = date_diff(new DateTime($date), new DateTime($courseDateExpire));
						
						$respond['status'] = 99;
						
						$diff_date = ($date_diff->d > 0)?' ' . $date_diff->d .' '. $label->label_alert_day:null;
						$diff_hour = ($date_diff->h > 0)?' ' . $date_diff->h .' '. $label->label_alert_hour:null;
						$diff_minute = ($date_diff->i > 0)?' ' . $date_diff->i .' '. $label->label_alert_min:null;
						$diff_second = ($date_diff->s > 0)?' ' . $date_diff->s .' '. $label->label_alert_sec:null;
						
						$respond['errormsg'] = $label->label_alert_msg_StartLearn . $diff_date . $diff_hour . $diff_minute . $diff_second;

					} else {

						$LessonList = Lesson::model()->findAll(array(
							'condition' => 'course_id = "' . $curCourse . '" AND active = "y"',
						));
						$startLearnASC = null;
						if($LessonList) {
							foreach ($LessonList as $lesson) {
								$checkLearn = Learn::model()->find(array(
									'condition' => 'lesson_id = "' . $lesson->id . '" AND user_id = "' . Yii::app()->user->id . '"',
									'order' => 'create_date ASC'
								));
								if($checkLearn && $startLearnASC != null) {
									if($checkLearn->create_date < $startLearnASC) {
										$startLearnASC = $checkLearn->create_date;
									}
								} else {
									if($checkLearn->create_date < $date) {
										$startLearnASC = $checkLearn->create_date;
									}
								}
							}
						}

						//start save
						$model = new CourseStart;
						$model->user_id = Yii::app()->user->id;
						$model->course_id = $curCourse;
						$model->ip_address = Yii::app()->request->getUserHostAddress();
						$model->device = '';
						$model->status = 1;
						$model->status_date = ($startLearnASC!=null)?$startLearnASC:$date;
						$model->create_date = ($startLearnASC!=null)?$startLearnASC:$date;

						if($model->save()) {
							$respond['status'] = 1;
							$respond['errormsg'] = $label->label_alert_msg_welcome;
						} else {
							$model->getErrors();
						}
					}
				} else {
					$respond['status'] = 0;
					$respond['errormsg'] = $label->label_alert_msg_welcome;
				}
			} else {
				$respond['status'] = 2;
				$respond['errormsg'] = $label->label_alert_msg_notFound;
			}
		} else {
			$respond['status'] = 3;
			$respond['errormsg'] = $label->label_alert_msg_expired;
		}
		$cokkie_name = 'alert_time'.$curCourse;
		if(empty(Yii::app()->request->cookies[$cokkie_name]->value)){
			$time = time()+3600; //1 hr.
			$cookie = new CHttpCookie($cokkie_name, $time);
			$cookie->expire = $time; 
			Yii::app()->request->cookies[$cokkie_name] = $cookie;
		}else{
			$respond['status'] = 4; //Not time expire
		}
		
		echo json_encode($respond);
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
}