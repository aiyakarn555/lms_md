<?php

/**
 * This is the model class for table "cms_faq_type".
 *
 * The followings are the available columns in table 'cms_faq_type':
 * @property integer $faq_type_id
 * @property string $faq_type_title_TH
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FaqType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_faq_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('faq_type_title_TH', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date,lang_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faq_type_id, faq_type_title_TH, create_date, create_by, update_date, update_by, active,lang_id, sortOrder', 'safe', 'on'=>'search'),
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
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by')
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
			'faq_type_id' => 'Faq Type',
			'faq_type_title_TH' => 'หมวดคำถาม'.$label_lang,
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'active' => 'สถานะ',
			'lang_id' => 'ภาษา',
			'sortOrder' => 'เรียงลำดับ',
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

		$criteria->compare('faq_type_id',$this->faq_type_id);
		$criteria->compare('faq_type_title_TH',$this->faq_type_title_TH,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',1);

	    $criteria->order = 'sortOrder ASC';

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
	 * @return FaqType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		$this->faq_type_title_TH = CHtml::encode($this->faq_type_title_TH);

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
		$this->faq_type_title_TH = CHtml::decode($this->faq_type_title_TH);

		return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'faqtype',
				'order' => ' faqtype.faq_type_id DESC ',
				'condition' => ' faqtype.active = "y" ',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'faqtype',
				'order' => ' faqtype.faq_type_id DESC ',
			);
		}

		return $checkScopes;
	}

	public function scopes()
	{
		//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("FaqType.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array(
				'faqtypecheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'faqtypecheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'faqtypecheck'=>array(
							'alias' => 'faqtype',
							'condition' => ' faqtype.active = "y" ',
							'order' => ' faqtype.faq_type_id DESC ',
						),
					);
				}else{
					$scopes = array(
						'faqtypecheck'=>array(
							'alias' => 'faqtype',
							'condition' => '  faqtype.create_by = "'.Yii::app()->user->id.'" AND faqtype.active = "y" ',
							'order' => ' faqtype.faq_type_id DESC ',
						),
					);
				}
				
				// $scopes = array(
				// 	'faqtypecheck'=>array(
				// 		'alias' => 'faqtype',
				// 		'condition' => ' faqtype.active = "y" ',
				// 		'order' => ' faqtype.faq_type_id DESC ',
				// 	),
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
		return $this->faq_type_id;
	}
}
