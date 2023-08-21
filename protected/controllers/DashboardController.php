<?php

class DashboardController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'


		//CourseOnline
		// $course_online = new CourseOnline('search');
		// $course_online->unsetAttributes();
		// if(isset($_POST['search_text']))
		// 	$course_online->course_title=$_POST['search_text'];

		// if(!Yii::app()->user->isGuest){
		// 	$userObject = Yii::app()->getModule('user')->user();
		// 	if($userObject->orgcourses){
		// 		$courses = $userObject->orgcourses;
		// 	}
		// }

		// $courseArray = array();
		// if(!empty($courses)){
		// 	$courseArray = CHtml::listData($courses,'course_id','course_id');
		// }
		// $course_online->course_id_array = array_values($courseArray);


		// Webborad
		// $forum = BbiiPost::model()->findAll(array(
		// 	'order'=>'create_time DESC',
		// 	'limit'=>'5',
		// ));

		// $this->render('index',array(
		// 	'course_online'=>$course_online->search(),
		// 	'forum'=>$forum,
		// ));

		$this->render('index2');
	}

	public function actionTerms()
	{
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
	        $langId = Yii::app()->session['lang'] = 1;
	        Yii::app()->language = 'en';
	    }else{
	        $langId = Yii::app()->session['lang'];
	        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
	    }
	    $model = Terms::model()->find(array(
	        'condition' => 'lang_id=:lang_id',
	        'params' => array(':lang_id' => $langId)
	    ));
	    if(!$model){
	        $model = Terms::model()->find(array(
	            'condition' => 'lang_id=:lang_id',
	            'params' => array(':lang_id' => 1)
	        ));
	    }

			$this->render('Terms',array('model' => $model));
	}

}
