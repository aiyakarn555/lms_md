<?php

class Account extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{account}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cms_title', 'length', 'max'=>250),
			array('cms_picture', 'length', 'max'=>200, 'on'=>'insert,update'),
			array('cms_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('active', 'length', 'max'=>1),
			array('cms_title,cms_short_title,cms_detail', 'required'),
			array('cms_short_title, cms_detail, create_date, update_date ,news_per_page', 'safe'),
			array('cms_id, cms_title, cms_short_title, cms_detail, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'cms_id' => 'ID',
			'cms_title' => 'ชื่อหัวข้อ',
			'cms_short_title' => 'รายละเอียดย่อ',
			'cms_detail' => 'เนื้อหา',
			'cms_picture' => 'รูปภาพ',
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
		$criteria->compare('cms_id',$this->cms_id);
		$criteria->compare('cms_title',$this->cms_title,true);
		$criteria->compare('cms_short_title',$this->cms_short_title,true);
		$criteria->compare('cms_detail',$this->cms_detail,true);
		$criteria->compare('cms_picture',$this->cms_picture,false);
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
    	$this->cms_title = CHtml::encode($this->cms_title);
    	$this->cms_short_title = CHtml::encode($this->cms_short_title);
    	$this->cms_detail = CHtml::encode($this->cms_detail);

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
    	$this->cms_title = CHtml::decode($this->cms_title);
    	$this->cms_short_title = CHtml::decode($this->cms_short_title);
    	$this->cms_detail = CHtml::decode($this->cms_detail);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'accounts',
		    	'order' => ' accounts.cms_id DESC ',
		    	'condition' => ' accounts.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'accounts',
		    	'order' => ' accounts.cms_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Account.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'accountcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'accountcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'accountcheck'=>array(
			    		'alias' => 'accounts',
			    		'order' => ' accounts.cms_id DESC ',
			    		'condition' => ' accounts.create_by = "'.Yii::app()->user->id.'" AND accounts.active = "y" ',
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
