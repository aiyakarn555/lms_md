
<?php
class AdminController extends Controller
{
	// public function filters()
	//   {
	//       return array(
	//           'accessControl', // perform access control for CRUD operations
	//       );
	//   }

	//   /**
	//    * Specifies the access control rules.
	//    * This method is used by the 'accessControl' filter.
	//    * @return array access control rules
	//    */
	//   public function accessRules()
	//   {
	//       return array(
	//           array('allow',  // allow all users to perform 'index' and 'view' actions
	//               'actions' => array('index', 'view'),
	//               'users' => array('*'),
	//           ),
	//           array('allow',
	//               // กำหนดสิทธิ์เข้าใช้งาน actionIndex
	//               'actions' => AccessControl::check_action(),
	//               // ได้เฉพาะ group 1 เท่านั่น
	//               'expression' => 'AccessControl::check_access()',
	//           ),
	//           array('deny',  // deny all users
	//               'users' => array('*'),
	//           ),
	//       );
	//   }

	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if (Yii::app()->user->id == null) {
			$this->redirect(array('site/index'));
		}
	}
	public $defaultAction = 'admin';
	public $layout = '//layouts/column2';

	private $_model;

	// public function filters() {
	// 		return array(
	// 				'rights',
	// 		);
	// }

	// public function actionGetAjaxDivision(){
	//        if(isset($_GET['company_id']) && $_GET['company_id'] != ""){
	//            $datalist = Division::model()->findAll('active = "y" and company_id = '.$_GET['company_id']);
	//            if($datalist){
	//                    echo "<option value=''> เลือกกอง</option>";
	//                foreach($datalist as $index => $val){
	//                    echo "<option value='".$val->id."'>".$val->div_title."</option>";
	//                }
	//            }else{
	//                    echo "<option value=''> ไม่พบกอง</option>";
	//            }
	//        }else{
	//            echo "<option value=''> เลือกกอง</option>";
	//        }
	//    }

	//    public function actionGetAjaxDepartment(){
	//        if(isset($_GET['division_id']) && $_GET['division_id'] != ""){
	//            $datalist = Department::model()->findAll('active = "y" and division_id = '.$_GET['division_id']);
	//            if($datalist){
	//                    echo "<option value=''> เลือกแผนก</option>";
	//                foreach($datalist as $index => $val){
	//                    echo "<option value='".$val->id."'>".$val->dep_title."</option>";
	//                }
	//            }else{
	//                    echo "<option value=''> ไม่พบแผนก</option>";
	//            }
	//        }else{
	//            echo "<option value=''> เลือกแผนก</option>";
	//        }
	//    }

	//    public function actionGetAjaxPosition(){
	//        if(isset($_GET['department_id']) && $_GET['department_id'] != ""){
	//            $datalist = Position::model()->findAll('active = "y" and department_id = '.$_GET['department_id']);
	//            if($datalist){
	//                    echo "<option value=''> เลือกตำแหน่ง</option>";
	//                foreach($datalist as $index => $val){
	//                    echo "<option value='".$val->id."'>".$val->position_title."</option>";
	//                }
	//            }else{
	//                    echo "<option value=''> ไม่พบตำแหน่ง</option>";
	//            }
	//        }else{
	//            echo "<option value=''> เลือกตำแหน่ง</option>";
	//        }
	//    }
	private function RandomPassword()
	{

		$number = "abcdefghijklmnopqrstuvwxyz0123456789";
		$i = '';
		$result = '';
		for ($i == 1; $i < 6; $i++) { // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
			$random = rand(0, strlen($number) - 1); //สุ่มตัวเลข
			$cut_txt = substr($number, $random, 1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
			$result .= substr($number, $random, 1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
			$number = str_replace($cut_txt, '', $number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
		}

		return $result;
	}

	public function actionListPosition()
	{

		$model = Position::model()->findAll(
			'department_id=:department_id',
			array(':department_id' => $_POST['id'])
		);

		$data = CHtml::listData($model, 'id', 'position_title', array('empty' => 'ตำแหน่ง'));
		if ($data) {
			$sub_list = 'เลือกตำแหน่ง';
			$data = '<option value ="">' . $sub_list . '</option>';
			foreach ($model as $key => $value) {
				$data .= '<option value = "' . $value->id . '"' . '>' . $value->position_title . '</option>';
			}
			echo ($data);
		} else {
			echo '<option value = "">ไม่พบข้อมูล</option>';
		}
	}

	public function actionListBranch()
	{

		$model = Branch::model()->findAll(
			'position_id=:position_id',
			array(':position_id' => $_POST['id'])
		);

		$data = CHtml::listData($model, 'id', 'branch_name', array('empty' => 'สาขา'));
		if ($data) {
			$sub_list = 'เลือกระดับ';
			$data = '<option value ="">' . $sub_list . '</option>';
			foreach ($model as $key => $value) {
				$data .= '<option value = "' . $value->id . '"' . '>' . $value->branch_name . '</option>';
			}
			echo ($data);
		} else {
			echo '<option value = "">ไม่พบข้อมูล</option>';
		}
	}

	public function actionListDepartment()
	{

		$model = Department::model()->findAll(
			'type_employee_id=:type_employee_id',
			array(':type_employee_id' => $_POST['id'])
		);

		$data = CHtml::listData($model, 'id', 'dep_title', array('empty' => 'แผนก'));
		$sub_list = 'เลือกแผนก';
		$data = '<option value ="">' . $sub_list . '</option>';
		foreach ($model as $key => $value) {
			$data .= '<option value = "' . $value->id . '"' . '>' . $value->dep_title . '</option>';
		}
		echo ($data);
	}

	public function actionApprove()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		// $model->typeuser = array(1);
		$model->register_status = array(0);
		$model->status = array(1);
		$model->supper_user_status = false;

		if (isset($_GET['User'])) {
			$model->attributes = $_GET['User'];
		}

		$this->render('approve', array(
			'model' => $model,
		));
	}

	public function actionMembership()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		$model->register_status = array(0, 2);
		$model->supper_user_status = true;

		if (isset($_GET['User'])) {
			$model->attributes = $_GET['User'];
		}
		$this->render('Membership', array(
			'model' => $model,
		));
	}

	// public function actionMembership_personal ()
	// {
	// 	$model = new User('search');
	//        $model->unsetAttributes();  // clear any default values
	//        $model->register_status = array(0,2);
	//        $model->supper_user_status = true;

	//        if(isset($_GET['User'])){
	//        	$model->attributes=$_GET['User'];
	//        }
	//        $this->render('Membership_personal',array(
	//        	'model'=>$model,
	//        ));
	// }

	public function loadDepartment($department_id)
	{
		$data = OrgChart::model()->findAll(
			'id=:id',
			array(':id' => $department_id)
		);

		$data = CHtml::listData($data, 'id', 'title');

		return $data;
	}

	public function actionAccess()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		$model->register_status = array(1);
		$model->repass_status = array(1);
		$model->status = array(1);

		if (isset($_GET['User'])) {
			$model->attributes = $_GET['User'];
		}
		$this->render('access', array(
			'model' => $model,
		));
	}

	public function actionAccessPersonal()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		$model->register_status = array(1);
		$model->repass_status = array(1);
		$model->status = array(1);

		if (isset($_GET['User'])) {
			$model->attributes = $_GET['User'];
		}
		$this->render('accessPersonal', array(
			'model' => $model,
		));
	}

	public function actionEditTable()
	{
		$model = TypeUser::model()->findAll(array('condition' => 'active = 1'));
		foreach ($model as $key => $value) {
			if ($value->id == 1) {
				$value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหน้าบ้าน)';
			} else if ($value->id == 2) {
				$value->name = 'ผู้ใช้งานทั่วไป(ลงทะเบียนหลังบ้าน)';
			} else if ($value->id == 3) {
				$value->name = 'บุคลากรภายใน';
			} else {
				$value->active = 0;
			}
			$value->save();
		}
	}

	public function actionStatus()
	{
		$model = new ReportUser();
		$model->unsetAttributes();
		if (isset($_GET['ReportUser'])) {
			//$_GET['ReportUser']['type_user'] = 1 General , 2 = Staff
			//type_user 1,2 General
			//type_user 3 Staff
			$model->attributes = $_GET['ReportUser'];
		}

		$this->render('status', array('model' => $model));
	}

	public function actionExport_excel()
	{
		$this->layout = FALSE;
		$model = new ReportUser();
		$model->unsetAttributes();
		if (isset($_GET['ReportUser'])) {
			$model->attributes = $_GET['ReportUser'];
		}

		$contentView = $this->renderPartial('excel_export', array(
			'model' => $model
		));



		echo '<meta charset="UTF-8">';
		echo $contentView;
		exit();
	}

	// public function actionAdmin()
	// {
	// 	$model=new User('search');
	//        $model->unsetAttributes();  // clear any default values
	//        if(isset($_GET['User']))
	//        	$model->attributes=$_GET['User'];

	//        $this->render('index',array(
	//        	'model'=>$model,
	//        ));
	// 	/*$dataProvider=new CActiveDataProvider('User', array(
	// 		'pagination'=>array(
	// 			'pageSize'=>Yii::app()->controller->module->user_page_size,
	// 		),
	// 	));

	// 	$this->render('index',array(
	// 		'dataProvider'=>$dataProvider,
	// 	));//*/
	// }
	public function actionEmployee()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		// $model->typeuser = array(3);
		// $model->type_employee = array(2);
		$model->status = array(1);
		$model->register_status = array(1);
		$model->supper_user_status = true;
		$model->attributes = $_GET['kind'];
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];
		$this->render('index', array(
			'model' => $model,
		));
	}

	// public function actionEmployeeShip()
	// {
	// 	$model=new User('search');
	//        $model->unsetAttributes();  // clear any default values

	//        $model->typeuser = array(1);
	//        $model->type_employee = array(1);
	//        $model->status = array(1);
	//        $model->register_status = array(1);
	//        $model->supper_user_status = true;
	//        if(isset($_GET['User']))
	//        	$model->attributes=$_GET['User'];
	//        $this->render('index',array(
	//        	'model'=>$model,
	//        ));
	// }

	public function actionGeneral()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		$model->typeuser = array(5);
		$model->status = array(1);
		$model->register_status = array(1);
		$model->supper_user_status = true;
		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];
		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionActive()
	{
		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		$profile = Profile::model()->findByPk($id);

		if ($model->status == 1 && $model->register_status == 0) {
			// $model->status = 0;
			$model->status = 1;
			$model->register_status = 1;
			$profile->type_user = 1;
			$profile->type_employee = 1;
			$profile->save(false);
		} else {
			$model->status = 0;
		}
		$model->username = $profile->passport;
		$model->save(false);
		if (Yii::app()->user->id) {
			Helpers::lib()->getLogapprove($model);
		}

		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;
		$message = $this->renderPartial('_mail_membership', array('model' => $model), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'อนุมัติการเข้าใช้งานระบบ', $message);
		}
		$this->redirect(array('/user/admin/approve'));
	}

	public function actionConfirm()
	{

		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		$Profile = Profile::model()->findByPk($id);
		if ($model->register_status == 0 && $model->status == 0) {
			//$model->register_status = 1;
			$model->status = 1;
		} else {
			$model->register_status = 0;
		}
		$genpass = $this->RandomPassword();
		$model->verifyPassword = $genpass;
		$model->password = UserModule::encrypting($genpass);
		$model->username = $Profile->passport;
		$model->save(false);
		if (Yii::app()->user->id) {
			Helpers::lib()->getLogregister($model);
		}
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;
		$message = $this->renderPartial('_mail_message', array('model' => $model, 'genpass' => $genpass), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'อนุมัติการสมัครสมาชิก', $message);
		}
		$this->redirect(array('/user/admin/Membership'));
	}

	public function actionConfirm_personal()
	{

		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		if ($model->register_status == 0 && $model->status == 0) {
			$model->register_status = 1;
			$model->status = 1;
		} else {
			$model->register_status = 0;
		}
		$genpass = $this->RandomPassword();
		$model->verifyPassword = $genpass;
		$model->password = UserModule::encrypting($genpass);
		$model->username = $model->email;
		$model->save(false);
		if (Yii::app()->user->id) {
			Helpers::lib()->getLogapprovePersonal($model);
		}
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;
		$message = $this->renderPartial('_mail_message', array('model' => $model, 'genpass' => $genpass), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'อนุมัติการสมัครสมาชิก', $message);
		}
		$this->redirect(array('/user/admin/Membership_personal'));
	}

	public function actionNotapproved()
	{

		$id = $_POST['id'];
		$passage = $_POST['passInput'];
		$model = User::model()->findByPk($id);
		if ($model->register_status == 0 && $model->status == 1) {
			$model->register_status = 2;
		} else {
			$model->register_status = 1;
		}
		$model->note = $passage;
		$model->save(false);
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;

		$message = $this->renderPartial('_mail_Notapproved', array('model' => $model, 'passage' => $passage), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'ไม่อนุมัติการสมัครสมาชิก', $message);
		}
		$this->redirect(array('/user/admin/Membership'));
	}

	public function actionNotapproved_personal()
	{

		$id = $_POST['id'];
		$passage = $_POST['passInput'];
		$model = User::model()->findByPk($id);
		if ($model->register_status == 0 && $model->status == 1) {
			$model->register_status = 2;
		} else {
			$model->register_status = 1;
		}
		$model->note = $passage;
		$model->save(false);
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;

		$message = $this->renderPartial('_mail_Notapproved', array('model' => $model, 'passage' => $passage), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'ไม่อนุมัติการสมัครสมาชิก', $message);
		}
		$this->redirect(array('/user/admin/Membership_personal'));
	}

	public function actionNotPassed()
	{

		$id = $_POST['id'];
		$passage = $_POST['passInput'];
		$model = User::model()->findByPk($id);
		if ($model->status == 1 && $model->register_status == 0) {
			$model->status = 1;
			$model->register_status = 0;
		} else {
			$model->status = 1;
		}
		$model->username = '';
		$model->not_passed = $passage;
		$model->save(false);
		$to['email'] = $model->email;
		$to['firstname'] = $model->profile->firstname;
		$to['lastname'] = $model->profile->lastname;

		$message = $this->renderPartial('_mail_NotPassed', array('model' => $model, 'passage' => $passage), true);
		if ($message) {
			$send = Helpers::lib()->SendMail($to, 'ไม่อนุมัติการเข้าใช้งานระบบ', $message);
		}
		$this->redirect(array('/user/admin/Membership'));
	}

	public function actionChangeposition()
	{

		$value  = $_POST['val'];
		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		if ($value != '') {
			$model->position_id = $value;
		}
		$model->save(false);
		// $to['email'] = $model->email;
		// $to['firstname'] = $model->profile->firstname;
		// $to['lastname'] = $model->profile->lastname;
		// $message = $this->renderPartial('_mail_Changeposition',array('model' => $model,'value' => $value),true);
		// if($message){
		// 	 $send = Helpers::lib()->SendMail($to,'ไม่อนุมัติการสมัครสมาชิก',$message);
		// }
		$this->redirect(array('/user/admin/Membership'));
	}

	public function actionOpen_employee()
	{
		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		if ($model != '') {
			$model->del_status = 0;
		}
		$model->save(false);

		$this->redirect(array('/user/admin/access'));
	}

	public function actionDelete_employee()
	{
		$id = $_POST['id'];
		$model = User::model()->findByPk($id);
		if ($model != '') {
			$model->del_status = 1;
		}
		$model->save(false);

		$this->redirect(array('/user/admin/Membership_personal'));
	}

	public function actionChangePasswordUser()
	{
		$id = $_POST['id'];
		$password = $_POST['password'];
		$verifyPassword = $_POST['verifyPassword'];
		$model = Users::model()->findbyattributes(array('id' => $id));
		$model->password = $password;
		$model->verifyPassword = $verifyPassword;
		$result = [];
		if ($model->validate()) {
			$model->password = UserModule::encrypting($model->password);
			$model->verifyPassword = UserModule::encrypting($model->verifyPassword);
			$model->save(false);

			// $to['email'] = $model->email;
			// $to['firstname'] = $model->profiles->firstname;
			// $to['lastname'] = $model->profiles->lastname;

			// $message = $this->renderPartial('_mail_ChangePassword', array('model' => $model, 'password' => $password), true);
			// if ($message) {
			// 	$send = Helpers::lib()->SendMail($to, 'แจ้งเปลี่ยน Password', $message);
			// }
		

			$result = ['check'=>true,'title'=>'สำเร็จ','text'=>'เปลี่ยนรหัสผ่านสำเร็จ','type'=>'success'];
			echo json_encode($result);
		}else{
			if($password != $verifyPassword){
				$result = ['check'=>false,'title'=>'ไม่สำเร็จ!','text'=>'รหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง','type'=>'error'];	
			}else{
				$result = ['check'=>false,'title'=>'ไม่สำเร็จ!','text'=>'ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ','type'=>'error'];	
			}
			echo json_encode($result);
		}

		//$this->redirect(array('/user/admin/index'));
	}


	public function actionCheckinformation()
	{
		$id = $_POST['id'];
		$user = User::model()->findByPk($id);
		$profile = Profile::model()->findByPk($id);


		$this->renderPartial('Checkinformation', array('user' => $user, 'profile' => $profile));
	}

	public function actionCheckinformation_personal()
	{
		$id = $_POST['id'];
		$user = User::model()->findByPk($id);
		$profile = Profile::model()->findByPk($id);


		$this->renderPartial('Checkinformation_personal', array('user' => $user, 'profile' => $profile));
	}

	public function actionChangePassword()
	{
		$id = $_POST['id'];
		$user = User::model()->findByPk($id);

		$this->renderPartial('ChangePassword', array('user' => $user));
	}

	public function actionAttach_load()
	{

		$user_id = $_GET["id"];
		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id ="' . $user_id . '"');
		$criteria->addCondition("active ='y'");
		$Attach_file = AttachFile::model()->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id ="' . $user_id . '"');
		$criteria->addCondition("active ='y'");
		$Edu_file = FileEdu::model()->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id ="' . $user_id . '"');
		$criteria->addCondition("active ='y'");
		$Training_file = FileTraining::model()->findAll($criteria);

		if ($user_id != '') {
			$profiles = Profile::model()->find(array(
				'condition' => 'user_id=:user_id ',
				'params' => array('user_id' => $user_id)
			));
			$user = User::model()->find(array(
				'condition' => 'id=:id',
				'params' => array('id' => $user_id)
			));
			$path_img = Yii::app()->baseUrl . '/images/head_print.png';

			$padding_left = 12.7;
			$padding_right = 12.7;
			$padding_top = 10;
			$padding_bottom = 20;

			Yii::import('application.extensions.*');
			require_once('THSplitLib/segment.php');
			$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
			$mPDF->useDictionaryLBR = false;
			$mPDF->setDisplayMode('fullpage');
			$mPDF->autoLangToFont = true;
			$mPDF->autoPageBreak = true;
			$mPDF->SetTitle("ใบสมัครสมาชิก");
			$texttt = '
         <style>
         body { font-family: "garuda"; }
         </style>
         ';
			$mPDF->WriteHTML($texttt);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('printpdf', array('profiles' => $profiles, 'user' => $user), true), 'UTF-8', 'UTF-8'));

			$uploadDir = Yii::app()->getUploadPath(null);
			$path1 = "pdf_regis";
			$path2 = $user_id;

			if (!is_dir($uploadDir . "../" . $path1 . "/")) {
				mkdir($uploadDir . "../" . $path1 . "/", 0777, true);
			}

			if (!is_dir($uploadDir . "../" . $path1 . "/" . $path2 . "/")) {
				mkdir($uploadDir . "../" . $path1 . "/" . $path2 . "/", 0777, true);
			} else { // ลบ file เก่า
				$files = glob($uploadDir . "../" . $path1 . "/" . $path2 . '/*');
				foreach ($files as $file) { // iterate files
					if (is_file($file)) {
						unlink($file); // delete file
					}
				}
			}

			$mPDF->Output($uploadDir . '../pdf_regis\\' . $user_id . '\เอกสารสมัครสมาชิก.pdf', 'F');
			//$mPDF->Output($uploadDir.'../pdf_regis/ใบสมัครสมาชิก.pdf', 'F');

		}
		$name_register_file = "เอกสารสมัครสมาชิก.pdf";
		$path_zip_attach = array();
		$name_file_attach = array();
		$nameold_file_attach = array();

		$path_zip_edu = array();
		$name_file_edu = array();
		$nameold_file_edu = array();

		$path_zip_training = array();
		$name_file_training = array();
		$nameold_file_training = array();

		$path_zip_register = array();
		$nameold_file_register = array();

		foreach ($Attach_file as $key => $value) {
			$attach_all  = glob(Yii::app()->getUploadPath('attach') . $value->file_name);
			if (!empty($attach_all)) {
				$path_zip_attach[] = "../uploads/attach/" . basename($attach_all[0]);
				$name_file_attach[] = basename($attach_all[0]);
				$nameold_file_attach[] = $value->filename;
			}
		}
		foreach ($Edu_file as $keyedu => $valueedu) {
			$edu_all  = glob(Yii::app()->getUploadPath('edufile') . $valueedu->filename);
			if (!empty($edu_all)) {
				$path_zip_edu[] = "../uploads/edufile/" . basename($edu_all[0]);
				$name_file_edu[] = basename($edu_all[0]);
				$nameold_file_edu[] = $valueedu->file_name;
			}
		}
		foreach ($Training_file as $keytn => $valuetn) {
			$Training_all  = glob(Yii::app()->getUploadPath(null) . "..\\Trainingfile\\" . $user_id . "\\*");
			if (!empty($Training_all)) {
				$path_zip_training[] = "../uploads/Trainingfile/" . $user_id . "/" . basename($Training_all[0]);
				$name_file_training[] = basename($Training_all[0]);
				$nameold_file_training[] = $valuetn->filename;
			}
		}
		$Register_all  = glob(Yii::app()->getUploadPath(null) . "..\\pdf_regis\\" . $user_id . "\\*");
		if (!empty($Register_all)) {
			$path_zip_register[] = "../uploads/pdf_regis/" . $user_id . "/" . basename($Register_all[0]);
			$nameold_file_register[] = basename($Register_all[0]);
		}

		// $Register_all  = glob(Yii::app()->getUploadPath('pdf_regis').$name_register_file);

		//   	if(!empty($Register_all)){

		//   			$path_zip_register[] = "../uploads/pdf_regis/".basename($Register_all[0]);	
		// 	    $nameold_file_register[] = basename($Register_all[0]);	

		//    }  

		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id ="' . $user_id . '"');
		$Profile = Profile::model()->find($criteria);

		$criteria = new CDbCriteria;
		$criteria->addCondition('user_id ="' . $user_id . '"');
		$user = User::model()->find($criteria);

		$criteria = new CDbCriteria;
		$criteria->addCondition('id ="' . $user->position_id . '"');
		$position = Position::model()->find($criteria);

		$firstname = $Profile->firstname;
		$positionName = $position->position_title;

		if (!empty($path_zip_attach) || !empty($path_zip_training) || !empty($path_zip_edu) || !empty($path_zip_register)) {
			$zip = Yii::app()->zip;
			$path_in_zip = "..\uploads\attachZib\\";
			$name_zip = "$firstname" . "-" . "$positionName.zip";

			$name_attach = "เอกสารไฟล์แนบ.zip";
			$name_edu = "เอกสารไฟล์แนบการศึกษา.zip";
			$name_training = "เอกสารไฟล์แนบการฝึกอบรม.zip";
			$name_register = "เอกสารสมัครสมาชิก.zip";

			$file_in_folders = glob(Yii::app()->getUploadPath(null) . "..\\attachZib\\*");
			if (!empty($file_in_folders)) {
				foreach ($file_in_folders as $file) { // iterate files
					if (is_file($file)) {
						unlink($file); // delete file
					}
				}
			}
			// foreach ($path_zip_attach as $key => $link_file) {

			// 	 $zip->makeZip_nn($link_file, $path_in_zip.$name_zip, $nameold_file_attach[$key]);
			// }
			// foreach ($path_zip_training as $keyt => $valuet) {
			//               $zip->makeZip_nn($valuet, $path_in_zip.$name_zip, $nameold_file_training[$keyt]);
			// }
			// foreach ($path_zip_edu as $keye => $valuee) {
			//               $zip->makeZip_nn($valuee, $path_in_zip.$name_zip, $nameold_file_edu[$keye]);
			// }

			foreach ($path_zip_attach as $key => $link_file) {

				$zip->makeZip_nn($link_file, $path_in_zip . $name_attach, $nameold_file_attach[$key]);
			}
			foreach ($path_zip_training as $keyt => $valuet) {
				$zip->makeZip_nn($valuet, $path_in_zip . $name_training, $nameold_file_training[$keyt]);
			}
			foreach ($path_zip_edu as $keye => $valuee) {
				$zip->makeZip_nn($valuee, $path_in_zip . $name_edu, $nameold_file_edu[$keye]);
			}
			foreach ($path_zip_register as $keyrg => $valuerg) {
				$zip->makeZip_nn($valuerg, $path_in_zip . $name_register, $nameold_file_register[$keyrg]);
			}

			$path_zip = array();
			$name_file = array();

			$file_in = glob(Yii::app()->getUploadPath(null) . "..\\attachZib\\*");

			if (isset($file_in)) {
				$path_zip[] = "../uploads/attachZib/" . basename($file_in[0]);
				$path_zip[] = "../uploads/attachZib/" . basename($file_in[1]);
				$path_zip[] = "../uploads/attachZib/" . basename($file_in[2]);
				$path_zip[] = "../uploads/attachZib/" . basename($file_in[3]);
				$name_file[] = basename($file_in[0]);
				$name_file[] = basename($file_in[1]);
				$name_file[] = basename($file_in[2]);
				$name_file[] = basename($file_in[3]);
			}

			foreach ($path_zip as $keys => $val) {

				$zip->makeZip_nn($val, $path_in_zip . $name_zip, $name_file[$keys]);
			}
			$file_in_folder = glob(Yii::app()->getUploadPath(null) . "..\\attachZib\\*");

			foreach ($file_in_folder as $file_in) { // วนลบไฟล์ในโฟลเดอร์

				if (is_file($file_in)) {
					$file = basename($file_in);
					if ($file == $name_zip) {
						$zip_susess = "..\uploads\attachZib\\$name_zip";

						if (file_exists($zip_susess)) {

							header('Content-Description: File Transfer');
							header('Content-Type: application/octet-stream');
							Header("Content-disposition: attachment; filename=" . basename($zip_susess) . ".zip");
							header('Content-Transfer-Encoding: binary');
							header('Expires: 0');
							header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
							header('Pragma: public');
							ob_clean();
							flush();
							// header('Content-Description: File Transfer');
							// header('Content-Type: application/octet-stream');
							// header('Content-Disposition: attachment; filename="'.basename($zip_susess).'"');
							// header('Expires: 0');
							// header('Cache-Control: must-revalidate');
							// header('Pragma: public');
							// header('Content-Length: ' . filesize($zip_susess));
							// flush(); // Flush system output buffer
							readfile($zip_susess);
							die();
						} else {
							http_response_code(404);
							die();
						}
					}
				}
			}
		}
	}

	public function actionIdCard($id)
	{
		// var_dump($id);exit();
		$model = User::model()->findbyPk($id);
		$regis = new RegistrationForm;
		$regis->id = $model->id;
		$profile = $model->profile;

		if (isset($_POST['User'])) {
			$uploadFile = CUploadedFile::getInstance($model, 'pic_user');
			if (isset($uploadFile)) {
				$uglyName = strtolower($uploadFile->name);
				$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
				$model->pic_cardid = $beautifulName;
				$model->save(false);
				Yii::app()->user->setFlash('registration', 'แก้ไขสำเร็จ');
				if (isset($uploadFile)) {
					/////////// SAVE IMAGE //////////
					Yush::init($regis);
					$originalPath = Yush::getPath($regis, Yush::SIZE_ORIGINAL, $model->pic_cardid);
					$thumbPath = Yush::getPath($regis, Yush::SIZE_THUMB, $model->pic_cardid);
					$smallPath = Yush::getPath($regis, Yush::SIZE_SMALL, $model->pic_cardid);
					// Save the original resource to disk
					$uploadFile->saveAs($originalPath);

					// Create a small image
					$smallImage = Yii::app()->phpThumb->create($originalPath);
					$smallImage->resize(385, 220);
					$smallImage->save($smallPath);

					// Create a thumbnail
					$thumbImage = Yii::app()->phpThumb->create($originalPath);
					$thumbImage->resize(350, 200);
					$thumbImage->save($thumbPath);
				}
			}
			// var_dump($model->pic_cardid);exit();
		}
		$this->render('id_card', array(
			'model' => $model,
			'profile' => $profile
		));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}

	// private function RandomPassword(){
	// 	$number="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	// 	$i = '';
	// 	$result = '';
	// 	for($i==1;$i<8;$i++){ // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
	// 		$random=rand(0,strlen($number)-1); //สุ่มตัวเลข
	// 		$cut_txt=substr($number,$random,1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
	// 		$result.=substr($number,$random,1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
	// 		$number=str_replace($cut_txt,'',$number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
	// 	}
	// 	return $result;
	// }


	public function actionExcelOld()
	{
		$HisImportArr = array();
		$HisImportErrorArr = array();
		$HisImportAttrErrorArr = array();
		$HisImportErrorMessageArr = array();
		$HisImportUserPassArr = array();
		//Student
		if (isset($_FILES['excel_import_student'])) {
			$extensionFile = pathinfo($_FILES['excel_import_student']['name'], PATHINFO_EXTENSION);
			$fullPath = Yii::app()->basePath . '/../../uploads/temp_excel.' . $extensionFile;
			if (!move_uploaded_file($_FILES["excel_import_student"]["tmp_name"], $fullPath)) {
				echo "Move File Error!!!";
				exit;
			}
			$file_path = $fullPath;
			$sheet_array = Yii::app()->yexcel->readActiveSheet($file_path);
			$HisImportArr = $sheet_array;

			foreach ($sheet_array as $key => $valueRow) {
				if ($key == 1) { // Header first row
				} else { // Data Row ALL 2 -
					// $passwordGen = $this->RandomPassword();
					// $HisImportUserPassArr[$key]['password'] = $passwordGen;

					$modelUser = new User;
					$modelUser->email = $valueRow['A'];
					$modelUser->username = $valueRow['A'];
					$modelUser->password = md5($valueRow['B']); // Random password
					$modelUser->verifyPassword = $modelUser->password;
					// $modelUser->department_id = $valueRow['G'];
					// $modelUser->company_id = $valueRow['F'];
					// $modelUser->division_id = $valueRow['G'];
					// $modelUser->department_id = $valueRow['H'];
					// $modelUser->position_id = $valueRow['I'];
					// $modelUser->orgchart_lv2 = $valueRow['J'];
					$modelUser->type_register = 2;
					$modelUser->superuser = 0;
					// $modelUser->auditor_id = $valueRow['G'];
					// $modelUser->bookkeeper_id = $valueRow['H'];

					$member = Helpers::lib()->ldapTms($modelUser->email);
					if ($member['count'] > 0) { //TMS
						$modelUser->type_register = 3;
						Helpers::lib()->_insertLdap($member);
						$modelStation = Station::model()->findByAttributes(array('station_title' => $member[0]['st'][0]));
						$modelDepartment = Department::model()->findByAttributes(array('dep_title' => $member[0]['department'][0]));
						$modelDivision = Division::model()->findByAttributes(array('div_title' => $member[0]['division'][0]));

						$modelUser->division_id = $modelDivision->id;
						$modelUser->station_id = $modelStation->station_id;
						$modelUser->department_id = $modelDepartment->id;
						$modelUser->password = md5($model->email);
						$modelUser->verifyPassword = $model->password;
						$modelUser->status = 1; //bypass not confirm
					} else { //LMS
						$modelUser->password = md5($valueRow['B']); // Random password
						$modelUser->verifyPassword = $modelUser->password;
						// $modelUser->department_id = 2;
						$modelUser->department_id = 1;
						$modelUser->status = 0;
					}

					if ($modelUser->validate()) {
						// insert right
						$modelUser->save();
						$modelProfile = new Profile;
						$modelProfile->user_id = $modelUser->id;
						$modelProfile->title_id = $valueRow['C'];
						$modelProfile->firstname = $valueRow['D'];
						$modelProfile->lastname = $valueRow['E'];
						$modelProfile->identification = $valueRow['B'];
						$modelProfile->phone = $valueRow['F'];
						// $modelProfile->active = 1;
						// $modelProfile->type_user = $valueRow['F'];
						// $modelProfile->birthday = $valueRow['I'];
						// $modelProfile->age = $valueRow['K'];
						// $modelProfile->education = $valueRow['L'];
						// $modelProfile->occupation = $valueRow['M'];
						// $modelProfile->position = $valueRow['N'];
						// $modelProfile->website = $valueRow['O'];
						// $modelProfile->address = $valueRow['P'];
						// $province=Province::model()->findByAttributes(array('pv_name_th'=>$valueRow['Q']));
						// $modelProfile->province = $province->pv_id;
						// $modelProfile->tel = $valueRow['R'];
						// $modelProfile->phone = $valueRow['S'];
						// $modelProfile->fax = $valueRow['T'];
						// $modelProfile->generation = $valueRow['W'];
						// $modelProfile->contactfrom = $valueRow['V'];
						// $modelProfile->firstname_en = $valueRow['H'];
						// $modelProfile->lastname_en = $valueRow['I'];
						// $modelProfile->advisor_email1 = $valueRow['L'];
						// $modelProfile->advisor_email2 = $valueRow['M'];
						// var_dump($modelProfile);exit();
						// $modelProfile->birthday = Yii::app()->dateFormatter->format("y-M-d",strtotime($valueRow['I']));
						if ($modelProfile->validate()) {
							$modelProfile->save();
							$Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";
						} else {
							$HisImportErrorArr[] = $HisImportArr[$key];
							$msgAllArr = array();
							$attrAllArr = array();
							foreach ($modelProfile->getErrors() as $field => $msgArr) {
								$attrAllArr[] = $field;
								$msgAllArr[] = $msgArr[0];
							}

							$HisImportErrorMessageArr[$key] = implode(", ", $msgAllArr);
							$HisImportAttrErrorArr[] = $attrAllArr;
							$HisImportArr = $sheet_array;
							$deldata = User::model()->findbyPk($modelUser->id);
							$deldata->delete();
							$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
						}


						/*$message = '
						<strong>สวัสดี คุณ' . $modelProfile->firstname . ' ' . $modelProfile->lastname . '</strong><br /><br />

						โปรดคลิกลิงค์ต่อไปนี้ เพื่อดำเนินการเข้าสู่ระบบ<br />
						<a href="' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '">' . str_replace("/admin","",Yii::app()->getBaseUrl(true)) . '</a><br />
						<strong>Username</strong> : ' . $valueRow['A'] . '<br />
						<strong>Password</strong> : ' . $passwordGen . '<br /><br />

						ยินดีตอนรับเข้าสู่ระบบ Brother E-Traning<br /><br />

						ทีมงาน SET

						';
						$subject = 'ยินดีต้อนรับเข้าสู่ระบบ SET E-Training';
						$to['email'] = $valueRow['K'];
						$to['firstname'] = $valueRow['F'];
						$to['lastname'] = $valueRow['G'];

						Helpers::lib()->SendMail($to,$subject,$message);*/
					} else {

						/*if(!isset($orgchart->id) && $valueRow['E'] != ''){
							//$modelUser->student_board = 0;
							$modelUser->clearErrors('department_id');
							$modelUser->addError('department_id','ไม่มีแผนกนี้');
						}*/

						$HisImportErrorArr[] = $HisImportArr[$key];

						$msgAllArr = array();
						$attrAllArr = array();
						foreach ($modelUser->getErrors() as $field => $msgArr) {
							$attrAllArr[] = $field;
							$msgAllArr[] = $msgArr[0];
						}

						$HisImportErrorMessageArr[$key] = implode(", ", $msgAllArr);
						$HisImportAttrErrorArr[] = $attrAllArr;

						//						unset($HisImportArr[$key]);
						$HisImportArr = $sheet_array;
						$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
					}
					//				}
				}
			}
			unlink($fullPath);
		}

		if (Yii::app()->user->id) {
			Helpers::lib()->getControllerActionId();
		}
		$this->render('excel', array('HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success));
	}

	public function actionExcel()
	{
		$model = new User('import');
		$HisImportArr = array();
		$HisImportErrorArr = array();
		$HisImportAttrErrorArr = array();
		$HisImportErrorMessageArr = array();
		$HisImportUserPassArr = array();
		$data = array();
		// if(isset($_FILES['excel_import_student']))
		$model->excel_file = CUploadedFile::getInstance($model, 'excel_file');

		if (!empty($model->excel_file)) {
			$phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
			include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

			$model->excel_file = CUploadedFile::getInstance($model, 'excel_file');
			// $model->excel_file =  $_FILES['excel_import_student'];

			//if ($model->excel_file && $model->validate()) {
			// $webroot = YiiBase::getPathOfAlias('webroot');
			$webroot = Yii::app()->basePath . "/../..";
			// $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
			$filename = $webroot . '/uploads/' . $model->excel_file->name;
			$model->excel_file->saveAs($filename);

			$sheet_array = Yii::app()->yexcel->readActiveSheet($filename);
			$inputFileName = $filename;
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);
			$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
			$highestRow = $objWorksheet->getHighestRow();
			$highestColumn = $objWorksheet->getHighestColumn();

			$headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
			$headingsArray = $headingsArray[1];

			$r = -1;
			$namedDataArray = array();
			for ($row = 2; $row <= $highestRow; ++$row) {
				$dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
				if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
					++$r;
					foreach ($headingsArray as $columnKey => $columnHeading) {
						$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
					}
				}
			}

			$index = 0;

			foreach ($namedDataArray as $key => $result) {

				$model = new User;
				$profile = new Profile;
				$model->email = $result[" email"];
				$model->username = $result["username(รหัสพนักงาน)"];
				$model->identification = $result["รหัสบัตรประชาชน (13หลัก)"];

				$model->type_register = 2;
				$model->superuser = 0;
				$model->repass_status = 0;

				$model->create_at = date('Y-m-d H:i:s');
				$model->status = 1;
				$model->department_id = $result["รหัสแผนก"];
				$model->position_id = $result["ตำแหน่ง"];
				$model->branch_id = $result["Lavel"];
				// $data[$key]['fullname'] = $result["ชื่อ"].' '.$result["นามสกุล"];
				// $data[$key]['email'] = $result["email"];
				// $data[$key]['phone'] =  $result["โทรศัพท์"];
				// $data[$key]['identification'] =  $result["รหัสบัตรประชาชน"];
				//$member = Helpers::lib()->ldapTms($model->email);
				// $member['count'] = 0;
				// if($member['count'] > 0){ //TMS
				// 	$model->type_register = 3;
				// 	Helpers::lib()->_insertLdap($member);
				// 	$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
				// 	$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
				// 	$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

				// 	$model->division_id = $modelDivision->id;
				// 	$model->station_id = $modelStation->station_id;
				// 	$model->department_id = $modelDepartment->id;
				// 	$model->password = md5($model->email);
				// 	$model->verifyPassword = $model->password;
				// 	$model->status = 1; //bypass not confirm
				// }else{ //LMS
				// 	$model->password = md5($model->email); // Random password
				// 	$model->verifyPassword = $model->password;
				// 	$model->department_id = 2;
				// 	$model->status = 0;
				// }


				$genpass = $this->RandomPassword();
				$model->verifyPassword = $genpass;
				$model->password = UserModule::encrypting($genpass);
				$model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);

				if ($model->validate()) {
					$model->save();
					//$data[$key]['msg'] = 'pass';

					$modelProfile = new Profile;
					$modelProfile->user_id = $model->id;
					$modelProfile->type_user = 3;
					$modelProfile->type_employee = 1;
					$modelProfile->title_id = $result["คำนำหน้าชื่อ "];
					$modelProfile->firstname = $result["ชื่อ"];
					$modelProfile->lastname = $result["นามสกุล"];
					$modelProfile->firstname_en = $result["ชื่อ-สกุล(EN)"];
					$modelProfile->lastname_en = $result["นามสกุล(EN)"];
					$modelProfile->sex = $result["เพศ"];
					$modelProfile->date_of_expiry = $result["วันหมดอายุบัตรประชาชน"];
					$modelProfile->place_issued = $result["สถานที่ออกบัตร"];
					$modelProfile->date_issued = $result["วันที่ออกบัตรประชาชน"];
					$modelProfile->passport = $result["เลขหนังสือเดินทาง"];
					$modelProfile->passport_place_issued = $result["สถานที่ออกหนังสือเดินทาง"];
					$modelProfile->passport_date_issued = $result["วันที่ออกหนังสือเดินทาง"];
					$modelProfile->pass_expire = $result["วันหมดอายุหนังสือเดินทาง"];
					$modelProfile->seamanbook = $result["เลขหนังสือเดินเรือ"];
					$modelProfile->seaman_expire = $result["วันหมดอายุเลขหนังสือเดินเรือ"];
					$modelProfile->tel = $result["โทรศัพท์"];
					$modelProfile->domicile_address =  $result["ที่อยู่ตามบัตรประชาชน"];
					$modelProfile->address =  $result["ที่อยู่"];
					$modelProfile->identification = $result["รหัสบัตรประชาชน (13หลัก)"];
					$modelProfile->birthday =  $result["วันเดือนปีเกิด"];
					$modelProfile->age = $result["อายุ"];
					$modelProfile->mouth_birth = $result["เดือน"];
					$modelProfile->place_of_birth = $result["สถานที่เกิด"];
					$modelProfile->blood = $result["กรุ๊ปเลือด"];
					$modelProfile->hight = $result["ความสูง"];
					$modelProfile->weight = $result["น้ำหนัก"];
					$modelProfile->nationality = $result["สัญชาติ"];
					$modelProfile->race = $result["เชื้อชาติ"];
					$modelProfile->religion = $result["ศาสนา"];
					$modelProfile->status_sm = $result["สถานะภาพทางการสมรส"];
					$modelProfile->number_of_children = $result["จำนวนบุตร"];
					$modelProfile->spouse_firstname = $result["ชื่อคู่สมรส"];
					$modelProfile->spouse_lastname = $result["นามสกุลคู่สมรส"];
					$modelProfile->occupation_spouse = $result["อาชีพคู่สมรส"];
					$modelProfile->father_firstname = $result["ชื่อบิดา"];
					$modelProfile->father_lastname = $result["นามสกุลบิดา"];
					$modelProfile->occupation_father = $result["อาชีพบิดา"];
					$modelProfile->mother_firstname = $result["ชื่อมารดา"];
					$modelProfile->mother_lastname = $result["นามสกุลมารดา"];
					$modelProfile->occupation_mother = $result["อาชีพมารดา"];
					$modelProfile->phone = $result["โทรศัพท์ที่ติดต่อฉุกเฉิน"];
					$modelProfile->name_emergency = $result["ชื่อผู้ที่ติดต่อฉุกเฉิน"];
					$modelProfile->relationship_emergency = $result["ความสัมพันธ์"];
					$modelProfile->line_id = $result["ไอดีไลน์"];
					$modelProfile->military = $result["สถานะการรับใช้ชาติ"];
					$modelProfile->history_of_illness = $result["ประวัติการเจ็บป่วยรุนแรง"];
					$modelProfile->sickness = $result["โรคที่เคยป่วย"];
					$modelProfile->accommodation = $result["ที่พัก"];

					if ($modelProfile->validate()) {
						$modelProfile->save();
						$data[$key]['msg'] = 'pass';

						$Insert_success[$key] = "สร้างชื่อผู้ใช้เรียบร้อย";

						$message = '
							<strong>สวัสดี คุณ' . $modelProfile->firstname . ' ' . $modelProfile->lastname . '</strong><br /><br />

							<h4>ระบบได้ทำการอนุมัติสมาชิกเข้าใช้งาน e-Learning Isuzu เรียบร้อยแล้ว โดยมี ชื่อผู้ใช้งานและรหัสผ่านดังนี้ </h4>
	    					<h4>- User : ' . $model->username . '</h4>
							<h4>- Password : ' . $genpass . '</h4>

							โปรดคลิกลิงค์ต่อไปนี้ เพื่อดำเนินการเข้าสู่ระบบ<br />
							<a href="' . str_replace("/admin", "", Yii::app()->getBaseUrl(true)) . '">' . str_replace("/admin", "", Yii::app()->getBaseUrl(true)) . '</a><br />
							<strong>Email</strong> : ' . $model->email . '<br />

							ยินดีต้อนรับเข้าสู่ระบบ e-Learning Isuzu<br /><br />

							';
						$subject = 'ยินดีต้อนรับเข้าสู่ระบบ e-Learning Isuzu';
						$to['email'] = $model->email;
						$to['firstname'] = $modelProfile->firstname;
						$to['lastname'] = $modelProfile->lastname;

						$mail = Helpers::lib()->SendMail($to, $subject, $message);
					} else {

						$HisImportErrorArr[] = $HisImportArr[$key];
						$msgAllArr = array();

						$attrAllArr = array();
						foreach ($modelProfile->getErrors() as $field => $msgArr) {
							$attrAllArr[] = $field;
							$msgAllArr[] = $msgArr[0];
						}

						$HisImportErrorMessageArr[$key] = implode(", ", $msgAllArr);
						$data[$key]['msg'] = implode(", ", $msgAllArr);
						$HisImportAttrErrorArr[] = $attrAllArr;
						$HisImportArr = $sheet_array;
						$deldata = User::model()->findbyPk($model->id);
						$deldata->delete();
						$Insert_success[$key] = "สร้างชื่อผู้ใช้ไม่สำเร็จ";
					}
				} else {
					$msgAllArr = array();
					$attrAllArr = array();
					foreach ($model->getErrors() as $field => $msgArr) {
						$attrAllArr[] = $field;
						$msgAllArr[] = $msgArr[0];
					}
					$data[$key]['msg'] = implode(", ", $msgAllArr);
					// var_dump($model->getErrors());
					// exit();
				}
			} //end loop add user
			//if($model->save())
			// $this->redirect(array('import','id'=>$id));
			$this->render('excel', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success, 'data' => $data));
			exit();
			//}
		}

		// $this->render('excel',array('model'=>$model));
		$this->render('excel', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success));
		// $this->render('import',array(
		//     'model'=>$model,
		// ));
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// $gen = Generation::model()->find('active=1');
		$model = new User;
		$profile = new Profile;
		$this->performAjaxValidation(array($model, $profile));
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
			echo UActiveForm::validate(array($model, $profile));
			Yii::app()->end();
		}

		if (isset($_POST['User'])) {
			// $Neworg = $_POST['Orgchart'];           
			// $Neworg = json_encode($Neworg);
			// $PGoup = $_POST['PGoup'];           
			// $PGoup = json_encode($PGoup);
			// $model->orgchart_lv2 = $Neworg;
			// $model->group = $PGoup;
			// $criteria=new CDbCriteria;
			//          $criteria->compare('department_id',$_POST['User']['department_id']);
			//          $criteria->compare('position_title',$_POST['User']['position_name']);
			// $position = Position::model()->find($criteria);
			//         if(!$position){
			//             $position = new Position;
			//             $position->department_id = $_POST['User']['department_id'];
			//             $position->position_title = $_POST['User']['position_name'];
			//             $position->create_date = date("Y-m-d H:i:s");
			// if(!empty($_POST['User']['department_id']) && !empty($_POST['User']['position_name']))$position->save();
			//         }
			$model->type_register = 1;

			// $model->position_name = $_POST['User']['position_name'];
			// $model->position_id = $position->id;
			// $model->division_id = $_POST['User']['division_id'];
			// $model->company_id = $_POST['User']['company_id'];
			$model->username = $_POST['User']['username'];
			$model->create_at = date('Y-m-d H:i:s');
			// $model->identification = $_POST['User']['identification'];
			// $model->passport = $_POST['User']['passport'];
			// $model->password = $_POST['User']['password'];
			// $model->verifyPassword = $_POST['User']['verifyPassword'];

			//$member = Helpers::lib()->ldapTms($model->email);

			////Test
			// $member['count'] = 0;
			//if($member['count'] > 0){ //TMS
			//$model->type_register = 3;
			// Helpers::lib()->_insertLdap($member);
			// $modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
			// $modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
			// $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

			// $model->division_id = $modelDivision->id;
			// $model->station_id = $modelStation->station_id;
			// $model->department_id = $modelDepartment->id;
			// $model->password = md5($model->email);
			// $model->verifyPassword = $model->password;
			// $model->confirmpass = $model->password;

			// $model->status = 1;
			//$model->email = $member[0]['mail'][0];
			//} else { //LMS
			$model->email = $_POST['User']['email'];
			// $model->password = $_POST['User']['identification'];
			$model->password = $_POST['User']['username'];
			$genpass = $this->RandomPassword();
			$model->password = $genpass;
			$model->verifyPassword = $genpass;

			$model->verifyPassword = $model->password;
			$model->confirmpass = $model->password;
			// $model->department_id = 1;
			$model->department_id = $_POST['User']['department_id'];
			$model->position_id = $_POST['User']['position_id'];
			$model->branch_id = $_POST['User']['branch_id'];
			// $model->station_id = $_POST['User']['station_id'];
			// $model->division_id = $_POST['User']['division_id'];
			$model->repass_status = 0;
			// $model->newpassword = $_POST['User']['identification'];
			$model->status = 1;
			// $model->status = 0;
			$model->scenario = 'general';
			//}
			// $model->department_id = $_POST['User']['department_id'];

			$model->activkey = Yii::app()->controller->module->encrypting(microtime() . $model->password);
			$profile->attributes = $_POST['Profile'];
			$profile->user_id = 0;

			// var_dump($profile->identification);
			// 	var_dump($model->save());
			// 	var_dump($model->getErrors());
			// 	exit();
			// var_dump($model->validate());
			// var_dump($profile->validate());exit();

			if ($model->validate() && $profile->validate()) {


				$model->password = Yii::app()->controller->module->encrypting($genpass);
				// $model->verifyPassword= UserModule::encrypting($model->password);
				$model->verifyPassword = Yii::app()->controller->module->encrypting($genpass);


				$uploadFile = CUploadedFile::getInstance($model, 'pic_user');
				if (isset($uploadFile)) {
					$uglyName = strtolower($uploadFile->name);
					$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
					$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
					$model->pic_user = $beautifulName;
				}
				// $model->status = 1;

				if ($model->save()) {
					if (Yii::app()->user->id) {
						Helpers::lib()->getControllerActionId();
					}
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

					// 	$contacts = $profile->contactfrom;
					// 	foreach ($contacts as $key => $contact) {
					// 				// var_dump($contact);
					// 				// exit();
					// 		if($contact != end($contacts)){
					// 			$value .= $contact.',';
					// 		} else {
					// 			$value .= $contact;
					// 		}

					// 	}
					// 	$profile->contactfrom = $value;
					// }
					// $profile->generation = $gen->id_gen;
					$profile->user_id = $model->id;
					$profile->type_user = 3;
					$profile->save();

					//if($model->type_register != 3 && $model->status != 0){
					$to['email'] = $model->email;
					$to['firstname'] = $profile->firstname;
					$to['lastname'] = $profile->lastname;
					$message = $this->renderPartial('_mail_message', array('model' => $model, 'genpass' => $genpass), true);
					if ($message) {
						$send = Helpers::lib()->SendMail($to, 'สมัครสมาชิกสำเร็จ', $message);
					}
					//}

				}
				$this->redirect(array('view', 'id' => $model->id));
			} else {
				// var_dump($model->getErrors());exit();
				$profile->validate();
				$profile->getErrors();
				$model->getErrors();
			}
		}
		$this->render('create', array(
			'model' => $model,
			'profile' => $profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model = $this->loadModel();
		$profile = $model->profile;
		$model->verifyPassword = $model->password;
		// $this->performAjaxValidation(array($model,$profile));
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
			echo UActiveForm::validate(array($model, $profile));
			Yii::app()->end();
		}
		if (isset($_POST['User'])) {
			// $Neworg = $_POST['Orgchart'];           
			// $Neworg = json_encode($Neworg);
			// $PGoup = $_POST['PGoup'];           
			// $PGoup = json_encode($PGoup);
			// $model->orgchart_lv2 = $Neworg;
			// $model->group = $PGoup;
			// $criteria=new CDbCriteria;
			//          $criteria->compare('department_id',$_POST['User']['department_id']);
			//          $criteria->compare('position_title',$_POST['User']['position_name']);
			//          $position = Position::model()->find($criteria);
			//         if(!$position){
			//             $position = new Position;
			//             $position->department_id = $_POST['User']['department_id'];
			//             $position->position_title = $_POST['User']['position_name'];
			//             $position->create_date = date("Y-m-d H:i:s");
			// if(!empty($_POST['User']['department_id']) && !empty($_POST['User']['position_name']))$position->save();
			//         }
			// $model->position_name = $_POST['User']['position_name'];
			// $model->position_id = $position->id;
			// $model->position_id = isset($_POST['User']['position_id']) ? $_POST['User']['position_id'] : 1;
			// $model->division_id = $_POST['User']['division_id'];
			// $model->company_id = $_POST['User']['company_id'];
			// $model->department_id = $_POST['User']['department_id'];
			// $model->department_id = 2;

			$model->username = $_POST['User']['username'];

			// $model->identification = $_POST['User']['identification'];
			// $model->passport = $_POST['User']['passport'];
			$model->status = $_POST['User']['status'];
			$model->superuser = $_POST['User']['superuser'];
			// if($_POST['User']['newpassword'] != ''){
			// 	$model->password = $_POST['User']['newpassword'];
			// 	$model->verifyPassword = $_POST['User']['confirmpass'];
			// }

			// $member = Helpers::lib()->ldapTms($model->email);
			// $member['çount'] = 0;
			// if($member["count"] > 0){ //TMS
			// 	Helpers::lib()->_insertLdap($member);
			// 	$modelStation = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
			// 	$modelDepartment = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
			// 	$modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));

			// 	$model->division_id = $modelDivision->id;
			// 	$model->station_id = $modelStation->station_id;
			// 	$model->department_id = $modelDepartment->id;
			// 	$model->password = md5($model->email);
			// 	$model->verifyPassword = $model->password;
			// 	$model->confirmpass = $model->password;


			// 	$model->email = $member[0]['mail'][0];
			// }else{ //LMS
			$model->email = $_POST['User']['email'];
			// $model->password = ($_POST['User']['identification']);
			// $model->verifyPassword = $model->password;
			// $model->department_id = 1;
			$model->confirmpass = $model->password;
			$model->department_id = $_POST['User']['department_id'];
			$model->position_id = $_POST['User']['position_id'];
			$model->branch_id = $_POST['User']['branch_id'];
			// $model->station_id = $_POST['User']['station_id'];
			// $model->division_id = $_POST['User']['division_id'];
			if ($_POST['User']['newpassword'] != null) {
				$model->password = Yii::app()->controller->module->encrypting($_POST['User']['newpassword']);
				// $model->verifyPassword=UserModule::encrypting($model->password);
				$model->confirmpass = UserModule::encrypting($_POST['User']['confirmpass']);
			}
			$model->scenario = 'general';
			// }

			$profile->attributes = $_POST['Profile'];
			// $model->verifyPassword = $model->password;
			// var_dump($model->password);
			// var_dump($model->confirmpass);
			// var_dump($model->save());
			// var_dump($model->getErrors());exit();

			if ($model->validate() && $profile->validate()) {
				// $model->password=Yii::app()->controller->module->encrypting($model->password);
				// $model->verifyPassword=UserModule::encrypting($model->verifyPassword);


				// $model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->newpassword);

				// $uploadFile = CUploadedFile::getInstance($model,'pic_user');
				// if(isset($uploadFile))
				// {
				// 	$uglyName = strtolower($uploadFile->name);
				// 	$mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				// 	$beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
				// 	$model->pic_user = $beautifulName;

				// // $rnd = rand(0,999);
				// // $fileName = $time."_Picture.".$uploadFile->getExtensionName();
				// // // $path = Yii::app()->basePath.'/../uploads/user/';
				// // $destination = $path.$fileName;
				// // $w = 200;
				// // $h = 200;
				// // $model->pic_user = $fileName;
				// }

				// if($profile->contactfrom){
				// 	$contacts = $profile->contactfrom;
				// 	foreach ($contacts as $key => $contact) {
				// 					// var_dump($contact);
				// 					// exit();
				// 		if($contact != end($contacts)){
				// 			$value .= $contact.',';
				// 		} else {
				// 			$value .= $contact;
				// 		}

				// 	}
				// 	$profile->contactfrom = $value;
				// }

				$model->save();
				$profile->save();

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
				if (Yii::app()->user->id) {
					Helpers::lib()->getControllerActionId($model->id);
				}
				$this->redirect(array('view', 'id' => $model->id));
			}
			// var_dump($model->getErrors());
			// var_dump($profile->getErrors());
			// exit();
		}
		//$model->position_name = isset($_POST['User']['position_name']) ? $_POST['User']['position_name'] : $model->position->position_title;
		$this->render('update', array(
			'model' => $model,
			'profile' => $profile,
		));
	}
	public function actionPrintpdf()
	{

		$user_id = $_GET['id'];
		if ($user_id != '') {
			$profiles = Profile::model()->find(array(
				'condition' => 'user_id=:user_id ',
				'params' => array('user_id' => $user_id)
			));
			$user = User::model()->find(array(
				'condition' => 'id=:id',
				'params' => array('id' => $user_id)
			));
			$path_img = Yii::app()->baseUrl . '/images/head_print.png';

			// $padding_left = 12.7;
			// $padding_right = 12.7;
			// $padding_top = 10;
			// $padding_bottom = 20;

			require_once __DIR__ . '/../../../vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf();
			//$mPDF = Yii::app()->ePdf->mpdf('th', 'A4', '0', 'garuda', $padding_left, $padding_right, $padding_top, $padding_bottom);
			$mPDF->useDictionaryLBR = false;
			$mPDF->setDisplayMode('fullpage');
			$mPDF->autoLangToFont = true;
			$mPDF->autoPageBreak = true;
			$mPDF->SetTitle("ใบสมัครสมาชิก");
			$texttt = '
         <style>
         body { font-family: "garuda"; }
         </style>
         ';
			$mPDF->WriteHTML($texttt);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('printpdf', array('profiles' => $profiles, 'user' => $user), true), 'UTF-8', 'UTF-8'));
			$mPDF->Output('ใบสมัครสมาชิก.pdf', 'I');
		}
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model = $this->loadModel();
			// $profile = Profile::model()->findByPk($model->id);
			// $profile->delete();
			// $model->status = '0';
			$model->del_status = '1';
			$model->save(false);
			if (Yii::app()->user->id) {
				Helpers::lib()->getControllerActionId();
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}



	public function actionSub_category()
	{
		$data = OrgChart::model()->findAll(
			'parent_id=:parent_id',
			array(':parent_id' => (int) $_POST['orgchart_lv2'])
		);

		$data = CHtml::listData($data, 'id', 'title');
		echo CHtml::tag(
			'option',
			array('value' => ''),
			"---กลุ่มหลักสูตรย่อย---",
			true
		);
		foreach ($data as $value => $name) {
			echo CHtml::tag(
				'option',
				array('value' => $value),
				CHtml::encode($name),
				true
			);
		}
	}

	public function actionGooglesheet()
	{

		if($_GET['type'] == 'p'){
			$data = json_decode($_POST['response']);
			$count = 0;
			foreach ($data as $item) {	
				$count++;
				$criteria=new CDbCriteria;
				$criteria->compare('employee_code',$item->col_a);
				$ck_Profile = Profile::model()->find($criteria);

				if(empty($ck_Profile)){

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_g);
					$OrgChart = OrgChart::model()->find($criteria);

					if(!empty($OrgChart)){
						$user = new User;
						$user->email = $item->col_aa;
						$user->online_status = 0;
						$user->superuser = 0;
						$user->status = 1;
						$model->type_register = 1;
						$user->orgchart_lv2 = $OrgChart->id;
						$user->save(false);

						$profile = new Profile;
						$profile->user_id = $user->id;
						$profile->head_id = $item->col_q;
						$profile->code = $item->col_g;
						$profile->kind = 'p';
						$profile->employee_code = $item->col_a;
						$profile->company_code = $item->col_f;
						$profile->prefix_th = $item->col_s;
						$profile->prefix_en = $item->col_w;
						$profile->firstname = $item->col_t;
						$profile->lastname = $item->col_u;
						$profile->firstname_en = $item->col_x;
						$profile->lastname_en = $item->col_y;
						$profile->head_name = $item->col_r;
						$profile->save(false);
					}

				}else{

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_g);
					$OrgChart = OrgChart::model()->find($criteria);

					if(!empty($OrgChart)){

						$criteria=new CDbCriteria;
						$criteria->compare('email',$item->col_aa);
						$user = User::model()->find($criteria);
						$user->email = $item->col_aa;
						$user->online_status = 0;
						$user->superuser = 0;
						$user->status = 1;
						$model->type_register = 1;
						$user->orgchart_lv2 = $OrgChart->id;
						$user->save(false);

						$criteria=new CDbCriteria;
						$criteria->compare('employee_code',$item->col_a);
						$profile = Profile::model()->find($criteria);
						$profile->head_id = $item->col_q;
						$profile->code = $item->col_g;
						$profile->kind = 'p';
						$profile->employee_code = $item->col_a;
						$profile->company_code = $item->col_f;
						$profile->prefix_th = $item->col_s;
						$profile->prefix_en = $item->col_w;
						$profile->firstname = $item->col_t;
						$profile->lastname = $item->col_u;
						$profile->firstname_en = $item->col_x;
						$profile->lastname_en = $item->col_y;
						$profile->head_name = $item->col_r;
						$profile->save(false);
					}




				}

				// if($count == 1){
				// 	return true;
				// }
				
			}
			return true;

		}else{

			$data = json_decode($_POST['response']);

			foreach ($data as $item) {
				$criteria=new CDbCriteria;
				$criteria->compare('employee_code',$item->col_c);
				$ck_Profile = Profile::model()->find($criteria);

				if(empty($ck_Profile)){

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_q);
					$criteria->compare('level',7);
					$OrgChartTeam = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_p);
					$criteria->compare('level',6);
					$OrgChartSection = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_o);
					$criteria->compare('level',5);
					$OrgChartDivision = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_n);
					$criteria->compare('level',4);
					$OrgChartDepartment = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_b);
					$criteria->compare('level',3);
					$OrgChartCompany = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_a);
					$criteria->compare('level',2);
					$OrgChartCountry = OrgChart::model()->find($criteria);

					if(!empty($OrgChartTeam)||!empty($OrgChartSection)||!empty($OrgChartDivision)||!empty($OrgChartDepartment)||!empty($OrgChartCompany)||!empty($OrgChartCountry)){
						$user = new User;
						$user->email = $item->col_r;
						$user->online_status = 0;
						$user->superuser = 0;
						$user->status = 1;
						$model->type_register = 1;
						if(!empty($OrgChartTeam)){
							$user->orgchart_lv2 = $OrgChartTeam->id;
						}elseif(!empty($OrgChartSection)){
							$user->orgchart_lv2 = $OrgChartSection->id;
						}elseif(!empty($OrgChartDivision)){
							$user->orgchart_lv2 = $OrgChartDivision->id;
						}elseif(!empty($OrgChartDepartment)){
							$user->orgchart_lv2 = $OrgChartDepartment->id;
						}elseif(!empty($OrgChartCompany)){
							$user->orgchart_lv2 = $OrgChartCompany->id;
						}elseif(!empty($OrgChartCountry)){
							$user->orgchart_lv2 = $OrgChartCountry->id;
						}
						$user->save(false);

						$profile = new Profile;
						$profile->user_id = $user->id;
						$profile->head_id = $item->col_t;

						if(!empty($OrgChartTeam)){
							$profile->code = $OrgChartTeam->code;
						}elseif(!empty($OrgChartSection)){
							$profile->code = $OrgChartSection->code;
						}elseif(!empty($OrgChartDivision)){
							$profile->code = $OrgChartDivision->code;
						}elseif(!empty($OrgChartDepartment)){
							$profile->code = $OrgChartDepartment->code;
						}elseif(!empty($OrgChartCompany)){
							$profile->code = $OrgChartCompany->code;
						}elseif(!empty($OrgChartCountry)){
							$profile->code = $OrgChartCountry->code;
						}
						
						$profile->kind = 'r';
						$profile->employee_code = $item->col_c;
						$profile->company_code = $item->col_b;
						// $profile->prefix_th = $item->col_s;
						// $profile->prefix_en = $item->col_w;
						// $profile->firstname = $item->col_e;
						// $profile->lastname = $item->col_f;
						$profile->firstname_en = $item->col_e;
						$profile->lastname_en = $item->col_f;
						$profile->head_name = $item->col_u;
						$profile->save(false);
					}

				}else{

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_q);
					$criteria->compare('level',7);
					$OrgChartTeam = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_p);
					$criteria->compare('level',6);
					$OrgChartSection = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_o);
					$criteria->compare('level',5);
					$OrgChartDivision = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_n);
					$criteria->compare('level',4);
					$OrgChartDepartment = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_b);
					$criteria->compare('level',3);
					$OrgChartCompany = OrgChart::model()->find($criteria);

					$criteria=new CDbCriteria;
					$criteria->compare('code',$item->col_a);
					$criteria->compare('level',2);
					$OrgChartCountry = OrgChart::model()->find($criteria);
					if(!empty($OrgChartTeam)||!empty($OrgChartSection)||!empty($OrgChartDivision)||!empty($OrgChartDepartment)||!empty($OrgChartCompany)||!empty($OrgChartCountry)){

						$criteria=new CDbCriteria;
						$criteria->compare('email',$item->col_s);
						$user = User::model()->find($criteria);
						$user->email = $item->col_r;
						$user->online_status = 0;
						$user->superuser = 0;
						$user->status = 1;
						$model->type_register = 1;
						if(!empty($OrgChartTeam)){
							$user->orgchart_lv2 = $OrgChartTeam->id;
						}elseif(!empty($OrgChartSection)){
							$user->orgchart_lv2 = $OrgChartSection->id;
						}elseif(!empty($OrgChartDivision)){
							$user->orgchart_lv2 = $OrgChartDivision->id;
						}elseif(!empty($OrgChartDepartment)){
							$user->orgchart_lv2 = $OrgChartDepartment->id;
						}elseif(!empty($OrgChartCompany)){
							$user->orgchart_lv2 = $OrgChartCompany->id;
						}elseif(!empty($OrgChartCountry)){
							$user->orgchart_lv2 = $OrgChartCountry->id;
						}
						$user->save(false);

						$criteria=new CDbCriteria;
						$criteria->compare('employee_code',$item->col_c);
						$profile = Profile::model()->find($criteria);

			
						$profile->head_id = $item->col_t;

						if(!empty($OrgChartTeam)){
							$profile->code = $OrgChartTeam->code;
						}elseif(!empty($OrgChartSection)){
							$profile->code = $OrgChartSection->code;
						}elseif(!empty($OrgChartDivision)){
							$profile->code = $OrgChartDivision->code;
						}elseif(!empty($OrgChartDepartment)){
							$profile->code = $OrgChartDepartment->code;
						}elseif(!empty($OrgChartCompany)){
							$profile->code = $OrgChartCompany->code;
						}elseif(!empty($OrgChartCountry)){
							$profile->code = $OrgChartCountry->code;
						}
						
						$profile->kind = 'r';
						$profile->employee_code = $item->col_c;
						$profile->company_code = $item->col_b;
						// $profile->prefix_th = $item->col_s;
						// $profile->prefix_en = $item->col_w;
						// $profile->firstname = $item->col_e;
						// $profile->lastname = $item->col_f;
						$profile->firstname_en = $item->col_e;
						$profile->lastname_en = $item->col_f;
						$profile->head_name = $item->col_u;

						
						$profile->save(false);
					}


				}
				
			}

			return true;
		}
		
	}

	// public function actionDivision()
	// {
	// 	$data=Division::model()->findAll('company_id=:company_id',
	// 		array(':company_id'=>(int)$_POST['company_id']));
	// 	$options[] = CHtml::tag('option',
	// 		array('value'=>''),"---เลือกศูนย์/แผนก---",true);
	// 	$data = CHtml::listData($data,'id','div_title');
	// 	foreach($data as $value=>$name)
	// 	{
	// 		$options[] =  CHtml::tag('option',
	// 			array('value'=>$value),CHtml::encode($name),true);
	// 	}

	// 	$data1=Position::model()->findAll('company_id=:company_id',
	// 		array(':company_id'=>(int)$_POST['company_id']));
	// 	$options1[] = CHtml::tag('option',
	// 		array('value'=>''),"---เลือกตำแหน่ง---",true);
	// 	$data1 =CHtml::listData($data1,'id','position_title');
	// 	foreach($data1 as $value=>$name)
	// 	{
	// 		$options1[] =  CHtml::tag('option',
	// 			array('value'=>$value),CHtml::encode($name),true);
	// 	}

	// 	echo json_encode(array("data_dsivision"=>$options,'data_position'=>$options1));
	// }

	// public function LoadDivision($company_id)
	// {
	// 	$data=Division::model()->findAll('company_id=:company_id',
	// 		array(':company_id'=>$company_id)
	// 	);

	// 	$data=CHtml::listData($data,'id','dep_title');

	// 	return $data;
	// }



	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($validate)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
			echo CActiveForm::validate($validate);
			Yii::app()->end();
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if ($this->_model === null) {
			if (isset($_GET['id']))
				$this->_model = User::model()->notsafe()->findbyPk($_GET['id']);
			if ($this->_model === null)
				throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $this->_model;
	}

	public function actionResetPhoto()
	{
		if($_POST["user_id"]){
			$users = UsersReset::model()->with('profiles')->findbyPk($_POST["user_id"]);
			if($users){
				$users->face_regis = 0;
				if($users->save()){
					$faceRegis = Yii::app()->basePath."/../../uploads/FaceRegis/".$_POST["user_id"].".jpg";
					$idCard = Yii::app()->basePath."/../../uploads/IdCard/".$_POST["user_id"].".jpg";
					$profile = Yii::app()->basePath."/../../uploads/users/".$_POST["user_id"]."/".$users->profiles->profile_picture;
					if (file_exists($faceRegis)) {
						unlink($faceRegis);
					}
					if (file_exists($idCard)) {
						unlink($idCard);
					}
					if (file_exists($profile)) {
						unlink($profile);
					}
					echo true;
					exit();
				}
			}
		}
		echo false;
		exit();
	}

	public function actionEditProfilePhoto($id)
	{
		$users = Users::model()->findbyPk($_GET["id"]);
		if($users){
			$profiles = Profile::model()->findByPk($users->id);
		}
		if($_POST){
			if ($_FILES['picture']['tmp_name'] != "") {
				$profiles->profile_picture = $_FILES['picture']['name'];
			}
			if($profiles->validate()){
				if ($_FILES['picture']['tmp_name'] != "") {
					$tempFile   = $_FILES['picture'];
					$path = "users";
					$base64_pic = $_POST["url_pro_pic"];
					$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$users->id,$base64_pic);
					if ($filename) {
						$profiles->profile_picture = $filename;
					}
				}
				if($profiles->save()){
					$this->redirect(array('/user/admin/general'));
				}

			}
		}
		$this->render('EditProfilePhoto', array('users' => $users,'profiles' => $profiles));     
	}
}
