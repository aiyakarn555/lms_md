<?php

/**
 * This is the model class for table "v_room".
 *
 * The followings are the available columns in table 'v_room':
 * @property integer $id
 * @property string $name
 * @property string $attendeePw
 * @property string $moderatorPw
 * @property string $welcomeMsg
 */
class VRoom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VRoom the static model class
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
		return 'v_room';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, attendeePw, moderatorPw, name_EN, pic_vroom', 'length', 'max'=>255),
			//array('name_EN', 'match', 'pattern' => '/^[A-Za-z_0-9]+$/u','message' => UserModule::t("Variable name may consist of A-z, 0-9, underscores, begin with a letter.")),
			array('name, welcomeMsg , start_learn_room , end_learn_room, status_key,name_EN', 'safe'),
			array('number_learn', 'numerical', 'integerOnly'=>true),
			// array('name,start_learn_room , end_learn_room', 'required'),
			
			//array('name, name_EN', 'required'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, attendeePw, moderatorPw, welcomeMsg,status_key, name_EN', 'safe', 'on'=>'search'),
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
			'docs'=> array(self::HAS_MANY, 'VRoomDoc', 'room_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'ชื่อห้องเรียน TH',
			'name_EN' => 'ชื่อห้องเรียน EN',
			'attendeePw' => 'Attendee Pw',
			'moderatorPw' => 'Moderator Pw',
			'welcomeMsg' => 'ข้อความต้อนรับ',
			'ckeck_key' => 'รหัสในการเข้าห้องเรียน',
			'number_learn' => 'จำนวนคนที่สามารถเข้าเรียนได้',
			'start_learn_room' => 'วันที่เริ่มต้นการเรียน',
			'end_learn_room' => 'วันที่สิ้นสุดการเรียน',
			'active' => 'สถานะ',
			'status_key' => 'ปิด / เปิด สิทธิในการเข้าเรียน',
			'show_key' => 'แสดง รหัสในการเข้าห้องเรียน',
            'pic_vroom'=>'รูปภาพ',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_EN',$this->name_EN,true);
		$criteria->compare('attendeePw',$this->attendeePw,true);
		$criteria->compare('moderatorPw',$this->moderatorPw,true);
		$criteria->compare('welcomeMsg',$this->welcomeMsg,true);
		$criteria->compare('active',y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getvroomList(){
		$model = VRoom::model()->findAll(array(
                      'condition' => 'active = :active',
                      'params'    => array(':active' => 'y')
                  ));
		$list = CHtml::listData($model,'id','name');
		return $list;
	}


}