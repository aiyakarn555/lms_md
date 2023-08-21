<?php

class UsabilityController extends Controller
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
		$id = $_GET['id'];
		//Usability
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}
		    $usability_data = Usability::model()->findAll(array(
            'condition'=>'lang_id=:lang_id AND active=:active',
            'params' => array(':lang_id' => $langId, ':active' => 'y'),
             'order'=> 'sortOrder ASC'
              ));
		    // if(!$usability_data){
		    // 	$usability_data = Usability::model()->findAll(array(
	     //        'condition'=>'lang_id=:lang_id AND active=:active',
	     //        'params' => array(':lang_id' => 1, ':active' => 'y')
	     //          ));
		    // }
            $label = MenuUsability::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                    ));
            if(!$label){
                $label = MenuUsability::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                    ));
             }

             $labelSite = MenuSite::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                    ));
            if(!$labelSite){
                $labelSite = MenuSite::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                    ));
             }

            // $labelSearch = MenuSearch::model()->find(array(
            //         'condition' => 'lang_id=:lang_id',
            //         'params' => array(':lang_id' => $langId)
            //         ));
            // if(!$labelSearch){
            //     $labelSearch = MenuSearch::model()->find(array(
            //         'condition' => 'lang_id=:lang_id',
            //         'params' => array(':lang_id' => 1)
            //         ));
            //  }

		$this->render('index',array(
			'usability_data'=>$usability_data,'label'=>$label,'labelSite'=>$labelSite
		));

	}

public function actionsearch($text) {
        $this->render('search', array
            ('text' => $text));
    }

	public function loadModel($id)
	{
		$model=Usability::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usability-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
