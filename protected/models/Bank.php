<?php

/**
 * This is the model class for table "{{bank}}".
 *
 * The followings are the available columns in table '{{bank}}':
 * @property integer $bank_id
 * @property string $bank_user
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Bank extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bank the static model class
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
		return '{{bank}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('bank_user, bank_name, bank_picture', 'length', 'max'=>255),
			array('bank_number', 'length', 'max'=>30),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bank_id, bank_user, bank_name, bank_number, bank_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'bank_id' => 'Bank',
			'bank_user' => 'ชื่อเจ้าของบัญชี',
			'bank_branch'=>'สาขาธนาคาร',
			'bank_name' => 'ชื่อธนาคาร',
			'bank_number' => 'เลขที่บัญชี',
			'bank_picture' => 'รูปภาพ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

    public function afterFind() 
    {
    	$this->bank_user = CHtml::decode($this->bank_user);
    	$this->bank_name = CHtml::decode($this->bank_name);
    	$this->bank_number = CHtml::decode($this->bank_number);

        return parent::afterFind();
    }

	public function defaultScope()
	{
	    return array(
	    	'alias'=>'bank',
	    	'order' => 'bank.bank_id desc',
	    	'condition' => 'bank.active = "y"',
	    );
	}

	public function getId()
	{
		return $this->bank_id;
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

		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('bank_user',$this->bank_user,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_number',$this->bank_number,true);
		$criteria->compare('bank_picture',$this->bank_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}