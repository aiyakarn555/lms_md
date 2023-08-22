<?php

class DocumentController extends Controller {
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
        );
	}
	public function init()
	{
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
		}
		parent::init();
		if (isset($_GET['lang_id']) || isset($_GET['parent_id']) ) {
			$langId = $_GET['lang_id'];
			$actionName = Yii::app()->urlManager->parseUrl(Yii::app()->request);
			
			if($langId != 1 && $actionName != "Document/createtype"){
				$lang = Language::model()->findByPk($langId);
				$parentId = $_GET['parent_id'];
				if(strtolower($actionName) == strtolower("Document/create")){
					$checkRoot = Document::model()->findByAttributes(array('parent_id'=> $parentId,'active'=>'1'));
					if(!isset($checkRoot)){
						$Root = Document::model()->findByAttributes(array('dow_id'=> $parentId,'active'=>'1'));
						$cateRoot = DocumentType::model()->findByAttributes(array('parent_id'=> $Root->dty_id,'lang_id'=>$langId,'active'=>'1'));
						$cateMain = DocumentType::model()->findByAttributes(array('dty_id'=> $Root->dty_id,'active'=>'1'));
						if(!$cateRoot){
							Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มประเภทเอกสาร '.$cateMain->dty_name .',ภาษา '.$lang->language);
							$this->redirect(array('Document/index_type'));
							exit();
						}
					}
				}
			}else{
				$lang = Language::model()->findByPk($langId);
				$parentId = $_GET['parent_id'];
				if(strtolower($actionName) != strtolower("Document/createtype") && strtolower($actionName) != strtolower("document/update_type/view")){
					$Root = Document::model()->findByAttributes(array('dow_id'=> $parentId,'active'=>'1'));
					$cateRoot = DocumentType::model()->findByAttributes(array('dty_id'=> $Root->dty_id,'lang_id'=>$langId,'active'=>'1'));
					$cateMain = DocumentType::model()->findByAttributes(array('dty_id'=> $Root->dty_id,'active'=>'1'));
					if(!$cateRoot){
						Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มประเภทเอกสาร '.$cateMain->dty_name .',ภาษา '.$lang->language);
						$this->redirect(array('Document/index_type'));
						exit();
					}
			    }
			}
		}
		$this->lastactivity();
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
            	'actions' => array('index', 'view','MultiDelete'),
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

	// public function init()
	// {
	// 	parent::init();
	// 	$this->lastactivity();

	// }

    public function actionIndex() {
    	$model = new Document('search');
    	$model->unsetAttributes();
    	if (isset($_GET['Document']))
    		$model->attributes = $_GET['Document'];
    	$this->render('index', array(
    		'model' => $model,
    	));
    }

    public function actionIndex_Type() {
    	$model = new DocumentType('search');
    	$model->unsetAttributes();
    	if (isset($_GET['DocumentType']))
    		$model->attributes = $_GET['DocumentType'];
    	$this->render('index_type', array(
    		'model' => $model,
    	));
    }

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionUpdate($id)
    {
		// var_dump($_POST['Document']);
		// echo $_POST['Document']['dow_detail'];
		// exit();
    	$model=$this->loadModel($id);
    	$imageShow = $model->dow_address;

			// echo '<pre>'; var_dump($model); exit();

    	if(isset($_POST['Document']))
    	{
    		$time = date("dmYHis");
    		$model->dow_detail = $_POST['Document']['dow_detail'];
    		$model->dow_name = $_POST['Document']['dow_name'];
    		$model->dty_id = $_POST['DocumentType']['dty_id'];
    		$model->updatedate = date('Y-m-d H:i:s');

    		$dow_address = CUploadedFile::getInstance($model, 'dow_address');
			// $cate_image = CUploadedFile::getInstance($model, 'dow_address');
			//echo $dow_address;exit();
    		if(isset($dow_address)){
    			$fileNamePicture = $time."_Files.".$dow_address->getExtensionName();
    			$model->dow_address = $fileNamePicture;
    		}else{
    			$model->dow_address = $imageShow;
    		}
    		if($model->validate())
    		{
    			if($model->save())
    			{
    				if(isset($dow_address))
    				{
								/////////// SAVE IMAGE //////////
    					$tempSave = CUploadedFile::getInstance($model, 'dow_address');
								//$fileName = "{$tempSave}";
								//$model->dow_address = $model->dow_address;
    					$Pathuploadfile = Yii::app()->basePath.'/../uploads/'.$fileNamePicture;
								// var_dump($Pathuploadfile);exit();
								if(!empty($tempSave))  // check if uploaded file is set or not
								{
									$tempSave->saveAs($Pathuploadfile);
								}
							}
							if(Yii::app()->user->id){
								Helpers::lib()->getControllerActionId();
							}

							$this->redirect(array('view','id'=>$model->dow_id));
						//$this->redirect(array('Document/index','model'=>$model));
					// $this->redirect('index');
						} else {
							echo "string";
							exit();
						}
					} else {
						var_Dump($model->getErrors());
						exit();
					}
				}
				$this->render('update',array(
					'model'=>$model,
					'imageShow'=>$imageShow,
				));
			}

			public function actionUpdate_type($id)
			{
				$model=$this->loadModelType($id);

				if(isset($_POST['DocumentType']))
				{
					$model->dty_name = $_POST['DocumentType']['dty_name'];
					$model->updatedate = date('Y-m-d H:i:s');

					if($model->validate())
					{
						if($model->save())
						{
							if(Yii::app()->user->id){
								Helpers::lib()->getControllerActionId();
							}
							$this->redirect(array('index_type'));

						}
					} else {
						var_Dump($model->getErrors());
						exit();
					}
				}
				$this->render('update_type',array(
					'model'=>$model,
				));
			}
    // Uncomment the following methods and override them if needed

			public function actionCreateType()
			{


				$model = new DocumentType;
				if(isset($_POST['DocumentType']['dty_name']))
				{
					$model->dty_name = $_POST['DocumentType']['dty_name'];
					$model->active='1';
					$model->createby = $id;
					$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
					$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
					if ($model->validate()) {
						if($model->save()){
							if(Yii::app()->user->id){
								Helpers::lib()->getControllerActionId();
							}
							$langs = Language::model()->findAll(array('condition'=>'active = "y"  and id != 1'));
							if($model->parent_id == 0){
								$rootStationId = $model->dty_id;
							}else{
								$rootStationId = $model->parent_id;
							}
							
							foreach ($langs as $key => $lang) {
								# code...

								$station = DocumentType::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootStationId));
								if(!$station){
									$stationRoot = DocumentType::model()->findByPk($rootStationId);
									Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มประเภทเอกสาร '.$stationRoot->dty_name .',ภาษา '.$lang->language);
						          	// $this->redirect(array('Category/index'));
						          	$this->redirect(array('createtype','lang_id'=> $lang->id,'parent_id'=> $rootStationId));
						          	exit();
								}
							}
							$this->redirect(array('index_type','id'=>$model->dty_id));

						}else{
							var_dump($model->getErrors());exit();
						}
					}

				}
					$this->render('create_type',array(
						'model'=>$model,
					));
				}

				public function actionCreate()
			{
				$criteria = new CDbCriteria;
				$criteria->compare('active', 1);
				$DocumentType = DocumentType::model()->findAll($criteria);
				if(!$DocumentType){
					Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มประเภทเอกสาร');
					$this->redirect(array('Document/index_type'));
					exit();
				}
				$model = new Document;
				if(isset($_POST['Document']))
				{
					$time = date("dmYHis");
					$model->attributes=$_POST['Document'];
					$model->dow_createday = date('Y-m-d H:i:s');
					$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
					$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
					$model->dty_id = $_POST['DocumentType']['dty_id'];
					$dow_address = CUploadedFile::getInstance($model, 'dow_address');

					if(isset($dow_address))
					{
						$fileNamePicture = $time."_Files.".$dow_address->getExtensionName();
						$model->dow_address = $fileNamePicture;
					}
					if($model->validate())
					{
						$uploadFile = CUploadedFile::getInstance($model, 'dow_address');
                    // if (isset($uploadFile)) 
                    // {
                    //     $uglyName = strtolower($uploadFile->name);
                    //     // $mediocreName = preg_replace('/[^a-zA-Z0-9]+/', '.', $uglyName);//(uglyName.นามสกุลไฟล)
                    //     $beautifulName = trim($uglyName);//uglyName = ชื่อไฟลที่อัพโหลด
                    //     $model->dow_address = $fileNamePicture;
                    // }
                $model->active = 1;//แอคทีบ
                if($model->save())
                {
                	if(isset($dow_address))
                	{ 
								/////////// SAVE IMAGE //////////
                		$tempSave = CUploadedFile::getInstance($model, 'dow_address');
								//$fileName = "{$tempSave}";
								//$model->dow_address = $model->dow_address;
                		$Pathuploadfile = Yii::app()->basePath.'/../uploads/'.$fileNamePicture;
								if(!empty($tempSave))  // check if uploaded file is set or not
								{  
									$tempSave->saveAs($Pathuploadfile); 
								}
							}
							if(Yii::app()->user->id){
								Helpers::lib()->getControllerActionId();
							}
						$langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
						if($model->parent_id == 0){
							$rootStationId = $model->dow_id;
						}else{
							$rootStationId = $model->parent_id;
						}
						
						foreach ($langs as $key => $lang) {
							# code...

							$station = Document::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootStationId));
							if(!$station){
								$stationRoot = Document::model()->findByPk($rootStationId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มเอกสาร '.$stationRoot->dow_name .',ภาษา '.$lang->language);
					          	// $this->redirect(array('Category/index'));
					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootStationId));
					          	exit();
							}
						}
							$this->redirect('index'); 

						}else{
							var_dump($model->getErrors());exit();
						}
					}
				}
				$this->render('create',array(
					'model'=>$model,
				));
			}
			public function actionDelete($id)
			{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id); // ดึงค่าจาก ฟังชั้น loadModel
	    // echo '<pre>';
	    // var_dump($model);
	    // exit();
        // if($model->dow_address != '')

	    $filename = Yii::app()->basePath.'/../uploads/'.$model->dow_address;
	    if (file_exists($filename)) {
	    	unlink($filename);
	    }
        	//Yii::app()->getDeleteImageYush('Document',$model->id,$model->dow_address);
        $model->active = 0;///คำสังลบ เซต active ไห้กลายเป็น 0 เพือ
        $parent_id = $model->dow_id;
        $modelChildren = Document::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => '1')
              ));
        	foreach ($modelChildren as $key => $value) {
        		$filename = Yii::app()->basePath.'/../uploads/'.$value->dow_address;
				    if (file_exists($filename)) {
				    	unlink($filename);
				    }
				 $value->active = 0;
				 $value->save();
        	}
        $model->save();
        if(Yii::app()->user->id){
	    	Helpers::lib()->getControllerActionId();
	    }
    }
    public function actionMultiDelete()
    {
		//header('Content-type: application/json');
    	if(isset($_POST['chk'])) {
    		foreach($_POST['chk'] as $val) {
    			$this->actionDelete($val);
    		}
    	}
    }
    public function actionDeletetype($id)
    {
		//$this->loadModel($id)->delete();
	    $model = $this->loadModelType($id); // ดึงค่าจาก ฟังชั้น loadModel
        $model->active = 0;///คำสังลบ เซต active ไห้กลายเป็น 0 เพือ

        $parent_id = $model->dty_id;
        $modelChildren = DocumentType::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => '1')
              ));
        	foreach ($modelChildren as $key => $value) {
        		$value->active = 0;
				$value->save();
        	}
        $model->save();
        if(Yii::app()->user->id){
        	Helpers::lib()->getControllerActionId();
        }
    }
    public function actionMultiDeletetype()
    {
		//header('Content-type: application/json');
    	if(isset($_POST['chk'])) {
    		foreach($_POST['chk'] as $val) {
    			$this->actionDeletetype($val);
    		}
    	}
    }
	public function loadModel($id)  // ทำการร return เพือไห้ฟังชั้นอืนดึงไปใช้งาน
	{
		$model=Document::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function loadModelType($id)  // ทำการร return เพือไห้ฟังชั้นอืนดึงไปใช้งาน
	{
		$model=DocumentType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionView_type($id)
	{
		$this->render('view_type',array(
    		'model'=>$this->loadModelType($id),
    	));
	}
}
