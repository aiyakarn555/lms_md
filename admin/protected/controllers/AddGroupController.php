<?php

class AddGroupController extends Controller {
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


    public function actionAddGroup() {

                $this->pageTitle = Yii::app()->name;
                $model = MTitlequestion::model()->findAll(); // ดึงข้อมูล ทั้งหมด   

        foreach ($model as $key => $value) {
            $dropdownitem[$value->Tit_cNameTH] = $value->Tit_cNameTH;
        }
        if (isset($_POST['nameTH'])) {
            if ($_POST['nameTH'] != null && $_POST['nameEN'] != null) {
                echo '<script>alert("บันทึกข้อมูลเรียบร้อย");</script>';
            } else {
                echo '<script>alert("กรุณากรอกข้อมูลให้ครบถ้วน");</script>';
            }
        }

                $sql = 'SELECT MAX(m_question.Que_nID) as MaxID FROM m_question ;'; // get MaxiD m_question
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $MaxIDReader = $command->query();
        foreach ($MaxIDReader as $row) {
                $count = $row['MaxID'];
        }             
        
        $this->OnQuestion();// cAtive = y all question        
        $this->render('AddGroup', array('dropdownitem' => $dropdownitem, 'count' => $count));
    }

    public function ActionListquestion() { // getAllquestion for show 
        if (isset($_POST['val'])) {

                $valTitle = $_POST['val'];

                $model1 = MQuestion::model()->findAllBySql('SELECT
                        m_sumquestionnaire.Sna_nID,
                        m_sumquestionnaire.Que_nID,
                        m_question.Que_cNameTH,
                        m_titlequestion.Tit_cNameTH
                        FROM
                        m_sumquestionnaire 
                        INNER JOIN 
                        m_question ON m_sumquestionnaire.Que_nID= m_question.Que_nID
                        INNER JOIN 
                        m_titlequestion  ON m_question.Tit_nID = m_titlequestion.Tit_nID
                        WHERE m_titlequestion.Tit_cNameTH="' . $valTitle . '" and m_question.cActive="y" ;');

            $value = CHtml::listData($model1, 'Que_nID', 'Que_cNameTH', '');

            foreach ($value as $n => $v) {
                echo "<div>";
                echo '<br>';                
                echo CHtml::checkBox("chkquestion" . $n, FALSE, array('value' => $v,));
                echo '&nbsp;';
                echo CHtml::textField('Qustion', $v,array('style'=>'width:300px;'));
                echo '<br>';
                echo "</div>";
            }
        }
    }

   
    public function ActionInsertQuestion() { // insertquestion to MgroupTable
                $chk = $_POST['chkquestion'];    
                $this->insertM_Group($chk);        
                $this->offQuestion($chk);
    }

    public function actionInsertCGroup() { // insert data to m_questionnaire
                $nameTH = $_POST['nTH'];
                $nameEN = $_POST["nEN"];
                $sDate  = $_POST["Sd"];
                $eDate  = $_POST["Ed"];
                $modelMax = MGroupquestionnaire::model()->findAllBySql('SELECT Max(m_groupquestionnaire.Gna_nID+1) as Gna_nID FROM m_groupquestionnaire;');
                $value = CHtml::listData($modelMax, 'Gna_nID', 'Gna_nID', '');
                foreach ($value as $key => $e) {
                    $maxkeyInsert = $e;
                }
                
                $model = new MGroupquestionnaire(); //บันทึลงตาราง MGroupquestionnaire
                $model->Gna_nID = (int) $maxkeyInsert;
                $model->Gna_cNameTH = $nameTH;
                $model->Gna_cNameEN = $nameEN;
                $model->Gna_dStart = $sDate;
                $model->Gna_dEnd = $eDate;
                $model->cCreateBy = 'Admin';
                $model->dCreateDate = date('Y-m-d H:i:s');
                $model->cUpdateBy = 'admin';
                $model->dUpdateDate = date('Y-m-d H:i:s');
                $model->cActive = 'y';
                return $model->save();
    }
   

    public function insertM_Group($chk) {      // insertquestion to MgroupTable  
                $modelMax = MGroupquestionnaire::model()->findAllBySql('SELECT Max(m_groupquestionnaire.Gna_nID) as Gna_nID FROM m_groupquestionnaire;');
                $value = CHtml::listData($modelMax, 'Gna_nID', 'Gna_nID', '');
        foreach ($value as $key => $e) {
                $maxID = $key;
        }
                $this->CurrentID($maxID);
                $modelSum = MSumquestionnaire::model()->findAllbySql('SELECT m_sumquestionnaire.Sna_nID, m_sumquestionnaire.Que_nID, m_question.Que_cNameTH
                FROM m_sumquestionnaire INNER JOIN m_question ON m_sumquestionnaire.Que_nID = m_question.Que_nID
                WHERE Que_cNameTH="' . $chk . '" GROUP BY Que_nID');
                $valueSum = CHtml::listData($modelSum, 'Sna_nID', 'Sna_nID', '');
        foreach ($valueSum as $n => $v) {
                $Sna_id = $n;
        }

                $model = new Mgroup();
                $model->cCreateBy = 'admin';
                $model->dCreateDate = date('Y-m-d H:i:s');
                $model->cUpdateBy = 'admin';
                $model->cUpdateDate = date('Y-m-d H:i:s');
                $model->cActive = 'y';
                $model->Gna_nID = $maxID;
                $model->Sna_nID = $Sna_id;       
                return $model->save();

    }

    public function offQuestion($chk) { // off question  cAtive= 'n'
                $criteria = new CDbCriteria();
                $criteria->condition = 'Que_cNameTH = "' . $chk . '"';
                MQuestion::model()->updateAll(
                        array(
                    'cActive' => 'n',
                        ), $criteria
                );
    }

    public function OnQuestion() { // On Question cAtive= 'y'
                $criteria = new CDbCriteria();
                $criteria->condition = 'cActive = "n"';
                MQuestion::model()->updateAll(
                        array(
                    'cActive' => 'y',
                        ), $criteria
                );
    }

   
 public function CurrentID() { // get CurrentID
                $modelMax = MGroupquestionnaire::model()->findAllBySql('SELECT Max(m_groupquestionnaire.Gna_nID) as Gna_nID FROM m_groupquestionnaire;');
                $value = CHtml::listData($modelMax, 'Gna_nID', 'Gna_nID', '');
        foreach ($value as $key => $e) {
                $maxID = $key;
        }
        return $maxID;
    }


    //-----------------------------------------------------PreviewPage----------------------------------------------------------
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
        echo"<div stlye='margin-left:50px;'>";
        foreach ($ChoiceReader  as $ch){             
             echo CHtml::radioButton("chkchoice","");
             echo "&nbsp;";
             echo $ch['Cho_cNameTH'];
             echo "&nbsp;";


        }
        echo"</div>";
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
