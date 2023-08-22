<?php

class ReportController extends Controller
{
    public function filters()
    {
        return array(
            'rights',
        );
    }

    public function actionIndex()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('index',array('model'=>$model));
    }

    public function actionTrack()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('track',array('model'=>$model));
    }

    public function actionStatus()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('status',array('model'=>$model));
    }

    public function actionScore()
    {
        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

        $this->render('Score',array('model'=>$model));
    }

}