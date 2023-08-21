<?php

/**
 * This is the model class for table "{{grouptesting}}".
 *
 * The followings are the available columns in table '{{grouptesting}}':
 * @property integer $group_id
 * @property integer $lesson_id
 * @property string $group_title
 * @property integer $step_id
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 *
 * The followings are the available model relations:
 * @property Lesson $lesson
 * @property Manage[] $manages
 * @property Question[] $questions
 */
class Grouptesting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Grouptesting the static model class
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
		return '{{grouptesting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lesson_id, step_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('group_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, lesson_id, group_title, step_id, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'lesson' => array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
			'manages' => array(self::HAS_MANY, 'Manage', 'group_id'),
			'questions' => array(self::HAS_MANY, 'Question', 'group_id'),
		);
	}

	public function defaultScope(){
		return array(
			'alias'=>'grouptesting',
			'condition' => 'grouptesting.active = "y"'
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'lesson_id' => 'Lesson',
			'group_title' => 'Group Title',
			'step_id' => 'Step',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('group_title',$this->group_title,true);
		$criteria->compare('step_id',$this->step_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}