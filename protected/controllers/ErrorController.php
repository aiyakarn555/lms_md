<?php

class ErrorController extends Controller
{
    public function init()
    {
        parent::init();
        $this->lastactivity();
        
    }
	public function actionIndex()
	{

        $errorMessage = Yii::app()->session['errorMessage'];
        $errorController = Yii::app()->session['errorController'];
        $errorAction = Yii::app()->session['errorAction'];
        $errorCode = Yii::app()->session['errorCode'];
        $errorParameter = Yii::app()->session['errorParameter'];

        Helpers::lib()->insertLogError($errorMessage,$errorController,$errorAction,$errorCode,$errorParameter);

		$this->render('index');
	}
}
?>