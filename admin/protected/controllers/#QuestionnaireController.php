<?php
	class QuestionnaireController extends Controller{
		
		public function actionIndex(){
			$this->ret('GroupQuestion');
		}

		public function actionAddTextField(){
            //echo CHtml::textField('test','test');
            echo CHtml::openTag('tr',array('id'=>$_POST['count']));
            echo CHtml::tag('td', array(), CHtml::textField('test'.$_POST['count'],'test'));
            echo CHtml::closeTag('tr');

		}
		public function actionTest(){ 
			$i = 1;  
			$abc = "";  
			if(isset($_POST['test'.$i])){
				for($i;;$i++){
					if(!isset($_POST['test'.$i])){
						break;
					}
					$abc = $_POST['test'.$i];
				}
			}
           	$this->render('test',array('count'=>$i,'so_good'=>$abc));
		}
		public function actionSaveChart(){
			$name = $_POST['name'];
			$data = $_POST['data'];

			$data = str_replace('data:image/png;base64,', '', $data);
			$data = str_replace(' ', '+', $data);
			$data = base64_decode($data);
			file_put_contents('Upload/'.$name.'.png', $data);
			echo Yii::app()->getBaseUrl(true).'/Upload/'.$name.'.png';
		}
		public function actionExcel($id=1){
			$this->render('frm_excel',array('groupid'=>$id));
		}

		public function actionSurvey($id=1){
			$cls = new cls_Survey;
			if(isset($_POST['btnSubmit'])&&$id!=null){
				$cls->saveData($id,$this->getSession());
			}
			$model = $cls->getGroup($id);
			if(count($model)){
				$this->render('frm_survey',array('Model'=>$model));
			}
		}

		public function actionAddSubAnswer(){
		    echo CHtml::openTag('div',array('id'=>'divSubAns'.$_POST['countSubAns'],'class'=>'marginSubAns'));
			echo CHtml::openTag('div');
		    echo CHtml::label('คำตอบย่อย','');
			echo CHtml::button('ลบคำตอบย่อย',array('id'=>$_POST['countSubAns'],'onclick'=>'removeSubAnswer(this)'));
		    echo CHtml::closeTag('div');

			echo CHtml::openTag('div');
		    echo CHtml::label('TH คำตอบย่อย','');
		    echo CHtml::textField('txtSubAnswerTH'.$_POST['countAns'].'[]',''
		    	,array('id'=>'txtSubAnswerTH'.$_POST['countSubAns']
		    		,'onkeyup'=>'txtKeyUp(this)'));
		    echo CHtml::label(' * กรุณากรอกข้อมูล',''
		    	,array('id'=>'txtSubAnswerTH'.$_POST['countSubAns'],'','class'=>'IsEmpty red'));
		    echo CHtml::closeTag('div');

			echo CHtml::openTag('div');
		    echo CHtml::label('EN คำตอบย่อย','');
		    echo CHtml::textField('txtSubAnswerEN'.$_POST['countAns'].'[]',''
		    	,array('id'=>'txtSubAnswerEN'.$_POST['countSubAns']
		    		,'onkeyup'=>'txtKeyUp(this)'));
		    echo CHtml::label(' * กรุณากรอกข้อมูล',''
		    	,array('id'=>'txtSubAnswerEN'.$_POST['countSubAns'],'','class'=>'IsEmpty red'));
		    echo CHtml::closeTag('div');

		    echo CHtml::openTag('div');
		    echo CHtml::checkBox('chkSubAnswer'.$_POST['countAns'].'[]');
		    echo CHtml::label('มีช่องให้กรอกเพิ่มเติม','');
		    echo CHtml::closeTag('div');
		    echo CHtml::closeTag('div');

		}

		public function AddAnswer(){
			echo CHtml::openTag('div',array('id'=>'divAns'.$_POST['countAns'],'class'=>'marginAns'));
			echo CHtml::openTag('div');
		    echo CHtml::label('คำตอบ','');
		    echo CHtml::button('ลบคำตอบ'
					    	,array('id'=>$_POST['countAns'],'onclick'=>'removeAnswer(this)'));
		    echo CHtml::closeTag('div');

			echo CHtml::openTag('div');
		    echo CHtml::label('TH คำตอบ','');
		    echo CHtml::textField('txtAnswerTH'.$_POST['countAns'],''
		    	,array('id'=>'txtAnswerTH'.$_POST['countAns'],'onkeyup'=>'txtKeyUp(this)'));
		    echo CHtml::label(' * กรุณากรอกข้อมูล',''
		    	,array('id'=>'txtAnswerTH'.$_POST['countAns'],'','class'=>'IsEmpty red'));
		    echo CHtml::closeTag('div');

			echo CHtml::openTag('div');
		    echo CHtml::label('EN คำตอบ','');
		    echo CHtml::textField('txtAnswerEN'.$_POST['countAns'],''
		    	,array('id'=>'txtAnswerEN'.$_POST['countAns'],'onkeyup'=>'txtKeyUp(this)'));
		    echo CHtml::label(' * กรุณากรอกข้อมูล',''
		    	,array('id'=>'txtAnswerEN'.$_POST['countAns'],'','class'=>'IsEmpty red'));
		    echo CHtml::openTag('div');

		    echo CHtml::checkBox('chkAnswer'.$_POST['countAns']);
		    echo CHtml::label('มีช่องให้กรอกเพิ่มเติม','');
		    echo CHtml::closeTag('div');
		    if($_POST['select']==2){
				echo CHtml::openTag('div',array('id'=>'divSub'.$_POST['countAns']));
		    	echo CHtml::closeTag('div');
				echo CHtml::openTag('div');
				echo CHtml::button('เพิ่มคำตอบย่อย'
		    		,array('id'=>$_POST['countAns'],'onclick'=>'addSubAnswer(this)'));
		    	echo CHtml::closeTag('div');
		    }
		    echo CHtml::closeTag('div');	
		}

		public function actionAddAnswer(){
			switch ($_POST['select']) {
				case 1:
					$this->AddAnswer();
					break;
				case 2:
					$this->AddAnswer();
					break;
				default :
					echo "";
					break;
			}
		}

		public function actionACQuestion(){
			if(isset($_POST['filter'])){
				$cls = new cls_Question;
				$result = $cls->selectAutoComplete($_POST['filter']);
				if($result!=null){
					foreach ($result as $key => $value) { 
						if($value->Que_cNameEN!=null&&strpos($value->Que_cNameEN,$_POST['filter'])!==false){
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Que_cNameEN,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Que_cNameEN)));
						}else{
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Que_cNameTH,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Que_cNameTH)));
						}
					}
				}
			}
		}

		public function actionQuestion($filter=null,$page=1){
			$cls = new cls_Question;
			//$filter = null;
			if(isset($_POST['btnSearch'])){
				$filter = $_POST['txtSearch'];
			}

			$result = $cls->selectData($filter,$page);
			$count = $cls->countData($filter);
			$countFloat = $count/$cls->getSkip();
			$countInt = intval(floor($countFloat));
			if($countFloat>$countInt){
				$countInt ++;
			}
			$this->render('frm_question',array('model'=>$result
				,'filter'=>$filter,'countpage'=>$countInt
				,'startnum'=>$this->getStartNumber($page,$cls->getSkip())
				));
		}
		public function actionManageQuestion($stat=null,$id=null,$language=0){
			$alert = "";
			$cls = new cls_AddQuestion;
			$modelQuestion = null;
			$arrChoice = array();
			$button_text = "ตกลง";
			$type_button = "VIEW";
			$arrModel = null;
			$arrQuestion = null;
			$arrChoice = null;
			$arrSubChoice = null;
			if(isset($_POST['VIEW'])){
				$this->ret('Question');
			}else if(isset($_POST['ADD'])){
				$alert = $cls->InsertData($this->getSession());
				return $this->redirect(array('Questionnaire/Question'));
			}else if(isset($_POST['EDIT'])){
				if(!empty($id)){
					$alert = $cls->EditData($id,$this->getSession());
					return $this->redirect(array('Questionnaire/Question'));
				}
			}else{
				if($stat!=null){
					if($id!=null){
						$modelQuestion = $this->getModelQuestion($id);
						if($modelQuestion!=null){
							$arrModel = $cls->GetSumQuestion($id);
							$arrQuestion = $cls->GetQuestion($id);
							$arrChoice = $cls->GetChoice($arrModel);
							$arrSubChoice = $cls->GetSubChoice($arrModel);
						}
					}
					switch ($stat) {
						case 'VIEW':
							$type_button = "VIEW";
							$button_text = "ตกลง";
							break;
						case 'ADD':
							$type_button = "ADD";
							$button_text = "เพิ่มข้อมูล";
							break;
						case 'EDIT':
							$type_button = "EDIT";
							$button_text = "แก้ไขข้อมูล";
							break;
						case 'DELALL':
							$cls->deleteAll($this->getSession());
							$this->ret('TypeAnswer');
							break;
					}
				}
			}

			$dropdownTitle = array();
			$dropdownType = array();
			foreach ($cls->getTitleQuestion($language) as $key => $value) {
				switch ($language) {
					case 0:
						$dropdownTitle[$value->Tit_nID] = $value->Tit_cNameTH;
						break;
					case 1:
						$dropdownTitle[$value->Tit_nID] = $value->Tit_cNameEN;
						break;
				}
			}
			foreach ($cls->getTypeQuestion($language) as $key => $value) {
				switch ($language) {
					case 0:
						$dropdownType[$value->Tan_nID] = $value->Tan_cNameTH;
						break;
					case 1:
						$dropdownType[$value->Tan_nID] = $value->Tan_cNameEN;
						break;
				}
			}
			return $this->render('manage_question',array('dropdownTitle'=>$dropdownTitle
				,'dropdownType'=>$dropdownType,'type_button'=>$type_button
				,'button_text'=>$button_text,'arrQuestion'=>$arrQuestion
				,'arrChoice'=>$arrChoice,'arrSubChoice'=>$arrSubChoice));
		}

		public function actionACGroupQuestionnaire(){
			if(isset($_POST['filter'])){
				$cls = new cls_GroupQuestionnaire;
				$result = $cls->selectAutoComplete($_POST['filter']);
				if($result!=null){
					foreach ($result as $key => $value) { 
						if($value->Gna_cNameEN!=null&&strpos($value->Gna_cNameEN,$_POST['filter'])!==false){
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Gna_cNameEN,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Gna_cNameEN)));
						}else{
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Gna_cNameTH,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Gna_cNameTH)));
						}
					}
				}
			}
		}
		public function actionGroupQuestionnaire($filter=null,$page=1){
			$cls = new cls_GroupQuestionnaire;
			//$filter = null;
			if(isset($_POST['btnSearch'])){
				$filter = $_POST['txtSearch'];
			}

			$result = $cls->selectData($filter,$page);
			$count = $cls->countData($filter);
			$countFloat = $count/$cls->getSkip();
			$countInt = intval(floor($countFloat));
			if($countFloat>$countInt){
				$countInt ++;
			}
			$this->render('frm_group_questionnaire',array('model'=>$result
				,'filter'=>$filter,'countpage'=>$countInt
				,'startnum'=>$this->getStartNumber($page,$cls->getSkip())));
		}
		public function actionACTypeAnswer(){
			if(isset($_POST['filter'])){
				$cls = new cls_TypeAnswer;
				$result = $cls->selectAutoComplete($_POST['filter']);
				if($result!=null){
					foreach ($result as $key => $value) { 
						if($value->Tan_cNameEN!=null&&strpos($value->Tan_cNameEN,$_POST['filter'])!==false){
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Tan_cNameEN,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Tan_cNameEN)));
						}else{
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Tan_cNameTH,
								$this->createAbsoluteUrl("Questionnaire/TypeAnswer&filter=".$value->Tan_cNameTH)));
						}
					}
				}
			}
		}
		public function actionTypeAnswer($filter=null,$page=1){
			$cls = new cls_TypeAnswer;
			//$filter = null;
			if(isset($_POST['btnSearch'])){
				$filter = $_POST['txtSearch'];
			}

			$result = $cls->selectData($filter,$page);
			$count = $cls->countData($filter);
			$countFloat = $count/$cls->getSkip();
			$countInt = intval(floor($countFloat));
			if($countFloat>$countInt){
				$countInt ++;
			}
			$this->render('frm_type_answer',array('model'=>$result
				,'filter'=>$filter,'countpage'=>$countInt
				,'startnum'=>$this->getStartNumber($page,$cls->getSkip())));
		}

	    public function actionManageTypeAnswer($stat=null,$id=null){
			//if(empty($stat)||empty($id)){
			//	$this->ret();
			//}
			$cls = new cls_TypeAnswer;
			$TypeTH = "";
			$TypeEN = "";
			$DescriptionTH = "";
			$DescriptionEN = "";
			$RulesTH = "";
			$RulesEN = "";
			$type_button = "";
			$button_text = "";
			if(isset($_POST['VIEW'])){
				$this->ret('TypeAnswer');
			}else if(isset($_POST['ADD'])){
				if ($cls->insertData($_POST['nameTH'], $_POST['nameEN']
	            	, $_POST['detailTH'], $_POST['detailEN'], $_POST['ruleTH'], $_POST['ruleEN'],$this->getSession())) {
	                $this->ret('TypeAnswer');
	            }
			}else if(isset($_POST['EDIT'])){
				if(!empty($id)){
					if($cls->updateData($id,$_POST['nameTH'], $_POST['nameEN']
	            	, $_POST['detailTH'], $_POST['detailEN'], $_POST['ruleTH'], $_POST['ruleEN'],$this->getSession())) {
						$this->ret('TypeAnswer');
	            	}
				}
			}else if(isset($_POST['DEL'])){
				if(!empty($id)){
					$cls->deleteData($id,$this->getSession());
				}
				$this->ret('TypeAnswer');
			}else{
				if($stat!=null){
					$model = $this->getModelTypeAnswer($id);
					if(!empty($model)){
						$TypeTH = $model[0]->Tan_cNameTH;
						$TypeEN = $model[0]->Tan_cNameEN;
						$DescriptionTH = $model[0]->Tan_cDescriptionTH;
						$DescriptionEN = $model[0]->Tan_cDescriptionEN;
						$RulesTH = $model[0]->Tan_cRulesTH;
						$RulesEN = $model[0]->Tan_cRulesEN;
					}
					switch ($stat) {
						case 'VIEW':
							$type_button = "VIEW";
							$button_text = "ตกลง";
							break;
						case 'ADD':
							$type_button = "ADD";
							$button_text = "เพิ่มข้อมูล";
							break;
						case 'EDIT':
							$type_button = "EDIT";
							$button_text = "แก้ไขข้อมูล";
							break;
						case 'DEL':
							$type_button = "DEL";
							$button_text = "ลบข้อมูล";
							break;
						case 'DELALL':
							$cls->deleteAll($this->getSession());
							$this->ret('TypeAnswer');
							break;
					}
				}
			}
			return $this->render('manage_type_answer',array(
					'TypeTH'=>$TypeTH,
					'TypeEN'=>$TypeEN,
					'DescriptionTH'=>$DescriptionTH,
					'DescriptionEN'=>$DescriptionEN,
					'RulesTH'=>$RulesTH,
					'RulesEN'=>$RulesEN,
					'type_button'=>$type_button,
					'button_text'=>$button_text
				));
		}
		public function actionACTitleQuestion(){
			if(isset($_POST['filter'])){
				$cls = new cls_TitleQuestion;
				$result = $cls->selectAutoComplete($_POST['filter']);
				if($result!=null){
					foreach ($result as $key => $value) {
						if(strpos($value->Tit_cNameEN,$_POST['filter'])!==false){
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Tit_cNameEN,
								$this->createAbsoluteUrl("Questionnaire/TitleQuestion&filter=".$value->Tit_cNameEN)));
						}else{
							echo CHtml::tag('li', array(), 
								CHtml::link($value->Tit_cNameTH,
								$this->createAbsoluteUrl("Questionnaire/TitleQuestion&filter=".$value->Tit_cNameTH)));
						}
					}
				}
			}
		}
		public function actionTitleQuestion($filter=null,$page=1){
			$cls = new cls_TitleQuestion;
			//$filter = null;
			if(isset($_POST['btnSearch'])){
				$filter = $_POST['txtSearch'];
			}

			$result = $cls->selectData($filter,$page);
			$count = $cls->countData($filter);
			$countFloat = $count/$cls->getSkip();
			$countInt = intval(floor($countFloat));
			if($countFloat>$countInt){
				$countInt ++;
			}
			$this->render('frm_title_question',array('model'=>$result
				,'filter'=>$filter,'countpage'=>$countInt
				,'startnum'=>$this->getStartNumber($page,$cls->getSkip())));
		}

		public function actionManageTitleQuestion($stat=null,$id=null){
			//if(empty($stat)||empty($id)){
			//	$this->ret();
			//}
			$cls = new cls_TitleQuestion;
			$titleTH = "";
			$titleEN = "";
			$DescriptionTH = "";
			$DescriptionEN = "";
			$type_button = "";
			$button_text = "";
			if(isset($_POST['VIEW'])){
				$this->ret('TitleQuestion');
			}else if(isset($_POST['ADD'])){
				if($cls->insertData($_POST['titleQuestionTH'],$_POST['titleQuestionEN']
					,$_POST['titleDescriptionTH'],$_POST['titleDescriptionEN'],$this->getSession())){
	            	$this->ret('TitleQuestion');
				}
			}else if(isset($_POST['EDIT'])){
				if(!empty($id)){
					if($cls->updateData($id,$_POST['titleQuestionTH'],$_POST['titleQuestionEN']
						,$_POST['titleDescriptionTH'],$_POST['titleDescriptionEN'],$this->getSession())){
							$this->ret('TitleQuestion');
					}
				}
			}else if(isset($_POST['DEL'])){
				if(!empty($id)){
					if($cls->deleteData($id,$this->getSession())){
						$this->ret('TitleQuestion');
					}
				}
			}else{
				if($stat!=null){
					$model = $this->getModelTitleQuestion($id);
					if(!empty($model)){
						$titleTH = $model[0]->Tit_cNameTH;
						$titleEN = $model[0]->Tit_cNameEN;
						$DescriptionTH = $model[0]->Tit_cDetailTH;
						$DescriptionEN = $model[0]->Tit_cDetailEN;
					}
					switch ($stat) {
						case 'VIEW':
							$type_button = "VIEW";
							$button_text = "ตกลง";
							break;
						case 'ADD':
							$type_button = "ADD";
							$button_text = "เพิ่มข้อมูล";
							break;
						case 'EDIT':
							$type_button = "EDIT";
							$button_text = "แก้ไขข้อมูล";
							break;
						case 'DEL':
							$type_button = "DEL";
							$button_text = "ลบข้อมูล";
							break;
						case 'DELALL':
							$cls->deleteAll($this->getSession());
							$this->ret('TitleQuestion');
							break;
					}
				}
			}
			return $this->render('manage_title_question',array(
					'titleTH'=>$titleTH,
					'titleEN'=>$titleEN,
					'DescriptionTH'=>$DescriptionTH,
					'DescriptionEN'=>$DescriptionEN,
					'type_button'=>$type_button,
					'button_text'=>$button_text
				));
		}
		private function ret($action){
			$this->redirect(array('Questionnaire/'.$action));
		}
		private function getModelTypeAnswer($id){
			return MTypeanswer::model()->findAllByPk($id);
		}
		private function getModelTitleQuestion($id){
			//return MTitlequestion::model()->findAllByAttributes(array('Tit_nID'=>$id));
			return MTitlequestion::model()->findAllByPk($id);
		}
		private function getModelQuestion($id){
			return MQuestion::model()->findAllByPk($id);
		}
		private function getStartNumber($page,$limit){
			$count = 0;
			if($page!=1){
				if($limit==1){
					$count = $page - 1;
				}else{
					$count = ($limit * $page) - $limit;
				}
			}
			return $count;
		}
		private function getSession(){
			return 'admin';
		}
	}
?>