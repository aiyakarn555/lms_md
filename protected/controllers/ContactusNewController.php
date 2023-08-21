<?php

class ContactusNewController extends Controller {
    public function init()
    {
        parent::init();
        $this->lastactivity();
        
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ));
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
            // $ContactusNew_data = ContactusNew::model()->findAll(array(
            // 'condition'=>' active=:active',
            // 'params' => array(':active' => 'y')
            //   ));
        
        $criteria = new CDbCriteria;
        $criteria->compare('active','y');
       // $criteriavdo->compare('lang_id',$langId);
        $criteria->order = 'sortOrder ASC limit 2';
        $ContactusNew_data = ContactusNew::model()->findAll($criteria);
        if($ContactusNew_data){
            $label = MenuContactus::model()->find(array(
                'condition' => 'lang_id=:lang_id ',
                'params' => array(':lang_id' => $langId)
            ));
        }else{
            $label = MenuContactus::model()->find(array(
                'condition' => 'lang_id=:lang_id ',
                'params' => array(':lang_id' => 1)
            ));
        }
        // $about_data = About::model()->findByAttributes(array(
        //     'active'=>'y',
        // ));

        // var_dump($about_data);exit();
                
        $this->render('index',array(
            'ContactusNew_data'=>$ContactusNew_data,'label'=>$label
        ));
    }


}
