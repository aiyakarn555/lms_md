<?php

class AddGroupController extends Controller {



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
                echo '<br>';
                echo CHtml::checkBox("chkquestion" . $n, FALSE, array('value' => $v));
                echo CHtml::textField('Qustion', $v);
                echo '<br>';
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


}
