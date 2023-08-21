<?php

/**
 * This is the model class for table "{{lesson_online}}".
 *
 * The followings are the available columns in table '{{lesson_online}}':
 * @property integer $id
 * @property integer $ms_teams_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property integer $cate_amount
 * @property integer $cate_percent
 * @property integer $header_id
 * @property integer $time_test
 * @property string $image
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property string $view_all
 * @property string $status
 * @property integer $lesson_no
 * @property string $type
 * @property integer $lang_id
 * @property integer $parent_id
 * @property integer $sequence_id
 * @property integer $status_exams_pre
 * @property integer $status_exams_post
 *
 * The followings are the available model relations:
 * @property GrouptestingOnline[] $grouptestingOnlines
 * @property MsOnline $msTeams
 * @property LogquesOnline[] $logquesOnlines
 */
class LessonOnline extends CActiveRecord
{

      public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lesson_online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ms_teams_id, title', 'required'),
            array('ms_teams_id, cate_amount, cate_percent, create_by, update_by', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>80),
            array('description, image', 'length', 'max'=>255),
            array('active', 'length', 'max'=>1),
            array('content, create_date, update_date, time_test,lang_id,parent_id,sequence_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ms_teams_id, title, description, content, cate_amount, cate_percent, image, create_date, create_by, update_date, update_by, active, time_test,lang_id,parent_id,sequence_id', 'safe', 'on'=>'search'),
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
            'msteams' => array(self::BELONGS_TO, 'MsOnline', 'ms_teams_id'),
            'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
            'Manages'=> array(self::HAS_MANY, 'ManageOnline','id'),
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'หมวดหมู่',
            'ms_teams_id'    => 'หลักสูตรอบรมออนไลน์',
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
        $criteria->compare('ms_teams_id',$this->ms_teams_id);
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