<?php

/**
 * This is the model class for table "cometchat".
 *
 * The followings are the available columns in table 'cometchat':
 * @property string $id
 * @property string $from
 * @property string $to
 * @property string $message
 * @property string $sent
 * @property integer $read
 * @property integer $direction
 */
class Cometchat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cometchat the static model class
	 */
	public $nameSearch;
	public $dateRang;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cometchat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, message', 'required'),
			array('read, direction', 'numerical', 'integerOnly'=>true),
			array('from, to, sent', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, message, sent, read, direction,dateRang, nameSearch', 'safe', 'on'=>'search'),
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
			'from_rel' => array(self::BELONGS_TO, 'Users', 'from'),
			'to_rel' => array(self::BELONGS_TO, 'Users', 'to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from' => 'From',
			'to' => 'To',
			'message' => 'Message',
			'sent' => 'Sent',
			'read' => 'Read',
			'direction' => 'Direction',
			'nameSearch' => 'ชื่อ - นามสกุล',
			'dateRang' => 'เลือกระยะเวลา',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('sent',$this->sent,true);
			// $criteria->compare('read',$this->read,true);
			// $criteria->compare('direction',$this->direction,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}