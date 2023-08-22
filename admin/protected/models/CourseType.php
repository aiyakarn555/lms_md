<?php

/**
 * This is the model class for table "{{course_type}}".
 *
 * The followings are the available columns in table '{{course_type}}':
 * @property integer $type_id
 * @property integer $sortOrder
 * @property string $type_name
 * @property integer $status
 * @property integer $lang_id
 * @property integer $parent_id
 * @property string $active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class CourseType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{course_type}}';
	}

	public function beforeSave() 
	{
		if($this->isNewRecord) {
			$this->created_by = Yii::app()->user->id;
			$this->created_date = date("Y-m-d H:i:s");
		} else {
			$this->updated_by = Yii::app()->user->id;
			$this->updated_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sortOrder, status, lang_id, parent_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('type_name', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('type_id, sortOrder, type_name, status, lang_id, parent_id, active, created_by, created_date, updated_by, updated_date', 'safe', 'on'=>'search'),
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
			'type_id' => 'Type',
			'sortOrder' => 'ลำดับ',
			'type_name' => 'ประเภทหลักสูตร',
			'status' => 'สถานะโชว์',
			'lang_id' => 'Lang',
			'parent_id' => 'Parent',
			'active' => 'Active',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'updated_by' => 'Updated By',
			'updated_date' => 'Updated Date',
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

		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('sortOrder',$this->sortOrder);
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',0);
		$criteria->compare('active','y',true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->order = 'sortOrder ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CourseType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
