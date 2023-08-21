<?php

class Order extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{order}}';
	}

	public function rules()
	{
		return array(
			array('user_id, order_countnum, order_countall, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('order_cost', 'length', 'max'=>10),
			array('order_file', 'length', 'max'=>255),
			array('order_file, order_bank, order_date_add, order_date_time', 'required', 'on'=>'update'),
			array('order_file', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'insert,update'),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			array('order_id, user_id, order_cost, order_countnum, order_countall, order_file, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Profiles'=>array(self::BELONGS_TO, 'Profile', 'user_id'),
			'OrderDetails'=>array(self::HAS_MANY, 'OrderDetail', 'order_id'),
			'bank'=>array(self::BELONGS_TO, 'Bank', 'order_bank'), 
		);
	}

	public function attributeLabels()
	{
		return array(
			'Datailhead'=>'หัวข้อ',
			'order_id' => 'รหัสรายการ',
			'user_id' => 'User',
			'order_bank'=>'ธนาคารที่โอนเงินมา',
			'order_date_add'=>'วันที่โอนเงิน',
			'order_date_time' =>'เวลาในการโอนเงิน',
			'order_cost' => 'จำนวนเงิน',
			'order_countnum' => 'จำนวนชนิดของที่สั่ง',
			'order_countall' => 'จำนวนของ/ชิ้น',
			'order_file' => 'รูปไฟล์เอกสาร',
			'create_date' => 'วันที่สั่งซื้อ',
			'create_by' => 'Create By',
			'update_date' => 'วันที่แจ้งการโอนเงิน',
			'update_by' => 'Update By',
			'con_user' => 'ยืนยันการโอนเงิน',
			'con_admin' => 'การอนุมัติ Point',
			'active' => 'Active',
		);
	}

   	public function beforeSave() 
    {
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
			$this->user_id = $id;
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = null;
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
        return parent::afterFind();
    }

	public function getShowIcon()
	{
		return $this->con_user == '0';
	}

	public function getShowIconEdit()
	{
		return $this->con_user == '1' && $this->con_admin == '0';
	}

	public function getCheckConfirm()
	{
		$get = 'update';
		$imageUrl = Yii::app()->request->baseUrl .'/images/icons/';
		if($this->con_user == 0)
		{
			$imageUrl .= 'coins.png';
			$link = CHtml::link(CHtml::image($imageUrl,'Accept'),array($get,'id'=>$this->order_id),array(
			   	'class' => 'imageIcon',
			));
		}
		else
		{
			if($this->con_admin == '1' && empty($this->order_ems))
			{
				$link = CHtml::image($imageUrl .= 'process.png');
			}
			else if($this->con_admin == '1' && !empty($this->order_ems))
			{
				$link = '<font color="#0000E0" style="font-weight:bold;">'.$this->order_ems.'</font>';
			}
			else
			{
				$link = '
				<div style="text-align: center; font-size: 13px;">
					<p> <font color="#009933" style="font-weight:bold;"> บริษัทได้รับข้อมูลการแจ้งโอนเงินจากคุณเรียบร้อยแล้ว </font> </p> 
					<p> ขณะนี้กําลังตรวจสอบข้อมูลการโอนเงิน (ภายใน 15 นาที) </p> 
					<p> ท่านสามารถเข้าเรียนออนไลน์ได้ทันทีหลังจากได้รับ SMS หรือ E-mail ยืนยันจากบริษัทฯ หรือ </p>
					<p> ตรวจสอบสถานนะการการโอนเงินได้ที่ “ตรวจสอบสถานะการโอนเงิน” พร้อมพิมพ์ใบเสร็จได้ทันที </p>
					<hr>
					<p> หมายเหตุ : ในกรณีที่ท่านยังไม่รับการยืนยันจากบริษัท ภายใน 15 นาที </p>
					<p> สามารถติดต่อได้ที่ 091-408-5727-8 </p>
				</div>
				';
			}
		}

		return $link;
	}

	public function getCheckFileUp()
	{
		if(isset($this->order_file))
			$date = ClassFunction::datethaiTime($this->update_date);
		else
			$date = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยัน</font>';

		return $date;
	}

	public function getPrintConfirm()
	{
		$imageUrl = Yii::app()->request->baseUrl .'/images/icons/';
		$imageUrl .= 'print.png';
		$print = CHtml::link(CHtml::image($imageUrl,'Accept'),array('PrintConfirm','id'=>$this->order_id),array(
			'class' => 'imageIcon','target'=>'_blank'
		));
		return $print;
	}

	public function getPrintReceipt()
	{
		$imageUrl = Yii::app()->request->baseUrl .'/images/icons/';
		$imageUrl .= 'print.png';
		if($this->con_admin == '1')
			$print = CHtml::link(CHtml::image($imageUrl,'Accept'),array('PrintReceipt','id'=>$this->order_id),array(
				'class' => 'imageIcon','target'=>'_blank'
			));
		else
			$print = '-';
		
		return $print;
	}
	
	public function getConfirmViewUser()
	{
		if ($this->con_user == 1) 
			$link = '<font color="#009933" style="font-weight:bold;">ยืนยันการโอนเงินแล้ว</font>';
		else
			$link = '<font color="#991A00" style="font-weight:bold;">ยังไม่มีการยืนยันโอนเงิน</font>';
		return $link;
	}

	public function defaultScope()
	{
	    return array(
	    	'alias'=>'orders',
	    	'order' => 'orders.order_id desc',
	    	'condition' => ' orders.active = "y" AND orders.user_id = "'.Yii::app()->user->id.'" ',
	    );
	}

	public function getAddFileCheck()
	{
		if(!empty($this->order_file))
		{
			$check = CHtml::link(CHtml::image(Yush::getUrl($this, Yush::SIZE_ORIGINAL, $this->order_file),'',array("class"=>"thumbnail")),Yush::getUrl($this, Yush::SIZE_ORIGINAL, $this->order_file),array("rel"=>"prettyPhoto"));
			//$check = Helpers::lib()->ZoomCheckImage($checkImg,$checkImg);
		}
		else
		{
			$check = '-';
		}
			
		return $check;
	}

	public function getCheckOrderDateAdd()
	{
		if(isset($this->order_date_add) && isset($this->order_date_time))
		{
			$date = '<font style="text-align:center;" color="#0000CC"> '.ClassFunction::dateThaiShort($this->order_date_add).'</font>';
		}
		else
		{
			$date = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยัน</font>';
		}

		return $date;
	}

	public function getNameBankCheck()
	{
		if(isset($this->order_bank))
		{
			if ($this->order_bank != '0')
			{
				$check = $this->bank->bank_name;
			}
			else
			{
				$check = CHtml::image(Yii::app()->request->baseUrl .'/images/psb2.jpg');
			}
		}
		else
		{
			$check = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยัน</font>';
		}
		return $check;
	}

    public function getCheckPaysBuy()
    {
    	$PaysBuy = '';
    	if ($this->con_user == 0 && $this->con_admin == 0)
    	{
			$modelShops = OrderDetail::model()->findAll(array(
				"condition"=>"  order_id =  ".$this->order_id
			));

			$productVariable = '';
			$i = 0;
    		foreach ($modelShops as $value) 
    		{
    			$i++;
    			$productVariable.= '('.$i.') '. $value->shops->shop_name.' ';
    		}

			//$productVariable 	= 'Detail';
			$postURL = "http://www.cpdland.com/index.php/order/payment";

			$PaysBuy.= CHtml::beginForm('https://www.PAYSBUY.com/paynow.aspx','post',array(
				'target'=>'_blank',
				'style' => 'margin-left:5px; margin-bottom: -1px;'
			));

			$PaysBuy.= CHtml::hiddenField('psb', 'psb'); //ต้องมีค่าเป็น “psb” เท่านั้น
			$PaysBuy.= CHtml::hiddenField('biz', 'cpdland@yahoo.com'); //E-mail ของร้านค้า
			$PaysBuy.= CHtml::hiddenField('inv', $this->getOrderId()); //รหัสสินค้า
			$PaysBuy.= CHtml::hiddenField('itm', $productVariable); //รายละเอียดสินค้า
			//$PaysBuy.= CHtml::hiddenField('amt', "1"); //ยอดรวมราคาสินค้า
			$PaysBuy.= CHtml::hiddenField('amt', $this->order_cost); //ยอดรวมราคาสินค้า
			$PaysBuy.= CHtml::hiddenField('postURL', $postURL); //URL ที่ redirect และรับค่าตัวแปร เมื่อทาการชาระเงินเสร็จ
			$PaysBuy.= CHtml::tag('input',array(
				'style' => 'width: 55px;',
				'src' => Yii::app()->baseUrl . '/images/S_click2buy.gif',
				'type' => 'image',
				'border'=>'0'
			));

			$PaysBuy.= CHtml::endForm();
    	}
    	else
    	{
    		$PaysBuy = '-';
    	}

    	return $PaysBuy;
    }

	public function getOrderId($text = 'T')
	{
		$checkOrder = $text.''.sprintf("%05d",$this->order_id);
		return $checkOrder;
	}

	public function getId()
	{
		return $this->order_id;
	}

    public function getNameUser() 
    {
        return $this->Profiles->first_name.' '.$this->Profiles->last_name;
    }

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('order_cost',$this->order_cost,true);
		$criteria->compare('order_countnum',$this->order_countnum,true);
		$criteria->compare('order_countall',$this->order_countall,true);
		$criteria->compare('order_file',$this->order_file,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		if (!empty($this->create_date))
		{
			$criteria->compare('create_date',ClassFunction::DateSearch($this->create_date),true);
		}
			
		if (!empty($this->update_date))
		{
			$criteria->compare('update_date',ClassFunction::DateSearch($this->update_date),true);
		}
			
		$poviderArray = array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
		);

		return new CActiveDataProvider($this, $poviderArray);
	}
}
