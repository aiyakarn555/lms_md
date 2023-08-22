<?php

/**
 * This is the model class for table "{{menu_contactus}}".
 *
 * The followings are the available columns in table '{{menu_contactus}}':
 * @property integer $id
 * @property string $label_firstname
 * @property string $label_lastname
 * @property string $label_phone
 * @property string $label_email
 * @property string $label_topic
 * @property string $label_detail
 * @property string $label_button
 * @property integer $lang_id
 * @property integer $parent_id
 */
class MenuContactus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_contactus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_firstname, label_lastname, label_phone, label_email, label_topic, label_detail,label_error_email,label_error_notNull,label_error_invalidData', 'length', 'max'=>255),
			array('label_button', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_firstname, label_lastname, label_phone, label_email, label_topic, label_detail, label_button,label_error_email,label_error_notNull,label_error_invalidData ,lang_id, parent_id', 'safe', 'on'=>'search'),
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
			'label_contactus'=>'ติดต่อเรา',
			'label_homepage'=>'หน้าแรก',
			'label_firstname' => 'ชื่อ',
			'label_lastname' => 'นามสกุล',
			'label_phone' => 'เบอร์โทรศัพท์',
			'label_email' => 'อีเมล์',
			'label_topic' => 'หัวข้อ',
			'label_detail' => 'รายละเอียด',
			'label_button' => 'ส่งข้อความ',
			'label_error_email' => 'รูปแบบอีเมล์ไม่ถูกต้อง',
			'label_error_notNull' => 'ไม่ควรเป็นค่าว่าง',
			'label_error_invalidData'=>'ข้อมูลไม่ถูกต้อง! กรุณากรอกข้อมูลให้ครบ',
			'lang_id' => 'ภาษา',
			'parent_id' => 'Parent',
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
		$criteria->compare('label_firstname',$this->label_firstname,true);
		$criteria->compare('label_lastname',$this->label_lastname,true);
		$criteria->compare('label_phone',$this->label_phone,true);
		$criteria->compare('label_email',$this->label_email,true);
		$criteria->compare('label_topic',$this->label_topic,true);
		$criteria->compare('label_detail',$this->label_detail,true);
		$criteria->compare('label_button',$this->label_button,true);
		$criteria->compare('label_error_email',$this->label_error_email,true);
		$criteria->compare('label_error_notNull',$this->label_error_notNull,true);
		$criteria->compare('label_error_invalidData',$this->label_error_invalidData,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuContactus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
