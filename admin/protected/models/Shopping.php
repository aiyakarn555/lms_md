<?php

class Shopping extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{shopping}}';
	}

	public function rules()
	{
		return array(
			array('shoptype_id, price, shop_point, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('shop_name', 'length', 'max'=>100),
			array('shop_short_detail', 'length', 'max'=>255),
			array('shop_picture', 'length', 'max'=>200),
			array('shop_number, shop_unit', 'length', 'max'=>20),
			array('shop_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('active', 'length', 'max'=>1),
			array('shop_detail, create_date, update_date , news_per_page', 'safe'),
			array('shop_name, shoptype_id,shop_detail, shop_short_detail,shop_point , price, shop_number, shop_unit, shop_status, shop_tax', 'required'),
			array('id, shoptype_id, shop_point,shop_name, shop_short_detail, shop_detail, price, shop_picture, create_date, create_by, update_date, update_by, active ,shop_number, shop_unit, shop_status, shop_tax', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'shoptype' => array(self::BELONGS_TO, 'Shoptype', 'shoptype_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Shop',
			'shop_number' => 'รหัสสินค้า',
			'shoptype_id' => 'หมวดสินค้า',
			'shop_name' => 'ชื่อสินค้า',
			'shop_unit' => 'หน่วยการเรียกใช้',
			'shop_short_detail' => 'รายละเอียดย่อ',
			'shop_detail' => 'รายละเอียดสินค้า',
			'price' => 'ราคาสินค้า',
			'shop_point'=>'คะแนนสะสม',
			'shop_picture' => 'รูปภาพประกอบ',
			'shop_status' => 'สินค้าแนะนำ',
			'shop_tax' => 'ประเภทการเสียภาษีหรือไม่',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('shoptype_id',$this->shoptype_id);
		$criteria->compare('shop_number',$this->shop_number,true);
		$criteria->compare('shop_name',$this->shop_name,true);
		$criteria->compare('shop_short_detail',$this->shop_short_detail,true);
		$criteria->compare('shop_detail',$this->shop_detail,true);
		$criteria->compare('shop_point',$this->shop_point,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('shop_picture',$this->shop_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('shop_unit',$this->shop_unit,true);
		$criteria->compare('shop_status',$this->shop_status,true);
		$criteria->compare('shop_tax',$this->shop_tax,true);

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
    	$this->shop_name = CHtml::encode($this->shop_name);
    	$this->shop_short_detail = CHtml::encode($this->shop_short_detail);
    	$this->shop_detail = CHtml::encode($this->shop_detail);
    	$this->shop_number = CHtml::encode($this->shop_number);

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}	
		else
		{
			$id = 0;
		}

		if($this->isNewRecord)
		{
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

        return parent::beforeSave();
    }

    public function afterFind() 
    {
    	$this->shop_name = CHtml::decode($this->shop_name);
    	$this->shop_short_detail = CHtml::decode($this->shop_short_detail);
    	$this->shop_detail = CHtml::decode($this->shop_detail);
    	$this->shop_number = CHtml::decode($this->shop_number);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'shoppings',
		    	'condition' => ' shoppings.active = "y" ',
		    	'order' => ' shoppings.id ASC ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'shoppings',
		    	'order' => ' shoppings.id ASC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Shopping.*","Promotion.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'shoppingcheck' => $this->checkScopes('scopes'),
	            'promotions'=>array(
	                'condition'=>' shoppings.shop_promotion = "1" AND shoppings.active = "y" ',
	            ),
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'shoppingcheck' => $this->checkScopes('scopes'),
		            'promotions'=>array(
		                'condition'=>' shoppings.shop_promotion = "1" AND shoppings.active = "y" ',
		            ),
				);
			}
			else
			{
			    $scopes = array(
		            'shoppingcheck'=>array(
			    		'alias' => 'shoppings',
			    		'condition' => ' shoppings.create_by = "'.Yii::app()->user->id.'" AND shoppings.active = "y" ',
			    		'order' => ' shoppings.id ASC ',
		            ),
		            'promotions'=>array(
		                'condition'=>' shoppings.create_by = "'.Yii::app()->user->id.'" AND shoppings.shop_promotion = "1" AND shoppings.active = "y" ',
		            ),
			    );
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

	public function getId()
	{
		return $this->cms_id;
	}
}
