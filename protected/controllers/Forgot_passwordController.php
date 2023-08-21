<?php

class Forgot_passwordController extends Controller
{
    public function init()
    {
        parent::init();
        $this->lastactivity();
        
    }
	public function actionIndex()
	{
        $model = new Users();

        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
        }else{
            $langId = Yii::app()->session['lang'];
        }

        $label = MenuForgotpassword::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
                ));
        if(!$label){
            $label = MenuForgotpassword::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
                ));
         }
   
		$this->render('index',array('model'=>$model,'label'=>$label));
	}

    public function actionSendpassword(){
            if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
            }
            $email = $_POST['Users']['email'];
            // $finduserbymail = Users::model()->notsafe()->findbyattributes(array('email'=>$email));
             $finduserbymail = Users::model()->notsafe()->findByAttributes(array('email'=>$email));
            if(isset($finduserbymail)){
            // $href = Yii::app()->createAbsoluteUrl('forgot_password/Checkpassword',array('oldpassword'=> $finduserbymail->password));
            $href = Yii::app()->createAbsoluteUrl('forgot_password/Checkpassword',array('oldpassword'=> $finduserbymail->activkey));
            $to = array();
            $to['email'] = $email;
            $to['firstname'] = $finduserbymail->profile->firstname;
            $to['lastname'] = $finduserbymail->profile->lastname;
            $subject = 'ลืมรหัสผ่าน\ Reset Password';
            $message = 'ระบบรีเซ็ตรหัสผ่าน <br> สวัสดีคุณ '.$finduserbymail->profile->firstname.' '.$finduserbymail->profile->lastname.'<br><a href="'.$href.'">คลิกลิงค์เพื่อตั้งรหัสผ่านใหม่</a><br><br>Reset Password <br> Dear '.$finduserbymail->profile->firstname_en.' '.$finduserbymail->profile->lastname_en.'<br><a href="'.$href.'">Click link to reset your password</a>';

             try {
                 $send = Helpers::lib()->SendMail($to, $subject, $message);
             } catch (Exception $e) {
                Yii::app()->session['errorMessage'] = $e;
                Yii::app()->session['errorController'] = "Forgot_passwordController";
                Yii::app()->session['errorAction'] = "Sendpassword";
                Yii::app()->session['errorCode'] = "500";
                Yii::app()->session['errorParameter'] = json_encode(["email"=>$_POST['Users']['email']]);
                $this->redirect(array('error/index'));
             }
           // $send = Helpers::lib()->SendMailToUser($to, $subject, $message);

            // echo "<script>alert('ตรวจสอบ กล่องข้อความ');</script>"; 

            // $member = Helpers::lib()->ldapTms($finduserbymail->email);
            // if($member['count'] > 0){
            //     if($langId == 1){
            //         $msg = 'Please Check Your Email';
            //     }else{
            //         $msg = 'กรุณาตรวจสอบกล่องจดหมายในอีเมลล์ของท่าน';
            //     }   
            //     Yii::app()->user->setFlash('msg',$msg);
            //     Yii::app()->user->setFlash('icon','success');
            // }else{
            //     if($langId == 1){
            //         $msg = 'Please Check Your Email (Junk Mail)';
            //     }else{
            //         $msg = 'กรุณาตรวจสอบกล่องจดหมายในอีเมลล์ของท่าน(จดหมายขยะ)';
            //     } 
            //     Yii::app()->user->setFlash('msg',$msg);
            //     Yii::app()->user->setFlash('icon','warning');
            // }
            
          $this->redirect(array('site/index'));
            }else{
                $model = new Users();
                if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                    $langId = Yii::app()->session['lang'] = 1;
                }else{
                    $langId = Yii::app()->session['lang'];
                }

                $label = MenuForgotpassword::model()->find(array(
                        'condition' => 'lang_id=:lang_id',
                        'params' => array(':lang_id' => $langId)
                        ));
                if(!$label){
                    $label = MenuForgotpassword::model()->find(array(
                        'condition' => 'lang_id=:lang_id',
                        'params' => array(':lang_id' => 1)
                        ));
                 }
                Yii::app()->user->setFlash('msg','ไม่มี Email นี้อยู่ในระบบ');
                $this->render('index',array('model'=>$model,'label'=>$label));
            }
           
           
    }
    public function actionTest(){
        $to = array();
            $to['email'] = "jojo99za@gmail.com";
            $to['firstname'] = "Pornchai";
            $to['lastname'] = "Tippawan";
            $subject = 'ลืมรหัสผ่าน';
            $message = 'ระบบลืมรหัสผ่าน <br> สวัสดีคุณ '."Pornchai".' '."Tippawan".'<br>';

            $send = Helpers::lib()->SendMail($to, $subject, $message);
            var_dump($send);
    }
    // public function actionSendpassword()
    // {
    //     if(isset($_POST['Users']['email'])){ 
    //         $destination_email = $_POST['Users']['email']; 
    //         $finduserbymail = Users::model()->notsafe()->findbyattributes(array('email'=>$destination_email));
    //         // $this->renderPartial('Form_mail',array('finduserbymail'=> $finduserbymail));
    //         // exit();
    //         Yii::import('application.extensions.phpmailer.JPhpMailer'); 
    //         $mail = new JPhpMailer; 
    //         $mail->IsSMTP(); 
    //         $mail->SMTPAuth = true; 
    //         $mail->SMTPSecure = "ssl"; 
    //         $mail->SMTPKeepAlive = true; 
    //         $mail->Mailer = "smtp"; 
    //         $mail->SMTPDebug = 1; 
    //         $mail->Host = 'smtp.gmail.com'; // gmail server 
    //         $mail->Port = '465'; // port number 
    //         $mail->Username = ''; // User Email 
    //         $mail->Password = ''; // Pass Email 
    //         $mail->CharSet = 'utf-8'; 
    //         $mail->SetFrom('', ''); // ตอบกลับ 
    //         $mail->AddAddress($destination_email); // to destination 
    //         $mail->Subject = 'Test mail'; // subject หัวข้อจดหมาย 
    //         $mail->MsgHTML($this->renderPartial('Form_mail',array('finduserbymail'=> $finduserbymail))); // Message 
         
    //         if(!$mail->Send()) { 
    //             echo "<pre>"; 
    //             echo "Mailer Error: " . $mail->ErrorInfo; 
    //             exit(); 
    //         }else { 
    //             echo "<script>alert('Message sent!');</script>"; 
    //             $this->redirect(array('site/index'));
    //          } 
    //     }
    // }

    public function actionCheckpassword($oldpassword){
        $model = new Users();
        if(isset($_GET['oldpassword'])){
                    // $users = Users::model()->notsafe()->findbyattributes(array('password'=>$_GET['oldpassword']));
                    $users = Users::model()->notsafe()->findByAttributes(array('activkey'=>$_GET['oldpassword']));
                    // $password = $users->password;
                    $password = $users->activkey;
                    $oldpass = $_GET['oldpassword'];
                }
            if ($oldpass == $password) {
                $this->render('repass',array('users'=>$users,'model'=>$model));
            }else{
                $this->redirect(array('site/index'));
            }
            // echo "string";
            // exit();
        // $this->render('index',array('model'=>$model));
        }

    public function actionRepassword(){
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
            }
        $users = new Users();
        $savepass = Users::model()->findByAttributes(array('id'=>$_POST['Users'][id]));
        if (isset($_POST['Users'])) {
            $savepass->password = $_POST['Users']['password'];
            $savepass->verifyPassword = $_POST['Users']['verifyPassword'];
        }
            // if ($savepass->validate()) {
            $savepass->password = UserModule::encrypting($savepass->password);
            $savepass->verifyPassword = UserModule::encrypting($savepass->verifyPassword);
            
                if ($savepass->save(false)) {
                    if($langId == 1){
                        $status = "Reset Password Success";
                    }else{
                        $status = "เปลี่ยนรหัสผ่านสำเร็จ";
                    }
                    
                    Yii::app()->user->setFlash('msg',$status);
                    Yii::app()->user->setFlash('icon','success');
                    // $this->redirect(array('site/index','users' => $users));
                    $this->redirect(array('site/index'));
                } else {
                    var_Dump($savepass->getErrors());
                    exit();
                }
            // }else{
            //     var_dump($savepass->getErrors());
            //     exit();
            // }
        
    }

}
?>