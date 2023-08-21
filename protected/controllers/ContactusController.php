<?php

class ContactusController extends Controller {
    public function init()
    {
        parent::init();
        $this->lastactivity();
        
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ));
    }

    public function actionIndex() {
        $user = array();
        $model = new Contactus();
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
            $user = User::model()->findbyPK(Yii::app()->user->id);
        }
        if(!empty($user)){
            $model->contac_by_name = $user->profile->firstname;
            $model->contac_by_surname = $user->profile->lastname;
            $model->contac_by_tel = $user->profile->tel;
            $model->contac_by_email = $user->email;
        }

        // echo "<pre>";
        // var_dump($_POST['Contactus'][contac_type]);
        // exit();
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }

        $label = MenuContactus::model()->find(array(
            'condition' => 'lang_id=:lang_id',
            'params' => array(':lang_id' => $langId)
        ));
        if(!$label){
            $label = MenuContactus::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
        }
        $model->mess = $label->label_error_notNull;
        $model->messEmail = $label->label_error_email;

        if (isset($_POST['Contactus'])) {
            $model->contac_by_name = $_POST['Contactus'][contac_by_name];
            $model->contac_by_surname = $_POST['Contactus'][contac_by_surname];
            $model->contac_by_email = $_POST['Contactus'][contac_by_email];
            $model->contac_by_tel = $_POST['Contactus'][contac_by_tel];
            $model->contac_subject = $_POST['Contactus'][contac_subject];
            $model->contac_detail = $_POST['Contactus'][contac_detail];
            $model->contac_type = $_POST['Contactus'][contac_type];
            if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                $secret = '6LdMXXcUAAAAAK76NVqqh5qMv05wg2QxbHoSrJMc';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if ($responseData->success)$model->captcha = $responseData->success;
            }
            if($model->validate()){
                if ($model->save());
                $to = array();
                //$to['email'] = 'thaiparliamenthrd@gmail.com';//$model->contac_by_email;
                $to['email'] = 'kmutnb.elearning@gmail.com';
                $to['firstname'] = 'ผู้ดูแลระบบ';
                $to['lastname'] = '';
                $subject = 'ระบบปัญหาการใช้งาน เรื่อง  : ' . $model->contac_subject ;
                $message = 'จาก '.$model->contac_by_name.' '.$model->contac_by_surname.'<br>';
                $message .= 'เบอร์โทรศัพท์ :'.$model->contac_by_tel.'<br>';
                $message .= 'อีเมล์ :'.$model->contac_by_email.'<br>';
                $message .= 'รายละเอียด :'.$model->contac_detail.'<br>';
                // $mail = Helpers::lib()->SendMail($to, $subject, $message);
                // $this->redirect('index');
                // $this->render('index', array('label'=>$label));
                Yii::app()->user->setFlash('msg','ส่งข้อมูลไปยังผู้ดูแลระบบเรียบร้อย');
                Yii::app()->user->setFlash('icon','success');

                $labelSite = MenuSite::model()->find(array(
                        'condition' => 'lang_id=:lang_id',
                        'params' => array(':lang_id' => $langId)
                        ));
                if(!$labelSite){
                    $labelSite = MenuSite::model()->find(array(
                        'condition' => 'lang_id=:lang_id',
                        'params' => array(':lang_id' => 1)
                        ));
                }
                // $this->render('index', array('model' => $model,'check'=>'fit','label'=>$label));
                $this->redirect(array('site/index'),array('label'=>$labelSite));
            }else{
                Yii::app()->user->setFlash('contactus',$label->label_error_invalidData);
                //echo "<script>alert('$label->label_error_invalidData')</script>";
                // $this->redirect('index');
                
                $this->render('index', array('model' => $model,'check'=>'fit','label'=>$label));
            }

        }
        else {
            $this->render('index', array('model' => $model,'label'=>$label));
        }
    }

    //  if(!Yii::app()->user->isGuest){
    //     $user = User::model()->findByPk(Yii::app()->user->id);
    //     $profile = $user->profile;
    // } else {
    //     $user = new User;
    //     $profile = new Profile;
//        // }
//				if(isset($_POST['ajax']) && $_POST['ajax']==='contact_form')
//				{
//					echo CActiveForm::validate(array($model));
//					Yii::app()->end();
//				}
//        if(isset($_POST['ReportProblem']))
//        {
//            if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
//                $secret = '6LcnyBQUAAAAAC8QBbg9Ic3f0A9XUZSzv_fN-lsc';
//                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
//                $responseData = json_decode($verifyResponse);
//                if(!$responseData->success){
//                    Yii::app()->user->setFlash('captcha','ป้อน captcha ไม่ถูกต้อง');
//                    $this->redirect(array('/site/index'));
//                }
//            $model = new ReportProblem;
//            $model->attributes=$_POST['ReportProblem'];
//            if($_POST['ReportProblem']['tel'] != ''){
//                $model->tel = $_POST['ReportProblem']['tel'];
//            } else {
//                $model->tel = $_POST['ReportProblem']['tel2'];
//            }
//
//            if($_POST['ReportProblem']['report_type'] != ''){
//                $model->report_type = $_POST['ReportProblem']['report_type'];
//            } else {
//                $model->report_type = $_POST['ReportProblem']['report_type2'];
//            }
//            if($model->validate())
//            {
//                $uploadFile = CUploadedFile::getInstance($model,'file');
//                if(isset($uploadFile))
//                {
//                    $uglyName = strtolower($uploadFile->name);
//                    $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
//                    $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
//                    $model->report_pic = $beautifulName;
//                }
//            $model->report_date = date("Y-m-d H:i:s");
//                if($model->save()){
//                    if(isset($uploadFile))
//                        {
//                            /////////// SAVE IMAGE //////////
//                            Yush::init($model);
//                            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->report_pic);
//                            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->report_pic);
//                            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->report_pic);
//                            // Save the original resource to disk
//                            $uploadFile->saveAs($originalPath);
//
//                            // Create a small image
//                            $smallImage = Yii::app()->phpThumb->create($originalPath);
//                            $smallImage->resize(385, 220);
//                            $smallImage->save($smallPath);
//
//                            // Create a thumbnail
//                            $thumbImage = Yii::app()->phpThumb->create($originalPath);
//                            $thumbImage->resize(350, 200);
//                            $thumbImage->save($thumbPath);
//                        }
//                    Yii::app()->user->setFlash('contactus','ขอบคุณที่ติดต่อเรา');
//                        Yii::app()->user->setFlash('messages','เราจะติดต่อกลับไปหาท่านโดยเร็วที่สุด');
//                    $this->redirect(array('/site/index'));
//                }
//            }
//        } else {
//            Yii::app()->user->setFlash('captcha','กรุณาป้อน Captcha');
//            $this->redirect(array('/site/index'));
//        }
//        }
//        $this->render('index',array(
//            'model'=>$model,
//            'user' => $user,
//            'profile'=>$profile,
//        ));
//
//	}
    public function actionMessage($id=null)
    {

        $criteria = new CDbCriteria;
        $criteria->order = 't.create_date DESC';
        $criteria->addCondition('t.create_by ='.Yii::app()->user->id);
        $model = Contactus::model()->with('type','course')->findAll($criteria);
        if (!empty($id)) {
            $topic = Contactus::model()->findbyPK($id);

        }

        $this->render('message', array(
            'model'=>$model,
            'topic'=>$topic
            ));
    }


    public function UploadPic($model)
    {

         /////////// SAVE IMAGE //////////
        Yush::init($model);
        $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->contac_pic);
        $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->contac_pic);
        $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->contac_pic);
        
                           // Save the original resource to disk
        $test = $uploadFile->saveAs($originalPath);

                           // Create a small image
        $smallImage = Yii::app()->phpThumb->create($originalPath);
        $smallImage->resize(385, 220);
        $smallImage->save($smallPath);

                           // Create a thumbnail
        $thumbImage = Yii::app()->phpThumb->create($originalPath);
        $thumbImage->resize(350, 200);
        $thumbImage->save($thumbPath);

    }

    public function UploadFile($model,$uploadFile)
    {
        $tempSave = $uploadFile;
        $dirfolder = Yii::app()->basePath."/../uploads/contactus/".$model->contac_id;
        
        if (!is_dir($dirfolder)) {
            $fol = mkdir($dirfolder);
        }

        $Pathuploadfile = Yii::app()->basePath.'/../uploads/contactus/'.$model->contac_id.'/'.$model->contac_pic;
        if(!empty($tempSave))
        {
            $tempSave->saveAs($Pathuploadfile);
        }

    }

    public function actionDownloadfile($id)
    {
        $model = Contactus::model()->findbyPK($id);

        if(!empty($model->contac_pic))
        {
            $typefile = explode(".",  $model->contac_pic);
            $typeimage = array('jpg','png','jpeg');
            $typenoimg = array('pdf','zip','rar');
            $attfile = '';

            if(in_array($typefile[sizeof($typefile)-1], $typeimage)){
                echo Yii::app()->baseUrl.'/uploads/contactus/'.$model->contac_id.'/original/'.$model->contac_pic;
                // return Yii::app()->basePath.'/../uploads/contactus/'.$model->contac_id.'/original/'.$model->contac_pic;

            }elseif (in_array($typefile[sizeof($typefile)-1], $typenoimg)) {
                echo Yii::app()->basePath.'/../uploads/contactus/'.$model->contac_id.'/'.$model->contac_pic;
            }

        }
    }

}
