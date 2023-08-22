<?php

/**
 * This is the model class for table "{{log_startcourse}}".
 *
 * The followings are the available columns in table '{{log_startcourse}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property string $start_date
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property string $end_date
 */
class LogStartcourse extends CActiveRecord
{
	public $news_per_page;
	public $search_name;
	public $type_employee;
	public $position_id;
	public $department_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_startcourse}}';
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('start_date, create_date, update_date, end_date, news_per_page', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, course_id, start_date, create_date, create_by, update_date, update_by, active, end_date, search_name,type_employee , position_id, department_id', 'safe', 'on'=>'search'),
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
			'pro' => array(self::BELONGS_TO, 'Profile', 'user_id'),
			'mem' => array(self::BELONGS_TO, 'User', 'user_id','foreignKey' => array('user_id'=>'id')),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'gen' => array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
			'pass' => array(self::BELONGS_TO, 'Passcours', 'course_id','foreignKey' => array('course_id'=>'passcours_cours')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'course_id' => 'Course',
			'start_date' => 'Start Date',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'end_date' => 'End Date',
			'type_employee' => 'ประเภทพนักงาน',
			'position_id' => 'ตำแหน่ง',
			'department_id' => 'แผนก',
			'search_name' => 'ชื่อ-สกุล',//, เลขบัตรประชาชน-พาสปอร์ต
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('course','pro','mem');
		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('t.course_id',$this->course_id);
		$criteria->compare('t.gen_id',$this->gen_id,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('pro.type_employee',$this->type_employee,true);
		$criteria->compare('position_id',$this->position_id,true);
		$criteria->compare('department_id',$this->department_id,true);

		$criteria->compare('CONCAT(pro.firstname , " " , pro.lastname , " ", " ", user.username," ",pro.firstname_en , " " , pro.lastname_en ," ", " ", user.identification, " ", pro.passport)',$this->search_name,true);
		$criteria->order = 'courseonline.course_title ASC, gen_id ASC';

		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
		$poviderArray = array('criteria' => $criteria);

        // Page
        if (isset($this->news_per_page)) {
            $poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
        } else {
            $poviderArray['pagination'] = array('pageSize' => intval(20));
        }

        return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogStartcourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
