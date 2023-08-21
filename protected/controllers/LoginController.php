<?php

class LoginController extends Controller
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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

        if ($_POST['UserLogin']['checkbox'] == "on") {
            $value = $_POST['UserLogin']['username'];
            // $value = "admin'\"()&%<acx><ScRiPt >rOfs(9977)</ScRiPt>";
            $value = Helpers::lib()->xss_clean($value);
            $cookie = new CHttpCookie('cookie_name', $value);
            $cookie->expire = time() + 60 * 60 * 24 * 180;
            Yii::app()->request->cookies['cookie_name'] = $cookie;
        }
        if (Yii::app()->user->isGuest) {


            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin']['username'])) {

                $model->username = $_POST['UserLogin']['username'];
                $model->password = $_POST['UserLogin']['password'];

                // validate user input and redirect to previous page if valid
                if ($model->validate()) {

                    Yii::app()->session['popup'] = 1;
                    $this->lastViset();
                    $this->saveToken();

                    // Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
                    if (Yii::app()->user->id) {
                        Helpers::lib()->getControllerActionId();
                    }

                    // $Setting = Setting::model()->find();
                    // if($Setting->settings_confirmface == '1')
                    // {
                    //     Yii::app()->session['utt'] = $model->username;
                    //     Yii::app()->session['ptt'] = $model->password;

                    //     $getprofile = Profile::model()->findByPk(Yii::app()->user->id);
                    //     $uId = Yii::app()->user->id ;
                    //     $msg = "Please verify your face.";
                    //     Yii::app()->user->setFlash('msg',$msg);
                    //     Yii::app()->user->setFlash('icon','info'); 


                    // if (User::model()->findbyPk(Yii::app()->user->id)->repass_status=='0' 
                    //         && Yii::app()->controller->id != 'registration'){
                    //      $this->redirect(array('/site/FaceLogin/', 'useld' => $uId, 'profile' => $getprofile->firstname, 'type_repass' => 1));     
                    // }

                    //      $this->redirect(array('/site/FaceLogin/', 'useld' => $uId, 'profile' => $getprofile->firstname));
                    //     // $this->render('/site/FaceLogin', ['userId' => $uId, 'profile' => $getprofile->firstname]);

                    //     $faceverify = 1;
                    // }
                    // else
                    // {
                    $getprofile = Profile::model()->findByPk(Yii::app()->user->id);
                    $msg = "Welcome. " . $getprofile->firstname;
                    Yii::app()->user->setFlash('msg', $msg);
                    Yii::app()->user->setFlash('icon', 'success');
                    $this->redirect(array('/site/index', 'useld' => Yii::app()->user->id));
                    // }

                } else {

                    foreach ($model->getErrors() as $key => $value) {
                        $error .= $value[0];
                    }

                    if ($error == 'NoRegisterFace') {
                        $userface = Users::model()->notsafe()->findByAttributes(array('username' => $model->username, 'del_status' => '0'));

                        $msg = "user ของคุณยังไม่ได้ลงทะเบียนภาพใบหน้า กรุณาลงทะเบียน";
                        Yii::app()->user->setFlash('msg', $msg);
                        Yii::app()->user->setFlash('icon', 'warning');
                        $this->redirect(array('/registration/idcardverification/', 'id' => $userface->id, 'typ' => 'lgn'));
                    }

                    if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
                        switch ($error) {
                            case "ชื่อผู้ใช้ไม่ถูกต้อง":
                                $msg = "Username Password is incorrect.";
                                break;
                            case "อีเมลล์ไม่ถูกต้อง":
                                $msg = "Email Password is incorrect.";
                                break;
                            case "Account คุณยังไม่ได้ยืนยันการใช้งาน":
                                $msg = "You account is not activated.";
                                break;
                            case "Account คุณถูกระงับ":
                                $msg = "You account is blocked.";
                                break;
                            case "รหัสผ่านไม่ถูกต้อง":
                                $msg = " Username Password is incorrect.";
                                break;
                        }
                        Yii::app()->user->setFlash('msg', $msg);
                        Yii::app()->user->setFlash('icon', 'warning');
                    } else {

                        switch ($error) {
                            case "ชื่อผู้ใช้ไม่ถูกต้อง":
                                $msg = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง.";
                                break;
                            case "อีเมลล์ไม่ถูกต้อง":
                                $msg = "อีเมลหรือรหัสผ่านไม่ถูกต้อง.";
                                break;
                            case "Account คุณยังไม่ได้ยืนยันการใช้งาน":
                                $msg = "คุณยังไม่ได้ยืนยันการใช้งาน";
                                break;
                            case "Account คุณถูกระงับ":
                                $msg = "คุณถูกระงับ.";
                                break;
                            case "รหัสผ่านไม่ถูกต้อง":
                                $msg = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง.";
                                break;
                        }
                        Yii::app()->user->setFlash('msg', $msg);
                        Yii::app()->user->setFlash('icon', 'warning');
                    }
                }
            }
            // $this->redirect(array('site/login'));
            $this->redirect(array('site/login'));
        } else {
            $this->redirect(array('site/login'));
        }
    }

    public function actionLogoutNoredirect()
    {
        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }
        //$logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
        if (Yii::app()->user->id) {
            Yii::app()->user->logout();
        }


        //$this->redirect(array('site/index'));
        // $this->render('/site/index');
    }



    public function actionLoginApp($id)
    {
        $key = $_GET['key'];
        // var_dump($key);exit();
        if ($key == 'BwjPHhyjbhhhU4pex5e1igys5Dp8adlWe') {
            $model = new UserLogin;

            $user = User::model()->findbyPk($id);

            $model->username = $user->username;
            $model->password = 'bangkokweb@thoresen2563';

            if ($model->validate()) {

                if (User::model()->findbyPk(Yii::app()->user->id)->superuser == 1) {
                    $this->actionLogout();
                }

                $this->lastViset();
                $this->saveToken();

                $this->redirect(array('virtualclassroom/index'));
            }
        } else {
            echo 'รหัสยืนยันไม่ถูก';
            exit();
        }
    }

    private function ldapTms($email)
    {
        $ldap_host = '172.30.110.111';
        $ldap_username = 'taaldap@aagroup.redicons.local';
        $ldap_password = 'Th@i@ir@sia320';
        $dn = "OU=TAA,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        $dn1 = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
        $ldap = ldap_connect($ldap_host);
        $bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die("Could not bind");

        // $attrs = array("sn","objectGUID","description","displayname","samaccountname","mail","telephonenumber","physicaldeliveryofficename","pwdLastSet","AA-joindt","division");
        $attrs = array("sn", "displayname", "samaccountname", "mail", "pwdLastSet", "division", "department", "st", "description");
        $filter = "(mail=" . $email . ")";
        $search = ldap_search($ldap, $dn, $filter, $attrs) or die("ldap search failed");
        $search1 = ldap_search($ldap, $dn1, $filter, $attrs) or die("ldap search failed");
        return ldap_get_entries($ldap, $search)['count'] > 0 ? ldap_get_entries($ldap, $search) : ldap_get_entries($ldap, $search1);
        // return ldap_get_entries($ldap, $search);
    }


    private function _checkKeyLogin($key)
    {
        $response = array();
        if ($key != 'de7e13f6-02ec-4ddf-bace-009a53289d7f') {
            $response['result'] = false;
            $response['msg'] = 'Error: Incorrect keys';
            $this->_sendResponse(401, CJSON::encode($response));
        }
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '
            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
            </head>
            <body>
            <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
            <p>' . $message . '</p>
            <hr />
            <address>' . $signature . '</address>
            </body>
            </html>';

            echo $body;
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function lastViset()
    {
        $lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit_at = date("Y-m-d H:i:s", time());
        $lastVisit->online_status = '1';
        $lastVisit->save(false);
    }

    private function saveToken()
    {
        $lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
        $token = UserModule::encrypting(time());
        $lastVisit->avatar = $token;
        //Set cookie token for login
        $time = time() + 7200; //1 hr.
        $cookie = new CHttpCookie('token_login', $token); //set value
        $cookie->expire = $time;
        Yii::app()->request->cookies['token_login'] = $cookie;
        $lastVisit->save(false);
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
    public function actionLogout()
    {

        if (Yii::app()->user->id) {
            Helpers::lib()->getControllerActionId();
        }

        if (Yii::app()->user->id) {
            $logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
            $logoutid->lastvisit_at = date("Y-m-d H:i:s", time());
            $logoutid->online_status = '0';
            $logoutid->save(false);
            Yii::app()->user->logout();

            $this->redirect(array('site/login'));
        } else {
            $this->redirect(array('site/login'));
        }
    }
}
