<?php

/**
 * This is the model class for table "{{log_sendmail_group}}".
 *
 * The followings are the available columns in table '{{log_sendmail_group}}':
 * @property integer $id
 * @property integer $group_id
 * @property integer $detail_id
 * @property string $status
 */
class LogSendmailGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogSendmailGroup the static model class
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
		return '{{log_sendmail_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, detail_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, group_id, detail_id, status, create_date', 'safe', 'on'=>'search'),
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
			'mailgroup' => array(self::BELONGS_TO, 'Mailgroup', 'group_id'),
			'maildetail' => array(self::BELONGS_TO, 'Maildetail', 'detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => 'กลุ่มอีเมล์',
			'detail_id' => 'แบบร่างอีเมล์',
			'status' => 'สถานะ',
			'mailGroup'=>'กลุ่มอีเมล์',
			'mailTitle'=>'หัวข้อ',
		);
	}


	public function getMailGroup()
	{
		return $this->mailgroup->group_name;
	}

	public function getMailTitle()
	{
		return $this->maildetail->mail_title;
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('detail_id',$this->detail_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('mailTitle',$this->mailTitle,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		$this->create_date = date("Y-m-d H:i:s");

		return parent::beforeSave();
	}

}