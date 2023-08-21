<?php

/**
 * This is the model class for table "{{library_type}}".
 *
 * The followings are the available columns in table '{{library_type}}':
 * @property integer $library_type_id
 * @property integer $sortOrder
 * @property string $library_type_name
 * @property string $library_type_name_en
 * @property string $library_type
 * @property string $active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class LibraryType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{library_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sortOrder, created_by, updated_by, library_cate', 'numerical', 'integerOnly'=>true),
			array('library_type_name, library_type_name_en, library_type', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date, library_cate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('library_type_id, sortOrder, library_type_name, library_type_name_en, library_type, active, created_by, created_date, updated_by, updated_date, library_cate', 'safe', 'on'=>'search'),
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
			'library_type_id' => 'Library Type',
			'sortOrder' => 'Sort Order',
			'library_type_name' => 'Library Type Name',
			'library_type_name_en' => 'Library Type Name En',
			'library_type' => 'Library Type',
			'active' => 'Active',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'updated_by' => 'Updated By',
			'updated_date' => 'Updated Date',
			'library_cate' => 'library_cate',
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

		$criteria->compare('library_type_id',$this->library_type_id);
		$criteria->compare('sortOrder',$this->sortOrder);
		$criteria->compare('library_type_name',$this->library_type_name,true);
		$criteria->compare('library_type_name_en',$this->library_type_name_en,true);
		$criteria->compare('library_type',$this->library_type,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);
		$criteria->compare('library_cate',$this->library_cate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
