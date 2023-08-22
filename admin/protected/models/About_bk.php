<?php

class About extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{about}}';
	}

	public function rules()
	{
		return array(
			array('about_title , about_detail','about_tel','about_email', 'required'),

			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('about_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('about_detail create_date, update_date, news_per_page, lang_id,parent_id', 'safe'),
			array('about_id, about_title, about_detail,about_tel,about_email, create_date, create_by, update_date, update_by, active,parent_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
		);
	}

	public function attributeLabels()
	{
		if(empty($this->lang_id)){
			$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		}else{
			$this->lang_id = $this->lang_id;
		}
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'about_id' => 'รหัส',
			'about_title' => 'หัวข้อติดต่อเรา'.$label_lang,
			'about_detail' => 'รายละเอียดติดต่อเรา'.$label_lang,
			'about_tel' => 'โทรศัพท์'.$label_lang,
			'about_email' => 'อีเมล'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ'.$label_lang,
			'lang_id' => 'ภาษา',
			'parent_id' => 'เมนูหลัก',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('about_id',$this->about_id);
		$criteria->compare('about_title',$this->about_title,true);
		$criteria->compare('about_detail',$this->about_detail,true);
		$criteria->compare('about_tel',$this->about_tel,true);
		$criteria->compare('about_email',$this->about_email,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		$criteria->compare('parent_id',0);
		$criteria->order = 'about_id';
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
    	$this->about_title 		= CHtml::encode($this->about_title);
    	$this->about_detail 	= CHtml::encode($this->about_detail);

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 1;
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
    	$this->about_title 		= CHtml::decode($this->about_title);
    	$this->about_detail 	= CHtml::decode($this->about_detail);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'about',
		    	'order' => ' about.about_id DESC ',
		    	'condition' => ' about.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'about',
		    	'order' => ' about.about_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//
    	
		$Access = Controller::SetAccess( array("About.*") );
		if($Access == true)
		{
			$scopes =  array( 
				'aboutcheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'aboutcheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
			    // $scopes = array(
		     //        'aboutcheck'=>array(
			    // 		'alias' => 'about',
			    // 		'condition' => '  about.create_by = "'.Yii::app()->user->id.'" AND about.active = "y" ',
			    // 		'order' => ' about.about_id DESC ',
		     //        ),
			    // );
			    $scopes = array(
		            'aboutcheck'=>array(
			    		'alias' => 'about',
			    		'condition' => ' about.active = "y" ',
			    		'order' => ' about.about_id DESC ',
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
		return $this->about_id;
	}

	public function listlanguageShow($model,$id,$class='')
	{
		if($model->lang_id == null){
			$list = CHtml::listData(Language::model()->findAll(array(
		"condition"=>" active = 'y' and status = 'y' and id != 1",'order'=>'id')),'id', 'language');
		}else{		
			$list = CHtml::listData(Language::model()->findAll(array(
		"condition"=>" active = 'y' and status = 'y' and id = ".$model->lang_id,'order'=>'id')),'id', 'language');

		}
		
		// var_dump($list); exit();
		return CHtml::activeDropDownList($model,'lang_id',$list , array(
			'class'=>$class
		));
	}

}