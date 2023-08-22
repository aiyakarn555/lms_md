<?php

class Gallery extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function tableName()
	{
		return '{{gallery}}';
	}

	public function rules()
	{
		return array(
			array('gallery_type_id', 'required'),
			array('gallery_type_id, group_gallery_id', 'numerical', 'integerOnly'=>true),
			array('image, create_by, update_by', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),

			array('id, image, gallery_type_id, create_date, create_by, update_date, update_by, active, group_gallery_id', 'safe', 'on'=>'search'),
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

	public function relations()
	{
		return array(
			'gType' => array(self::BELONGS_TO, 'GalleryType', 'id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			//'gallerygroup' => array(self::BELONGS_TO, 'GalleryGroup', 'group_gallery_id'),
		);
	}
	
	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'gallery',
				'order' => ' gallery.id DESC ',
				'condition' => ' gallery.active = "y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'gallery',
				'order' => ' gallery.id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("gallery.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'gallerycheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'gallerycheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				$scopes = array(
					'gallerycheck'=>array(
						'alias' => 'gallery',
						'order' => ' gallery.id DESC ',
						'condition' => ' gallery.active = "y" ',
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

	public function attributeLabels()
	{
		return array(
			'id' => 'รหัส',
			'image' => 'รูปภาพ',
			'gallery_type_id' => 'ประเภทแกลลอรี่',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('gallery_type_id',$this->gallery_type_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('group_gallery_id',$this->group_gallery_id,true);
		$criteria->group='gallery_type_id';
        
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);
	}

}
