<?php

class ConditionsController extends Controller
{
	public function actionIndex()
	{
        //$conditions_data
        $conditions_data = Conditions::model()->findByAttributes(array(
            'active'=>'y',
        ));

        $this->render('index',array(
            'conditions_data'=>$conditions_data,
        ));
	}
}
