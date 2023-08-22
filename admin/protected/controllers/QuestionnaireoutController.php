<?php

class QuestionnaireoutController extends Controller
{
    public function init()
    {
        // parent::init();
        // $this->lastactivity();
        if(Yii::app()->user->id == null){
                $this->redirect(array('site/index'));
            }
        
    }
    
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
        );
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
    	return array(
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

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionExcel($id)
    {
    	$this->layout=false;
//        var_dump($_GET['lesson_id']);
    	$header = QHeader::model()->findByPk($id);
    	$this->render('excel', array(
    		'header' => $header
    	));
    }

    /*========== CreateChoice ==========*/
    public function actionCreate()
    {
//		$modelGroup = $this->loadModelGroup($id);
//		$modelQues = new Question;
//		$modelChoice = new Choice;

    	if(isset($_POST['sectionTitle']) && isset($_POST['questionType']) && isset($_POST['questionTitle']))
    	{
    		$inputTypeArray = array('input' => 1,'radio' => 2, 'checkbox' => 3, 'contentment' => 4, 'text'=> 5);
    		$headerModel = new QHeader;
    		$headerModel->survey_name = $_POST['surveyHeader'];
    		$headerModel->instructions = CHtml::encode($_POST['surveyHeaderDetail']);
    		$headerModel->type = 'outside';
    		$headerModel->create_by = Yii::app()->user->id;
    		$headerModel->create_date = date('Y-m-d H:i:s');
    		if($headerModel->save()){
    			foreach($_POST['sectionTitle'] as $sectionKey => $sectionValue) {
    				$sectionModel = new QSection;
    				$sectionModel->survey_header_id = $headerModel->survey_header_id;
    				$sectionModel->section_title = $sectionValue;
    				if($sectionModel->save()){
    					foreach($_POST['questionType'][$sectionKey] as $questionKey => $questionValue) {
    						$questionModel = new QQuestion;
    						$questionModel->survey_section_id = $sectionModel->survey_section_id;
    						$questionModel->input_type_id = $inputTypeArray[$questionValue];
    						$questionModel->question_name = $_POST['questionTitle'][$sectionKey][$questionKey];
    						if($questionModel->input_type_id == '4'){
    							$questionModel->question_range = $_POST['questionRange'][$sectionKey][$questionKey];
    						}
    						if($questionModel->save()){
    							if($questionModel->input_type_id != 5 && $questionModel->input_type_id != 1){
    								foreach($_POST['choiceTitle'][$sectionKey][$questionKey] as $choiceKey => $choiceValue) {
    									$choiceModel = new QChoice;
    									$choiceModel->question_id = $questionModel->question_id;
    									$choiceModel->option_choice_name = $choiceValue;
    									if($_POST['choiceSpecify'][$sectionKey][$questionKey][$choiceKey] == "y"){
    										$choiceModel->option_choice_type = 'specify';
    									}
    									$choiceModel->save();
    								}
    							}else{
    								if($questionModel->input_type_id == 5){
    									$choiceModel = new QChoice;
    									$choiceModel->question_id = $questionModel->question_id;
    									$choiceModel->option_choice_name = "text";
    									$choiceModel->save();
    								}else{
    									$choiceModel = new QChoice;
    									$choiceModel->question_id = $questionModel->question_id;
    									$choiceModel->option_choice_name = "input";
    									$choiceModel->save();
    								}
    							}
    						}
    					}
    				}
    			}
    		}
    		if(Yii::app()->user->id){
    			Helpers::lib()->getControllerActionId();
    		}
    		$this->redirect(array('index', 'id' => $headerModel->survey_header_id));
    	}

    	$this->render('create');
    }

    public function actionImport($id)
    {
    	$model=new Question('import');

    	if(isset($_POST['Question']))
    	{
    		$phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
    		include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

    		$model->attributes=$_POST['Question'];
    		$model->excel_file = CUploadedFile::getInstance($model,'excel_file');
            //if ($model->excel_file && $model->validate()) {
    		$webroot = YiiBase::getPathOfAlias('webroot');
    		$filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
    		$model->excel_file->saveAs($filename);
    		$inputFileName = $filename;
    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
    		$objReader->setReadDataOnly(true);
    		$objPHPExcel = $objReader->load($inputFileName);
    		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    		$highestRow = $objWorksheet->getHighestRow();
    		$highestColumn = $objWorksheet->getHighestColumn();

    		$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
    		$headingsArray = $headingsArray[1];

    		$r = -1;
    		$namedDataArray = array();
    		for ($row = 2; $row <= $highestRow; ++$row) {
    			$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
    			if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
    				++$r;
    				foreach($headingsArray as $columnKey => $columnHeading) {
    					$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
    				}
    			}
    		}

//				echo '<pre>';
//				var_dump($namedDataArray[0]["ตัวเลือกที่ 3"]);
//				echo '</pre><hr />';
    		$index = 0;
    		foreach($namedDataArray as $result){

    			$questionModel = new Question();
    			$questionModel->group_id = $id;
    			$questionModel->ques_type = 2;
    			$questionModel->ques_title = $result["คำถาม"];

    			if($questionModel->save()){
    				$index++;
    				for($i=1;$i<=6;$i++) {
    					$choiceTitle = trim($result["ตัวเลือกที่ ".$i]);
    					if($choiceTitle != "") {
    						$choiceModel = new Choice();
    						$choiceModel->ques_id = $questionModel->ques_id;
    						$choiceModel->choice_detail = str_replace("*", "", $choiceTitle);
    						if ($choiceTitle[0] == "*") {
    							$choiceModel->choice_answer = 1;
    						} else {
    							$choiceModel->choice_answer = 2;
    						}
    						$choiceModel->choice_type = $result["ประเภท"];
    						$choiceModel->save();
    					}
    				}
    			}

    		}

                //if($model->save())
    		Yii::app()->user->setFlash('success', "Import ข้อสอบทั้งหมด ".$index." ข้อ");
    		$this->redirect(array('import','id'=>$id));
            //}

    	}

    	$this->render('import',array(
    		'model'=>$model,
    	));
    }

	//***** Save Question All *****//
    private function SaveQuesAll($Qtype,$Ctype,$IdGroup)
    {
    	$modelQues = new Question;
    	$modelChoice = new Choice;
		//***** ประเภทของข้อสอบ 1=2ตัวเลือก, 2=คำตอบเดียว , 3=หลายคำตอบ *****//
    	$QuesType = $Qtype;
		//***** End Type *****//

		//***** Type radio or checkbox *****//
    	$ChoiceType = $Ctype;
		//***** End Type *****//

    	$modelQues->attributes = $_POST['Question'];
    	$count = $_POST['countQuestion'];
    	for($i=0; $i<=(int)$count; $i++)
    	{
    		$modelQues->attributes = $_POST['Question'];
    		if(isset($modelQues->ques_title[$i]) && $modelQues->ques_title[$i] != '')
    		{		
    			/***** SAVE *****/			
    			$SaveQues = new Question;
    			$SaveQues->group_id = $IdGroup;
				//$SaveQues->ques_type = $QuesType;
    			$SaveQues->ques_type = $_POST['QuestionType'][$i];
    			$SaveQues->ques_title = CHtml::encode($modelQues->ques_title[$i]);
    			$SaveQues->save();
    			/***** END SAVE *****/	
    			$countChoice = $_POST['countBox'][$i];
    			for($z=0; $z<(int)$countChoice; $z++)
    			{
    				$modelChoice = new Choice;
    				$sum = $z+1;
    				if(isset($_POST['Choice']['choice_answer'][$i][$z]))
    				{
    					if($_POST['Choice']['choice_answer'][$i][$z] != 0)
    					{
    						if(isset($_POST['Choice']['choice_detail'][$i][$z]))
    						{
    							$modelChoice->ques_id = $SaveQues->ques_id;
    							$modelChoice->choice_answer = $_POST['Choice']['choice_answer'][$i][$z];
    							$modelChoice->choice_detail = CHtml::encode($_POST['Choice']['choice_detail'][$i][$z]);
    						}
    					}
    					else
    					{
    						$modelChoice->ques_id = $SaveQues->ques_id;
    						$modelChoice->choice_detail = CHtml::encode($_POST['Choice']['choice_detail'][$i][$z]);
    					}
    				}
    				else
    				{
    					if(isset($_POST['Choice']['choice_detail'][$i][$z]))
    					{
    						$modelChoice->ques_id = $SaveQues->ques_id;
    						$modelChoice->choice_detail = CHtml::encode($_POST['Choice']['choice_detail'][$i][$z]);
    					}
    				}
    				if(isset($_POST['Choice']['choice_detail'][$i][$z]))
    				{
						//$modelChoice->choice_type = $ChoiceType;
    					$modelChoice->choice_type = $_POST['Choice']['choice_type'][$i][$z];
    					$modelChoice->save();
    				}
    			}
    		}
    	}
    	return true;
    }
	//***** End Save Question All *****//
    public function actionChoose($id){
    	$lesson = Lesson::model()->findByPk($id);
    	if(isset($_POST['header_id'])){
    		$lesson->header_id = $_POST['header_id'];
    		$lesson->save();
    		$this->redirect(array('lesson/index'));
    	}

    	$this->render('choose',array(
    		'lesson'=>$lesson
    	));
    }

    public function actionSendmail($id){

    	if($_GET['university_id'] == ''){
    		$user = User::model()->actvie()->findAll();
    	}else{
    		$user = User::model()->actvie()->findAll("student_house = '".$_GET['university_id']."'");
    	}

    	if(count($user) > 0){

    		foreach ($user as $userKey => $userValue) {
    			$url = Yii::app()->getBaseUrl(true)."/../index.php/questionnaire/out/".$id."?username=".$userValue->username."&email=".$userValue->email;
    			$message = '
    			<strong>สวัสดี คุณ' . $userValue->first_name . ' ' . $userValue->last_name . '</strong><br /><br />

    			โปรดคลิกลิงค์ต่อไปนี้ เพื่อทำแบบสอบถาม<br />
    			<a href="' . $url . '">ทำแบบสอบถาม</a><br />
    			<strong>Username</strong> : ' . $userValue->username . '<br /><br />

    			ยินดีตอนรับเข้าสู่ระบบ SET E-Traning<br /><br />

    			ทีมงาน SET
    			';
    			$SettingAll = Helpers::lib()->SetUpSetting();
    			$adminEmail = $SettingAll['USER_EMAIL'];
    			$adminEmailPass = $SettingAll['PASS_EMAIL'];
    			$mail = Yii::app()->mailer;
    			$mail->CharSet = 'utf-8';
    			$mail->IsSMTP();
				$mail->Host = 'smtp.gmail.com'; // gmail server
				$mail->Port = '465'; // port number
				$mail->SMTPSecure = "ssl";
				$mail->SMTPKeepAlive = true;
				$mail->Mailer = "smtp";
				$mail->SMTPAuth = true;
				$mail->SMTPDebug = false;
				$mail->Username = $adminEmail;
				$mail->Password = $adminEmailPass;
				$mail->SetFrom('etraining@bangkokwebsolution.com', 'SET E-Training');
				$mail->AddAddress($userValue->email, 'คุณ' . $userValue->first_name . ' ' . $userValue->last_name);
				$mail->Subject = 'ยินดีต้อนรับเข้าสู่ระบบ SET E-Training คุณมีแบบสอบถามใหม่';
				$mail->Body = $message;
				$mail->IsHTML(true);
				$mail->Send();

			}
			$sendlog = new QuestSendLog;
			$sendlog->university_id = $_GET['university_id'];
			$sendlog->header_id = $id;
			$sendlog->send_date = date('Y-m-d H:i:s');
			$sendlog->save();
		}
	}

	public function actionShowPoint()
	{		
		if(isset($_POST['Count']))
		{
			$count = count($_POST['Count']);
			$scoreSum = 0;
			for($i=0; $i<(int)$count; $i++)
			{
				$criteria = new CDbCriteria;
				$criteria->condition = " ques_id = '".$_POST['Ques'][$i]."' ";
				$Question = Question::model()->find($criteria);

				$scoreGood[$i] = 0; //Good
				$scoreWrong[$i] = 0; //Wrong
				$scoreChoice[$i] = 0;
				$countChoice = Choice::model()->findAll("ques_id=:ques_id", array(
					"ques_id" =>$Question->ques_id,
				));
				foreach($countChoice as $z=>$resultChoice)
				{
					if($resultChoice->choice_answer == 1){ $scoreChoice[$i] = $scoreChoice[$i]+1; }
					if($_POST['Choice']['choice_answer'][$i][$z] == $resultChoice->choice_answer){
						$scoreGood[$i] = $scoreGood[$i]+1;
			    		// echo '<font color=gree>Y Get '.$_POST['Choice']['choice_answer'][$i][$z].'  DB '
			    		//  .$resultChoice->choice_answer.'</font><br>';
					}else{
						if($_POST['Choice']['choice_answer'][$i][$z] == 1){
							$scoreWrong[$i] = $scoreWrong[$i]+1;
					    		// echo 'N Get '.$_POST['Choice']['choice_answer'][$i][$z].'  DB '
					    		//  .$resultChoice->choice_answer.'<br>';
						}else{
			    			//echo 'NULL<br>';
						}
					}	
				}
				$SumScore = ((int)$scoreGood[$i]-(int)$scoreWrong[$i]);
				if($scoreChoice[$i] == $SumScore){ $scoreSum = $scoreSum+1; }
				// echo '<hr>';
				// echo 'SUM COUNT '.$scoreChoice[$i];
			 	// echo '<hr>';
				// echo 'GOOD '.$scoreGood[$i].'/ WRONG '.$scoreWrong[$i];
				// echo '<hr>';
				// echo 'SUM NUM '.$SumScore;
				// echo '<hr>';
				// echo 'PASS '.$scoreSum;
				//echo '<hr>';
			}
			echo 'PASS '.$scoreSum;
		}
	}

	public function actionUpdate($id)
	{
		$header = $this->loadModel($id);
		// echo '<pre>';
		// var_dump($header);
		// exit();
//		$modelChoice = Choice::model()->findAll(array('ques_id'=>$modelQues->ques_id));

		if(isset($_POST['sectionTitleOld']) || isset($_POST['sectionTitle']))
		{
			$header->survey_name = $_POST['surveyHeaderOld'];
			$header->instructions = CHtml::encode($_POST['surveyHeaderDetailOld']);
			$header->save();
			//old (update)

			$sectionOldModel = $header->sections;
			$section_old_ids = array();
			if(count($sectionOldModel) > 0) {
				foreach ($sectionOldModel as $sectionKey => $section) {
					$section_old_ids[] = $section->survey_section_id;
				}
			}

			$sectionTitle = $_POST['sectionTitleOld'];
			$section_new_ids = array();
			if(count($sectionTitle) > 0){
				foreach ($sectionTitle as $sectionKey => $section) {
					$section_new_ids[] = $sectionKey;
				}
			}

			$update_ids = array_intersect($section_new_ids,$section_old_ids);
			$delete_ids = array_diff($section_old_ids,$section_new_ids);

			if(count($update_ids) > 0){
				foreach ($update_ids as $section_id) {
					$sectionModel = QSection::model()->findByPk($section_id);
					$sectionModel->section_title = $sectionTitle[$section_id];
					$sectionModel->save();

					if(isset($_POST['questionTitleOld'][$section_id])){

						$questionModel = $sectionModel->questions;
						$question_old_ids = array();
						if(count($questionModel) > 0) {
							foreach ($questionModel as $questionKey => $question) {
								$question_old_ids[] = $question->question_id;
							}
						}

						$questionTitle = $_POST['questionTitleOld'][$section_id];
						$questionRange = $_POST['questionRangeOld'][$section_id];
						$question_new_ids = array();
						if(count($questionTitle) > 0){
							foreach ($questionTitle as $questionKey => $question) {
								$question_new_ids[] = $questionKey;
							}
						}

						$update_question_ids = array_intersect($question_new_ids,$question_old_ids);
						$delete_question_ids = array_diff($question_old_ids,$question_new_ids);

						if(count($update_question_ids) > 0){
							foreach ($update_question_ids as $question_id) {
								$questionModel = QQuestion::model()->findByPk($question_id);
								$questionModel->question_name = $questionTitle[$question_id];
								if($questionModel->input_type_id == "4"){
									$questionModel->question_range = ($questionRange[$question_id]!=""?$questionRange[$question_id]:"5");
								}
								$questionModel->save();

								if(isset($_POST['choiceTitleOld'][$section_id][$question_id])){

									$choiceModel = $questionModel->choices;
									$choice_old_ids = array();
									if(count($choiceModel) > 0) {
										foreach ($choiceModel as $choiceKey => $choice) {
											$choice_old_ids[] = $choice->option_choice_id;
										}
									}

									$choiceTitle = $_POST['choiceTitleOld'][$section_id][$question_id];
									$choice_new_ids = array();
									if(count($choiceTitle) > 0){
										foreach ($choiceTitle as $choiceKey => $choice) {
											$choice_new_ids[] = $choiceKey;
										}
									}

									$update_choice_ids = array_intersect($choice_new_ids,$choice_old_ids);
									$delete_choice_ids = array_diff($choice_old_ids,$choice_new_ids);


									if(count($update_choice_ids) > 0){
										foreach ($update_choice_ids as $choice_id) {
											$choiceModel = QChoice::model()->findByPk($choice_id);
											$choiceModel->option_choice_name = $choiceTitle[$choice_id];
											if($_POST['choiceSpecifyOld'][$section_id][$question_id][$choice_id] == "y"){
												$choiceModel->option_choice_type = 'specify';
											}else{
												$choiceModel->option_choice_type = 'normal';
											}
											$choiceModel->save();
										}
									}

									if(count($delete_choice_ids) > 0){

										foreach ($delete_choice_ids as $choice_id) {
											if ($choiceModel = QChoice::model()->findByPk($choice_id)) {
												$choiceModel->delete();
											}
										}
									}

								}

								if(isset($_POST['choiceTitleOldAdd'][$section_id][$question_id])){
									if($questionModel->input_type_id != 5 && $questionModel->input_type_id != 1){
										foreach($_POST['choiceTitleOldAdd'][$section_id][$question_id] as $choiceKey => $choiceValue) {
											$choiceModel = new QChoice;
											$choiceModel->question_id = $questionModel->question_id;
											$choiceModel->option_choice_name = $choiceValue;
											if($_POST['choiceSpecifyOldAdd'][$section_id][$question_id][$choiceKey] == "y"){
												$choiceModel->option_choice_type = 'specify';
											}
											$choiceModel->save();
										}
									}else{

										if($questionModel->input_type_id == 5){
											$choiceModel = new QChoice;
											$choiceModel->question_id = $questionModel->question_id;
											$choiceModel->option_choice_name = "text";
											$choiceModel->save();
										}else{
											$choiceModel = new QChoice;
											$choiceModel->question_id = $questionModel->question_id;
											$choiceModel->option_choice_name = "input";
											$choiceModel->save();
										}

									}
								}


							}
						}

						if(count($delete_question_ids) > 0){

							foreach ($delete_question_ids as $question_id) {
								if ($questionModel = QQuestion::model()->findByPk($question_id)) {
									$questionModel->delete();
								}

								$choiceModel = QChoice::model()->findAll("question_id = '".$question_id."'");
								if(count($choiceModel) > 0){
									foreach ($choiceModel as $choiceKey => $choiceValue) {
										$choiceValue->delete();
									}
								}
							}

						}

					}

					if(isset($_POST['questionTitleOldAdd'][$section_id])){
						$inputTypeArray = array('input' => 1,'radio' => 2, 'checkbox' => 3, 'contentment' => 4, 'text'=> 5);
						foreach($_POST['questionTypeOldAdd'][$section_id] as $questionKey => $questionValue) {
							$questionModel = new QQuestion;
							$questionModel->survey_section_id = $sectionModel->survey_section_id;
							$questionModel->input_type_id = $inputTypeArray[$questionValue];
							if($questionModel->input_type_id == "4"){
								$questionModel->question_range = ($_POST['questionRangeOldAdd'][$section_id][$questionKey]!=""?$_POST['questionRangeOldAdd'][$section_id][$questionKey]:"5");
							}
							$questionModel->question_name = $_POST['questionTitleOldAdd'][$section_id][$questionKey];
							if($questionModel->save()){
								if($questionModel->input_type_id != 5 && $questionModel->input_type_id != 1){
									foreach($_POST['choiceTitleOldAdd'][$section_id][$questionKey] as $choiceKey => $choiceValue) {
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = $choiceValue;
										if($_POST['choiceSpecifyOldAdd'][$section_id][$questionKey][$choiceKey] == "y"){
											$choiceModel->option_choice_type = 'specify';
										}
										$choiceModel->save();
									}
								}else{

									if($questionModel->input_type_id == 5){
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = "text";
										$choiceModel->save();
									}else{
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = "input";
										$choiceModel->save();
									}

								}
							}
						}
					}

				}
			}

			if(count($delete_ids) > 0){

				foreach ($delete_ids as $section_id) {
					if ($sectionModel = QSection::model()->findByPk($section_id)) {
						$sectionModel->delete();
					}

					$questionModel = QQuestion::model()->findAll("survey_section_id = '".$section_id."'");
					if(count($questionModel) > 0){
						foreach ($questionModel as $questionKey => $questionValue) {
							$choiceModel = QChoice::model()->findAll("question_id = '".$questionValue->question_id."'");
							if(count($choiceModel) > 0){
								foreach ($choiceModel as $choiceKey => $choiceValue) {
									$choiceValue->delete();
								}
							}
							$questionValue->delete();
						}
					}
				}

			}



			if(isset($_POST['sectionTitle']))
			{

				$inputTypeArray = array('input' => 1,'radio' => 2, 'checkbox' => 3, 'contentment' => 4, 'text'=> 5);

				foreach($_POST['sectionTitle'] as $sectionKey => $sectionValue) {
					$sectionModel = new QSection;
					$sectionModel->survey_header_id = $header->survey_header_id;
					$sectionModel->section_title = $sectionValue;
					if($sectionModel->save()){
						foreach($_POST['questionType'][$sectionKey] as $questionKey => $questionValue) {
							$questionModel = new QQuestion;
							$questionModel->survey_section_id = $sectionModel->survey_section_id;
							$questionModel->input_type_id = $inputTypeArray[$questionValue];
							$questionModel->question_name = $_POST['questionTitle'][$sectionKey][$questionKey];
							if($questionModel->input_type_id == '4'){
								$questionModel->question_range = $_POST['questionRange'][$sectionKey][$questionKey];
							}
							if($questionModel->save()){
								if($questionModel->input_type_id != 5 && $questionModel->input_type_id != 1){
									foreach($_POST['choiceTitle'][$sectionKey][$questionKey] as $choiceKey => $choiceValue) {
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = $choiceValue;
										if($_POST['choiceSpecify'][$sectionKey][$questionKey][$choiceKey] == "y"){
											$choiceModel->option_choice_type = 'specify';
										}
										$choiceModel->save();
									}
								}else{

									if($questionModel->input_type_id == 5){
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = "text";
										$choiceModel->save();
									}else{
										$choiceModel = new QChoice;
										$choiceModel->question_id = $questionModel->question_id;
										$choiceModel->option_choice_name = "input";
										$choiceModel->save();
									}

								}
							}
						}
					}
				}
				

			}

			if(Yii::app()->user->id){
				Helpers::lib()->getControllerActionId($header->survey_header_id);
			}
			$this->redirect(array('index', 'id' => $header->survey_header_id));
		}

		$this->render('update',array(
			'header'=>$header
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
        if($id != 35){
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save(false);
        }
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		header('Content-type: application/json');
		if(isset($_POST['chk'])) 
		{
			foreach($_POST['chk'] as $val) 
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionReport($id)
	{
		$header = QHeader::model()->findByPk($id);
		$this->render('report',array(
			'header'=>$header
		));
	}

	public function actionIndex()
	{
		$header = New QHeader('Searchout');
		$this->render('index',array(
			'header'=>$header
		));
		/*if(isset($id))
		{
			Yii::app()->user->setState('getReturn', $id);
			$model = new Question('search');
			$model->unsetAttributes();

			if(isset($_GET['Question']))
				$model->attributes = $_GET['Question'];
				$this->render('index',array(
					'model'=>$model,
					'pk'=>$id,
					'title_group'=>$modelGroup->group_title
				));
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}*/
	}

	public function loadModel($id)
	{
		$model=QHeader::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelGroup($id)
	{
		$model=Grouptesting::model()->findByPk($id);
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
