<?php

class LessonController extends Controller
{
    public function filters()
    {
        return array(
            'rights',
        );
    }

    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionDeleteVdo($id)
    {
        $model = File::model()->findByPk($id);

        if($model->count()>0){

            if(is_file(Yii::app()->getUploadPath(null).$model->filename)){
                unlink(Yii::app()->getUploadPath(null).$model->filename);
            }

            if($model->delete($id)){
                echo 1;
            }else{
                echo 0;
            }
        }
    }

    public function actionCreate()
    {
        $lesson=new Lesson;
        $file=new File;
        $session = Yii::app()->session;

        if(isset($_POST['Lesson']))
        {
            $time = date("dmYHis");
            $lesson->attributes=$_POST['Lesson'];
            $valid = $lesson->validate();

            $image = CUploadedFile::getInstance($lesson, 'image');
            if(!empty($image)){
                $fileNamePicture = $time."_Picture.".$image->getExtensionName();
                $lesson->image = $fileNamePicture;
            }

            if($valid)
            {
                if($lesson->save(false))
                {
                    if(isset($image))
                    {
                        /////////// SAVE IMAGE //////////
                        Yush::init($lesson);
                        $originalPath = Yush::getPath($lesson, Yush::SIZE_ORIGINAL, $lesson->image);
                        $thumbPath = Yush::getPath($lesson, Yush::SIZE_THUMB, $lesson->image);
                        $smallPath = Yush::getPath($lesson, Yush::SIZE_SMALL, $lesson->image);
                        // Save the original resource to disk
                        $image->saveAs($originalPath);

                        // Create a small image
                        $smallImage = Yii::app()->phpThumb->create($originalPath);
                        $smallImage->resize(110);
                        $smallImage->save($smallPath);

                        // Create a thumbnail
                        $thumbImage = Yii::app()->phpThumb->create($originalPath);
                        $thumbImage->resize(175);
                        $thumbImage->save($thumbPath);
                    }

                    if(isset($session['filenameCom']) || count($session['filenameCom'])!=0)
                    {
                        foreach ($session['filenameCom'] as $filenameComKey => $filenameComValue)
                        {
                            $filenameCheck = explode('.', $filenameComValue);
                            if($filenameCheck[1] == 'mp3' or $filenameCheck[1] == 'mp4')
                            {
                                $file = new File;
                                $file->lesson_id = $lesson->id;
                                $file->filename = $filenameComValue;
                                $file->length = "2.00";
                                $file->save(false);
                            }
                        }
                    }
                }
                unset($session['pathCom']);
                unset($session['filenameCom']);
                unset($session['idx']);

                $this->redirect(array('view','id'=>$lesson->id));
            }
        }
        unset($session['pathCom']);
        unset($session['filenameCom']);
        unset($session['idx']);

        $this->render('create',array(
            'lesson'=>$lesson,'file'=>$file
        ));
    }

    public function actionFormLesson($id,$type)
    {
        $model = $this->loadModel($id);
        $Manage = new Manage;
        //Query Manage
        $dataManage = new CActiveDataProvider('Manage',array('criteria'=>array('condition'=>' id = "'.$id.'" AND type = "'.$type.'" ')));
        $ManageModel=new Manage('search');
        $ManageModel->unsetAttributes();  // clear any default values
        $ManageModel->type = $_GET['type'];
        if(isset($_GET['Manage']))
            $ManageModel->attributes = $_GET['Manage'];

        if(isset($_POST['Manage']))
        {
            $Manage->attributes = $_POST['Manage'];
            $Manage->type = $_GET['type'];
            $Manage->id = $id;
            if($Manage->save())
                $this->redirect(array('formLesson','id'=>$id,'type'=>$type));
        }

        if(isset($_POST['Lesson']))
        {
            $model->attributes = $_POST['Lesson'];
            if($model->save())
                $this->redirect(array('formLesson','id'=>$id,'type'=>$type));
        }

        Yii::app()->user->setState('getLesson', $id);

        $this->render('formlesson',array(
            'model'=>$model,
            'ManageModel'=>$ManageModel,
            'Manage'=>$Manage,
            'dataManage'=>$dataManage,
            'pk'=>$id
        ));
    }

    public function actionUpdateLesson($id)
    {
        $Manage = $this->loadManageModel($id);
        if(isset($_POST['Manage']))
        {
            $Manage->attributes = $_POST['Manage'];
            if($Manage->save())
                $this->redirect(array('formLesson','id'=>Yii::app()->user->getState('getLesson')));
        }
        $this->render('updatelesson',array(
            'Manage'=>$Manage,
        ));
    }

    public function actionUpdate($id)
    {
        $lesson = $this->loadModel($id);
        $imageShow = $lesson->image;
        $file = $this->loadFileModel($id);
        $session = Yii::app()->session;

        if(isset($_POST['Lesson']))
        {
            $time = date("dmYHis");
            $lesson->attributes=$_POST['Lesson'];
            $valid = $lesson->validate();

            $imageOld = $lesson->image; // Image Old

            $image = CUploadedFile::getInstance($lesson, 'image');
            if(!empty($image)){
                $fileNamePicture = $time."_Picture.".$image->getExtensionName();
                $lesson->image = $fileNamePicture;
            }

            if($valid)
            {
                if($lesson->save(false))
                {
                    if(isset($imageShow) && isset($image))
                    {
                        Yii::app()->getDeleteImageYush('lesson',$lesson->id,$imageShow);
                    }

                    if(isset($image))
                    {
                        /////////// SAVE IMAGE //////////
                        Yush::init($lesson);
                        $originalPath = Yush::getPath($lesson, Yush::SIZE_ORIGINAL, $lesson->image);
                        $thumbPath = Yush::getPath($lesson, Yush::SIZE_THUMB, $lesson->image);
                        $smallPath = Yush::getPath($lesson, Yush::SIZE_SMALL, $lesson->image);
                        // Save the original resource to disk
                        $image->saveAs($originalPath);

                        // Create a small image
                        $smallImage = Yii::app()->phpThumb->create($originalPath);
                        $smallImage->resize(110);
                        $smallImage->save($smallPath);

                        // Create a thumbnail
                        $thumbImage = Yii::app()->phpThumb->create($originalPath);
                        $thumbImage->resize(175);
                        $thumbImage->save($thumbPath);
                    }

                    if (isset($session['filenameCom']) || count($session['filenameCom'])!=0)
                    {
                        foreach ($session['filenameCom'] as $filenameComKey => $filenameComValue) {
                            $filenameCheck = explode('.', $filenameComValue);
                            if($filenameCheck[1] == 'mp3' or $filenameCheck[1] == 'mp4')
                            {
                                $file = new File;
                                $file->lesson_id = $lesson->id;
                                $file->filename = $filenameComValue;
                                $file->length = "2.00";
                                $file->save(false);
                            }
                        }
                    }
                }

                unset($session['pathCom']);
                unset($session['filenameCom']);
                unset($session['idx']);

                $this->redirect(array('view','id'=>$lesson->id));
            }
        }

        unset($session['pathCom']);
        unset($session['filenameCom']);
        unset($session['idx']);

        $this->render('update',array(
            'lesson'=>$lesson,'file'=>$file,'imageShow'=>$imageShow
        ));
    }

    public function actionDelete($id)
    {
        //$this->loadModel($id)->delete();
        $model = $this->loadModel($id);
        $file = $this->loadFileModel($id);
        if(isset($file->files))
        {
            foreach($file->files as $fileData)
            {
                if(is_file(Yii::app()->getUploadPath(null).$fileData->filename))
                {
                    unlink(Yii::app()->getUploadPath(null).$fileData->filename);
                    File::model()->findByPk($fileData->id)->delete();
                }
            }
        }
        $model->active = 'n';

        if($model->image != '')
            Yii::app()->getDeleteImageYush('Lesson',$model->id,$model->image);

        $model->image = null;
        $model->save();

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

    public function actionCheckExists()
    {
        $webroot = Yii::app()->getUploadPath(null);
        $targetFolder = $webroot; // Relative to the root and should match the upload folder in the uploader script

        if (file_exists($targetFolder . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionUploadifive()
    {
        $session = Yii::app()->session;
        if(!isset($session['idx'])){
            $session['idx'] = 1;
        }
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath(null);
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('mp4','mp3'); // Allowed file extensions

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

                // Save the file

                if (!isset($session['filenameCom']) || count($session['filenameCom'])==0)
                {
                    $session['filenameCom'] = array($fileName);
                }else{
                    $filenameComArr = $session['filenameCom'];
                    $filenameComArr[] = $fileName;
                    $session['filenameCom'] = $filenameComArr;
                }

                if (!isset($session['pathCom']) || count($session['pathCom'])==0)
                {
                    $session['pathCom'] = array($uploadDir);
                }else{
                    $pathComArr = $session['pathCom'];
                    $pathComArr[] = $uploadDir;
                    $session['pathCom'] = $pathComArr;
                }

                move_uploaded_file($tempFile, $targetFile);
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

    public function actionIndex()
    {
        $model=new Lesson('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Lesson']))
            $model->attributes=$_GET['Lesson'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=Lesson::model()->lessoncheck()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadManageModel($id)
    {
        $model=Manage::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadFileModel($id)
    {
        $model=Lesson::model()->with('files')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
