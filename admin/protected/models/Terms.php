<?php

/**
 * This is the model class for table "{{terms}}".
 *
 * The followings are the available columns in table '{{terms}}':
 * @property integer $terms_id
 * @property string $terms_title
 * @property string $terms_detail
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $lang_id
 * @property integer $parent_id
 */
class Terms extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{terms}}';
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
			array('terms_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('terms_detail, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('terms_id, terms_title, terms_detail, create_date, create_by, update_date, update_by, active, lang_id, parent_id', 'safe', 'on'=>'search'),
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
			'terms_id' => 'Terms',
			'terms_title' => 'Terms Title'.$label_lang,
			'terms_detail' => 'Terms Detail'.$label_lang,
			'create_date' => 'Create Date'.$label_lang,
			'create_by' => 'Create By'.$label_lang,
			'update_date' => 'Update Date'.$label_lang,
			'update_by' => 'Update By',
			'active' => 'Active'.$label_lang,
			'lang_id' => 'Lang',
			'parent_id' => 'Parent',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter terms.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter terms.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('terms_id',$this->terms_id);
		$criteria->compare('terms_title',$this->terms_title,true);
		$criteria->compare('terms_detail',$this->terms_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',0);

		$poviderArray = array('criteria'=>$criteria);

		// Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
        
        return new CActiveDataProvider($this, $poviderArray);
		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Terms the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		$this->terms_title 		= CHtml::encode($this->terms_title);
		$this->terms_detail 	= CHtml::encode($this->terms_detail);

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
		$this->terms_title 		= CHtml::decode($this->terms_title);
		$this->terms_detail 	= CHtml::decode($this->terms_detail);

			return parent::afterFind();
	}

	public function checkScopes($check = 'scopes')
	{
		if ($check == 'scopes')
		{
			$checkScopes =  array(
				'alias' => 'terms',
				'order' => ' terms.terms_id DESC ',
				'condition' => ' terms.active = "y" ',
			);
		}
		else
		{
			$checkScopes =  array(
				'alias' => 'terms',
				'order' => ' terms.terms_id DESC ',
			);
		}

	return $checkScopes;
	}

	public function scopes()
		{
			//========== SET Controller loadModel() ==========//

		$Access = Controller::SetAccess( array("terms.*") );
		if($Access == true)
		{
			$scopes =  array(
				'termscheck' => $this->checkScopes('scopes')
			);
		}
		else
		{
			if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
			{
				$scopes =  array(
					'termscheck' => $this->checkScopes('scopes')
				);
			}
			else
			{
					// $scopes = array(
					// 			'termscheck'=>array(
					// 		'alias' => 'terms',
					// 		'condition' => '  terms.create_by = "'.Yii::app()->user->id.'" AND terms.active = "y" ',
					// 		'order' => ' terms.terms_id DESC ',
					// 			),
					// );
					$scopes = array(
								'termscheck'=>array(
							'alias' => 'terms',
							'condition' => ' terms.active = "y" ',
							'order' => ' terms.terms_id DESC ',
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
		return $this->terms_id;
	}
}
