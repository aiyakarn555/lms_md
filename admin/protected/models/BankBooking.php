<?php

/**
 * This is the model class for table "{{bank_booking}}".
 *
 * The followings are the available columns in table '{{bank_booking}}':
 * @property integer $id
 * @property string $bank_name
 * @property string $account_name
 * @property string $account_number
 * @property string $bank_images
 */
class BankBooking extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bank_booking}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_name, account_name, account_number, bank_images', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bank_name, account_name, account_number, bank_images', 'safe', 'on'=>'search'),
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
			'bank_name' => 'ชื่อธนาคาร',
			'account_name' => 'ชื่อบัญชี',
			'account_number' => 'เลขบัญชี',
			'bank_images' => 'โลโก้ธนาคาร',
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
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('bank_images',$this->bank_images,true);
		$criteria->compare('active','y');
		$criteria->compare('lang_id',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BankBooking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
