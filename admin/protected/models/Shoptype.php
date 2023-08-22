<?php

class Shoptype extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{shoptype}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('shoptype_name', 'length', 'max'=>100),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date , news_per_page', 'safe'),
			array('shoptype_name', 'required'),
			array('shoptype_id, shoptype_name, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'shoptype' => array(self::HAS_MANY, 'Shopping', 'shoptype_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'shoptype_id' => 'Shoptype',
			'shoptype_name' => 'ชื่อหมวดหมู่',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('shoptype_id',$this->shoptype_id);
		$criteria->compare('shoptype_name',$this->shoptype_name,true);
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
    	$this->shoptype_name = CHtml::encode($this->shoptype_name);

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

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
    	$this->shoptype_name = CHtml::decode($this->shoptype_name);
        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'shoptypes',
		    	'order' => ' shoptypes.shoptype_id DESC ',
		    	'condition' => ' shoptypes.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'shoptypes',
		    	'order' => ' shoptypes.shoptype_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Shoptype.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'shoptypecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'shoptypecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'shoptypecheck'=>array(
				    	'alias' => 'shoptypes',
				    	'order' => ' shoptypes.shoptype_id DESC ',
				    	'condition' => ' shoptypes.create_by = "'.Yii::app()->user->id.'" AND shoptypes.active = "y" ',
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

}
