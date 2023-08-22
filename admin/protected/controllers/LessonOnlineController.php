<?php

class LessonOnlineController extends Controller
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
                'actions' => array('index', 'view','update','delete','create'),
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
    $lesson = new LessonOnline;

    if(isset($_POST['LessonOnline']))
    {
        $time = date("dmYHis");
        $lesson->attributes=$_POST['LessonOnline'];


        // $lesson->ms_teams_id = $_POST['ms_teams_id'];
        $lesson->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        $lesson->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
        $count_les = LessonOnline::Model()->count("ms_teams_id=:ms_teams_id AND active=:active", array(
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

                $langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
                if($lesson->parent_id == 0){
                    $rootId = $lesson->id;
                }else{
                    $rootId = $lesson->parent_id;
                }

                foreach ($langs as $key => $lang) {
                    $models = LessonOnline::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
                    if(!$models){
                        $Root = LessonOnline::model()->findByPk($rootId);
                        Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มบทเรียน '.$Root->title .',ภาษา '.$lang->language);
                                // $this->redirect(array('Category/index'));
                        $this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
                        exit();
                    }
                }

            }

            $lesson = LessonOnline::model()->findByPk($rootId);
            $this->redirect(array('view','id'=>$lesson->id));
        }
    }
 
    $this->render('create',array(
        'lesson'=>$lesson
    ));
}

public function actionFormLessonms($id,$type)
{
    $model = $this->loadModel($id);
    $Manage = new ManageOnline;
        //Query Manage
    $dataManage = new CActiveDataProvider('ManageOnline',array('criteria'=>array('condition'=>' id = "'.$id.'" AND type = "'.$type.'" ')));
    $ManageModel=new ManageOnline('search');
        $ManageModel->unsetAttributes();  // clear any default values
        $ManageModel->type = $_GET['type'];
        if(isset($_GET['ManageOnline']))
            $ManageModel->attributes = $_GET['ManageOnline'];

        if(isset($_POST['ManageOnline']))
        {
            $Manage->attributes = $_POST['ManageOnline'];
            $Manage->type = $_GET['type'];
            $Manage->id = $id;
            if ($_POST['ManageOnline']['manage_row']<=$Manage->getCount()){
                if($Manage->save())
                    $this->redirect(array('formLessonms','id'=>$id,'type'=>$type));
            }else {
                Yii::app()->user->setFlash('error', 'ไม่สามารถเพิ่มค่าได้ จำนวนข้อสอบที่จะแสดงมีมากกว่าข้อสอบ');
            }
        }

        if(isset($_POST['LessonOnline']))
        {
            $model->attributes = $_POST['LessonOnline'];
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
        if(isset($_POST['ManageOnline']))
        {
            $Manage->attributes = $_POST['ManageOnline'];
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
       
        if(isset($_POST['LessonOnline']))
        {
            $time = date("dmYHis");
            if($lesson->ms_teams_id != $_POST['LessonOnline']['ms_teams_id']){
                $count_les = LessonOnline::Model()->count("ms_teams_id=:ms_teams_id AND active=:active", array(
                    "ms_teams_id"=>$_POST['LessonOnline']['ms_teams_id'], "active"=>"y"
                ));
                $lesson->lesson_no = $count_les+1;
            }
            $lesson->attributes=$_POST['LessonOnline'];
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


                    $parent_id = $lesson->id;
                    $modelChildren = LessonOnline::model()->updateAll(array(
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
        $modelChildren = LessonOnline::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
        ));
        foreach ($modelChildren as $key => $value) {
                $value->active = 'n';
                if($model->image != ''){
                    Yii::app()->getDeleteImageYush('LessonOnline',$model->id,$model->image);
                }
                $model->image = null;
                $value->save();
            }
            //End delete lesson Children
          
                $model->active = 'n';

                if($model->image != '')
                    Yii::app()->getDeleteImageYush('LessonOnline',$model->id,$model->image);

                $model->image = null;
                $model->save();

                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId();
                }

                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

        //         }
        // $this->redirect(array('index'));
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
    $model=new LessonOnline('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['LessonOnline']))
            $model->attributes=$_GET['LessonOnline'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=LessonOnline::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadManageModel($id)
    {
        $model= ManageOnline::model()->findByPk($id);
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
        $model = LessonOnline::model()->findByPk($id);
        $modelChildren = LessonOnline::model()->findAll(array(
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
        $this->redirect(array('/LessonOnline/index'));
    }

     public function actionActivePost($id){
        $model = LessonOnline::model()->findByPk($id);
        $modelChildren = LessonOnline::model()->findAll(array(
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
        $this->redirect(array('/LessonOnline/index'));
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
