<?php

class Usability extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{usability}}';
	}

	public function rules()
	{
		return array(
			array('usa_id, create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('usa_title, usa_address', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('usa_detail, update_date, news_per_page, parent_id, lang_id', 'safe'),
			array('usa_title', 'required'),
			array('usa_id, usa_title, usa_detail, create_date, create_by, update_date, update_by, active, parent_id, lang_id, sortOrder', 'safe', 'on'=>'search'),
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
			'usa_id' => 'Usa',
			'usa_title' => 'หัวข้อวิธีการใช้งาน'.$label_lang,
			'usa_detail' => 'รายละเอียดการใช้งาน'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
			'sortOrder'=>'ย้ายตำแหน่ง',
			'usa_address' => 'รูปภาพหน้าปก'
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('usa_id',$this->usa_id);
		$criteria->compare('usa_title',$this->usa_title,true);
		$criteria->compare('usa_detail',$this->usa_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
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

   	public function beforeSave() 
    {
    	$this->usa_title = CHtml::encode($this->usa_title);
    	$this->usa_detail = CHtml::encode($this->usa_detail);

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
    	$this->usa_title = CHtml::decode($this->usa_title);
    	$this->usa_detail = CHtml::decode($this->usa_detail);
    	$this->usa_detail = CHtml::decode($this->usa_detail);

        return parent::afterFind();
    }

    public function checkScopes($check = 'scopes')
    {
    	if ($check == 'scopes')
    	{
		    $checkScopes =  array(
		    	'alias' => 'usabilitys',
		    	'order' => ' usabilitys.usa_id DESC ',
		    	'condition' => ' usabilitys.active = "y" ',
		    );	
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'usabilitys',
		    	'order' => ' usabilitys.usa_id DESC ',
		    );	
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//
    	
		$Access = Controller::SetAccess( array("Usability.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array( 
				'usabilitycheck' => $this->checkScopes('scopes') 
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array( 
					'usabilitycheck' => $this->checkScopes('scopes') 
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'usabilitycheck'=>array(
							'alias' => 'usabilitys',
							'condition' => ' usabilitys.active = "y" ',
							'order' => ' usabilitys.usa_id DESC ',
						),
					);
				}else{
					$scopes = array(
						'usabilitycheck'=>array(
							'alias' => 'usabilitys',
							'condition' => '  usabilitys.create_by = "'.Yii::app()->user->id.'" AND usabilitys.active = "y" ',
							'order' => ' usabilitys.usa_id DESC ',
						),
					);
				}
			    // $scopes = array(
		     //        'usabilitycheck'=>array(
			    // 		'alias' => 'usabilitys',
			    // 		'condition' => '  usabilitys.create_by = "'.Yii::app()->user->id.'" AND usabilitys.active = "y" ',
			    // 		'order' => ' usabilitys.usa_id DESC ',
		     //        ),
			    // );
			    // $scopes = array(
		     //        'usabilitycheck'=>array(
			    // 		'alias' => 'usabilitys',
			    // 		'condition' => ' usabilitys.active = "y" ',
			    // 		'order' => ' usabilitys.usa_id DESC ',
		     //        ),
			    // );
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
		return $this->usa_id;
	}

	public function getUsabilityListNew(){

		$model = Usability::model()->findAll('active = "y"');
		$list = CHtml::listData($model,'id','usa_title');
		return $list;
		
	}
}
