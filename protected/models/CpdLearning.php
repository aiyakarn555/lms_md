<?php

/**
 * This is the model class for table "{{cpd_learning}}".
 *
 * The followings are the available columns in table '{{cpd_learning}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property string $pic_id_card
 * @property string $create_date
 */
class CpdLearning extends CActiveRecord
{
	public $pic_file;
	public $course_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cpd_learning}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id', 'numerical', 'integerOnly'=>true),
			array('pic_id_card,course_id', 'length', 'max'=>255),
			array('create_date,course_id', 'safe'),
			array('pic_file', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			// array('pic_file','required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, course_id, pic_id_card,pic_file,course_id, create_date', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'course_id' => 'Course',
			'pic_id_card' => 'Pic Id Card',
			'create_date' => 'Create Date',
			'pic_file'=>'บัตรประชาชน'
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('pic_id_card',$this->pic_id_card,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CpdLearning the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
