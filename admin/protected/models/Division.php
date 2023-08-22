<?php

/**
 * This is the model class for table "{{division}}".
 *
 * The followings are the available columns in table '{{division}}':
 * @property integer $id
 * @property integer $company_id
 * @property string $div_title
 * @property string $create_date
 * @property string $active
 */
class Division extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{division}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('div_title, active', 'length', 'max'=>255),
			array('create_date,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, div_title, create_date, active,lang_id,parent_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'company_id' => 'ฝ่าย',
			'div_title' => 'ชื่อกอง'.$label_lang,
			'create_date' => 'Create Date'.$label_lang,
			'active' => 'Active',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('div_title',$this->div_title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('lang_id',1);
		$criteria->compare('active',y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Division the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDivisionList($company_id = null){
		$strSql = $company_id != null ? ' AND company_id='.$company_id : '';
		$model = Division::model()->findAll('active = "y"'.$strSql);
		$list = CHtml::listData($model,'id','div_title');
		return $list;
	}

	public function getDivisionListNew(){
		$model = Division::model()->findAll('active = "y" AND lang_id = 1 ');
		$list = CHtml::listData($model,'id','div_title');
		return $list;
	}
}
