<?php

class ReportAuthorityController extends Controller
{

	public function init()
	{
		parent::init();
		$this->lastactivity();		
	}

	public function actionBoard()
	{
		$criteria = new CDbCriteria;			

		if($_GET['search']["fullname"] != ""){
			$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

			if(isset($ex_fullname[0])){    			
				$name = $ex_fullname[0];
				$criteria->compare('profile.firstname', $name, true);
				$criteria->compare('profile.lastname', $name, true, 'OR');
			}

			if(isset($ex_fullname[1])){
				$name = $ex_fullname[1];
				$criteria->compare('profile.lastname',$name,true, 'OR');
			}
		}
		if($_GET['search']["position"] != ""){
			$criteria->compare('position_id', $_GET["search"]["position"]);
		}

		$criteria->compare('superuser', 0);
		$criteria->compare('del_status', 0);
		$criteria->compare('repass_status', 1);
		$criteria->compare('register_status', 1);
		$criteria->compare('status', 1);

		$criteria->addCondition('(profile.type_user = 1 AND profile.type_employee = 1) OR (profile.type_user = 3 AND profile.type_employee = 2)');
		//OR profile.type_user = 5
		// $criteria->addCondition('profile.type_employee = 1 OR profile.type_employeee = 2');
		$criteria->addCondition('report_authority IS NULL');
		$criteria->order = 'profile.firstname ASC';
		$userAll = User::model()->with('profile')->findAll($criteria);

		$user_board = User::model()->findAll(array(
			'condition'=>'superuser=0 AND report_authority=1',
			'order'=>'profile.firstname ASC',
		));

		if(isset($_GET['user_list'])){
			$report_authority = 1;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/board'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}

		$this->render('board',array(
			'userAll'=>$userAll,
			'user_board'=>$user_board
		));
	}

	public function actionDivisionManager()
	{
        $criteria = new CDbCriteria;			
		
		if($_GET['search']["fullname"] != ""){
			$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

			if(isset($ex_fullname[0])){    			
				$name = $ex_fullname[0];
				$criteria->compare('profile.firstname', $name, true);
				$criteria->compare('profile.lastname', $name, true, 'OR');
			}

			if(isset($ex_fullname[1])){
				$name = $ex_fullname[1];
				$criteria->compare('profile.lastname',$name,true, 'OR');
			}
		}
		if($_GET['search']["position"] != ""){
			$criteria->compare('position_id', $_GET["search"]["position"]);
		}

		$criteria->compare('superuser', 0);
		$criteria->compare('del_status', 0);
		$criteria->compare('repass_status', 1);
		$criteria->compare('register_status', 1);
		$criteria->compare('status', 1);
		$criteria->compare('department.active', 'y');
		// $criteria->addCondition('profile.type_user = 1 OR profile.type_user = 3');
		// $criteria->addCondition('profile.type_employee = 1 OR profile.type_employee = 2');
		$criteria->addCondition('(profile.type_user = 1 AND profile.type_employee = 1) OR (profile.type_user = 3 AND profile.type_employee = 2)');
		$criteria->addCondition('report_authority IS NULL');
		$criteria->addCondition('user.department_id IS NOT NULL');		
		$criteria->order = 'profile.firstname ASC';
		$userAll = User::model()->with('profile', 'department')->findAll($criteria);

		$user_division = User::model()->findAll(array(
            'condition'=>'superuser=0 AND report_authority=2 AND department_id IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));

        if(isset($_GET['user_list'])){
			$report_authority = 2;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/DivisionManager'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}

		$this->render('divisionManager',array(
			'userAll'=>$userAll,
			'user_division'=>$user_division
		));
	}

	public function actionDepartmentManager()
	{
		$criteria = new CDbCriteria;			
		
		if($_GET['search']["fullname"] != ""){
			$ex_fullname = explode(" ", $_GET["search"]["fullname"]);

			if(isset($ex_fullname[0])){    			
				$name = $ex_fullname[0];
				$criteria->compare('profile.firstname', $name, true);
				$criteria->compare('profile.lastname', $name, true, 'OR');
			}

			if(isset($ex_fullname[1])){
				$name = $ex_fullname[1];
				$criteria->compare('profile.lastname',$name,true, 'OR');
			}
		}
		if($_GET['search']["position"] != ""){
			$criteria->compare('position_id', $_GET["search"]["position"]);
		}

		$criteria->compare('superuser', 0);
		$criteria->compare('del_status', 0);
		$criteria->compare('repass_status', 1);
		$criteria->compare('register_status', 1);
		$criteria->compare('status', 1);
		$criteria->compare('department.active', 'y');
		$criteria->compare('position.active', 'y');		
		// $criteria->addCondition('profile.type_user = 1 OR profile.type_user = 3');
		// $criteria->addCondition('profile.type_employee = 1 OR profile.type_employee = 2');
		$criteria->addCondition('(profile.type_user = 1 AND profile.type_employee = 1) OR (profile.type_user = 3 AND profile.type_employee = 2)');
		$criteria->addCondition('report_authority IS NULL');
		$criteria->addCondition('user.department_id IS NOT NULL');
		$criteria->addCondition('user.position_id IS NOT NULL');
		
		$criteria->order = 'profile.firstname ASC';
		$userAll = User::model()->with('profile', 'department', 'position')->findAll($criteria);

		$user_department = User::model()->findAll(array(
            'condition'=>'superuser=0 AND report_authority=3 AND user.department_id IS NOT NULL AND position_id IS NOT NULL',
            'order'=>'profile.firstname ASC',
        ));

        if(isset($_GET['user_list'])){
			$report_authority = 3;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->report_authority = $report_authority;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('ReportAuthority/DepartmentManager'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->report_authority = "";
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}
				
				echo "success";
				exit();
			}
		}

		$this->render('departmentManager',array(
			'userAll'=>$userAll,
			'user_department'=>$user_department
		));
	}



}