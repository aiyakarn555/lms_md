<?php
class PreviewController extends Controller {


 public function actionPreview() {

    $CurentID = $this->CurrentID();   //get CurrentID
    $data =  $this->getGroup($CurentID); // getData for Preview

        $sql = 'SELECT MAX(m_titlequestion.Tit_nID) as Tit_nID FROM m_titlequestion '; // Get MaxID m_titlequestion
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $MaxIDReader = $command->query();
        foreach ($MaxIDReader as $row) {
                         $count = $row['Tit_nID'];
                     }          


 $this->render('Preview', array('data'=>$data,'count'=>$count));

    }
 
 public function CurrentID() {
        $modelMax = MGroupquestionnaire::model()->findAllBySql('SELECT Max(m_groupquestionnaire.Gna_nID) as Gna_nID FROM m_groupquestionnaire;');
        $value = CHtml::listData($modelMax, 'Gna_nID', 'Gna_nID', '');
        foreach ($value as $key => $e) {
            $maxID = $key;
        }
        return $maxID;
    }

public function getGroup($pk) { //function getGroup for Preview 
        $sql = 'SELECT
                    m_group.Gna_nID,
                    m_sumquestionnaire.Sna_nID,
                    m_question.Que_nID,
                    m_question.Que_cNameTH,
                    m_question.Tit_nID, 
                    m_typeanswer.Tan_nID, 
                    m_typeanswer.Tan_cNameTH,
                    m_titlequestion.Tit_cNameTH,
                    m_choice.Cho_nID,
                    m_subchoice.Sch_nID                    
                    FROM
                    m_group
                    INNER JOIN m_groupquestionnaire ON m_group.Gna_nID = m_groupquestionnaire.Gna_nID
                    INNER JOIN m_sumquestionnaire ON m_sumquestionnaire.Sna_nID = m_group.Sna_nID
                    INNER JOIN m_question ON m_question.Que_nID = m_sumquestionnaire.Que_nID
                    INNER JOIN m_titlequestion ON m_titlequestion.Tit_nID = m_question.Tit_nID 
                    INNER JOIN m_typeanswer ON m_question.Tan_nID = m_typeanswer.Tan_nID
                    LEFT  JOIN m_choice ON  m_choice.Cho_nID = m_sumquestionnaire.Cho_nID
                    LEFT  JOIN m_subchoice ON m_subchoice.Cho_nID = m_choice.Cho_nID
                    WHERE m_group.Gna_nID = "' . $pk . '" ORDER BY m_question.Tit_nID ;';

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        return $dataReader = $command->query();
    }


public function actionChoice() // Data For Question titlequestion = 1
{
        $id = $_POST['cID'];
                	$sql = 'SELECT
					m_sumquestionnaire.Sna_nID,
					m_sumquestionnaire.Que_nID,
					m_sumquestionnaire.Cho_nID,
					m_question.Que_cNameTH,
					m_choice.Cho_cNameTH,
					m_subchoice.Sch_cNameTH
					FROM
					m_sumquestionnaire
					INNER JOIN m_question  ON m_sumquestionnaire.Que_nID= m_question.Que_nID
					INNER JOIN m_choice ON m_sumquestionnaire.Cho_nID = m_choice.Cho_nID
					LEFT JOIN m_subchoice ON m_choice.Cho_nID = m_subchoice.Cho_nID
					WHERE  m_sumquestionnaire.Que_nID ="'.$id .'";';
		$connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $ChoiceReader = $command->query();
        foreach ($ChoiceReader  as $ch){
        	 echo CHtml::radioButton("chkchoice");
             echo $ch['Cho_cNameTH'];

        }
}

public function actionSubChoice() // Data For Question titlequestion = 2
{

        $id = $_POST['cID'];
        $c= 0;
        $a=0;
        $sql = 'SELECT
					m_sumquestionnaire.Sna_nID,
					m_sumquestionnaire.Que_nID,
					m_sumquestionnaire.Cho_nID,
					m_question.Que_cNameTH,
					m_choice.Cho_cNameTH,
					m_subchoice.Sch_cNameTH
					FROM
					m_sumquestionnaire
					INNER JOIN m_question  ON m_sumquestionnaire.Que_nID= m_question.Que_nID
					INNER JOIN m_choice ON m_sumquestionnaire.Cho_nID = m_choice.Cho_nID
					LEFT JOIN m_subchoice ON m_choice.Cho_nID = m_subchoice.Cho_nID
					WHERE  m_sumquestionnaire.Que_nID ="'.$id .'";';
		$connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $ChoiceReader = $command->query();
        $cho="";
         					foreach ($ChoiceReader as $ch) {// แสดง Choice 
         					if($a<1){ 						
         						$cho=""; 
         						$a++;
         					}					
 											
 	                        if ($ch['Cho_cNameTH']!=$cho) { // Show Choice
 	                        			$cho=$ch['Cho_cNameTH'];  	                        			                     				
                                        echo "<br>";
                                        echo CHtml::checkBox("chkchoice");
                                        echo $ch['Cho_cNameTH'];
                                        $c++;
                                        echo "<br>";
                                    }
                            if ($ch['Sch_cNameTH'] != null) { //Show subchoice

                            			echo "<p style='margin-left:30px; margin-top:10px; '>";
                                        echo CHtml::checkBox("chksubchoice"); 
                                        echo $ch['Sch_cNameTH'];
                                        echo "<br>";
                                        echo "</p>";
                                    } 
                                }

}


 public function actionDelete(){

             	    $id = $_POST['Sna_nID'];
             	    $qid = $_POST['Q_ID'];
            		$criteria = new CDbCriteria();
                    $criteria->condition = 'Sna_nID ='.$id;
                    MGroup::model()->deleteAll($criteria); // delete question

                    $criteria = new CDbCriteria();
                    $criteria->condition = 'Que_nID ='.$qid;
                    MQuestion::model()->updateAll( //Update question cActive = y 
                            array(
                        'cActive' => 'y',
                            ), $criteria
                    );
               
        
    }


 }

   




