<?php

/**
 * This is the model class for table "problem_type".
 *
 * The followings are the available columns in table 'problem_type':
 * @property integer $id
 * @property string $Problem_id
 * @property string $Problem_name
 * @property string $create_date
 * @property string $active
 */
class ProblemType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'problem_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('Problem_id, Problem_name', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date,lang_id,parent_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Problem_id, Problem_name, create_date, active,lang_id,parent_id', 'safe', 'on'=>'search'),
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
			'Problem_id' => 'Problem',
			'Problem_name' => 'Problem Name',
			'create_date' => 'Create Date',
			'active' => 'Active',
			'lang_id'=>'ภาษา'
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
		$criteria->compare('Problem_id',$this->Problem_id,true);
		$criteria->compare('Problem_name',$this->Problem_name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('parent_id',0);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProblemType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
