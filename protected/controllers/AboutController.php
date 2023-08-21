<?php

class AboutController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public function actionIndex()
	{
		if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}
		    $about_data = About::model()->find(array(
            'condition'=>'lang_id=:lang_id AND active=:active',
            'params' => array(':lang_id' => $langId, ':active' => 'y')
              ));
		    if($about_data){
		    	$label = MenuAbout::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));
		    }else{
		    	$label = MenuAbout::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
		    }

        // $about_data = About::model()->findByAttributes(array(
        //     'active'=>'y',
        // ));

        // var_dump($about_data);exit();
				
        $this->render('index',array(
            'about_data'=>$about_data,
            'label'=>$label,
        ));
	}

		public function actionDetail1()
	{	
        $this->render('detail1');
	}

		public function actionDetail2()
	{	
        $this->render('detail2');
	}

	public function actionDetail3()
	{	
        $this->render('detail3');
	}

	public function actionDetail4()
	{	
        $this->render('detail4');
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
