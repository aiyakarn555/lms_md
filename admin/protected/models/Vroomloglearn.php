<?php

/**
 * This is the model class for table "v_room_loglearn".
 *
 * The followings are the available columns in table 'v_room_loglearn':
 * @property integer $id
 * @property integer $user_id
 * @property integer $v_room_id
 * @property string $time_learn_start
 * @property string $time_learn_end
 * @property string $active
 */
class Vroomloglearn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vroomloglearn the static model class
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
		return 'v_room_loglearn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, v_room_id', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('time_learn_start, time_learn_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, v_room_id, time_learn_start, time_learn_end, active', 'safe', 'on'=>'search'),
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
			'v_room_id' => 'V Room',
			'time_learn_start' => 'Time Learn Start',
			'time_learn_end' => 'Time Learn End',
			'active' => 'Active',
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
		$criteria->compare('v_room_id',$this->v_room_id);
		$criteria->compare('time_learn_start',$this->time_learn_start,true);
		$criteria->compare('time_learn_end',$this->time_learn_end,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}