<?php

class RegistrationController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public $defaultAction = 'registration';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
        /*
	/**
	 * Registration user
	 */

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
			
	public function actionRegistration() {
            $model = new RegistrationForm;
            $profile=new Profile;
            $profile->regMode = true;

			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				echo UActiveForm::validate(array($model,$profile));
				Yii::app()->end();
			}

		    if (Yii::app()->user->id) {
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes=$_POST['RegistrationForm'];
					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					if($model->validate()&&$profile->validate())
					{

						$soucePassword = $model->password;
						$model->bookkeeper_id = $model->username;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);


						$uploadFile = CUploadedFile::getInstance($model,'pic_user');
						if(isset($uploadFile))
						{

						$uglyName = strtolower($uploadFile->name);
			            $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '_', $uglyName);
			            $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
						$model->pic_user = $beautifulName;
						}

						if($model->save()&&$profile->save()) {
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

							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
							}

							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
								$this->refresh();
							}
						}
					} else $profile->validate();
				}
			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
		    }
	}
}
