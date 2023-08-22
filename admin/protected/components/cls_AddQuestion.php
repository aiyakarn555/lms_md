<?php
	class cls_AddQuestion
	{
		public function getTitleQuestion($language=0){
			$criteria = new CDbCriteria;
			switch ($language) {
				case 0:
					$criteria->select=array('Tit_nID','Tit_cNameTH');
					break;
				case 1:
					$criteria->select=array('Tit_nID','Tit_cNameEN');
					break;
			}
			$criteria->addCondition("cActive = 'y'");
			return MTitlequestion::model()->findAll($criteria);
		}
		public function getTypeQuestion($language=0){
			$criteria = new CDbCriteria;
			switch ($language) {
				case 0:
					$criteria->select=array('Tan_nID','Tan_cNameTH');
					break;
				case 1:
					$criteria->select=array('Tan_nID','Tan_cNameEN');
					break;
			}
			$criteria->addCondition("cActive = 'y'");
			return MTypeanswer::model()->findAll($criteria);
		}

		private function insertQuestion($nameTH,$nameEN,$detailTH,$detailEN,$title,$type,$session){
			$model = new MQuestion();
	        $model->Que_cNameTH = $nameTH;
	        $model->Que_cNameEN = $nameEN;
	        $model->Que_cDetailTH = $detailTH;
	        $model->Que_cDetailEN = $detailEN;
	        $model->cCreateBy = $session;
	        $model->dCreateDate = date('Y-m-d H:i:s');
	        $model->cUpdateBy = $session;
	        $model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'n';
	        $model->Tit_nID = $title;
	        $model->Tan_nID = $type;
	        $model->save();
	        return $model->Que_nID;
		}
		private function insertChoice($nameTH,$nameEN,$stat,$type,$session){
			$model = new MChoice();
	        $model->Cho_cNameTH = $nameTH;
	        $model->Cho_cNameEN = $nameEN;
	        $model->Cho_nScore = 0;
	        $model->stat_txt = $stat;
	        $model->cCreateBy = $session;
	        $model->dCreateDate = date('Y-m-d H:i:s');
	        $model->cUpdateBy = $session;
	        $model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'y';
	        $model->Tan_nID = $type;
	        $model->save();
	        return $model->Cho_nID;
		}
		private function insertSumQuestionnaire($question,$choice,$session){
			$model = new MSumquestionnaire();
	        $model->cCreateBy = $session;
	        $model->dCreateDate = date('Y-m-d H:i:s');
	        $model->cUpdateBy = $session;
	        $model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'y';
	        $model->Que_nID = $question;
	        $model->Cho_nID = $choice;
	        $model->save();
	        return $model->Sna_nID;
		}
		private function insertSubChoice($nameTH,$nameEN,$stat,$choice,$type,$session){
			$model = new MSubchoice();
	        $model->Sch_cNameTH = $nameTH;
	        $model->Sch_cNameEN = $nameEN;
	        $model->Cho_nScore = 0;
	        $model->stat_txt = $stat;
	        $model->cCreateBy = $session;
	        $model->dCreateDate = date('Y-m-d H:i:s');
	        $model->cUpdateBy = $session;
	        $model->dUpdateDate = date('Y-m-d H:i:s');
	        $model->cActive = 'y';
	        $model->Cho_nID = $choice;
	        $model->Tan_nID = $type;
	        $model->save();
	        return $model->save();
		}
		private function UpdateStat($id,$stat,$session){
			$update = MQuestion::model()->findByPk($id);
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
	        $update->cActive = $stat;
			return $update->save();
		}

		private function DeleteQuestion($QuestionId,$session){
			//Update Question
			$update = MQuestion::model()->findByPk($QuestionId);
			$update->cActive = 'n';
	        $update->cUpdateBy = $session;
	        $update->dUpdateDate = date('Y-m-d H:i:s');
			$update->save();
			//Update SumQuestionnaire
			MSumquestionnaire::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"Que_nID = '".$QuestionId."'");

			$criteria = new CDbCriteria;
			$criteria->select=array('Cho_nID');
			$criteria->addCondition("Que_nID = '".$QuestionId."'");
			$modelSumQuestion = MSumquestionnaire::model()->findAll($criteria);

			foreach ($modelSumQuestion as $key => $value) {
				//UpdateChoice
				$update = MChoice::model()->findByPk($value->Cho_nID);
				$update->cActive = 'n';
		        $update->cUpdateBy = $session;
		        $update->dUpdateDate = date('Y-m-d H:i:s');
				$update->save();
				//UpdateSubChoice
				MSubChoice::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"Cho_nID = '".$value->Cho_nID."'");
			}
		}

		private function EditQestion($QuestionId,$date,$session){
			//Update SumQuestionnaire
			MSumquestionnaire::model()->updateAll(array('cActive'=>'d'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>$date)
				,"Que_nID = '".$QuestionId."'");

			$criteria = new CDbCriteria;
			$criteria->select=array('Cho_nID');
			$criteria->addCondition("Que_nID = '".$QuestionId."'");
			$modelSumQuestion = MSumquestionnaire::model()->findAll($criteria);

			foreach ($modelSumQuestion as $key => $value) {
				//UpdateChoice
				$update = MChoice::model()->findByPk($value->Cho_nID);
				$update->cActive = 'd';
		        $update->cUpdateBy = $session;
		        $update->dUpdateDate = $date;
				$update->save();
				//UpdateSubChoice
				MSubChoice::model()->updateAll(array('cActive'=>'d'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>$date)
				,"Cho_nID = '".$value->Cho_nID."'");
			}
		}

		private function AddQuestion($session){
			$alert = "";
			$idQuestion = 0;
			$idChoice = 0;
			$chkChoice = 0;
			$chkSubChoice = 0;
			$type = $_POST['dropdownType'];
			$title = $_POST['dropdownTitle'];
			$isSuc = 0;

			$isSuc = $this->insertQuestion($_POST['txtQuestionTH']
					,$_POST['txtQuestionEN'],$_POST['txtDetailTH']
					,$_POST['txtDetailEN'],$title
					,$type,'i',$session);
			if($isSuc){
				$idQuestion = $isSuc;
			}else{
				return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
			}
			if($type==1||$type==2){
				if(isset($_COOKIE['countAnswer'])){
					for ($i=0; $i < $_COOKIE['countAnswer'] ; $i++) { 
						if(isset($_POST['txtAnswerTH'.$i])){
							if(isset($_POST['chkAnswer'.$i])){
								$chkChoice = 1;
							}
							$isSuc = $this->insertChoice($_POST['txtAnswerTH'.$i]
									,$_POST['txtAnswerTH'.$i],$chkChoice
									,$type,$session);
							if($isSuc){
								$idChoice = $isSuc;
							}else{
								return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
							}
							if($this->insertSumQuestionnaire($idQuestion,$idChoice,$session)){
								if(isset($_POST['txtSubAnswerTH'.$i])){
									for ($a=0; $a < sizeof($_POST['txtSubAnswerTH'.$i]) ; $a++) { 
										if(isset($_POST['chkSubAnswer'.$i][$a])){
											$chkSubChoice = 1;
										}
										$isSuc = $this->insertSubChoice($_POST['txtSubAnswerTH'.$i][$a]
												,$_POST['txtSubAnswerEN'.$i][$a],$chkSubChoice
												,$idChoice,$type,$session);
										if(!$isSuc){
											return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
										}
									}
								}
							}else{
								return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
							}
						}
					}
				}
			}
			if($idQuestion){
				if($this->UpdateStat($idQuestion,'y',$session)){
					return "";
				}else{
					return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
				}
			}else{
				return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
			}
			/*End If*/



		}


		private function EditQuestion2($QuestionId,$date,$session){
			//if flag is true Insert New Data.
			//else Update Data.
			$alert = 0;
			$idChoice = 0;
			$chkChoice = 0;
			$chkSubChoice = 0;
			$type = $_POST['dropdownType'];
			$title = $_POST['dropdownTitle'];
			$isSuc = 0;

			$update = MQuestion::model()->findByPk($QuestionId);
			$update->Que_cNameTH = $_POST['txtQuestionTH'];
		    $update->Que_cNameEN = $_POST['txtQuestionEN'];
		    $update->Que_cDetailTH = $_POST['txtDetailTH'];
		    $update->Que_cDetailEN = $_POST['txtDetailEN'];
		    $update->cUpdateBy = $session;
		    $update->dUpdateDate = $date;
		    $update->Tit_nID = $title;
		    $update->Tan_nID = $type;
		    $update->cActive = 'u';
			$isSuc = $update->save();
			if(!$isSuc){
				return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
			}
			if($type==1||$type==2){
				if(isset($_COOKIE['countAnswer'])){
					for ($i=0; $i < $_COOKIE['countAnswer'] ; $i++) { 
						if(isset($_POST['txtAnswerTH'.$i])){
							$chkChoice = 0;
							if(isset($_POST['chkAnswer'.$i])){
								$chkChoice = 1;
							}
							$isSuc = $this->insertChoice($_POST['txtAnswerTH'.$i]
									,$_POST['txtAnswerTH'.$i],$chkChoice
									,$type,$session);
							if($isSuc){
								$idChoice = $isSuc;
							}else{
								return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
							}
							if($this->insertSumQuestionnaire($QuestionId,$idChoice,$session)){
								if(isset($_POST['txtSubAnswerTH'.$i])){
									for ($a=0; $a < sizeof($_POST['txtSubAnswerTH'.$i]) ; $a++) { 
										$chkSubChoice = 0;
										if(isset($_POST['chkSubAnswer'.$i][$a])){
											$chkSubChoice = 1;
										}
										$isSuc = $this->insertSubChoice($_POST['txtSubAnswerTH'.$i][$a]
												,$_POST['txtSubAnswerEN'.$i][$a],$chkSubChoice
												,$idChoice,$type,$session);
										if(!$isSuc){
											return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
										}
									}
								}
							}else{
								return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
							}
						}
					}
				}
			}
			if($this->UpdateStat($QuestionId,'y',$session)){
				return "";
			}else{
				return "เกิดการผิดพลาดระหว่างบันทึกข้อมูลกรุณาลองใหม่อีกครั้ง";
			}
			/*End If*/



		}

		public function GetQuestion($QuestionId){
			$criteria = new CDbCriteria;
			$criteria->select=array('Que_cNameTH','Que_cNameEN','Que_cDetailTH','Que_cDetailEN','Tit_nID','Tan_nID');
			$criteria->addCondition("Que_nID = '".$QuestionId."'");
			$criteria->addCondition("cActive = 'y'");
			return MQuestion::model()->findAll($criteria);
		}

		public function GetSumQuestion($QuestionId){
			$criteria = new CDbCriteria;
			$criteria->select=array('Cho_nID');
			$criteria->addCondition("Que_nID = '".$QuestionId."'");
			$criteria->addCondition("cActive = 'y'");
			return MSumquestionnaire::model()->findAll($criteria);
		}
		public function GetChoice($Cho_nID){
			$arr = array();
			foreach ($Cho_nID as $key => $value) {
				$criteria1 = new CDbCriteria;
				$criteria1->select=array('Cho_nID','Cho_cNameTH','Cho_cNameEN','stat_txt');
				$criteria1->addCondition("Cho_nID = '".$value->Cho_nID."'");
				$criteria1->addCondition("cActive = 'y'");
				array_push($arr, MChoice::model()->findAll($criteria1));
			}
			return $arr;
		}
		public function GetSubChoice($Cho_nID){
			$arr = array();
			foreach ($Cho_nID as $key => $value) {
				$criteria2 = new CDbCriteria;
				$criteria2->select=array('Cho_nID','Sch_cNameTH','Sch_cNameEN','stat_txt');
				$criteria2->addCondition("Cho_nID = '".$value->Cho_nID."'");
				$criteria2->addCondition("cActive = 'y'");
				array_push($arr, MSubChoice::model()->findAll($criteria2));
			}
			return $arr;
		}

		private function deleteQuestionAll(){
			MQuestion::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"cActive = 'y'");
			MSumquestionnaire::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"cActive = 'y'");
			MChoice::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"cActive = 'y'");
			MSubChoice::model()->updateAll(array('cActive'=>'n'
				,'cUpdateBy'=>$session
				,'dUpdateDate'=>date('Y-m-d H:i:s'))
				,"cActive = 'y'");
		}

		public function DeleteDataAll(){
			$this->deleteQuestionAll();
		}

		public function InsertData($session){
			$this->AddQuestion($session);
		}

		public function EditData($QuestionId,$session){
			$date = date('Y-m-d H:i:s');
			if($_POST['dropdownType']==1||$_POST['dropdownType']==2){
				$this->EditQestion($QuestionId,$date,$session);
			}
			$this->EditQuestion2($QuestionId,$date,$session);
		}

		public function DeleteData($QuestionId,$session){
			$this->DeleteQuestion($QuestionId,$session);
		}
	}
?>