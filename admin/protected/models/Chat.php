<?php

/**
 * This is the model class for table "chat".
 *
 * The followings are the available columns in table 'chat':
 * @property integer $id
 * @property string $chatcode
 * @property integer $user_from
 * @property integer $time
 * @property integer $view
 * @property string $message
 */
class Chat extends CActiveRecord
{
	public $time_up_from;
	public $dateRang;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chat the static model class
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
		return 'chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chatcode, user_from, time, view, message', 'required'),
			array('user_from, time, view', 'numerical', 'integerOnly'=>true),
			array('chatcode, message', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, chatcode, dateRang,user_from, time, view, message, time_up_from', 'safe', 'on'=>'search'),
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
		// $criteria->compare('user_from!=1');

			'user' => array(self::BELONGS_TO, 'Users', 'user_from','foreignKey' => array('user_from'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'chatcode' => 'Chatcode',
			 'dateRang' => 'เลือกระยะเวลา',
			'user_from' => 'User From',
			'time' => 'Time',
			'view' => 'View',
			'message' => 'ข้อความ',
		);
	}

	public function getDateStart()
	{

		list($start,$end) = explode(" - ",$this->dateRang);
		$start = date("Y-m-d",strtotime($start))." 00:00:00";
		$end = date("Y-m-d",strtotime($end))." 23:59:59";
		$start = strtotime($start);
//		$end  =  strtotime($end);

		return $start;
	}

	public function getDateEnd()
	{
		list($start,$end) = explode(" - ",$this->dateRang);
		$start = date("Y-m-d",strtotime($start))." 00:00:00";
		$end = date("Y-m-d",strtotime($end))." 23:59:59";
//		$start = strtotime($start);
		$end  =  strtotime($end);
		return $end;
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
		$criteria->with=array('user');
		$criteria->compare('chatcode',$this->chatcode,true);
		$criteria->compare('user_from',$this->user_from);
		if($_GET['Chat']!=""){
			$criteria->addBetweenCondition('time',$this->DateStart,$this->DateEnd);
		}
		$criteria->compare('view',$this->view);
		$criteria->compare('message',$this->message,true);
		$criteria->addCondition('user.id != 1');
		$criteria->group='user_from';
		// $criteria->group='chatcode'; order by
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}