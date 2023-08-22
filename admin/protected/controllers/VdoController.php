<?php

class VdoController extends Controller
{
	// public function init()
	// {
	// 	parent::init();
	// 	$this->lastactivity();

	// }
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

    public function actionView($id)
    {
    	$this->render('view',array(
    		'model'=>$this->loadModel($id),
    	));
    }

    public function actionActive($id)
    {
    	// $array_id = array($id);
    	// $criteria = new CDbCriteria;
    	// $criteria->addNotIncondition('parent_id',$array_id);
    	// $model_all = Vdo::model()->findAll($criteria);

    	// foreach ($model_all as $key => $value) {
    	// 	$value->recommended_status = 0;
    	// 	$value->save();
    	// }

    	$vdoRoot = Vdo::model()->findByPk($id);
    	if ($vdoRoot->recommended_status == 0) {
    		$vdoRoot->recommended_status = 1;
    	}else{
    		$vdoRoot->recommended_status = 0;
    	}
    	$vdoRoot->save();

		if(count($vdoRoot) > 0){
			$criteria = new CDbCriteria;
			$criteria->compare('parent_id',$vdoRoot->vdo_id);
			$criteria->compare('active','y');
			$vdo_parent = Vdo::model()->findAll($criteria);
			if(count($vdo_parent) > 0){
				foreach ($vdo_parent as $keyp => $val_parent) {
					if($val_parent->recommended_status == 0){
						$val_parent->recommended_status = 1;
					}else{
						$val_parent->recommended_status = 0;
					}
					$val_parent->save();
				}
			}
		}
    	$this->redirect(array('/vdo/index'));
    }


    public function actionCreate()
    {
    	$model= new Vdo;
    	if(isset($_POST['Vdo']))
    	{
    		$model->attributes=$_POST['Vdo'];
    		$model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
			$model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
    		$time = date("dmYHis");
    		$model->scenario = $model->vdo_type;
    		if($model->vdo_type == 'file'){
    			$vdo_path = CUploadedFile::getInstance($model, 'vdo_path');
    			$uploadFile = CUploadedFile::getInstance($model, 'vdo_path');

    			// $vdo_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');
    			// $uploadFile_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');

    			if (isset($uploadFile)) {
                    // $uglyName = strtolower($uploadFile->name);
                    // $mediocreName = preg_replace('/[^a-zA-Z0-9ก-๙เ]+/', '_', $uglyName);
                    // $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
    				$beautifulName = $time."_Vdo.".$uploadFile->extensionName;
    				$model->vdo_path = $beautifulName;
    			}

    			// if (isset($uploadFile_thumbnail)) {

    			// 	$beautifulName_thumbnail = $time."_Vdo.".$uploadFile_thumbnail->extensionName;
    			// 	$model->vdo_thumbnail = $beautifulName_thumbnail;

    			// }

    		} else {
    			$model->vdo_path = $model->link_vdo;
    		}

    		if ($_FILES['picture']['tmp_name'] != "") {
				$model->vdo_thumbnail = $_FILES['picture']['name'];
			}

			//$model->attributes=$_POST['Vdo'];
    		$time = date("dmYHis");

                    // $vdo_path = $beautifulName;
    		if($model->validate())
    		{
                $model->active = y;//แอคทีบ
               

                if($model->save())
                {
					if($model->parent_id == 0){
						$model->sortOrder = Helpers::lib()->sortCreate('tbl_vdo','vdo_id',$model->vdo_id,'main'); 
					}else{
						$model->sortOrder = Helpers::lib()->sortCreate('tbl_vdo','vdo_id',$model->vdo_id,'parent',$model->parent_id);
					}
                    $model->save();
                    
                	if(isset($vdo_path))
                	{
                		$tempSave = CUploadedFile::getInstance($model, 'vdo_path');
                		$fileName = $beautifulName;
                		$model->vdo_path = $fileName;
                		$Pathuploadfile = Yii::app()->basePath.'/../../uploads/'.$fileName;

					if(!empty($tempSave))  // check if uploaded file is set or not
					{
						$tempSave->saveAs($Pathuploadfile);
					} else {
						var_Dump($model->getErrors());
						exit();
					}
				}

				if ($_FILES['picture']['tmp_name'] != "") {
					$tempFile   = $_FILES['picture'];
					$path = "vdo_img";
					$model_id = $model->vdo_id;
					$base64_pic = $_POST["url_pro_pic"];
					$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
					if ($filename) {
						$model = $this->loadModel($model->vdo_id);
						$model->vdo_thumbnail = $filename;
						$model->save();
					}
				}

				// if(isset($vdo_thumbnail))
				// {
				// 	$tempSave_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');
				// 	$fileName_thumbnail = $beautifulName_thumbnail;
				// 	$model->vdo_thumbnail = $fileName_thumbnail;
				// 	$Pathuploadfile_thumbnail = Yii::app()->basePath.'/../uploads/'.$fileName_thumbnail;

				// 		if(!empty($tempSave_thumbnail))  // check if uploaded file is set or not
				// 		{
				// 			$tempSave_thumbnail->saveAs($Pathuploadfile_thumbnail);
				// 		} else {
				// 			var_Dump($model->getErrors());
				// 			exit();
				// 		}
				// 	}

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					$langs = Language::model()->findAll(array('condition'=>'active = "y"  and id != 1'));
					if($model->parent_id == 0){
						$rootId = $model->vdo_id;
					}else{
						$rootId = $model->parent_id;
					}
					foreach ($langs as $key => $lang) {

							$station = Vdo::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
							if(!$station){
								$vdoRoot = Vdo::model()->findByPk($rootId);
								Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มวีดีโอ '.$vdoRoot->vdo_title .',ภาษา '.$lang->language);

					          	// $this->redirect(array('Category/index'));

					          	$this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
					          	exit();
							}

					  }

                      $this->redirect('index',array('model'=>$model));
					//$this->redirect(array('view','id'=>$model->vdo_id));
				} 
				$this->redirect('index',array('model'=>$model));
			}
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		
		$old_vdo_path = $model->vdo_path;
		$imageShow = $model->vdo_thumbnail;

		if($model->vdo_type == 'link'){
			$model->link_vdo = $model->vdo_path;
		}

		if(isset($_POST['Vdo']))
		{
			$model->attributes=$_POST['Vdo'];
			$time = date("dmYHis");

			if($model->vdo_type == 'file'){
				$vdo_path = CUploadedFile::getInstance($model, 'vdo_path');
				$uploadFile = CUploadedFile::getInstance($model, 'vdo_path');

				// $vdo_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');
				// $uploadFile_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');

				if (isset($uploadFile)) {
                    // $uglyName = strtolower($uploadFile->name);
                    // $mediocreName = preg_replace('/[^a-zA-Z0-9ก-๙เ]+/', '_', $uglyName);
					$beautifulName = $time."_Vdo.".$uploadFile->extensionName;
                    // $beautifulName = trim($mediocreName, '_') . "." . $uploadFile->extensionName;
					$model->vdo_path = $beautifulName;
				}
				// if (isset($uploadFile_thumbnail)) {

				// 	$beautifulName_thumbnail = $time."_Vdo.".$uploadFile_thumbnail->extensionName;
				// 	$model->vdo_thumbnail = $beautifulName_thumbnail;
				// }
			} else {
				$model->vdo_path = $model->link_vdo;
			}

			if ($_FILES['picture']['tmp_name'] != "") {
				$model->vdo_thumbnail = $_FILES['picture']['name'];
			}
                    // $vdo_path = $beautifulName;
			if($model->validate())
			{

				// if( !isset($_POST['Vdo'][vdo_thumbnail]) ){

				// 	$model->vdo_thumbnail = $old_vdo_thumbnail;
				// 		 // var_dump($model->vdo_thumbnail);exit();
				// }
				if( !isset($_POST['Vdo'][vdo_path]) ){

					$model->vdo_path = $old_vdo_path;
						 // var_dump($model->vdo_path);exit();
				}

                $model->active = y;//แอคทีบ
                if($model->save())
                {

                	if(isset($vdo_path))
                	{
                		$tempSave = CUploadedFile::getInstance($model, 'vdo_path');
                		$fileName = $beautifulName;
                		$model->vdo_path = $fileName;
                		$Pathuploadfile = Yii::app()->basePath.'/../uploads/'.$fileName;

						if(!empty($tempSave))  // check if uploaded file is set or not
						{
							$tempSave->saveAs($Pathuploadfile);
						} else {
							echo "not save vdo";
							exit();
						}
					}

					if ($_FILES['picture']['tmp_name'] != "") {
						$tempFile   = $_FILES['picture'];
						$path = "vdo_img";
						$model_id = $model->vdo_id;
						$base64_pic = $_POST["url_pro_pic"];
						$filename = Helpers::lib()->uploadimagecroppie($tempFile,$path,$model_id,$base64_pic);
						if ($filename) {
							$model = $this->loadModel($model->vdo_id);
							$model->vdo_thumbnail = $filename;
							$model->save();
						}
					}

					// if(isset($vdo_thumbnail))
					// {
					// 	$tempSave_thumbnail = CUploadedFile::getInstance($model, 'vdo_thumbnail');
					// 	$fileName_thumbnail = $beautifulName_thumbnail;
					// 	$model->vdo_thumbnail = $fileName_thumbnail;
					// 	$Pathuploadfile_thumbnail = Yii::app()->basePath.'/../uploads/'.$fileName_thumbnail;

					// 	if(!empty($tempSave_thumbnail))  // check if uploaded file is set or not
					// 	{
					// 		$tempSave_thumbnail->saveAs($Pathuploadfile_thumbnail);
					// 	} else {
					// 		echo "not save picture";
					// 		exit();
					// 	}
					// }

					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
                    $this->redirect('../index',array('model'=>$model));
					//$this->redirect(array('view','id'=>$model->vdo_id));
				} 
				$this->redirect('../index',array('model'=>$model));
			} 
		}
		$this->render('update',array(
			'model'=>$model,
			'imageShow'=>$imageShow,
		));
	}


	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$parent_id = $model->vdo_id;
        $modelChildren = Vdo::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
              ));
        	foreach ($modelChildren as $key => $value) {
				 $value->active = 'n';
				 $value->save();
        	}
		$model->save();

		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{
		// header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionIndex()
	{
		$model=new Vdo('search');
		$model->unsetAttributes();
		if(isset($_GET['Vdo']))
			$model->attributes=$_GET['Vdo'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Vdo::model()->vdocheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vdo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	  public function actionSequence() {

    if (isset($_POST['items']) && is_array($_POST['items'])) {
       
            // Get all current target items to retrieve available sortOrders
        $cur_items = Vdo::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
        
            // Check 1 by 1 and update if neccessary

        foreach ($cur_items as $keys => $values) {

            for ($i = 0; $i < count($_POST['items']); $i++) {
                $item = Vdo::model()->findByPk($_POST['items'][$i]);

                if ($item->sortOrder != $cur_items[$i]->sortOrder) {
                    $item->sortOrder = $cur_items[$i]->sortOrder ;
                    $item->save(false);
                } 

                $modellang2 = Vdo::model()->findByAttributes(array('parent_id'=>$_POST['items'][$i])); 
                  //var_dump($modellang2->sortOrder);exit();
                
                if ($modellang2->sortOrder != $cur_items[$i]->sortOrder) {
                    if ($modellang2->parent_id == '') {
                        $items = Vdo::model()->findByPk($_POST['items'][$i]);
                        $items->sortOrder = $cur_items[$i]->sortOrder ;
                        $items->save(false);
                        
                    }
                    if ($modellang2->parent_id != null) {
                        $modellang2->sortOrder = $cur_items[$i]->sortOrder ;
                        $modellang2->save(false);   
                    }
                    
                } 
            }
        }        
    }
}
}
