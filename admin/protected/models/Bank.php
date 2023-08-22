<?php

class Bank extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{bank}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('bank_name, bank_picture, bank_user, bank_branch', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('bank_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('bank_name,bank_number, bank_user, bank_branch', 'required'),
			array('create_date, update_date, news_per_page', 'safe'),

			array('bank_user, bank_branch, bank_id, bank_name,news_per_page, bank_number, bank_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'bank_id' => 'Bank',
			'bank_user' => 'ชื่อเจ้าของบัญชี',
			'bank_name' => 'ชื่อธนาคาร',
			'bank_number' => 'เลขที่บัญชี',
			'bank_branch'=>'สาขาธนาคาร',
			'bank_picture' => 'รูปภาพ',
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

		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('bank_number',$this->bank_number,true);
		$criteria->compare('bank_branch',$this->bank_branch,true);
		$criteria->compare('bank_picture',$this->bank_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
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
    	$this->bank_user = CHtml::encode($this->bank_user);
    	$this->bank_name = CHtml::encode($this->bank_name);
    	$this->bank_number = CHtml::encode($this->bank_number);
    	$this->bank_branch = CHtml::encode($this->bank_branch);

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
    	$this->bank_user = CHtml::decode($this->bank_user);
    	$this->bank_name = CHtml::decode($this->bank_name);
    	$this->bank_number = CHtml::decode($this->bank_number);
    	$this->bank_branch = CHtml::decode($this->bank_branch);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'bank',
		    	'condition' => ' bank.active = "y" ',
		    	'order' => ' bank.bank_id DESC ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'bank',
		    	'order' => ' bank.bank_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Bank.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'bankcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'bankcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'bankcheck'=>array(
			    		'alias' => 'bank',
			    		'condition' => ' bank.create_by = "'.Yii::app()->user->id.'" AND bank.active = "y" ',
			    		'order' => ' bank.bank_id DESC ',
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
		return $this->bank_id;
	}
}
