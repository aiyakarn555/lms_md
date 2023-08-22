<?php

/**
 * This is the model class for table "{{learn_file}}".
 *
 * The followings are the available columns in table '{{learn_file}}':
 * @property integer $learn_file_id
 * @property integer $learn_id
 * @property integer $file_id
 * @property string $learn_file_date
 * @property string $learn_file_status
 */
class LearnFile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LearnFile the static model class
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
		return '{{learn_file}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('learn_id, file_id, learn_file_date', 'required'),
			array('learn_id, file_id', 'numerical', 'integerOnly'=>true),
			array('learn_file_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('learn_file_id, learn_id, file_id, learn_file_date, learn_file_status, gen_id', 'safe', 'on'=>'search'),
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
			'learnI' => array(self::BELONGS_TO, 'learn', 'learn_id','foreignKey' => array('learn_id'=>'learn_id')),
			'file' => array(self::BELONGS_TO, 'File', 'file_id','foreignKey' => array('file_id'=>'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'learn_file_id' => 'Learn File',
			'learn_id' => 'Learn',
			'file_id' => 'File',
			'learn_file_date' => 'Learn File Date',
			'learn_file_status' => 'Learn File Status',
			'gen_id' => 'gen_id',
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

		$criteria->compare('learn_file_id',$this->learn_file_id);
		$criteria->compare('learn_id',$this->learn_id);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('learn_file_date',$this->learn_file_date,true);
		$criteria->compare('learn_file_status',$this->learn_file_status,true);
		$criteria->compare('gen_id',$this->gen_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}