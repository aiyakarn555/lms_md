<?php

/**
 * This is the model class for table "{{manage_exam_result}}".
 *
 * The followings are the available columns in table '{{manage_exam_result}}':
 * @property integer $id
 */
class ManageExamResult extends CFormModel
{

	public $type_cou;
    public $course_id;
    public $gen_id;
    public $result_status;
    public $nameIdSearch;
	public $email;


	public function attributeLabels()
	{
		return array(
            'type_cou' => 'ประเภทหลักสูตร',
            'course_id' => 'หลักสูตร',
            'gen_id' => 'รุ่น',
            'result_status' => 'ชื่อ - นามสกุล/เลขบัตรประชาชน',
            'nameIdSearch' => 'หน่วยงาน',
            'email' => 'อีเมล',
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function ByCourse($data) //คอร์ส เรียนรู้ด้วยตัวเอง
	{
		$course_id = $data['course_id'];
		$generation = $data['generation'];
		$result_status = $data['result_status'] == 1 ? 'y' : 'n';
		$name_id_search = $data['name_id_search'];
		$email = $data['email'];


		$allUsersScore = array();
        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$course_id);
        $courseOnline = CourseOnline::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->with = array('pro','course','gen','pro.user');
        $criteria->compare("t.course_id",$course_id);

		if(isset($generation) && $generation != null && $generation != 0){
		    $criteria->compare('gen.gen_id',$generation,true);
		}
      
		if(isset($name_id_search) && $name_id_search != null){
			if ( is_numeric($name_id_search) ) {
		        $criteria->compare('pro.identification',trim($name_id_search),true);
			} else {
				$ex_fullname = explode(" ", trim($name_id_search));

				if(isset($ex_fullname[0])){
					$pro_fname = $ex_fullname[0];
		
					if (!preg_match('/[^A-Za-z]/', $pro_fname))
					{
						$criteria->addCondition("pro.firstname_en = '".$pro_fname."' OR pro.lastname_en = '".$pro_fname."'");
					}else{
						$criteria->addCondition("pro.firstname = '".$pro_fname."' OR pro.lastname = '".$pro_fname."'");
					}    
				}
	
				if(isset($ex_fullname[1])){
					$pro_lname = $ex_fullname[1];
					if (!preg_match('/[^A-Za-z]/', $pro_lname))
					{
						$criteria->compare('pro.lastname_en',$pro_lname,true);
					}else{
						$criteria->compare('pro.lastname',$pro_lname,true);
					}    
				}
			}
        }

		if(isset($email) && $email != null){
			$criteria->compare('user.email',trim($email),true);
		}

        if($courseOnline->price == "y" || $courseOnline->document_status == "y"){
            $userAllPayment = array();
            $criteriaCourseTemp = new CDbCriteria;
            $criteriaCourseTemp->compare("course_id",$course_id);
            if($courseOnline->price == "y"){
                $criteriaCourseTemp->compare("status_payment","y");
            }
            if($courseOnline->document_status == "y"){
                $criteriaCourseTemp->compare("status_document","y");
            }
            $CourseTemp = CourseTemp::model()->findAll($criteriaCourseTemp);
            foreach ($CourseTemp as $keyCourseTemp => $valueCourseTemp) {
                $userAllPayment[] = $valueCourseTemp->user_id;
            }
            $criteria->addInCondition("t.user_id",$userAllPayment);

        }
        $criteria->compare("t.active",'y');
        $allUsersLogStartCourse = LogStartcourse::model()->findAll($criteria);
		$resultArr = [];
		foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {       
			$resultArr [] = $valueByUser;
		}
		uasort($resultArr, function($a, $b) { return $a['id'] <=> $b['id']; });
		$result = array_column($resultArr, null, 'user_id');
		$result = array_filter($result, function($v) { return !empty($v['user_id']); });

		usort($result, function($a, $b) {
			return $a['id'] - $b['id'];
		});

		$allUsersLogStartCourse = $result;
        
        foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
            $allUsersScore[$keyByUser] = array(
                "id"=>$keyByUser+1,
				"userId"=>$valueByUser->pro->user_id,
                "idCard"=>$valueByUser->pro->identification,
                "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                "fName"=>$valueByUser->pro->firstname,
                "lName"=>$valueByUser->pro->lastname,
                "institutionName"=>$valueByUser->course->usercreate->institution->institution_name,
                "courseTitle"=>$valueByUser->course->course_title,
                "courseScorePre"=>array(),
                "courseTotalPre"=>array(),
                "courseStatusPre"=>array(),
                "courseScorePost"=>array(),
                "courseTotalPost"=>array(),
                "courseStatusPost"=>array(),
            );

            $courseManage = Coursemanage::Model()->findAll("id=:course_id AND active=:active ", array(
                "course_id"=>$valueByUser->course_id, "active"=>"y"
            ));

            if(count($courseManage) > 0){
                foreach ($courseManage as $keyCourseManage=> $valueCourseManage) {
                        if($valueCourseManage->type == 'pre'){
                            //preTest
							$criteria = new CDbCriteria;
							$criteria->compare("course_id",$valueByUser->course_id);
							$criteria->compare("user_id",$valueByUser->pro->user_id);
							$criteria->compare("gen_id",$valueByUser->gen_id);
							$criteria->compare("type",'pre');
							$criteria->compare("active","y");
							$criteria->order = "score_id DESC";
                            $ScorePre = Coursescore::model()->find($criteria);

                            $allUsersScore[$keyByUser]["courseScorePre"] = ($ScorePre) ? $ScorePre->score_number : "-";
                            $allUsersScore[$keyByUser]["courseTotalPre"] = ($ScorePre) ? $ScorePre->score_total : "-";
                            $allUsersScore[$keyByUser]["courseStatusPre"] = ($ScorePre) ? $ScorePre->score_past : "-";
                            //preTest
                        }else if($valueCourseManage->type == 'course'){
                            //postTest
								$criteria = new CDbCriteria;
								$criteria->compare("course_id",$valueByUser->course_id);
								$criteria->compare("user_id",$valueByUser->pro->user_id);
								$criteria->compare("gen_id",$valueByUser->gen_id);
								$criteria->compare("type",'post');
								$criteria->compare("active","y");
								$criteria->order = "score_id DESC";
								$ScorePost = Coursescore::model()->find($criteria);

								$allUsersScore[$keyByUser]["courseScorePost"] = ($ScorePost) ? $ScorePost->score_number : "-";
								$allUsersScore[$keyByUser]["courseTotalPost"] = ($ScorePost) ? $ScorePost->score_total : "-";
								$allUsersScore[$keyByUser]["courseStatusPost"] = ($ScorePost) ? $ScorePost->score_past : "-";
								
                             
                            // postTest
                        }
                }
            }

        }


		foreach($allUsersScore as $key => $value){
			if($value["courseStatusPost"] != $result_status){ //เช็คเฉพาะ Post test
				unset($allUsersScore[$key]);
			}else if(!$value["courseStatusPre"] && !$value["courseStatusPost"] ){
				unset($allUsersScore[$key]);
			}else if(!$value['userId']){
				unset($allUsersScore[$key]);
			}
		}

        return $allUsersScore;
	
	}

	public function ByCourseLesson($data) //บทเรียน เรียนรู้ด้วยตัวเอง
	{
		$course_id = $data['course_id'];
		$generation = $data['generation'];
		$result_status = $data['result_status'] == 1 ? 'y' : 'n';
		$name_id_search = $data['name_id_search'];
		$email = $data['email'];


		$allUsersScore = array();
        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$course_id);
        $courseOnline = CourseOnline::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->with = array('pro','course','gen','pro.user');
        $criteria->compare("t.course_id",$course_id);

		if(isset($generation) && $generation != null && $generation != 0){
		    $criteria->compare('gen.gen_id',$generation,true);
		}
      
		if(isset($name_id_search) && $name_id_search != null){
			if ( is_numeric($name_id_search) ) {
		        $criteria->compare('pro.identification',trim($name_id_search),true);
			} else {
				$ex_fullname = explode(" ", trim($name_id_search));

				if(isset($ex_fullname[0])){
					$pro_fname = $ex_fullname[0];
		
					if (!preg_match('/[^A-Za-z]/', $pro_fname))
					{
						$criteria->addCondition("pro.firstname_en = '".$pro_fname."' OR pro.lastname_en = '".$pro_fname."'");
					}else{
						$criteria->addCondition("pro.firstname = '".$pro_fname."' OR pro.lastname = '".$pro_fname."'");
					}    
				}
	
				if(isset($ex_fullname[1])){
					$pro_lname = $ex_fullname[1];
					if (!preg_match('/[^A-Za-z]/', $pro_lname))
					{
						$criteria->compare('pro.lastname_en',$pro_lname,true);
					}else{
						$criteria->compare('pro.lastname',$pro_lname,true);
					}    
				}
			}
        }

		if(isset($email) && $email != null){
			$criteria->compare('user.email',trim($email),true);
		}

        if($courseOnline->price == "y" || $courseOnline->document_status == "y"){
            $userAllPayment = array();
            $criteriaCourseTemp = new CDbCriteria;
            $criteriaCourseTemp->compare("course_id",$course_id);
            if($courseOnline->price == "y"){
                $criteriaCourseTemp->compare("status_payment","y");
            }
            if($courseOnline->document_status == "y"){
                $criteriaCourseTemp->compare("status_document","y");
            }
            $CourseTemp = CourseTemp::model()->findAll($criteriaCourseTemp);
            foreach ($CourseTemp as $keyCourseTemp => $valueCourseTemp) {
                $userAllPayment[] = $valueCourseTemp->user_id;
            }
            $criteria->addInCondition("t.user_id",$userAllPayment);

        }
        $criteria->compare("t.active",'y');
        $allUsersLogStartCourse = LogStartcourse::model()->findAll($criteria);
		$resultArr = [];
		foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {       
			$resultArr [] = $valueByUser;
		}
		uasort($resultArr, function($a, $b) { return $a['id'] <=> $b['id']; });
		$result = array_column($resultArr, null, 'user_id');
		$result = array_filter($result, function($v) { return !empty($v['user_id']); });

		usort($result, function($a, $b) {
			return $a['id'] - $b['id'];
		});

		$allUsersLogStartCourse = $result;
        foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
			$criteria = new CDbCriteria;
            $criteria->compare("lesson.active","y");
            $criteria->compare("course_id",$valueByUser->course_id);
            $criteria->compare("lang_id","1");
            $criteria->order = "lesson_no ASC";
            $Lesson = Lesson::model()->findAll($criteria);

            $allUsersScore[$keyByUser] = array(
                "id"=>$keyByUser+1,
				"userId"=>$valueByUser->pro->user_id,
                "idCard"=>$valueByUser->pro->identification,
                "title"=>$valueByUser->pro->ProfilesTitle->prof_title,
                "fName"=>$valueByUser->pro->firstname,
                "lName"=>$valueByUser->pro->lastname,
                "institutionName"=>$valueByUser->course->usercreate->institution->institution_name,
                "courseTitle"=>$valueByUser->course->course_title,
				"lessonScorePre"=>null,
                "lessonTotalPre"=>null,
                "lessonStatusPre"=>null,
                "lessonScorePost"=>null,
                "lessonTotalPost"=>null,
                "lessonStatusPost"=>null,
            );

			if(count($Lesson) > 0){
                foreach ($Lesson as $keyLesson => $valueLesson) {
                    $manages = Manage::Model()->findAll("id=:id AND active=:active ", array(
                        "id"=>$valueLesson->id, "active"=>"y"
                    ));
                    if(count($manages) > 0){
						$allUsersScore[$keyByUser]["lesson_id"] = $valueLesson->id;
						$allUsersScore[$keyByUser]["lesson_title"] = $valueLesson->title;
                        foreach($manages as $manage){
                            if($manage->type == 'pre'){
                                //preTest
                                $criteria = new CDbCriteria;
								$criteria->compare("course_id",$valueByUser->course_id);
                                $criteria->compare("lesson_id",$valueLesson->id);
                                $criteria->compare("user_id",$valueByUser->pro->user_id);
                                $criteria->compare("gen_id",$valueByUser->gen_id);
                                $criteria->compare("type",'pre');
                                $criteria->compare("active","y");
                                $criteria->order = "score_id DESC";
								// $criteria->select = '*,MAX(score_number) score_number';
								// $criteria->compare("course_id",$valueByUser->course_id);
								// $criteria->compare("lesson_id",$valueLesson->id);
								// $criteria->compare("user_id",$valueByUser->pro->user_id);
								// $criteria->compare("gen_id",$valueByUser->gen_id);
								// $criteria->compare("type",'pre');
								// $criteria->compare("active","y");
								// $criteria->order = 'score_number';
                                $ScorePre = Score::model()->find($criteria);
                                $allUsersScore[$keyByUser]["lessonScorePre"] = ($ScorePre) ? $ScorePre->score_number : "-";
                                $allUsersScore[$keyByUser]["lessonTotalPre"] = ($ScorePre) ? $ScorePre->score_total : "-";
                                $allUsersScore[$keyByUser]["lessonStatusPre"] = ($ScorePre) ? $ScorePre->score_past : "-";
                                //preTest
                            }else if($manage->type == 'post'){
                                //postTest
                                 $criteria = new CDbCriteria;
								 $criteria->compare("course_id",$valueByUser->course_id);
								 $criteria->compare("lesson_id",$valueLesson->id);
								 $criteria->compare("user_id",$valueByUser->pro->user_id);
								 $criteria->compare("gen_id",$valueByUser->gen_id);
								 $criteria->compare("type",'post');
								 $criteria->compare("active","y");
								 $criteria->order = "score_id DESC";
                                 $ScorePost = Score::model()->find($criteria);
                                 $allUsersScore[$keyByUser]["lessonScorePost"] = ($ScorePost) ? $ScorePost->score_number : "-";
                                 $allUsersScore[$keyByUser]["lessonTotalPost"] = ($ScorePost) ? $ScorePost->score_total : "-";
                                 $allUsersScore[$keyByUser]["lessonStatusPost"] = ($ScorePost) ? $ScorePost->score_past : "-";
                            
                                // postTest
                            }
                        }
                    }
                }
            }
        }



		foreach($allUsersScore as $key => $value){//เช็คเฉพาะ Post test
			if($value["lessonStatusPost"] != $result_status){
				unset($allUsersScore[$key]);
			}else if(!$value["lessonStatusPre"] && !$value["lessonStatusPost"] ){
				unset($allUsersScore[$key]);
			}else if(!$value['userId']){
				unset($allUsersScore[$key]);
			}
		}
        return $allUsersScore;
	}

	public function ByMsteamsLesson($data) //บทเรียน เรียนรู้ทางไกล
	{
		$ms_teams_id = $data['course_id'];
		$result_status = $data['result_status'] == 1 ? 'y' : 'n';
		$name_id_search = $data['name_id_search'];
		$email = $data['email'];
		
		$allUserAdminCreateCourse = array();
		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		// $criteria->addInCondition('institution_id', $institution_array);
		$UserAdmin = Users::model()->findAll($criteria);
		foreach ($UserAdmin as $keyUserAdmin => $valueUserAdmin) {
			$allUserAdminCreateCourse[] = $valueUserAdmin->id;
		}


		$MsTeam = MsTeams::model()->find(array(
			'condition' => 'id="' . $ms_teams_id  . '"',
		));

		$allUsersScore = array();
		// ห้องเรียนออนไลน์
		$criteria = new CDbCriteria;
		$criteria->compare('course_md_code', $MsTeam->course_md_code);
		$criteria->addInCondition("create_by",$allUserAdminCreateCourse);
		$MsTeams = MsTeams::model()->findAll($criteria);

		$array_MsTeams = array();
		foreach ($MsTeams as $keyMsTeams => $valueMsTeams) {
			$array_MsTeams[] = $valueMsTeams->id;
		}

		$criteria = new CDbCriteria;
		$criteria->with = array('pro','pro.user');
		$criteria->addInCondition("ms_teams_id",$array_MsTeams);

		if(isset($name_id_search) && $name_id_search != null){
			if ( is_numeric($name_id_search) ) {
		        $criteria->compare('pro.identification',trim($name_id_search),true);
			} else {
				$ex_fullname = explode(" ", trim($name_id_search));

				if(isset($ex_fullname[0])){
					$pro_fname = $ex_fullname[0];
		
					if (!preg_match('/[^A-Za-z]/', $pro_fname))
					{
						$criteria->addCondition("pro.firstname_en = '".$pro_fname."' OR pro.lastname_en = '".$pro_fname."'");
					}else{
						$criteria->addCondition("pro.firstname = '".$pro_fname."' OR pro.lastname = '".$pro_fname."'");
					}    
				}
	
				if(isset($ex_fullname[1])){
					$pro_lname = $ex_fullname[1];
					if (!preg_match('/[^A-Za-z]/', $pro_lname))
					{
						$criteria->compare('pro.lastname_en',$pro_lname,true);
					}else{
						$criteria->compare('pro.lastname',$pro_lname,true);
					}    
				}
			}
        }

		if(isset($email) && $email != null){
			$criteria->compare('user.email',trim($email),true);
		}

		$allUsersLogStartCourse = LogStartMsTeams::model()->findAll($criteria);
		$resultArr = [];
		foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {       
			$resultArr [] = $valueByUser;
		}
		uasort($resultArr, function($a, $b) { return $a['id'] <=> $b['id']; });
		$result = array_column($resultArr, null, 'user_id');
		$result = array_filter($result, function($v) { return !empty($v['user_id']); });

		usort($result, function($a, $b) {
			return $a['id'] - $b['id'];
		});

		$allUsersLogStartCourse = $result;
		foreach ($allUsersLogStartCourse as $keyByUser => $valueByUser) {
			
			$criteria = new CDbCriteria;
			$criteria->with = array('manages');
			$criteria->compare("manage.active","y");
			$criteria->compare("lessonteams.active","y");
			$criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
			$criteria->compare("lang_id","1");
			$criteria->order = "lesson_no ASC";
			$LessonMs = LessonMsTeams::model()->findAll($criteria);
			$allUsersScore[$keyByUser] = array(
				"userId"=>$valueByUser->pro->user_id,
				"idCard"=>$valueByUser->pro->identification,
				"title"=>$valueByUser->pro->ProfilesTitle->prof_title,
				"fName"=>$valueByUser->pro->firstname,
				"lName"=>$valueByUser->pro->lastname,
				"institutionName"=>$valueByUser->msteams->createby->institution->institution_name,
				"courseTitle"=>$valueByUser->msteams->name_ms_teams,
				"lessonScorePre"=>null,
                "lessonTotalPre"=>null,
                "lessonStatusPre"=>null,
                "lessonScorePost"=>null,
                "lessonTotalPost"=>null,
                "lessonStatusPost"=>null,
			);
			if($LessonMs){
				foreach ($LessonMs as $keyLessonMs => $valueLessonMs) {
					$allUsersScore[$keyByUser]["lesson_id"] = $valueLessonMs->id;
					$allUsersScore[$keyByUser]["lesson_title"] = $valueLessonMs->title;
					if(count($valueLessonMs->manages) > 0){
						foreach($valueLessonMs->manages as $manage){
							if($manage->type == 'pre'){
								//preTest
								$criteria = new CDbCriteria;
								$criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
                                $criteria->compare("lesson_teams_id",$valueLessonMs->id);
                                $criteria->compare("user_id",$valueByUser->pro->user_id);
                                $criteria->compare("gen_id",$valueByUser->gen_id);
                                $criteria->compare("type",'pre');
                                $criteria->compare("active","y");
                                $criteria->order = "score_id DESC";
								$ScoreMsPre = ScoreMsTeams::model()->find($criteria);

								$allUsersScore[$keyByUser]["lessonScorePre"] = ($ScoreMsPre) ? $ScoreMsPre->score_number : "-";
								$allUsersScore[$keyByUser]["lessonTotalPre"] = ($ScoreMsPre) ? $ScoreMsPre->score_total : "-";
								$allUsersScore[$keyByUser]["lessonStatusPre"] = ($ScoreMsPre) ? $ScoreMsPre->score_past : "-";
								//preTes
							}
							if($manage->type == 'post'){
								//postTest
								$criteria = new CDbCriteria;
								$criteria->compare("ms_teams_id",$valueByUser->ms_teams_id);
                                $criteria->compare("lesson_teams_id",$valueLessonMs->id);
                                $criteria->compare("user_id",$valueByUser->pro->user_id);
                                $criteria->compare("gen_id",$valueByUser->gen_id);
                                $criteria->compare("type",'post');
                                $criteria->compare("active","y");
                                $criteria->order = "score_id DESC";

								$ScoreMsPost = ScoreMsTeams::model()->find($criteria);
								$allUsersScore[$keyByUser]["lessonScorePost"] = ($ScoreMsPost) ? $ScoreMsPost->score_number : "-";
								$allUsersScore[$keyByUser]["lessonTotalPost"] = ($ScoreMsPost) ? $ScoreMsPost->score_total : "-";
								$allUsersScore[$keyByUser]["lessonStatusPost"] = ($ScoreMsPost) ? $ScoreMsPost->score_past : "-";
								//postTest
							}
						}
					}
				}
			}
		}

		foreach($allUsersScore as $key => $value){
			if($value["lessonStatusPost"] != $result_status){
				unset($allUsersScore[$key]);
			}else if(!$value["lessonStatusPre"] && !$value["lessonStatusPost"] ){
				unset($allUsersScore[$key]);
			}else if(!$value['userId']){
				unset($allUsersScore[$key]);
			}
		}

		return $allUsersScore;

	}


	
}
