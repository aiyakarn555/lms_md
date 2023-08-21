<?php
class cls_Survey
{
	public function getGroup($id){
		$sqlSQL = "select a.Gna_cNameTH,z.Sna_nID
		,c.Que_nID,c.Que_cNameTH,f.Cho_nID,f.Cho_cNameTH
		,f.stat_txt as stat_choice,g.Sch_nID,g.Sch_cNameTH,g.stat_txt as stat_subchoice
		,d.Tan_nID,e.Tit_nID,e.Tit_cNameTH FROM m_group z

		INNER JOIN m_groupquestionnaire a on a.Gna_nID = z.Gna_nID
		INNER JOIN m_sumquestionnaire b on z.Sna_nID = b.Sna_nID
		INNER JOIN m_question c on b.Que_nID = c.Que_nID
		INNER JOIN m_typeanswer d on c.Tan_nID = d.Tan_nID
		INNER JOIN m_titlequestion e on c.Tit_nID = e.Tit_nID
		LEFT JOIN m_choice f on b.Cho_nID = f.Cho_nID
		LEFT JOIN m_subchoice g on f.Cho_nID = g.Cho_nID
		WHERE z.cActive = 'y' and z.Gna_nID = '".$id."' AND a.Gna_dEnd >=CURRENT_DATE ORDER BY z.Gro_nID";

		$connection=Yii::app()->db; 
		$command=$connection->createCommand($sqlSQL);
		return $command->queryAll();
	}
	public function saveData($id,$session){
		$model = $this->getGroup($id);
		$date = date('Y-m-d H:i:s');
		$Yna_nID = $this->insertQuestionnaireDate($id,$date,$session);
		$Qna_nID = null;
		for ($i=0; $i < count($model); $i++) { 
			if($i==0){
				$Qna_nID = $this->insertQuestion($model[$i],$Yna_nID,$date,$session);
			}else if($model[$i]['Que_nID']!=$model[$i-1]['Que_nID']){
				$Qna_nID = $this->insertQuestion($model[$i],$Yna_nID,$date,$session);
			}
			switch ($model[$i]['Tan_nID']) {
				case 1:
					$this->insertSingleChoice($model[$i],$Qna_nID,$date,$session);
					break;
				case 2:
					if ($i==0) {
						$this->insertMultiChoice($model[$i],$Qna_nID,$date,$session);
					}else {
						//if($model[$i-1]['Cho_nID']==$model[$i]['Cho_nID']){
						if(isset($_POST['chk'.$model[$i]['Cho_nID']])||isset($_POST['chkSub'.$model[$i]['Sch_nID']])){
							$this->insertMultiChoice($model[$i],$Qna_nID,$date,$session);
						}
							//if(isset($_POST['chkSub'.$model[$i]['Sch_nID']])){
							//	$this->insertMultiChoice($model[$i],$Qna_nID,$date,$session);
							//}
						//}else{
						//	$this->insertMultiChoice($model[$i],$Qna_nID,$date,$session);
						//}
					}
					break;
				case 3:
					$this->insertGrading($model[$i],$Qna_nID,$date,$session);
					break;
				case 4:
					$this->insertDescribe($model[$i],$Qna_nID,$date,$session);
					break;
				case 5:
					$this->insertDescribe($model[$i],$Qna_nID,$date,$session);
					break;
			}
		}
		$this->UpdateStat($Yna_nID,'y',$date,$session);
	}
	private function insertSingleChoice($arr,$Qna_nID,$date,$session){
		if(!isset($_POST['rdoChoice'.$arr['Que_nID']]))
			return;
		if(isset($_POST['rdoChoice'.$arr['Que_nID']])){
			if($_POST['rdoChoice'.$arr['Que_nID']]==$arr['Cho_nID']){
				$model = new TAnswerquestionnaire;
				$model->Cho_cNameTH = $arr['Cho_cNameTH'];
				$model->cCreateBy = $session;
			    $model->dCreateDate = $date;
			    $model->cUpdateBy = $session;
			    $model->dUpdateDate = $date;
			    $model->cActive = 'y';
			    $model->Qna_nID = $Qna_nID;
			    $model->Cho_nID = $_POST['rdoChoice'.$arr['Que_nID']];
			    return $model->save();
			}
		}
	}
	private function insertMultiChoice($arr,$Qna_nID,$date,$session){
		if($arr['Sch_nID']==null){
			if(isset($_POST['chk'.$arr['Cho_nID']])){
				$model = new TAnswerquestionnaire;
				$model->Cho_cNameTH = $arr['Cho_cNameTH'];
				if($arr['stat_choice'])
					$model->Ans_Description = $_POST['txtChoice'.$arr['Cho_nID']];
				$model->cCreateBy = $session;
			    $model->dCreateDate = $date;
			    $model->cUpdateBy = $session;
			    $model->dUpdateDate = $date;
			    $model->cActive = 'y';
			    $model->Cho_nID = $arr['Cho_nID'];
			    $model->Qna_nID = $Qna_nID;
			    return $model->save();
			}
		}else{
		    if(isset($_POST['chkSub'.$arr['Sch_nID']])){
				$model = new TAnswerquestionnaire;
				$model->Cho_cNameTH = $arr['Cho_cNameTH'];
				if($arr['stat_choice']&&$arr['Sch_nID']==null)
					$model->Ans_Description = $_POST['txtChoice'.$arr['Cho_nID']];
				$model->cCreateBy = $session;
			    $model->dCreateDate = $date;
			    $model->cUpdateBy = $session;
			    $model->dUpdateDate = $date;
			    $model->cActive = 'y';
			    $model->Cho_nID = $arr['Cho_nID'];

			    $model->Sch_cNameTH = $arr['Sch_cNameTH'];
			    if($arr['stat_subchoice'])
					$model->Ans_Description = $_POST['txtSubChoice'.$arr['Sch_nID']];
				$model->Sch_nID = $arr['Sch_nID'];

			    $model->Qna_nID = $Qna_nID;
			    return $model->save();
			}
		}
	}
	private function insertDescribe($arr,$Qna_nID,$date,$session){
		$model = new TAnswerquestionnaire;
		$model->Ans_Description = $_POST['txt'.$arr['Que_nID']];
		$model->cCreateBy = $session;
	    $model->dCreateDate = $date;
	    $model->cUpdateBy = $session;
	    $model->dUpdateDate = $date;
	    $model->cActive = 'y';
	    $model->Qna_nID = $Qna_nID;
	    return $model->save();
	}
	private function insertGrading($arr,$Qna_nID,$date,$session){
		if(!isset($_POST['rdo'.$arr['Que_nID']]))
			return;
		$model = new TAnswerquestionnaire;
		$model->Ans_cComment = $_POST['txtrdo'.$arr['Que_nID']];
		$model->cCreateBy = $session;
	    $model->dCreateDate = $date;
	    $model->cUpdateBy = $session;
	    $model->dUpdateDate = $date;
	    $model->cActive = 'y';
	    $model->Gra_nID = $_POST['rdo'.$arr['Que_nID']];
	    $model->Qna_nID = $Qna_nID;
	    return $model->save();
	}
	private function insertQuestion($arr,$Yna_nID,$date,$session){
		$model = new TQuestionnairequestion;
		$model->Que_cNameTH = $arr['Que_cNameTH'];
		$model->cCreateBy = $session;
	    $model->dCreateDate = $date;
	    $model->cUpdateBy = $session;
	    $model->dUpdateDate = $date;
	    $model->cActive = 'y';
	    $model->Que_nID = $arr['Que_nID'];
	    $model->Yna_nID = $Yna_nID;
	    $model->save();
	    return $model->Qna_nID;
	}
	private function insertQuestionnaireDate($id,$date,$session){
		$model = new TQuestionnairedate;
		$model->Yna_dDate = $date;
		$model->cCreateBy = $session;
	    $model->dCreateDate = $date;
	    $model->cUpdateBy = $session;
	    $model->dUpdateDate = $date;
	    $model->cActive = 'i';
	    $model->Gna_nID = $id;
	    $model->Mem_nID = 1;
	    $model->save();
	    return $model->Yna_nID;
	}
	private function UpdateStat($id,$stat,$date,$session){
		$update = TQuestionnairedate::model()->findByPk($id);
		$update->cUpdateBy = $session;
		$update->dUpdateDate = $date;
		$update->cActive = $stat;
		return $update->save();
	}
}
?>