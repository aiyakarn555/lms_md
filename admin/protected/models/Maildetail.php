<?php

/**
 * This is the model class for table "{{maildetail}}".
 *
 * The followings are the available columns in table '{{maildetail}}':
 * @property integer $id
 * @property string $mail_title
 * @property string $mail_detail
 * @property string $create_date
 * @property string $active
 */
class Maildetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Maildetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{maildetail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail_title, mail_detail', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mail_title, mail_detail, create_date, active', 'safe', 'on'=>'search'),
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
			'mailfile' => array(self::HAS_MANY, 'Mailfile', 'maildetail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mail_title' => 'หัวข้ออีเมล์',
			'mail_detail' => 'รายละเอียด',
			'create_date' => 'วันที่สร้าง',
			'active' => 'Active',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('mail_title',$this->mail_title,true);
		$criteria->compare('mail_detail',$this->mail_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	public function beforeSave()
	{
			$this->create_date = date("Y-m-d H:i:s");

		return parent::beforeSave();
	}
}