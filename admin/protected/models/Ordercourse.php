<?php

class Ordercourse extends AActiveRecord
{
	public $user_name;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{ordercourse}}';
	}

	public function rules()
	{
		return array(
			array('user_id, order_point,order_countnum, order_countall, con_user, con_admin, create_by, update_by', 'numerical'),
			array('order_cost', 'length', 'max'=>10),
			array('order_file', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('order_ems,order_point', 'required'),
			array('create_date, update_date, user_name, news_per_page', 'safe'),
			array('order_id,user_name, user_id, order_cost, order_countnum, order_countall, order_file, con_user, con_admin, create_date, create_by, update_date, update_by, active,  order_date_add, order_date_time, order_bank', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
        return array(
            'userorder' => array(self::BELONGS_TO, 'User', 'user_id'),
            'profile' => array(self::BELONGS_TO, 'Profile', 'user_id'),
            'bank'=>array(self::BELONGS_TO, 'Bank', 'order_bank'), 
        );
	}

	public function getNameUser()
	{
		return $this->profile->firstname.' '.$this->profile->lastname;
	}

	public function getShowIcon()
	{
		$check = false;
		if(Controller::PButton(array("Ordercourse.*", "Ordercourse.Delete")) == true)
		{
			if($this->con_admin == '0')
			{
				$check = true;
			}
		}
		
		return $check;
	}

	public function getAddPoint()
	{	
		if($this->con_admin == '1')
			return CHtml::link("เพิ่มเติม",array("update", "id"=>$this->order_id), array(
				"class"=>"btn btn-icon btn-primary"
			));
	}
	public function getAddEMS()
	{	
		if(isset($this->order_ems))
			$check = '<font color="green">'.$this->order_ems.'</font>';
		else
			$check = '<font color="red">ยังไม่ได้จัดส่ง</font>';

		return $check;
	}

	public function getCheckFileUp()
	{
		if(isset($this->order_file))
			$date = '<font style="text-align:center;" color="#006600">ยืนยันการโอนเงิน</font>';
		else
			$date = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยันการโอนเงิน</font>';

		return $date;
	}

	public function getDateConfirm()
	{
		if(isset($this->order_date_add))
			$date = ClassFunction::datethai($this->order_date_add);
		else
			$date = '<font style="text-align:center;" color="red">-</font>';

		return $date;
	}

	public function getTimeConfirm()
	{
		if(isset($this->order_date_time))
			$date = $this->order_date_time;
		else
			$date = '<font style="text-align:center;" color="red">-</font>';

		return $date;
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
	    		'alias'=>'ordercourse',
	    		'order' => 'ordercourse.update_date desc',
	    		'condition' => ' ordercourse.active = "y" AND ordercourse.con_user = "1"',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
	    		'alias'=>'ordercourse',
	    		'order' => 'ordercourse.update_date desc',
	    		'condition' => ' ordercourse.active = "y" AND ordercourse.con_user = "1"',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Ordercourse.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'ordercoursecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'ordercoursecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'ordercoursecheck'=>array(
	    				'alias'=>'ordercourse',
	    				'order' => 'ordercourse.update_date desc',
	    				'condition' => ' ordercourse.active = "y" AND ordercourse.con_user = "1"',
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


	public function getNameBankCheckPrint()
	{
		if(isset($this->order_bank))
		{
			if ($this->order_bank != '0')
			{
				$check = $this->bank->bank_name;
			}
			else
			{
				$check = 'PaysBuy';
			}
		}
		else
		{
			$check = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยัน</font>';
		}
		return $check;
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
				$check = CHtml::image(Yii::app()->baseUrl .'/../images/psb2.jpg');
			}
		}
		else
		{
			$check = '<font style="text-align:center;" color="red">ยังไม่ได้ยืนยัน</font>';
		}
		return $check;
	}

	public function getOrderId($text = 'K')
	{
		$checkOrder = $text.''.sprintf("%05d",$this->order_id);
		return $checkOrder;
	}

	public function attributeLabels()
	{
		return array(
			'order_id' => 'รหัสรายการ',
			'user_name' => 'ชื่อผู้ใช้',
			'user_id' => 'ผู้ใช้',
			'order_cost' => 'จำนวนเงินรวม',
			'order_countnum' => 'จำนวนประเภทหลักสูตร',
			'order_countall' => 'จำนวนการจองทั้งหมด',
			'order_file' => 'รูปไฟล์เอกสาร',
			'order_point' => 'ได้แต้ม',
			'order_ems' => 'EMS ไปรษณีย์',
			'order_date_add'=>'วันที่แจ้งการโอนเงิน',
			'order_date_time' =>'เวลาการโอนเงิน',
			'create_date' => 'วันที่การจองหลักสูตร',
			'order_bank' => 'ธนาคารที่โอนเข้า',
			'create_by' => 'Create By',
			'update_date' => 'วันที่แจ้งการโอนเงิน',
			'update_by' => 'Update By',
			'con_user' => 'ยืนยันการโอนเงิน',
			'con_admin' => 'ยืนยันการโอนเงิน',
			'active' => 'Active',
		);
	}

	public function getId()
	{
		return $this->order_id;
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('profile');
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('user_id',$this->user_id);

		if (!empty($this->user_name))
		{
			$criteria->addSearchCondition( 'CONCAT( profile.firstname, " ", profile.lastname )', $this->user_name );
		}
		else
		{
			$criteria->compare('profile.firstname',$this->user_name,true);
		}

		$criteria->compare('order_cost',$this->order_cost,true);
		$criteria->compare('order_ems',$this->order_ems,true);
		$criteria->compare('order_countnum',$this->order_countnum,true);
		$criteria->compare('order_countall',$this->order_countall,true);
		$criteria->compare('order_file',$this->order_file,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('con_admin',$this->con_admin,true);
		$criteria->compare('order_date_time',$this->order_date_time,true);
		$criteria->compare('order_bank',$this->order_bank,true);

		if (!empty($this->create_date))
		{
			$criteria->compare('create_date',ClassFunction::DateSearch($this->create_date),true);
		}
			
		if (!empty($this->order_date_add))
		{
			$criteria->compare('order_date_add',ClassFunction::DateSearch($this->order_date_add),true);
		}
			
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}
}