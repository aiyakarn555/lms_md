<?php

class AuthorityHRController extends Controller
{

	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
        	// 'rights- toggle, switch, qtoggle',
        );
	}

      public function init()
    {
        parent::init();
        $this->lastactivity();

    }

    
	public function actionIndex()
	{
		if(isset($_GET['user_list'])){
			$authority_hr = 1;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->authority_hr = $authority_hr;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('AuthorityHR/index'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->authority_hr = null;
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}


		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->addCondition('authority_hr IS NULL');
		$userAll = User::model()->with('profile')->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 1);
		$user_hr1 = User::model()->with('profile')->findAll($criteria);



		$this->render('index', array('userAll'=>$userAll, 'user'=>$user_hr1));
	}

	public function actionHr2()
	{

		if(isset($_GET['user_list'])){
			$authority_hr = 2;

			if (!empty($_GET['user_list'])) {
				foreach ($_GET['user_list'] as $key => $value) {
					$user = User::model()->findByPk($value);
					$user->authority_hr = $authority_hr;
					$user->save(false);

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId($value);
					}
				}
			}

			$this->redirect(array('AuthorityHR/hr2'));
		}elseif(isset($_POST['user_id'])){
			if($_POST['user_id'] != ""){
				$user = User::model()->findByPk($_POST['user_id']);
				$user->authority_hr = null;
				$user->save(false);

				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($_POST['user_id']);
				}

				echo "success";
				exit();
			}
		}



		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->addCondition('authority_hr IS NULL');
		$userAll = User::model()->with('profile')->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->compare('superuser', 1);
		$criteria->compare('authority_hr', 2);
		$user_hr2 = User::model()->with('profile')->findAll($criteria);



		$this->render('hr2', array('userAll'=>$userAll, 'user'=>$user_hr2));
	}
}