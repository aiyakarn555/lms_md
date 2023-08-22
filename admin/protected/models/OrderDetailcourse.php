<?php

/**
 * This is the model class for table "{{order_detailcourse}}".
 *
 * The followings are the available columns in table '{{order_detailcourse}}':
 * @property integer $order_detail_id
 * @property integer $order_id
 * @property integer $shop_id
 * @property string $price
 * @property integer $count
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class OrderDetailcourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderDetailcourse the static model class
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
		return '{{order_detailcourse}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, shop_id, price', 'required'),
			array('order_id, shop_id, count, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('order_detail_id, order_id, shop_id, price, count, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'courses' => array(self::BELONGS_TO, 'Course', 'shop_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_detail_id' => 'Order Detail',
			'order_id' => 'Order',
			'shop_id' => 'Shop',
			'price' => 'Price',
			'count' => 'Count',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
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

		$criteria->compare('order_detail_id',$this->order_detail_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('shop_id',$this->shop_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('count',$this->count);
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