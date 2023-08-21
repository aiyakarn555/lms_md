<?php

class About extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{about}}';
	}

	public function rules()
	{
		return array(
			array('create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('about_title', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('about_detail, create_date, update_date, lang_id', 'safe'),
			array('about_id, about_title, about_detail, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'about_id' => 'About',
			'about_title' => 'About Title',
			'about_detail' => 'About Detail',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'lang_id' => 'ภาษา',
		);
	}



	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('about_id',$this->about_id);
		$criteria->compare('about_title',$this->about_title,true);
		$criteria->compare('about_detail',$this->about_detail,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('lang_id',$this->lang_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind() 
    {
    	$this->about_title 		= CHtml::decode($this->about_title);
    	$this->about_detail 	= CHtml::decode($this->about_detail);

        return parent::afterFind();
    }

	public function defaultScope()
	{
		return array(
			'alias' => 'about',
			'order' => ' about.about_id DESC ',
			'condition' => ' about.active = "y" ',
		);	
	}
}