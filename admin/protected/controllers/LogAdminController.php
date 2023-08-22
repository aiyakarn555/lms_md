<?php

class LogAdminController extends Controller
{
    public function init()
    {
        // parent::init();
        // $this->lastactivity();
        if(Yii::app()->user->id == null){
                $this->redirect(array('site/index'));
            }
        
    }
    
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
                'actions' => array('index', 'view'),
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
    public function actionIndex()
    {
        $model=new LogAdmin('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogAdmin']))
            $model->attributes=$_GET['LogAdmin'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function actionUsers()
    {
        $model=new LogUsers('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogUsers']))
            $model->attributes=$_GET['LogUsers'];

        $this->render('users',array(
            'model'=>$model,
        ));
    }

    public function actionEmail()
    {
        $model=new LogEmail('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogEmail']))
            $model->attributes=$_GET['LogEmail'];

        $this->render('email',array(
            'model'=>$model,
        ));
    }

    public function actionApi()
    {
        $model=new LogApi('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogApi']))
            $model->attributes=$_GET['LogApi'];

        $this->render('api',array(
            'model'=>$model,
        ));
    }
    public function actionRegister()
    {
        $model=new LogRegister('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogRegister']))
            $model->attributes=$_GET['LogRegister'];

        $this->render('Register',array(
            'model'=>$model,
        ));
    }
     
    public function actionApprove()
    {
        $model=new LogApprove('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogApprove']))
            $model->attributes=$_GET['LogApprove'];

        $this->render('Approve',array(
            'model'=>$model,
        ));
    }

    public function actionApprovePersonal()
    {
        $model=new LogApprovePersonal('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LogApprovePersonal']))
            $model->attributes=$_GET['LogApprovePersonal'];

        $this->render('ApprovePersonal',array(
            'model'=>$model,
        ));
    }

    public function getStrLog($data){
        $jsonData = json_decode( $data->log_data);
        if($data->log_event == "create"){

            $course_id = $jsonData->course_id;
            $strCourse = "ชื่อหลักสูตร: ".$jsonData->course_title." รหัส: ".$jsonData->course_id;

            $ObjSchedule = $jsonData->schedule;
            if(!empty($ObjSchedule)){
                $strSchedule = "ตารางเรียน"."<br>";
                $strSchedule .= "รหัสตารางเรียน: ".$ObjSchedule->schedule_id."<br>";
                $strSchedule .= "วันที่เริ่มต้นการเรียน: ".$ObjSchedule->training_date_start."<br>";
                $strSchedule .= "วันที่สิ้นสุดการเรียน: ".$ObjSchedule->training_date_end."<br>";
            }

            $ObjMember = $jsonData->member;
            if(!empty($ObjMember)){
                $strUser = "จำนวนสมาชิกทั้งหมด : ".count($jsonData->member)."<br>";
                $strUser .= "สมาชิกที่เพิ่ม"."<br>";
                foreach ($ObjMember as $key => $user) {
                    $strUser .= "ชื่อ: ".$user->profile->firstname." ".$user->profile->lastname."<br>";
                    $strUser .= "วันที่สมัคร: ".$user->register_date."<br>";
                }
            }

            $key = $jsonData->key;
            $strKey = "KEY: ".$key;
                // var_dump($jsonData);
                // return $data->log_data;
            return $strCourse."<br>".$strSchedule."<br>".$strUser."<br>";
        }else if($data->log_event == "return"){
            $ObjSchedule = $jsonData->schedule_id;
            if(!empty($ObjSchedule)){
                $strSchedule = "ตารางเรียน"."<br>";
                $strSchedule .= "รหัสตารางเรียน: ".$ObjSchedule."<br>";
            }
            $ObjMember = $jsonData->member;
            if(!empty($ObjMember)){
                $strUser = "จำนวนสมาชิกทั้งหมด : ".count($jsonData->member)."<br>";
                $strUser .= "ข้อมูลสมาชิก"."<br>";
                foreach ($ObjMember as $key => $user) {
                    $strUser .= "(".++$key.")"." บัญชีผู้ใช้: ".$user->username."<br>";
                    $strUser .= "-สถานะ: ".$user->status."<br>";
                    if($user->status == "P"){
                        $strUser .= "-คะแนน: ".$user->score."<br>";
                        $strUser .= "-วันที่สอบผ่าน: ".$user->date."<br>";
                    }
                    
                    
                }
            }

            return $strSchedule."<br>".$strUser."<br>";
        }else if($data->log_event == "update"){
            $course_id = $jsonData->course_id;
            $course_title = $jsonData->course_title;
            $course_outline = $jsonData->course_outline;
            if(!empty($jsonData->schedule)){
                $strCourse = "ชื่อหลักสูตร: ".$jsonData->course_title." รหัส: ".$jsonData->course_id;
                $ObjSchedule = $jsonData->schedule;
                if(!empty($ObjSchedule)){
                    $strSchedule = "ตารางเรียน"."<br>";
                    $strSchedule .= "รหัสตารางเรียน: ".$ObjSchedule->schedule_id."<br>";
                    $strSchedule .= "วันที่เริ่มต้นการเรียน: ".$ObjSchedule->training_date_start."<br>";
                    $strSchedule .= "วันที่สิ้นสุดการเรียน: ".$ObjSchedule->training_date_end."<br>";
                }

                $ObjMember = $jsonData->member;
                if(!empty($ObjMember)){
                    $strUser = "จำนวนสมาชิกทั้งหมด : ".count($jsonData->member)."<br>";
                    $strUser .= "สมาชิกที่เพิ่ม"."<br>";
                    foreach ($ObjMember as $key => $user) {
                        $strUser .= "ชื่อ: ".$user->profile->firstname." ".$user->profile->lastname."<br>";
                        $strUser .= "วันที่สมัคร: ".$user->register_date."<br>";
                    }
                }

                $key = $jsonData->key;
                $strKey = "KEY: ".$key;
                // var_dump($jsonData);
                // return $data->log_data;
                return $strCourse."<br>".$strSchedule."<br>".$strUser."<br>";
            }
            return 'รหัสหลักสูตร: '.$course_id.'<br>'.'หัวข้อหลักสูตร: '.$course_title.'<br>'.'รายละเอียดหลักสูตร: '.$course_outline.'<br>';
        }
    }
}