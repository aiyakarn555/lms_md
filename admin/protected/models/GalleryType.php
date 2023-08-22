<?php

class GalleryType extends AActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{gallery_type}}';
	}

	public function rules()
	{
		return array(
			array('name_gallery_type', 'required'),
			array('name_gallery_type, create_by, update_by', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),

			array('id, name_gallery_type, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function beforeSave()
	{
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
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
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'gallerytype',
				'order' => ' gallerytype.id DESC ',
				'condition' => ' gallerytype.active = "y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'gallerytype',
				'order' => ' gallerytype.id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("gallerytype.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'gallerytypecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'gallerytypecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				$scopes = array(
					'gallerytypecheck'=>array(
						'alias' => 'gallerytype',
						'order' => ' gallerytype.id DESC ',
						'condition' => ' gallerytype.active = "y" ',
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
		return $this->id;
	}

	public function relations()
	{
		return array(
			'galleryid' => array(self::HAS_MANY, 'Gallery', 'id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'รหัส',
			'name_gallery_type' => 'ประเภท',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name_gallery_type',$this->name_gallery_type,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('active',$this->active,true);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);
	}

}
