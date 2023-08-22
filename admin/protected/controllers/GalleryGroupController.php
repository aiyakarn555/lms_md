<?php

class GalleryGroupController extends Controller
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
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
           // array('allow',  // allow all users to perform 'index' and 'view' actions
           // 	'actions' => array('index', 'view','update','delete' ,'create'),
           // 	'users' => array('*'),
           // ),
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

	public function actionCreate()
	{

		$gallery = new Gallery;
		$model = new GalleryGroup;
		$session = Yii::app()->session;
//var_dump($_POST['Gallery']);exit();
		if(isset($_POST['GalleryGroup'])){
               // var_dump($_POST['Gallery']);
               // var_dump($_POST['GalleryGroup']);
               // exit();
           		 $type_id = $_POST['GalleryGroup'][gallery_type_id];

				// if(isset($_FILES['files']['tmp_name'])){

				// foreach ($_FILES['files']['tmp_name'] as $key => $value) {
				//    if($_FILES['files']['tmp_name'][$key] != ""){
				//     $uploadDir = Yii::app()->getUploadPath(null);

				//     if (!is_dir($uploadDir."../gallery/")) {
				//      mkdir($uploadDir."../gallery/", 0777, true);
				//     }
				//     if (!is_dir($uploadDir."../gallery/"."images")) {
				//      mkdir($uploadDir."../gallery/"."images", 0777, true);
				//     }else{     
				//      rmdir($uploadDir."../gallery/"."images");
				//     }

				// 	 $uploadDir = $uploadDir."..\\gallery\\"."images"."\\";

				//      $tempFile   = $_FILES['files']['tmp_name'][$key];
				//      $fileParts = pathinfo($_FILES['files']['name'][$key]);
				//      $fileType = strtolower($fileParts['extension']);

 			// 		 $file_name_original = $_FILES['files']['name'][$key];
				//      $namepath = "gallery_".$type_id."_";
				//      $rnd = rand(0,9999999999);
				//      $fileName = $namepath."{$rnd}-{$session['idx']}".$file_name_original;
	
				//      $targetFile = $uploadDir.$fileName;
				//      move_uploaded_file($tempFile, $targetFile);

				// 	  $ProAttachFile = new Gallery;
				// 	  $ProAttachFile->image = $fileName;
				//       $ProAttachFile->gallery_type_id = $type_id;
				//       $ProAttachFile->save();
 
		if(isset($session['filenameComgallery']) || count($session['filenameComgallery'])!=0)
        {
        $model->gallery_type_id = $type_id;
        // $model->create_date = date("Y-m-d H:i:s");
        // $model->create_by = Yii::app()->user->id;
        $model->save();
        foreach ($session['filenameComgallery'] as $filenameComKey => $filenameComValue)
        {
            $filenameCheck = explode('.', $filenameComValue);
            $Gallery = new Gallery;
            $Gallery->image = $filenameComValue;
            $Gallery->gallery_type_id = $type_id;
            $Gallery->group_gallery_id = $model->id;
            $Gallery->save(false);
                            // }
        }

       $this->redirect('index',array('model'=>$model));
    }else{
    	 $this->redirect('create',array(
			'model'=>$model,'gallery'=>$gallery
		));
    }
    //$this->redirect('index',array('model'=>$model));

				//   } // close if
				// } // close foreach
				// $this->redirect('index');
		  //   } //close (isset($_FILES['files']['tmp_name']))
		}// close isset($_POST['Gallery'])
		unset($session['idx']);
        unset($session['pathComgallery']);
        unset($session['filenameComgallery']);
        unset($session['filenameOriComgallery']);

		$this->render('create',array(
			'model'=>$model,'gallery'=>$gallery
		));
	} // close function

	public function actionUploadifiveImages()
	{
		$session = Yii::app()->session;
        if(!isset($session['idx'])){
            $session['idx'] = 1;
        }
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath('gallery');
        $uploadDir = $webroot;
        // Set the allowed file extensions
        $fileTypes = array('jpg','jpeg','png'); // Allowed file extensions  //

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand(0,9999999999);
            $tempFile   = $_FILES['Filedata']['tmp_name'];   
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = "{$rnd}-{$session['idx']}.".strtolower($uploadedFile->getExtensionName());
            $session['idx'] += 1;
            //$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $fileName;
            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the filevar_dump($targetFile); exit();

// var_dump($_POST); exit();



              if (!isset($session['filenameComgallery']) || count($session['filenameComgallery'])==0)
              {
                $session['filenameComgallery'] = array($fileName);
            }else{
                $filenameComArr = $session['filenameComgallery'];
                $filenameComArr[] = $fileName;
                $session['filenameComgallery'] = $filenameComArr;
            }

            // $filenameCheck = explode('.', $filenameComValue);
            $Gallery = new Gallery;
            $Gallery->image = $fileName;
            $Gallery->group_gallery_id = $_POST['updateid'];
            // $Gallery->group_gallery_id = $model->id;
            $Gallery->save(false);


            if (!isset($session['filenameOriComgallery']) || count($session['filenameOriComgallery'])==0)
            {
                $session['filenameOriComgallery'] = array(str_replace(".".$fileParts,"",$_FILES['Filedata']['name']));
            }else{
                $filenameOriComArr = $session['filenameOriComgallery'];
                $filenameOriComArr[] = str_replace(".".$fileParts,"",$_FILES['Filedata']['name']);
                $session['filenameOriComgallery'] = $filenameOriComArr;
            }

            if (!isset($session['pathComgallery']) || count($session['pathComgallery'])==0)
            {
                $session['pathComgallery'] = array($uploadDir);
            }else{
                $pathComArr = $session['pathComgallery'];
                $pathComArr[] = $uploadDir;
                $session['pathComgallery'] = $pathComArr;
            }
            move_uploaded_file($tempFile, $targetFile);
            echo 1;

        } else {

                // The file type wasn't allowed
            echo 'Invalid file types.';

        }

    }
	}

	public function actionUpdate($id)
	{
		 $model = $this->loadModel($id);
		 $gallery = new Gallery;
		 $session = Yii::app()->session;
		if(isset($_POST['GalleryGroup'])){
                //var_dump($_POST['GalleryGroup']);
               // var_dump($_POST['GalleryGroup']);
               // exit();
           		 $type_id = $_POST['GalleryGroup'][gallery_type_id];
           		 if(isset($session['filenameComgallery']) || count($session['filenameComgallery'])!=0)
        {
        $model->gallery_type_id = $type_id;
        $model->save();


        $gallery_all = Gallery::model()->findAll('active="y" AND group_gallery_id="'.$id.'"  ');
        foreach ($gallery_all as $key => $value) {
            $value->gallery_type_id = $model->gallery_type_id;
            $value->save(false);
        }
        // foreach ($session['filenameComgallery'] as $filenameComKey => $filenameComValue)
        // {
        //     $filenameCheck = explode('.', $filenameComValue);
        //     $Gallery = new Gallery;
        //     $Gallery->image = $filenameComValue;
        //     $Gallery->gallery_type_id = $type_id;
        //     $Gallery->group_gallery_id = $model->id;
        //     $Gallery->save(false);
        //                     // }
        // }
        // exit();
       $this->redirect('../index',array('model'=>$model));
    }else{
    	 $this->redirect('create',array(
			'model'=>$model,'gallery'=>$gallery
		));
    }
        }
        unset($session['idx']);
        unset($session['pathComgallery']);
        unset($session['filenameComgallery']);
        unset($session['filenameOriComgallery']);
		$this->render('update',array(
			'model'=>$model,'gallery'=>$gallery,
		));
			//'imageShow'=>$imageShow
	}// close function
public function loadGalleryModel($id)
    {
        $model=Gallery::model()->with('gallerygroup')->findByPk($id);        
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
public function actionDeleteFile($id)
{
    $Gallery = Gallery::model()->findByPk($id);
    if($Gallery->count()>0){

        $webroot = Yii::app()->basePath."/../uploads/gallery/";

        if(is_file($webroot.$Gallery->image)){
            unlink($webroot.$Gallery->image);
        }

        if($Gallery->delete($id)){
            echo 1;
        }else{
            echo 0;
        }
    }
}
	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		if ($model->save()) {
	            $criteria = new CDbCriteria;
                $criteria->addCondition('group_gallery_id ="'.$id.'"');
                $Gallery = Gallery::model()->findAll($criteria);
                foreach ($Gallery as $key => $value) {
                    

                     $webroot = Yii::app()->basePath."/../uploads/gallery/";

                     if(is_file($webroot.$value->image)){
                        unlink($webroot.$value->image);
                    }
                    $value->delete($id);
        
                }
		}
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
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

		// var_dum(Yii::app()->basePath . '../';);exit();

		$model=new GalleryGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GalleryGroup']))
			$model->attributes=$_GET['GalleryGroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=GalleryGroup::model()->gallerygroupcheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
