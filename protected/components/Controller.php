<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public function init()
	{
		parent::init();

		if(empty(Yii::app()->session['lang'])){
			Yii::app()->session['lang'] = 2;
		}

		if(!empty($_GET['lang'])) {
			$lang = Language::model()->findByAttributes(array('id'=>$_GET['lang']));
			Yii::app()->session['lang'] = $_GET['lang'];
			if(!$lang){
				Yii::app()->session['lang'] = 1;
				header("Location:{$_SERVER['REDIRECT_URL']}");
			}
		}

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
            Yii::app()->language = 'en';
            $langId = Yii::app()->session['lang'] = 1;
            $this->pageTitle = 'Marine Department e-Learning System';
        }else{
        	Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
            $langId = Yii::app()->session['lang'];
            $this->pageTitle = 'ระบบการเรียนรู้ Marine Department';
        }
        	//Check Session

        if (User::model()->findbyPk(Yii::app()->user->id)->repass_status=='0' 
        	&& Yii::app()->controller->id != 'registration'){
        	if(!isset($_GET['type_repass'])){
        		// $this->redirect(array('registration/Repassword'));
        	}
				//var_dump(Yii::app()->controller->id);
				//exit();

        }
	     //  elseif (User::model()->findbyPk(Yii::app()->user->id)->repass_status=='2' 
	    	// && Yii::app()->controller->id != 'registration') {
	     //  	$this->redirect(array('registration/Update','id'=>Yii::app()->user->id));
	     //  	# code...
	     //  }

			if(Yii::app()->user->id != null){
				// var_dump(Yii::app()->request->cookies['token_login']->value);exit();
				$this->checkToken(Yii::app()->request->cookies['token_login']->value);
			}

		}

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * Initializes the controller.
	 * This method is called by the application before the controller starts to execute.
	 * You may override this method to perform the needed initialization for the controller.
	 */

	private function checkToken($token){
		$logoutid = User::model()->findByPk(Yii::app()->user->id);
		if($logoutid->avatar != $token){
			$this->gotoLogout();
		}
	}

	private function gotoLogout()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		$logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
		$logoutid->lastvisit_at = date("Y-m-d H:i:s",time()) ;
		$logoutid->online_status = '0';
		$logoutid->save(false);
		Yii::app()->user->logout();
		$this->redirect(array('site/index'));
	}

	public static function activeMenu($controller,$activeCssClass='active'){
		$currentController = Yii::app()->controller->id;
		if($currentController == $controller){
			return ' '.$activeCssClass;
		}else{
			return '';
		}
	}

	public static function getOnlineUsers()
	{
		$sql = "SELECT session.user_id, user.name FROM session LEFT JOIN user ON user.id=session.user_id";
		$command = Yii::app()->db->createCommand($sql);

		return $command->queryAll();
	}

	private function checkProfile($id){
		$users = User::model()->findbyPk($id);
        $profile = Profile::model()->findbyPk($id);
        $state = true;
        if(empty($users->department_id) || empty($users->station_id)){
        	// var_dump($users->getErrors());exit();
        	$state = false;
        }
        if(!$profile->validate()){
        	// var_dump($profile->getErrors());exit();
        	$state = false;
        }
        return $state;
	}
	
// 	protected function beforeAction($action)
// 	{
// //		var_dump($action->id, $this->id, $this->module->id);
// 		if (!Yii::app()->user->isGuest) {
// 			if(isset(Yii::app()->user->password_expire_date)) {
// 				if (Yii::app()->user->password_expire_date != '' && Yii::app()->user->password_expire_date < date('Y-m-d H:i:s')) {
// 					if ($action->id != 'changepassword') {
// 						Yii::app()->user->setFlash('passexpire', 'รหัสผ่านของคุณหมดอายุ กรุณาเปลี่ยนรหัสผ่านใหม่');
// 						$this->redirect(array('/user/profile/changepassword'));
// 					}
// 				}
// 			}else{
// 				if ($action->id != 'changepassword') {
// 					Yii::app()->user->setFlash('passexpire', 'คุณเข้าสู่ระบบด้วยรหัสผ่านที่ระบบสร้างให้ กรุณาเปลี่ยนรหัสผ่านใหม่');
// 					$this->redirect(array('/user/profile/changepassword'));
// 				}
// 			}
// 		}
// 		return parent::beforeAction($action);
// 	}


	// Query ImageSlide
	public function ImageSlide()
	{
		$img = Imgslide::model()->findAll(array('order'=>'imgslide_id DESC'));
		$imgDataProvider = new CArrayDataProvider($img, array(
		    'pagination'=>array(
		        'pageSize'=>5,
		    ),
		));
		return $imgDataProvider;
	}

	public function checkVisible()
	{
		if(!Yii::app()->user->isGuest)
			return true;
		else
			return false;
	}

	// Query List Teacher
	public function listTeacher($model,$class='')
	{
		$list = CHtml::listData(Teacher::model()->findAll(array(
		"condition"=>" active = 'y' ")),'teacher_id', 'teacher_name');
		return CHtml::activeDropDownList($model,'course_lecturer',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List ShopType
	public function listShopTypeShow($model,$class='')
	{
		$list = CHtml::listData(Shoptype::model()->findAll(array(
		"condition"=>" active = 'y' ",'order'=>'shoptype_id')),'shoptype_id', 'shoptype_name');
		return CHtml::activeDropDownList($model,'shoptype_id',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Query List Bank
	public function listShopBankShow($model,$class='')
	{
		$list = CHtml::listData(Bank::model()->findAll(array(
		'order'=>'bank_id')),'bank_id', 'bank_name');
		return CHtml::activeDropDownList($model,'order_bank',$list , array(
			'empty'=>'ทั้งหมด',
			'class'=>$class
		));
	}

	// Show Image Page Update
	public function ImageShowUpdate($model,$image)
	{
		if(!$model){
$retuenImage = <<<IMG
			<div class="row">
IMG;
			$retuenImage.= CHtml::image(Yii::app()->checkShowImage(null,$image),'',array("class"=>"thumbnail"));
$retuenImage.= <<<IMG
			</div>
IMG;
		return $retuenImage;
		} 		
	}

	// MessageError
	public static function MessageError($type = "")
	{
		if($type == 'int') // type Int
			$messageText = Yii::t('yii','{attribute} must be a number.');
		else if($type == 'username')
			$messageText = UserModule::t("ชื่อผู้ใช้นี้เคยใช้แล้ว");
		else if($type == 'passold')
			$messageText = UserModule::t("รหัสผ่านเก่าไม่ถูกต้อง");
		else if($type == 'emailPk')
			$messageText = UserModule::t("อีเมล์ นี้เคยใช้แล้ว");
		else if($type == 'email')
			$messageText = UserModule::t("รูปแบบการใช้ อีเมล์ ผิด");
		else if($type == 'Retype')
			$messageText = UserModule::t("รหัสผ่านไม่ตรงกัน");
		else if($type == 'pattern')
			$messageText = 'ข้อมูลควรเป็น (A-z0-9)';
		else if($type == 'min')
			$messageText = UserModule::t("ข้อมูลต้องมีตัวอักษรมากกว่า 6 ตัวอักษร");
		else if($type == 'max') // type Max characters
			$messageText = Yii::t('yii','{attribute} is too long (maximum is {max} characters).');
		else if($type == 'img')
			$messageText = Yii::t('yii', 'The file "{file}" cannot be uploaded. Only files with these extensions are allowed: {extensions}.');
		else if($type == 'maxSize')
			$messageText = 'ขนาดไฟล์แนบต้องไม่เกิน 500 KB';
		else
			$messageText = Yii::t('yii','{attribute} cannot be blank.');

		$messageError = "<p class='error help-block'><span class='label label-important'>".$messageText."</span></p>";
		return $messageError;
	}
	
	public static function ImageShowUser($Yush,$data,$image,$data2,$array=array(),$noimgname='default-avatar.png')
	{
		if(@getimagesize(Yush::getUrl($data, $Yush, $image))){

			$imgCheck = CHtml::image(Yush::getUrl($data, $Yush, $image),$image,$array);

		}elseif (@getimagesize(Yush::getUrl($data2, $Yush, $image))) {

			$imgCheck = CHtml::image(Yush::getUrl($data2, $Yush, $image),$image,$array);

		}else{

			$imgCheck = CHtml::image(Yii::app()->theme->baseUrl.'/images/'.$noimgname, 'No Image', $array);

		}

		return $imgCheck;
	}	

	
	public static function ImageShowIndex($Yush,$data,$image,$array=array(),$noimgname='logo_course.png')
	{
		if($image != null)
			$imgCheck = CHtml::image(Yush::getUrl($data, $Yush, $image),$image,$array);
		else
			$imgCheck = CHtml::image(Yii::app()->theme->baseUrl.'/images/'.$noimgname, 'No Image', $array);

		return $imgCheck;
	}
	public function lastactivity()
	{
		// Yii::app()->request->cookies->clear();
		if (!Yii::app()->user->isGuest) {
		
		$id = Yii::app()->user->id;
		$id_lastactivity = User::model()->findByPk($id);
		$id_lastactivity->last_activity = date("Y-m-d H:i:s",time());
		$id_lastactivity->lastactivity = time();
		
		if ($id_lastactivity->save(false)) {
			
		}
		
		}
		
	}

	public $breadcrumbs=array();
}