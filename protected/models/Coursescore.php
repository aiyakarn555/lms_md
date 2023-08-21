<?php

/**
 * This is the model class for table "{{score}}".
 *
 * The followings are the available columns in table '{{score}}':
 * @property integer $score_id
 * @property integer $lesson_id
 * @property integer $user_id
 * @property integer $score_number
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Coursescore extends CActiveRecord
{
    public $score_total;
    public $score_max;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Score the static model class
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
        return '{{coursescore}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_id, user_id, score_number,score_total, create_by, update_by', 'numerical', 'integerOnly'=>true),
            array('active', 'length', 'max'=>1),
            array('create_date, update_date, type', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('score_id, course_id, user_id, score_number,score_total, create_date, create_by, update_date, update_by, active, gen_id', 'safe', 'on'=>'search'),
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
            'course'=>array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
            'register'=>array(self::BELONGS_TO, 'RegistrationForm', 'user_id'),
            'Profiles'=>array(self::BELONGS_TO, 'Profile', 'user_id'),
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'Period' => array(self::HAS_MANY, 'CoursePeriod', array( 'id_course' => 'course_id' )),
            'CourseOnlines'=>array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
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
            'score_id'     => 'Score',
            'course_id'    => 'Lesson',
            'user_id'      => 'User',
            'type'         => 'type',
            'score_total'  => 'Score Total',
            'score_number' => 'Score Number',
            'create_date'  => 'Create Date',
            'create_by'    => 'Create By',
            'update_date'  => 'Update Date',
            'update_by'    => 'Update By',
            'active'       => 'Active',
            'gen_id'       => 'gen_id',

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

        $criteria->compare('score_id',$this->score_id);
        $criteria->compare('course_id',$this->course_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('score_total',$this->score_total);
        $criteria->compare('score_number',$this->score_number);
        $criteria->compare('create_date',$this->create_date,true);
        $criteria->compare('create_by',$this->create_by);
        $criteria->compare('update_date',$this->update_date,true);
        $criteria->compare('update_by',$this->update_by);
        $criteria->compare('active',$this->active,true);
        $criteria->compare('gen_id',$this->gen_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}