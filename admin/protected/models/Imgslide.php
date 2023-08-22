<?php

class Imgslide extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{imgslide}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('imgslide_picture', 'length', 'max'=>200),
			array('imgslide_title', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('news_per_page, create_date, update_date, parent_id, lang_id', 'safe'),
			array('imgslide_picture ,imgslide_title','required', 'on'=>'insert'),
			array('imgslide_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true, 'safe' => false),
			array('imgslide_id , imgslide_link,imgslide_detail,imgslide_title, parent_id, lang_id, gallery_type_id', 'safe', 'on'=>'search'),
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
		
		$this->imgslide_link = CHtml::encode($this->imgslide_link);

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

	public function afterFind() 
	{
		$this->imgslide_link = CHtml::decode($this->imgslide_link);
		return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'imgslide',
				'order' => ' imgslide.imgslide_id DESC ',
				'condition' => ' imgslide.active = "y" ',
			);	
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'imgslide',
				'order' => ' imgslide.imgslide_id DESC ',
			);	
		}

		return $checkScopes;
	}

	public function scopes()
	{
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Imgslide.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'imgslidecheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'imgslidecheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    // $scopes = array(
		     //        'imgslidecheck'=>array(
		    	// 		'alias' => 'imgslide',
	    		// 		'order' => ' imgslide.imgslide_id DESC ',
	    		// 		'condition' => ' imgslide.create_by = "'.Yii::app()->user->id.'" AND imgslide.active = "y" ',
		     //        ),
			    // );
				$scopes = array(
					'imgslidecheck'=>array(
						'alias' => 'imgslide',
						'order' => ' imgslide.imgslide_id DESC ',
						'condition' => ' imgslide.active = "y" ',
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

	public function relations()
	{
		return array(
			'gType' => array(self::BELONGS_TO, 'GalleryType', 'gallery_type_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
		);
	}

	public function getId()
	{
		return $this->imgslide_id;
	}

	public function attributeLabels()
	{
		$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'imgslide_id' => 'Imgslide',
			'imgslide_link'=> 'ชื่อลิ้งค์'.$label_lang,
			'imgslide_picture' => 'รูปภาพประกอบ'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'active' => 'สถานะ'.$label_lang,
			'imgslide_detail' => 'รายละเอียดรูปภาพ'.$label_lang,
			'imgslide_title' => 'หัวข้อรูปภาพ'.$label_lang,
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
			'gallery_type_id' => 'ประเภทแกลลอรี่'.$label_lang,
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('imgslide_id',$this->imgslide_id);
		$criteria->compare('imgslide_detail',$this->imgslide_detail,true);
		$criteria->compare('imgslide_title',$this->imgslide_title,true);
		$criteria->compare('imgslide_link',$this->imgslide_link,true);
		$criteria->compare('imgslide_picture',$this->imgslide_picture,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',$this->lang_id,true);
		$criteria->compare('parent_id',0);
		$criteria->compare('gallery_type_id',$this->gallery_type_id,true);

		
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $poviderArray);
	}
}