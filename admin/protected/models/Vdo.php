<?php

class Vdo extends AActiveRecord
{
	public $link_vdo;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{vdo}}';
	}

	public function rules()
	{
		return array(
			array('vdo_id, create_by, update_by,sortOrder', 'numerical', 'integerOnly'=>true),
			array('vdo_title, vdo_path , vdo_thumbnail, vdo_credit', 'length', 'max'=>255),
			//array('vdo_path', 'file', 'types' => ('mp4', 'avi', 'mpge'), 'maxSize' => 1024 * 1024 * 2),
			array('vdo_path', 'file', 'types' => 'mp4,avi,mpge', 'maxSize'=>100000000 ,'message'=>'ไฟล์จะต้องมีขนาดไม่เกิน 100 Mb กรุณาเลือกไฟล์ใหม่','on'=>'file'),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, news_per_page,vdo_type,link_vdo,lang_id,parent_id,sortOrder', 'safe'),
			array('vdo_title', 'required' ),

			array('vdo_id, vdo_title, vdo_path,vdo_thumbnail, create_date, create_by, update_date, update_by, active,lang_id,parent_id,sortOrder,vdo_credit', 'safe', 'on'=>'search'),
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
		$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'vdo_id' => 'Vdo',
			'vdo_title' => 'หัวข้อวิดีโอ'.$label_lang,
			'vdo_path' => 'ชื่อไฟล์วีดีโอ'.$label_lang,
			'vdo_thumbnail' => 'รูปภาพหน้าปกวีดีโอ'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'vdo_type' => 'ประเภทวิดีโอ'.$label_lang,
			'active' => 'สถานะ'.$label_lang,
			'link_vdo' => 'ลิงค์วิดีโอ'.$label_lang,
			'lang_id' => 'ภาษา',
			'paren_id' =>'paren',
			'sortOrder'=> 'ย้ายตำแหน่ง',
			'vdo_credit'=>'เครดิต'.$label_lang,
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('vdo_id',$this->vdo_id);
		$criteria->compare('vdo_title',$this->vdo_title,true);
		$criteria->compare('vdo_path',$this->vdo_path,true);
		$criteria->compare('vdo_thumbnail',$this->vdo_thumbnail,true);
		$criteria->compare('create_date',$this->create_date,true);
		// $criteria->compare('create_by',$this->create_by);
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('create_by', $groupUser);	
		}
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',$this->lang_id,true);
		$criteria->compare('vdo_credit',$this->vdo_credit,true);
		$criteria->compare('parent_id',0);
		$criteria->order = 'sortOrder ASC';
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
			
		return new CActiveDataProvider($this, $poviderArray);
	}

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'vdos',
		    	'order' => ' vdos.vdo_id DESC ',
		    	'condition' => ' vdos.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'vdos',
		    	'order' => ' vdos.vdo_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Vdo.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);
		if($Access == true)
		{
			$scopes =  array( 
				'vdocheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'vdocheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'vdocheck'=>array(
							'alias' => 'vdos',
							'order' => ' vdos.vdo_id DESC ',
							'condition' => 'vdos.active = "y" ',
						),
					);
				}else{
					$scopes = array(
						'vdocheck'=>array(
							'alias' => 'vdos',
							'order' => ' vdos.vdo_id DESC ',
							 // vdos.create_by = "'.Yii::app()->user->id.'" AND 
							'condition' => 'vdos.active = "y" ',
						),
					);
				}
			    
			}
		}

		return $scopes;
    }

	public function defaultScope()
	{
	    $defaultScope =  $this->checkScopes('defaultScope');

		return $defaultScope;
	}

   	public function beforeSave() 
    {
    	$this->vdo_title = CHtml::encode($this->vdo_title);
    	$this->vdo_path = CHtml::encode($this->vdo_path);
    	$this->vdo_thumbnail = CHtml::encode($this->vdo_thumbnail);

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
    	$this->vdo_title = CHtml::decode($this->vdo_title);
    	$this->vdo_path = CHtml::decode($this->vdo_path);
    	$this->vdo_thumbnail = CHtml::decode($this->vdo_thumbnail);

        return parent::afterFind();
    }
}
