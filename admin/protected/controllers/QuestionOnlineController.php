<?php

class QuestionOnlineController extends Controller
{
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','MultiDelete, Export'),
            	'users' => array('*'),
            	),
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
    // public function filters()
    // {
    //     return array(
    //         'rights',
    //     );
    // }

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/*========== CreateChoice ==========*/
	public function actionCreate($id)
	{
		$modelGroup = $this->loadModelGroup($id);
//		$modelQues = new Question;
//		$modelChoice = new Choice;

		if(isset($_POST['Question']))
		{
			foreach($_POST['Question'] as $key => $question) {
				// echo $_POST['Question_type'][$key];
			
				$questionTypeArray = array('checkbox' => 1, 'radio' => 2, 'textarea' => 3, 'dropdown' => 4, 'hidden'=> 6);
				$questionTitle = $question;
				$questionType = $_POST['Question_type'][$key];
				$questionModel = new QuestionOnline();
				$questionModel->group_id = $id;
				$questionModel->ques_type = $questionTypeArray[$questionType];
				$questionModel->ques_title = $questionTitle;
        		$questionModel->ques_explain = $_POST['Explain'][$key];

        		if($questionModel->ques_type == 3){
        			$questionModel->max_score = $_POST['Question_score'][$key]; //Max score
        		}


				if ($questionModel->save()) {
					if(($questionType != 'textarea') && ($questionType != 'dropdown')) {

						$answerValidCheckArray = $_POST['Choice'][$key];
						$choiceTitle = $_POST['ChoiceTitle'][$key];
						if (count($choiceTitle) > 0) {
							foreach ($choiceTitle as $choiceKey => $choice) {
								$choiceModel = new ChoiceOnline();
								$choiceModel->ques_id = $questionModel->ques_id;
								$choiceModel->choice_detail = $choice;
								$choiceModel->choice_type = $questionType;
								if (in_array($choiceKey, $answerValidCheckArray)) {
									$choiceModel->choice_answer = 1;
								} else {
									$choiceModel->choice_answer = 2;
								}
								$choiceModel->save();
							}
						}

					}else if($questionType == 'dropdown'){
						$questid = array();
						$choiceTitle = ($_POST['ChoiceTitle']['quest'][$key])?$_POST['ChoiceTitle']['quest'][$key]:null;

		        		if(isset($_POST['ChoiceTitle']['quest'][$key])){

								// $questid = array();
								// $choiceTitle = $_POST['ChoiceTitle']['quest'][$key];

								foreach ($choiceTitle as $keyQuest=>$valueQuest) {
										$choiceModel = new ChoiceOnline();
										$choiceModel->ques_id = $questionModel->ques_id;
										$choiceModel->choice_detail = $valueQuest;
										$choiceModel->choice_type = $questionType;
										$choiceModel->choice_answer = 1;
										$choiceModel->save();
										$questid[$keyQuest] = $choiceModel->choice_id;

								}
		        		}


		        		if(isset($_POST['ChoiceTitle']['ans'][$key])){

								$choiceTitle2 = $_POST['ChoiceTitle']['ans'][$key];
							

								foreach ($choiceTitle2 as $keyAns=>$valueAns) {
										$choiceModel = new ChoiceOnline();
										$choiceModel->ques_id = $questionModel->ques_id;
										$choiceModel->choice_detail = $valueAns;
										$choiceModel->choice_type = $questionType;
										$choiceModel->choice_answer = 2;
										$choiceModel->reference = ($questid[$keyAns])?$questid[$keyAns]:null;
										$choiceModel->save();
										// echo $keyAns.' -';
										// echo $questid[$keyAns];
								}
		        		}
					}

				}
			}
			// exit();
			$this->redirect(array('index', 'id' => $id));
		}

		$this->render('create',array(
			'modelGroup'=>$modelGroup
		));
	}

    public function actionImport($id)
    {
        $model=new QuestionOnline('import');

        if(isset($_POST['QuestionOnline']))
        {      
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

            $model->attributes=$_POST['QuestionOnline'];
            $model->excel_file = CUploadedFile::getInstance($model,'excel_file');
            //if ($model->excel_file && $model->validate()) {
                // $webroot = YiiBase::getPathOfAlias('webroot');
                $webroot = Yii::app()->basePath."/../..";
                // $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
                $filename = $webroot.'/uploads/' . $model->excel_file->name;
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
				$row = 2;
				if($headingsArray["A"] == null){
					$headingsArray = $objWorksheet->rangeToArray('A2:'.$highestColumn.'2',null, true, true, true);
				$headingsArray = $headingsArray[2];
				$row = 3;
				}

				$r = -1;
				$namedDataArray = array();
				for ($row = $row; $row <= $highestRow; ++$row) {
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
					
					$questionModel = new QuestionOnline();
					$questionModel->group_id = $id;
					// $questionModel->ques_type = 2;

					$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea', 4 => 'dropdown', 6=>'hidden');
					$key = array_search($result["ประเภท"], $questionTypeArray);
					$questionModel->ques_type = $key;

					$questionModel->ques_title = $result["คำถาม"];
					if($questionModel->save()){
						
						$index++;
						for($i=1;$i<=6;$i++) {
							$choiceTitle = trim($result["ตัวเลือกที่ ".$i]);
							if($choiceTitle != "") {
								$choiceModel = new ChoiceOnline();
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
                // $this->redirect(array('import','id'=>$id));
                $this->redirect(array('GrouptestingOnline/index'));
            //}
        }

        $this->render('import',array(
            'model'=>$model,
        ));
    }

	//***** Save Question All *****//
	private function SaveQuesAll($Qtype,$Ctype,$IdGroup)
	{
		$modelQues = new QuestionOnline;
		$modelChoice = new ChoiceOnline;
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
				$SaveQues = new QuestionOnline;
				$SaveQues->group_id = $IdGroup;
				//$SaveQues->ques_type = $QuesType;
				$SaveQues->ques_type = $_POST['QuestionType'][$i];
				$SaveQues->ques_title = CHtml::encode($modelQues->ques_title[$i]);
				$SaveQues->save();
				/***** END SAVE *****/
				$countChoice = $_POST['countBox'][$i];
				for($z=0; $z<(int)$countChoice; $z++)
				{
					$modelChoice = new ChoiceOnline;
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
			    $Question = QuestionOnline::model()->find($criteria);

				$scoreGood[$i] = 0; //Good
				$scoreWrong[$i] = 0; //Wrong
				$scoreChoice[$i] = 0;
				$countChoice = ChoiceOnline::model()->findAll("ques_id=:ques_id", array(
					"ques_id" =>$Question->ques_id,
				));
			 	foreach($countChoice as $z=>$resultChoice)
			 	{
				    if($resultChoice->choice_answer == 1){ $scoreChoice[$i] = $scoreChoice[$i]+1; }
			    	if($_POST['Choice']['choice_answer'][$i][$z] == $resultChoice->choice_answer){
			    		$scoreGood[$i] = $scoreGood[$i]+1;
			    		
			    	}else{
			    		if($_POST['Choice']['choice_answer'][$i][$z] == 1){
				    		$scoreWrong[$i] = $scoreWrong[$i]+1;
					    		
			    		}else{
			    			//echo 'NULL<br>';
			    		}
			    	}
			 	}
			 	$SumScore = ((int)$scoreGood[$i]-(int)$scoreWrong[$i]);
			 	if($scoreChoice[$i] == $SumScore){ $scoreSum = $scoreSum+1; }
				
			}
			echo 'PASS '.$scoreSum;
		}
	}

	public function actionUpdate($id)
	{
		$modelQues = $this->loadModel($id);
//		$modelChoice = Choice::model()->findAll(array('ques_id'=>$modelQues->ques_id));

		if(isset($_POST['Question']))
		{
//			if($modelQues->save())
			foreach($_POST['Question'] as $key => $question) {

				$questionTypeArray = array('checkbox' => 1, 'radio' => 2, 'textarea' => 3, 'dropdown' => 4, 'hidden'=> 6);
				$questionTitle = $question;
				$questionType = $_POST['Question_type'][$key];
				$questionModel = $modelQues;
//				$questionModel->group_id = $id;
				$questionModel->ques_type = $questionTypeArray[$questionType];
				$questionModel->ques_title = $questionTitle;
				
				if($questionModel->ques_type == 3){
        			$questionModel->max_score = $_POST['Question_score'][$key]; //Max score
        		}


				$choiceOldModel = $questionModel->choices;
				$choice_old_ids = array();
				$choiceQ_old_ids = array();
				$choiceA_old_ids = array();

				if(count($choiceOldModel) > 0) {
					foreach ($choiceOldModel as $choiceKey => $choice) {
						$choice_old_ids[] = $choice->choice_id;
						if(($choice->choice_type == 'dropdown') && ($choice->choice_answer == 1)){
							$choiceQ_old_ids[] = $choice->choice_id;
						}
						if(($choice->choice_type == 'dropdown') && ($choice->choice_answer == 2)){
							$choiceA_old_ids[] = $choice->choice_id;
						}
					}
				}



				if ($questionModel->save()) {
					if(($questionType != 'textarea') && ($questionType != 'dropdown')) {
						$answerValidCheckArray = $_POST['Choice'][$key];
						$choiceTitle = $_POST['ChoiceTitle'][$key];
						$choice_new_ids = array();
						foreach ($choiceTitle as $choiceKey => $choice) {
							$choice_new_ids[] = $choiceKey;
						}


						$insert_ids = array_diff($choice_new_ids,$choice_old_ids);
						$update_ids = array_intersect($choice_new_ids,$choice_old_ids);
						$delete_ids = array_diff($choice_old_ids,$choice_new_ids);



						if (count($insert_ids) > 0) {
							foreach ($insert_ids as $choice_id) {
								$choiceModel = new ChoiceOnline();
								$choiceModel->ques_id = $questionModel->ques_id;
								$choiceModel->choice_detail = $choiceTitle[$choice_id];
								$choiceModel->choice_type = $questionType;
								if (in_array($choice_id, $answerValidCheckArray)) {
									$choiceModel->choice_answer = 1;
								} else {
									$choiceModel->choice_answer = 2;
								}
								$choiceModel->save();
							}
						}

						if(count($update_ids) > 0){
							foreach ($update_ids as $choice_id) {

								$choiceModel = ChoiceOnline::model()->findByPk($choice_id);
//								$choiceModel->ques_id = $questionModel->ques_id;
								$choiceModel->choice_detail = $choiceTitle[$choice_id];
//								$choiceModel->choice_type = $questionType;
								if (in_array($choice_id, $answerValidCheckArray)) {
									$choiceModel->choice_answer = 1;
								} else {
									$choiceModel->choice_answer = 2;
								}
								$choiceModel->save();
							}
						}



						if(count($delete_ids) > 0){
							foreach ($delete_ids as $choice_id) {
								if ($choiceModel = ChoiceOnline::model()->findByPk($choice_id)) {
									$choiceModel->delete();
								}
							}
						}

					}else if($questionType == 'dropdown'){
						$questid = array();
						// $choiceTitle = ($_POST['ChoiceTitle']['quest'][$key])?$_POST['ChoiceTitle']['quest'][$key]:null;

						

		        		if(isset($_POST['ChoiceTitle']['quest'][$key])){
							$answerValidCheckArray = $_POST['Choice']['quest'][$key];
		        			$choiceTitle = $_POST['ChoiceTitle']['quest'][$key];
							$choiceQ_new_ids = array();
							foreach ($choiceTitle as $choiceKey => $choice) {
								$choiceQ_new_ids[] = $choiceKey;
							}

							
							$insertQ_ids = array_diff($choiceQ_new_ids,$choiceQ_old_ids);
							$updateQ_ids = array_intersect($choiceQ_new_ids,$choiceQ_old_ids);
							$deleteQ_ids = array_diff($choiceQ_old_ids,$choiceQ_new_ids);

							if (count($insertQ_ids) > 0) {
								foreach ($insertQ_ids as $choice_id) {
									$choiceModel = new ChoiceOnline();
									$choiceModel->ques_id = $questionModel->ques_id;
									$choiceModel->choice_detail = $choiceTitle[$choice_id];
									$choiceModel->choice_type = $questionType;
									$choiceModel->choice_answer = 1;
									$choiceModel->save();
									$questid[$choice_id] = $choiceModel->choice_id;
								}
							}

							if(count($updateQ_ids) > 0){
								foreach ($updateQ_ids as $choice_id) {
									$choiceModel = ChoiceOnline::model()->findByPk($choice_id);
									$choiceModel->choice_detail = $choiceTitle[$choice_id];
									$choiceModel->choice_answer = 1;
									$choiceModel->save();
								}
							}

							if(count($deleteQ_ids) > 0){
								foreach ($deleteQ_ids as $choice_id) {
									if ($choiceModel = ChoiceOnline::model()->findByPk($choice_id)) {
										$choiceModel->delete();
									}
								}
							}
		        		}


		        		if(isset($_POST['ChoiceTitle']['ans'][$key])){
		        			$answerValidCheckArray = $_POST['Choice']['ans'][$key];
		        			$choiceTitle = $_POST['ChoiceTitle']['ans'][$key];
							$choiceA_new_ids = array();
							foreach ($choiceTitle as $choiceKey => $choice) {
								$choiceA_new_ids[] = $choiceKey;
							}

							
							$insertA_ids = array_diff($choiceA_new_ids,$choiceA_old_ids);
							$updateA_ids = array_intersect($choiceA_new_ids,$choiceA_old_ids);
							$deleteA_ids = array_diff($choiceA_old_ids,$choiceA_new_ids);

							if (count($insertA_ids) > 0) {
								foreach ($insertA_ids as $choice_id) {
									$choiceModel = new ChoiceOnline();
									$choiceModel->ques_id = $questionModel->ques_id;
									$choiceModel->choice_detail = $choiceTitle[$choice_id];
									$choiceModel->choice_type = $questionType;
									$choiceModel->choice_answer = 2;
									$choiceModel->reference = ($questid[$choice_id])?$questid[$choice_id]:null;
									$choiceModel->save();
								}
							}

							if(count($updateA_ids) > 0){
								foreach ($updateA_ids as $choice_id) {
									$choiceModel = ChoiceOnline::model()->findByPk($choice_id);
									$choiceModel->choice_detail = $choiceTitle[$choice_id];
									$choiceModel->choice_answer = 2;
									$choiceModel->save();
								}
							}

							if(count($deleteA_ids) > 0){
								foreach ($deleteA_ids as $choice_id) {
									if ($choiceModel = ChoiceOnline::model()->findByPk($choice_id)) {
										$choiceModel->delete();
									}
								}
							}

							
		        		}
					}

				}
			}

			$this->redirect(array('view','id'=>$modelQues->ques_id));
		}
		$this->render('update',array(
			'modelQues'=>$modelQues
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->active = 'n';
	    $model->save(false);

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		// header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
	        foreach($_POST['chk'] as $val)
	        {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex($id)
	{
		$modelGroup = $this->loadModelGroup($id);
		if(isset($id))
		{
			Yii::app()->user->setState('getReturn', $id);
			$model = new QuestionOnline('search');
			$model->unsetAttributes();

			if(isset($_GET['QuestionOnline']))
				$model->attributes = $_GET['QuestionOnline'];
				$this->render('index',array(
					'model'=>$model,
					'pk'=>$id,
					'title_group'=>$modelGroup->group_title
				));
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionExport($id)
	{		
		$grouptesting = GrouptestingOnline::model()->findByPk($id);
		$question = QuestionOnline::model()->findAll([
			'condition'=>'active=:active AND group_id=:group_id',
			'params' => array(':group_id' => $id, ':active'=>'y')
		]);

		// $this->render('export_excel',array(
		// 	'grouptesting'=>$grouptesting,
		// 	'question'=>$question,
		// ));

		$this->renderPartial('export_excel', array(
		'grouptesting'=>$grouptesting, 
		'question'=>$question ));
	}

	public function loadModel($id)
	{
		$model=QuestionOnline::model()->questioncheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelGroup($id)
	{
		$model=GrouptestingOnline::model()->findByPk($id);
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
