<?php

class FaqController extends Controller
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

		$this->layout = '//layouts/main';
		$criteria=new CDbCriteria();
		$criteria->condition = 'active="y"';
		$criteria->compare('lang_id',Yii::app()->session['lang']);
		// $criteria->addSearchCondition('faq_THtopic',@$_POST['search_text'],true);
		//$criteria->order = 'create_date DESC';
		$criteria->order = 'sortOrder ASC';

		$faq_data=Faq::model()->findAll($criteria);

		$faq_type = FaqType::model()->findAll(array(
			'condition'=>'active="y" AND lang_id="'.Yii::app()->session['lang'].'"',
			'order'=>'sortOrder ASC',
		));

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            $langId = Yii::app()->session['lang'] = 1;
            }else{
                $langId = Yii::app()->session['lang'];
            }

            $label = MenuFaq::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => $langId)
                    ));
            if(!$label){
                $label = MenuFaq::model()->find(array(
                    'condition' => 'lang_id=:lang_id',
                    'params' => array(':lang_id' => 1)
                    ));
             }

		$this->render('index',array(
			'faq_data'=>$faq_data,
			'faq_type'=>$faq_type,
			'label'=>$label,
		));
	}

public function actionsearch($text) {
        $this->render('search', array
            ('text' => $text));
    }
	public function loadModel($id)
	{
		$model=Faq::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
