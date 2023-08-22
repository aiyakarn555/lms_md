<?php

class ResetController extends Controller
{
   public function filters()
   {
    return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('reset_user', 'view', 'get_dialog_learn', 'get_dialog_exam', 'resetdetail'),
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
    /*public function actionIndex()
    {
      $this->render('index');
  }*/
    //// USER ////
  public function actionShowResetCourse()
  {
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                'select'=>'lesson_id, id, user_id',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id 
                inner join tbl_course_online on tbl_course_online.course_id = tbl_lesson.course_id',
                'group'=>'tbl_course_online.course_id',
                'order'=>'tbl_course_online.course_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_course', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetLearnCourse()
{
    if (($_POST['stdID'] != '') && ($_POST['courseID'] != '')) {
        $stdID = $_POST['stdID'];
        $courseID = $_POST['courseID'];
        $lesson = Lesson::model()->findAll('course_id=' . $courseID . ' AND active="y"');
        foreach ($lesson as $lessonItems) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lessonItems->id);
            $criteria->addCondition('user_id=' . $stdID);
            $learnDel = Learn::model()->find($criteria);
            if($learnDel){
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $learnDel->learn_id);
                $criteria2->addCondition('user_id_file=' . $stdID);
                $learnFileDel = LearnFile::model()->findAll($criteria2);
                foreach ($learnFileDel as $key => $value) {
                    $value->delete();
                }
                $learnDel->delete();
            }
        }
    }
}

// public function actionShow(){
//     $to = array(
//                  'email'=>'taaonprem04@airasia.com',
//                  'firstname'=>'pornchai',
//                  'lastname'=>'tippawan'
//              );
//     $message = "test";
//     $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ',$message);
//     var_dump($mail);exit();
// }

public function actionShowResetLesson()
{
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                'select'=>'lesson_id, id, user_id',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id',
                'group'=>'Learn.lesson_id',
                'order'=>'Learn.lesson_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_lesson', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetLearnLesson()
{
    if (($_POST['stdID'] != '') && ($_POST['lessonID'] != '')) {
        $stdID = $_POST['stdID'];
        $lessonID = $_POST['lessonID'];
        $lesson = Lesson::model()->find('id=' . $lessonID . ' AND active="y"');
        if($lesson){
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lesson->id);
            $criteria->addCondition('user_id=' . $stdID);
            $learnDel = Learn::model()->find($criteria);
            if($learnDel){
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $learnDel->learn_id);
                $criteria2->addCondition('user_id_file=' . $stdID);
                $learnFileDel = LearnFile::model()->findAll($criteria2);
                foreach ($learnFileDel as $key => $value) {
                    $value->delete();
                }
                $learnDel->delete();
            }
        }
    }
}

public function actionShowResetExam()
{
    if (isset($_GET['userID'])) {
        $userID = $_GET['userID'];
        $user = MMember::model()->findByPk($userID);

        $dataProvider=new CActiveDataProvider('Score', array(
            'criteria'=>array(
                'condition'=>'user_id = "'.$userID.'"',
                    // 'select'=>'lesson_id, score_id, user_id, type',
                'alias'=>'Score',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Score.lesson_id',
                    // 'group'=>'Score.lesson_id',
                'order'=>'Score.lesson_id ASC,Score.type DESC'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_exam', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_user'));
    }
}

public function actionResetScoreLesson()
{
    if (($_POST['stdID'] != '') && ($_POST['scoreID'] != '')) {
        $stdID = $_POST['stdID'];
        $scoreID = $_POST['scoreID'];
        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id=' . $stdID);
        $criteria->addCondition('score_id=' . $scoreID);
        $score = Score::model()->find($criteria);
        if($score){
                // print_r($score);exit();
            $criteria = new CDbCriteria;
            $criteria->addCondition('user_id=' . $stdID);
            $criteria->addCondition('score_id=' . $scoreID);
            $modelLogChoice = Logchoice::model()->deleteAll($criteria);
            $modelLogQues = Logques::model()->deleteAll($criteria);
            $score->delete();
        }
    }
}

public function actionMultiDelete_exam_lesson()
{
    header('Content-type: application/json');
    if(isset($_POST['chk']))
    {
        foreach($_POST['chk'] as $val)
        {
            $this->actionDelete_lesson_score($val);
        }
    }
}

public function actionDelete_lesson_score($id)
{

    $model_Score = Score::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));
    $model_Logchoice = Logchoice::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));
    $model_Logques = Logques::model()->deleteAll(array(
        'condition' => 'score_id=' . $id,
    ));

    if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
}

    //// USER ////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //// UNIVERSITY ////

public function actionShowResetCourseUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, user_id, student_house',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id 
                inner join tbl_course_online on tbl_course_online.course_id = tbl_lesson.course_id 
                inner join tbl_users on tbl_users.id = Learn.user_id 
                inner join university on university.id = tbl_users.student_house',
                'group'=>'tbl_course_online.course_id',
                'order'=>'tbl_course_online.course_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_course_uni', array(
            'uni' => $uni,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetLearnCourseUni()
{
    if (($_POST['uniID'] != '') && ($_POST['courseID'] != '')) {
        $uniID = $_POST['uniID'];
        $courseID = $_POST['courseID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $lesson = Lesson::model()->findAll('course_id=' . $courseID . ' AND active="y"');
        foreach ($lesson as $lessonItems) {
            $criteria = new CDbCriteria;
            $criteria->addCondition('lesson_id=' . $lessonItems->id);
            $criteria->addInCondition('user_id', $ids);
            $learnDel = Learn::model()->findAll($criteria);
            foreach ($learnDel as $key => $value) {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('learn_id=' . $value->learn_id);
                $criteria2->addInCondition('user_id_file', $ids);
                LearnFile::model()->deleteAll($criteria2);
            }
            Learn::model()->deleteAll($criteria);
        }
    }
}

public function actionShowResetLessonUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Learn', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, user_id, student_house',
                'alias'=>'Learn',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Learn.lesson_id 
                inner join tbl_users on tbl_users.id = Learn.user_id 
                inner join university on university.id = tbl_users.student_house',
                'group'=>'Learn.lesson_id',
                'order'=>'Learn.lesson_id'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_lesson_uni', array(
            'uni' => $uni,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetLearnLessonUni()
{
    if (($_POST['uniID'] != '') && ($_POST['lessonID'] != '')) {
        $uniID = $_POST['uniID'];
        $lessonID = $_POST['lessonID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition('lesson_id=' . $lessonID);
        $criteria->addInCondition('user_id', $ids);
        $learnDel = Learn::model()->findAll($criteria);
        $idl = array();
        foreach ($learnDel as $learnItems) {
            $idl[] = $learnItems->learn_id;
        }
        $criteria2 = new CDbCriteria;
        $criteria2->addInCondition('learn_id', $idl);
        $criteria2->addInCondition('user_id_file', $ids);
        LearnFile::model()->deleteAll($criteria2);
        Learn::model()->deleteAll($criteria);
    }
}

public function actionShowResetExamLessonUni()
{
    if (isset($_GET['uniID'])) {
        $uniID = $_GET['uniID'];
        $uni = TbUniversity::model()->findByPk($uniID);

        $dataProvider=new CActiveDataProvider('Score', array(
            'criteria'=>array(
                'condition'=>'tbl_users.student_house = "'.$uniID.'"',
                'select'=>'lesson_id, score_id, user_id, type',
                'alias'=>'Score',
                'join'=>'inner join tbl_lesson on tbl_lesson.id = Score.lesson_id
                inner join tbl_users on tbl_users.id = Score.user_id
                inner join university on university.id = tbl_users.student_house',
                'group'=>'Score.lesson_id',
                'order'=>'Score.lesson_id ASC,Score.type DESC'
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));
        if(isset($_GET['Learn']))
            $model->attributes = $_GET['Learn'];

        $this->render('show_reset_exam_uni', array(
            'user' => $user,
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ));
    } else {
        $this->redirect(array('LearnReset/Reset_university'));
    }
}

public function actionResetScoreLessonUni()
{
    if (($_POST['uniID'] != '') && ($_POST['lessonID'] != '')) {
        $uniID = $_POST['uniID'];
        $lessonID = $_POST['lessonID'];

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $uniID,
        ));
        $ids = array();
        if ($university_user) {
            foreach ($university_user as $user) {
                $ids[] = $user->id;
            }
        }

        $criteria = new CDbCriteria;
        $criteria->addCondition('lesson_id=' . $lessonID);
        $criteria->addInCondition('user_id', $ids);
        $score = Score::model()->findAll($criteria);
        if($score){
            foreach ($score as $key => $value) {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('score_id=' . $value->score_id);
                $modelLogChoice = Logchoice::model()->deleteAll($criteria2);
                $modelLogQues = Logques::model()->deleteAll($criteria2);
            }                
            $score = Score::model()->deleteAll($criteria);
        }
    }
}
    //// UNIVERSITY ////

public function actionIndex()
{
    $model = new Reset('search');
    if(isset($_GET['Reset'])){
        $model->searchValue = $_GET['Reset']['searchValue'];
    }

    $this->render('index',array(
        'model'=>$model
    ));
}


public function actionReset_university()
{
    $model=new TbUniversity('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['University']))
            $model->attributes=$_GET['University'];

        $this->render('reset_university',array(
            'model'=>$model,
        ));
    }




    public function actionUser_reset_learn()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $model_learn = Learn::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_learnfile = LearnFile::model()->deleteAll(array(
                'condition' => 'user_id_file=' . $id,
            ));
        }
    }

    public function actionUser_reset_score()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $model_Score = Score::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_Logchoice = Logchoice::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
            $model_Logques = Logques::model()->deleteAll(array(
                'condition' => 'user_id=' . $id,
            ));
        }
    }


    public function actionDelete_user_learn($id)
    {

        $model_learn = Learn::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_learnfile = LearnFile::model()->deleteAll(array(
            'condition' => 'user_id_file=' . $id,
        ));

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDelete_user_score($id)
    {

        $model_Score = Score::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_Logchoice = Logchoice::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));
        $model_Logques = Logques::model()->deleteAll(array(
            'condition' => 'user_id=' . $id,
        ));

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    public function actionMultiDelete_learn_user()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_user_learn($val);
            }
        }
    }
    public function actionMultiDelete_score_user()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_user_score($val);
            }
        }
    }






    //===============================================University===========================================//

    public function actionUniversity_reset_learn()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $university_user = User::model()->findAll(array(
                'condition' => 'student_house=' . $id,
            ));
            if ($university_user) {
                foreach ($university_user as $user) {
                    $model_learn = Learn::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_learnfile = LearnFile::model()->deleteAll(array(
                        'condition' => 'user_id_file=' . $user->id,
                    ));
                }
            }
        }
    }


    public function actionUniversity_reset_score()
    {
        if(isset($_POST['del_id'])) {
            $id = $_POST['del_id'];
            $university_user = User::model()->findAll(array(
                'condition' => 'student_house=' . $id,
            ));
            if ($university_user) {
                foreach ($university_user as $user) {
                    $model_Score = Score::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_Logchoice = Logchoice::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                    $model_Logques = Logques::model()->deleteAll(array(
                        'condition' => 'user_id=' . $user->id,
                    ));
                }
            }
        }

    }



    public function actionDelete_learn($id)
    {

        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $id,
        ));
        if ($university_user) {
            foreach ($university_user as $user) {
                $model_learn = Learn::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_learnfile = LearnFile::model()->deleteAll(array(
                    'condition' => 'user_id_file=' . $user->id,
                ));
            }
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDelete_score($id)
    {
        $university_user = User::model()->findAll(array(
            'condition' => 'student_house=' . $id,
        ));
        if ($university_user) {
            foreach ($university_user as $user) {
                $model_Score = Score::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_Logchoice = Logchoice::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
                $model_Logques = Logques::model()->deleteAll(array(
                    'condition' => 'user_id=' . $user->id,
                ));
            }
        }

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    public function actionMultiDelete_learn()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_learn($val);
            }
        }
    }

    public function actionMultiDelete_score()
    {
        header('Content-type: application/json');
        if(isset($_POST['chk']))
        {
            foreach($_POST['chk'] as $val)
            {
                $this->actionDelete_score($val);
            }
        }
    }

    public function actionGet_dialog_learn()
    {
        $type = 'learn';
        $user_id = $_POST['user_id'];
        $test = '';
        
        $criteria = new CDbCriteria;
        $criteria->join = " INNER JOIN `tbl_lesson` AS les ON (les.`id`=t.`lesson_id`)";
        $criteria->compare('user_id',$user_id);
        $criteria->compare('lesson_active','y');
        $criteria->compare('les.active','y');
        $criteria->addCondition('lesson_status IS NOT NULL');
        //$criteria->group = 't.course_id';
        $criteria->order = 't.course_id ASC';
        $learn = Learn::model()->findAll($criteria);
        
        $lesson = array();
        $course = array();
        foreach ($learn as $key => $value) {
            if(!in_array($value->course_id, $course)){
                $course[$value->course_id] = $value->course;
            }
            $lesson[$value->course_id][$value->lesson_id] = $value->les;
        }

        $criteria = new CDbCriteria;
        $criteria->with = array('Lessons','Lessons.courseonlines');
        $criteria->compare('user_id',$user_id);
        $criteria->compare('courseonline.active','y');
        $criteria->compare('t.active','y');
        $score = Score::model()->findAll($criteria);
        foreach ($score as $key => $value) {
            // if($value->Lessons->courseonlines->active == 'y'){
                $course_id = $value->Lessons->courseonlines->course_id;
                if(!in_array($course_id, $course)){
                    $course[$course_id] = $value->Lessons->courseonlines;
                }
                if(!in_array($value->lesson_id, $lesson)){
                    $lesson[$course_id][$value->lesson_id] = $value->Lessons;
                }
            // }
        }
     
        $respon = $this->renderPartial('_modal_learn',array('course' => $course,'lesson' => $lesson,'user_id' => $user_id,'type' => $type));
        exit();
    }

    public function actionSaveResetLearn()
    {
     $user_id = $_POST['id'];
     $lesson = json_decode($_POST['checkedList']);
     $reset_type = $_POST['reset_type'];
     $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ข้อมูลการเรียนบทเรียนต่อไปนี้ <br>';
     foreach ($lesson as $key => $value) {
        $val = array();
        $val = explode(",", $value);
        $course_id = $val[0];
        $lesson_id = $val[1];
        $type = $val[2];
        
        $logReset = new LogReset;
        $logReset->user_id = $user_id;
        $logReset->course_id = $course_id;
        $logReset->lesson_id = $lesson_id;
        $logReset->reset_description = $_POST['description'];
        $logReset->reset_date = date('Y-m-d h:i:s');
        $logReset->reset_by = Yii::app()->user->id;
        $logReset->reset_type = 0;
        if($logReset->save()){
           $learn = Learn::model()->findAllByAttributes(array(
            'user_id' => $user_id,
            'lesson_id' => $lesson_id,
            'course_id' => $course_id
        ));
           foreach ($learn as $key1 => $data) {
               $learnFile = LearnFile::model()->deleteAll('user_id_file="' . $user_id . '" AND learn_id="' . $data->learn_id . '"');
               $score = Score::model()->findAllByAttributes(array(
                'user_id' => $user_id,
                'lesson_id' => $lesson_id,
            ));
               foreach ($score as $key2 => $sc) {
                 $sc->active = 'n';
                 $sc->save();
             }
             $data->lesson_active = 'n';
             $data->save();
         }
         //Reset Course
         $courseScore = Coursescore::model()->findAll(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id',
            'params' => array(':course_id' => $course_id,':user_id' => $user_id)));
         foreach ($courseScore as $valScore) {
             $valScore->active = 'n';
             $valScore->save();
         }

    } else {
        var_dump($logReset->getErrors());
    }
    //Reset Lesson
    QQuestAns::model()->deleteAll(array(
        'condition' => 'user_id=:user_id AND lesson_id=:lesson_id',
        'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id)));
    QQuestAns_course::model()->deleteAll(array(
        'condition' => 'user_id=:user_id AND course_id=:course_id',
        'params' => array(':user_id' => $user_id,':course_id' => $course_id)));
    Passcours::model()->deleteAll(array(
        'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:passcours_user',
        'params' => array(':passcours_cours' => $course_id,':passcours_user' => $user_id)));
    LogStartcourse::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active',
        'params' => array(':course_id' => $course_id,':user_id' => $user_id,':active'=>'y')));
    TempCourseQuiz::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id',
        'params' => array(':course_id' => $course_id,':user_id' => $user_id)));

    //Reset Course
    // Coursescore::model()->deleteAll(array(
    //     'condition' => 'course_id=:course_id AND user_id=:user_id AND score_past is NULL',
    //     'params' => array(':course_id' => $course_id,':user_id' => $user_id)));
    TempCourseQuiz::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id',
        'params' => array(':course_id' => $course_id,':user_id' => $user_id)));


    $lessonS = Lesson::model()->findByPk($lesson_id);
    $courseMsg .= ($key+1).". <b>หลักสูตร : </b> ".$lessonS->courseonlines->course_title.'<br> <b>บทเรียน : </b>'.$lessonS->title.'<br>';
}
if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();

        }
$courseMsg .= '<br><span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
$model = Users::model()->findByPk($user_id);
$to['email'] = $model->email;
$to['firstname'] = $model->profiles->firstname;
$to['lastname'] = $model->profiles->lastname;
$subject = 'แจ้งเตือน ระบบ reset การเรียน';
$message = "หัวช้อ : แจ้งเตือนระบบ reset <br> <br>";
$message .= "เรียน ".$model->profiles->firstname." ".$model->profiles->lastname."<br> <br>";
$message .= "<div style=\"text-indent: 4em;\">";
$message .= $courseMsg."</div>";
// $send = Helpers::lib()->SendMail($to,$subject,$message);
$send = Helpers::lib()->SendMailNotification($to,$subject,$message);
echo $reset_type;
}

public function actionGet_dialog_exam()
{
    $type = 'exam';
    $user_id = $_POST['user_id'];
    $criteria = new CDbCriteria;
    $criteria->join = " INNER JOIN `tbl_course_online` AS course ON (course.`course_id`=t.`course_id`)";
    $criteria->compare('user_id',$user_id);
    $criteria->compare('course.active','y');
    $criteria->compare('t.active','y');
    $criteria->group = 'course.course_id';
    $criteria->order = 't.score_id ASC';
    $score = Coursescore::model()->findAll($criteria);

    $respon = '';
    $respon = $this->renderPartial('_modal_exam',array('score' => $score,'user_id' => $user_id,'type' => $type));
    exit();
}

public function actionSaveResetExam(){
    $user_id = $_POST['id'];
    $courseData = json_decode($_POST['checkedList']);
    $reset_type = $_POST['reset_type'];
    $courseMsg = 'ผู้ดูแลระบบ ทำการ Reset ผลสอบวัดผลหลักสูตรต่อไปนี้ <br>';
    foreach ($courseData as $key => $value) {
        $courseScore = Coursescore::model()->findAll(array(
            'condition' => 'course_id=:course_id AND user_id=:user_id',
            'params' => array(':course_id' => $value,':user_id' => $user_id)));
        foreach ($courseScore as $valScore) {
           $valScore->active = 'n';
           $valScore->save();
       }
       Coursescore::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id AND score_past is NULL',
        'params' => array(':course_id' => $value,':user_id' => $user_id)));
       TempCourseQuiz::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id',
        'params' => array(':course_id' => $value,':user_id' => $user_id)));

       $logReset = new LogReset;
       $logReset->user_id = $user_id;
       $logReset->course_id = $value;
       $logReset->reset_description = $_POST['description'];
       $logReset->reset_date = date('Y-m-d h:i:s');
       $logReset->reset_type = 1;
       $logReset->reset_by = Yii::app()->user->id;
       if(!$logReset->save())var_dump($logReset->getErrors());

       Passcours::model()->deleteAll(array(
        'condition' => 'passcours_cours=:passcours_cours AND passcours_user=:passcours_user',
        'params' => array(':passcours_cours' => $value,':passcours_user' => $user_id)));
       $courseName = CourseOnline::model()->findByPk($value);
       $courseMsg .= ($key+1)." หลักสูตร : ".$courseName->course_title.'<br>';

       LogStartcourse::model()->deleteAll(array(
        'condition' => 'course_id=:course_id AND user_id=:user_id AND active=:active',
        'params' => array(':course_id' => $value,':user_id' => $user_id,':active'=>'y')));
        
       $courseName = CourseOnline::model()->findByPk($value);
       $courseMsg .= ($key+1)." หลักสูตร : ".$courseName->course_title.'<br>';

   }
   if(Yii::app()->user->id){
    Helpers::lib()->getControllerActionId();
}
    $courseMsg .= '<br><span style="color:red">สาเหตุ : '.$_POST['description'].'</span>';
$model = Users::model()->findByPk($user_id);
$to['email'] = $model->email;
$to['firstname'] = $model->profiles->firstname;
$to['lastname'] = $model->profiles->lastname;
$subject = 'แจ้งเตือน ระบบ reset สอบวัดผล';
$message = "หัวช้อ : แจ้งเตือนระบบ reset <br> <br>";
$message .= "เรียน ".$model->profiles->firstname." ".$model->profiles->lastname."<br> <br>";
$message .= "<div style=\"text-indent: 4em;\">";
$message .= $courseMsg."</div>";
// $send = Helpers::lib()->SendMail($to,$subject,$message);
$send = Helpers::lib()->SendMailNotification($to,$subject,$message);
   echo $reset_type;
}

public function actionResetDetail(){
    $id = $_POST['id'];
    $model = new LogReset('search');
    $model->unsetAttributes();
    if($id != null){
        $model->user_id = $id;
        $respon = $this->renderPartial('_reset_detail',array('model' => $model));
    }
    echo $respon;
}

public function actionGet_dialog_all()
{
    $user_id = $_POST['user_id'];

    $form = "
    <div class='col-md-12'>
    <form action='LearnReset/ResetLearnLesson' method='post'>
    <input type='hidden' name='reset_type' value='all'>
    <input type='checkbox' id='checkAll' /> เลือกทั้งหมด
    <br>
    ";

    $learn = Learn::model()->findAll(array(
        'condition' => 'user_id=' . $user_id.' order by course_id',
    ));

    if($learn){
        foreach($learn as $key => $value){
            $course_id[$value['course_id']] = $value['course_id'];
            $lesson_id[$value['course_id']][$value['lesson_id']] = $value['lesson_id'];
        }

        foreach($course_id as $key => $cid){
            $course_data = MtCourseName::model()->find(array('condition'=>'cnid = '.$cid));
            $form .= "<input type='checkbox'name=course_id[]  value=".$cid." /> ".$course_data['course_name'];
            $form .= "<br>";
            $form .="<ul style='list-style-type: none;'>";
            foreach($lesson_id[$key] as $cnid => $lid){
                $lesson_data = LessonList::model()->find(array('condition'=>'lid = '.$lid));
                $form .= "<li><input type='checkbox'name=lesson_id[]  value=".$lid." /> ".$lesson_data['lesson_name'];
                $form .= "</li>";
            }
            $form .= "</ul>";
        }
    }


    $form .= "</form>
    </div>
    <script>

    $('#checkAll').change(function () {
        $('input:checkbox').prop('checked', $(this).prop('checked'));
    });   
    </script>
    ";
    echo $form;
    exit();
}

    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    public function actionCheckCourseAccept(){
        $user = Users::model()->findByPk(Yii::app()->user->id);
        $type =  $_POST['reset_type'];
        $attr = array();
        $attr['status'] = true;
        if($user->superuser!=1){
            $lesson = json_decode($_POST['checkedList']);
            $criteria=new CDbCriteria;
            $criteria->with = array('course');
            $criteria->compare('user_id',$user->id);
            $criteria->addInCondition('course_id',$lesson);
            $courseSelect = MtAuthCourseName::model()->findAll($criteria);
            foreach ($courseSelect as $key => $value) {
                if($value->course->cn_accept_certificate == '1' && $value->approve_certificate=='y'){
                    $attr['status'] = false;
                    $attr['course'] .= $value->course->course_name;
                    } /*else {
                        if($type == 'exam'){
                            if($value->course->cn_accept_final_exam == '1' && $value->approve_exams=='y'){
                                $attr['status'] = false;
                                $attr['course'] .= $value->course->course_name;
                            }
                        } else {
                           if($value->course->cn_accept_result_exam == '1' && $value->approve_result_exam=='y'){
                                $attr['status'] = false;
                                $attr['course'] .= $value->course->course_name;
                            }
                        }
                    }*/
                }
            }
            echo json_encode($attr);
        }

        public function actionConfirmPass(){
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $passChk = $_POST['passInput'];
            if($user->email == $passChk){
                echo true;
            } else {
                echo false;
            }
        }

        protected function performAjaxValidation($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='reset-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }

    }