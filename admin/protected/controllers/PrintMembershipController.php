<?php

class PrintMembershipController extends Controller
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
                'actions' => array('index','approve'),
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

    public function actionindex ()
    {
        $model = new PrintMembership('searchmembership');
        $model->unsetAttributes();  // clear any default values
        $model->status = array(1);
        $model->register_status = array(0);
        $model->supper_user_status = true;
      
        if(isset($_GET['PrintMembership'])){
            $model->attributes=$_GET['PrintMembership'];
        }
        $this->render('index',array(
            'model'=>$model,
        ));
    }
    public function actionapprove ()
    {
        $model = new PrintMembership('search');
        $model->unsetAttributes();  // clear any default values
        $model->status = array(1);
        $model->register_status = array(1);
        $model->supper_user_status = true;
      
        if(isset($_GET['PrintMembership'])){
            $model->attributes=$_GET['PrintMembership'];
        }
        $this->render('approve',array(
            'model'=>$model,
        ));
    }

    public function actionPrintpdf(){

        $user_id =$_GET['id'];
        if ($user_id != '') {
            $profiles = Profile::model()->find(array(
                'condition' => 'user_id=:user_id ',
                'params' => array('user_id' => $user_id)
            ));
            $user = User::model()->find(array(
                'condition' => 'id=:id',
                'params' => array('id' => $user_id)
            ));
            $LogRegister = LogRegister::model()->find(array(
                'condition' => 'user_id=:user_id AND active=:active',
                'params' => array('user_id' => $user_id,'active'=>'y')
            ));
        $path_img = Yii::app()->baseUrl. '/images/head_print.png';
     
        // $padding_left = 12.7;
        // $padding_right = 12.7;
        // $padding_top = 10;
        // $padding_bottom = 20;
         require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
         $mPDF = new \Mpdf\Mpdf();
        //$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
        $mPDF->useDictionaryLBR = false;
        $mPDF->setDisplayMode('fullpage');
        $mPDF->autoLangToFont = true;
        $mPDF->autoPageBreak = true;
        $mPDF->SetTitle("ใบสมัครสมาชิก");
        $texttt= '
         <style>
         body { font-family: "garuda"; }
         </style>
         ';
        $mPDF->WriteHTML($texttt);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('PrintPDF', array('profiles'=>$profiles,'user'=>$user,'LogRegister'=>$LogRegister), true), 'UTF-8', 'UTF-8'));
        $mPDF->Output('ใบสมัครสมาชิก.pdf', 'I');

        }
    }

   public function actionPrintpdf_approve(){

        $user_id =$_GET['id'];
        if ($user_id != '') {
            $profiles = Profile::model()->find(array(
                'condition' => 'user_id=:user_id ',
                'params' => array('user_id' => $user_id)
            ));
            $user = User::model()->find(array(
                'condition' => 'id=:id',
                'params' => array('id' => $user_id)
            ));
            $LogRegister = LogRegister::model()->find(array(
                'condition' => 'user_id=:user_id AND active=:active',
                'params' => array('user_id' => $user_id,'active'=>'y')
            ));
            $LogApprove = LogApprove::model()->find(array(
                'condition' => 'user_id=:user_id AND active=:active',
                'params' => array('user_id' => $user_id,'active'=>'y')
            ));
        $path_img = Yii::app()->baseUrl. '/images/head_print.png';
     
        // $padding_left = 12.7;
        // $padding_right = 12.7;
        // $padding_top = 10;
        // $padding_bottom = 20;
         require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
         $mPDF = new \Mpdf\Mpdf();
        //$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
        $mPDF->useDictionaryLBR = false;
        $mPDF->setDisplayMode('fullpage');
        $mPDF->autoLangToFont = true;
        $mPDF->autoPageBreak = true;
        $mPDF->SetTitle("ใบสมัครสมาชิก");
        $texttt= '
         <style>
         body { font-family: "garuda"; }
         </style>
         ';
        $mPDF->WriteHTML($texttt);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('PrintPDF_approve', array('profiles'=>$profiles,'user'=>$user,'LogRegister'=>$LogRegister,'LogApprove'=> $LogApprove), true), 'UTF-8', 'UTF-8'));
        $mPDF->Output('ใบสมัครสมาชิก.pdf', 'I');

        }
    }

    protected function performAjaxValidation($model)
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }

    }