<?php

/**
 * This is the model class for table "{{report_problem}}".
 *
 * The followings are the available columns in table '{{report_problem}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $tel
 * @property string $report_type
 * @property string $report_title
 * @property string $report_detail
 * @property string $report_pic
 * @property string $report_date
 * @property string $accept_report_date
 * @property string $status
 * @property string $answer
 */
class ReportProblem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{report_problem}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, email, tel, report_type, report_title, report_pic, report_course', 'length', 'max'=>255),
			array('status', 'length', 'max'=>7),
			array('report_pic', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
			array('report_detail, report_date, accept_report_date, answer', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, firstname, lastname, email, tel, report_type, report_title, report_detail, report_pic, report_date, accept_report_date, status, answer, report_course', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'email' => 'Email',
			'tel' => 'Tel',
			'report_type' => 'Report Type',
			'report_title' => 'Report Title',
			'report_detail' => 'Report Detail',
			'report_pic' => 'Report Pic',
			'report_date' => 'Report Date',
			'accept_report_date' => 'Accept Report Date',
			'status' => 'Status',
			'answer' => 'Answer',
			'report_course'=> 'report_course',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('report_type',$this->report_type,true);
		$criteria->compare('report_title',$this->report_title,true);
		$criteria->compare('report_detail',$this->report_detail,true);
		$criteria->compare('report_pic',$this->report_pic,true);
		$criteria->compare('report_date',$this->report_date,true);
		$criteria->compare('accept_report_date',$this->accept_report_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('report_course',$this->report_course,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReportProblem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
