<?php

class LessonController extends Controller
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
                'actions' => array('index', 'view','DeleteVdo','DeleteFileDoc','add_teacher','CheckExists','uploadifive','uploadifivedoc','uploadifivepdf','uploadifiveebook','uploadifivescorm','EditName','update','delete','create', 'UploadifiveAudio'),
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
    //         'rights',
    //     );
    // }

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

            $webroot = Yii::app()->basePath."/../../uploads/lesson/";

            // if(is_file(Yii::app()->getUploadPath(null).$model->filename)){
            //     unlink(Yii::app()->getUploadPath(null).$model->filename);
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

    public function actionDeleteFileDoc($id)
    {
        $model = FileDoc::model()->findByPk($id);

        if($model->count()>0){

            $webroot = Yii::app()->basePath."/../uploads/filedoc/";

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

    public function actionDeleteFilePdf($id)
    {
        $model = FilePdf::model()->findByPk($id);
        $criteria=new CDbCriteria;
        $criteria->addCondition('file_id ='.$id);
        $criteria->addCondition('type = "pdf"');
        if($model->count()>0){

            $webroot = Yii::app()->basePath."/../uploads/filepdf/";

            // if(is_file(Yii::app()->getUploadPath('filepdf').$model->filename)){
            //     unlink(Yii::app()->getUploadPath('filepdf').$model->filename);
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

    public  function actionAdd_teacher($id){
      $teacher = new LessonTeacher('search');
      $teacher->lesson_id = $id;

      if(isset($_POST['LessonTeacher']))
      {
        $teacher->attributes = $_POST['LessonTeacher'];
        $teacher->lesson_id = $id;
        if($teacher->save())
          $this->redirect(array('add_teacher','id'=>$id));
  }

  $this->render('add_teacher',array(
    'teacher'=>$teacher,
));
}

public  function actionEdit_teacher($id){
  var_dump($id);
  $teacher = LessonTeacher::model()->findByPk($id);

  if(isset($_POST['LessonTeacher']))
  {
    $teacher->attributes = $_POST['LessonTeacher'];
    $teacher->lesson_id = $_GET['lesson_id'];
    if($teacher->save())
      $this->redirect(array('add_teacher','id'=>$_GET['lesson_id']));
}

$this->render('edit_teacher',array(
    'teacher'=>$teacher,
));
}

public function actionCreate()
{
    $lesson = new Lesson;
    // $lesson = Lesson::model()->findAll(array('condition'=> 'lang_id = 1'));

    $file = new File;
    $fileDoc = new FileDoc;
    $filePdf = new FilePdf;
    $fileAudio = new FileAudio;
    $fileScorm = new FileScorm;
    $fileebook = new FileEbook;


    $session = Yii::app()->session;

   //echo "<pre>"; var_dump($session); exit();
    // if(isset($_GET['lang_id'])){
    //     $lessonChildren = Lesson::model()->findByPk($_GET['parent_id']); //root parent
    //     $imageOld = $lessonChildren->image;
    //     $file = $this->loadFileModel($lessonChildren->id);
    //     $fileDoc = $this->loadFileDocModel($lessonChildren->id);
    //     $filePdf = $this->loadFilePdfModel($lessonChildren->id);
    //     $fileScorm = $this->loadFileScormModel($lessonChildren->id);

    // }
    if(isset($_POST['Lesson']))
    {
        $time = date("dmYHis");
        $lesson->attributes=$_POST['Lesson'];


        // $lesson->course_id = $_POST['course_id'];
        $lesson->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        $lesson->parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
        $count_les = Lesson::Model()->count("course_id=:course_id AND active=:active", array(
            "course_id"=>$lesson->course_id, "active"=>"y"
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

                
                if($lesson->type == "youtube"){
                    if(isset($_POST["link_youtube"])){
                        foreach ($_POST["link_youtube"] as $key => $youtube) {
                            $file = new File;
                            $file->lesson_id = $lesson->id;
                            $file->filename = $youtube;
                            $file->encredit = $_POST["encredit_youtube"][$key];
                            $file->length = "2.00";
                            $file->lang_id = 1;
                            $file->parent_id = 0;
                            $file->save(false);
                        }
                    }   
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
                            $file->file_name = $session['filenameTrueCom'][$filenameComKey];
                            $file->length = "2.00";
                            $file->lang_id = 1;
                            $file->parent_id = 0;
                            $file->save(false);
                        }
                    }
                }

                if(isset($session['filenameComAudio']) || count($session['filenameComAudio'])!=0)
                {
                    foreach ($session['filenameComAudio'] as $filenameComKey => $filenameComValue)
                    {
                        $filenameCheck = explode('.', $filenameComValue);
                        if($filenameCheck[1] == 'mp3' or $filenameCheck[1] == 'mp4')
                        {
                            $file = new FileAudio;
                            $file->lesson_id = $lesson->id;
                            $file->filename = $filenameComValue;
                            $file->length = "2.00";
                            $file->lang_id = 1;
                            $file->parent_id = 0;
                            $file->save(false);
                        }
                    }
                }

                if(isset($session['filenameComDoc']) || count($session['filenameComDoc'])!=0)
                {
                    foreach ($session['filenameComDoc'] as $filenameComKey => $filenameComValue)
                    {
                        $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx')
                            // {
                        $file = new FileDoc;
                        $file->lesson_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $session['filenameOriComDoc'][$filenameComKey];
                        $file->length = "2.00";
                        // $file->lang_id = 1;
                        // $file->parent_id = 0;
                        $file->save(false);
                            // }
                    }
                }
                if(isset($session['filenameComScorm']) || count($session['filenameComScorm'])!=0)
                {
                    foreach ($session['filenameComScorm'] as $filenameComKey => $filenameComValue)
                    {
                        $file = new FileScorm;
                        $file->lesson_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = "multiscreen.html";
                        $file->lang_id = 1;
                        $file->parent_id = 0;
                        $file->save(false);
                    }
                }

                     if(isset($session['filenameComEbook']) || count($session['filenameComEbook'])!=0)
                {
                    foreach ($session['filenameComEbook'] as $filenameComKey => $filenameComValue)
                    {
                        $fileScorm = FileEbook::model()->find(array('order'=>'id DESC'));
                        $cid = $fileScorm['id']+1;

                        $file = new FileEbook;
                        $file->id = $cid;
                        $file->lesson_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $filenameComValue.".html";
                        $file->lang_id = 1;
                        $file->parent_id = 0;
                        $file->save(false);
                    }
                }


               //var_dump($session['filenameComPdf']); exit();


                if(isset($session['filenameComPdf']) || count($session['filenameComPdf'])!=0)
                {
                    foreach ($session['filenameComPdf'] as $filenameComKey => $filenameComValue)
                    {
                        $file = new FilePdf;
                        $file->lesson_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $session['filenameOriComPdf'][$filenameComKey];
                        $file->length = "2.00";
                        $file->lang_id = 1;
                        $file->parent_id = 0;
                        $file->save(false);

                        // $webroot = Yii::app()->getUploadPath('filepdf');
                        $webroot = Yii::app()->basePath.'/../../uploads/filepdf/';

                        $fileNamePpt = $filenameComValue;
                        $dirPpt = Yii::app()->basePath."/../../uploads/pdf/".$file->id."/";
                        $pptFolder = Yii::app()->file->set($dirPpt);
                        $pptFolder->Delete();
                        if(!$pptFolder->CreateDir()){
                            echo "Can not create directory";
                            exit;
                        }
                        chmod($dirPpt, 0777);
                        if(file_exists($webroot.$fileNamePpt)){
                            copy($webroot.$fileNamePpt,$dirPpt.$fileNamePpt);
                            $ppName = $dirPpt.$fileNamePpt;

                            // if($_SERVER['HTTP_HOST'] == 'localhost'){
                            //     $imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
                            // }else{
                            //     $imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
                            // }

                            $imagemagick = "convert";
                            // $imagemagick = "convert";
                            $ppt_file = $ppName;
                            $new_pdf_file  = str_replace(".pptx", ".pdf", $ppName);
                            $new_pdf_file  = str_replace(".ppt", ".pdf", $new_pdf_file);
                            
                            exec($imagemagick.'  -density 300 "'.realpath($new_pdf_file).'"  -quality 80 "'.realpath($dirPpt).'/slide.jpg"');

                            $directory = realpath($dirPpt);
                            $scanned_directory = array_diff(scandir($directory), array('..', '.'));
                            $image_slide_len = count($scanned_directory)-1;

                            PdfSlide::model()->deleteAll("file_id='".$file->id."'");

                            for ($i=0; $i < $image_slide_len; $i++) { 
                                $image_slide = new PdfSlide;
                                $image_slide->file_id = $file->id;
                                $image_slide->image_slide_name = $i;
                                $image_slide->image_slide_time = $i;
                                $image_slide->save();
                            }

                            $pptFile = Yii::app()->file->set($dirPpt.$fileNamePpt);
                            $pptFile->Delete();

                            $pdfFile = Yii::app()->file->set($new_pdf_file);
                            $pdfFile->Delete();
                        }
                    }
                }

                $langs = Language::model()->findAll(array('condition'=>'active = "y" and id != 1'));
                if($lesson->parent_id == 0){
                    $rootId = $lesson->id;
                }else{
                    $rootId = $lesson->parent_id;
                }

                foreach ($langs as $key => $lang) {
                    $models = Lesson::model()->findByAttributes(array('lang_id'=> $lang->id,'parent_id'=>$rootId));
                    if(!$models){
                        $Root = Lesson::model()->findByPk($rootId);
                        Yii::app()->user->setFlash('Success', 'กรุณาเพิ่มบทเรียน '.$Root->title .',ภาษา '.$lang->language);
                                // $this->redirect(array('Category/index'));
                        unset($session['pathCom']);
                        unset($session['filenameCom']);
                        unset($session['idx']);

                        unset($session['pathComDoc']);
                        unset($session['filenameComDoc']);
                        unset($session['filenameComAudio']);
                        unset($session['filenameOriComDoc']);
                        unset($session['filenameComPdf']);
                        unset($session['filenameOriComPdf']);
                        unset($session['filenameComScorm']);
                        unset($session['filenameComEbook']);
                        unset($session['idxDoc']);
                        unset($session['idxPdf']);
                        $this->redirect(array('create','lang_id'=> $lang->id,'parent_id'=> $rootId));
                        exit();
                    }
                }

            }
            unset($session['pathCom']);
            unset($session['filenameCom']);
            unset($session['idx']);

            unset($session['pathComDoc']);
            unset($session['filenameComDoc']);
            unset($session['filenameOriComDoc']);
            unset($session['filenameComAudio']);
            unset($session['filenameOriComPdf']);
            unset($session['filenameComScorm']);
            unset($session['filenameComEbook']);
            unset($session['filenameComPdf']);
            unset($session['idxDoc']);
            unset($session['idxPdf']);

            $lesson = Lesson::model()->findByPk($rootId);
            $this->redirect(array('view','id'=>$lesson->id));
        }
    }
    unset($session['pathCom']);
    unset($session['filenameCom']);
    unset($session['idx']);

    unset($session['pathComDoc']);
    unset($session['filenameComDoc']);
    unset($session['filenameOriComDoc']);
    unset($session['filenameComAudio']);
    unset($session['filenameOriComPdf']);
    unset($session['filenameComScorm']);
    unset($session['filenameComEbook']);
    unset($session['filenameComPdf']);
    unset($session['idxDoc']);
    unset($session['idxPdf']);
    $this->render('create',array(
        'lesson'=>$lesson,'file'=>$file,'fileDoc'=>$fileDoc,'filePdf'=>$filePdf,'fileScorm'=>$fileScorm,'fileAudio'=>$fileAudio,'fileebook'=>$fileebook
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
            if ($_POST['Manage']['manage_row']<=$Manage->getCount() && $_POST['Manage']['manage_row'] > 0){
                if($Manage->save())
                    $this->redirect(array('formLesson','id'=>$id,'type'=>$type));
            }else {
                Yii::app()->user->setFlash('error', 'ไม่สามารถเพิ่มค่าได้ จำนวนข้อสอบที่จะแสดงมีมากกว่าข้อสอบ');
            }
            if ($_POST['Manage']['manage_row'] == 0) {
                Yii::app()->user->setFlash('error', 'ไม่สามารถเพิ่มค่าได้ จำนวนข้อสอบต้องมากกว่า 0 ข้อ');
            }
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
            'pk'=>$id,
            'type' => $type,
        ));
    }

    public function actionUpdateLesson($id,$type=null)
    {
        $Manage = $this->loadManageModel($id);
        if(isset($_POST['Manage']))
        {
            $Manage->attributes = $_POST['Manage'];
            if($Manage->save())
                $this->redirect(array('formLesson','id'=>Yii::app()->user->getState('getLesson'),'type' => $type));
        }
        $this->render('updatelesson',array(
            'Manage'=>$Manage,
            'type'=>$type
        ));
    }

    public function actionUpdate($id)
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

        $lesson = $this->loadModel($id);
        $imageOld = $lesson->image;
        $file = $this->loadFileModel($id);
        $fileDoc = $this->loadFileDocModel($id);
        $fileAudio = $this->loadFileAudioModel($id);
        $filePdf = $this->loadFilePdfModel($id);
        $fileScorm = $this->loadFileScormModel($id);
        $fileebook = $this->loadFileEbookModel($id);

        $session = Yii::app()->session;

        //echo "<pre>";var_dump($file); exit();

        if(isset($_POST['Lesson']))
        {
            $time = date("dmYHis");
            if($lesson->course_id != $_POST['Lesson']['course_id']){
                $count_les = Lesson::Model()->count("course_id=:course_id AND active=:active", array(
                    "course_id"=>$_POST['Lesson']['course_id'], "active"=>"y"
                ));
                $lesson->lesson_no = $count_les+1;
            }
            $lesson->attributes=$_POST['Lesson'];
            // $lesson->course_id = $_POST['course_id'];
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

                    if($lesson->type == "youtube"){
                        if(isset($_POST["link_youtube"])){
                            foreach ($_POST["link_youtube"] as $key => $youtube) {
                                $file = new File;
                                $file->lesson_id = $lesson->id;
                                $file->filename = $youtube;
                                $file->encredit = $_POST["encredit_youtube"][$key];
                                $file->length = "2.00";
                                $file->lang_id = 1;
                                $file->parent_id = 0;
                                $file->save(false);
                            }
                        }

                        if(isset($_POST["link_youtube_old"])){
                            $model_files_old = File::model()->findAll("active='y' AND lesson_id='".$lesson->id."' ");
                            foreach ($model_files_old as $key => $value) {
                                $model_old = File::model()->findByPk($value->id);
                                if(isset($_POST["link_youtube_old"][$value->id])){
                                    $model_old->filename = $_POST["link_youtube_old"][$value->id];
                                    $model_old->encredit = $_POST["encredit_youtube_old"][$value->id];
                                    $model_old->save(false);
                                }else{                                    
                                    $model_old->active = 'n';
                                    $model_old->save(false);
                                }
                            }
                        }
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
                                $file->file_name = $session['filenameTrueCom'][$filenameComKey];
                                $file->length = "2.00";
                                $file->lang_id = 1;
                                $file->parent_id = 0;
                                $file->save(false);
                            }
                        }
                    }

                    if(isset($session['filenameComAudio']) || count($session['filenameComAudio'])!=0)
                    {
                        foreach ($session['filenameComAudio'] as $filenameComKey => $filenameComValue)
                        {
                            $filenameCheck = explode('.', $filenameComValue);
                            if($filenameCheck[1] == 'mp3' or $filenameCheck[1] == 'mp4')
                            {
                                $file = new FileAudio;
                                $file->lesson_id = $lesson->id;
                                $file->filename = $filenameComValue;
                                $file->length = "2.00";
                                $file->lang_id = 1;
                                $file->parent_id = 0;
                                $file->save(false);
                            }
                        }
                    }

                    if(isset($session['filenameComDoc']) || count($session['filenameComDoc'])!=0)
                    {
                        foreach ($session['filenameComDoc'] as $filenameComKey => $filenameComValue)
                        {
                            $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx')
                            // {
                            $file = new FileDoc;
                            $file->lesson_id = $lesson->id;
                            $file->filename = $filenameComValue;
                            $file->file_name = $session['filenameOriComDoc'][$filenameComKey];
                            $file->length = "2.00";
                            // $file->lang_id = 1;
                            // $file->parent_id = 0;
                            $file->save(false);
                            // }
                        }
                    }

                    if(isset($session['filenameComPdf']) || count($session['filenameComPdf'])!=0)
                    {
                        foreach ($session['filenameComPdf'] as $filenameComKey => $filenameComValue)
                        {
                            // $filenameCheck = explode('.', $filenameComValue);
                            // if($filenameCheck[1] == 'pdf' or $filenameCheck[1] == 'doc' or $filenameCheck[1] == 'docx' or $filenameCheck[1] == 'pptx' or $filenameCheck[1] == 'ppt')
                            // {
                            $file = new FilePdf;
                            $file->lesson_id = $lesson->id;
                            $file->filename = $filenameComValue;
                            $file->file_name = $session['filenameOriComPdf'][$filenameComKey];
                            $file->length = "2.00";
                            $file->lang_id = 1;
                            $file->parent_id = 0;
                            $file->save(false);
                        // }
                            // $webroot = Yii::app()->getUploadPath('filepdf');
                            $webroot = Yii::app()->basePath.'/../../uploads/filepdf/';

                            $fileNamePpt = $filenameComValue;
                            $dirPpt = Yii::app()->basePath."/../../uploads/pdf/".$file->id."/";
                            $pptFolder = Yii::app()->file->set($dirPpt);
                            $pptFolder->Delete();
                            if(!$pptFolder->CreateDir()){
                                echo "Can not create directory";
                                exit;
                            }
                            chmod($dirPpt, 0777);
                            if(file_exists($webroot.$fileNamePpt)){
                                copy($webroot.$fileNamePpt,$dirPpt.$fileNamePpt);
                                $ppName = $dirPpt.$fileNamePpt;

                                // if($_SERVER['HTTP_HOST'] == 'localhost'){
                                //     $imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
                                // }else{
                                //     $imagemagick = "\"C:/ImageMagick-6/convert.exe\"";
                                // }
                                $imagemagick = "convert";
                                // $imagemagick = "convert.exe";
                                $ppt_file = $ppName;
                                $new_pdf_file  = str_replace(".pptx", ".pdf", $ppName);
                                $new_pdf_file  = str_replace(".ppt", ".pdf", $new_pdf_file);

                                exec($imagemagick.' -density 300 "'.realpath($new_pdf_file).'" -quality 80 "'.realpath($dirPpt).'/slide.jpg"');

                                $directory = realpath($dirPpt);
                                $scanned_directory = array_diff(scandir($directory), array('..', '.'));
                                $image_slide_len = count($scanned_directory)-1;

                                PdfSlide::model()->deleteAll("file_id='".$file->id."'");

                                for ($i=0; $i < $image_slide_len; $i++) { 
                                    $image_slide = new PdfSlide;
                                    $image_slide->file_id = $file->id;
                                    $image_slide->image_slide_name = $i;
                                    $image_slide->image_slide_time = $i;
                                    $image_slide->save();
                                }

                                $pptFile = Yii::app()->file->set($dirPpt.$fileNamePpt);
                                $pptFile->Delete();

                                $pdfFile = Yii::app()->file->set($new_pdf_file);
                                $pdfFile->Delete();
                            }
                        }
                    }

                    if(isset($session['filenameComScorm']) || count($session['filenameComScorm'])!=0)
                    {
                        foreach ($session['filenameComScorm'] as $filenameComKey => $filenameComValue)
                        {
                            $file = new FileScorm;
                            $file->lesson_id = $lesson->id;
                            $file->filename = $filenameComValue;
                            $file->file_name = "multiscreen.html";
                            $file->lang_id = 1;
                            $file->parent_id = 0;
                            $file->save(false);
                        }
                    }

                      if(isset($session['filenameComEbook']) || count($session['filenameComEbook'])!=0)
                {
                    foreach ($session['filenameComEbook'] as $filenameComKey => $filenameComValue)
                    {
                        $fileScorm = FileEbook::model()->find(array('order'=>'id DESC'));
                        $cid = $fileScorm['id']+1;

                        $file = new FileEbook;
                        $file->id = $cid;
                        $file->lesson_id = $lesson->id;
                        $file->filename = $filenameComValue;
                        $file->file_name = $filenameComValue.".html";
                        $file->lang_id = 1;
                        $file->parent_id = 0;
                        $file->save(false);
                    }
                } 
                    

                    $parent_id = $lesson->id;
                    $modelChildren = Lesson::model()->updateAll(array(
                        'course_id'=>$lesson->course_id,
                        'view_all'=>$lesson->view_all,
                        'cate_percent'=>$lesson->cate_percent,
                        'cate_amount'=>$lesson->cate_amount,
                        'time_test'=>$lesson->time_test,
                    ),
                    "parent_id='".$parent_id."'");
                    Yii::app()->user->setFlash('Success', 'แก้ไขบทเรียนสำเร็จ');

                }
                //Update By lerm
                unset($session['filenameComScorm']);

                unset($session['pathCom']);
                unset($session['filenameCom']);
                unset($session['idx']);

                unset($session['pathComDoc']);
                unset($session['filenameComDoc']);
                unset($session['filenameComAudio']);
                unset($session['filenameOriComDoc']);
                unset($session['filenameOriComPdf']);
                unset($session['filenameComPdf']);
                unset($session['filenameComEbook']);

                unset($session['idxDoc']);
                unset($session['idxPdf']);
                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId($lesson->id);
                }
                $this->redirect(array('view','id'=>$lesson->id));
            }
        }
        //Update By lerm
        unset($session['filenameComScorm']);

        unset($session['pathCom']);
        unset($session['filenameCom']);
        unset($session['idx']);

        unset($session['pathComDoc']);
        unset($session['filenameComDoc']);
        unset($session['filenameComAudio']);
        unset($session['filenameOriComDoc']);
        unset($session['filenameOriComPdf']);
        unset($session['filenameComPdf']);
        unset($session['filenameComEbook']);

        unset($session['idxDoc']);
        unset($session['idxPdf']);

        $this->render('update',array(
            'lesson'=>$lesson,'file'=>$file,'fileDoc'=>$fileDoc,'filePdf'=>$filePdf,'imageShow'=>$imageOld,'fileScorm'=>$fileScorm,'fileAudio' => $fileAudio,'fileebook'=>$fileebook
        ));

        }
        $this->redirect(array('index'));
    }

    public function actionDelete($id)
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

        //$this->loadModel($id)->delete();
        

        //Start delete lesson Children
        $parent_id = $model->id;
        $modelChildren = Lesson::model()->findAll(array(
            'condition'=>'parent_id=:parent_id AND active=:active',
            'params' => array(':parent_id' => $parent_id, ':active' => 'y')
        ));
        foreach ($modelChildren as $key => $value) {
            $fileCh = $this->loadFileModel($value->id);
            if(isset($fileCh->files))
            {
                foreach($fileCh->files as $fileDataCh)
                {
                    if(is_file(Yii::app()->getUploadPath(null).$fileDataCh->filename))
                        {
                            unlink(Yii::app()->getUploadPath(null).$fileDataCh->filename);
                            File::model()->findByPk($fileDataCh->id)->delete();
                        }
                    }
                }
                $value->active = 'n';
                if($model->image != ''){
                    Yii::app()->getDeleteImageYush('Lesson',$model->id,$model->image);
                }
                $model->image = null;
                $value->save();
            }
            //End delete lesson Children
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

                if(Yii::app()->user->id){
                    Helpers::lib()->getControllerActionId();
                }

                if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));

                }
        $this->redirect(array('index'));
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

            public function actionCheckExists()
            {
            // $webroot = Yii::app()->getUploadPath(null);
                $webroot = Yii::app()->basePath."/../../uploads/lesson/";
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
        $webroot = Yii::app()->basePath."/../../uploads/lesson/";
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('mp4','mp3','mkv'); // Allowed file extensions

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
                    $session['filenameTrueCom'] = array($_FILES['Filedata']['name']);
                }else{
                    $filenameComArr = $session['filenameCom'];
                    $filenameComArr[] = $fileName;
                    $session['filenameCom'] = $filenameComArr;
                    $filenameTrueComArr = $session['filenameTrueCom'];
                    $filenameTrueComArr[] = $_FILES['Filedata']['name'];
                    $session['filenameTrueCom'] = $filenameTrueComArr;
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

     public function actionUploadifiveAudio()
    {
        $session = Yii::app()->session;
        if(!isset($session['idx'])){
            $session['idx'] = 1;
        }
        // Set the uplaod directory
        $webroot = Yii::app()->getUploadPath(null);
        $webroot = Yii::app()->basePath."/../../uploads/lesson/";
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('mp4','mp3','mkv'); // Allowed file extensions

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

                if (!isset($session['filenameComAudio']) || count($session['filenameComAudio'])==0)
                {
                    $session['filenameComAudio'] = array($fileName);
                }else{
                    $filenameComArr = $session['filenameComAudio'];
                    $filenameComArr[] = $fileName;
                    $session['filenameComAudio'] = $filenameComArr;
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

    public function actionUploadifivepdf()
    {
        $session = Yii::app()->session;
        if(!isset($session['idxPdf'])){
            $session['idxPdf'] = 1;
        }
        // Set the uplaod directory
        // $webroot = Yii::app()->getUploadPath('filepdf');
        $webroot = Yii::app()->basePath."/../../uploads/filepdf/";
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('pdf'/*,'doc','docx','pptx','ppt'*/); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand(0,9999999999);
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = "{$rnd}-{$session['idxPdf']}.".strtolower($uploadedFile->getExtensionName());
            $session['idxPdf'] += 1;
            //$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $fileName;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file

                if (!isset($session['filenameComPdf']) || count($session['filenameComPdf'])==0)
                {
                    $session['filenameComPdf'] = array($fileName);
                }else{
                    $filenameComArr = $session['filenameComPdf'];
                    $filenameComArr[] = $fileName;
                    $session['filenameComPdf'] = $filenameComArr;
                }

                if (!isset($session['filenameOriComPdf']) || count($session['filenameOriComPdf'])==0)
                {
                    $session['filenameOriComPdf'] = array(str_replace(".".$fileParts,"",$_FILES['Filedata']['name']));
                }else{
                    $filenameOriComArr = $session['filenameOriComPdf'];
                    $filenameOriComArr[] = str_replace(".".$fileParts,"",$_FILES['Filedata']['name']);
                    $session['filenameOriComPdf'] = $filenameOriComArr;
                }

                if (!isset($session['pathPdf']) || count($session['pathPdf'])==0)
                {
                    $session['pathPdf'] = array($uploadDir);
                }else{
                    $pathComArr = $session['pathPdf'];
                    $pathComArr[] = $uploadDir;
                    $session['pathPdf'] = $pathComArr;
                }
                move_uploaded_file($tempFile, $targetFile);
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

    public function actionUploadifivedoc()
    {
        $session = Yii::app()->session;
        if(!isset($session['idxDoc'])){
            $session['idxDoc'] = 1;
        }
        // Set the uplaod directory
        // $webroot = Yii::app()->getUploadPath('filedoc');
        $webroot = Yii::app()->basePath."/../../uploads/filedoc/";
        $uploadDir = $webroot;

        // Set the allowed file extensions
        $fileTypes = array('pdf','doc','docx','pptx','ppt'); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {

            $rnd = rand(0,9999999999);
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

    public function actionUploadifivescorm()
    {
        require_once(__DIR__.'/../vendors/scorm/classes/pclzip.lib.php');
        require_once(__DIR__.'/../vendors/scorm/filemanager.inc.php');
        // Get arguments from argument array
        $session = Yii::app()->session;
        if(!isset($session['idxScorm'])){
            $session['idxScorm'] = 1;
        }
        $fileScorm = FileScorm::model()->find(array('order'=>'id desc'));
        $cid = $fileScorm['id']+1;
        // Set the uplaod directory
        // $webroot = Yii::app()->getUploadPath('scorm');
        $webroot = Yii::app()->basePath."/../../uploads/scorm/";
        $import_path = $webroot.$cid."/";
        // Set the allowed file extensions
        $fileTypes = array('zip'); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);
    if (!empty($_FILES) /*&& $_POST['token'] == $verifyToken*/) {
        // Validate the filetype
        $fileName = $_FILES['Filedata']['name'];
        $fileName = str_replace(".zip","",$fileName);
        $ext = pathinfo($_FILES['Filedata']['name']);
        if (in_array(strtolower($ext['extension']), $fileTypes)) {


            /* Copy package To Course/Import folder*/
            if (  !$_FILES['Filedata']['name'] || !is_uploaded_file($_FILES['Filedata']['tmp_name']) ||  ($_FILES['Filedata']['size'] == 0) ) {
                echo 'File: '.$_FILES['Filedata']['name'].' upload problem.'.$_FILES['Filedata']['size'];
                exit;
            }else{
                echo "<BR>upload Complete";
            }

            if (!is_dir($import_path)) {
                if (!@mkdir($import_path, 0777)) {
                    echo 'Cannot make import directory.';
                    exit;
                }
            }

            $pptFolder = Yii::app()->file->set($import_path);
            $pptFolder->Delete();
            if(!$pptFolder->CreateDir()){
                echo "Can not create directory";
                exit;
            }
            chmod($import_path, 0777);

            /* extract the entire archive into ../../content/import/$course using the call back function to filter out php files */
            $archive = new PclZip($_FILES['Filedata']['tmp_name']);
            if ($archive->extract(  PCLZIP_OPT_PATH,    $import_path,
                PCLZIP_CB_PRE_EXTRACT,  'preImportCallBack') == 0) {
                echo 'Cannot extract to $import_path';
                clr_dir($import_path);
                exit;
            }else {
                echo "<BR>Extract Complete";
            }
            // $uploadScormDir = $webroot.$cid.'/vr/';
       //      /*$uploadFolderScorm = Yii::app()->getUploadUrl("scorm").$cid.'/vr/';
       //      $uploadScormDir = __DIR__.'/../../../../..'.$uploadFolderScorm;*/
       //      if (is_dir($uploadScormDir)){
       //        if ($dh = opendir($uploadScormDir)){
       //          while (($file = readdir($dh)) !== false){
       //              $fileArray = explode('.', $file);
       //              $extension = $fileArray[sizeof($fileArray)-1];
       //              if($extension=='mp4'){
       //                 $fileName = $file;
       //             }
       //         }
       //         closedir($dh);
       //     }
       // }
            
            // $tempFile   = $_FILES['Filedata']['tmp_name'];
            // $targetFile = $import_path . $fileName.'.zip';
            // move_uploaded_file($tempFile, $targetFile);
        // Save the file
     if (!isset($session['filenameComScorm']) || count($session['filenameComScorm'])==0)
     {
        $session['filenameComScorm'] = array($fileName);
    }else{
        $filenameComArr = $session['filenameComScorm'];
        $filenameComArr[] = $fileName;
        $session['filenameComScorm'] = $filenameComArr;
    }

    unlink($_FILES['Filedata']['tmp_name']);
} else {
                // The file type wasn't allowed
    echo 'Invalid file type.';
}
}
}


public function actionuploadifiveebook()
    {
        require_once(__DIR__.'/../vendors/scorm/classes/pclzip.lib.php');
        require_once(__DIR__.'/../vendors/scorm/filemanager.inc.php');
        // Get arguments from argument array
        $session = Yii::app()->session;
        if(!isset($session['idxEbook'])){
            $session['idxEbook'] = 1;
        }
        $fileEbook = FileEbook::model()->find(array('order'=>'id desc'));
        $cid = $fileEbook['id']+1;

       

        // Set the uplaod directory
        // $webroot = Yii::app()->getUploadPath('scorm');
        $webroot = Yii::app()->basePath."/../../uploads/ebook/";
        $import_path = $webroot.$cid."/";
        // Set the allowed file extensions
        $fileTypes = array('zip'); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);
    if (!empty($_FILES) /*&& $_POST['token'] == $verifyToken*/) {
        // Validate the filetype
        $fileName = $_FILES['Filedata']['name'];
        $fileName = str_replace(".zip","",$fileName);
        $ext = pathinfo($_FILES['Filedata']['name']);
        if (in_array(strtolower($ext['extension']), $fileTypes)) {


            /* Copy package To Course/Import folder*/
            if (  !$_FILES['Filedata']['name'] || !is_uploaded_file($_FILES['Filedata']['tmp_name']) ||  ($_FILES['Filedata']['size'] == 0) ) {
                echo 'File: '.$_FILES['Filedata']['name'].' upload problem.'.$_FILES['Filedata']['size'];
                exit;
            }else{
                echo "<BR>upload Complete";
            }

            if (!is_dir($import_path)) {
                if (!@mkdir($import_path, 0777)) {
                    echo 'Cannot make import directory.';
                    exit;
                }
            }

            $pptFolder = Yii::app()->file->set($import_path);
            $pptFolder->Delete();
            if(!$pptFolder->CreateDir()){
                echo "Can not create directory";
                exit;
            }
            chmod($import_path, 0777);

            /* extract the entire archive into ../../content/import/$course using the call back function to filter out php files */
            $archive = new PclZip($_FILES['Filedata']['tmp_name']);
            if ($archive->extract(  PCLZIP_OPT_PATH,    $import_path,
                PCLZIP_CB_PRE_EXTRACT,  'preImportCallBack') == 0) {
                echo 'Cannot extract to $import_path';
                clr_dir($import_path);
                exit;
            }else {
                echo "<BR>Extract Complete";
            }
     
     if (!isset($session['filenameComEbook']) || count($session['filenameComEbook'])==0)
     {
        $session['filenameComEbook'] = array($fileName);
    }else{
        $filenameComArr = $session['filenameComEbook'];
        $filenameComArr[] = $fileName;
        $session['filenameComEbook'] = $filenameComArr;
    }

     copy('C:\inetpub\wwwroot\lms_thoresen\uploads\main.js', 'C:\inetpub\wwwroot\lms_thoresen\uploads\ebook'.'\\'.$cid.'\mobile\javascript\main.js');

    unlink($_FILES['Filedata']['tmp_name']);
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

    public function actionTestlist()
    {
        $model=new Lesson('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Lesson']))
            $model->attributes=$_GET['Lesson'];

        $this->render('testlist',array(
            'model'=>$model,
        ));
    }

    public function actionDownload($id)
    {
        $fileDoc = FileDoc::model()->findByPK($id);
        if($fileDoc){
            // $webroot = Yii::app()->getUploadPath('filedoc');
            $webroot = Yii::app()->basePath."/../../uploads/filedoc/";
            $uploadDir = $webroot;
            $filename = $fileDoc->filename;
            $filename = $uploadDir.$filename;
            // var_dump($filename);
            // exit;
            if (file_exists($filename)) {
                return Yii::app()->request->sendFile($fileDoc->file_name, file_get_contents($filename));
            }else{
                throw new CHttpException(404, 'The requested page does not exist.');
            }

        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionDownloadPdf($id)
    {
        $filePdf = FilePdf::model()->findByPK($id);
        if($filePdf){
            // $webroot = Yii::app()->getUploadPath('filepdf');
            $webroot = Yii::app()->basePath.'/../../uploads/filepdf/';
            $uploadDir = $webroot;
            $filename = $filePdf->filename;
            $filename = $uploadDir.$filename;
            // var_dump($filename);
            // exit;
            if (file_exists($filename)) {
                return Yii::app()->request->sendFile($filePdf->file_name, file_get_contents($filename));
            }else{
                throw new CHttpException(404, 'The requested page does not exist.');
            }

        }else{
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function actionEditName()
    {
        $fileDoc = FileDoc::model()->findByPK($_GET['id']);
        if($fileDoc){
            $fileDoc->file_name = $_GET['name'];
            $fileDoc->save();
        }
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

    public function loadFileDocModel($id)
    {
        $model=Lesson::model()->with('fileDocs')->findByPk($id);        
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadFileAudioModel($id)
    {
        $model=Lesson::model()->with('fileAudio')->findByPk($id);        
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadFilePdfModel($id)
    {
        $model=Lesson::model()->with('filePdf')->findByPk($id);        
        // if($model===null)
        //     throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function loadFileScormModel($id)
    {
        $model=Lesson::model()->with('fileScorm')->findByPk($id);
        // if($model===null)
        //     throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

     public function loadFileEbookModel($id)
    {
        $model=Lesson::model()->with('fileebook')->findByPk($id);
        // if($model===null)
        //     throw new CHttpException(404,'The requested page does not exist.');
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

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
