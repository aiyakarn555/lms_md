<?php

class CheckLectureController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
  public function init()
  {
    // parent::init();
    // $this->lastactivity();
    if(Yii::app()->user->id == null){
        $this->redirect(array('site/index'));
      }
    
  }
  
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
        	array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('index','view','create','update','admin','delete'),
                'users'=>Yii::app()->getModule('user')->getAdmins(),
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


    public function actionIndex()
    {

        $model=new Logques('search');
        $model->unsetAttributes();  // clear any default values
        // $model->check = 0;
        $model->confirm = 0;
        $model->ques_type = 3;

        if(isset($_GET['Logques'])){
        	// var_dump($_GET['Logques']);exit();

        	$model->searchAll = $_GET['Logques']['searchAll'];

        	if($model->searchAll != ""){
               $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
               $search = explode(" ",$model->searchAll);
               $searchCount = count($search);
               $sqlUser .= "(";
               foreach ($search as $key => $searchText) {
                  $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%' OR email LIKE '%" . trim($searchText) . "%' OR tbl_profiles.identification LIKE '%" . trim($searchText) . "%')";
                  if($searchCount != $key+1){
                    $sqlUser .= " OR ";
                }
              }

            $sqlUser .= ")";
            $user = Yii::app()->db->createCommand($sqlUser)->queryAll(); 

        }
        if(count($user) > 0){
        	$model->user_id = $user[0]['id'];
        }else{
            $model->user_id = $_GET['Logques']['searchAll'];
        }
        $model->course_id = $_GET['Logques']['course_id'];
            // $model->attributes=$_GET['Logques'];
        $model->dateRang = $_GET['Logques']['dateRang'];
        if($model->dateRang != ""){
          $date = explode("-",$model->dateRang);
          $start = date("Y-m-d", strtotime(trim($date[0])));
          $end = date("Y-m-d", strtotime(trim($date[1])));
          $model->period_start = $start;
          $model->period_end = $end;

      }
      $model->lesson_id = $_GET['Logques']['lesson_id'];
  }


  $this->render('index',array(
    'model'=>$model,
    'user'=>$user,
));
}

public function actionSaveExamConfirm(){
    $user_id = $_POST['user_id'];
    $lesson_id = $_POST['lesson_id'];
    $type = $_POST['test_type'];
    $logques = Logques::model()->updateAll(array('confirm' => '1'),array(
        'condition' => 'user_id=:user_id and active = "y" and test_type=:type and ques_type = 3 and lesson_id=:lesson_id','order'=>'user_id',
        'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id,':type' => $type)));
    $Score = Score::model()->updateAll(array('confirm' => '1'),array(
        'condition' => 'user_id=:user_id and active = "y" and type=:type and ques_type = 3 and lesson_id=:lesson_id',
        'params' => array(':user_id' => $user_id,':lesson_id' => $lesson_id,':type' => $type)));


    $post_score = Coursescore::model()->findAll(array(
        'condition' => 'user_id=:user_id and active = "y" and ques_type = 3 and course_id=:course_id and type="post" AND confirm=1',
        'params' => array(':user_id' => $user_id,':course_id' => $course_id)));

    $post_score_check = Coursescore::model()->find(array(
      'condition' => 'user_id=:user_id and active = "y" and ques_type = 3 and course_id=:course_id and type="post" AND confirm=1',
      'params' => array(':user_id' => $user_id,':course_id' => $course_id)));
      
    if ($post_score_check->score_number <= $post_score_check->score_total){
      if(!empty($post_score)){
        $passcourse = Passcours::model()->findAll(array(
          'condition' => 'passcours_user=:user_id AND passcours_cours=:course_id',
          'params' => array(':user_id' => $user_id,':course_id' => $course_id)));
        
        if(empty($passcourse)){
          $course_model = CourseOnline::model()->findByPk($course_id);
          $Passcours = new Passcours;
          $Passcours->passcours_cates = $course_model->cate_id;
          $Passcours->passcours_cours = $course_id;
          $Passcours->gen_id = $post_score_check->gen_id;
          $Passcours->passcours_user = $user_id;
          $Passcours->passcours_date = date("Y-m-d H:i:s");
          $Passcours->save();
        }
      }
    }

    
    echo true;
}

public function actionSaveCourseExamConfirm(){
    $user_id = $_POST['user_id'];
    $course_id = $_POST['course_id'];
    $logques = Courselogques::model()->updateAll(array('confirm' => '1'),array(
        'condition' => 'user_id=:user_id and active = "y" and ques_type = 3 and course_id=:course_id','order'=>'user_id',
        'params' => array(':user_id' => $user_id,':course_id' => $course_id)));
    $Score = Coursescore::model()->updateAll(array('confirm' => '1'),array(
        'condition' => 'user_id=:user_id and active = "y" and ques_type = 3 and course_id=:course_id',
        'params' => array(':user_id' => $user_id,':course_id' => $course_id)));
    echo true;
}

public function actionCoureCheck()
{
        // $model=new Logques('search');
    $model=new Courselogques('search');

        $model->unsetAttributes();  // clear any default values
        // $model->check = 0;
        $model->ques_type = 3;
        if(isset($_GET['Courselogques'])){
        	// var_dump($_GET['Logques']);exit();
          $model->searchAll = $_GET['Courselogques']['searchAll'];

          if($model->searchAll != ""){
           $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
           $search = explode(" ",$model->searchAll);
           $searchCount = count($search);
           $sqlUser .= "(";
           foreach ($search as $key => $searchText) {
              $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%' OR email LIKE '%" . trim($searchText) . "%' OR tbl_profiles.identification LIKE '%" . trim($searchText) . "%')";
              if($searchCount != $key+1){
                $sqlUser .= " OR ";
            }
            
        }
        $sqlUser .= ")";
        $user = Yii::app()->db->createCommand($sqlUser)->queryAll(); 
    }
    if(count($user) > 0){
       $model->user_id = $user[0]['id'];
   }else{
    $model->user_id =  $_GET['Courselogques']['searchAll'];
}
$model->course_id = $_GET['Courselogques']['course_id'];
            // $model->attributes=$_GET['Logques'];
$model->dateRang = $_GET['Courselogques']['dateRang'];
if($model->dateRang != ""){
  $date = explode("-",$model->dateRang);
  $start = date("Y-m-d", strtotime(trim($date[0])));
  $end = date("Y-m-d", strtotime(trim($date[1])));
  $model->period_start = $start;
  $model->period_end = $end;

}

        	// $model->nameSearch = $_GET['Courselogques']['user_id'];
        	// $model->email = $_GET['Courselogques']['email'];
        	// $model->course_id = $_GET['Courselogques']['course_id'];

            // $model->attributes=$_GET['Logques'];
}

$this->render('index_course',array(
    'model'=>$model,
    'user'=>$user,
));
}

public function actionGet_dialog_exam(){
  $userid = $_POST['user_id'];
  $lessonid = $_POST['lesson_id'];
  $test_type = $_POST['test_type'];

  $model = Logques::model()->with('Score')->findAll(array(
     'condition' => 't.user_id=:user_id AND t.lesson_id=:lesson_id AND t.active="y" AND Score.active="y"  AND t.ques_type = 3 AND t.test_type =:test_type and t.confirm = 0',
     'params' => array(':user_id'=> $userid,':lesson_id' => $lessonid,':test_type' => $test_type)));

  $msg = $this->renderPartial('_modal_exam',array('model'=>$model));
  echo $msg;
}

public function actionGet_dialog_result(){
  $userid = $_POST['user_id'];
  $lessonid = $_POST['lesson_id'];
  $test_type = $_POST['test_type'];

  $model = Logques::model()->findAll(array(
     'condition' => 'user_id=:user_id AND lesson_id=:lesson_id AND active="y" AND t.check = 1 AND ques_type = 3 AND t.test_type =:test_type',
     'params' => array(':user_id'=> $userid,':lesson_id' => $lessonid,':test_type' => $test_type)));
  $msg = $this->renderPartial('_modal_result',array('model'=>$model));
  echo $msg;
}

public function actionGet_dialog_resultCourse(){
    $userid = $_POST['user_id'];
    $courseId = $_POST['course_id'];

    $model = Courselogques::model()->findAll(array(
        'condition' => 'user_id=:user_id AND active="y" AND t.check = 1 AND t.course_id =:course_id AND ques_type = 3',
        'params' => array(':user_id'=> $userid,':course_id' => $courseId)));
    $msg = $this->renderPartial('_modal_resultCourse',array('model'=>$model));
    echo $msg;
}

public function actionGet_dialog_exam_course(){
  $userid = $_POST['user_id'];
  $courseId = $_POST['course_id'];

  $model = Courselogques::model()->with('Coursescore')->findAll(array(
     'condition' => 't.user_id=:user_id AND t.course_id=:course_id AND t.active="y" AND Coursescore.active="y" AND t.confirm = 0 AND t.ques_type=3',
     'params' => array(':user_id'=> $userid,':course_id' => $courseId)));
		// var_dump($model);exit();
  $msg = $this->renderPartial('_modal_exam_course',array('model'=>$model));
  echo $msg;
}

public function actionSaveExam(){
		// var_dump($_POST);exit();
  $allCheck = $_POST['logques_id'];
  $maxTotal = 0;
  $scoreNum = 0;
		foreach ($allCheck as $key => $value) { //$key = logques_id
			$modelCheck = Logques::model()->findByPk($key);
			$modelCheck->result = $value;
			$maxTotal += $modelCheck->question->max_score;
			$scoreNum += $value;
			$modelCheck->check = 1;
			$scoreId = $modelCheck->score_id;
			$modelCheck->save();
     }

     $scoreUpdate = Score::model()->findByPk($scoreId);

     $scoreSum =  $scoreNum;
     $sumPoint = $scoreSum * 100 / $maxTotal;
     Score::model()->updateByPk($scoreId, array(
        'score_number' => $scoreSum,
        'score_total' => $maxTotal,
        'update_date' => date('Y-m-d H:i:s'),
        'score_past' => ($sumPoint >= 60) ? 'y' : 'n',
    ));
 }

 public function actionSaveExamCourse(){
		// var_dump($_POST);exit();
		// $perPass = $scoreUpdate->percen_test;
  $allCheck = $_POST['logques_id'];
  $maxTotal = 0;
  $scoreNum = 0;
		foreach ($allCheck as $key => $value) { //$key = logques_id
			$modelCheck = Courselogques::model()->findByPk($key);

			$modelCheck->result = $value;
			$maxTotal += $modelCheck->questions->max_score;
			$scoreNum += $value;
			$modelCheck->check = 1;
			$scoreId = $modelCheck->score_id;
			$modelCheck->save();
     }
     $scoreUpdate = Coursescore::model()->findByPk($scoreId);
     $scoreSum =  $scoreNum;
     $perPass = $scoreUpdate->CourseOnlines->percen_test;
     $sumPoint = $scoreSum * 100 / $maxTotal;
     Coursescore::model()->updateByPk($scoreUpdate->score_id, array(
        'score_number' => $scoreSum,
        'score_total' => $maxTotal,
        'update_date' => date('Y-m-d H:i:s'),
        'score_past' => ($sumPoint >= $perPass) ? 'y' : 'n',
        'confirm' => 1
    ));

 }

 public function actionlogLecture($id=null){
  $model=new Logques('search');

        $model->unsetAttributes();  // clear any default values
        $model->check = 1;
        $model->ques_type = 3;

        if(isset($_GET['Logques'])){
           $model->attributes=$_GET['Logques'];
       }

       $this->render('index_loglecture',array(
        'model'=>$model,
    ));

   }

   public function actionGetLessonData(){
    $course_id = $_POST['course_id'];
      // $list = Logques::getLessonList($course_id);
    $list = Lesson::model()->findAll("course_id='".$course_id."' AND active='y' AND lang_id=1");
// var_dump($list); exit();
      $lesson = '<option value="">ทั้งหมด</option>';
      foreach ($list as $key => $value) {
      $lesson .= '<option value = "'.$value->id.'">'.$value->title.'</option>';
    }
    echo $lesson;
   }

   public function actionTest(){

    $course_id  = $_POST['course_id'];
    // $model = new Logques;
    // $list = $model->getLessonList($course_id);
    $model = Lesson::model()->findAll(array(
        'condition' => 'course_id=:course_id and active = "y"','order'=>'id',
        'params' => array(':course_id' => $course_id)));
    $test = '<option value>ทั้งหมด</option>';
    foreach ($model as $key => $value) {
      $test .= '<option value = "'.$value->id.'">'.$value->title.'</option>';
      # code...
    }
    var_dump($test);
    // var_dump($list);
   }

}