<?php

class RegistrationController extends Controller
{
    public $defaultAction = 'registration';

    /**
     * Registration user
     */
    public function actionIndex()
    {
        var_dump("TEST");
        exit();
    }

    public function actionSub_category()
    {
        $data = OrgChart::model()->findAll('parent_id=:parent_id',
            array(':parent_id' => (int)$_POST['orgchart_lv2']));

        $data = CHtml::listData($data, 'id', 'title');
        echo CHtml::tag('option',
            array('value' => ''), "---แผนก---", true);
        foreach ($data as $value => $name) {
            echo CHtml::tag('option',
                array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionDivision()
    {
        $data = Division::model()->findAll('company_id=:company_id',
            array(':company_id' => (int)$_POST['company_id']));
        $options[] = CHtml::tag('option',
            array('value' => ''), "---เลือกศูนย์/แผนก---", true);
        $data = CHtml::listData($data, 'id', 'div_title');
        foreach ($data as $value => $name) {
            $options[] = CHtml::tag('option',
                array('value' => $value), CHtml::encode($name), true);
        }

        $data1 = Position::model()->findAll('company_id=:company_id',
            array(':company_id' => (int)$_POST['company_id']));
        $options1[] = CHtml::tag('option',
            array('value' => ''), "---เลือกตำแหน่ง---", true);
        $data1 = CHtml::listData($data1, 'id', 'position_title');
        foreach ($data1 as $value => $name) {
            $options1[] = CHtml::tag('option',
                array('value' => $value), CHtml::encode($name), true);
        }

        echo json_encode(array("data_dsivision" => $options, 'data_position' => $options1));
    }

    public function LoadDivision($company_id)
    {
        $data = Division::model()->findAll('company_id=:company_id',
            array(':company_id' => $company_id)
        );

        $data = CHtml::listData($data, 'id', 'div_title');

        return $data;
    }

    public function actionRegistration()
    {

        $gen = Generation::model()->find('active=1');

        $Setting = Setting::model()->find();


        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;

        $activeRegis = $Setting->settings_register;

        $check = false;
        if ($gen) {
            $start_date = $gen->start_date;
            $end_date = $gen->end_date;
            $current_date = date("Y-m-d");
            if ($current_date >= $start_date) {
                if ($current_date <= $end_date) {
                    $check = true;
                    $msg = 'หมดระยะเวลาสมัคร';
                }
            }
        } else {
            $msg = 'ปิดการสมัครรุ่น';
        }

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }

        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->controller->module->profileUrl);
        } else {
            if ((isset($_POST['RegistrationForm']) && $check)) {

                $model->attributes = $_POST['RegistrationForm'];
                $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                    $secret = '6LcnyBQUAAAAAC8QBbg9Ic3f0A9XUZSzv_fN-lsc';
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                    $responseData = json_decode($verifyResponse);
                    if (!$responseData->success) {
                        Yii::app()->user->setFlash('captcha', 'ป้อน captcha ไม่ถูกต้อง');
                        $this->redirect(array('/user/registration'));
                    }
                    if ($model->validate() && $profile->validate()) {
                        $soucePassword = $model->password;
                        $model->activkey = UserModule::encrypting(microtime() . $model->password);
                        $model->password = UserModule::encrypting($model->password);
                        $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                        $model->superuser = 0;
                        $uploadFile = CUploadedFile::getInstance($model, 'pic_user');
                        $uploadFile3 = CUploadedFile::getInstance($model, 'card_id');

                        if (isset($uploadFile)) {
                            $uglyName = strtolower($uploadFile->name);
                            $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
                            $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
                            $model->pic_user = $beautifulName;
                        }
                        if (isset($uploadFile3)) {
                            $uglyName = strtolower($uploadFile3->name);
                            $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
                            $beautifulName = trim($mediocreName, '_') . "." . $uploadFile3->extensionName;

                            $model->pic_cardid = $beautifulName;
                        }
                        if ($profile->contactfrom) {
                            if (is_array($profile->contactfrom)) {
                                $value = '';
                                $contacts = $profile->contactfrom;
                                foreach ($contacts as $key => $contact) {
                                    if ($contact != end($contacts)) {
                                        $value .= $contact . ',';
                                    } else {
                                        $value .= $contact;
                                    }
                                }
                                $profile->contactfrom = $value;
                            }
                        }

                        $model->bookkeeper_id = $model->username;

                        if ($Setting->settings_confirmmail == 1) {

                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                            $check = UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                            if ($check) {
                                Yii::app()->user->setFlash('contact', ' (ตรวจสอบอีเมล ยืนยันตัวตนที่อีเมลผู้ใช้ก่อนเข้าสู่ระบบ)');
                            } else {
                                Yii::app()->user->setFlash('error', ' Error while sending email: ' . $mail->getError());
                            }
                        } else {
                            $model->status = 1;
                        }

                        $profile->birthday = Yii::app()->dateFormatter->format("y-M-d", strtotime($profile->birthday));
                        $profile->generation = $gen->id_gen;

                        if ($model->save() && $profile->save()) {
                            if (isset($uploadFile)) {
                                /////////// SAVE IMAGE //////////
                                Yush::init($model);
                                $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
                                $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
                                $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
                                // Save the original resource to disk
                                $uploadFile->saveAs($originalPath);

                                // Create a small image
                                $smallImage = Yii::app()->phpThumb->create($originalPath);
                                $smallImage->resize(385, 220);
                                $smallImage->save($smallPath);

                                // Create a thumbnail
                                $thumbImage = Yii::app()->phpThumb->create($originalPath);
                                $thumbImage->resize(350, 200);
                                $thumbImage->save($thumbPath);

                            }
                            if (isset($uploadFile3)) {
                                /////////// SAVE IMAGE //////////
                                Yush::init($model);
                                $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_cardid);
                                $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_cardid);
                                $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_cardid);
                                // Save the original resource to disk
                                $uploadFile3->saveAs($originalPath);

                                // Create a small image
                                $smallImage = Yii::app()->phpThumb->create($originalPath);
                                $smallImage->resize(385, 220);
                                $smallImage->save($smallPath);

                                // Create a thumbnail
                                $thumbImage = Yii::app()->phpThumb->create($originalPath);
                                $thumbImage->resize(350, 200);
                                $thumbImage->save($thumbPath);

                            }
                            if (Yii::app()->controller->module->sendActivationMail) {
                                $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                                UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                            }
                            if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) {
                                $identity = new UserIdentity($model->username, $soucePassword);
                                $identity->authenticate();
                                Yii::app()->user->login($identity, 0);
                                $this->redirect(Yii::app()->controller->module->returnUrl);
                            } else {
                                if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                                } elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false) {
                                    Yii::app()->user->setFlash('registration', 'ขอบคุณสำหรับการสมัครสมาชิก กรุณาเข้าสู่ระบบ');
                                } elseif (Yii::app()->controller->module->loginNotActiv) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
                                } else {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                                }
                                // $this->refresh();
                            }
                        } else {
                            Yii::app()->user->setFlash('regiserror', 'สมัครไม่สำเร็จ กรุณาทำรายการใหม่');
                            $this->redirect(array('/user/registration'));
                        } // end if..else model - profile save
                    } // end if validate model - profile
                } else {
                    Yii::app()->user->setFlash('captcha', 'กรุณาป้อน Captcha');
                    $this->redirect(array('/user/registration'));
                } // end check if..else empty captcha
            } // end if $_POST['RegistrationForm']
            $this->render('/user/registration', array('model' => $model, 'profile' => $profile, 'genechk' => $check, 'activeRegis' => $activeRegis, 'msg' => $msg ));
        } // end if..else check user id or user login
    }

    public function loadDepartment($department_id)
    {
        $data = OrgChart::model()->findAll('id=:id',
            array(':id' => $department_id)
        );

        $data = CHtml::listData($data, 'id', 'title');

        return $data;
    }
}
