<?php

class ImgslideLink extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{imgslide_link}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('imgslide_link', 'length', 'max'=>250),
			array('imgslide_picture', 'length', 'max'=>200),
			array('active', 'length', 'max'=>1),
			array('news_per_page, create_date, update_date', 'safe'),
			array('imgslide_picture , imgslide_link', 'required', 'on'=>'insert'),
			array('imgslide_link', 'required', 'on'=>'update'),
			array('imgslide_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('imgslide_id, imgslide_link, imgslide_picture, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'imgslide_id' => 'Imgslide',
			'imgslide_link'=> 'ชื่อลิ้งค์',
			'imgslide_picture' => 'รูปภาพประกอบ',
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

		$criteria->compare('imgslide_id',$this->imgslide_id);
		$criteria->compare('imgslide_link',$this->imgslide_link,true);
		$criteria->compare('imgslide_picture',$this->imgslide_picture,true);
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
		if(Yii::app()->user !== null && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		$this->imgslide_link = CHtml::encode($this->imgslide_link);

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
		$this->imgslide_link = CHtml::decode($this->imgslide_link);
        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'imgslideLinks',
		    	'order' => ' imgslideLinks.imgslide_id DESC ',
		    	'condition' => ' imgslideLinks.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'imgslideLinks',
		    	'order' => ' imgslideLinks.imgslide_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//
    	
		$Access = Controller::SetAccess( array("ImgslideLink.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'imgslidelinkcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'imgslidelinkcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    $scopes = array(
		            'imgslidelinkcheck'=>array(
			    		'alias' => 'imgslideLinks',
			    		'order' => ' imgslideLinks.imgslide_id DESC ',
			    		'condition' => ' imgslideLinks.create_by = "'.Yii::app()->user->id.'" AND imgslideLinks.active = "y" ',
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
		return $this->imgslide_id;
	}

}