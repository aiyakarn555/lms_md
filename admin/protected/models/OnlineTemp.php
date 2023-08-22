<?php

/**
 * This is the model class for table "{{online_temp}}".
 *
 * The followings are the available columns in table '{{online_temp}}':
 * @property integer $id
 * @property integer $ms_teams_id
 * @property integer $gen_id
 * @property integer $user_id
 * @property integer $user_confirm
 * @property string $create_date
 * @property string $status
 * @property string $date_confirm
 * @property integer $type_price
 * @property string $file_payment
 */
class OnlineTemp extends CActiveRecord
{
		public $courseTi;
	public $fullname;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{online_temp}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ms_teams_id, gen_id, user_id, user_confirm, type_price', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			array('file_payment', 'length', 'max'=>255),
			array('create_date, date_confirm', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ms_teams_id, gen_id, user_id, user_confirm, create_date, status, date_confirm, type_price, file_payment', 'safe', 'on'=>'search'),
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
			'teams' => array(self::BELONGS_TO, 'MsOnline', 'ms_teams_id'),
			'profile' => array(self::BELONGS_TO, 'Profiles', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ms_teams_id' => 'Ms Teams',
			'gen_id' => 'Gen',
			'user_id' => 'User',
			'user_confirm' => 'User Confirm',
			'create_date' => 'Create Date',
			'status' => 'Status',
			'date_confirm' => 'Date Confirm',
			'type_price' => 'Type Price',
			'file_payment' => 'File Payment',
			'courseTi' => 'ห้องสอบ',
			'fullname' => 'ชื่อ - นามสกุล'
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
		 $criteria->with = array('teams','profile');
		$criteria->compare('id',$this->id);
		$criteria->compare('ms_teams_id',$this->ms_teams_id);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_confirm',$this->user_confirm);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('date_confirm',$this->date_confirm,true);
		$criteria->compare('type_price',$this->type_price);
		$criteria->compare('file_payment',$this->file_payment,true);
		$criteria->compare('CONCAT(profile.firstname , " " , profile.lastname)',$this->fullname,true);
		$criteria->compare('teams.name_ms_teams',$this->courseTi,true);
		$criteria->addCondition('teams.end_date >= :date_now');
		$criteria->params[':date_now'] = date('Y-m-d H:i');
		$criteria->compare('teams.active','y');
		$criteria->compare('t.status','n');




		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MsteamsTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
