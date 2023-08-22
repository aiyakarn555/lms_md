<?php

class Conditions extends AActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{conditions}}';
	}

	public function rules()
	{
		return array(
			array('conditions_title , conditions_detail', 'required'),

			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('conditions_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('conditions_detail, create_date, update_date,parent_id, lang_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('conditions_id, conditions_title, conditions_detail, create_date, create_by, update_date, update_by, active,parent_id, lang_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by'),
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
			'conditions_id' => 'รหัส',
			'conditions_title' => 'หัวข้อเงื่อนไขการใช้งาน'.$label_lang,
			'conditions_detail' => 'รายละเอียดเงื่อนไขการใช้งาน'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'สถานะ'.$label_lang,
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('conditions_id',$this->conditions_id);
		$criteria->compare('conditions_title',$this->conditions_title,true);
		$criteria->compare('conditions_detail',$this->conditions_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0);

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
		$this->conditions_title 		= CHtml::encode($this->conditions_title);
		$this->conditions_detail 	= CHtml::encode($this->conditions_detail);

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
		$this->conditions_title 		= CHtml::decode($this->conditions_title);
		$this->conditions_detail 	= CHtml::decode($this->conditions_detail);

			return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'conditions',
				'order' => ' conditions.conditions_id DESC ',
				'condition' => ' conditions.active = "y" ',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'conditions',
				'order' => ' conditions.conditions_id DESC ',
			);
		}

	return $checkScopes;
	}

	public function scopes()
		{
			//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Conditions.*") );
		if($Access == true)
		{
			$scopes =  array(
				'conditionscheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'conditionscheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
					// $scopes = array(
					// 			'conditionscheck'=>array(
					// 		'alias' => 'conditions',
					// 		'condition' => '  conditions.create_by = "'.Yii::app()->user->id.'" AND conditions.active = "y" ',
					// 		'order' => ' conditions.conditions_id DESC ',
					// 			),
					// );
					$scopes = array(
								'conditionscheck'=>array(
							'alias' => 'conditions',
							'condition' => ' conditions.active = "y" ',
							'order' => ' conditions.conditions_id DESC ',
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
		return $this->conditions_id;
	}
}
