<?php

/**
 * This is the model class for table "{{passcourse_number}}".
 *
 * The followings are the available columns in table '{{passcourse_number}}':
 * @property integer $id
 * @property integer $passcourse_id
 * @property integer $course_id
 * @property integer $gen_id
 * @property integer $user_id
 * @property string $code_number
 * @property string $created_date
 */
class PasscourseNumber extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{passcourse_number}}';
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$this->created_date = date("Y-m-d H:i:s");
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
			array('passcourse_id, course_id, gen_id, user_id', 'numerical', 'integerOnly'=>true),
			array('code_number', 'length', 'max'=>255),
			array('created_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, passcourse_id, course_id, gen_id, user_id, code_number, created_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'passcourse_id' => 'Passcourse',
			'course_id' => 'Course',
			'gen_id' => 'Gen',
			'user_id' => 'User',
			'code_number' => 'Code Number',
			'created_date' => 'Created Date',
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
		$criteria->compare('passcourse_id',$this->passcourse_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('code_number',$this->code_number,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasscourseNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
