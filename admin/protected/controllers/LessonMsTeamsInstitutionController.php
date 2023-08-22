<?php

class LessonMsTeamsInstitutionController extends Controller
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
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view','update','delete','create','uploadifivedoc','DeleteFileDoc','EditName'
                    ,'FormLessonms','ActivePre','ActivePost' //เพิมชั่วคราว
                ),
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
 
    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }


public function actionCreate()
{
    $fileDoc = new FileDocMsTeams;
    $session = Yii::app()->session;

    $lesson = new LessonMsTeamsInstitution;

    if(isset($_POST['LessonMsTeamsInstitution']))
    {
        $time = date("dmYHis");
        $lesson->attributes=$_POST['LessonMsTeamsInstitution'];

        // $lesson->ms_teams_id = $_POST['ms_teams_id'];
        $lesson->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        $lesson->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
        $count_les = LessonMsTeamsInstitution::Model()->count("ms_teams_id=:ms_teams_id AND active=:active", array(
            "ms_teams_id"=>$lesson->ms_teams_id, "active"=>"y"
        ));
        $lesson->lesson_no = $count_les+1;
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
                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId();
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

                    if(isset($session['filenameComDoc']) || count($session['filenameComDoc'])!=0)
                {
                    foreach ($session['filenameComDoc'] as $filenameComKey => $filenameComValue)
                    {
                        $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx')
                            // {
                        $file = new FileDocMsTeams;
                        $file->lesson_teams_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $session['filenameOriComDoc'][$filenameComKey];
                        $file->length = "2.00";
                        $file->save(false);
                            // }
                    }
                }

                unset($session['filenameComDoc']);


                $langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
                if($lesson->parent_id == 0){
                    $rootId = $lesson->id;
                }else{
                    $rootId = $lesson->parent_id;
                }

                foreach ($langs as $key => $lang) {
                    $models = LessonMsTeamsInstitution::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
                    if(!$models){
                        $Root = LessonMsTeamsInstitution::model()->findByPk($rootId);
                        Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มบทเรียน '.$Root->title .',ภาษา '.$lang->language);
                                // $this->redirect(array('Category/index'));
                        $this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
                        exit();
                    }
                }

            }

            unset($session['filenameComDoc']);

            $lesson = LessonMsTeamsInstitution::model()->findByPk($rootId);
            $this->redirect(array('view','id'=>$lesson->id));
        }
    }
 
    $this->render('create',array(
        'lesson'=>$lesson
        ,'fileDoc'=>$fileDoc
    ));
}


public function actionUploadifivedoc()
{
    $session = Yii::app()->session;
    if(!isset($session['idxDoc'])){
        $session['idxDoc'] = 1;
    }
        // Set the uplaod directory
        // $webroot = Yii::app()->getUploadPath('filedoc');
    $webroot = Yii::app()->basePath."/../../uploads/filedoc_msteams/";
    $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('pdf','doc','docx','pptx','ppt','xlsx','xls'); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand();
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = "{$rnd}-{$session['idxDoc']}.".strtolower($uploadedFile->getExtensionName());
            $session['idxDoc'] += 1;
            //$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $fileName;
            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file

                if (!isset($session['filenameComDoc']) || count($session['filenameComDoc'])==0)
                {
                    $session['filenameComDoc'] = array($fileName);
                }else{
                    $filenameComArr = $session['filenameComDoc'];
                    $filenameComArr[] = $fileName;
                    $session['filenameComDoc'] = $filenameComArr;
                }

                if (!isset($session['filenameOriComDoc']) || count($session['filenameOriComDoc'])==0)
                {
                    $session['filenameOriComDoc'] = array(str_replace(".".$fileParts,"",$_FILES['Filedata']['name']));
                }else{
                    $filenameOriComArr = $session['filenameOriComDoc'];
                    $filenameOriComArr[] = str_replace(".".$fileParts,"",$_FILES['Filedata']['name']);
                    $session['filenameOriComDoc'] = $filenameOriComArr;
                }

                if (!isset($session['pathComDoc']) || count($session['pathComDoc'])==0)
                {
                    $session['pathComDoc'] = array($uploadDir);
                }else{
                    $pathComArr = $session['pathComDoc'];
                    $pathComArr[] = $uploadDir;
                    $session['pathComDoc'] = $pathComArr;
                }
                move_uploaded_file($tempFile, $targetFile);

                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

     public function actionDeleteFileDoc($id)
    {
        $model = FileDocMsTeams::model()->findByPk($id);

        if($model->count()>0){

            $webroot = Yii::app()->basePath."/../uploads/filedoc_msteams/";
            // if(is_file(Yii::app()->getUploadPath('filedoc').$model->filename)){
            //     unlink(Yii::app()->getUploadPath('filedoc').$model->filename);
            // }

            if(is_file($webroot.$model->filename)){
                unlink($webroot.$model->filename);
            }

            if($model->delete($id)){
                echo 1;
            }else{
                echo 0;
            }
        }
    }

     public function actionEditName()
    {
        $fileDoc = FileDocMsTeams::model()->findByPK($_GET['id']);
        if($fileDoc){
            $fileDoc->file_name = $_GET['name'];
            $fileDoc->save();
        }
    }



    public function actionFormLessonms($id,$type)
    {
        $model = $this->loadModel($id);
        $Manage = new ManageMsTeamsInstitution;
        //Query Manage
        $criteria=new CDbCriteria;
        $criteria->compare("id",$id);
        $criteria->compare("type",$type);
        $dataManage = new CActiveDataProvider('ManageMsTeamsInstitution',array('criteria'=>$criteria));
        $ManageModel=new ManageMsTeamsInstitution('search');
        $ManageModel->unsetAttributes();  // clear any default values
        $ManageModel->type = $_GET['type'];
        if(isset($_GET['ManageMsTeamsInstitution']))
            $ManageModel->attributes = $_GET['ManageMsTeamsInstitution'];

        if(isset($_POST['ManageMsTeamsInstitution']))
        {
            $Manage->attributes = $_POST['ManageMsTeamsInstitution'];
            $Manage->type = $_GET['type'];
            $Manage->id = $id;
            if ($_POST['ManageMsTeamsInstitution']['manage_row']<=$Manage->getCount()){
                if($Manage->save())
                    $this->redirect(array('formLessonms','id'=>$id,'type'=>$type));
            }else {
                Yii::app()->user->setFlash('error', 'ไม่สามารถเพิ่มค่าได้ จำนวนข้อสอบที่จะแสดงมีมากกว่าข้อสอบ');
            }
        }

        if(isset($_POST['LessonMsTeamsInstitution']))
        {
            $model->attributes = $_POST['LessonMsTeamsInstitution'];
            if($model->save())
                $this->redirect(array('formLessonms','id'=>$id,'type'=>$type));
        }

        Yii::app()->user->setState('getLessonMs', $id);

        $this->render('formlessonms',array(
            'model'=>$model,
            'ManageModel'=>$ManageModel,
            'Manage'=>$Manage,
            'dataManage'=>$dataManage,
            'pk'=>$id,
            'type' => $type,
        ));
    }

    public function actionUpdateLessonMs($id,$type=null)
    {
        $Manage = $this->loadManageModel($id);
        if(isset($_POST['ManageMsTeamsInstitution']))
        {
            $Manage->attributes = $_POST['ManageMsTeamsInstitution'];
            if($Manage->save())
                $this->redirect(array('formLessonms','id'=>Yii::app()->user->getState('getLessonMs'),'type' => $type));
        }
        $this->render('updatelessonms',array(
            'Manage'=>$Manage,
            'type'=>$type
        ));
    }

    public function actionUpdate($id)
    {
        $fileDoc = $this->loadFileDocModel($id);
        $session = Yii::app()->session;

        $model = $this->loadModel($id);
        // ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
        // $check_user = User::model()->findByPk(Yii::app()->user->id);
        // $group = $check_user->group;
        // $group_arr = json_decode($group);
        // $see_all = 2;
        // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
        //     $see_all = 1;
        // }
        //     //////////////////
        // if($see_all == 1 || $model->create_by == Yii::app()->user->id){

        $lesson = $this->loadModel($id);
        $imageOld = $lesson->image;
       
        if(isset($_POST['LessonMsTeamsInstitution']))
        {
            $time = date("dmYHis");
            if($lesson->ms_teams_id != $_POST['LessonMsTeamsInstitution']['ms_teams_id']){
                $count_les = LessonMsTeamsInstitution::Model()->count("ms_teams_id=:ms_teams_id AND active=:active", array(
                    "ms_teams_id"=>$_POST['LessonMsTeamsInstitution']['ms_teams_id'], "active"=>"y"
                ));
                $lesson->lesson_no = $count_les+1;
            }
            $lesson->attributes=$_POST['LessonMsTeamsInstitution'];
            // $lesson->ms_teams_id = $_POST['ms_teams_id'];
            $valid = $lesson->validate();


            $image = CUploadedFile::getInstance($lesson, 'image');
            if(!empty($image)){
                $fileNamePicture = $time."_Picture.".$image->getExtensionName();
                $lesson->image = $fileNamePicture;
            }else{
                $lesson->image = $imageOld;
            }

            if($valid)
            {
                if($lesson->save(false))
                {
                    if(isset($imageOld) && isset($image))
                    {
                        Yii::app()->getDeleteImageYush('lesson',$lesson->id,$imageOld);
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

                    if(isset($session['filenameComDoc']) || count($session['filenameComDoc'])!=0)
                {
                    foreach ($session['filenameComDoc'] as $filenameComKey => $filenameComValue)
                    {
                        $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx')
                            // {
                        $file = new FileDocMsTeams;
                        $file->lesson_teams_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $session['filenameOriComDoc'][$filenameComKey];
                        $file->length = "2.00";
                        $file->save(false);
                            // }
                    }
                }

                unset($session['filenameComDoc']);



                    $parent_id = $lesson->id;
                    $modelChildren = LessonMsTeamsInstitution::model()->updateAll(array(
                        'ms_teams_id'=>$lesson->ms_teams_id,
                        'view_all'=>$lesson->view_all,
                        'cate_percent'=>$lesson->cate_percent,
                        'cate_amount'=>$lesson->cate_amount,
                        'time_test'=>$lesson->time_test,
                    ),
                    "parent_id='".$parent_id."'");
                    Yii::app()->user->setFlash('Success', 'แก้ไขบทเรียนสำเร็จ');

                }
                //Update By lerm
              
                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId($lesson->id);
                }
                $this->redirect(array('view','id'=>$lesson->id));
            }
        }
        unset($session['filenameComDoc']);

        //Update By lerm

        $this->render('update',array(
            'lesson'=>$lesson,'file'=>$file,'fileDoc'=>$fileDoc,'filePdf'=>$filePdf,'imageShow'=>$imageOld,'fileScorm'=>$fileScorm,'fileAudio' => $fileAudio,'fileebook'=>$fileebook
        ));

        // }
        // $this->redirect(array('index'));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        // ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
        //     $check_user = User::model()->findByPk(Yii::app()->user->id);
        //     $group = $check_user->group;
        //     $group_arr = json_decode($group);
        //     $see_all = 2;
        //     if(in_array("1", $group_arr) || in_array("7", $group_arr)){
        //         $see_all = 1;
        //     }
        //     //////////////////
        //     if($see_all == 1 || $model->create_by == Yii::app()->user->id){

        //$this->loadModel($id)->delete();
        

        //Start delete lesson Children
        $parent_id = $model->id;
        $modelChildren = LessonMsTeamsInstitution::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
        ));
        foreach ($modelChildren as $key => $value) {
                $value->active = 'n';
                if($model->image != ''){
                    Yii::app()->getDeleteImageYush('LessonMsTeamsInstitution',$model->id,$model->image);
                }
                $model->image = null;
                $value->save();
            }
            //End delete lesson Children
          
                $model->active = 'n';

                if($model->image != '')
                    Yii::app()->getDeleteImageYush('LessonMsTeamsInstitution',$model->id,$model->image);

                $model->image = null;
                $model->save();

                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId();
                }

                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

                // }
                //  $this->redirect(array('index'));
    }

public function actionMultiDelete()
{
    header('Content-type: application/json');
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
    $model=new LessonMsTeamsInstitution('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LessonMsTeamsInstitution']))
            $model->attributes=$_GET['LessonMsTeamsInstitution'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=LessonMsTeamsInstitution::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadManageModel($id)
    {
        $model=ManageMsTeamsInstitution::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    
    public function actionCreatefolder(){
        $dirPpt = Yii::app()->basePath."/../../uploads/ppt_audio/";
        $pptFolder = Yii::app()->file->set($dirPpt);
        $pptFolder->Delete();
        if(!$pptFolder->CreateDir()){
            echo "Can not create directory";
            exit;
        }
        chmod($dirPpt, 0777);
        var_dump($dirPpt);exit();
    }

    public function actionActivePre($id){
        $model = LessonMsTeamsInstitution::model()->findByPk($id);
        $modelChildren = LessonMsTeamsInstitution::model()->findAll(array(
            'condition'=>'parent_id=:parent_id',
            'params' => array(':parent_id' => $model->id)
              ));
            foreach ($modelChildren as $key => $value) {
                if($value->status_exams_pre == 1){
                    $value->status_exams_pre = 0;
                    $value->save(false);
                } else {
                    $value->status = 1;
                    $value->save(false);
                }
            }
        if($model->status_exams_pre == 1){
            $model->status_exams_pre = 0;
            $model->save(false);
        } else {
            $model->status_exams_pre = 1;
            $model->save(false);
        }
        $this->redirect(array('/LessonMsTeamsInstitution/index'));
    }

     public function actionActivePost($id){
        $model = LessonMsTeamsInstitution::model()->findByPk($id);
        $modelChildren = LessonMsTeamsInstitution::model()->findAll(array(
            'condition'=>'parent_id=:parent_id',
            'params' => array(':parent_id' => $model->id)
              ));
            foreach ($modelChildren as $key => $value) {
                if($value->status_exams_post == 1){
                    $value->status_exams_post = 0;
                    $value->save(false);
                } else {
                    $value->status = 1;
                    $value->save(false);
                }
            }
        if($model->status_exams_post == 1){
            $model->status_exams_post = 0;
            $model->save(false);
        } else {
            $model->status_exams_post = 1;
            $model->save(false);
        }
        $this->redirect(array('/LessonMsTeamsInstitution/index'));
    }

       public function loadFileDocModel($id)
    {
        $model=LessonMsTeamsInstitution::model()->with('fileDocs')->findByPk($id);        
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
