<?php

/**
 * This is the model class for table "{{usability}}".
 *
 * The followings are the available columns in table '{{usability}}':
 * @property integer $usa_id
 * @property string $usa_title
 * @property string $usa_detail
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Usability extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{usability}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('usa_title, usa_address', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('usa_detail, create_date, update_date, parent_id, lang_id,usaMutiLang', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('usa_id, usa_title, usa_detail, create_date, create_by, update_date, update_by, active, sortOrder', 'safe', 'on'=>'search'),
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
			'usa_id' => 'Usa',
			'usa_title' => 'Usa Title',
			'usa_detail' => 'Usa Detail',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
			'usaMutiLang' => 'หัวข้อวิธีการใช้งานภาษาอื่น',
			'sortOrder'=>'ย้ายตำแหน่ง',
			'usa_address' => 'รูปภาพหน้าปก'
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

		$criteria->compare('usa_id',$this->usa_id);
		$criteria->compare('usa_title',$this->usa_title,true);
		$criteria->compare('usa_detail',$this->usa_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->order = 'usa_id';
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usability the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
