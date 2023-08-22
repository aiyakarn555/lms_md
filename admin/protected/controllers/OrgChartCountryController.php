<?php

class OrgChartCountryController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
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
			'postOnly + delete', // we only allow deletion via POST request
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
        		'actions'=>array('index','view','OrgChart2','OrgChartSave','SaveOrgchart', 'CheckUser','Course', 'DelUser','DelteUser','CreateUser','AddUserTo'),
        		'users'=>array('*'),
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

	public function actionListorg()
	{
		$model= OrgChart::model()->findAll();
		var_dump($model);exit();
	}

	public function actionEditorg()
	{
		$modelRoot= OrgChart::model()->findByPk(1177);
		$modelRoot->parent_id = null;
		$modelRoot->level = 1;
		$modelRoot->save();

		$model= OrgChart::model()->findByPk(1179);
		$model->parent_id = 1177;
		$model->level = 2;
		$model->save();
		
	}

	public function actionDel()
	{
		$model= OrgChart::model()->findAll();
		foreach ($model as $key => $value) {
			$this->loadModel($value->id)->delete();
		}
		
	}

	public function actionNeworg()
	{
		$model = new OrgChart;
		$model->id = 1;
		$model->title = 'Air Asiaแผนก TEST';
		$model->parent_id = null;
		$model->level = 1;
		$model->active = 'y';
		$model->save();

		$model = new OrgChart;
		$model->id = 2;
		$model->title = 'LMS';
		$model->parent_id = 1;
		$model->level = 2;
		$model->active = 'y';
		$model->save();

		$model = new OrgChart;
		$model->id = 4;
		$model->title = 'TMS';
		$model->parent_id = 1;
		$model->level = 2;
		$model->active = 'y';
		$model->save();
		
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



	public function actionSaveOrgchart()
	{
		$allorg = OrgChart::model()->findAll();
		$chk_org = array();
		foreach ($allorg as $value) {
			$chk_org[] = $value->id;
		}

		if(isset($_POST['post_value'])){
			$chk_org_new = array();
			foreach($_POST['post_value'] as $key => $value){
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
					$model_org->title = $value['key']; //********
					$model_org->parent_id = $parent_value;
					$model_org->level = $level_value;
					$model_org->save();
				}else{
					$model = new OrgChart;
					$model->title = $value['key'];
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
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
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

	/**
	 * Lists all models.
	 */


	public function actionCourse($id){
		// $model_org = OrgChart::model()->findByPk($id);
	    if(isset($_GET['name'])){
	    	$criteria = new CDbCriteria;
	    	$criteria->with = array('courses');
	    	$criteria->compare('courseonline.active','y');
	    	$criteria->compare('title_all',$_GET['name']);
	    	$criteria->group = 'courseonline.course_id';
	    	$modelCourse = OrgRoot::model()->findAll($criteria);
	    }else{
	    	$criteria = new CDbCriteria;
	    	$criteria->with = array('courses');
	    	$criteria->group = 'courseonline.course_id';
	    	$criteria->compare('courseonline.active','y');
	    	$criteria->compare('orgchart_id',$id);
	    	$modelCourse = OrgCourse::model()->findAll($criteria);
	    }
	    
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

	public function actionCheckUserbk(){

	//User
	$all = $_GET['all'];
	$course_id = $_GET['id'];
	$org_id = $_GET['orgchart_id'];	

	$orgRoot = OrgChart::model()->findByPk($org_id);

		// $modelUsers_old = ChkUsercourse::model()->findAll(
		// 				array(
		// 					'condition' => 'course_id=:course_id  ',
		// 					'params' => array(':course_id'=>$course_id)
		// 				)
		// 			);
	if($orgRoot->branch_id != null || $orgRoot->position_id != null || $orgRoot->department_id != null ){
	$criteria = new CDbCriteria; 
	$criteria->compare('course_id',$course_id);

		if($orgRoot->branch_id != ""){ // branch
		$criteria->compare('branch_id',$orgRoot->branch_id);
		}elseif($orgRoot->position_id != ""){ // position
			$criteria->compare('position_id',$orgRoot->position_id);
		}elseif($orgRoot->department_id != ""){ // dept
			$criteria->compare('department_id',$orgRoot->department_id);
		}

		// var_dump($orgRoot->branch_id);
		// var_dump($orgRoot->position_id);
		// var_dump($orgRoot->department_id);

		$modelUsers_old = ChkUsercourse::model()->findAll($criteria);
	}
			// array(
			// 		'condition' => 'course_id=:course_id AND department_id=:department_id AND position_id=:position_id',
				// 			'params' => array(':course_id'=>$course_id,':department_id'=>$orgRoot->department_id , ':position_id'=>$orgRoot->position_id )
			// 	)
		

	$criteria = new CDbCriteria; 
	$criteria->with = array('chk_usercourse');
	if($orgRoot->branch_id == null && $orgRoot->position_id == null && $orgRoot->department_id == null){
		if($orgRoot->title == "General"){
			$criteria->compare('type_user',1);


		}elseif($orgRoot->title == "Personnel"){
			$criteria->compare('type_user',3);

		}
		elseif($orgRoot->title == "MASTER / CAPTAIN"){
			$criteria->compare('type_employee',1);
		}
		elseif($orgRoot->title == "Office"){
			$criteria->compare('type_employee',2);
		}
	}else{

		if($orgRoot->branch_id != ""){ // branch
			$criteria->compare('t.branch_id',$orgRoot->branch_id);

		}elseif($orgRoot->position_id != ""){ // position
			$criteria->compare('t.position_id',$orgRoot->position_id);

		}elseif($orgRoot->department_id != ""){ // dept
			$criteria->compare('t.department_id',$orgRoot->department_id);
		}
		}

		// var_dump(expression)
		if($modelUsers_old){
		$criteria->compare('chk_usercourse.org_user_status',1);
		$criteria->compare('chk_usercourse.course_id',$course_id);

		}

	$users = Users::model()->with('profiles')->findAll($criteria);

	if(!$modelUsers_old){
		$users = array();
		}

	$criteria = new CDbCriteria; 
	$criteria->with = array('chk_usercourse');
	if($orgRoot->branch_id == null && $orgRoot->position_id == null && $orgRoot->department_id == null){
		if($orgRoot->title == "General"){
			$criteria->compare('type_user',1);

		}elseif($orgRoot->title == "Personnel"){
			$criteria->compare('type_user',3);

		}
		elseif($orgRoot->title == "MASTER / CAPTAIN"){
			$criteria->compare('type_employee',1);
		}
		elseif($orgRoot->title == "Office"){
			$criteria->compare('type_employee',2);
		}
	}else{

		if($orgRoot->branch_id != ""){ // branch
			$criteria->compare('t.branch_id',$orgRoot->branch_id);

		}elseif($orgRoot->position_id != ""){ // position
			$criteria->compare('t.position_id',$orgRoot->position_id);

		}elseif($orgRoot->department_id != ""){ // dept
			$criteria->compare('t.department_id',$orgRoot->department_id);
		}
		}	
		// var_dump($orgRoot->department_id);
		// var_dump($orgRoot->position_id);
		// var_dump($orgRoot->branch_id);



		$usersall_chk = Users::model()->with('profiles')->findAll($criteria);


		if($modelUsers_old){
		$criteria->compare('chk_usercourse.org_user_status',0);
		$criteria->compare('chk_usercourse.course_id',$course_id);
		}

		$usersall = Users::model()->with('profiles')->findAll($criteria);



	$state = "";
	$paren = $orgRoot->parent_id;
	$orgLvPosi = OrgChart::model()->findByPk($paren);
	$orgLvDeb = OrgChart::model()->findByPk($orgLvPosi->parent_id);

	if($org_id == '3' || $org_id == '5'){
		$state = "personnel_office";
	}elseif($org_id == '4'){
		$state = "master_captain";
	}elseif($orgRoot->level == '4'){
		$state = "state_dep_office";
		if($orgRoot->parent_id == '4'){
			$state = "state_dep_captain";
		}
	}elseif($orgRoot->level == '5'){
		$state = "state_posi_office";
		if($orgLvDeb->id != '5'){
			$state = "";
		}
	}

		// var_dump($state);exit();

	$this->render('user_list',array(
		'model'=>$users,
		'modelall'=>$usersall,
		'state'=>$state,
		'usersall_chk'=>$usersall_chk

	));
	}
	 public function actionCheckUser(){

		//User
		$all = $_GET['all'];
		$course_id = $_GET['id'];
		$org_id = $_GET['orgchart_id'];	

		$orgRoot = OrgChart::model()->findByPk($org_id);

		$criteria = new CDbCriteria; 
		$criteria->compare('orgchart_lv2',$orgRoot->code);
		$userall = Users::model()->findAll($criteria);

		$userID = array();
		foreach($userall as $user){
			$userID[] = $user->id;
		}
		
		$criteria = new CDbCriteria;
		$criteria->addIncondition('user_id',$userID);
		$criteria->compare('course_id',$course_id);
		$criteria->compare('org_user_status',1);
		$userdelete = ChkUsercourse::model()->findAll($criteria);


		$this->render('user_list',array(
		   'model'=>$users,
		   'modelall'=>$usersall,
		   'state'=>$state,
		   'usersall_chk'=>$usersall_chk

	   ));
	}


 public function actionCreateUser(){


	 $org_id = $_POST['org_id'];	
	 $course_id = $_POST['course_id'];

	 	$orgRoot = OrgChart::model()->findByPk($org_id);

	 	$criteria = new CDbCriteria; 
	 	$criteria->with = array('chk_usercourse');
	 	$criteria->compare('chk_usercourse.org_user_status',1);
	 	if($orgRoot->branch_id == null && $orgRoot->position_id == null && $orgRoot->department_id == null){ 
	 		if($orgRoot->title == "General"){
	 			$criteria->compare('type_user',1);

	 		}elseif($orgRoot->title == "Personnel"){
	 			$criteria->compare('type_user',3);

	 		}
	 		elseif($orgRoot->title == "MASTER / CAPTAIN"){
	 				$criteria->compare('type_employee',1);
	 		}
	 		elseif($orgRoot->title == "Office"){
	 			$criteria->compare('type_employee',2);
	 		}
	 	}else{

		 	if($orgRoot->branch_id != ""){ // branch
		 		$criteria->compare('t.branch_id',$orgRoot->branch_id);

		 	}elseif($orgRoot->position_id != ""){ // position
		 		$criteria->compare('t.position_id',$orgRoot->position_id);

		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$criteria->compare('t.department_id',$orgRoot->department_id);
		 	}
	 	}



	 	$users_test = Users::model()->with('profiles')->findAll($criteria);

	 	if($_POST['all'] != null){
	 			foreach ($users_test as $key => $val) {
	 				// $modelUsers_old = ChkUsercourse::model()->find(
	 				// 		array(
	 				// 			'condition' => 'course_id=:course_id AND user_id=:user_id AND department_id=:department_id AND position_id=:position_id AND branch_id=:branch_id  ',
	 				// 			'params' => array(':course_id'=>$course_id, ':user_id'=>$value , ':department_id'=>$orgRoot->department_id , ':position_id'=>$orgRoot->position_id , ':branch_id'=>$orgRoot->branch_id)
	 				// 		)
	 				// 	);

	 				$criteria = new CDbCriteria; 
	 				$criteria->compare('course_id',$course_id);
	 				$criteria->compare('user_id',$val->id);
	 		if($orgRoot->branch_id != ""){ // branch
	 			$criteria->compare('branch_id',$orgRoot->branch_id);
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$criteria->compare('position_id',$orgRoot->position_id);
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$criteria->compare('department_id',$orgRoot->department_id);
		 	}

	 	 $modelUsers_old = ChkUsercourse::model()->find($criteria);

	 					if($modelUsers_old){
	 						$modelUsers_old->org_user_status = '0';
	 						if($modelUsers_old->save()){
	 							echo "pass";
	 						}
	 					}else{
	 						$modelUsers = new ChkUsercourse;
	 						$modelUsers->user_id = $val->id;
	 						$modelUsers->course_id = $course_id;
	 						$modelUsers->position_id = $orgRoot->position_id;
	 						$modelUsers->department_id = $orgRoot->department_id;
	 						$modelUsers->branch_id = $orgRoot->branch_id;
	 						if($modelUsers->save()){
	 							echo "passnew";
	 						}
	 					}
	 			}

	 	}else{

	 			foreach ($_POST['id_arr']  as $key => $value) {
	 				if($value != null){

	 					$criteria = new CDbCriteria; 
	 					$criteria->compare('course_id',$course_id);
	 					$criteria->compare('user_id',$value);
	 		if($orgRoot->branch_id != ""){ // branch
	 			$criteria->compare('branch_id',$orgRoot->branch_id);
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$criteria->compare('position_id',$orgRoot->position_id);
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$criteria->compare('department_id',$orgRoot->department_id);
		 	}

		 	$modelUsers_old = ChkUsercourse::model()->find($criteria);


	 					if($modelUsers_old){
	 						$modelUsers_old->org_user_status = '0';
	 						if($modelUsers_old->save()){
	 							echo "pass";
	 						}
	 					}else{
	 						$modelUsers = new ChkUsercourse;
	 						$modelUsers->user_id = $value;
	 						$modelUsers->course_id = $course_id;
	 						$modelUsers->position_id = $orgRoot->position_id;
	 						$modelUsers->department_id = $orgRoot->department_id;
	 						$modelUsers->branch_id = $orgRoot->branch_id;
	 						if($modelUsers->save()){
	 							echo "passnew";
	 						}
	 					}

	 					
	 				}
	 			}
	 	}
}
	  public function actionDelteUser(){

	  	$id = $_POST['user_id'];
	  	$org_id = $_POST['org_id'];	
	  	$course_id = $_POST['course_id'];
	  	$id_all = $_POST['id_all'];

	  	$orgRoot = OrgChart::model()->findByPk($org_id);

	  	foreach ($id_all as $key => $value) {

	  		if($id != $value){

	  				$criteria = new CDbCriteria; 
	 				$criteria->compare('course_id',$course_id);
	 				$criteria->compare('user_id',$value);
	 		if($orgRoot->branch_id != ""){ // branch
	 			$criteria->compare('branch_id',$orgRoot->branch_id);
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$criteria->compare('position_id',$orgRoot->position_id);
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$criteria->compare('department_id',$orgRoot->department_id);
		 	}

	 	 $modelUsers_old_chk = ChkUsercourse::model()->find($criteria);


	  			if(!$modelUsers_old_chk){
	  				$modelUsers = new ChkUsercourse;
	  				$modelUsers->user_id = $value;
	  				$modelUsers->course_id = $course_id;
	  				$modelUsers_old->org_user_status = '0';
	  				$modelUsers->position_id = $orgRoot->position_id;
	  				$modelUsers->department_id = $orgRoot->department_id;
	  				$modelUsers->branch_id = $orgRoot->branch_id;
	  				if($modelUsers->save()){
	  				}
	  			}

	  		}

	  	}


	  
	  	$criteria = new CDbCriteria; 
	  	$criteria->compare('course_id',$course_id);
	  	$criteria->compare('user_id',$id);
	 		if($orgRoot->branch_id != ""){ // branch
	 			$criteria->compare('branch_id',$orgRoot->branch_id);
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$criteria->compare('position_id',$orgRoot->position_id);
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$criteria->compare('department_id',$orgRoot->department_id);
		 	}

		 	$modelUsers_old = ChkUsercourse::model()->find($criteria);


	  	if($modelUsers_old){
	  		$modelUsers_old->org_user_status = '1';
	  		if($modelUsers_old->save()){
	  			echo "pass";
	  		}
	  	}else{
	  		$modelUsers = new ChkUsercourse;
	  		$modelUsers->user_id = $id;
	  		$modelUsers->course_id = $course_id;
	  		$modelUsers->org_user_status = '1';
	  		$modelUsers->position_id = $orgRoot->position_id;
	  		$modelUsers->department_id = $orgRoot->department_id;
	  		$modelUsers->branch_id = $orgRoot->branch_id;

	  		if($modelUsers->save()){
	  			echo "passnew";
	  		}
	  	}
	  }


	  public function actionDelUser(){

	 	//User
	 	$all = $_GET['all'];
	 	$org_id = $_GET['orgchart_id'];	
	 	$course_id = $_GET['id'];

	 	if(isset($_POST['user-list_length'])){
	 		$user_id_arr = $_POST;
	 		unset($user_id_arr['user-list_length']);
	 		unset($user_id_arr['yt0']);

	 		foreach ($user_id_arr as $value) {	
	 			$modelUsers = Users::model()->findByPk($value);
	 			$modelUsers->org_user_status = '1';
	 			$modelUsers->save();
	 		}
	 	}

	 	$orgRoot = OrgChart::model()->findByPk($org_id);

	 	// var_dump($orgRoot);exit();
	 	if($orgRoot->branch_id == null && $orgRoot->position_id == null && $orgRoot->department_id == null){
	 		if($orgRoot->title == "General"){
	 			$con_text = "type_user='1' AND org_user_status='0'";
	 		}elseif($orgRoot->title == "Personnel"){
	 			$con_text = "type_user='3' AND org_user_status='0'";
	 		}
	 		elseif($orgRoot->title == "MASTER / CAPTAIN"){
	 			$con_text = "type_employee='1' AND org_user_status='0'";
	 		}
	 		elseif($orgRoot->title == "Office"){
	 			$con_text = "type_employee='2' AND org_user_status='0'";
	 		}
	 	}else{
		 	if($orgRoot->branch_id != ""){ // branch
		 		$con_text = "branch_id='".$orgRoot->branch_id."'" ." AND ". "org_user_status='0'";
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$con_text = "position_id='".$orgRoot->position_id."'" ." AND ". "org_user_status='0'";
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$con_text = "department_id='".$orgRoot->department_id."'" ." AND ". "org_user_status='0'";
		 	}
	 	}

	 	// var_dump($con_text);exit();

	 	$users = Users::model()->with('profiles')->findAll($con_text);

	    // var_dump($users);exit();

		$state = "";
		$paren = $orgRoot->parent_id;
		$orgLvPosi = OrgChart::model()->findByPk($paren);
		$orgLvDeb = OrgChart::model()->findByPk($orgLvPosi->parent_id);

		if($org_id == '3' || $org_id == '5'){
			$state = "personnel_office";
		}elseif($org_id == '4'){
			$state = "master_captain";
		}elseif($orgRoot->level == '4'){
			$state = "state_dep_office";
			if($orgRoot->parent_id == '4'){
				$state = "state_dep_captain";
			}
		}elseif($orgRoot->level == '5'){
			$state = "state_posi_office";
			if($orgLvDeb->id != '5'){
				$state = "";
			}
		}

		// var_dump($state);exit();

	 	$this->render('user_list',array(
			'model'=>$users,
			'state'=>$state
		));
	 }

	  public function actionCheckUserTo(){
	 	
	 //User
	 	$all = $_GET['all'];
	 	// var_dump($all);exit();
	 	$org_id = $_GET['orgchart_id'];	
	 	// var_dump($org_id);exit();
	 	$course_id = $_GET['id'];
	 	// var_dump($course_id);exit();

	 	// if(isset($_POST)){
	 	// 	// var_dump("<pre>"); 
	 	// 	// var_dump($_POST); exit();
	 	// }

	 	$orgRoot = OrgChart::model()->findByPk($org_id);

	 	// var_dump($orgRoot);exit();
	 	if($orgRoot->branch_id == null && $orgRoot->position_id == null && $orgRoot->department_id == null){
	 		if($orgRoot->title == "General"){
	 			$con_text = "type_user=1";
	 		}elseif($orgRoot->title == "Personnel"){
	 			$con_text = "type_user=3";
	 		}
	 		elseif($orgRoot->title == "MASTER / CAPTAIN"){
	 			$con_text = "type_employee=1";
	 		}
	 		elseif($orgRoot->title == "Office"){
	 			$con_text = "type_employee=2";
	 		}
	 	}else{
		 	if($orgRoot->branch_id != ""){ // branch
		 		$con_text = "branch_id='".$orgRoot->branch_id."'";
		 	}elseif($orgRoot->position_id != ""){ // position
		 		$con_text = "position_id='".$orgRoot->position_id."'";
		 	}elseif($orgRoot->department_id != ""){ // dept
		 		$con_text = "department_id='".$orgRoot->department_id."'";
		 	}
	 	}

	 	$users = Users::model()->with('profiles')->findAll($con_text);

		$state = null;
	 	foreach ($users as $value) {
		 	if($value->profiles->type_employee == '2'){
		 		$state = true;
		 	}
	 	}

	 	 // var_dump($state);exit();

	 	$this->render('user_to',array(
			'model'=>$users,
			'state'=>$state
		));
	 }



	   public function actionAddUserTo(){

	  	$id = $_POST['user_id'];
	  	$org_id = $_POST['org_id'];	
	  	$course_id = $_POST['course_id'];

	  	$modelUsers_old_chk = ChkUsercourseto::model()->find(
	  		array(
	  			'condition' => 'course_id=:course_id AND user_id=:user_id AND orgchart_id=:orgchart_id',
	  			'params' => array(':course_id'=>$course_id, ':user_id'=>$id , ':orgchart_id'=>$org_id )
	  		)
	  	);

	  	if(empty($modelUsers_old_chk)){
	  		$modelUsers = new ChkUsercourseto;
	  		$modelUsers->user_id = $id;
	  		$modelUsers->course_id = $course_id;
	  		$modelUsers->orgchart_id = $org_id;

	  		if($modelUsers->save()){
	  		echo "passnew";
	  		}
	  	}else{
	  		echo "pass";
	  	}


	  }

	    public function actionDelteUserTo(){

	  	$id = $_POST['user_id'];
	  	$org_id = $_POST['org_id'];	
	  	$course_id = $_POST['course_id'];

	  	$modelUsers_old_chk = ChkUsercourseto::model()->find(
	  		array(
	  			'condition' => 'course_id=:course_id AND user_id=:user_id AND orgchart_id=:orgchart_id',
	  			'params' => array(':course_id'=>$course_id, ':user_id'=>$id , ':orgchart_id'=>$org_id )
	  		)
	  	);

	  	if(!empty($modelUsers_old_chk)){
	  		if($modelUsers_old_chk->delete()){
	  		echo "delete";
	  		}
	  	}else{
	  		echo "nodata";
	  	}


	  }





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




		$dataProvider=new CActiveDataProvider('OrgChartCountry');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionOrgChart2()
	{
		$this->renderPartial('orgChart2');
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

	public function actionLoadPos()
	{
		$dep_id  = $_POST["dep_id"];
		$criteria = new CDbCriteria;
		$criteria->compare('department_id',$dep_id);
		$criteria->order = 'position_title  ASC';
		$data = Position::model()->findAll($criteria);

		$datalist = CHtml::listdata($data,'id', 'position_title');
		echo "<option value=''> ทั้งหมด </option>";
		foreach ($datalist as $value => $Position){ 
			echo CHtml::tag('option',array('value' => $value),CHtml::encode($Position),true);
		}
	}


	public function actionLoadBranch()
	{
		$pos_id  = $_POST["pos_id"];
		$criteria = new CDbCriteria;
		$criteria->compare('position_id',$pos_id);
		$criteria->order = 'branch_name  ASC';
		$data = Branch::model()->findAll($criteria);

		$datalist = CHtml::listdata($data,'id', 'branch_name');
		echo "<option value=''> ทั้งหมด </option>";
		foreach ($datalist as $value => $Branch){ 
			echo CHtml::tag('option',array('value' => $value),CHtml::encode($Branch),true);
		}
	}



}
