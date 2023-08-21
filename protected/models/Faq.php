<?php

/**
 * This is the model class for table "cms_faq".
 *
 * The followings are the available columns in table 'cms_faq':
 * @property integer $faq_nid_
 * @property string $faq_THtopic
 * @property string $faq_THanswer
 * @property integer $faq_type_id
 * @property integer $faq_hideStatus
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $sortOrder
 */
class Faq extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faq_type_id', 'required'),
			array('faq_type_id, faq_hideStatus, create_by, update_by, sortOrder', 'numerical', 'integerOnly'=>true),
			array('faq_THtopic', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('faq_THanswer, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faq_nid_, faq_THtopic, faq_THanswer, faq_type_id, faq_hideStatus, create_date, create_by, update_date, update_by, active, sortOrder', 'safe', 'on'=>'search'),
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
			'faq_type' => array(self::BELONGS_TO, 'FaqType', 'faq_type_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faq_nid_' => 'Faq Nid',
			'faq_THtopic' => 'Faq Thtopic',
			'faq_THanswer' => 'Faq Thanswer',
			'faq_type_id' => 'Faq Type',
			'faq_hideStatus' => 'Faq Hide Status',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'sortOrder' => 'Sort Order',
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

		$criteria->compare('faq_nid_',$this->faq_nid_);
		$criteria->compare('faq_THtopic',$this->faq_THtopic,true);
		$criteria->compare('faq_THanswer',$this->faq_THanswer,true);
		$criteria->compare('faq_type_id',$this->faq_type_id);
		$criteria->compare('faq_hideStatus',$this->faq_hideStatus);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('sortOrder',$this->sortOrder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
