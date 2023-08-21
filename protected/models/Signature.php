<?php

/**
 * This is the model class for table "{{signature}}".
 *
 * The followings are the available columns in table '{{signature}}':
 * @property integer $sign_id
 * @property string $sign_title
 * @property string $sign_position
 * @property integer $sign_hide
 * @property string $sign_path
 * @property string $create_date
 * @property string $create_by
 * @property string $active
 */
class Signature extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{signature}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sign_hide', 'numerical', 'integerOnly'=>true),
			array('sign_title, sign_position, sign_path, create_by', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sign_id, sign_title, sign_position, sign_hide, sign_path, create_date, create_by, active', 'safe', 'on'=>'search'),
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
			'sign_id' => 'Sign',
			'sign_title' => 'ชื่อลายเซ็นต์',
			'sign_position' => 'ตำแหน่ง',
			'sign_hide' => 'เปิด/ปิด การแสดงผล (ไม่ได้ลบนะ ปิดเฉยๆ)',
			'sign_path' => 'path รูป เก็บเฉพาะ folder/img path',
			'create_date' => 'วันที่สร้าง',
			'create_by' => 'id คนสร้าง',
			'active' => 'Active',
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

		$criteria->compare('sign_id',$this->sign_id);
		$criteria->compare('sign_title',$this->sign_title,true);
		$criteria->compare('sign_position',$this->sign_position,true);
		$criteria->compare('sign_hide',$this->sign_hide);
		$criteria->compare('sign_path',$this->sign_path,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Signature the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
