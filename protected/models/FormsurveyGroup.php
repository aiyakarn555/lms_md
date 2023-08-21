<?php

/**
 * This is the model class for table "{{formsurvey_group}}".
 *
 * The followings are the available columns in table '{{formsurvey_group}}':
 * @property integer $fg_id
 * @property string $fg_title
 * @property integer $lesson_id
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class FormsurveyGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveyGroup the static model class
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
		return '{{formsurvey_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lesson_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('fg_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fg_id, fg_title, lesson_id, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'fg_id' => 'Fg',
			'fg_title' => 'กลุ่มแบบสอบถาม',
			'lesson_id' => 'Lesson',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
		);
	}

    public function defaultScope()
    {

        return array(
            'alias' => __CLASS__,
            'condition' => __CLASS__.".active = 'y'",
        );

    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('fg_id',$this->fg_id);
		$criteria->compare('fg_title',$this->fg_title,true);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->addCondition('lesson_id ="'.$id.'"');
        $criteria->addCondition('lesson_id =\'\'','OR');
        $criteria->addCondition('lesson_id IS NULL','OR');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}