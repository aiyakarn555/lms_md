<?php

/**
 * This is the model class for table "cometchat_status".
 *
 * The followings are the available columns in table 'cometchat_status':
 * @property string $userid
 * @property string $message
 * @property string $status
 * @property string $typingto
 * @property string $typingtime
 * @property string $isdevice
 * @property string $lastactivity
 */
class CometchatStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CometchatStatus the static model class
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
		return 'cometchat_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'required'),
			array('userid, typingto, typingtime, lastactivity', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('isdevice', 'length', 'max'=>1),
			array('message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userid, message, status, typingto, typingtime, isdevice, lastactivity', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'message' => 'Message',
			'status' => 'Status',
			'typingto' => 'Typingto',
			'typingtime' => 'Typingtime',
			'isdevice' => 'Isdevice',
			'lastactivity' => 'Lastactivity',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('typingto',$this->typingto,true);
		$criteria->compare('typingtime',$this->typingtime,true);
		$criteria->compare('isdevice',$this->isdevice,true);
		$criteria->compare('lastactivity',$this->lastactivity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}