<?php

class OrgmanageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init()
    {
        parent::init();
        $this->lastactivity();

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

	public function actionDivision()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "2";
		$model->active = "y";

		if(isset($_GET['OrgChart'])){
			$model->attributes=$_GET['OrgChart'];
		}

		$this->render('Division',array(
			'model'=>$model,
		));
	}

	public function actionDivision_create()
	{
		$model = new Orgchart;
		// $model->scenario = 'validateCheckk';

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST['OrgChart']);exit();
			$model->attributes=$_POST['OrgChart'];
			$model->level = 2;
			$model->parent_id = 1;

			if($model->save()){				
				// $model->sortOrder = $model->id;
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Division'));
			}
		}

		$this->render('Division_create',array(
			'model'=>$model,
		));

	}

	public function actionDivision_update($id)
	{
		$model = Orgchart::model()->findByPk($id);

		if(isset($_POST['OrgChart']))
		{
			
			$model->attributes=$_POST['OrgChart'];

			// var_dump($_POST['OrgChart']);exit();

			// $model->scenario = 'validateCheckk';
			// var_dump($model->validate()); 
			// var_dump($model->getErrors()); 
			// exit();
			// if($model->validate() && $model->save()){
			
			if($model->save(false)){

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Division'));
			}
		}

		$this->render('Division_update',array(
			'model'=>$model,
		));

	}

	public function actionDivision_delete($id)
	{	
		
		$model = Orgchart::model()->findByPk($id);
		$model->active = 'n';
		// $model->org_number = null;
		$model->save(false);

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Division'));
		}
		// $this->redirect(array('ManageOrg'));
	}


	public function actionDepartment()
	{
		$model = new Orgchart('search');
		$model->unsetAttributes();  // clear any default values
		$model->level = "3";

		if(isset($_GET['OrgChart'])){
			$model->attributes=$_GET['OrgChart'];
		}

		$this->render('Department',array(
			'model'=>$model,
		));
	}


	public function actionDepartment_create()
	{
		$model = new Orgchart;

		if(isset($_POST['OrgChart']))
		{
			
			$model->attributes=$_POST['OrgChart'];
			$model->level = 3;
			// $model->parent_id = 1;

			if($model->save()){				
				
				$model->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('Department'));
			}
		}

		$this->render('Department_create',array(
			'model'=>$model,
		));

	}



	public function actionDepartment_create()
	{
		$model = new Orgchart;
		// $model->scenario = 'validateCheckk';

		if(isset($_POST['OrgChart']))
		{
			// var_dump($_POST['OrgChart']);exit();
			$model->attributes=$_POST['OrgChart'];
			$model->level = 3;
			                                                                       

			if($model->save()){				
				$model->save(false);
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}

				$this->redirect(array('Department'));
			}
		}

		$this->render('Department_create',array(
			'model'=>$model,
		));

	}


	public function actionManageorguser()
	{	
		if(isset($_GET["id"]) && $_GET["id"] != ""){
			$orgid = $_GET["id"];
		}else{
			$this->redirect(array('OrgChart/index'));
		}		

		if (!empty($_GET['user_list'])) {
			foreach ($_GET['user_list'] as $key => $value) {

				$chk_old = OrgUser::model()->find("orgchart_id='".$orgid."' AND user_id='".$value."' ");

				if($chk_old != ""){
					$model = OrgUser::model()->findByPk($chk_old->id);
					$model->active = 'y';
					$model->authority_id = null;
				}else{
					$model = new OrgUser;
					$model->orgchart_id = $orgid;
					$model->user_id = $value;
				}
				
				$model->save();

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($value);
				}
			}

			$this->redirect(array('OrgChart/Manageorguser/'.$orgid));

		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$value = $_POST['user_id'];
				$chk_old = OrgUser::model()->find("orgchart_id='".$orgid."' AND user_id='".$value."' ");
				$chk_old->active = 'n';
				$chk_old->save();

				$org_position = OrgPosition::model()->findAll(array(
					'select'=>'id',
					'condition'=>'user_id="'.$value.'" AND state="y" ',
				));
				foreach ($org_position as $key_p => $val_p) {
					$mo_posi = OrgPosition::model()->findByPk($val_p->id);
					if($mo_posi){
						$mo_posi->state = "n";
						$mo_posi->save();
					}
				}



				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}

		//--------------------*******************************************-------------------------//

		$arr_user_all = [];
		$OrgUser = OrgUser::model()->findAll('active="y" GROUP BY user_id');
		if(!empty($OrgUser)){
			foreach ($OrgUser as $key => $value) {
				$arr_user_all[] = $value->user_id;
			}
		}
		$criteria = new CDbCriteria;
		// $criteria->compare('superuser', 1);
		$criteria->compare('del_status', 0);
		$criteria->compare('status', 1);
		// $criteria->addCondition('authority_hr IS NULL');
		$criteria->addNotInCondition('id',$arr_user_all);
		$userAll = User::model()->with('profile')->findAll($criteria);

		$arr_user = [];
		$OrgUser_2 = OrgUser::model()->findAll('orgchart_id="'.$orgid.'" AND active="y" GROUP BY user_id');
		if(!empty($OrgUser_2)){
			foreach ($OrgUser_2 as $key => $value) {
				$arr_user[] = $value->user_id;
			}
		}

		$criteria = new CDbCriteria;
		$criteria->addInCondition('id',$arr_user);
		$criteria->compare('del_status', 0);
		$criteria->compare('status', 1);
		$user = User::model()->with('profile')->findAll($criteria);

		$this->render('manage_org_user', array('userAll'=>$userAll, 'user'=>$user));

	}

	public function actionManageorgapprove(){

		if(isset($_GET["id"]) && $_GET["id"] != ""){
			$orgid = $_GET["id"];
		}else{
			$this->redirect(array('OrgChart/index'));
		}

		$arr_user = [];
		$OrgUser_2 = OrgUser::model()->findAll('orgchart_id="'.$orgid.'" AND active="y" GROUP BY user_id');
		if(!empty($OrgUser_2)){
			foreach ($OrgUser_2 as $key => $value) {
				$arr_user[] = $value->user_id;
			}
		}

		$criteria = new CDbCriteria;
		$criteria->addInCondition('id',$arr_user);
		$user = User::model()->with('profile')->findAll($criteria);

		$this->render('manage_org_approve', array('user'=>$user));
	}

	public function actionManageorgapproveupdate(){

		// var_dump($_GET["id"]);
		// var_dump($_GET["user"]);
		// exit();
		if(isset($_GET["id"]) && $_GET["id"] != "" && isset($_GET["user"]) && $_GET["user"] != ""){
			$orgid = $_GET["id"];
			$user_id = $_GET["user"];
		}else{
			$this->redirect(array('OrgChart/index'));
		}

		$OrgUser = OrgUser::model()->find("orgchart_id='".$orgid."' AND user_id='".$user_id."' ");

		// var_dump($_GET['org_id']); exit();
		if(!empty($_POST['org_id'])){
			$arr_org = [];
			$arr_org = json_encode($_POST['org_id']);
			$OrgUser->authority_id = $arr_org;
			$OrgUser->save();

			$this->redirect(array('OrgChart/Manageorgapprove/'.$_GET["id"]));			
		}


		$chk_org = [];
		$chk_org = json_decode($OrgUser->authority_id);

		$model = Orgchart::model()->findAll("active='y' AND level=4");

		$profile = User::model()->with('profile')->findByPk($user_id);

		$this->render('manage_org_approve_update', array('model'=>$model, 'chk_org'=>$chk_org, 'profile'=>$profile));
	}





	public function actionManage()
	{
		$model=new OrgChart('searchPosition');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrgChart']))
			$model->attributes=$_GET['OrgChart'];

		$this->render('course_manage',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OrgChart;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgChart']))
		{
			$model->attributes=$_POST['OrgChart'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId();
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCourse($id){
		// $model_org = OrgChart::model()->findByPk($id);
		

		// var_dump($_GET['type_course']); exit();
	    if(isset($_GET['name'])){
	    	$criteria = new CDbCriteria;
	    	$criteria->with = array('courses');
	    	$criteria->compare('courseonline.active','y');
	    	$criteria->compare('title_all',$_GET['name']);
	    	$criteria->group = 'courseonline.course_id';
	    	$modelCourse = OrgRoot::model()->findAll($criteria);
	    }elseif(isset($_GET['type_course']) && $_GET['type_course'] == "out"){
	    	$criteria = new CDbCriteria;
	    	$criteria->with = array('courses');
	    	$criteria->group = 'courseonline.course_id';
	    	$criteria->compare('courseonline.active','y');
	    	$criteria->compare('orgchart_id',$id);
	    	$modelCourse = OrgCourseOut::model()->findAll($criteria);
	    }else{
	    	$criteria = new CDbCriteria;
	    	$criteria->with = array('courses');
	    	$criteria->group = 'courseonline.course_id';
	    	$criteria->compare('courseonline.active','y');
	    	$criteria->compare('orgchart_id',$id);
	    	$modelCourse = OrgCourse::model()->findAll($criteria);
	    }


// var_dump($modelCourse); exit();
	    
	    $courseArray = array();
		foreach ($modelCourse as $key => $value) {
			$courseArray[] = $value->course_id;
		}
		if(isset($id))
		{
			$model = new CourseOnline('search');
			$model->unsetAttributes();
			if(isset($_GET['CourseOnline']))
				$model->attributes=$_GET['CourseOnline'];
				$model->searchCourse = true;
				$model->org = $courseArray;

				$this->render('course_list',array(
					'model' => $model,
					'modelCourse'=>$modelCourse,
					'position_id' => $id,
				));
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionGet_dialog_user()
    {

	     $position_id = $_POST['position_id'];
	     $criteria = new CDbCriteria();
	     $criteria->compare('position_id',$position_id);
	     $userObject = Users::model()->findAll($criteria);
	     $respon = '';
	     $respon = $this->renderPartial('_modal_user',array('userObject' => $userObject));
	     exit();
	 }



	 // public function actionCheckUser($course_id,$position_id,$all){
	 public function actionCheckUser(){
	 	//User
	 	$all = $_GET['all'];
	 	$position_id = $_GET['position_id'];
	 	$course_id = $_GET['id'];



	 	if(!empty($_POST['id'])){
	 		
	 		$saveUserApplied = $_POST['id'];
	 		if($saveUserApplied) {
	 			foreach ($saveUserApplied as $user) {
	 				$model = OrgPosition::model()->findByAttributes(array(
	 					'user_id' => $user,
	 					'course_id' => $course_id
	 				));

	 				if($model){
	 					$model->state='n';
	 					$model->save();
	 				}

	 				$criteria = new CDbCriteria();
	 				$criteria->compare('parent_id',$course_id);
	 				$Parent_course = CourseOnline::model()->findAll($criteria);

	 				$model = OrgPosition::model()->findByAttributes(array(
	 					'user_id' => $user,
	 					'course_id' => $Parent_course[0]->course_id,
	 				));

	 				if($model){
	 					$model->state='n';
	 					$model->save();
	 				}

	 			}
	 		}
	 	}

	 	if(!empty($_POST['id2'])){ // ลบผุ้เรียนออกจาหลักสูตร

	 		foreach ($_POST['id2'] as $key_2 => $value_2) {
	 			$user = $value_2;
	 		$Orgpos = OrgChart::model()->findByPk($position_id);

			$criteria = new CDbCriteria();
		 	$criteria->compare('parent_id',$course_id);
			$Parent_course = CourseOnline::model()->findAll($criteria);

			$criteria = new CDbCriteria();
		 	$criteria->compare('user_id',$user);
		 	$criteria->compare('course_id',$course_id);
			$CheckUser = OrgPosition::model()->findAll($criteria);

 			if (empty($CheckUser)) {
				$model = new OrgPosition;
 				$model->course_id = $course_id;
 				$model->user_id = $user;
 				$model->org_root_title = $orgRoot->title;
				$model->state = "y";
 				$model->save();

				$model = new OrgPosition;
				$model->user_id = $user;
 				$model->org_root_title = $orgRoot->title;
 				$model->course_id = $Parent_course[0]->course_id;
 				$model->state = "y";
 				$model->save();
 			}else{

				$model = OrgPosition::model()->findByAttributes(array(
				        'user_id' => $user,
				        'course_id' => $course_id,
			   	));

				if($model){
					$model->state='y';
					$model->save();
				}

				$criteria = new CDbCriteria();
			 	$criteria->compare('parent_id',$course_id);
				$Parent_course = CourseOnline::model()->findAll($criteria);

				$model = OrgPosition::model()->findByAttributes(array(
				        'user_id' => $user,
				        'course_id' => $Parent_course[0]->course_id,
			   	));

				if($model){
					$model->state='y';
					$model->save();
				}

 			}

	 		} // foreach


	 	} // id2










	 	

	 	$Orgpos = OrgChart::model()->findByPk($position_id);

	 	$org_user = OrgUser::model()->findAll("orgchart_id='".$position_id."' AND active='y' ");
	 	$org_position = OrgPosition::model()->findAll("course_id='".$course_id."' AND state='y' ");

	 	$arr_user = [];
	 	if(!empty($org_user)){
	 		foreach ($org_user as $key => $value) {
	 			$arr_user[] = $value->user_id;
	 		}
	 	} 	

	 	$arr_position = [];
	 	if(!empty($org_position)){
	 		foreach ($org_position as $key => $value) {
	 			$arr_position[] = $value->user_id;
	 		}
	 	} 	
	 	// var_dump($arr_user); exit();

	 	$criteria = new CDbCriteria();
	 	$criteria->compare('status','1');
	 	$criteria->addInCondition('id',$arr_user);
	 	$criteria->addNotInCondition('id',$arr_position);
	 	$getAlluser = Users::model()->findAll($criteria);

	 	$criteria = new CDbCriteria();
	 	$criteria->compare('status','1');
	 	$criteria->addInCondition('id',$arr_position);
	 	$criteria->addInCondition('id',$arr_user);
	 	$user_del = Users::model()->findAll($criteria);



	 	$this->render('user_list',array(
			'model'=>$getAlluser,
			'model_del'=>$user_del,
			// 'mtId'=>$mtId,
			'state'=>$state,
			'all'=>$all,
			'position_id'=>$position_id,
			'id'=>$course_id,

		));
	 }

	public function actionUserModal() {
		$respon = '';
		$position_id = $_POST['position_id'];
		$course_id = $_POST['course_id'];
		if($course_id != null && $position_id != null) {
			$state = false;
		    $OrgChartModel = OrgChart::model()->findByPk($position_id);
		    if($OrgChartModel->orgchartParent->title){
		    	if($OrgChartModel->orgchartParent->title == "Fitness"){
		    		$state = true;
		    	}
		    }

			$criteria = new CDbCriteria();
		    $criteria->compare('position_id',$position_id);
		    $getAlluser = Users::model()->findAll($criteria);

		    //model orgchart_user
			$model = OrgPosition::model()->findAll(array(
				'condition'=>'course_id = "'.$course_id.'"'
			));

			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId[$key] = $value->user_id;
			}
			if($getAlluser) {
				$respon .= '<table class="table table-striped user-list">';
				$respon .= '<input type="hidden" name="course_id" value="' . $course_id . '">';
				$respon .= '<thead>';
				$respon .= '<tr>';
				$respon .= '<th style="width:90px;"><input type="checkbox" id="checkAll" /> ทั้งหมด</th>';
				$respon .= '<th>ชื่อ-นามสกุล</th>';
				if($state){
					$respon .= '<th>PT Grading</th>';
				}
				$respon .= '</tr>';
				$respon .= '</thead>';
				$respon .= '<tbody>';
				foreach ($getAlluser as $user) {
					$checked = '';
					if(in_array($user['id'], $mtId)){
						$checked = 'checked';
					}
					$respon .= '<tr>';
					$respon .= '<td>';
					$respon .= '<input class="userCheckList" type="checkbox" ' . $checked . ' value="' . $user['id'] . '"> ';
					$respon .= '</td>';
					$respon .= '<td>';
					$respon .= $user->profiles->firstname.' '.$user->profiles->lastname;
					$respon .= '</td>';
					if($state){
						$respon .= '<td>';
						$respon .= $user->grades->grade_title;
						$respon .= '</td>';
					}
					$respon .= '</tr>';
					$respon .= '</tbody>';
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

	public function actionSaveUserModal() {
		$course_id = $_POST['course_id'];
		$saveUserApplied = json_decode($_POST['checkedList']);
		$model = OrgPosition::model()->deleteAll(array(
			'condition'=>'course_id = "'.$course_id.'"'
		));
		if($saveUserApplied) {
			foreach ($saveUserApplied as $user) {
				$model = OrgPosition::model()->deleteAll(array(
					'condition'=>'course_id = "'.$user.'"'
				));
				$model = new OrgPosition;
				$model->course_id = $course_id;
				$model->user_id = $user;
				$model->save();
			}
		}
		echo true;
	}



	public function actionSaveOrgchart()
	{
		$allorg = OrgChart::model()->findAll();
		$chk_org = array();
		foreach ($allorg as $value) {
			$chk_org[] = $value->id;
		}

			// echo "<pre>"; var_dump($_POST['post_value']);exit();
		if(isset($_POST['post_value'])){
			$chk_org_new = array();
			// foreach($_POST['post_value'] as $value){
			// 	var_dump($value);
			// }
			// exit();
			foreach($_POST['post_value'] as $value){
				$chk_org_new[] = $value['id'];
				$model_org = OrgChart::model()->findByPk($value['id']);
				// var_dump($_POST['post_value']);
				// exit();
				if($value['id']!=1 && $value['parent_id']==""){
					$parent_value = 1;
					$level_value = 2;
				}else{
					$parent_value = $value['parent_id'];
					$level_value = $value['level'];
				}

				if($model_org){
					$model_org->title = $this->Strrename($value['key']);
					$model_org->code = $value['text_code'];
					$model_org->parent_id = $parent_value;
					$model_org->level = $level_value;
					$model_org->save();
				}else{
					$model = new OrgChart;
					$model->title = $this->Strrename($value['key']);
					$model->code = $value['text_code'];
					$model->parent_id = $parent_value;
					$model->level = $level_value;
					$model->save();
				}
			}
		}

		$result_org = array_diff($chk_org,$chk_org_new);

		foreach ($result_org as $value) {
			$model_orgchart = OrgChart::model()->findByPk($value);
			$model_orgchart->active = 'n';
			$model_orgchart->save();
		}

		$this->render('index');
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OrgChart']))
		{
			$model->attributes=$_POST['OrgChart'];
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionDeleteOrg()
	{
		
		if(!empty($_GET)){
		 	$all = $_GET['all'];
		 	$position_id = $_GET['position_id'];
		 	$course_id = $_GET['id'];
		 	$user = $_GET['user_id'];
	 		$Orgpos = OrgChart::model()->findByPk($position_id);

			$criteria = new CDbCriteria();
		 	$criteria->compare('parent_id',$course_id);
			$Parent_course = CourseOnline::model()->findAll($criteria);

			$criteria = new CDbCriteria();
		 	$criteria->compare('user_id',$user);
		 	$criteria->compare('course_id',$course_id);
			$CheckUser = OrgPosition::model()->findAll($criteria);

 			if (empty($CheckUser)) {
				$model = new OrgPosition;
 				$model->course_id = $course_id;
 				$model->user_id = $user;
 				$model->org_root_title = $orgRoot->title;
				$model->state = "y";
 				$model->save();

				$model = new OrgPosition;
				$model->user_id = $user;
 				$model->org_root_title = $orgRoot->title;
 				$model->course_id = $Parent_course[0]->course_id;
 				$model->state = "y";
 				$model->save();
 			}else{

				$model = OrgPosition::model()->findByAttributes(array(
				        'user_id' => $user,
				        'course_id' => $course_id,
			   	));
				$model->state='y';
				$model->save();

				$criteria = new CDbCriteria();
			 	$criteria->compare('parent_id',$course_id);
				$Parent_course = CourseOnline::model()->findAll($criteria);

				$model = OrgPosition::model()->findByAttributes(array(
				        'user_id' => $user,
				        'course_id' => $Parent_course[0]->course_id,
			   	));
				$model->state='y';
				$model->save();

 			}
			$this->redirect(array('CheckUser','id'=>$course_id,'all'=>$all,'position_id'=>$position_id));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{


/*		$root=new OrgChart;
		$root->title='Mobile Phones';
		$root->saveNode();
		$root=new OrgChart;
		$root->title='Cars';
		$root->saveNode();
		$OrgChart1=new OrgChart;
		$OrgChart1->title='Ford';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='Mercedes';
		$OrgChart3=new OrgChart;
		$OrgChart3->title='Audi';
		$root=OrgChart::model()->findByPk(1);
		$OrgChart1->appendTo($root);
		$OrgChart2->insertAfter($OrgChart1);
		$OrgChart3->insertBefore($OrgChart1);

		$OrgChart1=new OrgChart;
		$OrgChart1->title='Samsung';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='Motorola';
		$OrgChart3=new OrgChart;
		$OrgChart3->title='iPhone';
		$root=OrgChart::model()->findByPk(2);
		$OrgChart1->appendTo($root);
		$OrgChart2->insertAfter($OrgChart1);
		$OrgChart3->prependTo($root);

		$OrgChart1=new OrgChart;
		$OrgChart1->title='X100';
		$OrgChart2=new OrgChart;
		$OrgChart2->title='C200';
		$node=OrgChart::model()->findByPk(3);
		$OrgChart1->appendTo($node);
		$OrgChart2->prependTo($node);
*/



		$dataProvider=new CActiveDataProvider('OrgChart');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionOrgChart2()
	{
		$this->renderPartial('orgchart2');
	}

	public function actionOrgChartSave()
	{

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OrgChart('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrgChart']))
			$model->attributes=$_GET['OrgChart'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	private function Strrename($name){
		$replace = str_replace("*", "", $name);
		return $replace;

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OrgChart the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OrgChart::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OrgChart $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='org-chart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
