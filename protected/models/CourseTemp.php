<?php

/**
 * This is the model class for table "{{course_temp}}".
 *
 * The followings are the available columns in table '{{course_temp}}':
 * @property integer $id
 * @property integer $course_id
 * @property integer $gen_id
 * @property integer $user_id
 * @property integer $user_confirm
 * @property string $create_date
 * @property string $status
 * @property string $date_confirm
 */
class CourseTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_temp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, gen_id, user_id, user_confirm', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			array('create_date, date_confirm', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, course_id, gen_id, user_id, user_confirm, create_date, status, date_confirm', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'course_id' => 'Course',
			'gen_id' => 'Gen',
			'user_id' => 'User',
			'user_confirm' => 'User Confirm',
			'create_date' => 'Create Date',
			'status' => 'Status',
			'date_confirm' => 'Date Confirm',
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
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_confirm',$this->user_confirm);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_confirm',$this->date_confirm,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
