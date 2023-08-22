<?php
class cls_Excel
{
	public function getHeader($id){
		$strSQL = "select COUNT(a.Mem_nID) As member,c.Gna_cNameTH,c.Gna_dStart,c.Gna_dEnd FROM t_questionnairedate a";
		$strSQL .= " INNER JOIN t_questionnairequestion b ON a.Yna_nID = b.Yna_nID";
		$strSQL .= " INNER JOIN m_groupquestionnaire c ON a.Gna_nID = c.Gna_nID";
		$strSQL .= " INNER JOIN m_question d ON b.Que_nID = d.Que_nID";
		$strSQL .= " WHERE d.Tan_nID = 3 AND a.Gna_nID = '".$id."'";
		$strSQL .= " GROUP BY b.Que_nID LIMIT 1";

		$connection=Yii::app()->db; 
		$command=$connection->createCommand($strSQL);
		return $command->queryAll();
	}
	public function getGrading($id){
		$strSQL = "select b.Que_cNameTH,TRUNCATE((SUM(c.Gra_nID)*20/COUNT(a.Mem_nID)),4) As avg,e.Tit_cNameTH,e.Tit_nID FROM t_questionnairedate a";
		$strSQL .= " INNER JOIN t_questionnairequestion b ON a.Yna_nID = b.Yna_nID";
		$strSQL .= " INNER JOIN m_question d ON b.Que_nID = d.Que_nID";
		$strSQL .= " INNER JOIN m_titlequestion e ON d.Tit_nID = e.Tit_nID";
		$strSQL .= " LEFT JOIN t_answerquestionnaire c ON b.Qna_nID = c.Qna_nID";
		$strSQL .= " WHERE d.Tan_nID = 3 AND a.Gna_nID = '".$id."'";
		$strSQL .= " GROUP BY b.Que_nID";

		$connection=Yii::app()->db; 
		$command=$connection->createCommand($strSQL);
		return $command->queryAll();
	}
	public function getSingleChoice($id){
		$strSQL = "select TRUNCATE(IFNULL((100 / ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = '".$id."' AND m_question.Tan_nID = 1) * ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = '".$id."' AND m_question.Tan_nID = 1";
		$strSQL .= " AND t_answerquestionnaire.Cho_nID = c.Cho_nID GROUP BY t_answerquestionnaire.Cho_nID)),0),4) As avg";
		$strSQL .= " ,c.Cho_cNameTH,a.Que_cNameTH,d.Tit_nID,d.Tit_cNameTH FROM m_question a";
		$strSQL .= " INNER JOIN m_sumquestionnaire b ON a.Que_nID = b.Que_nID";
		$strSQL .= " INNER JOIN m_choice c ON b.Cho_nID = c.Cho_nID";
		$strSQL .= " INNER JOIN m_titlequestion d ON a.Tit_nID = d.Tit_nID";
		$strSQL .= " INNER JOIN m_group e ON b.Sna_nID = e.Sna_nID";
		$strSQL .= " WHERE a.Tan_nID = 1 AND e.Gna_nID = '".$id."'";
		$strSQL .= " GROUP BY c.Cho_nID,a.Que_nID";
		$connection=Yii::app()->db; 
		$command=$connection->createCommand($strSQL);
		return $command->queryAll();
	}
	public function getMultiChoiceHeader($id){
		$strSQL = "select TRUNCATE(IFNULL((100 / ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = '".$id."' AND m_question.Tan_nID = 2) * ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = '".$id."' AND m_question.Tan_nID = 2";
		$strSQL .= " AND t_answerquestionnaire.Cho_nID = c.Cho_nID GROUP BY t_answerquestionnaire.Cho_nID)),0),4) As avg";
		$strSQL .= " ,c.Cho_cNameTH,a.Que_cNameTH,d.Tit_nID,d.Tit_cNameTH,c.Cho_nID FROM m_question a";
		$strSQL .= " INNER JOIN m_sumquestionnaire b ON a.Que_nID = b.Que_nID";
		$strSQL .= " INNER JOIN m_choice c ON b.Cho_nID = c.Cho_nID";
		$strSQL .= " INNER JOIN m_titlequestion d ON a.Tit_nID = d.Tit_nID";
		$strSQL .= " INNER JOIN m_group e ON b.Sna_nID = e.Sna_nID";
		$strSQL .= " WHERE a.Tan_nID = 2 AND e.Gna_nID = '".$id."'";
		$strSQL .= " GROUP BY c.Cho_nID,a.Que_nID";
		$connection=Yii::app()->db; 
		$command=$connection->createCommand($strSQL);
		return $command->queryAll();
	}
	public function getMultiChoiceDetail($id){
		$strSQL = "select TRUNCATE(IFNULL((100 / ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = 1 AND m_question.Tan_nID = 2 ";
		$strSQL .= " AND t_answerquestionnaire.Sch_nID IS NOT NULL) * ";
		$strSQL .= " (SELECT COUNT(t_answerquestionnaire.Cho_nID) FROM t_questionnairedate";
		$strSQL .= " INNER JOIN t_questionnairequestion ON t_questionnairedate.Yna_nID = t_questionnairequestion.Yna_nID";
		$strSQL .= " INNER JOIN t_answerquestionnaire ON t_questionnairequestion.Qna_nID = t_answerquestionnaire.Qna_nID";
		$strSQL .= " INNER JOIN m_question ON t_questionnairequestion.Que_nID = m_question.Que_nID";
		$strSQL .= " WHERE t_questionnairedate.Gna_nID = 1 AND m_question.Tan_nID = 2 AND t_answerquestionnaire.Sch_nID = f.Sch_nID";
		$strSQL .= " AND t_answerquestionnaire.Sch_nID IS NOT NULL GROUP BY t_answerquestionnaire.Sch_nID)),0),4) As avg";
		$strSQL .= " ,f.Sch_cNameTH,a.Que_cNameTH,d.Tit_nID,d.Tit_cNameTH,c.Cho_nID FROM m_question a";
		$strSQL .= " INNER JOIN m_sumquestionnaire b ON a.Que_nID = b.Que_nID";
		$strSQL .= " INNER JOIN m_choice c ON b.Cho_nID = c.Cho_nID";
		$strSQL .= " INNER JOIN m_subchoice f ON c.Cho_nID = f.Cho_nID";
		$strSQL .= " INNER JOIN m_titlequestion d ON a.Tit_nID = d.Tit_nID";
		$strSQL .= " INNER JOIN m_group e ON b.Sna_nID = e.Sna_nID";
		$strSQL .= " WHERE a.Tan_nID = 2 AND e.Gna_nID = 1";
		$strSQL .= " GROUP BY f.Sch_nID,c.Cho_nID";
		$connection=Yii::app()->db; 
		$command=$connection->createCommand($strSQL);
		return $command->queryAll();
	}
}
?>