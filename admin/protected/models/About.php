<?php

/**
 * This is the model class for table "{{about}}".
 *
 * The followings are the available columns in table '{{about}}':
 * @property integer $about_id
 * @property string $about_title
 * @property string $about_detail
 * @property string $about_tel
 * @property string $about_email
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $lang_id
 * @property integer $parent_id
 */
class About extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{about}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('about_title, about_email', 'length', 'max'=>255),
			array('about_tel', 'length', 'max'=>50),
			array('active', 'length', 'max'=>1),
			array('about_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('about_id, about_title, about_detail, about_tel, about_email, create_date, create_by, update_date, update_by, active, lang_id, parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
			'lang' => array(self::BELONGS_TO, 'Language', 'lang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('about_id',$this->about_id);
		$criteria->compare('about_title',$this->about_title,true);
		$criteria->compare('about_detail',$this->about_detail,true);
		$criteria->compare('about_tel',$this->about_tel,true);
		$criteria->compare('about_email',$this->about_email,true);
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
		$criteria->order = 'about_id';
		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return About the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
