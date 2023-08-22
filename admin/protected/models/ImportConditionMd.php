<?php

/**
 * This is the model class for table "{{import_condition_md}}".
 *
 * The followings are the available columns in table '{{import_condition_md}}':
 * @property integer $id
 * @property string $idcard
 * @property string $title
 * @property string $fname
 * @property string $lname
 * @property integer $institution_id
 * @property integer $course_md_id
 * @property string $instructor_name
 */
class ImportConditionMd extends CActiveRecord
{
    public $fullname;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{import_condition_md}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('institution_id, course_md_id', 'numerical', 'integerOnly'=>true),
			array('idcard, title, fname, lname, instructor_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idcard, title, fname, lname, institution_id, course_md_id, instructor_name', 'safe', 'on'=>'search'),
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
			'idcard' => 'รหัสบัตรประชาชน',
			'title' => 'Title',
			'fname' => 'Fname',
			'lname' => 'Lname',
			'institution_id' => 'Institution',
			'course_md_id' => 'Course Md',
			'instructor_name' => 'Instructor Name',
			'fullname' => 'ชื่อ - นามสกุล',

			
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
		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('fname',$this->fname,true);
		$criteria->compare('lname',$this->lname,true);
		$criteria->compare('institution_id',$this->institution_id);
		$criteria->compare('course_md_id',$this->course_md_id);
		$criteria->compare('instructor_name',$this->instructor_name,true);
		$criteria->compare('CONCAT(fname , " " , lname)',$this->fullname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImportConditionMd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
