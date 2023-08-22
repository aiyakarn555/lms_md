<?php

/**
 * This is the model class for table "cms_faq".
 *
 * The followings are the available columns in table 'cms_faq':
 * @property integer $faq_nid_
 * @property string $faq_THtopic
 * @property string $faq_THanswer
 * @property integer $faq_type_id
 * @property integer $faq_hideStatus
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $sortOrder
 */
class Faq extends CActiveRecord
{
	public $news_per_page;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faq_type_id', 'required'),
			array('faq_type_id, faq_hideStatus, create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('faq_THtopic', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('faq_THanswer, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faq_nid_, faq_THtopic, faq_THanswer, faq_type_id, faq_hideStatus, create_date, create_by, update_date, update_by, active, sortOrder, news_per_page', 'safe', 'on'=>'search'),
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
			'faq_type' => array(self::BELONGS_TO, 'FaqType', 'faq_type_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$this->lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
		$lang = Language::model()->findByPk($this->lang_id);
		$mainLang = $lang->language;
		$label_lang = ' (ภาษา '.$mainLang.' )';
		return array(
			'faq_nid_' => 'Faq Nid',
			'faq_THtopic' => 'คำถาม'.$label_lang,
			'faq_THanswer' => 'คำตอบ'.$label_lang,
			'faq_type_id' => 'หมวดคำถาม',
			'faq_hideStatus' => 'Faq Hide Status',
			'create_date' => 'วันที่เพิ่มข้อมูล'.$label_lang,
			'create_by' => 'ผู้เพิ่มข้อมูล'.$label_lang,
			'update_date' => 'วันที่แก้ไขข้อมูล'.$label_lang,
			'update_by' => 'ผู้แก้ไขข้อมูล'.$label_lang,
			'active' => 'สถานะ',
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
		$criteria->compare('faq_nid_',$this->faq_nid_);
		$criteria->compare('faq_THtopic',$this->faq_THtopic,true);
		$criteria->compare('faq_THanswer',$this->faq_THanswer,true);
		$criteria->compare('faq_type_id',$this->faq_type_id);
		$criteria->compare('faq_hideStatus',$this->faq_hideStatus);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id','0');
		$criteria->order = 'sortOrder ASC';

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}

		// $t = new CActiveDataProvider($this, $poviderArray);
		// echo "<pre>";var_dump($t->getData());exit();

		return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		$this->faq_THtopic = CHtml::encode($this->faq_THtopic);
		$this->faq_THanswer = CHtml::encode($this->faq_THanswer);
		$this->faq_type_id = CHtml::encode($this->faq_type_id);

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
		$this->faq_THtopic = CHtml::decode($this->faq_THtopic);
		$this->faq_THanswer = CHtml::decode($this->faq_THanswer);
		$this->faq_type_id = CHtml::encode($this->faq_type_id);

		return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'faq',
				'order' => ' faq.faq_nid_ DESC ',
				'condition' => ' faq.active = "y" ',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'faq',
				'order' => ' faq.faq_nid_ DESC ',
			);
		}

		return $checkScopes;
	}

	public function scopes()
	{
		//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("Faq.*") );
		$user = User::model()->findByPk(Yii::app()->user->id);
		$state = Helpers::lib()->getStatePermission($user);

		if($Access == true)
		{
			$scopes =  array(
				'faqcheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'faqcheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
				if($state){
					$scopes = array(
						'faqcheck'=>array(
							'alias' => 'faq',
							'condition' => ' faq.active = "y" ',
							'order' => ' faq.faq_nid_ DESC ',
						),
					);
				}else{
					$scopes = array(
						'faqcheck'=>array(
							'alias' => 'faq',
							'condition' => '  faq.create_by = "'.Yii::app()->user->id.'" AND faq.active = "y" ',
							'order' => ' faq.faq_nid_ DESC ',
						),
					);
				}
				
				// $scopes = array(
				// 	'faqcheck'=>array(
				// 		'alias' => 'faq',
				// 		'condition' => ' faq.active = "y" ',
				// 		'order' => ' faq.faq_nid_ DESC ',
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
		return $this->faq_nid_;
	}
}
