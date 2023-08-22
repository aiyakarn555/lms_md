<?php

class News extends AActiveRecord
{
	public $picture;
	public $cms_tab;
	public $cms_url;
	public $labelState = false;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{news}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cms_title', 'length', 'max'=>250),
			// array('cms_picture', 'length', 'max'=>200, 'on'=>'insert,update'),
			// array('cms_picture', 'file','types' => 'jpg, gif, png', 'allowEmpty'=>true),
			array('active', 'length', 'max'=>1),
			array('cms_title', 'required'),
			array('cms_short_title, cms_detail, create_date, cms_picture, update_date ,news_per_page, lang_id,parent_id', 'safe'),
			array('cms_id, cms_title, cms_picture, cms_short_title, cms_detail, create_date, create_by, update_date, update_by, active,cms_tab,cms_link,cms_url,cms_type_display, lang_id,parent_id,cms_type_id', 'safe', 'on'=>'search'),
			array('picture', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			array('picture', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'update'),
			array('picture,cms_tab,cms_link,cms_url,cms_type_display,cms_type_id', 'safe'),
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
		if(!$this->labelState){
            $this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
        }
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'cms_id' => 'ID',
			'cms_title' => 'ชื่อหัวข้อ'.$label_lang,
			'cms_type_id' => 'หมวด'.$label_lang,
			'cms_short_title' => 'รายละเอียดย่อ'.$label_lang,
			'cms_detail' => 'เนื้อหาข่าว'.$label_lang,
			'cms_picture' => 'รูปภาพ'.$label_lang,
			'cms_url' => 'URL Link',
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ'.$label_lang,
			'picture'=>'รูปภาพ'.$label_lang,
			'cms_tab' => 'ตั้งค่า New Tab (Url Link)',
			'cms_type_display' => 'ตั้งค่า Redirect (Url Link)',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cms_id',$this->cms_id);
		$criteria->compare('cms_type_id',$this->cms_type_id);
		$criteria->compare('cms_title',$this->cms_title,true);
		$criteria->compare('cms_short_title',$this->cms_short_title,true);
		$criteria->compare('cms_detail',$this->cms_detail,true);
		$criteria->compare('cms_picture',$this->cms_picture,false);
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
			// $this->update_by = $id;
			// $this->update_date = date("Y-m-d H:i:s");
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
		    	'alias' => 'news',
		    	'order' => ' news.update_date ASC ',
		    	'condition' => ' news.active = "y" ',
		    );
    	}
    	else
    	{
		    $checkScopes =  array(
		    	'alias' => 'news',
		    	'order' => ' news.update_date ASC ',
		    );
    	}

		return $checkScopes;
    }

	public function scopes()
    {
    	//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("News.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array(
				'newscheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'newscheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'newscheck'=>array(
							'alias' => 'news',
							'order' => ' news.update_date ASC ',
							'condition' => ' news.active = "y" ',
						),
					);
				}else{
					$scopes = array(
						'newscheck'=>array(
							'alias' => 'news',
							'order' => ' news.update_date ASC ',
							'condition' => ' news.active = "y" ',
							// 'condition' => ' news.create_by = "'.Yii::app()->user->id.'" AND news.active = "y" ',
						),
					);
				}
			    
			    // $scopes = array(
		     //        'newscheck'=>array(
			    // 		'alias' => 'news',
			    // 		'order' => ' news.cms_id DESC ',
			    // 		'condition' => ' news.active = "y" ',
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
		return $this->cms_id;
	}
}
