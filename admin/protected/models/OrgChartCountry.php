<?php

/**
 * This is the model class for table "{{orgchart_country}}".
 *
 * The followings are the available columns in table '{{orgchart_country}}':
 * @property integer $id
 * @property integer $sortOrder
 * @property string $title
 * @property string $code
 * @property integer $parent_id
 * @property integer $level
 * @property string $active
 * @property integer $country_id
 * @property integer $company_id
 * @property integer $department_id
 * @property integer $division_id
 * @property integer $section_id
 * @property integer $team_id
 */
class OrgChartCountry extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orgchart_country}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sortOrder, parent_id, level, country_id, company_id, department_id, division_id, section_id, team_id', 'numerical', 'integerOnly'=>true),
			array('title, code', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sortOrder, title, code, parent_id, level, active, country_id, company_id, department_id, division_id, section_id, team_id', 'safe', 'on'=>'search'),
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
		return array(
			'id' => 'ID',
			'sortOrder' => 'Sort Order',
			'title' => 'Title',
			'code' => 'Code',
			'parent_id' => 'Parent',
			'level' => 'Level',
			'active' => 'Active',
			'country_id' => 'Country',
			'company_id' => 'Company',
			'department_id' => 'Department',
			'division_id' => 'Division',
			'section_id' => 'Section',
			'team_id' => 'Team',
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
		$criteria->compare('sortOrder',$this->sortOrder);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('division_id',$this->division_id);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('team_id',$this->team_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrgchartCountry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
