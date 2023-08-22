<?php

class Lesson extends AActiveRecord
{
    public $image;
    public $period_start;
    public $period_end;
    public $labelState = false;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{lesson}}';
    }

    public function beforeSave()
    {
        $this->title = CHtml::encode($this->title);
        $this->description = CHtml::encode($this->description);
        $this->content = CHtml::encode($this->content);

        if(null !== Yii::app()->user && isset(Yii::app()->user->id))
        {
            $id = Yii::app()->user->id;
        }
        else
        {
            $id = 0;
        }

        if($this->isNewRecord)
        {
            $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
            $this->update_by = $id;
            $this->update_date = date("Y-m-d H:i:s");
        }
        else
        {
            $this->update_by = $id;
            $this->update_date = date("Y-m-d H:i:s");
        }

        return parent::beforeSave();
    }

    public function afterFind()
    {
        $this->title = CHtml::decode($this->title);
        $this->description = CHtml::decode($this->description);
        $this->content = CHtml::decode($this->content);

        return parent::afterFind();
    }

    public function rules()
    {
        return array(
            array('course_id, title, cate_amount,cate_percent, view_all', 'required' ),
            array('course_id', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            // array('description', 'length', 'max'=>255),
            array('content, create_date, create_by, news_per_page, CountManage, time_test,type,lang_id,parent_id,sequence_id,status,enablefacedetect,intervalfacedetect,popup_detail,verifyfaceperiod', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true),
            array('id, active , course_id, CountManage, title, description, content, time_test,lang_id,parent_id,sequence_id, status,enablefacedetect,intervalfacedetect,popup_detail,verifyfaceperiod', 'safe', 'on'=>'search'),
        );
    }

    public function getConcatCourseLesson()
    {

        return $this->courseonlines->course_title."/".$this->title;

    }

    public function relations()
    {
        return array(
            'courseonlines' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
            'fileCount'=>array(self::STAT, 'File', 'lesson_id'),
            'fileDocCount'=>array(self::STAT, 'FileDoc', 'lesson_id'),
            'files' => array(self::HAS_MANY, 'File', 'lesson_id'),
            'fileDocs'=> array(self::HAS_MANY, 'FileDoc', 'lesson_id'),
            'filePdf'=> array(self::HAS_MANY, 'FilePdf', 'lesson_id'),
            'fileScorm'=> array(self::HAS_MANY, 'FileScorm', 'lesson_id'),
            'fileebook'=> array(self::HAS_MANY, 'FileEbook', 'lesson_id'),
            'fileAudio'=> array(self::HAS_MANY, 'FileAudio', 'lesson_id'),
            'documents' => array(self::HAS_MANY, 'Document', 'lesson_id'),
            'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
            'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
            'header'=>array(self::BELONGS_TO, 'QHeader', 'header_id'),
            'manages'=>array(self::HAS_MANY, 'Manage', 'id'),
            'LessonRelateLearn' => array(self::HAS_MANY, 'Learn', 'lesson_id'),
            'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
            'Schedules' => array(self::BELONGS_TO, 'Schedule', 'course_id'),
        );
    }

    public function attributeLabels()
    {
        if(!$this->labelState){
            $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        }
        // $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        $lang = Language::model()->findByPk($this->lang_id);
        $mainLang = $lang->language;
        $label_lang = ' (ภาษา '.$mainLang.' )';
        return array(
            'id'           => 'หมวดหมู่'.$label_lang,
            'course_id'    => 'หลักสูตรอบรมออนไลน์',
            'title'        => 'ชื่อบทเรียน'.$label_lang,
            'description'  => 'รายละเอียดย่อ'.$label_lang,
            'content'      => 'เนื้อหา'.$label_lang,
            'image'        => 'รูปภาพ'.$label_lang,
            'cate_amount'  => 'จำนวนครั้งที่สามารถทำข้อสอบได้'.$label_lang,
            'cate_percent' => 'เปอร์เซ็นในการผ่านของบท (หลังเรียน)'.$label_lang,
            'create_date'  => 'วันที่เพิ่มข้อมูล'.$label_lang,
            'create_by'    => 'ผู้เพิ่มข้อมูล'.$label_lang,
            'update_date'  => 'วันที่แก้ไขข้อมูล'.$label_lang,
            'update_by'    => 'ผู้แก้ไขข้อมูล'.$label_lang,
            'active'       => 'สถานะ'.$label_lang,
            'CountGroup'   => 'จำนวนชุด'.$label_lang,
            'filename'     => 'ไฟล์บทเรียน (mp3,mp4)'.$label_lang,
            'doc'          => 'ไฟล์ประกอบบทเรียน (pdf,doc,docx,ppt,pptx)'.$label_lang,
            'time_test'    => 'เวลาในการทำข้อสอบ (ก่อนเรียนและหลังเรียน)'.$label_lang,
            'type'    => 'ชนิดไฟล์บทเรียน'.$label_lang,
            'view_all'     => 'สิทธิ์การดูบทเรียนนี้'.$label_lang,
            'status' => 'เปิด ปิด เฉลยข้อสอบ ',
            'parent_id' => 'เมนูหลัก',
            'lang_id' => 'ภาษา',
            'sequence_id' => 'ลำดับ',
            'enablefacedetect' => 'เปิด-ปิดการตรวจจับใบหน้าระหว่างเรียน',
            'intervalfacedetect' => 'ช่วงเวลาในการตรวจจับ',
            'popup_detail' => 'ข้อความการแจ้งเตือน',
            'verifyfaceperiod' =>'ระยะเวลายืนยันตัวตน'
            
        );
    }

    public function getCountTeacher()
    {
        $count = LessonTeacher::Model()->count("lesson_id=:lesson_id", array(
            "lesson_id"=>$this->id,
        ));
        return $count;
    }

    public function checkScopes($check = 'scopes')
    {
        if ($check == 'scopes')
        {
            $checkScopes =  array(
                'alias' => 'lesson',
                'order' => ' lesson.id DESC ',
                'condition' => ' lesson.active ="y"',// AND courseonlines.active ="y"

            );
        }
        else
        {
            $checkScopes =  array(
                'alias' => 'lesson',
                'order' => ' lesson.id DESC ',
            );
        }

        return $checkScopes;
    }

    public function scopes()
    {
        //========== SET Controller loadModel() ==========//

        $Access = Controller::SetAccess( array("Lesson.*") );
        $user = User::model()->findByPk(Yii::app()->user->id);
        $state = Helpers::lib()->getStatePermission($user);
        if($Access == true)
        {
            $scopes =  array(
                'lessoncheck' => $this->checkScopes('scopes')
            );
        }
        else
        {
            if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
            {
                $scopes =  array(
                    'lessoncheck' => $this->checkScopes('scopes')
                );
            }
            else
            {
                if($state){
                    $scopes = array(
                        'lessoncheck'=>array(
                            'alias' => 'lesson',
                            'condition' => ' lesson.active="y"',
                            'order' => ' lesson.id DESC ',
                        ),
                    );
                }else{
                  $scopes = array(
                    'lessoncheck'=>array(
                        'alias' => 'lesson',
                        'condition' => ' lesson.create_by = "'.Yii::app()->user->id.'" AND lesson.active="y" ',
                        'order' => ' lesson.id DESC ',
                    ),
                );  
              }

                // $scopes = array(
                //     'lessoncheck'=>array(
                //         'alias' => 'lesson',
                //         'condition' => ' lesson.active="y" ',
                //         'order' => ' lesson.id DESC ',
                //     ),
                // );
          }
      }

      return $scopes;
  }

  public function defaultScope()
  {
    $defaultScope =  $this->checkScopes('defaultScope');

    return $defaultScope;
}

public function getCountFile()
{
    $count = File::Model()->count("lesson_id=:lesson_id AND active=:active", array(
        "lesson_id"=>$this->id,"active"=>"y"
    ));
    return $count;
}

public function getCountFileLang($id)
{
    $count = File::Model()->count("lesson_id=:lesson_id AND active=:active AND lang_id = 1", array(
        "lesson_id"=>$id,"active"=>"y"
    ));
    return $count;
}

public function getCountFilePDFLang($id)
{
    $count = FilePdf::Model()->count("lesson_id=:lesson_id AND active=:active AND lang_id = 1", array(
        "lesson_id"=>$id,"active"=>"y"
    ));
    return $count;
}

public function getCountFileScormLang($id)
{
    $count = FileScorm::Model()->count("lesson_id=:lesson_id AND active=:active AND lang_id = 1", array(
        "lesson_id"=>$id,"active"=>"y"
    ));
    return $count;
}

public function getCountFileAudioLang($id)
{
    $count = FileAudio::Model()->count("lesson_id=:lesson_id AND active=:active AND lang_id = 1", array(
        "lesson_id"=>$id,"active"=>"y"
    ));
    return $count;
}

public function getCountTest($type='pre')
{
    $count = Manage::Model()->count("id=:lesson_id AND active=:active AND type=:type", array(
        "lesson_id"=>$this->id, "active"=>"y", "type"=>$type
    ));
    return $count;
}


public function getId()
{
    return $this->id;
}

public static function getChilds($sequence_id)
{
    $data = array();

    $criteria = new CDbCriteria;
    $criteria->addCondition('course_id ="'.$_GET['id'].'"');
    $criteria->addCondition('sequence_id ='.$sequence_id);
    $criteria->addCondition('active = "y"');
    $criteria->addCondition('lang_id = 1');
    $criteria->order='lesson_no';
    $lessonList = Lesson::model()->findAll($criteria);

    foreach($lessonList as $model) {

        $row['text'] = $model->title;
        $row['data'] = $model->id;
        $row['lesson'] = $model->id;
        $row['code'] = $model->id;
        $row['children'] = Lesson::getChilds($model->id);
        $data[] = $row;
    }
    return $data;
}

public function search()
{
    $criteria=new CDbCriteria;
    // $criteria->with = 'courseonlines';
    $criteria->with=array('courseonlines','courseonlines.cates');

        //$criteria->compare('id',$this->id,true);
    $criteria->compare('lesson.course_id',$this->course_id,true);
    $criteria->compare('lesson.title',$this->title,true);
    $criteria->compare('lesson.description',$this->description,true);
    $criteria->compare('lesson.type',$this->type);
    $criteria->compare('lesson.content',$this->content,true);
        // $criteria->compare('parent_id',0);
    $criteria->compare('lesson.lang_id',1);
    $criteria->compare('courseonline.active','y');
    $criteria->compare('categorys.active','y');
    $criteria->compare('lesson.active','y');

    ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
    // $check_user = User::model()->findByPk(Yii::app()->user->id);
    // $group = $check_user->group;
    // $group_arr = json_decode($group);
    // $see_all = 2;
    // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
    //     $see_all = 1;
    // }
    // //////////////////
    // if($see_all != 1){
    //     $criteria->compare('lesson.create_by',Yii::app()->user->id);
    // }else{
    //     $criteria->compare('lesson.create_by',$this->create_by);
    // }

    $modelUser = Users::model()->findByPk(Yii::app()->user->id);
    $group = json_decode($modelUser->group);
    if (!in_array(1, $group)){
        $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
        $criteria->addInCondition('lesson.create_by', $groupUser);	
    }


        // $criteria->order = 'id';
    $criteria->order = 'lesson.create_date DESC';
    $poviderArray = array('criteria'=>$criteria);

        // Page
    if(isset($this->news_per_page))
    {
        $poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
    }

    return new CActiveDataProvider($this, $poviderArray);
}

public function GetfileCount($id)
{
    $file = File::model()->count("lesson_id=:id AND active = 'y' AND lang_id = 1 ",
        array("id" => $id));
    return $file;
}


}
