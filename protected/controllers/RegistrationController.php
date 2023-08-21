<?php

class RegistrationController extends Controller
{
    public function init()
    {
        parent::init();
        $this->lastactivity();
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function resize_image($file, $destination, $w, $h)
    {
        //Get the original image dimensions + type
        list($source_width, $source_height, $source_type) = getimagesize($file);


        switch ($source_type) {
            case IMAGETYPE_GIF:
                $source_gdim = imagecreatefromgif($file);
                break;

            case IMAGETYPE_JPEG:
                $source_gdim = imagecreatefromjpeg($file);
                break;

            case IMAGETYPE_PNG:
                $source_gdim = imagecreatefrompng($file);
                break;
        }

        //Figure out if we need to create a new JPG, PNG or GIF
        //    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //    if ($ext == "jpg" || $ext == "jpeg") {
        //        $source_gdim=imagecreatefromjpeg($file);
        //    } elseif ($ext == "png") {
        //        $source_gdim=imagecreatefrompng($file);
        //    } elseif ($ext == "gif") {
        //        $source_gdim=imagecreatefromgif($file);
        //    } else {
        //        //Invalid file type? Return.
        //        return;
        //    }
        //If a width is supplied, but height is false, then we need to resize by width instead of cropping
        if ($w && !$h) {
            $ratio = $w / $source_width;
            $temp_width = $w;
            $temp_height = $source_height * $ratio;

            $desired_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $desired_gdim,
                $source_gdim,
                0,
                0,
                0,
                0,
                $temp_width,
                $temp_height,
                $source_width,
                $source_height
            );
        } elseif (!$w && $h) {
            $ratio = $h / $source_height;
            $temp_width = $source_width * $ratio;
            $temp_height = $h;

            $desired_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $desired_gdim,
                $source_gdim,
                0,
                0,
                0,
                0,
                $temp_width,
                $temp_height,
                $source_width,
                $source_height
            );
        } else {
            $source_aspect_ratio = $source_width / $source_height;
            $desired_aspect_ratio = $w / $h;

            if ($source_aspect_ratio > $desired_aspect_ratio) {
                /*
                 * Triggered when source image is wider
                 */
                $temp_height = $h;
                $temp_width = (int) ($h * $source_aspect_ratio);
            } else {
                /*
                 * Triggered otherwise (i.e. source image is similar or taller)
                 */
                $temp_width = $w;
                $temp_height = (int) ($w / $source_aspect_ratio);
            }

            /*
             * Resize the image into a temporary GD image
             */

            $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
            imagecopyresampled(
                $temp_gdim,
                $source_gdim,
                0,
                0,
                0,
                0,
                $temp_width,
                $temp_height,
                $source_width,
                $source_height
            );

            /*
             * Copy cropped region from temporary image into the desired GD image
             */

            $x0 = ($temp_width - $w) / 2;
            $y0 = ($temp_height - $h) / 2;
            $desired_gdim = imagecreatetruecolor($w, $h);
            imagecopy(
                $desired_gdim,
                $temp_gdim,
                0,
                0,
                $x0,
                $y0,
                $w,
                $h
            );
        }

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */


        switch ($source_type) {
            case IMAGETYPE_GIF:
                imagegif($desired_gdim, $destination);
                break;

            case IMAGETYPE_JPEG:
                imagejpeg($desired_gdim, $destination, 100);
                break;

            case IMAGETYPE_PNG:
                imagepng($desired_gdim, $destination);
                break;
        }

        //    if ($ext == "jpg" || $ext == "jpeg") {
        //        imagejpeg($desired_gdim,$destination.".jpg",100);
        //    } elseif ($ext == "png") {
        //        imagepng($desired_gdim,$destination.".png");
        //    } elseif ($ext == "gif") {
        //        imagegif($desired_gdim,$destination.".gif");
        //    } else {
        //        return;
        //    }

        imagedestroy($desired_gdim);
    }

    // public function actionGetAjaxDivision(){
    //     if(isset($_GET['company_id']) && $_GET['company_id'] != ""){
    //         $datalist = Division::model()->findAll('active = "y" and company_id = '.$_GET['company_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกกอง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->div_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบกอง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกกอง</option>";
    //     }
    // }

    // public function actionGetAjaxDepartment(){
    //     if(isset($_GET['division_id']) && $_GET['division_id'] != ""){
    //         $datalist = Department::model()->findAll('active = "y" and division_id = '.$_GET['division_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกแผนก</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->dep_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบแผนก</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกแผนก</option>";
    //     }
    // }

    // public function actionGetAjaxPosition(){
    //     if(isset($_GET['department_id']) && $_GET['department_id'] != ""){
    //         $datalist = Position::model()->findAll('active = "y" and department_id = '.$_GET['department_id']);
    //         if($datalist){
    //             echo "<option value=''> เลือกตำแหน่ง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->position_title."</option>";
    //             }
    //         }else{
    //             echo "<option value=''> ไม่พบตำแหน่ง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกตำแหน่ง</option>";
    //     }
    // }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    // public function actionReport_problem()
    //     {
    //         $model=new ReportProblem;

    //         if(isset($_POST['ReportProblem']))
    //         {
    //             $model->attributes=$_POST['ReportProblem'];
    //             if($model->save())
    //                 $this->redirect(array('index'));
    //         }

    //         $this->render('report_problem',array(
    //             'model'=>$model,
    //         ));
    //     }
    private function RandomPassword()
    {

        $number = "abcdefghijklmnopqrstuvwxyz0123456789";
        $i = '';
        $result = '';
        for ($i == 1; $i < 6; $i++) { // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
            $random = rand(0, strlen($number) - 1); //สุ่มตัวเลข
            $cut_txt = substr($number, $random, 1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
            $result .= substr($number, $random, 1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
            $number = str_replace($cut_txt, '', $number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
        }

        return $result;
    }

    public function actionShowForm()
    {

        $chk_status_reg = $SettingAll = Helpers::lib()->SetUpSetting();
        $chk_status_reg = $SettingAll['ACTIVE_REGIS'];
        if (!$chk_status_reg) {
            $this->redirect(array('site/index'));
        }
        $con = $_POST['status'];
        if ($con == '1') {
            $this->redirect(array('registration/index'));
        } elseif ($con == '2') {
            $this->redirect(array('site/index'));
        } else {
            if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                $langId = Yii::app()->session['lang'] = 1;
            } else {
                $langId = Yii::app()->session['lang'];
            }
            $model = Conditions::model()->find(array(
                'condition' => 'lang_id=:lang_id AND active=:active',
                'params' => array(':lang_id' => $langId, ':active' => 'y')
            ));

            $label = MenuRegistration::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if (!$label) {
                $label = MenuRegistration::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                ));
            }

            // $model = Conditions::model()->findbyPk(1);
            if (!empty($_POST)) {
                Yii::app()->user->setFlash('CheckQues', 'กรุณายืนยัน');
                Yii::app()->user->setFlash('checkClass', "warning");
            }
            $this->render('Con_regis', array('model' => $model, 'label' => $label));
        }
    }
    public function actionIndex()
    {
        $SettingAll = Helpers::lib()->SetUpSetting();

        $chk_status_email = $SettingAll['CONFIRM_MAIL'];

        $users = new User;
        $profile = new Profile;

        if (isset($_POST['Profile'])) {
            $profile->typeregis = $_POST['typeregis'];

            if ($_POST['typeregis'] == 1) {
                $users->identification = $_POST['idcard'];
                $profile->identification = $_POST['idcard'];
            } else {
                $users->identification = $_POST['passport'];
                $profile->identification = $_POST['passport'];
            }

            $users->username = $_POST['User'][username];


            $users->email = $_POST['User'][email] != "" ? $_POST['User'][email] : "ไม่ได้กรอก";

            $users->department_id = $_POST['User'][department_id];
            $users->password = $_POST['User'][password];
            $passwordshow = $_POST['User'][password];
            $users->verifyPassword = $_POST['User'][verifyPassword];

            $users->activkey = UserModule::encrypting(microtime() . $users->password);

            $users->repass_status = 0;
            $users->create_at = date("Y-m-d H:i:s");
            $users->type_register = 1;
            $users->face_regis = 0;

            if ($_POST['Profile']['prefix_th'] == "other") {
                $criteria = new CDbCriteria;
                $criteria->condition = 'prof_title=:prof_title';
                $criteria->params = array(':prof_title' => $_POST["Profile"]["prename_other_th"]);
                $protitle = ProfilesTitle::model()->find($criteria);
                if (!$protitle) {
                    $modelTitleTH = new ProfilesTitle;
                    $modelTitleTH->prof_title = $_POST["Profile"]["prename_other_th"];
                    $modelTitleTH->type = "other";
                    if ($modelTitleTH->save()) {
                        $profile->prefix_th = $modelTitleTH->prof_id;
                    }
                } else {
                    $profile->prefix_th = $protitle->prof_id;
                }
            } else {
                $profile->prefix_th = $_POST['Profile']['prefix_th'];
            }

            if ($_POST['Profile']['prefix_en'] == "other") {
                $criteria = new CDbCriteria;
                $criteria->condition = 'prof_title_en=:prof_title_en';
                $criteria->params = array(':prof_title_en' => $_POST["Profile"]["prename_other_en"]);
                $protitle = ProfilesTitle::model()->find($criteria);
                if (!$protitle) {
                    $modelTitleEN = new ProfilesTitle;
                    $modelTitleEN->prof_title_en = $_POST["Profile"]["prename_other_en"];
                    $modelTitleEN->type = "other";
                    if ($modelTitleEN->save()) {
                        $profile->prefix_en = $modelTitleEN->prof_id;
                    }
                } else {
                    $profile->prefix_en = $protitle->prof_id;
                }
            } else {
                $profile->prefix_en = $_POST['Profile']['prefix_en'];
            }

            $profile->firstname = $_POST['Profile']['firstname'];
            $profile->lastname = $_POST['Profile']['lastname'];
            $profile->firstname_en = $_POST['Profile']['firstname_en'];
            $profile->lastname_en = $_POST['Profile']['lastname_en'];
            if ($_POST['Profile']['birthday']) {
                $profile->birthday = Helpers::lib()->changeFormatsaveBirthday($_POST['Profile']['birthday']);
            }

            $profile->phone = $_POST['Profile']['phone'];
            $profile->address = $_POST['Profile']['address'];
            $profile->province = $_POST['Profile']['province'];
            $profile->district = $_POST['Profile']['district'];
            $profile->subdistrict = $_POST['Profile']['subdistrict'];
            $profile->zipcode = $_POST['Profile']['zipcode'];


            if ($profile->validate() && $users->validate()) {

                $users->password = UserModule::encrypting($users->password);
                $users->verifyPassword = UserModule::encrypting($users->verifyPassword);
            } else {

                if (!$users->validate()) {
                    $users->save();
                }
                $profile->birthday = $_POST['Profile']['birthday'];
                $profile->prefix_en = $_POST["Profile"]["prefix_en"];
                $profile->prename_other_en = $_POST["Profile"]["prename_other_en"];
                $profile->prefix_th = $_POST["Profile"]["prefix_th"];
                $profile->prename_other_th = $_POST["Profile"]["prename_other_th"];
                $this->render('index', array('profile' => $profile, 'users' => $users, 'typeregis' => $_POST['typeregis']));
                exit();
            }

            if ($users->save()) {

                if ($_FILES['file_photo']['tmp_name'] != "") {
                    $tempFile   = $_FILES['file_photo'];
                    $path = "users";
                    $base64_pic = $_POST["url_pro_pic"];
                    $filename = Helpers::lib()->uploadimagecroppie($tempFile, $path, $users->id, $base64_pic);
                    if ($filename) {
                        $profile->profile_picture = $filename;
                    }
                }

                $profile->user_id = $users->id;

                if ($profile->save()) {
                    Helpers::lib()->APIAuthenLmsRegister(
                        $users->id,
                        $users->username,
                        $_POST['User'][password],
                        $profile->firstname,
                        $profile->lastname,
                        $profile->identification,
                        'sercetAuthenMd'
                    );

                    Yii::app()->session['ptex'] = $passwordshow;
                    $this->redirect(array('/registration/condition/', 'id' => $users->id));

                    // if ($chk_status_email == 1) {

                    //     $to = array(
                    //      'email'=>$users->email,
                    //      'firstname'=>$profile->firstname,
                    //      'lastname'=>$profile->lastname,
                    //  );
                    //     $firstname = $profile->firstname;
                    //     $lastname = $profile->lastname;
                    //     $username = $users->username;
                    //     $firstname_en = $profile->firstname_en;
                    //     $lastname_en = $profile->lastname_en;

                    //     $message = $this->renderPartial('Form_mail',array('email'=>$users->email,'genpass'=>$passwordshow,'username'=>$username,'firstname'=>$firstname,'lastname'=>$lastname,'firstname_en'=>$firstname_en,'lastname_en'=>$lastname_en),true);

                    //     $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ\ Registered successfully',$message);

                    //     Yii::app()->user->setFlash('profile',$profile->identification);
                    //     Yii::app()->user->setFlash('msg', $users->email);
                    //     Yii::app()->user->setFlash('icon', "success");
                    //     $this->redirect(array('site/index'));

                    // }else{
                    //     $login = '1';
                    //     Yii::app()->user->setFlash('profile',$profile->identification);
                    //     Yii::app()->user->setFlash('msg', $users->email);
                    //     Yii::app()->user->setFlash('icon', "success");
                    //     $this->redirect(array('site/index'));
                    // }

                } else {
                    $profile->birthday = $_POST['Profile']['birthday'];
                    $profile->prefix_en = $_POST["Profile"]["prefix_en"];
                    $profile->prename_other_en = $_POST["Profile"]["prename_other_en"];
                    $profile->prefix_th = $_POST["Profile"]["prefix_th"];
                    $profile->prename_other_th = $_POST["Profile"]["prename_other_th"];
                    $this->render('index', array('profile' => $profile, 'users' => $users));
                }
            } else {
                $profile->birthday = $_POST['Profile']['birthday'];
                $profile->prefix_en = $_POST["Profile"]["prefix_en"];
                $profile->prename_other_en = $_POST["Profile"]["prename_other_en"];
                $profile->prefix_th = $_POST["Profile"]["prefix_th"];
                $profile->prename_other_th = $_POST["Profile"]["prename_other_th"];
                $this->render('index', array('profile' => $profile, 'users' => $users));
            }
        }
        $this->render('index', array('profile' => $profile, 'users' => $users));
    }



    public function actionCondition($id)
    {

        if (isset($_POST['status'])) {

            $status = $_POST['status'];
            $user_id = $_POST['UserId'];
            if ($status == 1) {
                $this->redirect(array('/registration/idcardverification/', 'id' => $user_id));
            } else {

                $users = Users::model()->findByPk($user_id);
                $getprofile = Profile::model()->findByPk($id);

                if ($users) {
                    $users->delete();
                }
                if ($getprofile) {
                    $getprofile->delete();
                }

                $msg = "สมัครสมาชิกไม่สำเร็จ";
                Yii::app()->user->setFlash('msg', $msg);
                Yii::app()->user->setFlash('icon', 'warning');
                $this->redirect(array('site/index'));
            }
        }

        $this->render('condition', array('users_id' => $id));
    }

    public function actionIdCardVerification($id, $typ = null)
    {

        $getprofile = Profile::model()->findByPk($id);
        $profile = $getprofile->firstname;
        if (isset($_FILES["fileidcard"])) {

            $user_id = $_POST['UserId'];
            // $data = $_POST['idcard'];

            //    list($type, $data) = explode(';', $data);
            //    list(, $data)      = explode(',', $data);
            //    $data = base64_decode($data);

            $path = 'uploads/IdCard/';
            $file_name = $id;
            $file_extension = '.jpg';
            $full_path = $path . $file_name . $file_extension;

            $checkSaveImage = file_put_contents($full_path, file_get_contents($_FILES["fileidcard"]["tmp_name"]));
            if ($checkSaveImage) {
                $result =  Helpers::lib()->ApiFaceIdCard($id);
            } else {
                $msg = "ไม่สามารถบันทึกรูปภาพได้ กรุณาลองอีกครั้ง";
                Yii::app()->user->setFlash('msg', $msg);
                Yii::app()->user->setFlash('icon', 'warning');

                $this->redirect(array('/registration/idcardverification/', 'id' => $id));
            }

            if ($result != "success") {
                $msg = "รูปภาพไม่ถูกต้องตามเงื่อนไข กรุณาลองอีกครั้ง";
                Yii::app()->user->setFlash('msg', $msg);
                Yii::app()->user->setFlash('icon', 'warning');

                $this->redirect(array('/registration/idcardverification/', 'id' => $id));
            } else {

                if ($typ == 'lgn') {
                    $this->redirect(array('/registration/faceregister/', 'id' => $user_id, 'typ' => $typ));
                } else {
                    $this->redirect(array('/registration/faceregister/', 'id' => $user_id));
                }
            }
        }

        $this->render('IdCard', array('users_id' => $id, 'profile' => $profile));
    }


    public function actionFaceRegister($id, $typ = null)
    {
        $getprofile = Profile::model()->findByPk($id);
        $profile = $getprofile->firstname;

        if (isset($_FILES["face_image_1"]) && isset($_FILES["face_image_2"]) && isset($_FILES["face_image_3"])) {

            // $result =  Helpers::lib()->ApiFaceImage($id, $_FILES, "register", "FaceIdCard");
            // $result != "success"
            if (false) {
                $getprofile->face_amount = $getprofile->face_amount + 1;
                $getprofile->save();

                if ($getprofile->face_amount >= 3) {

                    $getprofile->face_amount = 0;
                    $getprofile->save();

                    $msg = "การตรวจจับไม่สำเร็จ! กรุณาตรวจสอบความชัดเจนและอัพโหลดภาพบัตรประชาชนอีกครั้ง";
                    Yii::app()->user->setFlash('msg', $msg);
                    Yii::app()->user->setFlash('icon', 'warning');
                    $this->redirect(array('/registration/idcardverification/', 'id' => $id));
                }

                // if ($result == "fake") {
                //     $msg = "การตรวจสอบใบหน้าไม่ถูกต้อง ระบบตรวจสอบพบว่าไม่ใช่การถ่ายภาพตามเงื่อนไขที่กำหนด กรุณาถ่ายภาพใหม่อีกครั้งให้ถูกต้องตามเงื่อนไข";
                // } else {
                //     $msg = "ไม่สามารถตรวจจับใบหน้าของคุณได้ กรุณาลองอีกครั้ง";
                // }

                Yii::app()->user->setFlash('msg', $msg);
                Yii::app()->user->setFlash('icon', 'warning');
                $this->render('FaceRegister', array('users_id' => $id, 'profile' => $profile));
                exit();
            } else {
                $getprofile->face_amount = 0;
                $getprofile->save();

                $user_id = $_POST['UserId'];
                $path = 'uploads/FaceRegis/';
                $file_name = $id;
                $file_extension = '.jpg';
                $full_path = $path . $file_name . $file_extension;

                $checkSaveImage = file_put_contents($full_path, file_get_contents($_FILES["face_image_1"]["tmp_name"]));

                if (!$checkSaveImage) {
                    $msg = "ไม่สามารถบันทึกรูปภาพได้ กรุณาลองอีกครั้ง";
                    Yii::app()->user->setFlash('msg', $msg);
                    Yii::app()->user->setFlash('icon', 'warning');
                    $this->render('FaceRegister', array('users_id' => $id, 'profile' => $profile));
                    exit();
                }

                $users = Users::model()->notsafe()->findByPk($user_id);
                $users->face_regis = 1;
                $users->save(false);

                if ($typ == 'lgn') {
                    Yii::app()->user->setFlash('msg', 'กรุณา Login ใหม่อีกครั้ง');
                    Yii::app()->user->setFlash('icon', "success");
                    $this->redirect(array('site/login'));
                }


                $SettingAll = Helpers::lib()->SetUpSetting();
                $chk_status_email = $SettingAll['CONFIRM_MAIL'];

                if ($chk_status_email == 1) {

                    $to = array(
                        'email' => $users->email,
                        'firstname' => $profile->firstname,
                        'lastname' => $profile->lastname,
                    );
                    $firstname = $profile->firstname;
                    $lastname = $profile->lastname;
                    $username = $users->username;
                    $firstname_en = $profile->firstname_en;
                    $lastname_en = $profile->lastname_en;

                    $passwordshow = Yii::app()->session['ptex'];
                    Yii::app()->session['ptex'] = null;

                    $message = $this->renderPartial('Form_mail', array('email' => $users->email, 'genpass' => $passwordshow, 'username' => $username, 'firstname' => $firstname, 'lastname' => $lastname, 'firstname_en' => $firstname_en, 'lastname_en' => $lastname_en), true);

                    $mail = Helpers::lib()->SendMail($to, 'สมัครสมาชิกสำเร็จ\ Registered successfully', $message);

                    Yii::app()->user->setFlash('profile', $profile->identification);
                    Yii::app()->user->setFlash('msg', $users->email);
                    Yii::app()->user->setFlash('icon', "success");
                    $this->redirect(array('site/login'));
                } else {
                    $login = '1';
                    Yii::app()->user->setFlash('profile', $profile->identification);
                    Yii::app()->user->setFlash('msg', $users->email);
                    Yii::app()->user->setFlash('icon', "success");
                    $this->redirect(array('site/login'));
                }
            }
        }

        $this->render('FaceRegister', array('users_id' => $id, 'profile' => $profile));
    }


    public function actionUpdate()
    {

        $SettingAll = Helpers::lib()->SetUpSetting();

        $chk_status_email = $SettingAll['CONFIRM_MAIL'];

        if (Yii::app()->user->id) {
            $users = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
            $profile = $users->profile;
        }

        if ($profile->birthday != null) {
            $birthday = date_format(date_create($profile->birthday), "d-m-Y");
        } else {
            $birthday = null;
        }
        $passOld = $users->password;
        $userOld = $users->username;


        if (isset($_POST['Profile'])) {

            $profile->typeregis = $_POST['typeregis'];

            if ($_POST['typeregis'] == 1) {
                $users->identification = $_POST['idcard'];
                $profile->identification = $_POST['idcard'];
            } else {
                $users->identification = $_POST['passport'];
                $profile->identification = $_POST['passport'];
            }

            $users->username = $userOld;

            $users->email = $_POST['User'][email] != "" ? $_POST['User'][email] : "ไม่ได้กรอก";

            $users->department_id = $_POST['User'][department_id];

            $users->password = $passOld;
            $users->verifyPassword = $passOld;

            $profile->prefix_th = $_POST['Profile']['prefix_th'];
            $profile->prefix_en = $_POST['Profile']['prefix_en'];
            $profile->firstname = $_POST['Profile']['firstname'];
            $profile->lastname = $_POST['Profile']['lastname'];
            $profile->firstname_en = $_POST['Profile']['firstname_en'];
            $profile->lastname_en = $_POST['Profile']['lastname_en'];
            if ($_POST['Profile']['birthday']) {
                $profile->birthday = Helpers::lib()->changeFormatsaveBirthday($_POST['Profile']['birthday']);
            }

            $profile->phone = $_POST['Profile']['phone'];

            $profile->address = $_POST['Profile']['address'];
            $profile->province = $_POST['Profile']['province'];
            $profile->district = $_POST['Profile']['district'];
            $profile->subdistrict = $_POST['Profile']['subdistrict'];
            $profile->zipcode = $_POST['Profile']['zipcode'];


            if ($profile->validate() && $users->validate()) {

                $users->password = $users->password;
                $users->verifyPassword = $users->verifyPassword;
            } else {

                if (!$users->validate()) {
                    $users->save();
                }
                $profile->birthday = $_POST['Profile']['birthday'];
                $this->render('index', array('profile' => $profile, 'users' => $users));
                exit();
            }

            if ($users->save()) {

                if ($_FILES['file_photo']['tmp_name'] != "") {
                    $tempFile   = $_FILES['file_photo'];
                    $path = "users";
                    $base64_pic = $_POST["url_pro_pic"];
                    $filename = Helpers::lib()->uploadimagecroppie($tempFile, $path, $users->id, $base64_pic);
                    if ($filename) {
                        $profile->profile_picture = $filename;
                    }
                }

                $profile->user_id = $users->id;

                if ($profile->save()) {

                    Yii::app()->session['ptex'] = $passwordshow;

                    $msg = "แก้ไขข้อมูลส่วนตัวสำเร็จ";
                    Yii::app()->user->setFlash('msg', $msg);
                    Yii::app()->user->setFlash('icon', 'success');

                    $this->redirect(array('site/index'));
                } else {
                    $profile->birthday = $_POST['Profile']['birthday'];
                    $this->render('index', array('profile' => $profile, 'users' => $users));
                }
            } else {
                $profile->birthday = $_POST['Profile']['birthday'];
                $this->render('index', array('profile' => $profile, 'users' => $users));
            }
        }

        $profile->birthday = $birthday;

        $this->render('index', array('profile' => $profile, 'users' => $users));
    }

    /**
     * This is the action to handle external exceptions.
     */

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionRepassword()
    {

        if (User::model()->findbyPk(Yii::app()->user->id)->repass_status == '0') {
            $model = new Users();
            if (isset($_POST['Users'])) {

                // $user = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                $model = Users::model()->findbyattributes(array('id' => Yii::app()->user->id));
                // var_dump($model);
                $model->password = $_POST['Users']['password'];
                $model->verifyPassword = $_POST['Users']['verifyPassword'];
                // var_dump($model->save());
                // var_dump($model->getErrors());
                // exit();
                if ($model->validate()) {

                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->repass_status = 1;

                    if ($model->save(false)) {

                        $status = "เปลี่ยนรหัสผ่านสำเร็จ";
                        $type_status = "success";
                    } else {
                        $status = "เปลี่ยนรหัสผ่าน ไม่สำเร็จ";
                        $type_status = "error";
                    }
                    //$this->redirect(array('site/index','status' => $status,'type_status'=> $type_status));
                    $this->redirect(array('site/index'));
                }
            }
            $this->render('repassword', array('model' => $model));
        } else {
            $this->redirect(array('site/index'));
        }
    }
    public function actionCheckMail()
    {

        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email' => $_POST['text_mail']);
        $model = Users::model()->findAll($criteria);
        if ($model != null) {
            $data = false;
            echo ($data);
        } else {
            $data = true;
            echo ($data);
        }
    }

    public function actionCheckPassport()
    {

        $criteria = new CDbCriteria;
        $criteria->condition = 'passport=:passport';
        $criteria->params = array(':passport' => $_POST['text_passport']);
        $model = Profile::model()->findAll($criteria);
        if ($model != null) {
            $data = false;
            echo ($data);
        } else {
            $data = true;
            echo ($data);
        }
    }

    public function actionCheckIdcard()
    {
        $str = $_POST['idcard'];
        $chk = strlen($str);
        if ($chk == "13") {
            $id = str_split(str_replace('-', '', $_POST['idcard'])); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
            $sum = 0;
            $total = 0;
            $digi = 13;
            for ($i = 0; $i < 12; $i++) {
                $sum = $sum + (intval($id[$i]) * $digi);
                $digi--;
            }
            $total = (11 - ($sum % 11)) % 10;
            if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
                //  $this->addError('identification', 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์*');
                $data = 'no';
                echo ($data);
            } else {
                $criteria = new CDbCriteria;
                $criteria->condition = 'user.identification=:identification';
                $criteria->params = array(':identification' => $str);
                $model = Users::model()->findAll($criteria);
                foreach ($model as $key_u => $value_u) {
                    $profile_chk = Profile::model()->findByPk($value_u->id);
                    if ($profile_chk == "") {
                        $addlog = new LogUsers;
                        $addlog->controller = "Registration";
                        $addlog->action = "CheckIdcardDelUser";
                        $addlog->parameter = $str;
                        $addlog->user_id = $value_u->id;
                        $addlog->create_date = date("Y-m-d H:i:s");
                        $addlog->save(false);

                        $Users_del = Users::model()->findByPk($value_u->id);
                        $Users_del->delete();
                    }
                }
                $criteria = new CDbCriteria;
                $criteria->condition = 'user.identification=:identification';
                $criteria->params = array(':identification' => $str);
                $model = Users::model()->findAll($criteria);

                if ($model) {
                    $data = 'yes';
                    echo ($data);
                } else {
                    $data = 'bool';
                    echo ($data);
                }
            }
        } else {
            $data = 'little';
            echo ($data);
        }
    }

    public function actionLoadDistrict()
    {
        $pv_id  = $_POST["pv_id"];
        $criteria = new CDbCriteria;
        $criteria->compare('pv_id', $pv_id);
        $criteria->order = 'dt_name_th  ASC';
        $data = District::model()->findAll($criteria);

        $datalist = CHtml::listdata($data, 'dt_id', 'dt_name_th');
        echo "<option value=''> เลือกอำเภอ </option>";
        foreach ($datalist as $value => $District) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($District), true);
        }
    }

    public function actionLoadSubdistrict()
    {
        $dt_id  =  $_POST["dt_id"];
        $criteria = new CDbCriteria;
        $criteria->compare('dt_id', $dt_id);
        $criteria->order = 'sdt_name_th  ASC';
        $data = Subdistrict::model()->findAll($criteria);

        $datalist = CHtml::listdata($data, 'sdt_id', 'sdt_name_th');
        echo "<option value=''> เลือกตำบล </option>";
        foreach ($datalist as $value => $Subdistrict) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($Subdistrict), true);
        }
    }

    public function actionLoadZipcode()
    {
        $sdt_id  =  $_POST["sdt_id"];
        $data = Subdistrict::model()->findByAttributes(array('sdt_id' => $sdt_id));
        echo $data->zipcode;
    }


    public function actionLoadIdcard()
    {
        $id_card  =  $_POST["id_card"];
        $criteria = new CDbCriteria;
        $criteria->compare('NationalId', $id_card);
        $data = Trainee::model()->find($criteria);

        $return_arr[] = array(
            "FirstNameTh" => $data->FirstNameTh,
            "LastNameTh" => $data->LastNameTh,
            "FirstNameEn" => $data->FirstNameEn,
            "LastNameEn" => $data->LastNameEn,
            "DateOfBirth" => date_format(date_create($data->DateOfBirth), "d-m-Y"),
            "TelNumber" => $data->TelNumber,
            "Email" => $data->Email,
            "Passport" => $data->PassportId,
        );

        echo json_encode($return_arr);
    }

    public function actionLoadPassport()
    {
        $passport  =  $_POST["passport"];
        $criteria = new CDbCriteria;
        $criteria->compare('PassportId', $passport);
        $data = Trainee::model()->find($criteria);

        if ($data) {
            $return_arr[] = array(
                "status" => true,
                "FirstNameTh" => $data->FirstNameTh,
                "LastNameTh" => $data->LastNameTh,
                "FirstNameEn" => $data->FirstNameEn,
                "LastNameEn" => $data->LastNameEn,
                "DateOfBirth" => date_format(date_create($data->DateOfBirth), "d-m-Y"),
                "TelNumber" => $data->TelNumber,
                "Email" => $data->Email,
                "idCard" => $data->NationalId,
            );
        } else {
            $return_arr[] = array(
                "status" => false,
            );
        }

        echo json_encode($return_arr);
    }


    public function actionCalculateBirthday()
    {
        $birthdays = $_POST['item'];
        $Current = date('d-m-Y');
        $birthdayn = explode("-", $birthdays);
        $Current = explode("-", $Current);

        if ($birthdayn[2] < $Current[2]) {

            $birthday = $birthdayn[2] . '-' . $birthdayn[1] . '-' . $birthdayn[0];
            $dob = new DateTime($birthday);
            $now = new DateTime();

            $difference = $now->diff($dob);

            $age = $difference->y;
            $mouth = $difference->m;
            $day = $difference->d;

            $data = $difference->y . '-' . $difference->m . '-' . $difference->d;
            echo $data;
        } else {
            echo (0);
        }
    }


    public function actionCreateByApp()
    {

        // $_POST = array(
        //     'type_regis' => 1,
        //     'identity_number_passport' => 3049484291117,
        //     'prefix_en' => null,
        //     'first_name_en' => "testcreateFirst",
        //     'last_name_en' => "testcreateLast",
        //     'prefix_th' => null,
        //     'first_name_th' => "ทดสอบ",
        //     'last_name_th' => "ทดสอบสร้าง",
        //     'email' => "testcreate@gmail.com",
        //     'telephone_number' => "01234567890",
        //     'birth_day' => "18-09-2022",
        //     'address' => "222/33",
        //     'province' => 35,
        //     'district' => 480,
        //     'sub_district' => 3821,
        //     'zip_code' => 46160,
        //     'username' => "testcreate",
        //     'password' => "testcreate123",
        //     'verify_password' => "testcreate123",
        // );


        $SettingAll = Helpers::lib()->SetUpSetting();
        $chk_status_email = $SettingAll['CONFIRM_MAIL'];

        $users = new User;
        $profile = new Profile;

        if (isset($_POST)) {
            $profile->typeregis = $_POST['type_regis'];
            if ($_POST['type_regis'] == 1) {
                $users->identification = $_POST['identity_number_passport'];
                $profile->identification = $_POST['identity_number_passport'];
            } else {
                $users->identification = $_POST['identity_number_passport'];
                $profile->identification = $_POST['identity_number_passport'];
            }

            $users->username = $_POST['username'];
            $users->email = $_POST['email'];

            $users->department_id = $_POST['department_id']; // null ไว้
            $users->password = $_POST['password'];
            // $passwordshow = $_POST['password'];
            $users->verifyPassword = $_POST['verify_password'];

            $users->activkey = UserModule::encrypting(microtime() . $users->password);

            $users->repass_status = 0;
            $users->create_at = date("Y-m-d H:i:s");
            $users->type_register = 1;
            $users->face_regis = 0;

            if (isset($_POST['prefix_other_en']) && $_POST['prefix_other_en'] != null && $_POST['prefix_other_en'] != "") {
                $criteria = new CDbCriteria;
                $criteria->condition = 'prof_title_en=:prof_title_en';
                $criteria->params = array(':prof_title_en' => trim($_POST["prefix_other_en"]));
                $protitle = ProfilesTitle::model()->find($criteria);
                if (!$protitle) {
                    $modelTitleEN = new ProfilesTitle;
                    $modelTitleEN->prof_title_en = trim($_POST["prefix_other_en"]);
                    $modelTitleEN->type = "other";
                    if ($modelTitleEN->save()) {
                        $profile->prefix_en = $modelTitleEN->prof_id;
                    }
                } else {
                    $profile->prefix_en = $protitle->prof_id;
                }
            } else {
                $profile->prefix_en = trim($_POST['prefix_en']);
            }

            if (isset($_POST['prefix_other_th']) && $_POST['prefix_other_th'] != null && $_POST['prefix_other_th'] != "") {
                $criteria = new CDbCriteria;
                $criteria->condition = 'prof_title=:prof_title';
                $criteria->params = array(':prof_title' => trim($_POST["prefix_other_th"]));
                $protitle = ProfilesTitle::model()->find($criteria);
                if (!$protitle) {
                    $modelTitleTH = new ProfilesTitle;
                    $modelTitleTH->prof_title = trim($_POST["prefix_other_th"]);
                    $modelTitleTH->type = "other";
                    if ($modelTitleTH->save()) {
                        $profile->prefix_th = $modelTitleTH->prof_id;
                    }
                } else {
                    $profile->prefix_th = $protitle->prof_id;
                }
            } else {
                $profile->prefix_th = $_POST['prefix_th'];
            }


            $profile->firstname = $_POST['first_name_th'];
            $profile->lastname = $_POST['last_name_th'];
            $profile->firstname_en = $_POST['first_name_en'];
            $profile->lastname_en = $_POST['last_name_en'];
            if ($_POST['birth_day']) {
                $profile->birthday = Helpers::lib()->changeFormatsaveBirthday($_POST['birth_day']);
            }

            $profile->phone = $_POST['telephone_number'];
            $profile->address = $_POST['address'];
            $profile->province = $_POST['province'];
            $profile->district = $_POST['district'];
            $profile->subdistrict = $_POST['sub_district'];
            $profile->zipcode = $_POST['zip_code'];

            if ($profile->validate() && $users->validate()) {
                $users->password = UserModule::encrypting($users->password);
                $users->verifyPassword = UserModule::encrypting($users->verifyPassword);
            } else {
                $result['success'] = false;
                $errorsProfile = $profile->errors;
                $errorsUser = $users->errors;
                if (count($errorsUser) > 0) {
                    $i = 0;
                    $len = count($errorsUser);
                    foreach ($errorsUser as $key => $value) {
                        if ($i == $len - 1) {
                            $result['message'] .= $value[0];
                        } else {
                            $result['message'] .= $value[0] . ',';
                        }
                        $i++;
                    }
                } else {
                    if (count($errorsProfile) > 0) {
                        $i = 0;
                        $len = count($errorsProfile);
                        foreach ($errorsProfile as $key => $value) {
                            if ($i == $len - 1) {
                                $result['message'] .= $value[0];
                            } else {
                                $result['message'] .= $value[0] . ',';
                            }
                            $i++;
                        }
                    }
                }
                echo json_encode($result);
                exit();
            }
            if ($users->save()) {
                foreach ($_FILES as $key => $file) {
                    if ($key == 'profile') {
                        $tempFile   = $_FILES[$key];
                        $path = "users";

                        $type = pathinfo($_FILES[$key]["tmp_name"], PATHINFO_EXTENSION);
                        $data = file_get_contents($_FILES[$key]["tmp_name"]);
                        $base64_pic = 'data:image/' . $type . ';base64,' . base64_encode($data);

                        $filename = Helpers::lib()->uploadimagecroppie($tempFile, $path, $users->id, $base64_pic);
                        if ($filename) {
                            $profile->profile_picture = $filename;
                        } else {
                            $result['success'] = false;
                            $result['message'] = 'Image cannot be saved.';
                            echo json_encode($result);
                            exit();
                        }
                    } else {
                        if ($key == 'face_register') {
                            $path = 'uploads/FaceRegis/';
                        } else if ($key == 'identity_number_image') {
                            $path = 'uploads/IdCard/';
                        }

                        $file_name = $users->id;
                        $file_extension = '.jpg';
                        $full_path = $path . $file_name . $file_extension;
                        $success = file_put_contents($full_path, file_get_contents($_FILES[$key]["tmp_name"]));
                        if (!$success) {
                            $result['success'] = false;
                            $result['message'] = 'Image cannot be saved.';
                            echo json_encode($result);
                            exit();
                        }
                    }
                }


                $profile->user_id = $users->id;
                if ($profile->save()) {
                    Helpers::lib()->APIAuthenLmsRegister(
                        $users->id,
                        $users->username,
                        $_POST['password'],
                        $profile->firstname,
                        $profile->lastname,
                        $profile->identification,
                        'sercetAuthenMd'
                    );

                    $result['success'] = true;
                    $result['message'] = 'Successful save.';
                    echo json_encode($result);
                    // exit();

                    // Yii::app()->session['ptex'] = $passwordshow;
                    // $this->redirect(array('/registration/condition/', 'id' => $users->id));

                    // if ($chk_status_email == 1) {

                    //     $to = array(
                    //      'email'=>$users->email,
                    //      'firstname'=>$profile->firstname,
                    //      'lastname'=>$profile->lastname,
                    //  );
                    //     $firstname = $profile->firstname;
                    //     $lastname = $profile->lastname;
                    //     $username = $users->username;
                    //     $firstname_en = $profile->firstname_en;
                    //     $lastname_en = $profile->lastname_en;

                    //     $message = $this->renderPartial('Form_mail',array('email'=>$users->email,'genpass'=>$passwordshow,'username'=>$username,'firstname'=>$firstname,'lastname'=>$lastname,'firstname_en'=>$firstname_en,'lastname_en'=>$lastname_en),true);

                    //     $mail = Helpers::lib()->SendMail($to,'สมัครสมาชิกสำเร็จ\ Registered successfully',$message);

                    //     Yii::app()->user->setFlash('profile',$profile->identification);
                    //     Yii::app()->user->setFlash('msg', $users->email);
                    //     Yii::app()->user->setFlash('icon', "success");
                    //     $this->redirect(array('site/index'));

                    // }else{
                    //     $login = '1';
                    //     Yii::app()->user->setFlash('profile',$profile->identification);
                    //     Yii::app()->user->setFlash('msg', $users->email);
                    //     Yii::app()->user->setFlash('icon', "success");
                    //     $this->redirect(array('site/index'));
                    // }

                }
            }
        }
    }

    public function actionfilterListToApp()
    {
        // $language = $_POST['language'] ;
        $obj = json_decode(file_get_contents('php://input'));
        if (trim($obj->lang) == 'th' || !isset($obj->lang)) {
            $prefix_th_list = Yii::app()->db->createCommand()
                ->select('prof_id,prof_title')
                ->from('tbl_profiles_title')
                ->where('type = "main"')
                ->order('prof_id ASC')
                ->queryAll();

            $province_th_list = Yii::app()->db->createCommand()
                ->select('pv_id,pv_name_th as pv_name')
                ->from('tbl_province')
                ->order('pv_id ASC')
                ->queryAll();

            $district_th_list = Yii::app()->db->createCommand()
                ->select('dt_id,dt_name_th as dt_name,pv_id')
                ->from('tbl_district')
                ->where('dt_name_th IS NOT NULL')
                ->order('dt_id ASC')
                ->queryAll();

            $sub_district_th_list = Yii::app()->db->createCommand()
                ->select('sdt_id,sdt_name_th as sdt_name,dt_id,zipcode as zip_code')
                ->from('tbl_subdistrict')
                ->where('sdt_name_th IS NOT NULL')
                ->order('sdt_id ASC')
                ->queryAll();

            $result['prefix_list']  = $prefix_th_list;
            $result['province_list']  = $province_th_list;
            $result['district_list']  = $district_th_list;
            $result['sub_district_list']  = $sub_district_th_list;
        } else {

            $prefix_en_list = Yii::app()->db->createCommand()
                ->select('prof_id,prof_title_en as prof_title')
                ->from('tbl_profiles_title')
                ->where('type = "main"')
                ->order('prof_id ASC')
                ->queryAll();

            $province_en_list = Yii::app()->db->createCommand()
                ->select('pv_id,pv_name_en as pv_name')
                ->from('tbl_province')
                ->order('pv_id ASC')
                ->queryAll();

            $district_en_list = Yii::app()->db->createCommand()
                ->select('dt_id,dt_name_en as dt_name,pv_id')
                ->from('tbl_district')
                ->where('dt_name_en IS NOT NULL')
                ->order('dt_id ASC')
                ->queryAll();

            $sub_district_en_list = Yii::app()->db->createCommand()
                ->select('sdt_id,sdt_name_en as sdt_name ,dt_id,zipcode as zip_code')
                ->from('tbl_subdistrict')
                ->where('sdt_name_en IS NOT NULL')
                ->order('sdt_id ASC')
                ->queryAll();

            $result['prefix_list']  = $prefix_en_list;
            $result['province_list']  = $province_en_list;
            $result['district_list']  = $district_en_list;
            $result['sub_district_list']  = $sub_district_en_list;
        }

        echo json_encode($result);
    }
}
