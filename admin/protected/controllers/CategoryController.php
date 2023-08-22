<?php

class CategoryController extends Controller
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
            // 'rights- toggle, switch, qtoggle',
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
                'actions' => array('index', 'view','Multidelete','update','delete','create'),
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
    // public function filters()
    // {
    //     return array(
    //      'rights- toggle, switch, qtoggle',
    //     );
    // }

    public function actions()
    {
        return array(
            'toggle'=>'ext.jtogglecolumn.ToggleAction',
            'switch'=>'ext.jtogglecolumn.SwitchAction',
            'qtoggle'=>'ext.jtogglecolumn.QtoggleAction',
        );
    }

    public function actionActive($id){
        $model = Category::model()->findByPk($id);
             $modelChildren = Category::model()->findAll(array(
            'condition'=>'parent_id=:parent_id',
            'params' => array(':parent_id' => $model->cate_id)
              ));
            foreach ($modelChildren as $key => $value) {
                if($value->cate_show == 1){
                    $value->cate_show = 0;
                    $value->save(false);
                } else {
                    $value->cate_show = 1;
                    $value->save(false);
                }
            }
        if($model->cate_show == 1){
            $model->cate_show = 0;
            $model->save(false);
        } else {
            $model->cate_show = 1;
            $model->save(false);
        }
        $this->redirect(array('/Category/index'));
    }

    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionDeleteVdo($id)
    {
        $model = Filecategory::model()->findByPk($id);

        if($model->count()>0){

            if(is_file(Yii::app()->getUploadPath(null).$model->filename))
                {
                    unlink(Yii::app()->getUploadPath(null).$model->filename);
                }

                if($model->delete($id))
                {
                    echo 1;
                }
                else
                {
                    echo 0;
                }
            }
        }

        public function actionCreate()
        {
            $model=new Category;

            if(isset($_POST['Category']))
            {

                $time = date("dmYHis");
                $model->attributes=$_POST['Category'];
                $model->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
                $model->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
                $model->cate_show = 1;
                $cate_image = CUploadedFile::getInstance($model, 'cate_image');

                if(!empty($cate_image)){
                    $fileNamePicture = $time."_Picture.".$cate_image->getExtensionName();
                    $model->cate_image = $fileNamePicture;
                }


                if($model->validate())
                {
//                exit();
                    if($model->save())
                    {
                        if(isset($cate_image))
                        {
                        /////////// SAVE IMAGE //////////
                            Yush::init($model);
                            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->cate_image);
                            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->cate_image);
                            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->cate_image);
                        // Save the original resource to disk
                            $cate_image->saveAs($originalPath);

                        // Create a small image
                            $smallImage = Yii::app()->phpThumb->create($originalPath);
                            $smallImage->resize(110);
                            $smallImage->save($smallPath);

                        // Create a thumbnail
                            $thumbImage = Yii::app()->phpThumb->create($originalPath);
                            $thumbImage->resize(250);
                            $thumbImage->save($thumbPath);
                        }

                        if(Yii::app()->user->id){
                            Helpers::lib()->getControllerActionId();
                        }

                        $langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
                        if($model->parent_id == 0){
                            $rootId = $model->cate_id;
                        }else{
                            $rootId = $model->parent_id;
                        }
                        
                        foreach ($langs as $key => $lang) {
                            $models = Category::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
                            if(!$models){
                                $Root = Category::model()->findByPk($rootId);
                                Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มหมวดหลักสูตร '.$Root->cate_title .',ภาษา '.$lang->language);
                                // $this->redirect(array('Category/index'));
                                $this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
                                exit();
                            }
                        }

                        $model = Category::model()->findByPk($rootId);
                        $this->redirect(array('view','id'=>$model->cate_id));
                    }
                }
            }

            $this->render('create',array(
                'model'=>$model
            ));
        }

        public function actionUpdate($id)
        {
            $model=$this->loadModel($id);
            // ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
            // $check_user = User::model()->findByPk(Yii::app()->user->id);
            // $group = $check_user->group;
            // $group_arr = json_decode($group);
            // $see_all = 2;
            // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
            //     $see_all = 1;
            // }
            // //////////////////
            // if($see_all == 1 || $model->create_by == Yii::app()->user->id){

            
            $imageShow = $model->cate_image;


            if(isset($_POST['Category']))
            {
                $time = date("dmYHis");
                $model->attributes=$_POST['Category'];



                $cate_image = CUploadedFile::getInstance($model, 'cate_image');
                if(isset($cate_image)){
                    $fileNamePicture = $time."_Picture.".$cate_image->getExtensionName();
                    $model->cate_image = $fileNamePicture;
                }else{
                    $model->cate_image = $imageShow;
                }

                if($model->validate())
                {
                    if($model->save())
                    {
                        if(Yii::app()->user->id){
                            Helpers::lib()->getControllerActionId($model->cate_id);
                        }
                        if(isset($imageShow) && isset($cate_image))
                        {
                            Yii::app()->getDeleteImageYush('category',$model->id,$imageShow);
                        }

                        if(isset($cate_image))
                        {
                        /////////// SAVE IMAGE //////////
                            Yush::init($model);
                            $originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->cate_image);
                            $thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->cate_image);
                            $smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->cate_image);
                        // Save the original resource to disk
                            $cate_image->saveAs($originalPath);

                        // Create a small image
                            $smallImage = Yii::app()->phpThumb->create($originalPath);
                            $smallImage->resize(110);
                            $smallImage->save($smallPath);

                        // Create a thumbnail
                            $thumbImage = Yii::app()->phpThumb->create($originalPath);
                            $thumbImage->resize(250);
                            $thumbImage->save($thumbPath);
                        }


                        $this->redirect(array('view','id'=>$model->cate_id));
                    }
                }
            }        

            $this->render('update',array(
                'model'=>$model,
                'imageShow'=>$imageShow,
            ));
        // }
        // $this->redirect(array('index'));
        }

        public function actionDelete_old($id)
        {
            $model = $this->loadModel($id);
            ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
            $check_user = User::model()->findByPk(Yii::app()->user->id);
            $group = $check_user->group;
            $group_arr = json_decode($group);
            $see_all = 2;
            if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                $see_all = 1;
            }
            //////////////////
            if($see_all == 1 || $model->create_by == Yii::app()->user->id){

            $parent_id = $model->cate_id;
            $modelChildren = Category::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
              ));
            foreach ($modelChildren as $key => $value) {
                 $value->active = 'n';
                 $value->save();

                 $modelCourseOnlineCh = CourseOnline::model()->findAll(array(
                'condition' => 'cate_id = '.$value->cate_id,
                    ));
                 if(isset($modelCourseOnlineCh)){
                        foreach($modelCourseOnlineCh as $valueCourseOnlineCh){
                            $modelLessonCh = Lesson::model()->findAll(array(
                            'condition' => 'course_id = '.$valueCourseOnlineCh->course_id,    
                                ));
                                foreach ($modelLessonCh as $valueLessonCh){
                                    $modelFileCh = File::model()->findAll(array(
                                    'condition' => 'lesson_id = '.$valueLessonCh->id,
                                    ));
                                    foreach ($modelFileCh as $valueFileCh){
                                        if(is_file(Yii::app()->getUploadPath('Lesson').$valueFileCh->filename))
                                        {
                                            unlink(Yii::app()->getUploadPath('Lesson').$valueFileCh->filename);
                                        }
                                    }
                                    if(isset($valueLessonCh->image) && $valueLessonCh->image != null)
                                    {
                                        Yii::app()->getDeleteImageYush('Lesson',$valueLessonCh->id,$valueLessonCh->image);
                                    }
                                }
                                if(isset($valueCourseOnlineCh->course_picture) && $valueCourseOnlineCh->course_picture != null)
                                {
                                    Yii::app()->getDeleteImageYush('CourseOnline',$valueCourseOnlineCh->course_id,$valueCourseOnlineCh->course_picture);
                                }
                        }
                 }
                 //========== Delete Course ==========//
                $modelCourseCh = Course::model()->findAll(array(
                    'condition' => 'cate_id = '.$value->cate_id,
                ));
                if(isset($modelCourseCh))
                {
                    foreach($modelCourseCh as $valueCourseCh)
                    {
                        if(isset($valueCourseCh->course_picture) && $valueCourseCh->course_picture != null)
                        {
                            Yii::app()->getDeleteImageYush('Course',$valueCourseCh->course_id,$valueCourseCh->course_picture);
                        }
                    }
                }

                if($value->cate_image != '')
                {
                    Yii::app()->getDeleteImageYush('Category',$value->cate_id,$value->cate_image);
                }

        //========== Delect File Vdo ==========//
                $fileCh = $this->loadFileModel($value->cate_id);
                if(isset($fileCh->files))
                {
                    foreach($fileCh->files as $fileDataCh)
                    {
                        if(is_file(Yii::app()->getUploadPath(null).$fileDataCh->filename))
                            {
                                unlink(Yii::app()->getUploadPath(null).$fileDataCh->filename);
                            }
                        }
                    }

            }
            //End parent

        //========== Delete CourseOnline  ==========//
            $modelCourseOnline = CourseOnline::model()->findAll(array(
                'condition' => 'cate_id = '.$id,
            ));
            if(isset($modelCourseOnline))
            {
                foreach($modelCourseOnline as $valueCourseOnline)
                {
                //========== Delete Lesson  ==========//
                    $modelLesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = '.$valueCourseOnline->course_id,
                    ));

                    foreach ($modelLesson as $valueLesson)
                    {
                    //========== Delete File  ==========//
                        $modelFile = File::model()->findAll(array(
                            'condition' => 'lesson_id = '.$valueLesson->id,
                        ));

                        foreach ($modelFile as $valueFile)
                        {
                            if(is_file(Yii::app()->getUploadPath('Lesson').$valueFile->filename))
                                {
                                    unlink(Yii::app()->getUploadPath('Lesson').$valueFile->filename);
                                }
                            }

                            if(isset($valueLesson->image) && $valueLesson->image != null)
                            {
                                Yii::app()->getDeleteImageYush('Lesson',$valueLesson->id,$valueLesson->image);
                            }
                        }

                        if(isset($valueCourseOnline->course_picture) && $valueCourseOnline->course_picture != null)
                        {
                            Yii::app()->getDeleteImageYush('CourseOnline',$valueCourseOnline->course_id,$valueCourseOnline->course_picture);
                        }
                    }
                }

        //========== Delete Course ==========//
                $modelCourse = Course::model()->findAll(array(
                    'condition' => 'cate_id = '.$id,
                ));
                if(isset($modelCourse))
                {
                    foreach($modelCourse as $valueCourse)
                    {
                        if(isset($valueCourse->course_picture) && $valueCourse->course_picture != null)
                        {
                            Yii::app()->getDeleteImageYush('Course',$valueCourse->course_id,$valueCourse->course_picture);
                        }
                    }
                }

                if($model->cate_image != '')
                {
                    Yii::app()->getDeleteImageYush('Category',$model->id,$model->cate_image);
                }

        //========== Delect File Vdo ==========//
                $file = $this->loadFileModel($id);
                if(isset($file->files))
                {
                    foreach($file->files as $fileData)
                    {
                        if(is_file(Yii::app()->getUploadPath(null).$fileData->filename))
                            {
                                unlink(Yii::app()->getUploadPath(null).$fileData->filename);
                            }
                        }
                    }

                    // $this->loadModel($id)->delete();
                    $model->active = 'n';
                    $model->save();
                    if(Yii::app()->user->id){
                        Helpers::lib()->getControllerActionId();
                    }

                    if(!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

                    }
        $this->redirect(array('index'));
    }

    public function actionDelete($id)
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
        // if($see_all == 1 || $model->create_by == Yii::app()->user->id){
            $model->active = 'n';
            $model->save(false);
            $modelChildren = Category::model()->findAll(array(
                'condition'=>'parent_id=:parent_id AND active=:active',
                'params' => array(':parent_id'=>$id, ':active'=>'y')
            ));
            foreach ($modelChildren as $key => $value) {
               $value->active = 'n';
               $value->save(false);
           }
           //////////////////////////////////////////////////////// จบ cate
           $model_Course = CourseOnline::model()->findAll(array(
            'condition' => 'cate_id='.$id,
            ));
           foreach ($model_Course as $key => $value) {
                $value->active = 'n';
                $value->save(false);
                $model_course_ch = CourseOnline::model()->findAll(array(
                    'condition' => 'parent_id='.$value->course_id,
                ));
                foreach ($model_course_ch as $key_ch => $value_ch) {
                    $value_ch->active = 'n';
                    $value_ch->save(false);
                }
                ///////////////////////////////////////////////////// จบ course
                $model_lesson = Lesson::model()->findAll(array(
                    'condition' => 'course_id='.$value->course_id,
                ));
                foreach ($model_lesson as $key_l => $value_l) {
                    $value_l->active = 'n';
                    $value_l->save(false);
                    $model_lesson_ch = Lesson::model()->findAll(array(
                        'condition' => 'parent_id='.$value_l->id,
                    ));
                    foreach ($model_lesson_ch as $key_l_ch => $value_l_ch) {
                        $value_l_ch->active = 'n';
                        $value_l_ch->save(false);
                    }
                    ////////////////////////////////////////////////// จบ lesson
                    $model_file = File::model()->findAll(array(
                        'condition' => 'lesson_id='.$value_l->id,
                    ));
                    $model_file_audio = FileAudio::model()->findAll(array(
                        'condition' => 'lesson_id='.$value_l->id,
                    ));
                    $model_file_doc = FileDoc::model()->findAll(array(
                        'condition' => 'lesson_id='.$value_l->id,
                    ));
                    $model_file_pdf = FilePdf::model()->findAll(array(
                        'condition' => 'lesson_id='.$value_l->id,
                    ));
                    $model_file_scorm = FileScorm::model()->findAll(array(
                        'condition' => 'lesson_id='.$value_l->id,
                    ));

                    foreach ($model_file as $key_f => $value_f) {
                        $value_f->active = 'n';
                        $value_f->save(false);
                    }
                    foreach ($model_file_audio as $key_f => $value_f) {
                        $value_f->active = 'n';
                        $value_f->save(false);
                    }
                    foreach ($model_file_doc as $key_f => $value_f) {
                        $value_f->active = 'n';
                        $value_f->save(false);
                    }
                    foreach ($model_file_pdf as $key_f => $value_f) {
                        $value_f->active = 'n';
                        $value_f->save(false);
                    }
                    foreach ($model_file_scorm as $key_f => $value_f) {
                        $value_f->active = 'n';
                        $value_f->save(false);
                    }
                    ////////////////////////////////////////////////// จบ file
                } // foreach ($model_lesson
                $model_org_course = OrgCourse::model()->findAll(array(
                    'condition' => 'course_id='.$value->course_id,
                ));
                foreach ($model_org_course as $key_oc => $value_oc) {
                    $value_oc->active = 'n';
                    $value_oc->save(false);
                }
                ///////////////////////////////////////////////////// จบ Org Course
           } // foreach ($model_Course
        // } // if($see_all == 1 || $model->create_by == Yii::app()->user->id
        if(!isset($_GET['ajax'])){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    public function actionMultiDelete()
    {
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
        $model=new Category('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Category']))
            $model->attributes=$_GET['Category'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    public function loadModel($id)
    {
        $model=Category::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadFileModel($id)
    {
        $model=Category::model()->with('files')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
