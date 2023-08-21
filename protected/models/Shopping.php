<?php

/**
 * This is the model class for table "{{shopping}}".
 *
 * The followings are the available columns in table '{{shopping}}':
 * @property integer $id
 * @property integer $shoptype_id
 * @property string $shop_name
 * @property string $shop_short_detail
 * @property string $shop_detail
 * @property integer $price
 * @property string $shop_picture
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Shopping extends CActiveRecord implements IECartPosition
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shopping the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    function getId()
    {
        return $this->id;
    }
 
    function getPrice()
    {
        return $this->price;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shopping}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shoptype_id, price, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('shop_name', 'length', 'max'=>100),
			array('shop_short_detail', 'length', 'max'=>255),
			array('shop_picture', 'length', 'max'=>200),
			array('active', 'length', 'max'=>1),
			array('shop_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, shoptype_id, shop_name, shop_short_detail, shop_detail, price, shop_picture, create_date, create_by, update_date, update_by, active, shop_number, shop_status', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'OrderDetail', 'shop_id'),
			'shoptype' => array(self::BELONGS_TO, 'Shoptype', 'shoptype_id'),
		);
	}

    public function afterFind() 
    {
    	$this->shop_name = CHtml::decode($this->shop_name);
    	$this->shop_short_detail = CHtml::decode($this->shop_short_detail);
    	$this->shop_detail = CHtml::decode($this->shop_detail);
        return parent::afterFind();
    }

	public function defaultScope()
	{
		$alias = $this->getTableAlias(false,false);
	    return array(
	    	'order' => $alias.'.id desc',
	    	'condition' => $alias.'.active = "y"',
	    );
	}

	public function scopes()
    {
        return array(
            'showshop'=>array(
                'condition'=>' shop_status = 1',
            ),
            'promotions'=>array(
                'condition'=>' shop_promotion = 1 ',
            ),
        );
    }

	public function getBuyItem()
	{
		$link = CHtml::link('สั่งซื้อ',array('//Shopping/cart','id'=>$this->id),array(
			'class'=>'btn btn-primary btn-icon glyphicons ok_2'
		));
		return $link;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Datailhead'=>'หัวข้อ',
			'id' => 'รหัสสินค้า',
			'shop_number' => 'รหัสสินค้า',
			'shoptype_id' => 'หมวดสินค้า',
			'shop_name' => 'ชื่อสินค้า',
			'shop_short_detail' => 'รายละเอียดย่อ',
			'shop_detail' => 'รายละเอียดสินค้า',
			'price' => 'ราคาสินค้า',
			'shop_picture' => 'รูปภาพประกอบ',
			'shop_status' => 'สินค้าแนะนำ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function getImageCheck()
	{
		$imageCateCourse = Controller::ImageShowIndex(Yush::SIZE_THUMB,$this,$this->shop_picture,array());
		return CHtml::link($imageCateCourse, array('shopping/view', 'id'=>$this->id),array(
			'class'=>'thumbnail'
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if($id !== null){
			$criteria->compare('shoptype_id',$id,false);
		}
		$criteria->compare('shop_name',$this->shop_name,true);
		$criteria->compare('shop_number',$this->shop_number,true);
		$criteria->compare('shop_short_detail',$this->shop_short_detail,true);
		$criteria->compare('shop_detail',$this->shop_detail,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('shop_picture',$this->shop_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('shop_status',$this->shop_status,true);

		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}
}