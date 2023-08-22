<?php

/**
 * This is the model class for table "private_message".
 *
 * The followings are the available columns in table 'private_message':
 * @property integer $pm_id
 * @property string $pm_topic
 * @property string $pm_quest
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $pm_to
 * @property string $pm_alert
 * @property integer $question_status
 * @property string $all_file
 */
class PrivateMessage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'private_message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, pm_to, question_status', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			array('pm_alert', 'length', 'max'=>10),
			array('all_file', 'length', 'max'=>255),
			array('pm_topic, pm_quest, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pm_id, pm_topic, pm_quest, create_date , create_by, update_date, update_by, active, pm_to, pm_alert, question_status, all_file', 'safe', 'on'=>'search'),
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
			'msgReturn' => array(self::HAS_MANY, 'PrivateMessageReturn', array('pm_id'=>'pm_id')),
			'fromUser' => array(self::BELONGS_TO, 'User', 'create_by'),
			'toUser' => array(self::BELONGS_TO, 'User', 'pm_to'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pm_id' => 'Pm',
			'pm_topic' => 'Pm Topic',
			'pm_quest' => 'Pm Quest',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'pm_to' => 'Pm To',
			'pm_alert' => 'Pm Alert',
			'question_status' => 'Question Status',
			'all_file' => 'All File',
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

		$criteria = new CDbCriteria;

		// $criteria->order ='update_date DESC';

		$criteria->compare('pm_id',$this->pm_id);
		$criteria->compare('pm_topic',$this->pm_topic,true);
		$criteria->compare('pm_quest',$this->pm_quest,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('pm_to',$this->pm_to);
		$criteria->compare('pm_alert',$this->pm_alert,true);
		$criteria->compare('question_status',$this->question_status);
		$criteria->compare('all_file',$this->all_file,true);

		// $criteria->group = 'create_by ';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria
			// ,
			// 'sort'=>array(
   //          'defaultOrder'=>array(
   //              'order'=>CSort::SORT_DESC,
   //          )
   //      )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PrivateMessage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
