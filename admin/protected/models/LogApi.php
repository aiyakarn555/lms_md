<?php

/**
 * This is the model class for table "log_api".
 *
 * The followings are the available columns in table 'log_api':
 * @property integer $log_id
 * @property integer $schedule_id
 * @property string $log_ip
 * @property string $log_event
 * @property string $log_data
 * @property string $log_date
 */
class LogApi extends CActiveRecord
{
	public $news_per_page;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_api';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('schedule_id', 'numerical', 'integerOnly'=>true),
			array('log_ip, log_event', 'length', 'max'=>255),
			array('log_date, log_data, news_per_page', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('log_id, schedule_id, log_ip, log_event, log_data, log_date, news_per_page', 'safe', 'on'=>'search'),
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
			'log_id' => 'Log',
			'schedule_id' => 'Schedule_id',
			'log_ip' => 'Log Ip',
			// 'log_event' => 'Log Event',
			'log_event' => 'กิจกรรม',

			'log_data' => 'Log Data',
			'log_date' => 'Log Date',
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

		$criteria->compare('log_id',$this->log_id);
		$criteria->compare('schedule_id',$this->schedule_id);
		$criteria->compare('log_ip',$this->log_ip,true);
		$criteria->compare('log_event',$this->log_event,true);
		$criteria->compare('log_data',$this->log_data,true);
		$criteria->compare('log_date',$this->log_date,true);
		$criteria->order = 'log_date DESC';

		$poviderArray = array('criteria' => $criteria);

        // Page
        if (isset($this->news_per_page)) {
            $poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
        } else {
            $poviderArray['pagination'] = array('pageSize' => intval(10));
        }

        return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogApi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
