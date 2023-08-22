<?php

/**
 * This is the model class for table "{{orgchart}}".
 *
 * The followings are the available columns in table '{{orgchart}}':
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property integer $group_bu_id
 * @property integer $bu_id
 * @property integer $department_id
 * @property integer $division_id
 * @property integer $section_id
 * @property integer $sub_section_id
 * @property integer $country_id
 * @property integer $company_id
 * @property integer $department_country_id
 * @property integer $division_country_id
 * @property integer $section_country_id
 * @property integer $team_id
 * @property integer $level
 */
class OrgChart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orgchart}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('title', 'required'),
			array('parent_id, level', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, level ,active, group_bu_id, bu_id, department_id, division_id, section_id, sub_section_id,country_id, company_id, department_country_id, division_country_id, section_country_id, team_id, sortOrder', 'safe', 'on'=>'search'),
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
			'orgchart'=>array(self::BELONGS_TO, 'Orgchart', 'parent_id'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'parent_id' => 'Parent',
			'level' => 'Level',
			'active' => 'Active',
			'group_bu_id' => 'group_bu_id',
			'bu_id' => 'bu_id',
			'department_id' => 'department_id',
			'division_id' => 'division_id',
			'section_id' => 'section_id',
			'sub_section_id' => 'sub_section_id',
			'country_id' => 'country_id',
			'company_id' => 'company_id',
			'department_country_id' => 'department_country_id',
			'division_country_id' => 'division_country_id',
			'section_country_id' => 'section_country_id',
			'team_id' => 'team_id',
			'sortOrder' => 'sortOrder',

		);
	}
	public function defaultScope()
	{
	 	return array(
				// 'condition'=>"active='y'",
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('sortOrder',$this->sortOrder,true);



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orgchart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
