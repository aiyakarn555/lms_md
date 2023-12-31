<?php

/**
 * This is the model class for table "{{division}}".
 *
 * The followings are the available columns in table '{{division}}':
 * @property integer $id
 * @property string $div_title
 * @property string $dep_code
 * @property string $create_date
 */
class TblDivision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblDivision the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

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
			array('company_id,div_title','required'),
			array('div_title', 'length', 'max'=>255),
			array('create_date,company_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,company_id, div_title, create_date', 'safe', 'on'=>'search'),
		);
	}


	public function beforeSave()
	{
		$this->create_date=new CDbExpression('NOW()');
		return true;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'company' => array(self::BELONGS_TO, 'TblCompany', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'หน่วยงาน',
			'div_title' => 'ชื่อศูนย์/แผนก',
			'create_date' => 'Create Date',
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

		$criteria->with = array('company');
		$criteria->compare('id',$this->id);
		$criteria->compare('company.company_title',$this->company_id,true);
		$criteria->compare('div_title',$this->div_title,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}