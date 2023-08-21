<?php

/**
 * This is the model class for table "{{library_file}}".
 *
 * The followings are the available columns in table '{{library_file}}':
 * @property integer $library_id
 * @property integer $sortOrder
 * @property integer $library_type_id
 * @property string $library_name
 * @property string $library_name_en
 * @property string $library_filename
 * @property string $active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 */
class LibraryFile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{library_file}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sortOrder, library_type_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('library_name, library_name_en, library_filename', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('library_id, sortOrder, library_type_id, library_name, library_name_en, library_filename, active, created_by, created_date, updated_by, updated_date', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'LibraryType', 'library_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'library_id' => 'Library',
			'sortOrder' => 'Sort Order',
			'library_type_id' => 'Library Type',
			'library_name' => 'Library Name',
			'library_name_en' => 'Library Name En',
			'library_filename' => 'Library Filename',
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

		$criteria->compare('library_id',$this->library_id);
		$criteria->compare('sortOrder',$this->sortOrder);
		$criteria->compare('library_type_id',$this->library_type_id);
		$criteria->compare('library_name',$this->library_name,true);
		$criteria->compare('library_name_en',$this->library_name_en,true);
		$criteria->compare('library_filename',$this->library_filename,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('updated_date',$this->updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LibraryFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
