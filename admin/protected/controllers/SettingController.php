<?php

class SettingController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
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
            // array('allow',  // allow all users to perform 'index' and 'view' actions
            //     'actions' => array('index', 'view'),
            //     'users' => array('*'),
            //     ),
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
    // public function filters() 
    // {
    //     return array(
    //         'rights',
    //     );
    // }
    
    public $defaultAction = 'Create';
    
    public function actionCreate()
    {
    	$model=Setting::model()->find();

    	if(!$model)
    	{
    		$model = new Setting();
    	}

    	$imageShow = $model->settings_intro_bg;

    	if(isset($_POST['Setting']))
    	{
    		$time = date("dmYHis");
    		$model->attributes=$_POST['Setting'];

			$imageOld = $model->settings_intro_bg; // Image Old

			$settings_intro_bg = CUploadedFile::getInstance($model, 'settings_intro_bg');
			if(isset($settings_intro_bg)){
				$fileNamePicture = $time."_Picture.".$settings_intro_bg->getExtensionName();
				$model->settings_intro_bg = $fileNamePicture;
			}

			if($model->validate())
			{
				if($model->save())
				{
					if(isset($imageShow) && isset($settings_intro_bg))
					{
						Yii::app()->getDeleteImageYush('setting',$model->id,$imageShow);
					}

					if(isset($settings_intro_bg))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);
						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->settings_intro_bg);
						$settings_intro_bg->saveAs($originalPath);
					}

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}

					$this->redirect(array('create'));
				}	
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'imageShow'=>$imageShow
		));
	}

	public function actionDeleteImageBg($id)
	{
		$model = $this->loadModel($id);
		if(isset($model->settings_intro_bg))
		{
			Yii::app()->getDeleteImageYush('setting',$model->id,$model->settings_intro_bg);
			echo 1;
		}
	}

	public function loadModel($id)
	{
		$model=Setting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='setting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
