<?php

/**
 * This is the model class for table "{{passcours_log}}".
 *
 * The followings are the available columns in table '{{passcours_log}}':
 * @property integer $pclog_id
 * @property integer $pclog_userid
 * @property string $pclog_event
 * @property integer $pclog_target
 * @property string $pclog_date
 */
class PasscoursLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{passcours_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pclog_userid, pclog_target', 'numerical', 'integerOnly'=>true),
			array('pclog_event', 'length', 'max'=>50),
			array('pclog_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pclog_id, pclog_userid, pclog_event, pclog_target, pclog_date, gen_id', 'safe', 'on'=>'search'),
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
			'Profiles' => array(self::BELONGS_TO, 'Profile', array('pclog_userid'=>'user_id')),
			'Course' => array(self::BELONGS_TO, 'Passcours', array('pclog_target'=>'passcours_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pclog_id' => 'Pclog',
			'pclog_userid' => 'Pclog Userid',
			'pclog_event' => 'Pclog Event',
			'pclog_target' => 'Pclog Target',
			'pclog_date' => 'Pclog Date',
			'gen_id' => 'gen_id',

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

		$criteria->with = array('Course');

		$criteria->compare('pclog_id',$this->pclog_id);
		$criteria->compare('pclog_userid',$this->pclog_userid);
		$criteria->compare('pclog_event',$this->pclog_event,true);
		$criteria->compare('pclog_target',$this->pclog_target);
		$criteria->compare('pclog_date',$this->pclog_date,true);
		$criteria->compare('gen_id',$this->gen_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasscoursLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCurrentCourse() {

		$sql = " select * from tbl_passcours_log";
		$sql .= " join tbl_passcours on tbl_passcours.passcours_id = tbl_passcours_log.pclog_target";
		$sql .= " join tbl_course_online on tbl_course_online.course_id = tbl_passcours.passcours_cours";

		$sql .= " group by tbl_passcours.passcours_cours";

		$sql .= " order by tbl_course_online.cate_course";

		$query = Yii::app()->db->createCommand($sql)->queryAll();

        return new CSqlDataProvider($query, $poviderArray);

	}
}
