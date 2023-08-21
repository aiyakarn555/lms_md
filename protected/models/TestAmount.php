<?php

/**
 * This is the model class for table "{{test_amount}}".
 *
 * The followings are the available columns in table '{{test_amount}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $lesson_id
 * @property string $create_date
 */
class TestAmount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TestAmount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}



	public function beforeSave()
	{
		if ($this->isNewRecord){
			$this->create_date = new CDbExpression('NOW()');
		}
		return true;
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{test_amount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lesson_id', 'numerical', 'integerOnly'=>true),
			array('create_date,type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, lesson_id,type, create_date', 'safe', 'on'=>'search'),
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
			'lesson_id' => 'Lesson',
			'type' => 'Type',
			'create_date' => 'Create Date',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}