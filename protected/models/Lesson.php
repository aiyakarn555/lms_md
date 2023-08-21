<?php

/**
 * This is the model class for table "{{lesson}}".
 *
 * The followings are the available columns in table '{{lesson}}':
 * @property integer $id
 * @property integer $course_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $cate_amount
 * @property integer $cate_percent
 * @property string $image
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Lesson extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lesson the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{lesson}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_id, title', 'required'),
            array('course_id, cate_amount, cate_percent, create_by, update_by', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>80),
            array('description, image', 'length', 'max'=>255),
            array('active', 'length', 'max'=>1),
            array('content, create_date, update_date, time_test,lang_id,parent_id,sequence_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, course_id, title, description, content, cate_amount, cate_percent, image, create_date, create_by, update_date, update_by, active, time_test,lang_id,parent_id,sequence_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'CourseOnlines' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
            'files' => array(self::HAS_MANY, 'File', 'lesson_id'),
            'fileDocs'=> array(self::HAS_MANY, 'FileDoc', 'lesson_id'),
            'filePdf'=> array(self::HAS_MANY, 'FilePdf', 'lesson_id'),
            'fileScorm'=> array(self::HAS_MANY, 'FileScorm', 'lesson_id'),
            'fileEbook'=> array(self::HAS_MANY, 'FileEbook', 'lesson_id'),
            
            'fileAudio'=> array(self::HAS_MANY, 'FileAudio', 'lesson_id'),
            'fileCount'=>array(self::STAT, 'File', 'lesson_id'),
            'fileDocCount'=>array(self::STAT, 'FileDoc', 'lesson_id'),
            'fileScormCount'=>array(self::STAT, 'FileScorm', 'lesson_id'),
            'fileCountEbook'=>array(self::STAT, 'FileEbook', 'lesson_id'),
            
            'filePdfCount'=>array(self::STAT, 'FilePdf', 'lesson_id'),
            'fileAudioCount'=>array(self::STAT, 'FileAudio', 'lesson_id'),
            'creater'=>array(self::BELONGS_TO, 'User', 'create_by'),
            'header'=>array(self::BELONGS_TO, 'QHeader', 'header_id'),
            'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
            // 'lessonParent' =>array(self::BELONGS_TO, 'Lesson', 'parent_id'),
            'lessonParent' =>array(self::BELONGS_TO, 'Lesson', 'sequence_id'),
            'fileCountPdf'=> array(self::STAT, 'FilePdf', 'lesson_id'),
            'Manages'=> array(self::HAS_MANY, 'Manage','id'),
            'LessonLearn' => array(self::HAS_MANY, 'Learn', 'lesson_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'หมวดหมู่',
            'course_id'    => 'หลักสูตรอบรมออนไลน์',
            'title'        => 'ชื่อบทเรียน',
            'description'  => 'รายละเอียดย่อ',
            'content'      => 'เนื้อหา',
            'image'        => 'รูปภาพ',
            'cate_amount'  => 'จำนวนครั้งที่สามารถทำข้อสอบได้',
            'cate_percent' => 'เปอร์เซ็นในการผ่านของบท',
            'create_date'  => 'วันที่เพิ่มข้อมูล',
            'create_by'    => 'ผู้เพิ่มข้อมูล',
            'update_date'  => 'วันที่แก้ไขข้อมูล',
            'update_by'    => 'ผู้แก้ไขข้อมูล',
            'active'       => 'สถานะ',
            'CountGroup'   => 'จำนวนชุด',
            'filename'     => 'ไฟล์บทเรียน (mp3,mp4)',
            'time_test'    => 'เวลาในการทำข้อสอบ',
            'parent_id' => 'เมนูหลัก',
            'lang_id' => 'ภาษา',
        );
    }

    // public function defaultScope()
    // {
    //     return array(
    //         'condition' => ' active = "y" ',
    //     );
    // }

    public function GetfileCount($id)
    {
        $file = File::model()->count("lesson_id=:id AND active = 'y' AND lang_id = 1 ",
            array("id" => $id));
        return $file;
    }

    public function afterFind()
    {
        $this->title = CHtml::decode($this->title);
        $this->description = CHtml::decode($this->description);
        $this->content = CHtml::decode($this->content);
        return parent::afterFind();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('course_id',$this->course_id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('cate_amount',$this->cate_amount);
        $criteria->compare('cate_percent',$this->cate_percent);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('create_by',$this->create_by);
        $criteria->compare('update_date',$this->update_date,true);
        $criteria->compare('update_by',$this->update_by);
        $criteria->compare('active',$this->active,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}