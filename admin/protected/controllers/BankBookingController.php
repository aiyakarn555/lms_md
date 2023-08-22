<?php

class BankBookingController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();

		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
		}
		
	}
	
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
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
            	'actions' => array('index', 'view','update','delete','coursemodal','savecoursemodal','msteamsmodal','savemsmodal'),
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

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    		));
    }

    public function actionCreate()
    {
    	$model = new BankBooking;

    	if(isset($_POST['BankBooking']))
    	{
    		
    		$time = date("dmYHis");
    		$model->attributes=$_POST['BankBooking'];

    		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;

    		if($model->validate())
    		{
    			if($model->save())
    			{	

    				if ($_FILES['picture']['tmp_name'] != "") {
    					$tempFile   = $_FILES['picture'];
    					$path = "bank";
    					$model_id = $model->id;
    					$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
    					if ($filename) {
    						$model = $this->loadModel($model->id);
    						$model->bank_images = $filename;
    						$model->save();
    					}
    				}


    				if(Yii::app()->user->id){
    					Helpers::lib()->getControllerActionId();
    				}
    				$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootId = $model->id;
						}else{
							$rootId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							# code...

							$new = BankBooking::model()->findByAttributes(array('lang_id'=> $lang->id, 'parent_id'=>$rootId));
							if(!$new){
								$newsRoot = BankBooking::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มธนาคาร '.$newsRoot->bank_name .',ภาษา '.$lang->language);
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}
						}

    				$this->redirect(array('index'));
    			}else{
    				var_dump($model->getErrors());exit();
    			}
    		}
    	}

    	$this->render('create',array(
    		'model'=>$model
    		));
    }

    public function actionUpdate($id)
    {
    	$model = $this->loadModel($id);
    	// var_dump($model->cms_detail);
    	$imageShow = $model->bank_images;
    	if(isset($_POST['BankBooking']))
    	{

    		$time = date("dmYHis");
    		$model->attributes=$_POST['News'];
			$imageOld = $model->bank_images; // Image Old

			if($model->validate())
			{
				if($model->save())
				{

					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "bank";
						$model_id = $model->id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->id);
							$model->bank_images = $filename;
							$model->save();
						}
					}


					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}


					$this->redirect(array('index'));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow
			));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		// $this->actionSort($model->sortOrder);
		$model->active = 'n';

		if($model->bank_images != '')
			Yii::app()->getDeleteImageYush('News',$model->id,$model->bank_images);

		$model->bank_images = null;

		$modelChrilden = BankBooking::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $model->id, ':active' => 'y')
              ));
		foreach ($modelChrilden as $key => $value) {
			// $this->actionSort($value->sortOrder);
			$value->active = 'n';

			if($value->bank_images != ''){
				Yii::app()->getDeleteImageYush('News',$value->id,$value->bank_images);
			}
			$value->bank_images = null;
			$value->save();
		}
		$model->save();

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}


		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		//header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionIndex()
	{
		$model=new BankBooking('search');
		$model->unsetAttributes();
		$model->active = 'y';
		if(isset($_GET['BankBooking']))
			$model->attributes=$_GET['BankBooking'];

		$this->render('index',array(
			'model'=>$model,
			));
	}

	public function loadModel($id)
	{
		$model=BankBooking::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	public function actionCourseModal() {
		$respon = '';
		$bank_id = $_POST['bank_id'];

		if($bank_id != null) {
			// $getAllCourse = CourseOnline::model()->findAll();
			$getAllCourse = CourseOnline::model()->findAll(array(
				'condition'=>'lang_id = 1 AND active = "y"'
			));
			$model = BankNameRelations::model()->findAll(array(
				'condition'=>'bank_id = "'.$bank_id.'"'
			));
			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId[$key] = $value->course_id;
			}
			if($getAllCourse) {
				$respon .= '<table class="table table-striped">';
				$respon .= '<input type="hidden" name="id" value="' . $bank_id . '">';
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
					$respon .= '<input id="cou-'.$course['course_id'].'" class="courseCheckList" type="checkbox" ' . $checked . ' value="' . $course['course_id'] . '"> ';
					$respon .= '</td>';
					$respon .= '<td>';
					$respon .= '<label for="cou-'.$course['course_id'].'">'.(($course['course_number'] != null || $course['course_number'] != "")? $course['course_number'] : "ไม่พบรหัส")." : ".$course['course_title'].'</label>';
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


	public function actionMsteamsModal() {
		$respon = '';
		$bank_id = $_POST['bank_id'];

		if($bank_id != null) {
			// $getAllCourse = CourseOnline::model()->findAll();
			// $getAllCourse = MsTeams::model()->findAll(array(
			// 	'condition'=>'active = "y"'
			// ));


			$criteria = new CDbCriteria;
			$criteria->compare('active','y');
			$criteria->order = 'create_date DESC';
			$getAllCourse = MsTeams::model()->findAll($criteria);


			$model = BankNameRelations::model()->findAll(array(
				'condition'=>'bank_id = "'.$bank_id.'"'
			));
			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId[$key] = $value->ms_teams_id;
			}
			if($getAllCourse) {
				$respon .= '<table class="table table-striped">';
				$respon .= '<input type="hidden" name="msid" value="' . $bank_id . '">';
				$respon .= '<tr>';
				$respon .= '<th style="width:90px;"><input type="checkbox" id="checkAllms" /> ทั้งหมด</th>';
				$respon .= '<th>ชื่อห้องเรียนออนไลน์</th>';
				$respon .= '</tr>';
				foreach ($getAllCourse as $course) {
					$checked = '';
					if(in_array($course['id'], $mtId)){
						$checked = 'checked';
					}
					$respon .= '<tr>';
					$respon .= '<td>';
					$respon .= '<input id="ms-'.$course['id'].'" class="msCheckList" type="checkbox" ' . $checked . ' value="' . $course['id'] . '"> ';
					$respon .= '</td>';
					$respon .= '<td>';
					$respon .= '<label for="ms-'.$course['id'].'">'.$course['name_ms_teams'].' ( '.$course->start_date.' ถึง '.$course->end_date.' )'.'</label>';
					$respon .= '</td>';
					$respon .= '</tr>';
				}
				$respon .= '</table>';
			}
			$respon .= "<script>
			$('#checkAllms').change(function () {
				$('input:checkbox').prop('checked', $(this).prop('checked'));
			});
			</script>";
		}
		echo $respon;	
	}


	public function actionSaveMsModal() {

		$bankId = $_POST['bankId'];
		$saveCourseApplied = json_decode($_POST['checkedListms']);

		$criteria = new CDbCriteria;
		$criteria->addNotIncondition('ms_teams_id',$saveCourseApplied);
		$criteria->compare('bank_id',$bankId);
		$banks = BankNameRelations::model()->deleteAll($criteria);

		if($saveCourseApplied) {
			foreach ($saveCourseApplied as $msteams) {
				
				$modelOld = BankNameRelations::model()->find(array(
					'condition'=>'ms_teams_id = "'.$msteams.'" And bank_id = "'.$bankId.'"'
				));
				
				if($modelOld == null){
					$model = new BankNameRelations;
					$model->ms_teams_id = $msteams;
					$model->bank_id = $bankId;
					$model->save();
				}
			}
		} 
		echo true;
	}

		public function actionSaveCourseModal() {

		$bankId = $_POST['bankId'];
		$saveCourseApplied = json_decode($_POST['checkedList']);
		
		$criteria = new CDbCriteria;
		$criteria->addNotIncondition('course_id',$saveCourseApplied);
		$criteria->compare('bank_id',$bankId);
		$banks = BankNameRelations::model()->deleteAll($criteria);

		if($saveCourseApplied) {
			foreach ($saveCourseApplied as $cou) {

				$modelOld = BankNameRelations::model()->find(array(
					'condition'=>'course_id = "'.$cou.'" And bank_id = "'.$bankId.'"'
				));

				if($modelOld == null){
					$model = new BankNameRelations;
					$model->course_id = $cou;
					$model->bank_id = $bankId;
					$model->save();
				}
			}
		} 
		echo true;
	}


	

}
