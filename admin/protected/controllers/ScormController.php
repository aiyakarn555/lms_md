<?php

class ScormController extends Controller
{

	public function actionCreate()
	{
		$model = new Sco;

		if(isset($_POST['Sco']))
		{
			$model->attributes=$_POST['Sco'];
			$zip = CUploadedFile::getInstance($model, 'filezip');
			if(!empty($zip)){
                $filnameZip = $zip->getName();
                $model->filezip = $filnameZip;
            }
			if($model->save()){
				if(!empty($zip)){
					Yush::init($model);
	                $zipPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->filezip);
	                $extractZipPath = Yush::getPath($model, Yush::SIZE_THUMB);
	                $zip->saveAs($zipPath);
	                $zipEx = new ZipArchive;
	                $res = $zipEx->open($zipPath);
	                if ($res === TRUE) {
					  $zipEx->extractTo($extractZipPath);
					  $zipEx->close();
					  $SCOdata = Helpers::lib()->readIMSManifestFile($extractZipPath.'/imsmanifest.xml');
					  $playpage = '';
					  foreach ($SCOdata as $identifier => $SCO) {
					  	$playpage = Helpers::lib()->cleanVar($SCO['href']);
					  }
					  $model->playpage = $playpage;
					  $model->save();
					  echo 'Success!';
					} else {
					  echo 'Fail!';
					}
            	}
			}
			$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
	
		if(isset($_POST['VRoom']))	
		{
			$model->attributes=$_POST['VRoom'];
			$model->save();
			$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model
		));
	}

	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();
	    $model = $this->loadModel($id);
	    $model->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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

	public function actionIndex()
	{
		
		$model=new Sco('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Sco']))
			$model->attributes=$_GET['Sco'];

		$this->render('index',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=Sco::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = CourseOnline::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = CourseOnline::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

	public function actionCheckExists()
    {
        $webroot = Yii::app()->getUploadPath('scorm');
        $targetFolder = $webroot; // Relative to the root and should match the upload folder in the uploader script

        if (file_exists($targetFolder . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionUploadifive()
    {
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath('scorm');
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('zip'); // Allowed file extensions

        if (!empty($_FILES)) {

            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = $uploadedFile->getName();

            $targetFile = $uploadDir . $fileName;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                $roomDoc = new VRoomDoc();
                $roomDoc->room_id = $_POST['room_id'];
                $roomDoc->name = $fileName;
                $roomDoc->save();
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

}
