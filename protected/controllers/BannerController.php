<?php
class BannerController extends Controller{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}

	public function actionIndex(){
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
          	}

            $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $langId)
            ));

            if(!$label){
                $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => 1)
            ));
            }

	    $this->render('index',array('label'=>$label));
	}
	public function actionDetail($id) {
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$id = $_GET['id'];
			//Imgslide
			$img_data = Imgslide::model()->findByAttributes(array(
				'active'=>'y',
				'imgslide_id'=>$id,
			));
			// echo "<pre>";
			// var_dump($img_data);
			// exit();
			$this->render('detail',array(
				'img_data'=>$img_data
			));
	}   
}
?>
