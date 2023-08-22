<?php

class AdminUserController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	
	// private $_model;
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
            	'actions' => array('index', 'view'),
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

    // public function actionGetAjaxDivision(){
    //     if(isset($_GET['company_id']) && $_GET['company_id'] != ""){
    //         $datalist = Division::model()->findAll('active = "y" and company_id = '.$_GET['company_id']);
    //         if($datalist){
    //                 echo "<option value=''> เลือกกอง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->div_title."</option>";
    //             }
    //         }else{
    //                 echo "<option value=''> ไม่พบกอง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกกอง</option>";
    //     }
    // }

    // public function actionGetAjaxDepartment(){
    //     if(isset($_GET['division_id']) && $_GET['division_id'] != ""){
    //         $datalist = Department::model()->findAll('active = "y" and division_id = '.$_GET['division_id']);
    //         if($datalist){
    //                 echo "<option value=''> เลือกแผนก</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->dep_title."</option>";
    //             }
    //         }else{
    //                 echo "<option value=''> ไม่พบแผนก</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกแผนก</option>";
    //     }
    // }

    // public function actionGetAjaxPosition(){
    //     if(isset($_GET['department_id']) && $_GET['department_id'] != ""){
    //         $datalist = Position::model()->findAll('active = "y" and department_id = '.$_GET['department_id']);
    //         if($datalist){
    //                 echo "<option value=''> เลือกตำแหน่ง</option>";
    //             foreach($datalist as $index => $val){
    //                 echo "<option value='".$val->id."'>".$val->position_title."</option>";
    //             }
    //         }else{
    //                 echo "<option value=''> ไม่พบตำแหน่ง</option>";
    //         }
    //     }else{
    //         echo "<option value=''> เลือกตำแหน่ง</option>";
    //     }
    // }
    public function actionListPosition(){

     $model=Position::model()->findAll('department_id=:department_id',
        array(':department_id'=>$_POST['id']));

     $data=CHtml::listData($model,'id','position_title',array('empty' => 'ตำแหน่ง'));
     if ($data) {  
     $sub_list = 'เลือกตำแหน่ง';
     $data = '<option value ="">'.$sub_list.'</option>';
     foreach ($model as $key => $value) {
        $data .= '<option value = "'.$value->id.'"'.'>'.$value->position_title.'</option>';
    }
    echo ($data);
    }else{
    echo '<option value = "">ไม่พบข้อมูล</option>';
     	
     }

}

public function actionListBranch(){

 $model=Branch::model()->findAll('position_id=:position_id',
    array(':position_id'=>$_POST['id']));

 $data=CHtml::listData($model,'id','branch_name',array('empty' => 'สาขา'));
 if ($data) {
 $sub_list = 'เลือกระดับ';
 $data = '<option value ="">'.$sub_list.'</option>';
 foreach ($model as $key => $value) {
    $data .= '<option value = "'.$value->id.'"'.'>'.$value->branch_name.'</option>';
}
echo ($data);
}else{
    echo '<option value = "">ไม่พบข้อมูล</option>';
     	
     }

}

public function actionListDepartment(){

 $model=Department::model()->findAll('type_employee_id=:type_employee_id',
    array(':type_employee_id'=>$_POST['id']));

 $data=CHtml::listData($model,'id','dep_title',array('empty' => 'แผนก'));
 $sub_list = 'เลือกแผนก';
 $data = '<option value ="">'.$sub_list.'</option>';
 foreach ($model as $key => $value) {
    $data .= '<option value = "'.$value->id.'"'.'>'.$value->dep_title.'</option>';
}
echo ($data);

}

    public function actionTest(){
    	var_dump("expression");exit();
    }

    public function actionIndex()
    {
    	$model=new UsersAdmin('search');
        $model->unsetAttributes();  // clear any default values
        $model->superuser = 1;
        if(isset($_GET['UsersAdmin'])){
        //var_dump($_GET['UsersAdmin']['name_search']);exit();
        	$model->name_search=$_GET['UsersAdmin']['name_search'];
            // $model->status = 5;
            // var_dump($_GET['AdminUser']);

        }
        $this->render('index',array(
        	'model'=>$model,
        	));
    }
    public function actionCreate(){
    	$gen = Generation::model()->find('active=1');
		$model=new User;
		$profile=new Profile;
		
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}

		if(isset($_POST['User']))
		{		
			$PGoup = $_POST['PGoup'];           
    		$PGoup = json_encode($PGoup);

    		if(in_array("2",$_POST['PGoup'])){
    			$model->institution_id = $_POST["institution_id"];
    		}else{
    			$model->institution_id = 7; // Set สุภาพบุรุษเดินเรือ
    		}

            $model->company_id = $_POST['User']['company_id'];
			$model->username = $_POST['User']['username'];
            $model->email = $_POST['User']['email'];
			$model->group = $PGoup;
            $model->password = $_POST['User']['password'];
            $model->verifyPassword = $_POST['User']['verifyPassword'];
            $model->create_at = date("Y-m-d H:i:s");
			$model->activkey=UserModule::encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->firstname = $_POST['Profile']['firstname'];
    		$profile->lastname  = $_POST['Profile']['lastname'];
			$profile->firstname_en = $_POST['Profile']['firstname'];
    		$profile->lastname_en  = $_POST['Profile']['lastname'];

				//$errors = $model->getErrors();

				// var_dump($errors);
				// exit();
        
			if($model->validate()) {	//&&$profile->validate()
				$model->password=UserModule::encrypting($model->password);
				$model->verifyPassword=UserModule::encrypting($model->verifyPassword);


				// $uploadFile = CUploadedFile::getInstance($model,'pic_user');
				// if(isset($uploadFile))
				// {
				// 	$uglyName = strtolower($uploadFile->name);
				//           $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				//           $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
				// 	$model->pic_user = $beautifulName;
				// }
                $model->status = 1;
                $model->superuser = 1;

				if($model->save()) {
					// if(isset($uploadFile))
					// {
					// 	/////////// SAVE IMAGE //////////
					// 	Yush::init($model);
					// 				$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
					// 				$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
					// 				$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
					// 				// Save the original resource to disk
					// 				$uploadFile->saveAs($originalPath);

					// 				// Create a small image
					// 				$smallImage = Yii::app()->phpThumb->create($originalPath);
					// 				$smallImage->resize(385, 220);
					// 				$smallImage->save($smallPath);

					// 				// Create a thumbnail
					// 				$thumbImage = Yii::app()->phpThumb->create($originalPath);
					// 				$thumbImage->resize(350, 200);
					// 				$thumbImage->save($thumbPath);
					// }
					// if($profile->contactfrom){
					// 			$contacts = $profile->contactfrom;
					// 			foreach ($contacts as $key => $contact) {
					// 				// var_dump($contact);
					// 				// exit();
					// 				if($contact != end($contacts)){
					// 					$value .= $contact.',';
					// 				} else {
					// 					$value .= $contact;
					// 				}
									
					// 			}
					// 			$profile->contactfrom = $value;
					// 		}
					// $profile->generation = $gen->id_gen;
					$profile->user_id=$model->id;
					$profile->save(false);
				}
				$this->redirect(array('view','id'=>$model->id));
			} else {
				$profile->validate();
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	public function actionView($id){		
		if($id){
			// $model = Profile::model()->find(array('condition' => 'user_id = '.$id));
			$model = User::model()->findByPk($id);
			$this->render('view' ,array(
				'model'=>$model
				));
		}
	}
	public function actionUpdate($id){
		// echo '<pre>';
		// var_dump($model);
		// exit();
		if($id){
			$model = User::model()->notsafe()->findbyPk($_GET['id']);
				// $model=$this->loadModel();
			$profile=$model->profile;
			$model->verifyPassword = $model->password;
			$this->performAjaxValidation(array($model,$profile));
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
				{
					echo UActiveForm::validate(array($model,$profile));
					Yii::app()->end();
				}

			if(isset($_POST['User']))
			{				
				
				$PGoup = $_POST['PGoup'];           
				$PGoup = json_encode($PGoup);
				$model->group = $PGoup;
				$model->username = $_POST['User']['username'];
	            $model->email = $_POST['User']['email']; //**
	            //$member = Helpers::lib()->ldapTms($model->email);

	            // $member['count']  = 1;
	            // $member[0]['samaccountname'][0] = 'taaonprem03';
	            // if($member['count'] > 0){
	            // 	$model->username = $member[0]['samaccountname'][0];
	            // }else{ //บุคคลภายนอก
	            // 	 $model->username = $model->email;
	            // 	 $model->scenario = 'general';
	            // }
	            if(!empty($_POST['User']['newpassword'])){
		            $model->password = $_POST['User']['newpassword'];
		            $model->verifyPassword = $_POST['User']['confirmpass'];
		        }
				$profile->attributes=$_POST['Profile'];
				// $model->verifyPassword = $model->password;
				if($model->validate()) { // &&$profile->validate()
					if(!empty($_POST['User']['newpassword'])){
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
					}

							// $model->password=UserModule::encrypting($model->password);
							// $model->verifyPassword=UserModule::encrypting($model->verifyPassword);


							// $model->password=Yii::app()->controller->module->encrypting($model->password);
							// $model->verifyPassword=UserModule::encrypting($model->verifyPassword);
							// $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->newpassword);

					// $uploadFile = CUploadedFile::getInstance($model,'pic_user');
					// if(isset($uploadFile))
					// {
					// 	$uglyName = strtolower($uploadFile->name);
			  //           $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
			  //           $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
					// 	$model->pic_user = $beautifulName;

					// // $rnd = rand(0,999);
					// // $fileName = $time."_Picture.".$uploadFile->getExtensionName();
					// // // $path = Yii::app()->basePath.'/../uploads/user/';
					// // $destination = $path.$fileName;
					// // $w = 200;
					// // $h = 200;
					// // $model->pic_user = $fileName;
					// }
				// 			echo '<pre>';
				// var_dump(UserModule::encrypting($model->password));
				// exit();

					// if($profile->contactfrom){
					// 				$contacts = $profile->contactfrom;
					// 				foreach ($contacts as $key => $contact) {
					// 					// var_dump($contact);
					// 					// exit();
					// 					if($contact != end($contacts)){
					// 						$value .= $contact.',';
					// 					} else {
					// 						$value .= $contact;
					// 					}
										
					// 				}
					// 				$profile->contactfrom = $value;
					// 			}

					if(!$model->save()){
						echo 'Model not save';
						exit();
					}
					if(!$profile->save(false)){
						echo 'profile not save';
						exit();
					}

				// 	if(isset($uploadFile))
				// 	{
				// 		/////////// SAVE IMAGE //////////
				// 		Yush::init($model);
				// 					$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
				// 					$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
				// 					$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
				// 					// Save the original resource to disk
				// 					$uploadFile->saveAs($originalPath);

				// 					// Create a small image
				// 					$smallImage = Yii::app()->phpThumb->create($originalPath);
				// 					$smallImage->resize(110);
				// 					$smallImage->save($smallPath);

				// 					// Create a thumbnail
				// 					$thumbImage = Yii::app()->phpThumb->create($originalPath);
				// 					$thumbImage->resize(240);
				// 					$thumbImage->save($thumbPath);

				// }
					$this->redirect(array('view','id'=>$model->id));
				}

				// var_dump($model->getErrors());
				//   var_dump($profile->getErrors());
				//   exit();
			}
			// echo '<pre>';
			// var_dump($profile);
			// exit();
			$model->position_name = isset($_POST['User']['position_name']) ? $_POST['User']['position_name'] : $model->position->position_title;
			$this->render('update',array(
				'model'=>$model,
				'profile'=>$profile,
			));

		// 	$model = Profile::model()->find(array('condition' => 'user_id = '.$id));
		// 	// $model = AdminUser::model()->find(array('condition' => 'm_id = '.$id));
		// 	$modelUser = UsersAdmin::model()->find(array('condition'=> 'id ='.$id));

		// 	// echo '<pre>';
		// 	// var_dump(ProfilesTitle::getTitleList());
		// 	// exit();
		// 	if(isset($_POST['AdminUser']) || isset($_POST['UsersAdmin']) && !empty($_POST['UsersAdmin']['group'])){
		// 		$group = json_encode($_POST['UsersAdmin']['group']);
		// 		$modelUser->username =  str_replace('-', '', $_POST['UsersAdmin']['username']);
		// 		$modelUser->identification = $modelUser->username;
		// 		$password = $_POST['UsersAdmin']['update_password'];
		// 		$repeat_password = $_POST['UsersAdmin']['repeat_updatepassword'];
		// 		$modelUser->id_passport = $_POST['UsersAdmin']['username'];
		// 		$modelUser->password =  ($password)?md5($password):$modelUser->password;
		// 		$modelUser->repeat_password = ($repeat_password)?md5($repeat_password):$modelUser->password;
		// 		$modelUser->email = $_POST['UsersAdmin']['email'];
		// 	// $modelUser->activkey=md5(microtime().$model->password);
		// 		$modelUser->status = 1;
		// 		$modelUser->group = $group;
		// 		if($modelUser->validate()){
		// 			if($modelUser->save()){
		// 				$model->attributes = $_POST['AdminUser'];
		// 				$path =  Yii::app()->basePath."/../../uploads/member/";
		// 				$profile_picture = Slim::getImages('profile');
		// 			if($profile_picture){ //รูปโปรไฟล์
		// 				$model->m_file_image = Helpers::lib()->uploadImage($profile_picture,$path);
		// 				$image = Yii::app()->phpThumb->create($path.$model->m_file_image);    
		// 				$image->resize(255, 213);    
		// 				$image->save($path.$model->m_file_image);
		// 			}
		// 			$model->m_tel = str_replace('-', '',$_POST['AdminUser']['m_tel']);
		// 			$model->update_date = date('Y-m-d H:i:s');
		// 			// $model->m_id = $modelUser->id;
		// 			// $model->status = 1;
		// 			$model->update_by = Yii::app()->user->id;
		// 			if($model->validate()){
		// 				if($model->save()){
		// 					$this->redirect(array('index'));
		// 				} else {
		// 					print_r($model->getErrors());
		// 				}
		// 			}else {
		// 				var_dump($model->getErrors());
		// 				$this->render('update',array(
		// 					'model'=>$model,
		// 					'modelUser' => $modelUser,
		// 					'id' => $id
		// 					));
		// 			}
		// 		} else {
		// 			var_dump($modelUser->getErrors());
		// 		}
		// 	} else{
		// 		$this->render('update',array(
		// 			'model'=>$model,
		// 			'modelUser' => $modelUser,
		// 			'id' => $id
		// 			));
		// 	} // validate users

		// } else { // if post
		// 	$this->render('update',array(
		// 		'model'=>$model,
		// 		'modelUser' => $modelUser,
		// 		'id' => $id
		// 		));
		// }

	}
}
public function actionDelete($id){

		/*if($id){
			$model = AdminUser::model()->find(array('condition' => 'm_id = '.$id));
			$model->active ="n";
			$model->save(false);
		}*/
		//$this->loadModel($id)->delete();
		$model = UsersAdmin::model()->findByPk($id);
		$model->status = '0';
		$model->del_status = '1';
		$model->update();
		// return 0;

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	public function actionDelImg()
	{
		$id = $_POST['id'];
		$model = MMember::model()->findByPk($id);
		if(!empty($model)){
			$path = Yii::app()->basePath . "/../../uploads/member/";
			@unlink($path . $model->m_file_image);
			$model->m_file_image = null;
			$model->update();
		}
		echo true;
	}

		public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
}