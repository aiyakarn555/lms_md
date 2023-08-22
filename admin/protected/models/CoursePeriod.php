<?php

/**
 * This is the model class for table "{{course_period}}".
 *
 * The followings are the available columns in table '{{course_period}}':
 * @property integer $id
 * @property string $id_course
 * @property string $startdate
 * @property string $enddate
 * @property string $hour_accounting
 * @property string $hour_etc
 */
class CoursePeriod extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_period}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('startdate,enddate,id_course,hour_accounting,code', 'required'),
			array('id_course, hour_accounting, hour_etc,code', 'length', 'max'=>255),
			array('startdate, enddate,active', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_course, startdate, enddate,code, hour_accounting, hour_etc,active', 'safe', 'on'=>'search'),
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
		    'course' => array(self::BELONGS_TO, 'CourseOnline', array('id_course'=>'course_id')),
		 );
	}

	public function detailHour($id){
		$model = CoursePeriod::model()->findByPk($id);
		$value = 'ด้านการบัญชีได้ '.(int)$model->hour_accounting.' ชั่วโมง';
		if($model->hour_etc > 0){
			$value .= ' อื่นๆ '.(int)$model->hour_etc.' ชั่วโมง';
		}
		return $value;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_course' => 'หลักสูตร',
			'startdate' => 'วันที่เริ่มใช้',
			'enddate' => 'วันที่สิ้นสุด',
			'hour_accounting' => 'ชั่วโมงด้านบัญชี',
			'hour_etc' => 'ชั่วโมงอื่น ๆ',
			'code' => 'รหัสหลักสูตร'
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
		$criteria->compare('id_course',$this->id_course,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('hour_accounting',$this->hour_accounting,true);
		$criteria->compare('hour_etc',$this->hour_etc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoursePeriod the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
