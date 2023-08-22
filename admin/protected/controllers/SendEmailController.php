<?php

class SendEmailController extends Controller
{

    public function actionSendEmail()
    {
        $model_group=new Mailgroup;

        $this->render('SendEmail',array(
            'model_group'=>$model_group,
        ));
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='send-email-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}