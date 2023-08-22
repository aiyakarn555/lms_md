<?php

/**
 * This is the model class for table "{{menu_privatemessage}}".
 *
 * The followings are the available columns in table '{{menu_privatemessage}}':
 * @property integer $id
 * @property string $label_privatemessage
 * @property string $label_homepage
 * @property string $label_reply
 * @property string $label_sendMess
 * @property integer $lang_id
 */
class MenuPrivatemessage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_privatemessage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('id', 'required'),
			array('id, lang_id', 'numerical', 'integerOnly'=>true),
			array('label_privatemessage, label_homepage', 'length', 'max'=>100),
			array('label_reply, label_sendMess', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_privatemessage, label_homepage, label_reply, label_sendMess,label_createMsg,label_receiver,label_topic,label_detail,label_notification,label_notfiToEmail,label_uploadFile, lang_id', 'safe', 'on'=>'search'),
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
			'label_privatemessage' => 'ข้อความ',
			'label_homepage' => 'หน้าแรก',
			'label_reply' => 'ข้อความตอบกลับ',
			'label_sendMess' => 'ส่งข้อความ',
			'label_createMsg'=> 'สร้างข้อความใหม่',
			'label_receiver'=> 'ผู้รับ',
			'label_topic'=> 'หัวข้อ',
			'label_detail'=> 'รายละเอียด',
			'label_notification'=> 'การแจ้งเตือน',
			'label_notfiToEmail'=> 'แจ้งเตือนไปยังอีเมล์ เมื่อมีการโต้ตอบ (สำหรับหัวข้อนี้)',
			'label_uploadFile'=> 'แนบไฟล์',
			'lang_id' => 'ภาษา',
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
		$criteria->compare('label_privatemessage',$this->label_privatemessage,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_reply',$this->label_reply,true);
		$criteria->compare('label_sendMess',$this->label_sendMess,true);
		$criteria->compare('label_createMsg',$this->label_createMsg,true);
		$criteria->compare('label_receiver',$this->label_receiver,true);
		$criteria->compare('label_topic',$this->label_topic,true);
		$criteria->compare('label_detail',$this->label_detail,true);
		$criteria->compare('label_notification',$this->label_notification,true);
		$criteria->compare('label_notfiToEmail',$this->label_notfiToEmail,true);
		$criteria->compare('label_uploadFile',$this->label_uploadFile,true);
		$criteria->compare('lang_id',$this->lang_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuPrivatemessage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
