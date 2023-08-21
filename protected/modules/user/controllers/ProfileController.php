<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	// public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = User::model()->findByPk(Yii::app()->user->id);
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function loadDepartment($department_id){
	 $data=OrgChart::model()->findAll('id=:id',
		 array(':id'=>$department_id)
	 );

	 $data=CHtml::listData($data,'id','title');

	 return $data;
 }

 public function actionSub_category() {
			 $data=OrgChart::model()->findAll('parent_id=:parent_id',
					 array(':parent_id'=>(int) $_POST['orgchart_lv2']));

			 $data=CHtml::listData($data,'id','title');
			 echo CHtml::tag('option',
					 array('value'=>''),"---แผนก---",true);
			 foreach($data as $value=>$name)
			 {
					 echo CHtml::tag('option',
							 array('value'=>$value),CHtml::encode($name),true);
			 }

	 }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;

		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];

			if($model->validate()&&$profile->validate()) {
				$uploadFile = CUploadedFile::getInstance($model,'pic_user');
				$uploadFile2 = CUploadedFile::getInstance($profile,'file_user');
				$model->bookkeeper_id = $model->username;
					if(isset($uploadFile))
						{
							$uglyName = strtolower($uploadFile->name);
				            $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
				            $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
							$model->pic_user = $beautifulName;
						}
					if(isset($uploadFile2))
						{
							$uglyName = strtolower($uploadFile2->name);
						    $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
						    $beautifulName = trim($mediocreName, '_') . "." . $uploadFile2->extensionName;
							$profile->file = $beautifulName;
						}

					if($model->newpassword){
						$model->password = UserModule::encrypting($model->newpassword);
						$model->verifyPassword = $model->password;
					}

						if($model->save()) {
								if(isset($uploadFile))
								{
									/////////// SAVE IMAGE //////////
									Yush::init($model);
												$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_user);
												$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_user);
												$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_user);
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

							if($profile->contactfrom){
								$contacts = $profile->contactfrom;
								foreach ($contacts as $key => $contact) {
									// var_dump($contact);
									// exit();
									if($contact != end($contacts)){
										$value .= $contact.',';
									} else {
										$value .= $contact;
									}
									
								}
								$profile->contactfrom = $value;
							}

							if($profile->save()) {
								if(isset($uploadFile2))
							{
								/////////// SAVE IMAGE //////////
								Yush::init($profile);

											$originalPath = Yush::getPath($profile, Yush::SIZE_ORIGINAL, $profile->file);
											// Save the original resource to disk
											$uploadFile2->saveAs($originalPath);
							}
							}
						}
                // Yii::app()->user->updateSession();
				// Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {

			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}

			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}
