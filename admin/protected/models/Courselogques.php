<?php

/**
 * This is the model class for table "{{logques}}".
 *
 * The followings are the available columns in table '{{logques}}':
 * @property integer $logques_id
 * @property integer $score_id
 * @property integer $ques_id
 * @property integer $user_id
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Courselogques extends CActiveRecord
{
    public $typeOfUser;
    public $typeuser;
    public $university;
    public $company;
    public $categoryUniversity;
    public $categoryCompany;
    public $dateRang;
    public $period_start;
    public $period_end;
    public $course;
    public $department;
    public $nameSearch;
    public $user_id;
    public $company_id;
    public $division_id;
    public $position_id;
    public $courseArray;
    public $course_id;
    public $learnStatus;
    public $generation;
    public $search;
    public $lesson_id;
    public $email;
    public $searchAll;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Logques the static model class
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
        return '{{courselogques}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('score_id, ques_id, user_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
            array('active', 'length', 'max'=>1),
            array('create_date, update_date, test_type, ques_type, logques_text , check', 'safe'),

            array('period_start,period_end,typeOfUser,dateRang,course,nameSearch,university,company,categoryUniversity,categoryCompany,company_id,division_id,position_id,course_id,email,searchAll', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logques_id, score_id, ques_id, user_id, create_date, create_by, update_date, update_by, active, test_type, ques_type , logques_text , check', 'safe', 'on'=>'search'),
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
            'questions'=>array(self::BELONGS_TO, 'Coursequestion', 'ques_id'),
            'choice' => array(self::BELONGS_TO, 'CourseChoice', array('choice_id'=>'choice_id')),
            'user'=>array(self::BELONGS_TO, 'Users', 'user_id'),
            'member'=>array(self::BELONGS_TO, 'Profiles', 'user_id'),
            'courseOnline'=>array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
            'Coursescore'=>array(self::BELONGS_TO, 'Coursescore', 'score_id'),
        );
    }

    public function beforeSave()
    {
        if(null !== Yii::app()->user && isset(Yii::app()->user->id))
            $id = Yii::app()->user->id;
        else
            $id = 0;

        if($this->isNewRecord){
            $this->create_by = $id;
            $this->create_date = date("Y-m-d H:i:s");
            $this->update_by = $id;
            $this->update_date = date("Y-m-d H:i:s");
        }else{
            $this->update_by = $id;
            $this->update_date = date("Y-m-d H:i:s");
        }
        return parent::beforeSave();
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'logques_id'  => 'Logques',
            'score_id'    => 'Score',
            'ques_id'     => 'Ques',
            'user_id'     => 'User',
            'test_type'   => 'Test Type',
            'ques_type'   => 'Question Type',
            'create_date' => 'Create Date',
            'create_by'   => 'Create By',
            'update_date' => 'Update Date',
            'update_by'   => 'Update By',
            'active'      => 'Active',
            'logques_text' => 'Logchoice Text',
            'check' => 'check',

            'searchAll' => 'รายชื่อผู้เรียน , E-mail , เลขบัตรประชาชน',
            'typeOfUser' => 'ประเภทของสมาชิก',
            'dateRang' => 'เลือกระยะเวลา',
            'course' => 'หลักสูตร',
            'nameSearch' => 'รายชื่อผู้เรียน',
            'company_id' => 'หน่วยงาน',
            'division_id' => 'ศูนย์/แผนก',
            'position_id' => 'ตำแหน่ง',
            'search' => 'ค้นหา',
            'period_start' => 'วันที่เริ่มต้น',
            'period_end' => 'วันที่สิ้นสุด',
            'generation' => 'เลือกรุ่น',
            'course_id' => 'เลือกหลักสูตร',
            'lesson_id' => 'เลือกหลักสูตร',
            'email' => 'อีเมลล์ผู้ใช้'
        );
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

        // $criteria->compare('logques_id',$this->logques_id);
        // $criteria->compare('score_id',$this->score_id);
        // $criteria->compare('ques_id',$this->ques_id);
        // $criteria->compare('user_id',$this->user_id);
        // $criteria->compare('test_type',$this->test_type,true);
        // $criteria->compare('ques_type',$this->ques_type,true);
        // $criteria->compare('create_date',$this->create_date,true);
        // $criteria->compare('create_by',$this->create_by);
        // $criteria->compare('update_date',$this->update_date,true);
        // $criteria->compare('update_by',$this->update_by);
        // $criteria->compare('active',$this->active,true);

        $criteria->compare('logques_id',$this->logques_id);
        $criteria->with = array('user','member','questions','courseOnline');
        $criteria->compare('score_id',$this->score_id);
        $criteria->compare('ques_id',$this->ques_id);
        $criteria->compare('t.user_id',$this->user_id);

        if($this->course_id != null){
        $criteria->compare('t.course_id',$this->course_id);
        }
        if($this->email != null){
            $criteria->compare('email',$this->email,true);
        }
        if($this->dateRang != null && $this->dateRang != ""){
            
            $criteria->addCondition('t.create_date >= "'.$this->period_start.'" ');
            $criteria->addCondition('t.create_date <= "'.$this->period_end.'" ');
        }

        $criteria->compare('test_type',$this->test_type,true);
        $criteria->compare('t.ques_type',$this->ques_type,true);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('create_by',$this->create_by);
        $criteria->compare('update_date',$this->update_date,true);
        $criteria->compare('update_by',$this->update_by);
        $criteria->compare('active',$this->active,true);
        // $criteria->compare('t.check',$this->check);
        $criteria->group = 't.course_id,t.user_id';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}