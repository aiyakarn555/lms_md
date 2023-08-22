<?php

class CaptchaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
        );
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
    	return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','multidelete','savecoursemodal','CourseModal'),
            	'users' => array('*'),
            ),
            array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
            	'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
            	'expression' => 'AccessControl::check_access()',
            ),
            array('deny',  // deny all users
            	'users' => array('*'),
            ),
        );
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */


	public function actionReportAnsCaptcha()
	{
		/*$model=new MMember('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['MMember']))
            $model->attributes=$_GET['MMember'];
		*/
            $model = new ValidateCaptcha('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ValidateCaptcha'])){
        	$model->attributes=$_GET['ValidateCaptcha'];
        } else {
        	$model->search_passport = -1;
        }
        $this->render('reportCaptcha',array(
        	'model'=>$model,
        ));
    }

    public function actionReportCaptchaModal(){
    	$id = $_POST['id'];
    	$course = $_POST['course'];
    	$model = new ValidateCaptcha('searchAnsDetail');
    	$model->unsetAttributes();
    	if($id != null && $course){
    		$model->user_id = $id;
    		$model->cnid = $course;
    		$respon = $this->renderPartial('_reportCaptcha',array('model' => $model));
    	}
    	echo $respon;
    }

    public function actionSaveCourseModal() {
		$capid = $_POST['capid'];
		$saveCourseApplied = json_decode($_POST['checkedList']);
		$model = ConfigCaptchaCourseRelation::model()->deleteAll(array(
			'condition'=>'captid = "'.$capid.'"'
		));
		if($saveCourseApplied) {
			foreach ($saveCourseApplied as $course) {
				$model = ConfigCaptchaCourseRelation::model()->deleteAll(array(
					'condition'=>'captid = "'.$course.'"'
				));
				$model = new ConfigCaptchaCourseRelation;
				$model->cnid = $course;
				$model->captid = $capid;
				$model->save();
			}
		} 
		echo true;
	}
	
	public function actionCourseModal() {
		$respon = '';
		$capid = $_POST['capid'];
		if($capid != null) {
			// $getAllCourse = CourseOnline::model()->findAll();
			$getAllCourse = CourseOnline::model()->findAll(array(
				'condition'=>'lang_id = 1'
			));
			$model = ConfigCaptchaCourseRelation::model()->findAll(array(
				'condition'=>'captid = "'.$capid.'"'
			));
			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId[$key] = $value->cnid;
			}
			if($getAllCourse) {
				$respon .= '<table class="table table-striped">';
				$respon .= '<input type="hidden" name="capid" value="' . $capid . '">';
				$respon .= '<tr>';
				$respon .= '<th style="width:90px;"><input type="checkbox" id="checkAll" /> ทั้งหมด</th>';
				$respon .= '<th>ชื่อหลักสูตร</th>';
				$respon .= '</tr>';
				foreach ($getAllCourse as $course) {
					$checked = '';
					if(in_array($course['course_id'], $mtId)){
						$checked = 'checked';
					}
					$respon .= '<tr>';
					$respon .= '<td>';
					$respon .= '<input class="courseCheckList" type="checkbox" ' . $checked . ' value="' . $course['course_id'] . '"> ';
					$respon .= '</td>';
					$respon .= '<td>';
					$respon .= $course['course_title'];
					$respon .= '</td>';
					$respon .= '</tr>';
				}
				$respon .= '</table>';
			}
			$respon .= "<script>
			$('#checkAll').change(function () {
				$('input:checkbox').prop('checked', $(this).prop('checked'));
			});
			</script>";
		}
		echo $respon;	
	}


    public function actionCreate()
    {
    	$model = new ConfigCaptcha;

    	$cap = new ConfigCaptchaCourseRelation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
    	$model->attributes=$_POST['ConfigCaptcha'];

    	$cap->attributes=$_POST['ConfigCaptchaCourseRelation'];
    	//$cap->cnid=$_POST['cnid'];
    	$model->created_by = Yii::app()->user->id;
    	$model->created_date = date("Y-m-d H:i:s");
    	$model->capt_active = 'y';

    	if(isset($_POST['ConfigCaptcha']) || isset($_POST['ConfigCaptchaCourseRelation']))
    	{		
    		$model->capt_time_back = 999;
    		$model->capt_wait_time = 999;
    		$model->capt_times = 999;
    		$model->prev_slide = 999;	
    		$model->type = json_encode($_POST['type']);
    		if($model->validate() && $cap->validate()){
    			if($model->save()){
    				$course = $cap->cnid;
    				if($course){
    					// foreach ($lesson as $key => $value) {
    					$cap1 = new ConfigCaptchaCourseRelation;
    						// $cap1->lid = $value;
    					$cap1->cnid = $course;
    					$cap1->captid = $model->capid;
    					$cap1->save();
    					// }
    				}
    				$this->redirect(array('index'));
    			}
    		} 
    	}

    	if(!empty($_POST["status_id"])) {
    		$model = ConfigCaptcha::model()->find(array(
    			'condition' => 'capid='.$_POST["status_id"]
    		));
    		if($model->capt_hide == 1){
    			$model->capt_hide = 0;
    			$value = 0;
    		} else {
    			$model->capt_hide = 1;
    			$value = 1;
    		}
    		$model->save(); 

    		echo $value;
    		exit();
    	}

    	$this->render('create',array(
    		'model'=>$model,
    		'cap'=>$cap,
    	));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$cap = ConfigCaptchaCourseRelation::model()->find(array('condition' => 'captid='.$id));
		if(!$cap){
			$cap = new ConfigCaptchaCourseRelation;
		}
		$model->updated_by = Yii::app()->user->id;
		$model->updated_date = date("Y-m-d H:i:s");

		if(isset($_POST['ConfigCaptcha']) || isset($_POST['ConfigCaptchaCourseRelation']))
		{	
			$model->type = json_encode($_POST['type']);
			$model->attributes = $_POST['ConfigCaptcha'];
			$cap->attributes = $_POST['ConfigCaptchaCourseRelation'];
			//$cap->cnid=$_POST['cnid'];
			if($model->validate() && $cap->validate()){
				$cap1 = ConfigCaptchaCourseRelation::model()->deleteAll(array(
					'condition'=>'captid = "'.$id.'"'
				));
				if($model->save()){
					$coruse = $cap->cnid;
					if($coruse){
						// foreach ($coruse as $key => $value) {
						ConfigCaptchaCourseRelation::model()->deleteAll(array(
							'condition'=>'lid = "'.$value.'" AND cnid="'.$cap->cnid.'"'
						));
						$cap1 = new ConfigCaptchaCourseRelation;
							// $cap1->lid = $value;
						$cap1->cnid = $coruse;
						$cap1->captid = $model->capid;
						$cap1->save();
						// }
					}
					/*$this->redirect(array('view','id'=>$model->capid));*/
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('update',array(
			'model'=> $model,
			'cap' => $cap,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionMultiDelete()
	{
		header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		ConfigCaptchaCourseRelation::model()->deleteAll(array(
			'condition'=>'captid = "'.$id.'"'
		));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        // Page
		$poviderArray['pagination'] = array('pageSize' => intval(20));

		$dataProvider=new CActiveDataProvider('ConfigCaptcha', $poviderArray);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ConfigCaptcha('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ConfigCaptcha']))
			$model->attributes=$_GET['ConfigCaptcha'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ConfigCaptcha the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ConfigCaptcha::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	/**
	 * Performs the AJAX validation.
	 * @param ConfigCaptcha $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='config-captcha-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionLessonChange(){
		
		$id = $_POST['id'];

		$data=ControlLesson::model()->findAll('course_id=:course_id', 
			array(':course_id'=>$id));

		$data=CHtml::listData($data,'lesson_id','lesson.lesson_name');

		echo "<option value=''>---กำหนดบทเรียน---</option>";
		foreach($data as $key=>$value)
			echo CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);

	}

	public function actionTest2(){
		
		$id = $_POST['id'];


		$lesson = LessonList::model()->findByPk($id);
		$data['lid'] = $lesson->lid;
		$data['lesson_name'] = $lesson->lesson_name;


		echo json_encode($data);
	}

	public function actionCheckboxLesson(){
		
		$id = $_POST['id'];
		$respon = '';
		$data=Lesson::model()->findAll('course_id=:course_id', 
			array(':course_id'=>$id));

		$data=CHtml::listData($data,'id','title');
		if($_POST['cap']){
			$cap = $_POST['cap'];
			$model = ConfigCaptchaCourseRelation::model()->findAll(array(
				'condition'=>'captid = "'.$cap.'"'
			));
			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId['keys'][$key] = $value->lid;
			}
		}
		$mtId['textOption'] .= '<select class="span8" multiple="multiple" name="ConfigCaptchaCourseRelation[lid][]" style="width: 300px; height: 100px; display: none;" id="select">';
		foreach ($data as $key => $value) {
			$mtId['textOption'] .= '<option style="width: 100%" value="'.$key.'">'.$value.'</option>';
		}
		$mtId['textOption'] .= '</select>';

		echo json_encode($mtId);
	}

}
