<?php

/**
 * This is the model class for table "{{formsurvey_header}}".
 *
 * The followings are the available columns in table '{{formsurvey_header}}':
 * @property string $fsh_id
 * @property integer $fs_id
 * @property string $fsh_type
 * @property string $fsh_title
 */
class FormsurveyHeader extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveyHeader the static model class
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
		return '{{formsurvey_header}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fs_id', 'numerical', 'integerOnly'=>true),
			array('fsh_type, fsh_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fsh_id, fs_id, fsh_type, fsh_title', 'safe', 'on'=>'search'),
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
			'FormSurveyList' => array(self::HAS_MANY, 'FormSurveyList','fsh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fsh_id' => 'Fsh',
			'fs_id' => 'Fs',
			'fsh_type' => 'Fsh Type',
			'fsh_title' => 'Fsh Title',
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

		$criteria->compare('fsh_id',$this->fsh_id,true);
		$criteria->compare('fs_id',$this->fs_id);
		$criteria->compare('fsh_type',$this->fsh_type,true);
		$criteria->compare('fsh_title',$this->fsh_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}