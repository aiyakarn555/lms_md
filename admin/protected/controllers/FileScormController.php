<?php

class FileScormController extends Controller
{
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
        	array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view','Update','Sequence'),
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

    public function actionCreate()
    {
    	require_once(__DIR__.'/../vendors/scorm/classes/pclzip.lib.php');
        require_once(__DIR__.'/../vendors/scorm/filemanager.inc.php');

    	$model=new FileScorm;

    	if (isset($_GET["id"])) {
    		$id = $_GET["id"];
    		$model->lesson_id = $id;
    	}

    	if (isset($_GET["lang_id"])) {
    		$lang_id = $_GET["lang_id"];
    	}else{
    		$lang_id = 1;
    	}

    	if (isset($_GET["parent_id"])) {
    		$parent_id = $_GET["parent_id"];
    	}else{
    		$parent_id = 0;
    	}

    	$file_parent = FileScorm::model()->findByPK($parent_id);
    	if ($file_parent) {
    		$id = $file_parent->lesson_id;
    		$model->lesson_id = $id;
    	}

    	if(isset($_POST['FileScorm']))
    	{

    		$scorm_file = CUploadedFile::getInstance($model, 'file_scorm');

    		if (empty($scorm_file)) {
    			$error['scorm_file'] = "Required";
    			$this->render('create',array(
    				'model'=>$model,
    				'error'=>$error,
    			));
    			exit();
    		}
    		$fileTypes = array('zip');
    		if (!in_array(strtolower($scorm_file->getExtensionName()), $fileTypes)) {
    			$error['scorm_file'] = "Invalid";
    			$this->render('create',array(
    				'model'=>$model,
    				'error'=>$error,
    			));
    			exit();
    		}

    		$model->attributes=$_POST['FileScorm'];
    		$model->file_name="multiscreen.html";
    		$model->lang_id = $lang_id;
    		$model->parent_id = $parent_id;

    		$rnd = rand(0,9999999999);
    		$fileName = "{$rnd}-".date('YmdHms').".".strtolower($scorm_file->getExtensionName());

    		if ($model->save(false)) {
    			$webroot = Yii::app()->basePath."/../../uploads/scorm/";
    			$targetFile = $webroot . $fileName;
    			$tempFile  = $scorm_file->tempName;

    			if (move_uploaded_file($tempFile, $targetFile)) {
    				$dirScorm = Yii::app()->basePath."/../../uploads/scorm/".$model->id."/";
    				$ScormFolder = Yii::app()->file->set($dirScorm);
    				$ScormFolder->Delete();
    				if(!$ScormFolder->CreateDir()){
    					echo "Can not create directory";
    					exit;
    				}
    				chmod($dirScorm, 0777);
    				if(file_exists($targetFile)){
    					$scormName = $dirScorm.$fileName;
    					$archive = new PclZip($targetFile);
    					if ($archive->extract(  PCLZIP_OPT_PATH,    $dirScorm,
    						PCLZIP_CB_PRE_EXTRACT,  'preImportCallBack') == 0) {
    						echo 'Cannot extract to $import_path';
    						clr_dir($dirScorm);
    						exit;
    					}
    				}
    				$this->redirect(array('index','id'=>$model->lesson_id));
    				exit();
    			}

    			

    		}


    	}

    	$this->render('create',array(
    		'model'=>$model,
    	));
    }

	public function actionUpdate($id)
	{
		require_once(__DIR__.'/../vendors/scorm/classes/pclzip.lib.php');
        require_once(__DIR__.'/../vendors/scorm/filemanager.inc.php');
        
		$model=$this->loadModel($id);
		if(isset($_POST['FileScorm']))
		{
			$scorm_file = CUploadedFile::getInstance($model, 'file_scorm');

			$model->attributes=$_POST['FileScorm'];
			$model->file_name="multiscreen.html";

			$rnd = rand(0,9999999999);
			if (!empty($scorm_file)) {
				$fileName = "{$rnd}-".date('YmdHms').".".strtolower($scorm_file->getExtensionName());
				$fileTypes = array('zip');
				if (!in_array(strtolower($scorm_file->getExtensionName()), $fileTypes)) {
					$error['scorm_file'] = "Invalid";
					$this->render('update',array(
						'model'=>$model,
						'error'=>$error,
					));
					exit();
				}

			}

			if ($model->save(false)) {
				if (!empty($scorm_file)) {
					$webroot = Yii::app()->basePath."/../../uploads/scorm/";
					$targetFile = $webroot . $fileName;
					$tempFile  = $scorm_file->tempName;

					if (move_uploaded_file($tempFile, $targetFile)) {
						$dirScorm = Yii::app()->basePath."/../../uploads/scorm/".$model->id."/";
						$ScormFolder = Yii::app()->file->set($dirScorm);
						$ScormFolder->Delete();
						if(!$ScormFolder->CreateDir()){
							echo "Can not create directory";
							exit;
						}
						chmod($dirScorm, 0777);
						if(file_exists($targetFile)){
							$scormName = $dirScorm.$fileName;
							$archive = new PclZip($targetFile);
							if ($archive->extract(  PCLZIP_OPT_PATH,    $dirScorm,
								PCLZIP_CB_PRE_EXTRACT,  'preImportCallBack') == 0) {
								echo 'Cannot extract to $import_path';
								clr_dir($dirScorm);
								exit;
							}
						}

					}
				}
				$this->redirect(array('index','id'=>$model->lesson_id));
				exit();
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionIndex($id)
	{
		$model=new FileScorm('search');
		$model->unsetAttributes();  // clear any default values
		$model->active = 'y';
		if(isset($_GET['FileScorm']))
			$model->attributes=$_GET['FileScorm'];

		$this->render('index',array(
			'model'=>$model,
			'id'=>$id,
		));
	}

	public function actionDelete($id){
		$model = $this->loadModel($id);
		// $model->active = 'n';
		$model->delete();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function loadModel($id)
	{
		$model=FileScorm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence()
	{
	    if(isset($_POST['items']) && is_array($_POST['items'])) 
	    {
	    	$SortArray = array();
			foreach ($_POST['items'] as $key => $value) 
			{
				$checkSort = FileScorm::model()->findByPk($value);
				$SortArray[] = $checkSort->file_position;
			}

			usort($SortArray, function ($a, $b){ return substr($b, -2) - substr($a, -2); });

	        $i = 0;
	        foreach ($_POST['items'] as $item) 
	        {
				FileScorm::model()->updateByPk($_POST['items'][$i], array(
					'file_position'=>$SortArray[$i],
				));
	            $i++;
	        }
	    }
	}
}