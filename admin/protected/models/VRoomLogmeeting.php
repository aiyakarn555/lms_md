<?php

/**
 * This is the model class for table "v_room_logmeeting".
 *
 * The followings are the available columns in table 'v_room_logmeeting':
 * @property integer $id
 * @property string $fullname
 * @property integer $v_room_id
 * @property string $time
 * @property string $event
 * @property string $active
 */
class VRoomLogmeeting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_room_logmeeting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('v_room_id', 'numerical', 'integerOnly'=>true),
			array('fullname, event', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fullname, v_room_id, time, event, active', 'safe', 'on'=>'search'),
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
			'VRooms' => array(self::BELONGS_TO, 'VRoom', 'v_room_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ห้องประชุม',
			'fullname' => 'ชื่อผู้เข้าประชุม',
			'v_room_id' => 'ห้องประชุม',
			'time' => 'เวลา',
			'event' => 'Event',
			'active' => 'Active',
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
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('v_room_id',$this->v_room_id);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('active','y',true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VRoomLogmeeting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
