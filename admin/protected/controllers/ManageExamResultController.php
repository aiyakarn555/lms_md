<?php

class ManageExamResultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}


	public function actionManageCourse()
	{
		$model = new ManageExamResult();
		$model->unsetAttributes();
		if(count($_GET) > 0){
			$listCourse = $this->actionListCourse($_GET['type_cou'],1);
			$listGeneration = [];
			if($_GET['type_cou'] == 1){
				$listGeneration = $this->actionListGeneration($_GET['course_id'],1);
				$result = $model->ByCourse($_GET);
			}else{
				$result = $model->ByMsteams($_GET);
			}

		}
        $this->render('manageCourse', array(
            'model' => $model,
			'listCourse'=>$listCourse,
			'listGeneration'=>$listGeneration,
			'result' => $result,
        ));
	}

	public function actionManageLesson()
	{
		$model = new ManageExamResult();
		$model->unsetAttributes();
		if(count($_GET) > 0){
			$listCourse = $this->actionListCourse($_GET['type_cou'],1);
			$listGeneration = [];
			if($_GET['type_cou'] == 1){
				$listGeneration = $this->actionListGeneration($_GET['course_id'],1);
				$result = $model->ByCourseLesson($_GET);
			}else{
				$result = $model->ByMsteamsLesson($_GET);
			}
		}
        $this->render('manageLesson', array(
            'model' => $model,
			'listCourse'=>$listCourse,
			'listGeneration'=>$listGeneration,
			'result' => $result,
        ));
	}


	public function actionListCourse($type,$search=0){
		if($type == 1){
			$criteria=new CDbCriteria;
			$criteria->compare('active','y');
			$criteria->compare("parent_id",0);

			$modelUser = Users::model()->findByPk(Yii::app()->user->id);
			$group = json_decode($modelUser->group);
			if (!in_array(1, $group)){
				$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
				$criteria->addInCondition('create_by', $groupUser);    
			}

			$criteria->order = 'create_date DESC';
			$courseOnline = CourseOnline::model()->findAll($criteria);
			$array = CHtml::listData($courseOnline, 'course_id','ConcatCourseName');
			if($search == 0){
				echo json_encode($this->array_preserve_js_order($array));
			}else{
				return $array;
			}
		}else{
			$criteria=new CDbCriteria;
			$criteria->compare("active","y");
            $criteria->order = "create_date DESC";
			
			$modelUser = Users::model()->findByPk(Yii::app()->user->id);
			$group = json_decode($modelUser->group);
			if (!in_array(1, $group)){
				$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
				$criteria->addInCondition('create_by', $groupUser);    
			}

            $msTeams = MsTeams::model()->findAll($criteria);
			$array = CHtml::listData($msTeams, 'id','ConcatMsTeamsName');
			if($search == 0){
				echo json_encode($this->array_preserve_js_order($array));
			}else{
				return $array;
			}
		}
	}


	public function actionListGeneration($course_id,$search=0){

		$generation = CourseGeneration::Model()->findAll("course_id=:course_id AND active='y'", array(
			"course_id"=>$course_id,
		));
		$array = CHtml::listData($generation, 'gen_id','gen_detail');
		if($search == 0){
			echo json_encode($this->array_preserve_js_order($array));
		}else{
			return $array;
		}
	}


	public function actionUpdate($type_cou,$course_id,$gen_id,$result_status,$name_id_search,$email,$user_id){

			$model =  CourseOnline::model()->findByPk($course_id);
			$getGen_id = $model->getGenID($model->course_id);
			if(isset($_POST['Choice']) || isset($_POST['ChoiceWrong'])){

				foreach($_POST['ChoiceWrong'] as $key => $wrong){
					if(!isset($_POST['Choice'][$key])){
						$_POST['Choice'][$key][0] = $wrong[0];
					}
				}

				$modelScore = Coursescore::model()->find(array(
					'condition' => 'user_id=:user_id AND course_id=:course_id AND active="y" AND type=:type',
					'params' => array(':user_id' => $user_id,':course_id' => $model->course_id,':type'=> 'post'),
					'order' => 'score_id desc'));
				
				$logQues = Courselogques::model()->findAll(array(
					'condition' => 'score_id=:score_id AND user_id=:user_id',
					'params' => array(':score_id' => $modelScore->score_id,':user_id'=>$user_id))
				);
				foreach ($logQues as $key => $value) {
					$reset = Courselogchoice::model()->findAll(array( 
						'condition'=>"score_id=:score_id and logchoice_answer = 1 and ques_id=:ques_id AND test_type=:test_type",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id,':test_type'=> 'post')
					));

					foreach($reset as $r){
						$re = Courselogchoice::model()->findByPk($r->logchoice_id);
						$re->logchoice_answer = 0;
						$re->save();
					}

					$edit = Courselogchoice::model()->find(array( 
						'condition'=>"score_id=:score_id and ques_id=:ques_id and choice_id=:choice_id AND test_type=:test_type",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id,':choice_id'=>$_POST['Choice'][$value->ques_id][0],':test_type'=> 'post')
					));

					if(isset($edit)){
						$edit->logchoice_answer = 1;
						if($edit->save()){
							$resetLogQues = Courselogques::model()->find(array( 
								'condition'=>"score_id=:score_id and ques_id=:ques_id AND test_type=:test_type",
								'params' => array(':score_id' =>  $edit->score_id,':ques_id' => $edit->ques_id,':test_type'=> 'post')
							));
							if($edit->is_valid_choice == 1){
								$resetLogQues->result = 1;
							}else{
								$resetLogQues->result = 0;
							}
							$resetLogQues->save();
						}
					}
					
				}

				$modelScore->score_number = $_POST['scoreExam'];
				$modelScore->score_past = $_POST['statusPass'];
				if($modelScore->save()){
					Yii::app()->user->setFlash('Success', 'บันทึกข้อมูลสำเร็จ!');
				}else{
					Yii::app()->user->setFlash('Success', 'บันทึกไม่สำเร็จ!'.' กรุณาลองอีกครั้ง');
				}

			}

			$this->render('update',array(
				'model'=>$model,
				'type_cou'=>$type_cou,
				'course_id'=>$course_id,
				'gen_id'=>$gen_id,
				'result_status'=>$result_status,
				'name_id_search'=>$name_id_search,
				'email'=>$email,
				'user_id'=>$user_id
			));
		
	}

	public function actionUpdateLesson($type_cou,$course_id,$gen_id,$result_status,$name_id_search,$email,$lesson_id,$user_id){
		if($type_cou == 1){
			$model =  CourseOnline::model()->findByPk($course_id);
			$getGen_id = $model->getGenID($model->course_id);
			if(isset($_POST['Choice']) || isset($_POST['ChoiceWrong'])){

				foreach($_POST['ChoiceWrong'] as $key => $wrong){
					if(!isset($_POST['Choice'][$key])){
						$_POST['Choice'][$key][0] = $wrong[0];
					}
				}

				$modelScore = Score::model()->find(array(
                    'condition' => 'user_id=:user_id AND course_id=:course_id AND lesson_id=:lesson_id AND active="y" AND type=:type',
                    'params' => array(':user_id' => $user_id,':course_id' => $model->course_id,':type'=> 'post',':lesson_id'=> $lesson_id),
                    'order' => 'score_id desc')
                );

				$logQues = Logques::model()->findAll(array(
					'condition' => 'score_id=:score_id AND user_id=:user_id',
					'params' => array(':score_id' => $modelScore->score_id,':user_id'=>$user_id))
				);
				foreach ($logQues as $key => $value) {
					$reset = logchoice::model()->findAll(array( 
						'condition'=>"score_id=:score_id and logchoice_answer = 1 and ques_id=:ques_id",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id)
					));

					foreach($reset as $r){
						$re = logchoice::model()->findByPk($r->logchoice_id);
						$re->logchoice_answer = 0;
						$re->save();
					}

					$edit = logchoice::model()->find(array( 
						'condition'=>"score_id=:score_id and ques_id=:ques_id and choice_id=:choice_id",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id,':choice_id'=>$_POST['Choice'][$value->ques_id][0])
					));

					if(isset($edit)){
						$edit->logchoice_answer = 1;
						if($edit->save()){
							$resetLogQues = Logques::model()->find(array( 
								'condition'=>"score_id=:score_id and ques_id=:ques_id AND test_type=:test_type",
								'params' => array(':score_id' =>  $edit->score_id,':ques_id' => $edit->ques_id,':test_type'=> 'post')
							));

							if($edit->is_valid_choice == 1){
								$resetLogQues->result = 1;
							}else{
								$resetLogQues->result = 0;
							}
							$resetLogQues->save();
						}
					}
					
				}

				$modelScore->score_number = $_POST['scoreExam'];
				$modelScore->score_past = $_POST['statusPass'];
				if($modelScore->save()){
					Yii::app()->user->setFlash('Success', 'บันทึกข้อมูลสำเร็จ!');
				}else{
					Yii::app()->user->setFlash('Success', 'บันทึกไม่สำเร็จ!'.' กรุณาลองอีกครั้ง');
				}

			}
		}else{
			$model =  MsTeams::model()->findByPk($course_id);
			$getGen_id = 0;
			if(isset($_POST['Choice']) || isset($_POST['ChoiceWrong'])){

				foreach($_POST['ChoiceWrong'] as $key => $wrong){
					if(!isset($_POST['Choice'][$key])){
						$_POST['Choice'][$key][0] = $wrong[0];
					}
				}

				$modelScore = ScoreMsTeams::model()->find(array(
                    'condition' => 'user_id=:user_id AND lesson_teams_id=:lesson_teams_id AND active="y" AND type=:type',
                    'params' => array(':user_id' => $user_id,':lesson_teams_id' => $lesson_id,':type'=> 'post'),
                    'order' => 'score_id desc')
                );

				
				$logQues = LogquesMsTeams::model()->findAll(array(
					'condition' => 'score_id=:score_id AND user_id=:user_id AND lesson_teams_id=:lesson_teams_id',
					'params' => array(':score_id' => $modelScore->score_id,':user_id'=>$user_id,':lesson_teams_id'=> $lesson_id)));
				foreach ($logQues as $key => $value) {
					$reset = LogchoiceMsTeams::model()->findAll(array( 
						'condition'=>"score_id=:score_id and logchoice_answer = 1 and ques_id=:ques_id AND lesson_teams_id=:lesson_teams_id",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id,':lesson_teams_id'=> $lesson_id)
					));

					foreach($reset as $r){
						$re = LogchoiceMsTeams::model()->findByPk($r->logchoice_id);
						$re->logchoice_answer = 0;
						$re->save();
					}

					$edit = LogchoiceMsTeams::model()->find(array( 
						'condition'=>"score_id=:score_id and ques_id=:ques_id and choice_id=:choice_id",
						'params' => array(':score_id' =>  $value->score_id,':ques_id' => $value->ques_id,':choice_id'=>$_POST['Choice'][$value->ques_id][0])
					));

					if(isset($edit)){
						$edit->logchoice_answer = 1;
						if($edit->save()){
							$resetLogQues = LogquesMsTeams::model()->find(array( 
								'condition'=>"score_id=:score_id and ques_id=:ques_id AND lesson_teams_id=:lesson_teams_id AND  test_type=:test_type",
								'params' => array(':score_id' =>  $edit->score_id,':ques_id' => $edit->ques_id,':lesson_teams_id'=> $lesson_id,':test_type'=> 'post')
							));

							if($edit->is_valid_choice == 1){
								$resetLogQues->result = 1;
							}else{
								$resetLogQues->result = 0;
							}
							$resetLogQues->save();
						}
					}
					
				}

				$modelScore->score_number = $_POST['scoreExam'];
				$modelScore->score_past = $_POST['statusPass'];
				if($modelScore->save()){
					Yii::app()->user->setFlash('Success', 'บันทึกข้อมูลสำเร็จ!');
				}else{
					Yii::app()->user->setFlash('Success', 'บันทึกไม่สำเร็จ!'.' กรุณาลองอีกครั้ง');
				}

			}
		}

		$this->render('updateLesson',array(
			'model'=>$model,
			'type_cou'=>$type_cou,
			'course_id'=>$course_id,
			'gen_id'=>$gen_id,
			'result_status'=>$result_status,
			'name_id_search'=>$name_id_search,
			'email'=>$email,
			'lesson_id'=>$lesson_id,
			'user_id'=>$user_id
	
		));
	}


	function array_preserve_js_order(array $data) {
		return array_map(
			function($key, $value) {
				if (is_array($value)) {
					$value = $this->array_preserve_js_order($value);
				}
				return array($key, $value);
			},
			array_keys($data),
			array_values($data)
		);
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