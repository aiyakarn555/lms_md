<?php

/**
 * This is the model class for table "{{vdo}}".
 *
 * The followings are the available columns in table '{{vdo}}':
 * @property integer $vdo_id
 * @property string $vdo_title
 * @property string $vdo_path
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Vdo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vdo the static model class
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
		return '{{vdo}}';
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
			array('vdo_title, vdo_path, vdo_credit', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, news_per_page, parent_id, lang_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vdo_id, vdo_title, vdo_path, create_date, create_by, update_date, update_by, active, parent_id,lang_id, sortOrder, vdo_credit', 'safe', 'on'=>'search'),
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

    public function afterFind() 
    {
    	$this->vdo_title = CHtml::decode($this->vdo_title);
    	$this->vdo_path = CHtml::decode($this->vdo_path);
    	
        return parent::afterFind();
    }
    
	public function defaultScope()
	{
	    return array(
	    	'order' => 'vdo_id ASC',
	    	'condition' => ' active = "y" ',
	    );
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'vdo_id' => 'Vdo',
			'vdo_title' => 'Vdo Title',
			'vdo_path' => 'Vdo Path',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'sortOrder'=> 'ย้ายตำแหน่ง',
			'vdo_credit'=>'vdo_credit'
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

		$criteria->compare('vdo_id',$this->vdo_id);
		$criteria->compare('vdo_title',$this->vdo_title,true);
		$criteria->compare('vdo_path',$this->vdo_path,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('vdo_credit',$this->vdo_credit,true);
		$criteria->compare('parent_id',0);

		$criteria->order = 'sortOrder ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}