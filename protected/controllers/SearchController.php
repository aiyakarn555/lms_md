<?php

class SearchController extends Controller {
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}

    public function actionindex($text) {

             if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
                    $langId = Yii::app()->session['lang'] = 1;
                }else{
                    $langId = Yii::app()->session['lang'];
                }

            if(empty($text)){
                $this->redirect(array('/site/index/'));
            }else{

                $label = MenuSearch::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                ));

                if(!$label){
                    $label = MenuSearch::model()->find(array(
                        'condition' => 'lang_id=:lang_id',
                        'params' => array(':lang_id' => 1)
                    ));
                }
                $this->render('index', array
                    ('text' => $text,'label'=>$label,'lang_session'=>$langId));
            }
    	 
    }

}
