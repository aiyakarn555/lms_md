<?php

/**
 * This is the model class for table "{{contactus_new}}".
 *
 * The followings are the available columns in table '{{contactus_new}}':
 * @property integer $con_id
 * @property string $con_firstname
 * @property string $con_lastname
 * @property string $con_firstname_en
 * @property string $con_lastname_en
 * @property string $con_position
 * @property string $con_tel
 * @property string $con_email
 * @property string $con_image
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class ContactusNew extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contactus_new}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('con_firstname, con_lastname, con_firstname_en, con_lastname_en, con_position, con_email, con_image, con_position_en', 'length', 'max'=>255),
			array('con_tel', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('con_id, con_firstname, con_lastname, con_firstname_en, con_lastname_en, con_position, con_tel, con_email, con_image, create_date, create_by, update_date, update_by, active, sortOrder, con_position_en', 'safe', 'on'=>'search'),
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
			'id' => 'Con',
			'con_firstname' => 'Con Firstname',
			'con_lastname' => 'Con Lastname',
			'con_firstname_en' => 'Con Firstname En',
			'con_lastname_en' => 'Con Lastname En',
			'con_position' => 'Con Position',
			'con_position_en'=> 'con_position_en',
			'con_tel' => 'Con Tel',
			'con_email' => 'Con Email',
			'con_image' => 'Con Image',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('con_firstname',$this->con_firstname,true);
		$criteria->compare('con_lastname',$this->con_lastname,true);
		$criteria->compare('con_firstname_en',$this->con_firstname_en,true);
		$criteria->compare('con_lastname_en',$this->con_lastname_en,true);
		$criteria->compare('con_position',$this->con_position,true);
		$criteria->compare('con_position_en',$this->con_position_en,true);
		$criteria->compare('con_tel',$this->con_tel,true);
		$criteria->compare('con_email',$this->con_email,true);
		$criteria->compare('con_image',$this->con_image,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactusNew the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
