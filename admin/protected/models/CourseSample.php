<?php

/**
 * This is the model class for table "{{course_sample}}".
 *
 * The followings are the available columns in table '{{course_sample}}':
 * @property integer $id
 * @property string $sample_name
 * @property string $sample_detail
 * @property string $file
 * @property integer $active
 * @property string $create_date
 * @property string $update_date
 */
class CourseSample extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_sample}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('sample_name, file', 'length', 'max'=>255),
			array('sample_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sample_name, sample_detail, file, active, create_date, update_date', 'safe', 'on'=>'search'),
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
			'sample_name' => 'ตัวอย่างชื่อ',
			'sample_detail' => 'ตัวอย่างลายละเอียด',
			'file' => 'ไฟล์',
			'active' => 'ทำงาน',
			'create_date' => 'วันที่สร้าง',
			'update_date' => 'วันที่อัพเดท',
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
		$criteria->compare('sample_name',$this->sample_name,true);
		$criteria->compare('sample_detail',$this->sample_detail,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseSample the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
