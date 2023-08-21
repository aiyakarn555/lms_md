<?php

/**
 * This is the model class for table "{{course_notification}}".
 *
 * The followings are the available columns in table '{{course_notification}}':
 * @property integer $id
 * @property integer $course_id
 * @property integer $generation_id
 * @property integer $notification_time
 * @property string $create_date
 * @property string $update_date
 * @property string $active
 */
class CourseNotification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_notification}}';
	}

	public function getCourseName($id)
	{
		$course_id = explode(',', $id);
		if(is_array($course_id)){
			$datas = $course_id;
			$data = '';
			$i = 1;
			foreach ($datas as $key => $value) {
				$model = CourseOnline::model()->findByPk($value);
				$data .= $i.'. '.$model->course_title;
				$data .= '<br>';
				$i++;
			}
			return $data;
		} else {
			$model = CourseOnline::model()->findByPk($id);
			return $model->course_title;
		}
	}

	public function getDay($date){
		return $date.' วัน';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, generation_id,notification_time','required'),
			array('generation_id, notification_time', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>255),
			array('create_date, update_date, end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, course_id, generation_id, notification_time, create_date,end_date, update_date, active', 'safe', 'on'=>'search'),
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
		    'generation' => array(self::BELONGS_TO, 'Generation', array('generation_id'=>'id_gen')),
		    'courseonlines' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
		    'orgCourses' => array(self::HAS_MANY, 'OrgCourse', array('course_id' => 'course_id')),
		    'Schedules' => array(self::BELONGS_TO, 'Schedule', 'course_id'),
		 );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'course_id' => 'หลักสูตร',
			'generation_id' => 'รุ่น',
			'notification_time' => 'ระยะเวลาแจ้งเตือน',
			'create_date' => 'วันที่สร้าง',
			'update_date' => 'วันที่แก้ไข',
			'active' => 'สถานะ',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('generation_id',$this->generation_id);
		$criteria->compare('notification_time',$this->notification_time);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseNotification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
